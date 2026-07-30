<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Partes asignados a la orden de trabajo</div>
        <div class="ayuda_table_wrap">
            <table class="table table-hover table-striped table-bordered table-condensed ayuda_real_table">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Tipo Servicio</th>
                        <th>Usuario alta</th>
                        <th>Fecha</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(p, i) in filas" :key="i">
                        <td><strong>{{ p.numero }}</strong></td>
                        <td>{{ p.tipo }}</td>
                        <td>{{ p.usuario }}</td>
                        <td>{{ p.fecha }}</td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-xs" title="Editar"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-default btn-xs" title="PDF original"><i class="fa fa-file-pdf-o"></i></button>
                            <button class="btn btn-default btn-xs" title="PDF final"><i class="fa fa-file-pdf-o"></i></button>
                            <button class="btn btn-default btn-xs" title="Informes escaneados"><i class="fa fa-cloud-upload"></i></button>
                            <button v-if="!p.firma" class="btn btn-default btn-xs" title="Firmar"><i class="glyphicon glyphicon-pencil"></i></button>
                            <span v-else class="btn btn-default btn-xs" title="Firmado"><i class="fa fa-check"></i></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="ayuda_demo_caption">
            El <strong>Tipo Servicio</strong> es el turno del parte (Diurno / Nocturno).
            Mientras el parte no está firmado se muestra el botón <strong>Firmar</strong>; una vez firmado aparece la imagen de firma
            y el parte queda disponible para certificados. Cada parte tiene sus PDFs (original y final) e informes escaneados.
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-tabla-partes',
    data() {
        return {
            filas: [
                { numero: '00000089', tipo: 'Diurno',   usuario: 'Juan Pérez',     fecha: '25-06-2026', firma: false },
                { numero: '00000088', tipo: 'Nocturno', usuario: 'Lucía Mendoza',  fecha: '24-06-2026', firma: true },
                { numero: '00000087', tipo: 'Diurno',   usuario: 'Juan Pérez',     fecha: '20-06-2026', firma: true },
                { numero: '00000086', tipo: 'Diurno',   usuario: 'Diego Salas',    fecha: '18-06-2026', firma: true },
                { numero: '00000085', tipo: 'Nocturno', usuario: 'Marcos Aguirre', fecha: '15-06-2026', firma: false },
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
.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
</style>
