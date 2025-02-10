<template>
    <div v-show="show" @click="show = false" class="fixed inset-0 z-40"></div>
    <header class="shadow-md bg-white font-[sans-serif] tracking-wide relative z-50">
        <!-- Top Section -->
        <section
            class="flex items-center flex-wrap lg:justify-center gap-4 py-2.5 sm:px-10 px-4 border-gray-200 border-b min-h-[70px]">

            <!-- Logo -->
            <a href="/" class="max-sm:hidden">
                <img src="../assets/image/logo.png" alt="logo" class="w-36"/>
            </a>
            <a href="/" class="hidden max-sm:block">
                <img src="../assets/image/logo.png" alt="logo" class="w-[120px]"/>
            </a>

            <!-- Navigation Icons -->
            <div class="lg:absolute lg:right-10 flex items-center ml-auto space-x-8">

                <!-- Cart Icon -->
                <span class="relative">
                    <a href="/cart"><svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px"
                         class="cursor-pointer fill-gray-800 hover:fill-[#007bff] inline-block" viewBox="0 0 512 512">
                        <path
                            d="M164.96 300.004h.024c.02 0 .04-.004.059-.004H437a15.003 15.003 0 0 0 14.422-10.879l60-210a15.003 15.003 0 0 0-2.445-13.152A15.006 15.006 0 0 0 497 60H130.367l-10.722-48.254A15.003 15.003 0 0 0 105 0H15C6.715 0 0 6.715 0 15s6.715 15 15 15h77.969c1.898 8.55 51.312 230.918 54.156 243.71C131.184 280.64 120 296.536 120 315c0 24.812 20.188 45 45 45h272c8.285 0 15-6.715 15-15s-6.715-15-15-15H165c-8.27 0-15-6.73-15-15 0-8.258 6.707-14.977 14.96-14.996zM477.114 90l-51.43 180H177.032l-40-180zM150 405c0 24.813 20.188 45 45 45s45-20.188 45-45-20.188-45-45-45-45 20.188-45 45zm45-15c8.27 0 15 6.73 15 15s-6.73 15-15 15-15-6.73-15-15 6.73-15 15-15zm167 15c0 24.813 20.188 45 45 45s45-20.188 45-45-20.188-45-45-45-45 20.188-45 45zm45-15c8.27 0 15 6.73 15 15s-6.73 15-15 15-15-6.73-15-15 6.73-15 15-15zm0 0"
                            data-original="#000000"/>
                    </svg></a>
                    <span
                        class="absolute left-auto -ml-1 top-0 rounded-full bg-blue-600 px-1 py-0 text-xs text-white">{{ cartCount }}</span>
                </span>

                <!-- User Icon -->
                <div class="relative">
                    <!-- User Icon -->
                    <div
                        class="flex items-center space-x-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-gray-700 shadow-sm cursor-pointer hover:border-[#007bff] hover:text-[#007bff]"
                        @click="show = !show"
                        :class="{ 'bg-slate-300': show }"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24"
                             class="hover:fill-[#007bff]">
                            <circle cx="10" cy="7" r="6"/>
                            <path
                                d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5zm8-4h-2.59l.3-.29a1 1 0 0 0-1.42-1.42l-2 2a1 1 0 0 0 0 1.42l2 2a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-.3-.29H22a1 1 0 0 0 0-2z"/>
                        </svg>
                        <p v-if="user" class="text-sm font-medium">{{ user.name }}</p>

                    </div>




                    <!-- Dropdown Menu -->
                    <div  v-show="show"
                         @click="show = false"  class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border bg-white rounded divide-y divide-gray-300 ">
                        <div v-if="user" class="py-3 px-4 " aria-labelledby="dropdown">
                            <span class="block text-sm font-semibold  text-gray-800">{{ user.name }}</span>
                            <span class="block text-sm  truncate text-gray-800">{{ user.email }}</span>
                        </div>
                        <ul v-if="user" class="py-2">

                            <li>
                                <a href="/profile" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">profile</a>
                                <a href="/dashboard" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">dashboard</a>
                                <a v-if="user.isAdmin" href="/admin/dashboard" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">admin dashboard</a>
                                <a
                                    href="#"
                                    @click.prevent="$inertia.post(route('logout'))"
                                    class="block px-4 py-2 text-gray-800 hover:bg-gray-100"
                                >
                                    Logout
                                </a>
                            </li>
                        </ul>

                        <ul v-else class="py-2">

                            <li>
                                <a href="/login" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Login</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <nav class="bg-gray-100 border-t border-gray-200">
            <ul class="flex justify-center space-x-8 px-4 sm:px-10 py-3 text-md font-medium">
                <li><a href="/" class="text-gray-700 hover:text-[#007bff]">Home</a></li>
                <li><a href="/shop" class="text-gray-700 hover:text-[#007bff]">Shop</a></li>
                <li><a href="/contact" class="text-gray-700 hover:text-[#007bff]">Contact</a></li>
            </ul>
        </nav>
    </header>
</template>

<script setup>
import { computed, ref, onMounted } from 'vue';
import { usePage } from "@inertiajs/vue3";

const dropdownOpen = ref(false);
const cartCount = ref(0);
const page = usePage();
const user = computed(() => page.props.auth.user);

const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value;
};
const show = ref(false);

// Fetch cart items and calculate the total count
const fetchCartCount = async () => {
    try {
        const response = await axios.get('/cart/items');
        cartCount.value = response.data.reduce((total, item) => total + item.quantity, 0);
    } catch (err) {
        console.error('Error fetching cart items:', err);
    }
};

onMounted(() => {
    fetchCartCount();
});
</script>

<style scoped>

</style>
