<template>
    <div>
      <vue-good-table
        :columns="columns"
        :rows="rows"
        :sort-options="{ enabled: true }"
        :pagination-options="{ enabled: true }"
      >
        <!-- Optional: Customize status colors -->
        <template #table-row="props">
          <span v-if="props.column.field === 'status'" :class="`status-${props.row.status}`">
            {{ props.row.status }}
          </span>
          <span v-else>
            {{ props.formattedRow[props.column.field] }}
          </span>
        </template>
      </vue-good-table>
    </div>
  </template>
  
  <script>
  import 'vue-good-table/dist/vue-good-table.css';
  import { VueGoodTable } from 'vue-good-table';
  
  export default {
    components: { VueGoodTable },
    data() {
      return {
        columns: [
          { label: 'Status', field: 'status' },
          { label: '#Today', field: 'today' },
          { label: '#This Week', field: 'week' },
          { label: '#This Month', field: 'month' },
          { label: '#This Year', field: 'year' },
        ],
        rows: [
          { status: 'Active', today: 5, week: 25, month: 100, year: 1200 },
          { status: 'Inactive', today: 2, week: 10, month: 30, year: 400 },
          // Add more dummy data or fetch from an API
        ],
      };
    },
  };
  </script>
  
  <style>
  /* Add status color styling */
  .status-Active { color: green; }
  .status-Inactive { color: red; }
  </style>