<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Carga de elementos del informe {{ metodo }}</div>
        <div class="ayuda_table_wrap">
            <table class="table table-hover table-striped table-bordered table-condensed ayuda_real_table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th v-for="(col, i) in columnas" :key="i" :class="col.align ? 'text-' + col.align : ''">{{ col.label }}</th>
                        <th class="text-center" style="width:90px;">Resultado</th>
                        <th class="text-center" style="width:60px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(row, idx) in filas" :key="idx">
                        <td>{{ idx + 1 }}</td>
                        <td v-for="(col, i) in columnas" :key="i" :class="col.align ? 'text-' + col.align : ''">
                            <strong v-if="col.key === 'codigo'">{{ row[col.key] }}</strong>
                            <span v-else>{{ row[col.key] }}</span>
                        </td>
                        <td class="text-center">
                            <span class="label" :class="row.aprobado ? 'label-success' : 'label-danger'">
                                {{ row.aprobado ? 'Aceptable' : 'Rechazo' }}
                            </span>
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
            <button class="btn btn-default btn-sm" v-if="metodo === 'RI'"><i class="fa fa-upload"></i>&nbsp; Importar CSV</button>
        </div>
        <div class="ayuda_demo_caption" v-if="metodo === 'RI'">
            Si se carga una posición de anomalía, el sistema marca la costura como <strong>rechazo</strong>. Ese estado se puede ajustar manualmente.
            Las posiciones se pueden clonar para acelerar la carga de costuras similares.
        </div>
        <div class="ayuda_demo_caption" v-else-if="metodo === 'US'">
            Si el espesor medido es menor al mínimo, el reporte lo destaca automáticamente.
        </div>
        <div class="ayuda_demo_caption" v-else>
            Cada elemento puede tener una descripción, medida en cm y un archivo de referencia adjunto.
        </div>
    </div>
</template>

<script>
const DATA = {
    RI: {
        etiqueta: 'costura',
        columnas: [
            { key: 'codigo',     label: 'Costura' },
            { key: 'placa',      label: 'Pos. placa' },
            { key: 'densidad',   label: 'Densidad', align: 'center' },
            { key: 'icpi',       label: 'IQI', align: 'center' },
            { key: 'indicacion', label: 'Indicación' },
        ],
        filas: [
            { codigo: 'J14',   placa: 'A-1', densidad: '2.8', icpi: '12', indicacion: '—',                 aprobado: true  },
            { codigo: 'J15',   placa: 'A-2', densidad: '2.7', icpi: '12', indicacion: 'FU (falta unión)',  aprobado: false },
            { codigo: 'J16',   placa: 'A-1', densidad: '2.9', icpi: '13', indicacion: '—',                 aprobado: true  },
            { codigo: 'J17',   placa: 'A-1', densidad: '2.8', icpi: '12', indicacion: '—',                 aprobado: true  },
        ],
    },
    PM: {
        etiqueta: 'elemento',
        columnas: [
            { key: 'codigo',      label: 'Elemento' },
            { key: 'descripcion', label: 'Descripción' },
            { key: 'medida',      label: 'Medida (cm)', align: 'center' },
            { key: 'indicacion',  label: 'Indicación' },
        ],
        filas: [
            { codigo: 'E-01', descripcion: 'Costura long. tanque T-200', medida: '180', indicacion: '—',                  aprobado: true  },
            { codigo: 'E-02', descripcion: 'Junta tapa - cuerpo',         medida: '120', indicacion: 'Fisura superficial', aprobado: false },
            { codigo: 'E-03', descripcion: 'Refuerzo boquilla N-1',       medida: '45',  indicacion: '—',                  aprobado: true  },
        ],
    },
    LP: {
        etiqueta: 'elemento',
        columnas: [
            { key: 'codigo',      label: 'Elemento' },
            { key: 'descripcion', label: 'Descripción' },
            { key: 'medida',      label: 'Medida (cm)', align: 'center' },
            { key: 'indicacion',  label: 'Indicación' },
        ],
        filas: [
            { codigo: 'E-01', descripcion: 'Costura circunferencial',     medida: '95',  indicacion: '—',                aprobado: true  },
            { codigo: 'E-02', descripcion: 'Boquilla salida vapor',        medida: '60',  indicacion: 'Poro 0.8 mm',      aprobado: false },
        ],
    },
    US: {
        etiqueta: 'medición',
        columnas: [
            { key: 'codigo',      label: 'Punto' },
            { key: 'descripcion', label: 'Descripción' },
            { key: 'medida',      label: 'Espesor (mm)', align: 'center' },
            { key: 'indicacion',  label: 'Observación' },
        ],
        filas: [
            { codigo: 'P-1', descripcion: 'Generatriz superior', medida: '12.4', indicacion: '—',                    aprobado: true  },
            { codigo: 'P-2', descripcion: 'Generatriz lateral',  medida: '11.9', indicacion: 'Cercano al mínimo',     aprobado: true  },
            { codigo: 'P-3', descripcion: 'Generatriz inferior', medida: '10.2', indicacion: 'Por debajo del mínimo', aprobado: false },
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
.ayuda_real_table .label { font-size: 10.5px; padding: 3px 8px; }
.enod-form-actions { margin-top: 8px; }
.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
</style>
