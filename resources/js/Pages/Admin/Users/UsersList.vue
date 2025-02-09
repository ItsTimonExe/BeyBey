<template>
  <div class="p-6 min-h-screen bg-white rounded-lg shadow-md">
    <h1 class="text-3xl font-bold mb-6 text-gray-700 text-center">Users List</h1>
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
      <table class="min-w-full bg-white">
        <thead >
          <tr>
            <th class="w-1/4 px-8 py-5 bg-gray-200 text-gray-600 text-left text-sm uppercase font-semibold">ID</th>
            <th class="w-1/4 px-8 py-5 bg-gray-200 text-gray-600 text-left text-sm uppercase font-semibold">Name</th>
            <th class="w-1/4 px-8 py-5 bg-gray-200 text-gray-600 text-left text-sm uppercase font-semibold">Email</th>
            <th class="w-1/4 px-8 py-5 bg-gray-200 text-gray-600 text-left text-sm uppercase font-semibold">Is Admin</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          <tr v-for="user in users" :key="user.id" class="hover:bg-gray-100 transition duration-200">
            <td class="w-1/4 py-5 px-8 border-b border-gray-200">{{ user.id }}</td>
            <td class="w-1/4 py-5 px-8 border-b border-gray-200">{{ user.name }}</td>
            <td class="w-1/4 py-5 px-8 border-b border-gray-200">{{ user.email }}</td>
            <td class="w-1/4 py-5 px-8 border-b border-gray-200">{{ user.isAdmin ? 'Yes' : 'No' }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
defineProps({
  users: Array
});
</script>

<style scoped>
/* No additional styles needed as Tailwind CSS is used */
</style>
