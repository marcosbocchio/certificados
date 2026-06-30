<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Listado de informes de la OT</div>
        <div class="ayuda_table_wrap">
            <table class="table table-hover table-striped table-bordered table-condensed ayuda_real_table">
                <thead>
                    <tr>
                        <th class="text-center" style="width:60px;">Tipo</th>
                        <th>Número</th>
                        <th class="text-center">N rev</th>
                        <th>Obra</th>
                        <th>Usuario alta</th>
                        <th class="text-center">Fecha</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(inf, i) in filas" :key="i">
                        <td class="text-center"><span class="label" :class="colorMetodo(inf.tipo)">{{ inf.tipo }}</span></td>
                        <td><strong>{{ inf.numero }}</strong></td>
                        <td class="text-center">
                            <span class="ayuda_rev_badge" :class="{ 'ayuda_rev_badge--mult': inf.rev > 0 }">
                                Rev. {{ inf.rev }}
                            </span>
                        </td>
                        <td>{{ inf.obra }}</td>
                        <td>{{ inf.usuario }}</td>
                        <td class="text-center">{{ inf.fecha }}</td>
                        <td class="text-center">
                            <button class="btn btn-default btn-xs" title="Ver PDF"><i class="fa fa-file-pdf-o"></i></button>
                            <button class="btn btn-default btn-xs" title="Ver"><i class="fa fa-eye"></i></button>
                            <button class="btn btn-enod btn-xs" title="Editar (nueva revisión)"><i class="fa fa-pencil"></i></button>
                            <button class="btn btn-default btn-xs" title="Clonar"><i class="fa fa-copy"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="ayuda_demo_caption">
            La columna <strong>N rev</strong> muestra la revisión vigente. Editar un informe firmado genera una nueva revisión y conserva la trazabilidad.
            El color de <strong>Tipo</strong> ayuda a identificar de un vistazo el método de ensayo.
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-tabla-informes',
    data() {
        return {
            filas: [
                { tipo: 'RI', numero: '150-LR-RI001', rev: 0, obra: 'Gasoducto NEA T12', usuario: 'J. Pérez',    fecha: '25/06/2026' },
                { tipo: 'RI', numero: '150-LR-RI002', rev: 1, obra: 'Gasoducto NEA T12', usuario: 'J. Pérez',    fecha: '25/06/2026' },
                { tipo: 'PM', numero: 'PM014',        rev: 0, obra: 'Planta Río III',    usuario: 'L. Mendoza',  fecha: '24/06/2026' },
                { tipo: 'PM', numero: 'PM015',        rev: 2, obra: 'Planta Río III',    usuario: 'L. Mendoza',  fecha: '24/06/2026' },
                { tipo: 'US', numero: 'US042',        rev: 0, obra: 'Refinería Loma',    usuario: 'D. Salas',    fecha: '20/06/2026' },
                { tipo: 'LP', numero: 'LP008',        rev: 0, obra: 'Planta Río III',    usuario: 'M. Aguirre',  fecha: '18/06/2026' },
                { tipo: 'CV', numero: 'CV003',        rev: 0, obra: 'Gasoducto NEA T12', usuario: 'J. Pérez',    fecha: '15/06/2026' },
            ],
        };
    },
    methods: {
        colorMetodo(t) {
            return {
                'RI': 'label-warning',
                'RD': 'label-warning',
                'PM': 'label-info',
                'LP': 'label-success',
                'US': 'label-primary',
                'CV': 'label-default',
            }[t] || 'label-default';
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
.ayuda_rev_badge {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 3px;
    font-size: 11px;
    background: #f3f4f6;
    color: #4c5661;
    font-weight: 600;
}
.ayuda_rev_badge--mult {
    background: #fff7d6;
    color: #6b5300;
}
.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
</style>
