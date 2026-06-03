<template>
    <div class="ayuda_demo_chart">
        <div class="ayuda_demo_label">Ejemplo: gráfico de aprobados vs rechazados</div>
        <div class="ayuda_demo_chart_wrap">
            <pie-chart :chart-data="chartData" :options="chartOptions" />
        </div>
    </div>
</template>

<script>
import PieChart from '../chart.js/PieChart.js';

export default {
    name: 'ayuda-demo-grafico-pie',
    components: { PieChart },
    data() {
        return {
            chartData: {
                labels: ['Aprobados', 'Rechazados'],
                datasets: [
                    {
                        data: [318, 24],
                        backgroundColor: ['#5cb85c', '#d9534f'],
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
                    text: 'Distribución de soldaduras',
                    fontSize: 14,
                },
                tooltips: {
                    callbacks: {
                        label: function (item, data) {
                            const value = data.datasets[0].data[item.index];
                            const label = data.labels[item.index];
                            const total = data.datasets[0].data.reduce((a, b) => a + b, 0);
                            const pct = ((value * 100) / total).toFixed(1);
                            return label + ': ' + value + ' (' + pct + '%)';
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
    height: 280px;
    width: 100%;
    background: #fff;
    border: 1px solid #e6eaf0;
    border-radius: 10px;
    padding: 12px;
    box-sizing: border-box;
    overflow: hidden;
}
.ayuda_demo_chart_wrap ::v-deep > div {
    position: absolute !important;
    top: 12px;
    left: 12px;
    right: 12px;
    bottom: 12px;
    height: auto !important;
    width: auto !important;
}
.ayuda_demo_chart_wrap ::v-deep canvas {
    max-height: 100% !important;
    max-width: 100% !important;
}
@media (max-width: 600px) {
    .ayuda_demo_chart_wrap {
        height: 220px;
        padding: 8px;
    }
    .ayuda_demo_chart_wrap ::v-deep > div {
        top: 8px;
        left: 8px;
        right: 8px;
        bottom: 8px;
    }
}
</style>
