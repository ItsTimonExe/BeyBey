<script setup>
import { defineEmits } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

defineProps({
    categories: Array
});

const emit = defineEmits(['edit']);
const form = useForm();

const deleteCategory = (id) => {
    Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('admin.categories.destroy', id), {
                onSuccess: () => {
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Category has been deleted.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                }
            });
            window.location.reload();
        }
    });
};
</script>

<template>
    <div class="container mx-auto p-6 min-h-screen bg-gray-100">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600">ID</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600">Name</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="category in categories" :key="category.id" class="border-t border-gray-200">
                    <td class="py-3 px-4 text-sm text-gray-700">{{ category.id }}</td>
                    <td class="py-3 px-4 text-sm text-gray-700">{{ category.name }}</td>
                    <td class="py-3 px-4 text-sm">
                        <button @click="emit('edit', category)" class="text-blue-500 hover:underline">Edit</button>
                        <button @click="deleteCategory(category.id)" class="text-red-500 hover:underline ml-2">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
