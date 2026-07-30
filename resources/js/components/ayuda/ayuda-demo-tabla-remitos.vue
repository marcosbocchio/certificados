<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Listado de remitos</div>
        <div class="ayuda_table_wrap">
            <table class="table table-hover table-striped table-bordered table-condensed ayuda_real_table">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Frente origen</th>
                        <th>Frente destino</th>
                        <th>Receptor</th>
                        <th>Destino</th>
                        <th>Fecha</th>
                        <th class="text-center">Anulado</th>
                        <th class="text-center">Borrador</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(r, i) in filas" :key="i" :class="{ ayuda_row_anulado: r.anulado }">
                        <td><strong>{{ r.numero }}</strong></td>
                        <td>{{ r.origen }}</td>
                        <td>{{ r.destino }}</td>
                        <td>{{ r.receptor }}</td>
                        <td>{{ r.lugar }}</td>
                        <td>{{ r.fecha }}</td>
                        <td class="text-center">
                            <i v-if="r.anulado" class="fa fa-check ayuda_check"></i>
                        </td>
                        <td class="text-center">
                            <i v-if="r.borrador" class="fa fa-check ayuda_check"></i>
                        </td>
                        <td class="text-center ayuda_acciones">
                            <button class="btn btn-warning btn-xs" :disabled="!r.borrador" title="Editar (solo borrador)"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-default btn-xs" :disabled="r.borrador" title="EEP"><i class="fa fa-clipboard"></i></button>
                            <button class="btn btn-default btn-xs" title="Ver / Imprimir PDF"><i class="fa fa-file-pdf-o"></i></button>
                            <button v-if="!r.anulado" class="btn btn-default btn-xs" :disabled="r.borrador" title="Anular"><i class="fa fa-times"></i></button>
                            <button v-else class="btn btn-default btn-xs" :disabled="r.borrador" title="Desanular"><i class="fa fa-check"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="ayuda_demo_caption">
            Un remito marcado como <strong>Borrador</strong> se puede editar; al confirmarlo deja de ser borrador,
            descuenta stock (si el origen es centro de distribución) y actualiza el frente de los internos.
            Un remito confirmado se puede <strong>Anular</strong> / <strong>Desanular</strong>; los borradores no.
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-tabla-remitos',
    data() {
        return {
            filas: [
                { numero: '0001-00012543', fecha: '25/06/2026', origen: 'CD Neuquén',   destino: 'Obra NEA T12',   receptor: 'D. Salas',   lugar: 'Obra Gasoducto NEA - km 87', borrador: false, anulado: false },
                { numero: '0001-00012542', fecha: '24/06/2026', origen: 'CD Neuquén',   destino: 'Planta Río III', receptor: 'L. Mendoza', lugar: 'Planta Río III - Sector B',   borrador: false, anulado: false },
                { numero: '0001-00012541', fecha: '24/06/2026', origen: 'Obra NEA T12', destino: 'CD Neuquén',     receptor: 'J. Pérez',   lugar: 'Depósito central Neuquén',   borrador: true,  anulado: false },
                { numero: '0001-00012540', fecha: '20/06/2026', origen: 'CD Neuquén',   destino: 'Refinería Loma', receptor: 'D. Salas',   lugar: 'Refinería Loma - Pañol NDT',  borrador: false, anulado: true  },
                { numero: '0001-00012538', fecha: '15/06/2026', origen: 'CD Neuquén',   destino: 'Planta Río III', receptor: 'M. Aguirre', lugar: 'Planta Río III - Taller',     borrador: false, anulado: false },
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
.ayuda_check { color: #1a1a1a; }
.ayuda_row_anulado > td { color: #9ca3af; text-decoration: line-through; }
.ayuda_acciones .btn-xs { margin: 0 1px; }
.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
}
.ayuda_demo_caption .label { font-size: 10px; padding: 2px 7px; margin: 0 2px; }
</style>
