<script setup>
import Footer from "../components/footer.vue";
import navbar from "../components/navBar.vue";
import { ref, onMounted } from "vue";
import axios from "axios";


const product = ref(null); // Stocke les détails du produit
const error = ref(null); // Stocke les erreurs éventuelles
const mainImage = ref(null); // Stocke l'image affichée
const selectedSize = ref(null); // Taille sélectionnée par l'utilisateur
;
const relatedProducts = ref([]); // Stocke les produits similaires
// Fonction pour récupérer l'ID produit depuis Laravel
function getProductIdFromURL() {
    // Extraire le chemin actuel
    const path = window.location.pathname;

    // Utiliser une expression régulière pour capturer l'ID depuis l'URL
    const match = path.match(/\/product\/(\d+)/);

    return match ? match[1] : null; // Retourne l'ID ou null s'il n'est pas trouvé
}

const productId = getProductIdFromURL();

if (!productId) {
    console.error("ID de produit introuvable dans l'URL.");
    alert("Produit introuvable !");
}

console.log("ID produit extrait de l'URL :", productId);

// Fonction pour chercher les détails du produit
async function fetchProduct() {
    if (!productId) {
        console.error("Invalid Product ID:", productId);
        error.value = "ID produit manquant ou non valide.";
        return; // Arrête si productId est invalide
    }

    try {
        // Appel API pour récupérer le produit
        const response = await axios.get(`/api/product/${productId}`);
        // Transformation des données reçues pour les rendre compatibles avec le format attendu
        const rawData = response.data;

        product.value = {
            ...rawData, // Garde les données de base
            sizes: rawData.size ? rawData.size.split(", ") : [], // Transforme "size" (chaîne de caractères) en tableau
            oldPrice: rawData.old_price, // Renomme "old_price" en "oldPrice"
            images: [
                `http://127.0.0.1:8000/${rawData.image}`,
                `http://127.0.0.1:8000/${rawData.hover_image}`
            ].filter(Boolean),  // Intègre les images dans un tableau
        };

        // Définit l'image principale comme la première image
        mainImage.value = product.value.images.length > 0 ? product.value.images[0] : null;
        console.log(product.value.images);

    } catch (err) {
        console.error("Error fetching product:", err);
        error.value = "Impossible de charger les détails du produit.";
    }
}

// Fonction pour ajouter au panier

axios.defaults.baseURL = 'http://127.0.0.1:8000';
axios.defaults.withCredentials = true;

// Add to cart
const addToCart = async (product) => {
    try {
        const token = localStorage.getItem("auth_token");
        await axios.post(
            "/api/cart/add",
            {
                product_id: product.id,
                name: product.name,
                price: product.price,
                quantity: 1,
                size: selectedSize.value,
            },
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            }
        );
        alert("Product added to cart!");
    } catch (error) {
        console.error("Error adding to cart:", error.response?.data || error.message);
        alert("Failed to add product to cart.");
    }
};

// Fonction pour chercher les produits similaires
async function fetchRelatedProducts() {
    try {
        const response = await axios.get(`/api/product/${productId}/related`);
        relatedProducts.value = response.data; // On suppose que l'API renvoie un tableau de produits similaires
    } catch (err) {
        console.error("Error fetching related products:", err);
    }
}

// Montée du composant : lancer l'appel API
onMounted(() => {
    fetchProduct();
    fetchRelatedProducts();
});
</script>

<template>
    <navbar />
    <!-- Affichage du produit -->
    <div v-if="product" class="min-h-screen bg-gray-100 py-8">
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Galerie d'images -->
            <div>
                <div class="relative">
                    <img
                        :src="mainImage"
                        :alt="product.name"
                        class="w-full  object-cover rounded-lg"
                    />
                </div>

                <!-- Miniatures -->
                <div class="flex space-x-4 mt-4">
                    <img
                        v-for="(image, index) in product.images"
                        :key="index"
                        :src="image"
                        :alt="`${product.name} Image ${index + 1}`"
                        class="w-[140PX] h-[140PX] object-cover rounded cursor-pointer hover:ring-2 hover:ring-blue-500"
                        @click="mainImage = image"
                    />
                </div>
            </div>

            <!-- Détails du produit -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h1 class="text-2xl font-semibold text-gray-800">{{ product.name }}</h1>
                <div class="mt-4">
                    <p class="text-primary text-2xl font-bold">{{ product.price }}DT</p>
                    <p class="text-gray-400 text-sm line-through" v-if="product.oldPrice">
                        {{ product.oldPrice }}DT
                    </p>
                </div>
                <p class="text-gray-600 mt-6 leading-6">{{ product.description }}</p>

                <!-- Sélection de taille -->
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-800">Taille :</h3>
                    <div class="flex space-x-4 mt-2">
                        <button
                            v-for="size in product.sizes"
                            :key="size"
                            :class="[
                'px-4 py-2 rounded text-sm',
                size === selectedSize ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
            ]"
                            @click="selectedSize = size">
                            {{ size }}
                        </button>
                    </div>
                    <!-- Show selected size -->
                    <p v-if="selectedSize" class="mt-4 text-gray-800">Taille sélectionnée : {{ selectedSize }}</p>
                </div>

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

        <div v-if="relatedProducts.length" class="mt-12 bg-gray-300 py-8">
            <div class="container mx-auto">
                <h2 class="text-center text-3xl font-bold text-gray-800 mb-6">You may also like</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <!-- Product Card -->
                    <div
                        v-for="product in relatedProducts"
                        :key="product.id"
                        class="bg-white shadow-md rounded overflow-hidden group cursor-pointer transform transition duration-300 hover:-translate-y-2 hover:shadow-lg"
                    >
                        <a :href="`/product/${product.id}`" class="group">
                            <div class="relative">
                                <!-- Main Image -->
                                <img
                                    :src="`http://127.0.0.1:8000/${product.image}`"
                                    :alt="product.name"
                                    class="w-full h-[300px] object-cover transition-all duration-500 group-hover:opacity-0"
                                />
                                <!-- Hover Image -->
                                <img
                                    :src="`http://127.0.0.1:8000/${product.hover_image}`"
                                    :alt="product.name"
                                    class="absolute inset-0 w-full h-[300px] object-cover transition-opacity duration-500 opacity-0 group-hover:opacity-100"
                                />
                            </div>
                            <div class="p-4">
                                <h3 class="text-sm font-semibold text-gray-800 group-hover:text-blue-600 transition">
                                    {{ product.name }}
                                </h3>
                                <div class="flex items-center justify-between mt-2">
                                    <p class="text-primary text-lg font-bold">{{ product.price }}DT</p>
                                    <p
                                        v-if="product.old_price"
                                        class="text-gray-400 text-sm line-through"
                                    >
                                        {{ product.old_price }}DT
                                    </p>
                                </div>
                            </div>
                        </a>
                        <!-- Add to Cart Button -->
                        <div class="p-4">
                            <button
                                class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 text-sm font-medium shadow-sm"
                            >
                                Ajouter au panier
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <Footer/>
</template>

<style scoped>
.hover\:ring-blue-500:hover {
    --tw-ring-color: #2563eb;
}
</style>
