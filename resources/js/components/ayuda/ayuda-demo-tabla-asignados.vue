<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">{{ config.titulo }}</div>
        <div class="ayuda_table_wrap">
            <table class="table table-hover table-striped table-bordered table-condensed ayuda_real_table">
                <thead>
                    <tr>
                        <th v-for="col in config.columnas" :key="col.key" :class="col.align ? 'text-' + col.align : ''">{{ col.label }}</th>
                        <th class="text-center" style="width:80px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, i) in config.filas" :key="i">
                        <td v-for="col in config.columnas" :key="col.key" :class="col.align ? 'text-' + col.align : ''">
                            <strong v-if="col.bold">{{ row[col.key] }}</strong>
                            <span v-else-if="col.tipo === 'estado'" class="label" :class="estadoBadge(row[col.key])">
                                <i :class="estadoIcono(row[col.key])"></i>&nbsp; {{ row[col.key] }}
                            </span>
                            <span v-else-if="col.tipo === 'vencimiento'" :class="vencClase(row[col.key + '_vence'])">
                                {{ row[col.key] }}
                                <small v-if="row[col.key + '_dias'] !== undefined" class="ayuda_dias">
                                    ({{ row[col.key + '_dias'] }} d.)
                                </small>
                            </span>
                            <span v-else>{{ row[col.key] }}</span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-default btn-xs" title="Ver documento"><i class="fa fa-eye"></i></button>
                            <button class="btn btn-default btn-xs" title="Descargar PDF"><i class="fa fa-download"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="ayuda_demo_caption" v-html="config.caption"></div>
    </div>
</template>

<script>
const CONFIG = {
    'doc-operador': {
        titulo: 'Documentación de operadores asignados',
        columnas: [
            { key: 'operador',     label: 'Operador',           bold: true },
            { key: 'funcion',      label: 'Función' },
            { key: 'certificacion',label: 'Certif. Nivel',      align: 'center' },
            { key: 'art',          label: 'ART',                tipo: 'vencimiento', align: 'center' },
            { key: 'dosimetria',   label: 'Última dosimetría',  tipo: 'vencimiento', align: 'center' },
            { key: 'estado',       label: 'Estado',             tipo: 'estado',      align: 'center' },
        ],
        filas: [
            { operador: 'Juan Pérez',     funcion: 'Operador RI',       certificacion: 'Nivel II',  art: '15/12/2026', art_vence: 173, dosimetria: '20/06/2026',  dosimetria_vence: 5,  estado: 'Vigente'   },
            { operador: 'Marcos Aguirre', funcion: 'Asistente',          certificacion: 'Nivel I',   art: '08/09/2026', art_vence: 74,  dosimetria: '15/06/2026',  dosimetria_vence: 10, estado: 'Vigente'   },
            { operador: 'Diego Salas',    funcion: 'Operador PM',        certificacion: 'Nivel II',  art: '30/06/2026', art_vence: 4,   dosimetria: '01/06/2026',  dosimetria_vence: 24, estado: 'Por vencer'},
            { operador: 'Lucía Mendoza',  funcion: 'Inspector cliente',  certificacion: '—',         art: '20/03/2026', art_vence: -98, dosimetria: '—',           dosimetria_vence: 0,  estado: 'Vencido'   },
        ],
        caption: 'Cuando un cliente ingresa a la OT, ve esta misma tabla. Si una fila aparece como <span class="label label-warning"><i class="fa fa-clock-o"></i>&nbsp;Por vencer</span> o <span class="label label-danger"><i class="fa fa-times-circle"></i>&nbsp;Vencido</span>, hay que actualizar la documentación del operador en su perfil.',
    },
    'vehiculo': {
        titulo: 'Vehículos asignados a la OT',
        columnas: [
            { key: 'patente',  label: 'Patente',       bold: true,  align: 'center' },
            { key: 'modelo',   label: 'Marca / modelo' },
            { key: 'tipo',     label: 'Tipo' },
            { key: 'vtv',      label: 'VTV',           tipo: 'vencimiento', align: 'center' },
            { key: 'seguro',   label: 'Seguro',        tipo: 'vencimiento', align: 'center' },
            { key: 'estado',   label: 'Estado',        tipo: 'estado',      align: 'center' },
        ],
        filas: [
            { patente: 'AB 234 CD', modelo: 'Toyota Hilux 4x4 2022', tipo: 'Camioneta', vtv: '10/11/2026', vtv_vence: 138, seguro: '15/12/2026', seguro_vence: 173, estado: 'Vigente'   },
            { patente: 'AE 102 NK', modelo: 'VW Amarok 2021',         tipo: 'Camioneta', vtv: '05/07/2026', vtv_vence: 10,  seguro: '20/08/2026', seguro_vence: 55,  estado: 'Por vencer'},
            { patente: 'AD 556 QR', modelo: 'Iveco Daily furgón',     tipo: 'Furgón',    vtv: '22/09/2026', vtv_vence: 88,  seguro: '30/10/2026', seguro_vence: 126, estado: 'Vigente'   },
        ],
        caption: 'La VTV y el seguro del vehículo viajan con la OT. <strong>Por vencer</strong> = faltan menos de 30 días.',
    },
    'procedimiento': {
        titulo: 'Procedimientos asignados a la OT',
        columnas: [
            { key: 'codigo',      label: 'Código',      bold: true },
            { key: 'descripcion', label: 'Descripción' },
            { key: 'metodo',      label: 'Método',      align: 'center' },
            { key: 'revision',    label: 'Rev.',        align: 'center' },
            { key: 'norma',       label: 'Norma' },
            { key: 'estado',      label: 'Estado',      tipo: 'estado', align: 'center' },
        ],
        filas: [
            { codigo: 'PR-RI-007', descripcion: 'Radiografía industrial DDSE',   metodo: 'RI', revision: 'Rev. 3', norma: 'API 1104',  estado: 'Vigente' },
            { codigo: 'PR-PM-002', descripcion: 'Partículas magnéticas - Yugo',   metodo: 'PM', revision: 'Rev. 2', norma: 'ASME V',    estado: 'Vigente' },
            { codigo: 'PR-LP-004', descripcion: 'Líquidos penetrantes',           metodo: 'LP', revision: 'Rev. 1', norma: 'ASME V',    estado: 'Vigente' },
            { codigo: 'PR-US-009', descripcion: 'Ultrasonido convencional',       metodo: 'US', revision: 'Rev. 4', norma: 'ASME V',    estado: 'Vigente' },
        ],
        caption: 'Si un procedimiento aparece como <span class="label label-danger"><i class="fa fa-times-circle"></i>&nbsp;Vencido</span>, los informes que lo usen no podrán firmarse hasta actualizar la revisión.',
    },
};

export default {
    name: 'ayuda-demo-tabla-asignados',
    props: {
        entidad: { type: String, required: true,
                   validator: v => Object.keys(CONFIG).includes(v) },
    },
    computed: {
        config() { return CONFIG[this.entidad]; },
    },
    methods: {
        estadoBadge(e) {
            return {
                'Vigente':    'label-success',
                'Por vencer': 'label-warning',
                'Vencido':    'label-danger',
            }[e] || 'label-default';
        },
        estadoIcono(e) {
            return {
                'Vigente':    'fa fa-check-circle',
                'Por vencer': 'fa fa-clock-o',
                'Vencido':    'fa fa-times-circle',
            }[e];
        },
        vencClase(dias) {
            if (dias === undefined) return '';
            if (dias < 0)  return 'ayuda_venc ayuda_venc--neg';
            if (dias < 30) return 'ayuda_venc ayuda_venc--warn';
            return 'ayuda_venc';
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
.ayuda_venc { color: #4c5661; }
.ayuda_venc--warn { color: #b07a00; font-weight: 700; }
.ayuda_venc--neg  { color: #8a1f2a; font-weight: 700; text-decoration: line-through; }
.ayuda_dias { font-size: 10.5px; color: #6b7280; font-weight: 400; }
.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
}
.ayuda_demo_caption .label { font-size: 10px; padding: 2px 7px; margin: 0 2px; }
</style>
