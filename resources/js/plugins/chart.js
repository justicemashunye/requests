import { Chart, registerables } from 'chart.js';


Chart.register(...registerables);


Chart.defaults.font.family = 'Clash Grotesk';

export default Chart;