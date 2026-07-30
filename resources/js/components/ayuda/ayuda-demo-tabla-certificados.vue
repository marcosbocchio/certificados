<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Certificados asignados a la orden de trabajo</div>
        <div class="ayuda_table_wrap">
            <table class="table table-hover table-striped table-bordered table-condensed ayuda_real_table">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Fecha</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(c, i) in filas" :key="i">
                        <td><strong>{{ c.numero }}</strong></td>
                        <td>{{ c.fecha }}</td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-xs" title="Editar"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-default btn-xs" title="Certificado original"><i class="fa fa-file-pdf-o"></i></button>
                            <span class="dropdown ayuda_dropdown">
                                <button class="btn btn-default btn-xs dropdown-toggle" title="Opciones de certificado">
                                    <i class="fa fa-file-pdf-o"></i>&nbsp;<span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#" @click.prevent>Certificado</a></li>
                                    <li><a href="#" @click.prevent>Certificado Agrupado</a></li>
                                </ul>
                            </span>
                            <button class="btn btn-default btn-xs" title="Informes escaneados"><i class="fa fa-cloud-upload"></i></button>
                            <button class="btn btn-default btn-xs" title="Exportar Excel"><i class="fa fa-file-excel-o"></i></button>
                            <button v-if="!c.firma" class="btn btn-default btn-xs" title="Firmar"><i class="glyphicon glyphicon-pencil"></i></button>
                            <span v-else class="btn btn-default btn-xs" title="Firmado"><i class="fa fa-check"></i></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="ayuda_demo_caption">
            Cada certificado se identifica por su <strong>N°</strong> y <strong>Fecha</strong>.
            Mientras no está firmado se muestra el botón <strong>Firmar</strong>; una vez firmado aparece la imagen de firma y queda inmutable.
            Desde acciones se accede al PDF original, al desplegable de PDF final (<strong>Certificado</strong> / <strong>Certificado Agrupado</strong>),
            a los informes escaneados y a la exportación a Excel.
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-tabla-certificados',
    data() {
        return {
            filas: [
                { numero: '00000212', fecha: '25-06-2026', firma: false },
                { numero: '00000211', fecha: '20-06-2026', firma: true },
                { numero: '00000210', fecha: '13-06-2026', firma: true },
                { numero: '00000208', fecha: '06-06-2026', firma: true },
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
.ayuda_real_table > tbody > tr > td { font-size: 13px; vertical-align: middle; }
.ayuda_real_table .label { font-size: 11px; padding: 3px 8px; }
.ayuda_dropdown { position: relative; display: inline-block; }
.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
</style>
