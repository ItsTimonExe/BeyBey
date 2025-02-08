<script setup>
import {ref} from "vue";
import {useRouter} from "vue-router";
import Footer from "../components/footer.vue";
import navbar from "../components/navBar.vue";

// Données des articles du panier (réactif)
const cartItems = ref([
    {
        id: 1,
        name: "Product 1",
        price: 29.99,
        quantity: 2,
        image: new URL("../assets/image/t1-h.jpg", import.meta.url).href,
    },
    {
        id: 2,
        name: "Product 2",
        price: 49.99,
        quantity: 1,
        image: new URL("../assets/image/t8-h.jpg", import.meta.url).href,
    },
    {
        id: 3,
        name: "Product 3",
        price: 19.99,
        quantity: 3,
        image: new URL("../assets/image/t5-h.jpg", import.meta.url).href,
    },
]);

const discountCode = ref(""); // Code promo entré par l'utilisateur
const isCodeApplied = ref(false); // Indique si le code promo est valide
const discountValue = ref(0); // Valeur de la remise
const showDiscountMessage = ref(false); // Contrôle l'affichage des messages de remise

// Fonction pour formater les montants
const formatCurrency = (value) => {
    return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
    }).format(value);
};

// Calculer le sous-total
const calculateSubtotal = () => {
    return cartItems.value.reduce(
        (total, item) => total + item.price * item.quantity,
        0
    );
};

// Calculer les taxes
const calculateTaxes = () => {
    return calculateSubtotal() * 0.1; // Supposons un taux de taxes à 10%
};

// Calculer le total après remise
const calculateTotal = () => {
    return calculateSubtotal() + calculateTaxes() - discountValue.value;
};

// Appliquer un code promo
const applyDiscountCode = () => {
    showDiscountMessage.value = true; // Permet d'afficher les messages après clic sur le bouton
    if (discountCode.value === "PROMO10") {
        discountValue.value = calculateSubtotal() * 0.1; // Réduction de 10%
        isCodeApplied.value = true;
    } else {
        discountValue.value = 0;
        isCodeApplied.value = false;
    }
};

// Rafraîchir le panier après chaque modification
const refreshCart = () => {
    applyDiscountCode(); // Réapplique la remise lors du rafraîchissement
};

// Supprimer un article du panier
const removeItem = (id) => {
    cartItems.value = cartItems.value.filter((item) => item.id !== id);
    refreshCart(); // Met à jour le panier après suppression
};

// Modifier la quantité d'un produit
const updateQuantity = (item, change) => {
    item.quantity += change;
    if (item.quantity < 1) {
        removeItem(item.id); // Supprime l'article si quantité devient 0
    } else {
        refreshCart(); // Rafraîchit le panier sinon
    }
};

// Rediriger vers la page de paiement
const router = useRouter();
const goToCheckout = () => {
    router.push("/checkout");
};
</script>

<template>
    <navbar />
    <div class="container mx-auto max-w-7xl p-6 space-y-12">
        <!-- Titre de la page -->
        <h1 class="text-4xl font-semibold text-center text-gray-800 tracking-wide">
            My Cart
        </h1>

        <!-- Contenu principal -->
        <div v-if="cartItems.length > 0" class="grid lg:grid-cols-12 gap-8">
            <!-- Liste des produits -->
            <div class="lg:col-span-8 space-y-8">
                <div
                    v-for="item in cartItems"
                    :key="item.id"
                    class="flex items-center bg-white border border-gray-200 rounded-lg shadow-sm px-4 transition hover:shadow-md"
                >
                    <!-- Image du produit -->
                    <div class="w-[140px] h-[140px] rounded-lg overflow-hidden flex-shrink-0">
                        <img
                            :src="item.image"
                            :alt="item.name"
                            class="w-full h-full object-cover"
                        />
                    </div>

                    <!-- Détails du produit -->
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
                            @click="removeItem(item.id)"
                            class="flex items-center justify-center w-8 h-8 bg-red-100 text-red-500 rounded-full hover:bg-red-200 transition"
                        >
                            ✕
                        </button>
                    </div>
                </div>
            </div>

            <!-- Section Résumé -->
            <div class="lg:col-span-4 p-6 bg-gray-50 rounded-xl shadow-sm border border-gray-200 space-y-6">
                <h2 class="text-lg font-medium text-gray-800 text-center">
                    Order Summary
                </h2>

                <!-- Liste des produits récapitulatifs -->
                <div
                    v-for="item in cartItems"
                    :key="item.id"
                    class="flex justify-between items-center text-sm text-gray-600"
                >
                    <span>{{ item.name }} (x{{ item.quantity }})</span>
                    <span class="font-medium">{{ formatCurrency(item.price * item.quantity) }}</span>
                </div>

                <hr class="border-gray-300" />

                <!-- Totaux et réductions -->
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

                <!-- Champ Promo -->
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

                <button
                    @click="goToCheckout"
                    class="w-full py-3 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition"
                >
                    Go to Checkout
                </button>
            </div>
        </div>

        <!-- Message si panier vide -->
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
