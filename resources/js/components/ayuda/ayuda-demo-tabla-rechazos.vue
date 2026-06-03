<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Ejemplo: tabla de índices de rechazos por diámetro</div>
        <table class="ayuda_demo_table table table-striped">
            <thead>
                <tr>
                    <th>Diámetro</th>
                    <th class="text-center">Aprobados</th>
                    <th class="text-center">Rechazados</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">% Rechazo</th>
                    <th class="text-center">Placas rechazadas</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row, i) in filas" :key="i">
                    <td><strong>{{ row.diametro }}</strong></td>
                    <td class="text-center">{{ row.aprobados }}</td>
                    <td class="text-center">{{ row.rechazados }}</td>
                    <td class="text-center">{{ row.total }}</td>
                    <td class="text-center">
                        <span class="ayuda_demo_badge" :class="badgeClass(row.porcentaje)">
                            {{ row.porcentaje }}%
                        </span>
                    </td>
                    <td class="text-center">{{ row.placas_rech }}</td>
                </tr>
                <tr class="ayuda_demo_total_row">
                    <td><strong>Totales</strong></td>
                    <td class="text-center"><strong>{{ totales.aprobados }}</strong></td>
                    <td class="text-center"><strong>{{ totales.rechazados }}</strong></td>
                    <td class="text-center"><strong>{{ totales.total }}</strong></td>
                    <td class="text-center">
                        <strong>{{ totales.porcentaje }}%</strong>
                    </td>
                    <td class="text-center"><strong>{{ totales.placas_rech }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-tabla-rechazos',
    data() {
        return {
            filas: [
                { diametro: '4"',  aprobados: 85, rechazados: 6,  total: 91,  porcentaje: 6.59,  placas_rech: 8 },
                { diametro: '6"',  aprobados: 124, rechazados: 9, total: 133, porcentaje: 6.77,  placas_rech: 12 },
                { diametro: '8"',  aprobados: 67, rechazados: 4,  total: 71,  porcentaje: 5.63,  placas_rech: 5 },
                { diametro: '12"', aprobados: 42, rechazados: 5,  total: 47,  porcentaje: 10.64, placas_rech: 7 },
            ],
        };
    },
    computed: {
        totales() {
            const sum = (k) => this.filas.reduce((a, r) => a + r[k], 0);
            const aprobados = sum('aprobados');
            const rechazados = sum('rechazados');
            const total = sum('total');
            return {
                aprobados,
                rechazados,
                total,
                placas_rech: sum('placas_rech'),
                porcentaje: parseFloat((rechazados * 100 / total).toFixed(2)),
            };
        },
    },
    methods: {
        badgeClass(p) {
            if (p < 5) return 'ayuda_demo_badge--success';
            if (p < 10) return 'ayuda_demo_badge--warning';
            return 'ayuda_demo_badge--danger';
        },
    },
};
</script>

<style scoped>
.ayuda_demo_block {
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
.ayuda_demo_table th {
    background: #f8fafc;
    color: #4c5661;
    font-size: 13px;
    font-weight: 700;
}
.ayuda_demo_table td {
    font-size: 13px;
}
.ayuda_demo_total_row {
    background: #f0f4f8 !important;
}
.ayuda_demo_badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
}
.ayuda_demo_badge--success { background: #dff0d8; color: #2c7a2c; }
.ayuda_demo_badge--warning { background: #fff3cd; color: #8a6d3b; }
.ayuda_demo_badge--danger  { background: #f8d7da; color: #a94442; }
</style>
