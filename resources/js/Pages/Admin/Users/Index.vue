<template>
    <AdminLayout>
        <UsersList :users="users" />
    </AdminLayout>
</template>

<script setup>
defineProps({
    users: Array
});
import AdminLayout from '../Components/AdminLayout.vue';
import UsersList from './UsersList.vue';
</script>
