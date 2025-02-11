<script setup>
import Swal from 'sweetalert2';
import Footer from "../components/footer.vue";
import navbar from "../components/navBar.vue";
import { ref, onMounted } from "vue";
import axios from "axios";

const product = ref(null);
const error = ref(null);
const mainImage = ref(null);
const selectedSize = ref(null);
const relatedProducts = ref([]);
const quantity = ref(1);

function getProductIdFromURL() {
    const path = window.location.pathname;
    const match = path.match(/\/product\/(\d+)/);
    return match ? match[1] : null;
}

const productId = getProductIdFromURL();

if (!productId) {
    console.error("ID de produit introuvable dans l'URL.");
    alert("Produit introuvable !");
}

console.log("ID produit extrait de l'URL :", productId);

async function fetchProduct() {
    if (!productId) {
        console.error("Invalid Product ID:", productId);
        error.value = "ID produit manquant ou non valide.";
        return;
    }

    try {
        const response = await axios.get(`/api/product/${productId}`);
        const rawData = response.data;

        product.value = {
            ...rawData,
            sizes: rawData.size ? rawData.size.split(", ") : [],
            oldPrice: rawData.old_price,
            images: [
                `http://127.0.0.1:8000/${rawData.image}`,
                `http://127.0.0.1:8000/${rawData.hover_image}`
            ].filter(Boolean),
        };

        mainImage.value = product.value.images.length > 0 ? product.value.images[0] : null;
        console.log(product.value.images);

    } catch (err) {
        console.error("Error fetching product:", err);
        error.value = "Impossible de charger les détails du produit.";
    }
}

async function fetchRelatedProducts() {
    try {
        const response = await axios.get(`/api/product/${productId}/related`);
        relatedProducts.value = response.data;
    } catch (err) {
        console.error("Error fetching related products:", err);
    }
}

async function addToCart(product) {
    if (!selectedSize.value) {
        Swal.fire({
            icon: 'warning',
            title: 'Size Required',
            text: 'You must select a size before adding to cart.',
        });
        return;
    }

    try {
        const response = await axios.post('/cart/add', {
            product_id: product.id,
            size: selectedSize.value,
            quantity: quantity.value,
        });
        Swal.fire({
            icon: 'success',
            title: 'Added to Cart',
            text: response.data.message,
        }).then(() => {
            window.location.reload();
        });
    } catch (err) {
        console.error("Error adding to cart:", err);
        alert("Failed to add product to cart.");
    }
}

onMounted(() => {
    fetchProduct();
    fetchRelatedProducts();
});
</script>

<template>
    <navbar />
    <div v-if="product" class="min-h-screen bg-gray-100 py-8">
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <div class="relative">
                    <img
                        :src="mainImage"
                        :alt="product.name"
                        class="w-full object-cover rounded-lg"
                    />
                </div>
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
            <div class="bg-white p-6 rounded-lg shadow">
                <h1 class="text-2xl font-semibold text-gray-800">{{ product.name }}</h1>
                <div class="mt-4">
                    <p class="text-primary text-2xl font-bold">{{ product.price }}DT</p>
                    <p class="text-gray-400 text-sm line-through" v-if="product.oldPrice">
                        {{ product.oldPrice }}DT
                    </p>
                </div>
                <p class="text-gray-600 mt-6 leading-6">{{ product.description }}</p>
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
                    <p v-if="selectedSize" class="mt-4 text-gray-800">Taille sélectionnée : {{ selectedSize }}</p>
                </div>
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-800">Quantity:</h3>
                    <input
                        type="number"
                        v-model="quantity"
                        min="1"
                        class="mt-2 p-2 border border-gray-300 rounded-lg w-20"
                    />
                </div>
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
                    <div
                        v-for="product in relatedProducts"
                        :key="product.id"
                        class="bg-white shadow-md rounded overflow-hidden group cursor-pointer transform transition duration-300 hover:-translate-y-2 hover:shadow-lg"
                    >
                        <a :href="`/product/${product.id}`" class="group">
                            <div class="relative">
                                <img
                                    :src="`http://127.0.0.1:8000/${product.image}`"
                                    :alt="product.name"
                                    class="w-full h-[300px] object-cover transition-all duration-500 group-hover:opacity-0"
                                />
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
                        <div class="p-4">
                            <a
                                :href="`/product/${product.id}`"
                                class="block w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 text-sm font-medium shadow-sm text-center"
                            >
                                Visit Product
                            </a>
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
