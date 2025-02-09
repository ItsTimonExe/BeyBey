<template>
    <AdminLayout>
        <CategoriesList :categories="categories" />
    </AdminLayout>
</template>

<script setup>
defineProps({
    categories: Array
});
import AdminLayout from '../Components/AdminLayout.vue';
import CategoriesList from './CategoriesList.vue';
</script>
