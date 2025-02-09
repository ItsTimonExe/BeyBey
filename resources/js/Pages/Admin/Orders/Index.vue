<template>
    <AdminLayout>
        <OrdersList :orders="orders" />
    </AdminLayout>
</template>

<script setup>
defineProps({
    orders: Array
});
import AdminLayout from '../Components/AdminLayout.vue';
import OrdersList from './OrdersList.vue';
</script>
