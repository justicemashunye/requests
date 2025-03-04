<template>
    <div class="m-10">
      <!-- Heading -->
      <h2 class="mb-6 text-center text-2xl font-bold text-gray-800">
        {{ $page.props.auth.user.name }} {{ currentYear }} Requisitions
      </h2>
  
      <!-- Table -->
      <EasyDataTable
        :headers="headers"
        :items="requisitions"
        :rows-per-page="5"
         :style="{ backgroundColor: 'red' }"
        tableClassName="customize-table bg-red-500"
        headerClassName="customize-header"
        bodyClassName="customize-body"

      >
        <!-- Customize the `created_at` column using the body slot -->
        <template #item-created_at="{ created_at }">
          <span class="text-sm text-gray-600">
            {{ formatDate(created_at) }}
          </span>
        </template>
      </EasyDataTable>
    </div>
  </template>
  
  <script setup>
import { defineProps } from 'vue';
import EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';

const props = defineProps({
  requisitions: Array,
});

const currentYear = new Date().getFullYear();

const headers = [
  { text: 'Type of Product', value: 'typeOfProduct' },
  { text: 'Name of Product', value: 'nameOfProduct' },
  { text: 'Description', value: 'description' },
  { text: 'Quantity', value: 'quantity' },
  { text: 'Purpose', value: 'purpose' },
  { text: 'Urgency', value: 'urgency' },
  { text: 'Status', value: 'status' },
  { text: 'Created At', value: 'created_at', sortable: true },
];


const formatDate = (date) => new Date(date).toLocaleString();
</script>

<style scoped>

.customize-table {
  @apply w-full rounded-lg shadow-sm overflow-hidden;
}

/* Customize the table header */
.customize-header {
  @apply bg-gradient-to-r from-blue-500 to-blue-600 text-white;
}

/* Customize the table header cells */
.customize-header th {
  @apply px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider;
}

/* Customize the table body */
.customize-body {
  @apply bg-white divide-y divide-gray-200;
}

/* Customize the table body rows */
.customize-body tr {
  @apply hover:bg-gray-50 transition-colors;
}

/* Customize the table body cells */
.customize-body td {
  @apply px-6 py-4 text-sm text-gray-700;
}

/* Customize the "Created At" column */
.customize-body td:last-child {
  @apply text-gray-600;
}
</style>