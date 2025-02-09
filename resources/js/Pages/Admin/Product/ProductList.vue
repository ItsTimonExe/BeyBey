<template>
  <section class="p-6 bg-white rounded-lg shadow-md min-h-screen">
    <div class="container mx-auto">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Product Manager</h1>
      </div>
      <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
          <thead>
            <tr>
              <th class="px-5 py-3 bg-gray-200 text-gray-600 text-left text-sm uppercase font-semibold">Image</th>
              <th class="px-5 py-3 bg-gray-200 text-gray-600 text-left text-sm uppercase font-semibold">Name</th>
              <th class="px-5 py-3 bg-gray-200 text-gray-600 text-left text-sm uppercase font-semibold">Price</th>
              <th class="px-5 py-3 bg-gray-200 text-gray-600 text-left text-sm uppercase font-semibold">Category</th>
              <th class="px-5 py-3 bg-gray-200 text-gray-600 text-left text-sm uppercase font-semibold">Stock</th>
              <th class="px-5 py-3 bg-gray-200 text-gray-600 text-left text-sm uppercase font-semibold">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(product, index) in products" :key="product.id" class="border-b">
              <td class="px-5 py-5 bg-white text-sm">
                <img :src="`/${product.image}`" alt="Product Image" class="w-16 h-16 object-cover rounded-lg" />
              </td>
              <td class="px-5 py-5 bg-white text-sm">{{ product.name }}</td>
              <td class="px-5 py-5 bg-white text-sm">${{ product.price }}</td>
              <td class="px-5 py-5 bg-white text-sm">{{ product.category.name }}</td>
              <td class="px-5 py-5 bg-white text-sm">{{ product.stock }}</td>
              <td class="px-5 py-5 bg-white text-sm flex space-x-4">
                <button @click="openEditModal(product)" class="text-blue-600 hover:underline">Edit</button>
                <button @click="deleteProduct(product.id, index)" class="text-red-600 hover:underline">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <el-dialog v-model="dialogVisible" :title="editMode ? 'Edit Product' : 'Add Product'" width="30%">
        <div class="flex justify-between items-center mb-6">
            <h1 class="py-8 text-3xl font-bold text-gray-800">{{ editMode?" Edit Product":"Add Product" }}</h1>
            <button @click="openAddModal" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Add Product
            </button>
        </div>
      <form @submit.prevent="editMode ? updateProduct() : addProduct()" class="space-y-4">
        <div>
          <label for="product_name" class="block text-sm font-medium text-gray-700">Product Name</label>
          <input v-model="name" type="text" id="product_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required />
        </div>
        <div>
          <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
          <textarea v-model="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
        </div>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label for="price" class="block text-sm font-medium text-gray-700">Current Price</label>
            <input v-model="price" type="number" id="price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
          </div>
          <div>
            <label for="old_price" class="block text-sm font-medium text-gray-700">Old Price</label>
            <input v-model="old_price" type="number" id="old_price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
          </div>
        </div>
        <div>
          <label for="stock" class="block text-sm font-medium text-gray-700">Stock Quantity</label>
          <input v-model="stock" type="number" id="stock" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required />
        </div>
        <div>
          <label for="size" class="block text-sm font-medium text-gray-700">Size</label>
          <input v-model="size" type="text" id="size" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
        </div>
        <div>
          <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
          <select v-model="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
          </select>
        </div>
       <div v-if="editMode">
            <label for="image" class="block text-sm font-medium text-gray-700">Main Image</label>
            <img v-if="image" :src="image" alt="Current Image" class="w-16 h-16 object-cover rounded-lg mb-2" />
            <input type="checkbox" id="change_image" v-model="changeImage" />
            <label for="change_image" class="ml-2 text-sm text-gray-700">Change Image</label>
            <input v-if="changeImage" type="file" id="image" @change="handleImageUpload" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" />
          </div>
          <div v-else>
            <label for="image" class="block text-sm font-medium text-gray-700">Main Image</label>
            <input type="file" id="image" @change="handleImageUpload" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" />
          </div>
          <div v-if="editMode">
            <label for="hover_image" class="block text-sm font-medium text-gray-700">Hover Image</label>
            <img v-if="hover_image" :src="hover_image" alt="Current Hover Image" class="w-16 h-16 object-cover rounded-lg mb-2" />
            <input type="checkbox" id="change_hover_image" v-model="changeHoverImage" />
            <label for="change_hover_image" class="ml-2 text-sm text-gray-700">Change Hover Image</label>
            <input v-if="changeHoverImage" type="file" id="hover_image" @change="handleHoverImageUpload" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" />
          </div>
          <div v-else>
            <label for="hover_image" class="block text-sm font-medium text-gray-700">Hover Image</label>
            <input type="file" id="hover_image" @change="handleHoverImageUpload" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" />
          </div>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
          {{ editMode ? 'Update' : 'Submit' }}
        </button>
      </form>
    </el-dialog>
  </section>
</template>

<script setup>
import { ref } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import Swal from "sweetalert2";

defineProps({
  products: Array,
});

const categories = usePage().props.categories;

const isAddProduct = ref(false);
const editMode = ref(false);
const dialogVisible = ref(false);

const id = ref("");
const name = ref("");
const description = ref("");
const size = ref("");
const stock = ref(0);
const price = ref("");
const old_price = ref("");
const category_id = ref("");
const image = ref(null);
const hover_image = ref(null);
const changeImage = ref(false);
const changeHoverImage = ref(false);
const imageFile = ref(null);
const hoverImageFile = ref(null);

const resetFormData = () => {
  id.value = "";
  name.value = "";
  description.value = "";
  size.value = "";
  stock.value = 0;
  price.value = "";
  old_price.value = "";
  category_id.value = "";
  image.value = null;
  hover_image.value = null;
  changeImage.value = false;
  changeHoverImage.value = false;
  imageFile.value = null;
  hoverImageFile.value = null;
};

const openAddModal = () => {
  dialogVisible.value = true;
  editMode.value = false;
  resetFormData();
};

const openEditModal = (product) => {
  id.value = product.id;
  name.value = product.name;
  description.value = product.description;
  size.value = product.size;
  stock.value = product.stock;
  price.value = product.price;
  old_price.value = product.old_price;
  category_id.value = product.category_id;
  image.value = product.image ? `/${product.image}` : null;
  hover_image.value = product.hover_image ? `/${product.hover_image}` : null;
  editMode.value = true;
  isAddProduct.value = false;
  dialogVisible.value = true;
};

const handleImageUpload = (event) => {
  imageFile.value = event.target.files[0];
  image.value = URL.createObjectURL(imageFile.value);
};

const handleHoverImageUpload = (event) => {
  hoverImageFile.value = event.target.files[0];
  hover_image.value = URL.createObjectURL(hoverImageFile.value);
};

const addProduct = async () => {
  const formData = new FormData();
  formData.append("name", name.value);
  formData.append("description", description.value);
  formData.append("size", size.value);
  formData.append("stock", stock.value);
  formData.append("price", price.value);
  formData.append("old_price", old_price.value);
  formData.append("category_id", category_id.value);
  if (imageFile.value) formData.append("image", imageFile.value);
  if (hoverImageFile.value) formData.append("hover_image", hoverImageFile.value);

  try {
    await router.post(route('admin.products.store'), formData, {
      onSuccess: (page) => {
        Swal.fire({
          title: "ADD SUCCESSFUL",
          text: "Product has been added successfully!",
          icon: "success",
        }).then(() => {
          window.location.reload();
        });
        dialogVisible.value = false;
        resetFormData();
      },
    });
  } catch (err) {
    console.error(err);
  }
};

const updateProduct = async () => {
  const formData = new FormData();
  formData.append("name", name.value);
  formData.append("description", description.value);
  formData.append("size", size.value);
  formData.append("stock", stock.value);
  formData.append("price", price.value);
  formData.append("old_price", old_price.value);
  formData.append("category_id", category_id.value);
  formData.append("_method", "PUT");
  if (changeImage.value && imageFile.value) formData.append("image", imageFile.value);
  if (changeHoverImage.value && hoverImageFile.value) formData.append("hover_image", hoverImageFile.value);

  try {
    await router.post(route('admin.products.update', id.value), formData, {
      onSuccess: (page) => {
        Swal.fire({
          title: "UPDATE SUCCESSFUL",
          text: "Product has been updated successfully!",
          icon: "success",
        }).then(() => {
          window.location.reload();
        });
        dialogVisible.value = false;
        resetFormData();
      },
    });
  } catch (err) {
    console.error(err);
  }
};
const deleteProduct = (productId, index) => {
  Swal.fire({
    title: "Are you sure?",
    text: "This action cannot be undone!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: "No",
    confirmButtonText: "Yes, Delete!",
  }).then((result) => {
    if (result.isConfirmed) {
      router.delete(route('admin.products.destroy', productId), {
        onSuccess: (page) => {
          products.splice(index, 1);
          Swal.fire({
            toast: true,
            icon: "success",
            position: "top-end",
            showConfirmButton: false,
            timer: 1500,
            title: page.props.flash.success,
          }).then(() => {
              window.location.reload();
          });
        },
        onError: (errors) => {
          Swal.fire({
            toast: true,
            icon: "error",
            position: "top-end",
            showConfirmButton: false,
            timer: 1500,
            title: "Failed to delete product.",
          });
        }
      });
    }
  });
};
</script>
