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
                        <th>Elemento</th>
                        <th>N° Pasada</th>
                        <th>Cuño P</th>
                        <th>Cuño L</th>
                        <th>Cuño Z</th>
                        <th v-if="tipo === 'planta'">Proceso</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(p, i) in pasadasVisibles" :key="i">
                        <td><strong>{{ p.elemento }}</strong></td>
                        <td>{{ p.numero }}</td>
                        <td>{{ p.cunoP }}</td>
                        <td>{{ p.cunoL || '—' }}</td>
                        <td>{{ p.cunoZ || '—' }}</td>
                        <td v-if="tipo === 'planta'">{{ p.proceso }}</td>
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
            En <strong>ducto</strong> se cargan hasta 6 pasadas numeradas (1, 2, 3...) con sus soldadores por cuño (Cuño P, Cuño L, Cuño Z).
            En <strong>planta</strong> queda 1 sola pasada y aparece además la columna <strong>Proceso</strong>.
            Si los soldadores no aparecen en la lista, primero hay que asignarlos a la OT.
        </div>
    </div>
</template>

<script>
const DUCTO = [
    { elemento: 'J14', numero: 1, cunoP: 'S-104', cunoL: '',      cunoZ: '',      proceso: 'GTAW' },
    { elemento: 'J14', numero: 2, cunoP: 'S-118', cunoL: 'S-104', cunoZ: '',      proceso: 'SMAW' },
    { elemento: 'J14', numero: 3, cunoP: 'S-118', cunoL: '',      cunoZ: '',      proceso: 'SMAW' },
    { elemento: 'J14', numero: 4, cunoP: 'S-122', cunoL: '',      cunoZ: '',      proceso: 'SMAW' },
    { elemento: 'J14', numero: 5, cunoP: 'S-122', cunoL: '',      cunoZ: 'S-118', proceso: 'SMAW' },
];
const PLANTA = [
    { elemento: 'C-01', numero: 1, cunoP: 'S-104', cunoL: 'S-118', cunoZ: 'S-122', proceso: 'SMAW' },
];

export default {
    name: 'ayuda-demo-tabla-pasadas',
    data() { return { tipo: 'ducto' }; },
    computed: {
        pasadasVisibles() {
            return this.tipo === 'ducto' ? DUCTO : PLANTA;
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
