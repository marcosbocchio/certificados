<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Listado de certificados de la OT</div>
        <div class="ayuda_table_wrap">
            <table class="table table-hover table-striped table-bordered table-condensed ayuda_real_table">
                <thead>
                    <tr>
                        <th>N° certificado</th>
                        <th>Fecha</th>
                        <th>Título</th>
                        <th class="text-center">Partes</th>
                        <th class="text-center">Firma</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(c, i) in filas" :key="i">
                        <td><strong>{{ c.numero }}</strong></td>
                        <td>{{ c.fecha }}</td>
                        <td>{{ c.titulo }}</td>
                        <td class="text-center"><span class="label label-warning">{{ c.partes }}</span></td>
                        <td class="text-center">
                            <span class="label" :class="badge(c.firma)">
                                <i :class="iconoFirma(c.firma)"></i>&nbsp; {{ c.firma }}
                            </span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-default btn-xs" title="Ver PDF"><i class="fa fa-file-pdf-o"></i></button>
                            <button class="btn btn-default btn-xs" title="Ver partes asociados"><i class="fa fa-link"></i></button>
                            <button class="btn btn-enod btn-xs" :disabled="c.firma === 'Firmado'" title="Editar"><i class="fa fa-pencil"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="ayuda_demo_caption">
            La columna <strong>Partes</strong> indica cuántos partes diarios consolidó el certificado.
            Al hacer click en el ícono <i class="fa fa-link"></i> se ve la trazabilidad: certificado → partes → informes.
            Un certificado firmado queda inmutable y representa la salida documental final del trabajo.
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-tabla-certificados',
    data() {
        return {
            filas: [
                { numero: 'CERT-0212', fecha: '25/06/2026', titulo: 'Avance semanal RI / PM - Tramo 12',  partes: 2, firma: 'Pendiente' },
                { numero: 'CERT-0211', fecha: '20/06/2026', titulo: 'Avance semanal - Semana 24',         partes: 5, firma: 'Firmado' },
                { numero: 'CERT-0210', fecha: '13/06/2026', titulo: 'Avance semanal - Semana 23',         partes: 4, firma: 'Firmado' },
                { numero: 'CERT-0208', fecha: '06/06/2026', titulo: 'Certificado mensual mayo 2026',      partes: 18, firma: 'Firmado' },
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
.ayuda_real_table > tbody > tr > td { font-size: 13px; vertical-align: middle; }
.ayuda_real_table .label { font-size: 11px; padding: 3px 8px; }
.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
</style>
