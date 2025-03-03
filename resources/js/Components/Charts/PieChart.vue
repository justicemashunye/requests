<template>
  <div class="chart-container">
    <canvas ref="chart"></canvas>
  </div>
</template>

<script setup>
import { ref, onMounted, watch, onBeforeUnmount } from 'vue';
import { Chart } from 'chart.js/auto'; // Auto-registers everything

const props = defineProps({
  datasets: { type: Array, required: true },
  labels: { type: Array, required: true },
  title: String,
  statusLabels: Object
});

const chart = ref(null);
let chartInstance = null; // <-- Keep this declaration

const renderChart = () => {
  if (!chart.value) return;
  if (chartInstance) chartInstance.destroy();

  const ctx = chart.value.getContext('2d');
  
  chartInstance = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: props.labels?.map(label => props.statusLabels?.[label] || label) || [],
      datasets: props.datasets || []
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        title: { display: !!props.title, text: props.title },
        legend: { position: 'bottom' }
      }
    }
  });
};

onMounted(renderChart);
watch(() => [props.datasets, props.labels], renderChart, { deep: true });


onBeforeUnmount(() => {
  if (chartInstance) {
    chartInstance.destroy();
    chartInstance = null; 
  }
});
</script>

<style scoped>
.chart-container {
  position: relative;
  width: 100%;
  height: 300px;
  margin: 0 auto;
}

.chart-container canvas {
  position: absolute;
  left: 0;
  top: 0;
  width: 100% !important;
  height: 100% !important;
}
</style>