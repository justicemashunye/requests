import ApexCharts from 'apexcharts';
import VueApexCharts from 'vue3-apexcharts';


export default (app) => {
  app.use(VueApexCharts);
  app.component('ApexChart', VueApexCharts);
  app.config.globalProperties.$apexcharts = ApexCharts;
};