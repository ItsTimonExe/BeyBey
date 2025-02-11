<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import Footer from "../Components/footer.vue";
import navbar from "../Components/navBar.vue";
import axios from "axios";
import { Link as InertiaLink } from '@inertiajs/inertia-vue3';

// Reactive data for cart items
const cartItems = ref([]);
const discountCode = ref(""); // Discount code entered by the user
const isCodeApplied = ref(false); // Indicates if the discount code is valid
const discountValue = ref(0); // Discount value
const showDiscountMessage = ref(false); // Controls the display of discount messages

// Function to format currency
const formatCurrency = (value) => {
    return new Intl.NumberFormat("en-TN", {
        style: "currency",
        currency: "TND",
    }).format(value);
};

// Calculate subtotal
const calculateSubtotal = () => {
    return cartItems.value.reduce(
        (total, item) => total + item.price * item.quantity,
        0
    );
};

// Calculate taxes
const calculateTaxes = () => {
    return calculateSubtotal() * 0.1; // Assume a tax rate of 10%
};

// Calculate total after discount
const calculateTotal = () => {
    return calculateSubtotal() + calculateTaxes() - discountValue.value;
};

// Apply discount code
const applyDiscountCode = () => {
    showDiscountMessage.value = true; // Show messages after clicking the button
    if (discountCode.value === "PROMO10") {
        discountValue.value = calculateSubtotal() * 0.1; // 10% discount
        isCodeApplied.value = true;
    } else {
        discountValue.value = 0;
        isCodeApplied.value = false;
    }
};

// Refresh the cart after each modification
const refreshCart = () => {
    applyDiscountCode(); // Reapply the discount when refreshing
};

// Remove an item from the cart
const removeItem = async (product_id) => {
    try {
        await axios.delete(`/cart/items/${product_id}`);
        cartItems.value = cartItems.value.filter(item => item.product_id !== product_id);
    } catch (err) {
        console.error("Error removing product from cart:", err);
    }
};
// Update the quantity of a product
const updateQuantity = async (item, change) => {
    item.quantity += change;
    if (item.quantity < 1) {
        await removeItem(item.id); // Remove the item if quantity becomes 0
    } else {
        try {
            await axios.put(`/cart/items/${item.id}`, { quantity: item.quantity });
            refreshCart(); // Refresh the cart otherwise
        } catch (err) {
            console.error("Error updating item quantity:", err);
        }
    }
};

// Redirect to the checkout page
const router = useRouter();


// Fetch cart items from the backend
// Helper function to add or update items in the cart
const addOrUpdateCartItem = (item) => {
    const existingItem = cartItems.value.find(cartItem => cartItem.product_id === item.product_id && cartItem.size === item.size);
    if (existingItem) {
        existingItem.quantity += item.quantity;
    } else {
        cartItems.value.push(item);
    }
};

// Fetch cart items from the backend
const fetchCartItems = async () => {
    try {
        const response = await axios.get('/cart/items');
        const cartData = response.data;

        // Fetch product details for each cart item
        const productRequests = cartData.map(item => axios.get(`/api/product/${item.product_id}`));
        const productResponses = await Promise.all(productRequests);

        // Map cart items with product images and add/update them in the cart
        cartData.forEach((item, index) => {
            const cartItem = {
                ...item,
                image: productResponses[index].data.image || 'default-image-path.jpg' // Fallback image
            };
            addOrUpdateCartItem(cartItem);
        });

        console.log(cartItems.value);
        // Log the image value for each item
        cartItems.value.forEach(item => {
            console.log(item.image);
        });
    } catch (err) {
        console.error("Error fetching cart items:", err);
    }
};

onMounted(() => {
    fetchCartItems();
});
</script>

<template>
    <navbar />
    <div class="container mx-auto max-w-7xl p-6 space-y-12">
        <!-- Page title -->
        <h1 class="text-4xl font-semibold text-center text-gray-800 tracking-wide">
            My Cart
        </h1>

        <!-- Main content -->
        <div v-if="cartItems.length > 0" class="grid lg:grid-cols-12 gap-8">
            <!-- Product list -->
            <div class="lg:col-span-8 space-y-8">
                <div
                    v-for="item in cartItems"
                    :key="item.id"
                    class="flex items-center bg-white border border-gray-200 rounded-lg shadow-sm px-4 transition hover:shadow-md"
                >

                    <!-- Product image -->
                    <div class="w-[140px] h-[140px] rounded-lg overflow-hidden flex-shrink-0">
                        <img
                            :src="`/${item.image}`"
                            :alt="item.name"
                            class="w-full h-full object-cover"
                            @error="handleImageError"
                        />
                    </div>

                    <!-- Product details -->
                    <div class="ml-6 flex-1">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ item.name }}
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Unit Price:
                            <span class="font-semibold text-teal-600">
                            {{ formatCurrency(item.price) }}
                        </span>
                        </p>
                        <p class="text-sm text-gray-500">
                            Size:
                            <span class="font-semibold text-gray-800">
                            {{ item.size }}
                        </span>
                        </p>
                        <p class="text-sm text-gray-500">
                            Quantity:
                            <span class="font-semibold text-gray-800">
                            {{ item.quantity }}
                        </span>
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center space-x-4">
                        <button
                            @click="updateQuantity(item, -1)"
                            :disabled="item.quantity <= 1"
                            class="flex items-center justify-center w-8 h-8 bg-gray-100 text-gray-600 rounded-full hover:bg-gray-200 transition disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            -
                        </button>
                        <div class="text-sm text-gray-900 font-semibold">
                            {{ item.quantity }}
                        </div>
                        <button
                            @click="updateQuantity(item, 1)"
                            class="flex items-center justify-center w-8 h-8 bg-teal-500 text-white rounded-full hover:bg-teal-600 transition"
                        >
                            +
                        </button>
                        <button
                            @click="removeItem(item.product_id)"
                            class="flex items-center justify-center w-8 h-8 bg-red-100 text-red-500 rounded-full hover:bg-red-200 transition"
                        >
                            ✕
                        </button>
                    </div>
                </div>
            </div>

            <!-- Summary section -->
            <div class="lg:col-span-4 p-6 bg-gray-50 rounded-xl shadow-sm border border-gray-200 space-y-6">
                <h2 class="text-lg font-medium text-gray-800 text-center">
                    Order Summary
                </h2>

                <!-- Summary product list -->
                <div
                    v-for="item in cartItems"
                    :key="item.id"
                    class="flex justify-between items-center text-sm text-gray-600"
                >
                    <span>{{ item.name }} (x{{ item.quantity }})</span>
                    <span class="font-medium">{{ formatCurrency(item.price * item.quantity) }}</span>
                </div>

                <hr class="border-gray-300" />

                <!-- Totals and discounts -->
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-medium text-gray-900">{{ formatCurrency(calculateSubtotal()) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Taxes (10%):</span>
                        <span class="font-medium text-gray-900">{{ formatCurrency(calculateTaxes()) }}</span>
                    </div>
                    <div v-if="discountValue > 0" class="flex justify-between text-teal-600 font-medium">
                        <span>Discount:</span>
                        <span>-{{ formatCurrency(discountValue) }}</span>
                    </div>
                </div>

                <hr class="border-gray-300" />

                <!-- Total -->
                <div class="flex justify-between text-lg font-semibold">
                    <span>Total:</span>
                    <span class="text-teal-500">{{ formatCurrency(calculateTotal()) }}</span>
                </div>

                <!-- Promo field -->
                <div class="flex flex-col space-y-3">
                    <input
                        v-model="discountCode"
                        type="text"
                        placeholder="Discount Code"
                        class="p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-400 focus:outline-none"
                    />
                    <button
                        @click="applyDiscountCode"
                        class="w-full py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition"
                    >
                        Apply Discount
                    </button>
                    <p v-if="showDiscountMessage && isCodeApplied" class="text-sm text-green-500 text-center">
                        Discount code successfully applied!
                    </p>
                    <p v-else-if="showDiscountMessage && !isCodeApplied" class="text-sm text-red-500 text-center">
                        Invalid discount code.
                    </p>
                </div>
                <inertia-link
                    class="w-full py-3 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition text-center block"
                    href="/checkout">


                        Go to Checkout

                </inertia-link>

            </div>
        </div>

        <!-- Message if cart is empty -->
        <div v-else class="flex flex-col items-center space-y-4 text-center">
            <h2 class="text-xl font-semibold text-gray-700">
                Your cart is empty.
            </h2>
            <a
                href="/shop"
                class="px-6 py-3 bg-teal-500 text-white rounded-lg transition shadow hover:shadow-lg"
            >
                Continue Shopping
            </a>
        </div>
    </div>
    <Footer />
</template>
