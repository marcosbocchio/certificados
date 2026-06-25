<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Responsables y horas de la jornada</div>
        <div class="ayuda_table_wrap">
            <table class="table table-hover table-striped table-bordered table-condensed ayuda_real_table">
                <thead>
                    <tr>
                        <th>Operador</th>
                        <th>Función</th>
                        <th class="text-center">Inicio</th>
                        <th class="text-center">Fin</th>
                        <th class="text-center">Horas</th>
                        <th>Novedades</th>
                        <th class="text-center" style="width:42px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(r, i) in filas" :key="i">
                        <td><strong>{{ r.operador }}</strong></td>
                        <td>{{ r.funcion }}</td>
                        <td class="text-center">{{ r.inicio }}</td>
                        <td class="text-center">{{ r.fin }}</td>
                        <td class="text-center"><span class="label label-warning">{{ r.horas }}h</span></td>
                        <td>
                            <span v-if="r.novedad" class="ayuda_nov">{{ r.novedad }}</span>
                            <span v-else class="text-muted">—</span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-enod-danger btn-xs" title="Quitar"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr class="ayuda_total_row">
                        <td colspan="4" class="text-right"><strong>Total horas hombre</strong></td>
                        <td class="text-center"><strong>{{ totalHoras }}h</strong></td>
                        <td colspan="2"></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="enod-form-actions">
            <button class="btn btn-default btn-sm"><i class="fa fa-plus"></i>&nbsp; Agregar operador</button>
        </div>
        <div class="ayuda_demo_caption">
            Si un operador faltó parte del día, registralo en novedades — esto después aparece en el PDF del parte
            y se usa en certificados / reportes de horas hombre.
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-tabla-operarios-horas',
    data() {
        return {
            filas: [
                { operador: 'Juan Pérez',     funcion: 'Operador RI',      inicio: '07:30', fin: '16:00', horas: 8, novedad: '' },
                { operador: 'Marcos Aguirre', funcion: 'Asistente',         inicio: '07:30', fin: '12:00', horas: 4.5, novedad: 'Retiro por turno médico' },
                { operador: 'Lucía Mendoza',  funcion: 'Inspector cliente', inicio: '08:00', fin: '16:00', horas: 8, novedad: '' },
            ],
        };
    },
    computed: {
        totalHoras() {
            return this.filas.reduce((s, r) => s + r.horas, 0);
        },
    },
};
</script>

<style scoped>
.ayuda_demo_block { margin: 16px 0 20px; font-family: 'Montserrat', sans-serif; }
.ayuda_demo_label {
    font-size: 11px; color: #6b7280;
    text-transform: uppercase; letter-spacing: 0.06em;
    margin-bottom: 8px; font-weight: 700;
}
.ayuda_table_wrap { overflow-x: auto; }
.ayuda_real_table { background: #fff; margin-bottom: 0; }
.ayuda_real_table > thead > tr > th {
    background: #fafbfc;
    border-bottom: 2px solid #FFCC00;
    color: #4c5661;
    font-size: 11.5px;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    font-weight: 700;
    white-space: nowrap;
}
.ayuda_real_table > tbody > tr > td {
    font-size: 13px;
    vertical-align: middle;
}
.ayuda_real_table .label { font-size: 11px; padding: 3px 8px; }
.ayuda_nov {
    display: inline-block;
    background: #fff7d6;
    color: #6b5300;
    padding: 2px 8px;
    border-radius: 3px;
    font-size: 12px;
}
.ayuda_total_row td { background: #fafbfc; }
.enod-form-actions { margin-top: 8px; }
.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
</style>
