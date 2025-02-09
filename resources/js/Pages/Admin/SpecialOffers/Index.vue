<template>
    <AdminLayout>
        <SpecialOffersList :SpecialOffers="SpecialOffers" />
    </AdminLayout>
</template>

<script setup>
defineProps({
    SpecialOffers: Array
});
import AdminLayout from '../Components/AdminLayout.vue';
import SpecialOffersList from './SpecialOffersList.vue';
</script>
