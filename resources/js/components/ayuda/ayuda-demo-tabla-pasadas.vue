<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Pasadas y soldadores responsables (RI)</div>

        <div class="ayuda_tipo_selector">
            <label class="ayuda_radio">
                <input type="radio" v-model="tipo" value="ducto" /> Ducto (hasta 6 pasadas)
            </label>
            <label class="ayuda_radio">
                <input type="radio" v-model="tipo" value="planta" /> Planta (1 pasada)
            </label>
        </div>

        <div class="ayuda_table_wrap">
            <table class="table table-hover table-striped table-bordered table-condensed ayuda_real_table">
                <thead>
                    <tr>
                        <th>Pasada</th>
                        <th>Proceso</th>
                        <th>Soldador 1</th>
                        <th>Soldador 2</th>
                        <th>Material aporte</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(p, i) in pasadasVisibles" :key="i">
                        <td><strong>{{ p.numero }}</strong></td>
                        <td>{{ p.proceso }}</td>
                        <td>{{ p.s1 }}</td>
                        <td>{{ p.s2 || '—' }}</td>
                        <td>{{ p.aporte }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="enod-form-actions">
            <button class="btn btn-default btn-sm"><i class="fa fa-plus"></i>&nbsp; Agregar pasada</button>
            <button class="btn btn-default btn-sm"><i class="fa fa-copy"></i>&nbsp; Clonar</button>
            <button class="btn btn-default btn-sm"><i class="fa fa-upload"></i>&nbsp; Importar CSV</button>
        </div>
        <div class="ayuda_demo_caption">
            En <strong>ducto</strong> se cargan hasta 6 pasadas (raíz, caliente, relleno, presentación, etc.).
            En <strong>planta</strong> queda 1 sola pasada. Si los soldadores no aparecen en la lista, hay que asignarlos primero a la OT.
        </div>
    </div>
</template>

<script>
const TODAS = [
    { numero: 'Raíz',          proceso: 'GTAW',      s1: 'A. Gómez (S-104)',    s2: '',                    aporte: 'ER70S-6 Ø2.4' },
    { numero: 'Caliente',      proceso: 'SMAW',      s1: 'M. Suárez (S-118)',   s2: 'A. Gómez (S-104)',    aporte: 'E7010-P1 Ø3.25' },
    { numero: 'Relleno 1',     proceso: 'SMAW',      s1: 'M. Suárez (S-118)',   s2: '',                    aporte: 'E8010-P1 Ø4.0' },
    { numero: 'Relleno 2',     proceso: 'SMAW',      s1: 'C. Núñez (S-122)',    s2: '',                    aporte: 'E8010-P1 Ø4.0' },
    { numero: 'Presentación',  proceso: 'SMAW',      s1: 'C. Núñez (S-122)',    s2: '',                    aporte: 'E8010-P1 Ø4.0' },
];

export default {
    name: 'ayuda-demo-tabla-pasadas',
    data() { return { tipo: 'ducto' }; },
    computed: {
        pasadasVisibles() {
            return this.tipo === 'ducto' ? TODAS : [TODAS[0]];
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
.ayuda_tipo_selector {
    display: flex; gap: 16px;
    background: #fafbfc;
    border: 1px solid #eef0f3;
    padding: 8px 12px;
    border-radius: 4px;
    margin-bottom: 8px;
}
.ayuda_radio { font-size: 13px; color: #4c5661; cursor: pointer; margin: 0; font-weight: 600; }
.ayuda_radio input { margin-right: 6px; }
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
.enod-form-actions { margin-top: 8px; }
.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
</style>
