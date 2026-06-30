<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Listado de remitos</div>
        <div class="ayuda_table_wrap">
            <table class="table table-hover table-striped table-bordered table-condensed ayuda_real_table">
                <thead>
                    <tr>
                        <th>N° remito</th>
                        <th>Fecha</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Receptor</th>
                        <th class="text-center">Contenido</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(r, i) in filas" :key="i">
                        <td><strong>{{ r.numero }}</strong></td>
                        <td>{{ r.fecha }}</td>
                        <td>{{ r.origen }}</td>
                        <td>{{ r.destino }}</td>
                        <td>{{ r.receptor }}</td>
                        <td class="text-center">
                            <span v-if="r.productos" class="label label-info" :title="r.productos + ' productos'"><i class="fa fa-cubes"></i> {{ r.productos }}</span>
                            <span v-if="r.internos" class="label label-default" :title="r.internos + ' internos de equipos'"><i class="fa fa-wrench"></i> {{ r.internos }}</span>
                        </td>
                        <td class="text-center">
                            <span class="label" :class="r.borrador ? 'label-warning' : 'label-success'">
                                <i :class="r.borrador ? 'fa fa-floppy-o' : 'fa fa-check-circle'"></i>&nbsp;
                                {{ r.borrador ? 'Borrador' : 'Definitivo' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-default btn-xs" title="Ver PDF"><i class="fa fa-file-pdf-o"></i></button>
                            <button class="btn btn-enod btn-xs" :disabled="!r.borrador" title="Editar (solo borrador)"><i class="fa fa-pencil"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="ayuda_demo_caption">
            <span class="label label-warning"><i class="fa fa-floppy-o"></i>&nbsp;Borrador</span>
            no impacta stock y permite edición.
            <span class="label label-success"><i class="fa fa-check-circle"></i>&nbsp;Definitivo</span>
            descuenta stock (si el origen es centro de distribución) y actualiza el frente de los internos.
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-tabla-remitos',
    data() {
        return {
            filas: [
                { numero: '0001-00012543', fecha: '25/06/2026', origen: 'CD Neuquén',     destino: 'Obra NEA T12',     receptor: 'D. Salas',     productos: 3, internos: 2, borrador: false },
                { numero: '0001-00012542', fecha: '24/06/2026', origen: 'CD Neuquén',     destino: 'Planta Río III',   receptor: 'L. Mendoza',   productos: 5, internos: 0, borrador: false },
                { numero: '0001-00012541', fecha: '24/06/2026', origen: 'Obra NEA T12',   destino: 'CD Neuquén',       receptor: 'J. Pérez',     productos: 0, internos: 1, borrador: true  },
                { numero: '0001-00012540', fecha: '20/06/2026', origen: 'CD Neuquén',     destino: 'Refinería Loma',   receptor: 'D. Salas',     productos: 8, internos: 1, borrador: false },
                { numero: '0001-00012538', fecha: '15/06/2026', origen: 'CD Neuquén',     destino: 'Planta Río III',   receptor: 'M. Aguirre',   productos: 4, internos: 0, borrador: false },
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
.ayuda_real_table .label {
    font-size: 11px;
    padding: 3px 7px;
    margin-right: 2px;
    display: inline-block;
}
.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
}
.ayuda_demo_caption .label { font-size: 10px; padding: 2px 7px; margin: 0 2px; }
</style>
