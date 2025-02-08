<script setup>
import Footer from "../components/footer.vue";
import Navbar from "../components/navBar.vue";
import {computed, ref, onMounted} from 'vue';
import axios from 'axios';
import {usePage} from "@inertiajs/vue3";
const page = usePage();
const user = computed(() => page.props.auth.user);


const name = ref('');
const email = ref('');
const message = ref('');
const errors = ref({});
const successMessage = ref('');

onMounted(() => {
    if (user.value) {
        name.value = user.value.name || '';
        email.value = user.value.email || '';
    }
});
const submitForm = async () => {
    errors.value = {};
    successMessage.value = '';

    try {
        const response = await axios.post('/contact', {
            name: name.value,
            email: email.value,
            message: message.value,
        });

        successMessage.value = response.data.message;
        name.value = '';
        email.value = '';
        message.value = '';
    } catch (error) {
        if (error.response && error.response.data.errors) {
            errors.value = error.response.data.errors;
        }
    }
};
</script>

<template>
    <Navbar />

    <!-- Contact Section -->
    <section class="relative bg-gradient-to-br from-blue-50 via-white to-gray-50 py-16 lg:py-24 overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <!-- Header Section with Animation -->
            <div class="text-center mb-16 animate-fade-in">
                <h1 class="text-5xl font-extrabold text-gray-800 leading-tight">
                    Let's <span class="text-blue-600">Talk</span>
                </h1>
                <p class="text-gray-600 text-lg mt-4 max-w-3xl mx-auto">
                    Have questions or ideas? Contact us and let’s discuss how we can help!
                </p>
            </div>

            <!-- Main Content -->
            <div class="grid lg:grid-cols-2 gap-12 items-start">
                <!-- Contact Information Section -->
                <div class="space-y-8 animate-slide-in-left">
                    <div class="bg-blue-100 p-6 rounded-lg shadow-lg">
                        <h2 class="text-2xl font-bold text-blue-600 mb-4">Contact Information</h2>
                        <ul class="space-y-6">
                            <!-- Email -->
                            <li>
                                <span class="block font-bold">Email:</span>
                                <span>contact@example.com</span>
                            </li>

                            <!-- Phone -->
                            <li>
                                <span class="block font-bold">Phone:</span>
                                <span>+216 29 123 123</span>
                            </li>

                            <!-- Address -->
                            <li>
                                <span class="block font-bold">Address:</span>
                                <span>Tunise,Djerba 4135</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Contact Form Section -->
                <div
                    class="bg-white shadow-xl rounded-lg p-8 lg:p-12 border-t-4 border-blue-600 animate-fade-in"
                >
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Get in Touch</h2>
                    <form  @submit.prevent="submitForm" class="space-y-6">
                        <!-- Input: Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input
                                v-model="name"
                                id="name"
                                type="text"
                                placeholder="Name"
                                class="block w-full mt-2 rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            />
                        </div>

                        <!-- Input: Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input
                                v-model="email"
                                id="email"
                                type="email"
                                placeholder="youremail@example.com"
                                class="block w-full mt-2 rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            />
                        </div>

                        <!-- Input: Message -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                            <textarea
                                v-model="message"
                                id="message"
                                rows="4"
                                placeholder="Your message here..."
                                class="block w-full mt-2 rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            ></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button
                                type="submit"
                                class="w-full block py-3 px-6 bg-blue-600 text-white text-center font-semibold rounded-lg shadow-md hover:bg-blue-700 transform duration-300 ease-in-out hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-400"
                            >
                                Send Message
                            </button>
                        </div>
                        <p v-if="successMessage">{{ successMessage }}</p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <Footer />
</template>

<style scoped>
/* Custom Animations */
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 1s ease-in-out forwards;
}

@keyframes slide-in-left {
    from {
        opacity: 0;
        transform: translateX(-50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.animate-slide-in-left {
    animation: slide-in-left 1s ease-in-out forwards;
}
</style>
