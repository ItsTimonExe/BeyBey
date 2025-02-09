<template>
    <AdminLayout>
        <ContactList :contacts="contacts" />
    </AdminLayout>
</template>

<script setup>
defineProps({
    contacts: Array
});
import AdminLayout from '../Components/AdminLayout.vue';
import ContactList from './ContactList.vue';
</script>
