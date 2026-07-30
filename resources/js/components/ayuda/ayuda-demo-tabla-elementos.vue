<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Carga de elementos del informe {{ metodo }}</div>
        <div class="ayuda_table_wrap">
            <table class="table table-hover table-striped table-bordered table-condensed ayuda_real_table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th v-for="(col, i) in columnas" :key="i" :class="col.align ? 'text-' + col.align : ''">{{ col.label }}</th>
                        <th class="text-center" style="width:60px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, idx) in filas" :key="idx">
                        <td>{{ idx + 1 }}</td>
                        <td v-for="(col, i) in columnas" :key="i" :class="col.align ? 'text-' + col.align : ''">
                            <template v-if="col.type === 'check'">
                                <i v-if="row[col.key]" class="fa fa-check ayuda_check_ok"></i>
                                <i v-else class="fa fa-times ayuda_check_no"></i>
                            </template>
                            <strong v-else-if="col.key === 'codigo'">{{ row[col.key] }}</strong>
                            <span v-else>{{ row[col.key] }}</span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-default btn-xs" title="Clonar"><i class="fa fa-copy"></i></button>
                            <button class="btn btn-enod-danger btn-xs" title="Quitar"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="enod-form-actions">
            <button class="btn btn-default btn-sm"><i class="fa fa-plus"></i>&nbsp; Agregar {{ etiquetaItem }}</button>
            <button class="btn btn-default btn-sm" v-if="metodo === 'RI' || metodo === 'US'"><i class="fa fa-upload"></i>&nbsp; Importar {{ metodo === 'US' ? 'Excel' : 'CSV' }}</button>
        </div>
        <div class="ayuda_demo_caption" v-if="metodo === 'RI'">
            La columna <strong>Aceptable</strong> marca con un check las costuras sin anomalías; si se carga una observación de rechazo, se destildan.
        </div>
        <div class="ayuda_demo_caption" v-else-if="metodo === 'US'">
            Se compara el espesor <strong>Nominal</strong> contra el <strong>Mínimo</strong> admisible. Si el espesor medido baja del mínimo, el reporte lo destaca.
        </div>
        <div class="ayuda_demo_caption" v-else-if="metodo === 'LP'">
            En LP se cargan los <strong>cuños</strong> de los soldadores responsables (Cuño P / Cuño Z), la medida en cm y un archivo de referencia.
        </div>
        <div class="ayuda_demo_caption" v-else>
            Cada elemento puede tener un detalle, medida en cm (CM) y un archivo de referencia adjunto.
        </div>
    </div>
</template>

<script>
const DATA = {
    RI: {
        etiqueta: 'elemento',
        columnas: [
            { key: 'codigo',    label: 'Elemento' },
            { key: 'densidad',  label: 'Densidad', align: 'center' },
            { key: 'pos',       label: 'Pos.', align: 'center' },
            { key: 'aceptable', label: 'Aceptable', align: 'center', type: 'check' },
            { key: 'obs',       label: 'Observación' },
        ],
        filas: [
            { codigo: 'J14', densidad: '2.8', pos: '—',   aceptable: true,  obs: '—' },
            { codigo: 'J15', densidad: '2.7', pos: '340', aceptable: false, obs: 'FU (falta unión)' },
            { codigo: 'J16', densidad: '2.9', pos: '—',   aceptable: true,  obs: '—' },
            { codigo: 'J17', densidad: '2.8', pos: '—',   aceptable: true,  obs: '—' },
        ],
    },
    PM: {
        etiqueta: 'elemento',
        columnas: [
            { key: 'codigo',    label: 'Elemento' },
            { key: 'cm',        label: 'CM', align: 'center' },
            { key: 'detalle',   label: 'Detalle' },
            { key: 'aceptable', label: 'Aceptable', align: 'center', type: 'check' },
            { key: 'referencia', label: 'Referencia', align: 'center' },
        ],
        filas: [
            { codigo: 'E-01', cm: '180', detalle: 'Costura long. tanque T-200', aceptable: true,  referencia: 'FT-01' },
            { codigo: 'E-02', cm: '120', detalle: 'Junta tapa - cuerpo (fisura superficial)', aceptable: false, referencia: 'FT-02' },
            { codigo: 'E-03', cm: '45',  detalle: 'Refuerzo boquilla N-1', aceptable: true,  referencia: '—' },
        ],
    },
    LP: {
        etiqueta: 'elemento',
        columnas: [
            { key: 'codigo',    label: 'Elemento' },
            { key: 'cunoP',     label: 'Cuño P', align: 'center' },
            { key: 'cunoZ',     label: 'Cuño Z', align: 'center' },
            { key: 'cm',        label: 'CM', align: 'center' },
            { key: 'detalle',   label: 'Detalle' },
            { key: 'aceptable', label: 'Aceptable', align: 'center', type: 'check' },
            { key: 'referencia', label: 'Referencia', align: 'center' },
        ],
        filas: [
            { codigo: 'E-01', cunoP: 'S-104', cunoZ: 'S-118', cm: '95', detalle: 'Costura circunferencial', aceptable: true,  referencia: '—' },
            { codigo: 'E-02', cunoP: 'S-122', cunoZ: '—',     cm: '60', detalle: 'Boquilla salida vapor (poro 0.8 mm)', aceptable: false, referencia: 'FT-05' },
        ],
    },
    US: {
        etiqueta: 'elemento',
        columnas: [
            { key: 'codigo',    label: 'Elemento' },
            { key: 'nominal',   label: 'Nominal', align: 'center' },
            { key: 'minimo',    label: 'Mínimo', align: 'center' },
            { key: 'minimoAnt', label: 'Mínimo Ant', align: 'center' },
            { key: 'glp',       label: 'G.L.P.', align: 'center' },
        ],
        filas: [
            { codigo: 'Anillo 1', nominal: '12.7', minimo: '9.5',  minimoAnt: '10.1', glp: 'No' },
            { codigo: 'Anillo 2', nominal: '12.7', minimo: '9.5',  minimoAnt: '9.8',  glp: 'No' },
            { codigo: 'Techo',    nominal: '9.5',  minimo: '6.4',  minimoAnt: '6.9',  glp: 'Sí' },
        ],
    },
};

export default {
    name: 'ayuda-demo-tabla-elementos',
    props: {
        metodo: { type: String, required: true, validator: v => ['RI','PM','LP','US'].includes(v) },
    },
    computed: {
        columnas() { return DATA[this.metodo].columnas; },
        filas()    { return DATA[this.metodo].filas; },
        etiquetaItem() { return DATA[this.metodo].etiqueta; },
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
.ayuda_check_ok { color: #1b6b34; }
.ayuda_check_no { color: #dc3545; }
.enod-form-actions { margin-top: 8px; }
.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
</style>
