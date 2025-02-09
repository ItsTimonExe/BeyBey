<template>
    <AdminLayout>
        <SalesList :Sales="Sales" />
    </AdminLayout>
</template>

<script setup>
defineProps({
    Sales: Array
});
import AdminLayout from '../Components/AdminLayout.vue';
import SalesList from './SalesList.vue';
</script>
