<template>
  <div class="  p-6 min-h-screen bg-white rounded-lg shadow-md">
    <h1 class="text-3xl font-bold mb-6 text-gray-700 text-center">Contact List</h1>
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
      <table class="min-w-full bg-white">
        <thead class="bg-gradient-to-r from-blue-500 to-purple-600 text-white">
          <tr>
            <th class="w-1/3 py-5 px-8 uppercase font-semibold text-sm text-left">Name</th>
            <th class="w-1/3 py-5 px-8 uppercase font-semibold text-sm text-left">Email</th>
            <th class="w-1/3 py-5 px-8 uppercase font-semibold text-sm text-left">Message</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          <tr v-for="contact in contacts" :key="contact.id" class="hover:bg-gray-100 transition duration-200">
            <td class="w-1/3 py-5 px-8 border-b border-gray-200">{{ contact.name }}</td>
            <td class="w-1/3 py-5 px-8 border-b border-gray-200">{{ contact.email }}</td>
            <td class="w-1/3 py-5 px-8 border-b border-gray-200">{{ contact.message }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
defineProps({
  contacts: Array
});
</script>
