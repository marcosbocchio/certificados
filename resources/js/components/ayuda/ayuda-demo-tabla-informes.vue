<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Informes asignados a la orden de trabajo</div>
        <div class="ayuda_table_wrap">
            <table class="table table-hover table-striped table-bordered table-condensed ayuda_real_table">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>N°</th>
                        <th class="text-center">N° Rev.</th>
                        <th>Obra</th>
                        <th>Usuario alta</th>
                        <th class="text-center">Fecha</th>
                        <th class="text-center">Anulado</th>
                        <th class="text-center">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(inf, i) in filas" :key="i">
                        <td>{{ inf.tipo }}</td>
                        <td><strong>{{ inf.numero }}</strong></td>
                        <td class="text-center">{{ inf.rev }}</td>
                        <td>{{ inf.obra }}</td>
                        <td>{{ inf.usuario }}</td>
                        <td class="text-center">{{ inf.fecha }}</td>
                        <td class="text-center">
                            <i v-if="inf.anulado" class="fa fa-check ayuda_check_ok"></i>
                        </td>
                        <td class="text-center ayuda_acciones">
                            <button class="btn btn-warning btn-sm" title="Editar"><span class="fa fa-edit"></span></button>
                            <div class="dropdown ayuda_dropdown">
                                <button class="btn btn-default btn-sm dropdown-toggle" title="Clonar">
                                    <i class="fa fa-copy"></i> <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a>Clonado</a></li>
                                    <li><a>Clonado Completo</a></li>
                                </ul>
                            </div>
                            <button class="btn btn-default btn-sm" title="Informe"><span class="fa fa-file-pdf-o"></span></button>
                            <button class="btn btn-default btn-sm" title="Firmar"><span class="glyphicon glyphicon-pencil"></span></button>
                            <button class="btn btn-default btn-sm" title="Revisiones"><span class="fa fa-table"></span></button>
                            <button class="btn btn-default btn-sm" title="Anular"><i class="fa fa-times"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="ayuda_demo_caption">
            La columna <strong>N° Rev.</strong> muestra la revisión vigente. Editar un informe firmado genera una nueva revisión y conserva la trazabilidad.
            Los informes <strong>anulados</strong> quedan marcados con un check y solo se pueden desanular.
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-tabla-informes',
    data() {
        return {
            filas: [
                { tipo: 'RI', numero: '150-LR-RI001', rev: 0, obra: 'Gasoducto NEA T12', usuario: 'J. Pérez',    fecha: '25/06/2026', anulado: false },
                { tipo: 'RI', numero: '150-LR-RI002', rev: 1, obra: 'Gasoducto NEA T12', usuario: 'J. Pérez',    fecha: '25/06/2026', anulado: false },
                { tipo: 'PM', numero: 'PM014',        rev: 0, obra: 'Planta Río III',    usuario: 'L. Mendoza',  fecha: '24/06/2026', anulado: true  },
                { tipo: 'PM', numero: 'PM015',        rev: 2, obra: 'Planta Río III',    usuario: 'L. Mendoza',  fecha: '24/06/2026', anulado: false },
                { tipo: 'US', numero: 'US042',        rev: 0, obra: 'Refinería Loma',    usuario: 'D. Salas',    fecha: '20/06/2026', anulado: false },
                { tipo: 'LP', numero: 'LP008',        rev: 0, obra: 'Planta Río III',    usuario: 'M. Aguirre',  fecha: '18/06/2026', anulado: false },
                { tipo: 'CV', numero: 'CV003',        rev: 0, obra: 'Gasoducto NEA T12', usuario: 'J. Pérez',    fecha: '15/06/2026', anulado: false },
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
.ayuda_acciones { white-space: nowrap; }
.ayuda_acciones .btn { margin: 1px; }
.ayuda_dropdown { display: inline-block; }
.ayuda_check_ok { color: #1b6b34; }
.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
</style>
