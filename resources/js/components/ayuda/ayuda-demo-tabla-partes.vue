<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Listado de partes diarios</div>
        <div class="ayuda_table_wrap">
            <table class="table table-hover table-striped table-bordered table-condensed ayuda_real_table">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Fecha</th>
                        <th>Tipo de servicio</th>
                        <th>Usuario alta</th>
                        <th class="text-center">Informes</th>
                        <th class="text-center">Firma</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(p, i) in filas" :key="i">
                        <td><strong>{{ p.numero }}</strong></td>
                        <td>{{ p.fecha }}</td>
                        <td>{{ p.tipo }}</td>
                        <td>{{ p.usuario }}</td>
                        <td class="text-center"><span class="label label-warning">{{ p.informes }}</span></td>
                        <td class="text-center">
                            <span class="label" :class="badge(p.firma)">
                                <i :class="iconoFirma(p.firma)"></i>&nbsp; {{ p.firma }}
                            </span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-default btn-xs" title="Ver PDF"><i class="fa fa-file-pdf-o"></i></button>
                            <button class="btn btn-enod btn-xs" :disabled="p.firma === 'Firmado'" title="Editar"><i class="fa fa-pencil"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="ayuda_demo_caption">
            <strong>Firma</strong> resume el estado documental: una vez firmado, el parte queda inmutable y disponible para certificados.
            <strong>Informes</strong> indica cuántos informes técnicos fueron consolidados en esa jornada.
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-tabla-partes',
    data() {
        return {
            filas: [
                { numero: 'P-0089', fecha: '25/06/2026', tipo: 'Radiografía industrial', usuario: 'Juan Pérez',    informes: 5, firma: 'Pendiente' },
                { numero: 'P-0088', fecha: '24/06/2026', tipo: 'Partículas magnéticas',  usuario: 'Lucía Mendoza', informes: 3, firma: 'Firmado' },
                { numero: 'P-0087', fecha: '20/06/2026', tipo: 'Radiografía industrial', usuario: 'Juan Pérez',    informes: 7, firma: 'Firmado' },
                { numero: 'P-0086', fecha: '18/06/2026', tipo: 'Ultrasonido',            usuario: 'Diego Salas',   informes: 2, firma: 'Firmado' },
                { numero: 'P-0085', fecha: '15/06/2026', tipo: 'Líquidos penetrantes',   usuario: 'Marcos Aguirre',informes: 4, firma: 'Anulado' },
            ],
        };
    },
    methods: {
        badge(f) {
            return {
                'Firmado':   'label-success',
                'Pendiente': 'label-warning',
                'Anulado':   'label-danger',
            }[f];
        },
        iconoFirma(f) {
            return {
                'Firmado':   'fa fa-check-circle',
                'Pendiente': 'fa fa-clock-o',
                'Anulado':   'fa fa-ban',
            }[f];
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
.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
</style>
