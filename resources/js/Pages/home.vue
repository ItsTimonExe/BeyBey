<template>
    <div class="bg-gray-100">
        <navbar />
        <!-- Hero Section -->
        <section class="relative bg-gray-900 text-white h-screen flex items-center justify-center">
            <video
                autoplay
                loop
                muted
                playsinline
                class="absolute inset-0 w-full h-full object-cover z-0 opacity-40"
            >
                <source src="../assets/image/bg3.mp4" type="video/mp4" />
                Your browser does not support the video tag.
            </video>
            <div class="relative z-10 text-center space-y-6 animate__animated animate__fadeIn">
                <h1 class="text-5xl font-bold md:text-6xl">
                    Welcome to <span class="text-blue-500 ">Bey&Bey</span>
                </h1>
                <p class="text-lg md:text-xl text-gray-300 animate__animated animate__slideInUp">
                    Discover trending products and exclusive deals.
                </p>

                <a
                    href="/shop"
                    class="inline-block px-8 py-3 bg-blue-500 text-white text-lg font-semibold rounded hover:bg-blue-600"
                >
                    Shop Now
                </a>
            </div>
        </section>

        <!-- Product Card -->
        <section class="min-h-screen py-10 px-4 md:px-10">
            <h2 class="text-4xl font-bold text-center mb-10">
                Art & Comfort every day
            </h2>

            <!-- Products Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <!-- Product Card -->
                <div
                    v-for="product in products"
                    :key="product.id"
                    class="bg-white shadow-md rounded overflow-hidden group cursor-pointer transform transition duration-300 hover:-translate-y-2 hover:shadow-lg"
                >
                    <a :href="`/product/${product.id}`" class="group">
                        <div class="relative" >
                            <img
                                :src="product.image"
                                :alt="product.name"
                                class="w-full h-70 object-cover transition-opacity duration-300 group-hover:opacity-0"
                            />
                            <img
                                :src="product.hover_image"
                                :alt="product.name"
                                class="absolute inset-0 w-full h-70 object-cover transition-opacity duration-300 opacity-0 group-hover:opacity-100"
                            />
                        </div>
                        <div class="p-4" >
                            <h3 class="text-lg font-semibold text-gray-800">
                                {{ product.name }}
                            </h3>
                            <div class="flex items-center justify-between mt-2">
                                <p class="text-primary text-xl font-bold">{{ product.price }}DT</p>
                                <p class="text-gray-400 line-through">{{ product.old_price }}DT</p>
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
            <!-- ./Product Card -->
        </section>

        <div class="relative w-full overflow-hidden bg-gray-900 text-white py-2">
            <div class="flex whitespace-nowrap animate-marquee">
            <span v-for="i in 1000" :key="i" class="text-lg font-bold uppercase mx-8">
            Free shipping on purchases over 300 DT
            </span>
            </div>
        </div>
        <!-- Swiper Section: Special Offers -->
        <section class="py-10 bg-gray-100">
            <div class="container mx-auto px-4">
                <h2 class="text-4xl font-bold text-center mb-10">
                    Special Offers
                </h2>
                <swiper

                    :slides-per-view="4"
                    :loop="true"
                    :pagination="{ clickable: true }"

                    :autoplay="{ delay: 3000 }"
                    :space-between="16"
                    :breakpoints="{ 640: { slidesPerView: 1 }, 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }"
                    class="h-94"
                >
                    <swiper-slide
                        v-for="offer in specialOffers"
                        :key="offer.id"
                        class="rounded-lg  overflow-hidden  overflow-hidden group cursor-pointer transform transition duration-300 hover:-translate-y-4 hover:shadow-lg"
                    >
                        <img
                            :src="offer.image"
                            :alt="offer.title"
                            class="h-56 w-full object-cover"
                        />
                        <div class="p-6 bg-white">
                            <h3 class="text-lg font-semibold">{{ offer.title }}</h3>
                            <p class="mt-2 text-gray-600">
                                {{ offer.description }}
                            </p>
                            <a
                                href="/shop"
                                class="inline-block mt-4 px-6 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                            >
                                Shop Now
                            </a>
                        </div>
                    </swiper-slide>
                </swiper>
            </div>
        </section>

        <!-- Why Choose Us Section -->
        <section class="py-10 bg-gray-900 text-white">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-4xl font-extrabold mb-12 text-center w-full mx-auto">
                        Why Choose Us
                    </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Card 1 -->
                    <div
                        class="p-6 bg-gray-800 rounded-lg transform transition duration-500 hover:scale-105 hover:shadow-lg hover:rotate-3"
                    >
                        <img src="../assets/icons/i3.gif" alt="Quality" class="w-[100px] h-[100px] mx-auto mb-4" />
                        <h3 class="font-bold text-lg">High Quality</h3>
                        <p class="text-gray-400 mt-2">
                            We guarantee that every product meets the highest standards of quality.
                        </p>
                    </div>
                    <!-- Card 2 -->
                    <div
                        class="p-6 bg-gray-800 rounded-lg transform transition duration-500 hover:scale-105 hover:shadow-lg hover:rotate-2"
                    >
                        <img src="../assets/icons/i1.gif" alt="Fast Delivery" class="w-[100px] h-[100px] mx-auto mb-4" />
                        <h3 class="font-bold text-lg">Fast Delivery</h3>
                        <p class="text-gray-400 mt-2">
                            Get your products delivered quickly with our trusted logistics partners.
                        </p>
                    </div>
                    <!-- Card 3 -->
                    <div
                        class="p-6 bg-gray-800 rounded-lg transform transition duration-500 hover:scale-105 hover:shadow-lg hover:-rotate-2"
                    >
                        <img src="../assets/icons/i4.gif" alt="Customer Support" class="w-[100px] h-[100px] mx-auto mb-4" />
                        <h3 class="font-bold text-lg">24/7 Support</h3>
                        <p class="text-gray-400 mt-2">
                            Our customer support team is here to help you anytime, anywhere.
                        </p>
                    </div>
                    <!-- Card 4 -->
                    <div
                        class="p-6 bg-gray-800 rounded-lg transform transition duration-500 hover:scale-105 hover:shadow-lg hover:-rotate-3"
                    >
                        <img src="../assets/icons/i2.gif" alt="Secure Payment" class="w-[100px] h-[100px] mx-auto mb-4" />
                        <h3 class="font-bold text-lg">Secure Payment</h3>
                        <p class="text-gray-400 mt-2">
                            We provide the most secure and reliable payment options available.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Instagram Section -->
        <section class="bg-white text-black py-10 px-6">
            <div class="max-w-7xl mx-auto">
                <p class="text-sm uppercase tracking-wide text-gray-400">Stay in Touch</p>
                <h2 class="text-4xl font-bold mt-2">Moments Made Memories</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
                    <div v-for="(image, index) in IMAGE_TABLE" :key="index" class="overflow-hidden">
                        <img :src="image" alt="Fashion moment" class="w-full h-auto object-cover" />
                    </div>
                </div>
                <div class="text-right mt-6">
                    <a href="https://www.instagram.com/beyandbey/?hl=fr" class="inline-flex items-center space-x-2 text-black font-semibold ">
                        <span>Get Inspired with</span>
                        <span class="text-blue-400">@Bey&Bey</span>
                    </a>
                </div>
            </div>
        </section>
        <Footer />
    </div>
</template>

<script setup>
import Footer from "@/Components/footer.vue";
import navbar from "@/Components/navBar.vue";
import 'swiper/css/pagination';
import {Swiper, SwiperSlide} from "swiper/vue";
import "swiper/swiper-bundle.css";
import { ref, onMounted } from "vue";
import axios from "axios";

const IMAGE_TABLE = ref( [
    new URL("../assets/image/p5.jpg", import.meta.url).href,
    new URL("../assets/image/p7.jpg", import.meta.url).href,
    new URL("../assets/image/p6.jpg", import.meta.url).href,
    new URL("../assets/image/p8.jpg", import.meta.url).href,
]);
const specialOffers = ref([]);

onMounted(async () => {
    try {
        const response = await axios.get("/api/special-offers");
        specialOffers.value = response.data; // Mettre à jour les données
    } catch (error) {
        console.error("Erreur lors de la récupération des offres spéciales :", error);
    }
});


const products = ref([]);

onMounted(async () => {
    try {
        const response = await axios.get("/api/last-products");
        products.value = response.data;
    } catch (error) {
        console.error("Erreur de chargement des produits :", error);
    }
});


</script>

<style scoped>

@keyframes marquee {
    from {
        transform: translateX(1%);
    }
    to {
        transform: translateX(-10000%);
    }
}

.animate-marquee {
    display: flex;
    animation: marquee 1500s linear infinite;
}
</style>
