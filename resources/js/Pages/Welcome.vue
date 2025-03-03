<template>
    <div class="home-page">
      
      <div class="column left-column">
        User information
        <status-reports-table/>
      </div>
  
      <!-- Right Column: Department Reports -->
      <div class="column right-column">
        Department Inform
        <department-reports />
      </div>
    </div>
  </template>
  
  <script setup>
    import StatusReportsTable from '@/Pages/Reports/StatusReportsTable.vue';
</script>



  <style>
  .home-page {
    display: grid;
    grid-template-columns: 1fr 1fr; /* Equal columns */
    gap: 20px; /* Spacing between columns */
    padding: 20px;
  }
  </style>