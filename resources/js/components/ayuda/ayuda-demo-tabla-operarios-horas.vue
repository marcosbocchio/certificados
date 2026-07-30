<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Responsabilidades del parte</div>
        <div class="ayuda_table_wrap">
            <table class="table table-hover table-striped table-bordered table-condensed ayuda_real_table">
                <thead>
                    <tr>
                        <th>Operador</th>
                        <th>Responsabilidad</th>
                        <th class="text-center" style="width:42px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(r, i) in filas" :key="i">
                        <td><strong>{{ r.operador }}</strong></td>
                        <td>{{ r.responsabilidad }}</td>
                        <td class="text-center">
                            <button class="btn btn-enod-danger btn-xs" title="Quitar"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="enod-form-actions">
            <button class="btn btn-default btn-sm"><i class="fa fa-plus"></i>&nbsp; Agregar operador</button>
        </div>
        <div class="ayuda_demo_caption">
            En el box <strong>Responsabilidades</strong> se elige a los operadores que trabajaron en la jornada y se les asigna
            una responsabilidad (texto libre). El parte no registra horas ni novedades por operador.
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-tabla-operarios-horas',
    data() {
        return {
            filas: [
                { operador: 'Juan Pérez',     responsabilidad: 'OPERADOR' },
                { operador: 'Marcos Aguirre', responsabilidad: 'AYUDANTE' },
                { operador: 'Lucía Mendoza',  responsabilidad: 'OPERADOR' },
            ],
        };
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
.enod-form-actions { margin-top: 8px; }
.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
</style>
