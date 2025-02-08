<template>
    <section class="relative flex items-center justify-center min-h-screen bg-gray-900 overflow-hidden">
        <video
            autoplay
            loop
            muted
            playsinline
            class="absolute z-0 w-auto min-w-full min-h-full max-w-none"
        >
            <source
                src="@/assets/image/bg.mp4"
                type="video/mp4"
            />
            Your browser does not support the video tag.
        </video>

        <div class="absolute inset-0 z-10 bg-black opacity-50"></div>

        <div
            class="relative z-20 w-full max-w-md px-6 py-8 bg-white rounded-lg shadow-md dark:bg-gray-800 animate-fade-in"
        >
            <div class="flex justify-center mb-6">
                <a href="/">
                    <img
                        src="@/assets/image/logo1.png"
                        alt="Logo"
                        class="h-12"
                    />
                </a>
            </div>

            <div class="text-center">
                <h2 class="text-lg font-semibold text-gray-700 dark:text-white">
                    Reset Your Password
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Enter your email to request a password reset link.
                </p>
            </div>

            <form @submit.prevent="handleSubmit" class="mt-6 space-y-6">
                <div>
                    <div
                        v-if="status"
                        class="mb-4 text-sm font-medium text-green-600"
                    >
                        {{ status }}
                    </div>

                    <label for="email" class="block text-sm text-gray-700 dark:text-gray-200">
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

                <div>
                    <button
                        type="submit"
                        class="w-full px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:bg-blue-600 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    >
                        Send Reset Link
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Remembered your password?
                    <a
                        href="/login"
                        class="text-blue-500 hover:underline dark:text-blue-300"
                    >
                        Log in
                    </a>
                </p>
            </div>
        </div>
    </section>
</template>

<script setup>
import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const handleSubmit = () => {
    form.post(route('password.email'));
};

</script>

<style scoped>
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
