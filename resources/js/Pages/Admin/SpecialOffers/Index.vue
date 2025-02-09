<template>
    <AdminLayout>
        <SpecialOffersList :specialOffers="specialOffers" />
    </AdminLayout>
</template>

<script setup>
defineProps({
    specialOffers: Array
});
import AdminLayout from '../Components/AdminLayout.vue';
import SpecialOffersList from './SpecialOffersList.vue';
</script>
