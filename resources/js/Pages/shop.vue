<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";
import Footer from "../Components/footer.vue";
import navbar from "../Components/navBar.vue";

// État des variables
const products = ref([]); // Tous les produits
const categories = ref([]); // Toutes les catégories
const selectedCategory = ref(0); // ID de la catégorie sélectionnée (0 = "All Products")
const sortOrder = ref(""); // Ordre de tri des produits
// Plage de prix pour les filtres
const minPrice = ref(0);
const maxPrice = ref(200);

// Affichage de la sidebar
const isSidebarOpen = ref(false);
const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
};

// Fetch des catégories depuis l'API
const fetchCategories = async () => {
    try {
        const response = await axios.get("http://127.0.0.1:8000/api/categories");
        console.log("Catégories récupérées :", response.data);

        // Construire les catégories avec un total global pour "All Products"
        categories.value = [
            { id: 0, name: "All Products", count: 0 }, // Catégorie par défaut
            ...response.data.map((category) => ({
                id: category.id,
                name: category.name,
                count: category.products_count || 0, // Ajoute un gestionnaire pour les produits
            })),
        ];

        // Mise à jour du total des produits pour "All Products"
        categories.value[0].count = response.data.reduce(
            (total, category) => total + (category.products_count || 0),
            0
        );
    } catch (error) {
        console.error("Erreur lors de la récupération des catégories :", error);
    }
};

// Fetch des produits depuis l'API
const fetchProducts = async () => {
    try {
        const response = await axios.get("http://127.0.0.1:8000/api/products");
        console.log("Produits récupérés :", response.data);
        products.value = response.data;
    } catch (error) {
        console.error("Erreur lors de la récupération des produits :", error);
    }
};

// Mapper les catégories à leurs noms respectifs pour chaque produit.
const mapCategoryNamesToProducts = () => {
    if (products.value.length && categories.value.length) {
        products.value.forEach((product) => {
            const category = categories.value.find((c) => c.id === product.category_id);
            product.category = category
                ? { id: category.id, name: category.name }
                : { id: product.category_id, name: "Inconnu" }; // Défaut si non trouvé
        });
    }
};

// Charger les données lorsqu'on monte le composant
onMounted(async () => {
    await fetchCategories(); // Charger les catégories
    await fetchProducts(); // Charger les produits
    mapCategoryNamesToProducts(); // Mapper les catégories aux produits
});

// Produits triés après filtrage
const sortedProducts = computed(() => {
    const sorted = [...filteredProducts.value]; // Clonage des produits filtrés pour tri
    switch (sortOrder.value) {
        case "price-low-to-high":
            sorted.sort((a, b) => a.price - b.price);
            break;
        case "price-high-to-low":
            sorted.sort((a, b) => b.price - a.price);
            break;
        case "latest":
            sorted.sort((a, b) => b.id - a.id);
            break;
    }
    return sorted;
});
// Produits filtrés
const filteredProducts = computed(() => {
    return products.value.filter((product) => {
        // Filtrage par catégorie (0 = "All Products" : tous les produits)
        const matchCategory =
            selectedCategory.value === 0 || product.category_id === selectedCategory.value;

        // Filtrage par plage de prix
        const matchPrice =
            (minPrice.value === 0 || product.price >= minPrice.value) &&
            (maxPrice.value === 0 || product.price <= maxPrice.value);

        // Retourner les produits correspondant aux deux critères
        return matchCategory && matchPrice;
    });
});

// Ajouter un produit au panier
const addToCart = async (product) => {
    try {
        const token = localStorage.getItem('auth_token');
        const response = await axios.post(
            '/api/cart/add',
            {
                product_id: product.id,
                name: product.name,
                price: product.price,
                quantity: 1,
            },
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            }
        );
        console.log('Produit ajouté :', response.data);
    } catch (error) {
        console.error('Erreur dans l’ajout au panier :', error.response?.data || error.message);
    }
};
</script>


<template>
    <navbar />
    <div class="min-h-screen bg-gray-100">
        <!-- Shop Content -->
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-4 gap-6 py-8">
            <!-- Bouton pour afficher ou masquer les catégories (Mobile) -->
            <button
                class="md:hidden fixed bottom-4 left-4 px-4 py-2 bg-blue-500 text-white text-lg rounded shadow-lg z-50"
                @click="toggleSidebar"
            >
                {{ isSidebarOpen ? "Hide Categories" : "Show Categories" }}
            </button>

            <!-- Sidebar (off-canvas) mobile -->
            <aside
                class="fixed top-0 left-0 w-64 h-full bg-white shadow-lg transform transition-transform duration-300 z-50"
                :class="{ '-translate-x-full': !isSidebarOpen, 'translate-x-0': isSidebarOpen }"
            >
                <!-- Header de la sidebar -->
                <div class="flex justify-between items-center p-4 border-b bg-blue-500 text-white">
                    <h2 class="text-xl font-semibold">Categories</h2>
                    <button @click="toggleSidebar" class="text-xl">✕</button>
                </div>
                <!-- Liste des catégories -->
                <ul class="p-4">
                    <li
                        v-for="category in categories"
                        :key="category.id"
                        class="flex justify-between items-center border-b py-2 hover:bg-gray-100 cursor-pointer"
                        :class="{ 'font-bold': selectedCategory === category.id }"
                        @click="() => { selectedCategory = category.id; toggleSidebar(); }"
                    >
                        <span>{{ category.name }}</span>
                        <span class="text-sm text-gray-500">({{ category.count }})</span>
                    </li>
                </ul>
                <!-- Price Range Filter -->
                <div class="p-4 border-t">
                    <h3 class="text-lg font-semibold mb-3">Price Filter</h3>
                    <!-- Min Price -->
                    <label for="minPrice" class="block text-sm text-gray-500">Min Price</label>
                    <input
                        id="minPrice"
                        type="number"
                        v-model="minPrice"
                        class="w-full border rounded py-2 px-3 mb-3"
                    />

                    <!-- Max Price -->
                    <label for="maxPrice" class="block text-sm text-gray-500">Max Price</label>
                    <input
                        id="maxPrice"
                        type="number"
                        v-model="maxPrice"
                        class="w-full border rounded py-2 px-3"
                    />
                </div>
            </aside>

            <!-- Sidebar desktop (visible uniquement sur grand écran) -->
            <aside class="hidden md:block bg-white p-4 shadow rounded">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Categories</h2>
                <ul>
                    <li
                        v-for="category in categories"
                        :key="category.id"
                        class="flex items-center justify-between border-b py-2  hover:bg-gray-100 cursor-pointer"
                        :class="{ 'font-bold': selectedCategory === category.id }"
                        @click="selectedCategory = category.id"
                    >
                        <span class="text-gray-600">{{ category.name }}</span>
                        <span class="text-sm text-gray-500">({{ category.count }})</span>
                    </li>
                </ul>
                <!-- Price Range Filter -->
                <div class="mt-6">
                    <h3 class="text-lg font-semibold mb-3">Price Filter</h3>
                    <!-- Min Price -->
                    <label for="minPriceDesktop" class="block text-sm text-gray-500">Min Price</label>
                    <input
                        id="minPriceDesktop"
                        type="number"
                        v-model="minPrice"
                        class="w-full border rounded py-2 px-3 mb-3"
                    />

                    <!-- Max Price -->
                    <label for="maxPriceDesktop" class="block text-sm text-gray-500">Max Price</label>
                    <input
                        id="maxPriceDesktop"
                        type="number"
                        v-model="maxPrice"
                        class="w-full border rounded py-2 px-3"
                    />
                </div>
            </aside>

            <!-- Main Section: Product List -->
            <main class="col-span-1 md:col-span-3 min-h-screen py-10 px-4 md:px-10">
                <!-- Handle Empty State -->
                <p class="mb-4 text-gray-500" v-if="!sortedProducts.length">No products found.</p>
                <div class="mb-4">
                    <select
                        v-model="sortOrder"
                        class="bg-white border border-gray-300 text-gray-600 px-4 py-2 rounded shadow-sm text-sm focus:ring-primary focus:border-primary"
                    >
                        <option value="">Default Sorting</option>
                        <option value="price-low-to-high">Price Low to High</option>
                        <option value="price-high-to-low">Price High to Low</option>
                        <option value="latest">Latest</option>
                    </select>
                </div>
                <!-- Product Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6" v-if="sortedProducts.length">
                    <div
                        v-for="product in sortedProducts"
                        :key="product.id"
                        class="bg-white shadow-md rounded overflow-hidden group cursor-pointer transform transition duration-300 hover:-translate-y-2 hover:shadow-lg"
                    >
                        <!-- Product Link with Hover Effect -->
                        <a :href="`/product/${product.id}`" class="group">
                            <div class="relative">
                                <img
                                    :src="`http://127.0.0.1:8000/${product.image}`"
                                    :alt="product.name"
                                    class="w-full h-70 object-cover transition-opacity duration-300 group-hover:opacity-0"
                                />
                                <img
                                    :src="`http://127.0.0.1:8000/${product.hover_image}`"
                                    :alt="product.name"
                                    class="absolute inset-0 w-full h-70 object-cover transition-opacity duration-300 opacity-0 group-hover:opacity-100"
                                />
                            </div>


                            <!-- Product Details -->
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    {{ product.name }}
                                </h3>
                                <div class="flex items-center justify-between mt-2">
                                    <p class="text-primary text-xl font-bold">{{ product.price }} DT</p>
                                    <p class="text-gray-400 line-through" v-if="product.old_price">
                                        {{ product.old_price }} DT
                                    </p>
                                </div>
                            </div>
                        </a>

                        <!-- Add to Cart Button -->
                        <div class="p-4">
                            <button
                                @click="addToCart(product)"
                                class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 text-sm font-medium shadow-sm"
                            >
                                Ajouter au panier
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <Footer/>
    </div>

</template>

<style scoped>
</style>

