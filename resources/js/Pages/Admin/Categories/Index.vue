<!-- resources/js/Pages/Admin/Categories/Index.vue -->
<template>
    <AdminLayout>
        <div class="p-6 bg-white rounded-lg shadow-md">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">Categories</h1>
            <form @submit.prevent="submitForm" class="mb-6">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" v-model="form.name" id="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
                </div>
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-600">{{ form.id ? 'Update' : 'Add' }} Category</button>
            </form>
            <CategoriesList :categories="categories" @edit="editCategory" />
        </div>
    </AdminLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import AdminLayout from '../Components/AdminLayout.vue';
import CategoriesList from './CategoriesList.vue';

const { props } = usePage();
const categories = props.categories;
const form = useForm({
    id: null,
    name: '',
});

const submitForm = () => {
    if (!form.name) {
        Swal.fire({
            title: 'Error',
            text: 'Category name cannot be empty!',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        return;
    }

    if (form.id) {
        form.put(route('admin.categories.update', form.id), {
            onSuccess: () => {
                Swal.fire({
                    title: 'Success',
                    text: 'Category updated successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.reload();
                });
                const index = categories.findIndex(category => category.id === form.id);
                if (index !== -1) {
                    categories[index] = { ...form };
                }
                form.reset();
            },
            onError: (errors) => {
                if (errors.name) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Category name already exists!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    } else {
        form.post(route('admin.categories.store'), {
            onSuccess: (response) => {
                Swal.fire({
                    title: 'Success',
                    text: 'Category added successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.reload();
                });
                categories.push(response.data);
                form.reset();
            },
            onError: (errors) => {
                if (errors.name) {
                    Swal.fire({
                        title: 'Error',
                        text: 'Category name already exists!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    }
};

const editCategory = (category) => {
    form.id = category.id;
    form.name = category.name;
};
</script>
