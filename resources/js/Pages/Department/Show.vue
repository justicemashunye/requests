<script setup>
import { Link } from '@inertiajs/vue3'; // Import the Link component for navigation

// Define the department prop
const props = defineProps({
    department: Object,
});
</script>

<template>
    <div>
        <h1 class="text-2xl font-bold mb-4">Department Details</h1>

        <!-- Display department details -->
        <tr>
  <td class="px-4 py-2">{{ department.id }}</td>
  <td class="px-4 py-2">{{ department.name }}</td>
  <td class="px-4 py-2">{{ department.program.name }}</td>
</tr>

        <!-- Back button using the Link component -->
        <Link href="/departments" class="mt-4 inline-block text-blue-500 hover:underline">
            Back to Departments
        </Link>
    </div>
</template>