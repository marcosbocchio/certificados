<template>
    <div class="ayuda_demo_chart">
        <div class="ayuda_demo_label">Ejemplo: tipos de defecto del soldador seleccionado</div>
        <div class="ayuda_demo_chart_wrap">
            <bar-chart :chart-data="chartData" :options="chartOptions" />
        </div>
    </div>
</template>

<script>
import BarChart from '../chart.js/BarChart.js';

export default {
    name: 'ayuda-demo-grafico-barras',
    components: { BarChart },
    data() {
        return {
            chartData: {
                labels: ['FF', 'P', 'I', 'F', 'NP'],
                datasets: [
                    {
                        label: 'Cantidad de defectos',
                        data: [4, 2, 1, 1, 1],
                        backgroundColor: 'rgba(153, 102, 255, 0.3)',
                        borderColor: 'rgb(153, 102, 255)',
                        borderWidth: 1,
                    },
                ],
            },
            chartOptions: {
                responsive: true,
                maintainAspectRatio: false,
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Defectos producción - W-12 - Wilson Pérez',
                    fontSize: 14,
                },
                scales: {
                    yAxes: [{
                        ticks: { beginAtZero: true, stepSize: 1 },
                    }],
                },
                tooltips: {
                    callbacks: {
                        label: function (item) {
                            const desc = {
                                FF: 'Falta de fusión',
                                P:  'Porosidad',
                                I:  'Inclusión',
                                F:  'Fisura',
                                NP: 'Nido de poros',
                            };
                            return desc[item.xLabel] + ': ' + item.yLabel;
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
