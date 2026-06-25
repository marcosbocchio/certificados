<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Ejemplo: listado de órdenes de trabajo</div>
        <table class="ayuda_demo_table table table-striped">
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
                        <span class="ayuda_demo_badge" :class="badge(ot.estado)">{{ ot.estado }}</span>
                    </td>
                    <td class="text-center">
                        <button class="ayuda_demo_iconbtn" title="Ver"><i class="fa fa-eye"></i></button>
                        <button class="ayuda_demo_iconbtn" :disabled="ot.estado === 'Cerrada'" title="Editar"><i class="fa fa-pencil"></i></button>
                        <button class="ayuda_demo_iconbtn" title="PDF"><i class="fa fa-file-pdf-o"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="ayuda_demo_caption">
            Las OT se muestran en orden descendente por fecha de alta. El estado <strong>Editando</strong> habilita
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
                'Activa':   'ayuda_demo_badge--success',
                'Editando': 'ayuda_demo_badge--warning',
                'Cerrada':  'ayuda_demo_badge--muted',
            }[estado];
        },
    },
};
</script>

<style scoped>
.ayuda_demo_block {
    margin: 12px 0 20px;
    overflow-x: auto;
}
.ayuda_demo_label {
    font-size: 12px; color: #6b7280;
    text-transform: uppercase; letter-spacing: 0.06em;
    margin-bottom: 8px; font-weight: 600;
}
.ayuda_demo_table { min-width: 640px; }
.ayuda_demo_table th {
    background: #f8fafc; color: #4c5661;
    font-size: 13px; font-weight: 700;
}
.ayuda_demo_table td { font-size: 13px; vertical-align: middle; }
.ayuda_demo_badge {
    display: inline-block; padding: 3px 10px;
    border-radius: 999px; font-size: 11.5px; font-weight: 700;
}
.ayuda_demo_badge--success { background: #dff0d8; color: #2c7a2c; }
.ayuda_demo_badge--warning { background: #fff3cd; color: #8a6d3b; }
.ayuda_demo_badge--muted   { background: #e9ecef; color: #6b7280; }
.ayuda_demo_iconbtn {
    background: transparent; border: 0;
    color: #4c5661; padding: 4px 6px;
    cursor: pointer; font-size: 14px;
}
.ayuda_demo_iconbtn:hover { color: #2e86c1; }
.ayuda_demo_iconbtn:disabled { color: #d6dce3; cursor: not-allowed; }
.ayuda_demo_caption {
    margin-top: 6px; font-size: 11px;
    color: #9ca3af; font-style: italic;
}
</style>
