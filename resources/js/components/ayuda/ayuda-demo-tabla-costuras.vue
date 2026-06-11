<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Ejemplo: tabla de resultados del seguimiento de costuras</div>
        <table class="ayuda_demo_table table table-striped">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Informe Nº</th>
                    <th>Costura</th>
                    <th>Línea</th>
                    <th>Plano Isométrico</th>
                    <th class="text-center">Aprob.</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row, i) in filas" :key="i">
                    <td>{{ row.fecha }}</td>
                    <td><span class="ayuda_demo_link">{{ row.informe }}</span></td>
                    <td>
                        <strong>{{ row.costura }}</strong>
                        <span v-if="row.costura.endsWith('R')" class="ayuda_demo_rep_tag">reparación</span>
                    </td>
                    <td>{{ row.linea }}</td>
                    <td>
                        <strong v-if="row.hoja" :title="'Hoja: '+ row.hoja">{{ row.plano }}</strong>
                        <span v-else>{{ row.plano }}</span>
                    </td>
                    <td class="text-center">
                        <span class="ayuda_demo_badge" :class="row.aprobado ? 'ayuda_demo_badge--success' : 'ayuda_demo_badge--danger'">
                            {{ row.aprobado ? 'SI' : 'NO' }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="ayuda_demo_caption">
            Datos de ejemplo — el número de informe es un link al informe real. La costura J15 fue rechazada el 12/05
            y su reparación (J15R) aprobada el 20/05. Los planos en <strong>negrita</strong> tienen número de hoja — pasá el mouse para verlo.
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-tabla-costuras',
    data() {
        return {
            filas: [
                { fecha: '20/05/2026', informe: 'RD0034',          costura: 'J15R', linea: 'L-104', plano: 'ISO-PL-0245', hoja: '2',  aprobado: true },
                { fecha: '12/05/2026', informe: 'RD0028',          costura: 'J15',  linea: 'L-104', plano: 'ISO-PL-0245', hoja: '2',  aprobado: false },
                { fecha: '12/05/2026', informe: 'RD0028',          costura: 'J14',  linea: 'L-104', plano: 'ISO-PL-0245', hoja: '1',  aprobado: true },
                { fecha: '08/05/2026', informe: '125-PT-RI0019',   costura: 'K221', linea: 'L-090', plano: 'ISO-DC-0090', hoja: null, aprobado: true },
                { fecha: '08/05/2026', informe: '125-PT-RI0019',   costura: 'K220', linea: 'L-090', plano: 'ISO-DC-0090', hoja: null, aprobado: true },
            ],
        };
    },
};
</script>

<style scoped>
.ayuda_demo_block {
    margin: 12px 0 20px;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}
.ayuda_demo_label {
    font-size: 12px;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 8px;
    font-weight: 600;
}
.ayuda_demo_table {
    min-width: 560px;
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
.ayuda_demo_link {
    color: #2e86c1;
    text-decoration: underline;
    cursor: not-allowed;
}
.ayuda_demo_rep_tag {
    display: inline-block;
    margin-left: 6px;
    padding: 1px 7px;
    border-radius: 999px;
    background: #fff3cd;
    color: #8a6d3b;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
}
.ayuda_demo_badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 700;
}
.ayuda_demo_badge--success { background: #dff0d8; color: #2c7a2c; }
.ayuda_demo_badge--danger  { background: #f8d7da; color: #a94442; }
.ayuda_demo_caption {
    margin-top: 6px;
    font-size: 11px;
    color: #9ca3af;
    font-style: italic;
}

@media (max-width: 600px) {
    .ayuda_demo_table th,
    .ayuda_demo_table td {
        font-size: 12px;
        padding: 6px 4px;
    }
    .ayuda_demo_badge {
        font-size: 10px;
        padding: 2px 6px;
    }
}
</style>
