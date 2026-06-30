<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Listado de órdenes de trabajo</div>
        <div class="ayuda_table_wrap">
            <table class="table table-hover table-striped table-bordered table-condensed ayuda_real_table">
                <thead>
                    <tr>
                        <th>OT N°</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Proyecto</th>
                        <th>Responsable</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(ot, i) in filas" :key="i">
                        <td><strong>{{ ot.numero }}</strong></td>
                        <td>{{ ot.fecha }}</td>
                        <td>{{ ot.cliente }}</td>
                        <td>{{ ot.proyecto }}</td>
                        <td>{{ ot.responsable }}</td>
                        <td class="text-center">
                            <span class="label" :class="badge(ot.estado)">{{ ot.estado }}</span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-default btn-xs" title="Ver"><i class="fa fa-eye"></i></button>
                            <button class="btn btn-enod btn-xs" :disabled="ot.estado === 'Cerrada'" title="Editar"><i class="fa fa-pencil"></i></button>
                            <button class="btn btn-default btn-xs" title="PDF"><i class="fa fa-file-pdf-o"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="ayuda_demo_caption">
            Las OT se muestran en orden descendente por fecha de alta. <strong>Editando</strong> habilita
            edición, <strong>Activa</strong> congela datos base pero permite cargar informes y partes,
            <strong>Cerrada</strong> deja la OT como antecedente consultable.
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-tabla-ots',
    data() {
        return {
            filas: [
                { numero: 'OT-1542', fecha: '25/06/2026', cliente: 'YPF S.A.',         proyecto: 'Gasoducto NEA - T12',   responsable: 'Juan Pérez',    estado: 'Activa' },
                { numero: 'OT-1541', fecha: '24/06/2026', cliente: 'Techint',          proyecto: 'Planta Río III',         responsable: 'Marcos Aguirre', estado: 'Editando' },
                { numero: 'OT-1538', fecha: '20/06/2026', cliente: 'Pampa Energía',    proyecto: 'Refinería Loma',         responsable: 'Lucía Mendoza',  estado: 'Activa' },
                { numero: 'OT-1530', fecha: '12/06/2026', cliente: 'YPF S.A.',         proyecto: 'Mantto. Tanques 2026',   responsable: 'Juan Pérez',    estado: 'Cerrada' },
                { numero: 'OT-1527', fecha: '08/06/2026', cliente: 'Tecpetrol',        proyecto: 'Reparación válvulas',    responsable: 'Diego Salas',   estado: 'Cerrada' },
            ],
        };
    },
    methods: {
        badge(estado) {
            return {
                'Activa':   'label-success',
                'Editando': 'label-warning',
                'Cerrada':  'label-default',
            }[estado];
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
.ayuda_real_table .label { font-size: 11px; padding: 3px 8px; font-weight: 700; }
.ayuda_real_table .btn-xs { margin: 0 1px; }
.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
</style>
