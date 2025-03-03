<template>
    <div class="p-6 bg-gray-100 min-h-screen">
      <h1 class="text-3xl font-bold text-center mb-6 text-gray-800">Programs</h1>
      <ul class="space-y-4">
        <li
          v-for="program in programs"
          :key="program.id"
          class="text-center p-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300"
        >
          <span class="text-lg font-semibold text-gray-700">
            {{ program.program_number }}
          </span>
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      programs: Array,
    },
  };
  </script>