<script setup>
import { ref } from "vue";
import Footer from "../components/footer.vue";
import navbar from "../components/navBar.vue";
import axios from "axios";

// Fetch cart items from the backend
const cartItems = ref([]);

const fetchCartItems = async () => {
    try {
        const response = await axios.get('/cart/items');
        cartItems.value = response.data;
    } catch (err) {
        console.error("Error fetching cart items:", err);
    }
};

// Function to format currency
const formatCurrency = (value) => {
    return new Intl.NumberFormat("en-TN", {
        style: "currency",
        currency: "TND",
    }).format(value);
};
// Compute total
const calculateTotal = () => {
    return cartItems.value.reduce(
        (total, item) => total + item.price * item.quantity,
        0
    );
};

// Object to store user information
const userInfo = ref({
    fullName: "",
    email: "",
    address: "",
    city: "",
    zipCode: "",
    phone: "",
    paymentMethod: "credit_card",
});

// Form validation and order action
const placeOrder = async () => {
    if (
        userInfo.value.fullName &&
        userInfo.value.email &&
        userInfo.value.address &&
        userInfo.value.city &&
        userInfo.value.zipCode &&
        userInfo.value.phone
    ) {
        try {
            await axios.post('/checkout', {
                userInfo: userInfo.value,
                cartItems: cartItems.value,
                total: calculateTotal(),
            });
            alert("Order placed successfully!");
        } catch (err) {
            console.error("Error placing order:", err);
            alert("Failed to place order.");
        }
    } else {
        alert("Please fill out all fields.");
    }
};

fetchCartItems();
</script>

<template>
    <navbar />
    <div class="checkout-page container mx-auto p-8 space-y-10">
        <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-teal-500 via-indigo-500 to-purple-500 text-center">
            Complete Your Purchase
        </h1>

        <div class="grid lg:grid-cols-12 gap-10">
            <!-- Form Section -->
            <div class="lg:col-span-8">
                <div class="bg-white p-8 shadow-xl rounded-2xl">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Billing Information</h2>
                    <form @submit.prevent="placeOrder" class="space-y-6">
                        <!-- Full Name -->
                        <div>
                            <label for="fullName" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input
                                v-model="userInfo.fullName"
                                type="text"
                                id="fullName"
                                placeholder="Your Full Name"
                                class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500"
                            />
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input
                                v-model="userInfo.email"
                                type="email"
                                id="email"
                                placeholder="Your Email"
                                class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500"
                            />
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <input
                                v-model="userInfo.address"
                                type="text"
                                id="address"
                                placeholder="Your Address"
                                class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500"
                            />
                        </div>

                        <!-- City -->
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                            <input
                                v-model="userInfo.city"
                                type="text"
                                id="city"
                                placeholder="Your City"
                                class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500"
                            />
                        </div>

                        <!-- Zip Code -->
                        <div>
                            <label for="zipCode" class="block text-sm font-medium text-gray-700">ZIP Code</label>
                            <input
                                v-model="userInfo.zipCode"
                                type="text"
                                id="zipCode"
                                placeholder="Your ZIP Code"
                                class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500"
                            />
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                            <input
                                v-model="userInfo.phone"
                                type="text"
                                id="phone"
                                placeholder="Your Phone Number"
                                class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500"
                            />
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <label for="paymentMethod" class="block text-sm font-medium text-gray-700">Payment Method</label>
                            <select
                                v-model="userInfo.paymentMethod"
                                id="paymentMethod"
                                class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-teal-500 focus:border-teal-500"
                            >
                                <option value="credit_card">Credit Card</option>
                                <option value="paypal">PayPal</option>
                                <option value="bank_transfer">Bank Transfer</option>
                            </select>
                        </div>

                        <!-- Order Button -->
                        <button
                            type="submit"
                            class="w-full py-3 bg-gradient-to-r from-teal-500 to-green-400 text-white text-lg font-semibold rounded-lg shadow-lg hover:from-teal-600 hover:to-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-400"
                        >
                            Place Order
                        </button>
                    </form>
                </div>
            </div>

            <!-- Order Summary Section -->
            <div class="lg:col-span-4">
                <div class="bg-gradient-to-bl from-gray-100 to-gray-200 p-8 shadow-xl rounded-2xl">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Order Summary</h2>
                    <div class="space-y-6">
                        <div
                            v-for="item in cartItems"
                            :key="item.id"
                            class="flex justify-between items-center"
                        >
                            <div>
                                <h3 class="text-lg font-medium text-gray-700">{{ item.name }}</h3>
                                <p class="text-sm text-gray-500">
                                    {{ item.quantity }} × {{ formatCurrency(item.price) }}
                                </p>
                            </div>
                            <p class="text-lg font-medium text-gray-800">
                                {{ formatCurrency(item.price * item.quantity) }}
                            </p>
                        </div>
                    </div>
                    <hr class="my-4 border-dashed border-gray-300" />
                    <div class="flex justify-between font-semibold text-xl">
                        <span>Total:</span>
                        <span class="text-teal-500">{{ formatCurrency(calculateTotal()) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Footer />
</template>
