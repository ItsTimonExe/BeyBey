<template>

    <section class="relative flex items-center justify-center min-h-screen bg-gray-900 overflow-hidden text-white">

        <video
            autoplay
            loop
            muted
            playsinline
            class="absolute z-0 w-auto min-w-full min-h-full max-w-none"
        >
            <source
                src="../assets/image/bg.mp4"
                type="video/mp4"
            />
            Your browser does not support the video tag.
        </video>


        <div class="absolute inset-0 z-10 bg-black opacity-70"></div>


        <div class="relative z-20 flex flex-col items-center text-center px-6 py-8 bg-opacity-50 rounded-lg">

            <div class="mb-6">
                <img
                    src="../assets/image/logo1.png"
                    alt="Logo"
                    class="h-12"
                />
            </div>


            <h1 class="text-6xl font-bold text-blue-500">404</h1>
            <h2 class="mt-4 text-2xl font-semibold text-white">Page Not Found</h2>
            <p class="mt-2 text-gray-400">
                Oops, the page you are looking for does not exist or has been removed.
            </p>

            <div class="mt-6 space-x-4">
                <!-- Go Back Button -->
                <button
                    @click="goBack"
                    class="px-6 py-3 text-sm font-medium text-gray-900 bg-gray-300 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring focus:ring-gray-400 focus:ring-opacity-50"
                >
                    Go Back
                </button>


                <a
                    href="/"
                    class="px-6 py-3 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-50"
                >
                    Go to Home
                </a>
            </div>
        </div>
    </section>
</template>

<script setup>

const goBack = () => {
    window.history.back();
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
</style>
