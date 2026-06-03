<template>
    <div class="ayuda_demo_chart">
        <div class="ayuda_demo_label">Ejemplo: defectos por posición horaria</div>
        <div class="ayuda_demo_chart_wrap">
            <doughnut-chart :chart-data="chartData" :options="chartOptions" />
        </div>
    </div>
</template>

<script>
import DoughnutChart from '../chart.js/DoughnutChart.js';

export default {
    name: 'ayuda-demo-grafico-doughnut',
    components: { DoughnutChart },
    data() {
        return {
            chartData: {
                labels: ['0-90', '90-180', '180-270', '270-360'],
                datasets: [
                    {
                        data: [7, 3, 5, 9],
                        backgroundColor: ['#4472C4', '#5BC0DE', '#F0AD4E', '#5CB85C'],
                        borderColor: '#fff',
                        borderWidth: 2,
                    },
                ],
            },
            chartOptions: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                    labels: { fontSize: 13 },
                },
                title: {
                    display: true,
                    text: 'Defectos por posición (diámetro 6")',
                    fontSize: 14,
                },
                tooltips: {
                    callbacks: {
                        label: function (item, data) {
                            const value = data.datasets[0].data[item.index];
                            const label = data.labels[item.index];
                            const total = data.datasets[0].data.reduce((a, b) => a + b, 0);
                            const pct = ((value * 100) / total).toFixed(1);
                            return label + ': ' + value + ' defectos (' + pct + '%)';
                        },
                    },
                },
            },
        };
    },
};
</script>

<style scoped>
.ayuda_demo_chart {
    margin: 12px 0 20px;
}
.ayuda_demo_label {
    font-size: 12px;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 8px;
    font-weight: 600;
}
.ayuda_demo_chart_wrap {
    position: relative;
    height: 260px;
    width: 100%;
    background: #fff;
    border: 1px solid #e6eaf0;
    border-radius: 10px;
    padding: 12px;
    box-sizing: border-box;
}
.ayuda_demo_chart_wrap >>> canvas {
    max-height: 100% !important;
    max-width: 100% !important;
}
</style>
