<template>
    <ApexChart 
      type="bar"
      :options="options"
      :series="series"
      :height="height"
    />
  </template>
  
  <script setup>
  const props = defineProps({
    series: Array, // e.g., [{ name: 'Requisitions', data: [44, 55, 41] }]
    labels: Array, // e.g., ['Jan', 'Feb', 'Mar']
    height: {
      type: Number,
      default: 350
    }
  });
  
  const options = {
    chart: {
      type: 'bar',
      toolbar: { show: true }
    },
    plotOptions: {
      bar: { horizontal: false }
    },
    xaxis: {
      categories: props.labels
    },
    colors: ['#3B82F6', '#10B981'], // Tailwind blue/green
    dataLabels: { enabled: false }
  };
  </script>