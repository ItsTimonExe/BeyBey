<template>
    <footer class="bg-gray-100 shadow-md py-10 sm:px-10 px-6 font-[sans-serif] tracking-wide">
        <div class="max-w-screen-xl mx-auto">
            <!-- Logo Section -->
            <div class="flex items-center justify-center h-full">
                <img :src="logoPath" alt="Logo" class="h-14" />
            </div>
            <hr class="my-12" />
            <!-- Links Section -->
            <div class="grid max-sm:grid-cols-1 max-lg:grid-cols-2 lg:grid-cols-4 gap-8">
                <div v-for="(section, index) in sections" :key="index">
                    <h4 class="text-base font-bold mb-6 text-gray-900">{{ section.title }}</h4>
                    <p v-if="section.text" class="text-gray-700 mb-2 text-sm leading-relaxed">
                        {{ section.text }}
                    </p>
                    <ul v-else class="space-y-3">
                        <li v-for="(link, i) in section.links" :key="i">
                            <a :href="link.url" class="text-gray-900 hover:text-blue-500 text-sm">
                                {{ link.text }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup>
import { ref } from "vue";
const logoPath = new URL("../assets/image/logo.png", import.meta.url).href;

const sections = [
    {
        title: "About Us",
        text: "100% Tunisian brand embroidered and eco-friendly,\n" +
            "crafted specifically for the coolest streetwear lovers."
    },
    {
        title: "NAVIGATION",
        links: [
            { text: "Home", url: "/" },
            { text: "Shop", url: "/shop" },
            { text: "Contact", url: "/contact" },
        ]
    },
    {
        title: "COLLECTIONS",
        links: [
            { text: "Hoodies", url: "/shop" },
            { text: "T-Shirts", url: "/shop" },
            { text: "Sweatshirts", url: "/shop" },
        ]
    },
    {
        title: "Social Links",
        links: [
            { text: "Facebook", url: "https://www.facebook.com" },
            { text: "Instagram", url: "https://www.instagram.com" },
            { text: "Youtube", url: "https://www.youtube.com" },
        ]
    }
];
</script>

<style scoped>
</style>
