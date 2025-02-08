<template>
    <section
        class="relative flex items-center justify-center min-h-screen bg-gray-900 overflow-hidden"
        aria-label="Login Section"
    >
        <!-- Vidéo ou image de fond -->
        <video
            v-if="supportsVideo"
            autoplay
            loop
            muted
            playsinline
            class="absolute z-0 w-full h-full object-cover"
        >
            <source :src="backgroundVideo" type="video/mp4" />
            Your browser does not support the video tag.
        </video>
        <img
            v-else
            :src="backgroundImage"
            alt="Background"
            class="absolute z-0 w-full h-full object-cover"
        />

        <!-- Overlay sombre -->
        <div class="absolute inset-0 z-10 bg-black opacity-50"></div>

        <!-- Contenu -->
        <div
            class="relative z-20 w-full max-w-md px-6 py-8 bg-white rounded-lg shadow-md dark:bg-gray-800 sm:mx-4 sm:py-5 animate-fade-in"
            aria-labelledby="login-title"
        >
            <h1 id="login-title" class="sr-only">Log in to your Account</h1>

            <!-- Logo centré -->
            <div class="flex justify-center mb-6">
                <a href="/">
                    <img
                        :src="logoPath"
                        alt="Logo"
                        class="h-12 sm:h-10"
                    />
                </a>
            </div>

            <!-- Formulaire -->
            <form @submit.prevent="handleSubmit" class="space-y-6" aria-label="Login Form">
                <!-- Champ Email -->
                <div>
                    <label
                        for="email"
                        class="block text-sm text-gray-700 dark:text-gray-200"
                    >
                        Email Address
                    </label>
                    <input
                        v-model="form.email"
                        type="email"
                        id="email"
                        required
                        placeholder="you@example.com"
                        class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border rounded-lg dark:bg-gray-900 dark:placeholder-gray-500 dark:text-gray-300 focus:border-blue-400 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />

                </div>

                <!-- Champ Password -->
                <div>
                    <label
                        for="password"
                        class="flex items-center justify-between text-sm text-gray-700 dark:text-gray-200"
                    >
                        <span>Password</span>
                        <a
                            :href="route('password.request')"
                            class="text-sm text-blue-500 hover:underline dark:text-blue-300"
                        >
                            Forgot Password?
                        </a>
                    </label>
                    <input
                        v-model="form.password"
                        type="password"
                        id="password"
                        required
                        placeholder="Your Password"
                        class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400 bg-white border rounded-lg dark:bg-gray-900 dark:placeholder-gray-500 dark:text-gray-300 focus:border-blue-400 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <!-- Case à cocher Remember Me -->
                <div class="flex items-center">
                    <input
                        v-model="form.remember"
                        type="checkbox"
                        id="remember"
                        class="w-4 h-4 text-blue-500 border-gray-300 rounded focus:ring-blue-400 focus:ring-opacity-50 dark:bg-gray-900 dark:border-gray-700"
                    />
                    <label
                        for="remember"
                        class="ml-2 text-sm text-gray-700 dark:text-gray-200"
                    >
                        Remember me
                    </label>
                    </div>

                <!-- Bouton Login -->
                <div>
                    <button
                        type="submit"
                        class="w-full px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:bg-blue-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    >
                        Log in
                    </button>
                </div>
            </form>

            <!-- Invitation à s'inscrire -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Don't have an account?
                    <a
                        href="/register"
                        class="text-blue-500 hover:underline dark:text-blue-300"
                    >
                        Create one
                    </a>
                </p>
            </div>
        </div>
    </section>
</template>

<script setup>
import {computed} from "vue";
import {useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";

// Import des fichiers statiques via Vite
const backgroundVideo = new URL("@/assets/image/bg.mp4", import.meta.url).href;
const backgroundImage = new URL("@/assets/image/bg-placeholder.jpg", import.meta.url).href;
const logoPath = new URL("@/assets/image/logo1.png", import.meta.url).href;

// Support du tag vidéo — Feature detection
const supportsVideo = computed(() => {
    return document.createElement("video").canPlayType !== undefined;
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});
// Fonction de soumission
const handleSubmit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<style scoped>
/* Animation */
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.5s ease-out;
}

/* Styles Responsive */
@media (max-width: 1024px) {
    section {
        padding: 16px;
    }
}

@media (max-width: 768px) {
    section {
        padding: 16px;
    }

    .sm\:mx-4 {
        margin: 0 auto;
    }

    .sm\:py-5 {
        padding: 1.25rem;
    }

}
</style>
