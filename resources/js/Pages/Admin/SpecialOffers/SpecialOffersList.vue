<template>
  <section class="p-6 bg-white rounded-lg shadow-md min-h-screen">
    <div class="container mx-auto">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Special Offers Manager</h1>
      </div>
      <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
          <thead>
            <tr>
              <th class="px-5 py-3 bg-gray-200 text-gray-600 text-left text-sm uppercase font-semibold">Image</th>
              <th class="px-5 py-3 bg-gray-200 text-gray-600 text-left text-sm uppercase font-semibold">Title</th>
              <th class="px-5 py-3 bg-gray-200 text-gray-600 text-left text-sm uppercase font-semibold">Description</th>
              <th class="px-5 py-3 bg-gray-200 text-gray-600 text-left text-sm uppercase font-semibold">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(offer, index) in specialOffers" :key="offer.id" class="border-b">
              <td class="px-5 py-5 bg-white text-sm">
                <img :src="`/${offer.image}`" alt="Offer Image" class="w-16 h-16 object-cover rounded-lg" />
              </td>
              <td class="px-5 py-5 bg-white text-sm">{{ offer.title }}</td>
              <td class="px-5 py-5 bg-white text-sm">{{ offer.description }}</td>
              <td class="px-5 py-5 bg-white text-sm flex space-x-4">
                <button @click="openEditModal(offer)" class="text-blue-600 hover:underline">Edit</button>
                <button @click="deleteSpecialOffer(offer.id, index)" class="text-red-600 hover:underline">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <el-dialog v-model="dialogVisible" :title="editMode ? 'Edit Special Offer' : 'Add Special Offer'" width="30%">
        <div class="flex justify-between items-center mb-6">
            <h1 class="py-8 text-3xl font-bold text-gray-800">{{ editMode?" Edit Special Offer":"Add Special Offer" }}</h1>
            <button @click="openAddModal" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                Add Special Offer
            </button>
        </div>
        <form @submit.prevent="editMode ? updateSpecialOffer() : addSpecialOffer()" class="space-y-4">
        <div>
          <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
          <input v-model="title" type="text" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required />
        </div>
        <div>
          <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
          <textarea v-model="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
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
          <input type="file" id="image" @change="handleImageUpload" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" required />
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
import { router } from "@inertiajs/vue3";
import Swal from "sweetalert2";

defineProps({
  specialOffers: Array,
});

const dialogVisible = ref(false);
const editMode = ref(false);

const id = ref("");
const title = ref("");
const description = ref("");
const image = ref(null);
const changeImage = ref(false);
const imageFile = ref(null);

const resetFormData = () => {
  id.value = "";
  title.value = "";
  description.value = "";
  image.value = null;
  changeImage.value = false;
  imageFile.value = null;
};

const openAddModal = () => {
  dialogVisible.value = true;
  editMode.value = false;
  resetFormData();
};

const openEditModal = (offer) => {
  id.value = offer.id;
  title.value = offer.title;
  description.value = offer.description;
  image.value = offer.image ? `/${offer.image}` : null;
  editMode.value = true;
  dialogVisible.value = true;
};

const handleImageUpload = (event) => {
  imageFile.value = event.target.files[0];
  image.value = URL.createObjectURL(imageFile.value);
};

const addSpecialOffer = async () => {
  const formData = new FormData();
  formData.append("title", title.value);
  formData.append("description", description.value);
  if (imageFile.value) formData.append("image", imageFile.value);

  try {
    await router.post(route('admin.special_offers.store'), formData, {
      onSuccess: (page) => {
        Swal.fire({
          title: "ADD SUCCESSFUL",
          text: "Special offer has been added successfully!",
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

const updateSpecialOffer = async () => {
  const formData = new FormData();
  formData.append("title", title.value);
  formData.append("description", description.value);
  formData.append("_method", "PUT");
  if (changeImage.value && imageFile.value) formData.append("image", imageFile.value);

  try {
    await router.post(route('admin.special_offers.update', id.value), formData, {
      onSuccess: (page) => {
        Swal.fire({
          title: "UPDATE SUCCESSFUL",
          text: "Special offer has been updated successfully!",
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

const deleteSpecialOffer = (offerId, index) => {
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
      router.delete(route('admin.special_offers.destroy', offerId), {
        onSuccess: (page) => {
          specialOffers.splice(index, 1);
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
            title: "Failed to delete special offer.",
          });
        }
      });
    }
  });
};
</script>

<style scoped>
/* Add your styles here */
</style>
