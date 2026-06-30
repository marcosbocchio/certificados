<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Pantalla de vehículos y documentación complementaria</div>

        <!-- Vehículos -->
        <div class="box box-custom-enod ayuda_veh_box">
            <div class="box-body">
                <div class="form-group">
                    <label>Vehículos</label>
                    <select class="form-control" v-model="vehSel">
                        <option value="">— elegí un vehículo —</option>
                        <option v-for="v in vehDisponibles" :key="v.id" :value="v.id">
                            {{ v.nro_interno }} — {{ v.marca }} {{ v.patente }}
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-default" @click="agregarVehiculo" :disabled="!vehSel"><i class="fa fa-plus-circle"></i></button>
                </div>
            </div>
        </div>

        <!-- Tabla vehículos asignados -->
        <div class="box box-custom-enod ayuda_veh_box">
            <div class="box-header with-border"><h3 class="ayuda_veh_title">Vehículos asignados a la orden de trabajo</h3></div>
            <div class="box-body">
                <table class="table table-hover table-striped table-condensed ayuda_veh_table">
                    <thead><tr>
                        <th>N° INT.</th><th>Marca</th><th>Modelo</th><th>Patente</th><th>Tipo</th><th class="text-center" style="width:30px;"></th>
                    </tr></thead>
                    <tbody>
                        <tr v-for="v in vehAsignados" :key="v.id">
                            <td>{{ v.nro_interno }}</td>
                            <td>{{ v.marca }}</td>
                            <td>{{ v.modelo }}</td>
                            <td>{{ v.patente }}</td>
                            <td>{{ v.tipo }}</td>
                            <td class="text-center"><i class="fa fa-minus-circle ayuda_veh_remove" @click="quitarVehiculo(v.id)"></i></td>
                        </tr>
                        <tr v-if="!vehAsignados.length"><td colspan="6" class="ayuda_veh_empty text-muted">Todavía no asignaste vehículos.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Documentaciones del vehículo -->
        <div class="box box-custom-enod ayuda_veh_box">
            <div class="box-header with-border"><h3 class="ayuda_veh_title">Documentaciones del vehículo</h3></div>
            <div class="box-body">
                <table class="table table-hover table-striped table-condensed ayuda_veh_table">
                    <thead><tr>
                        <th>TÍTULO</th><th>DESCRIPCIÓN</th><th class="text-center" style="width:30px;"></th>
                    </tr></thead>
                    <tbody>
                        <tr v-for="d in docVehiculo" :key="d.id">
                            <td>{{ d.titulo }}</td>
                            <td>{{ d.descripcion }}</td>
                            <td class="text-center"><i class="fa fa-file-image-o" style="color:#d4a800;"></i></td>
                        </tr>
                        <tr v-if="!docVehiculo.length"><td colspan="3" class="ayuda_veh_empty text-muted">Sin documentaciones cargadas para los vehículos asignados.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Documentaciones complementarias -->
        <div class="box box-custom-enod ayuda_veh_box">
            <div class="box-body">
                <div class="form-group">
                    <label>Documentaciones</label>
                    <select class="form-control" v-model="docSel">
                        <option value="">— elegí una documentación —</option>
                        <option v-for="d in docDisponibles" :key="d.id" :value="d.id">{{ d.titulo }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-default" @click="agregarDoc" :disabled="!docSel"><i class="fa fa-plus-circle"></i></button>
                </div>
            </div>
        </div>

        <div class="box box-custom-enod ayuda_veh_box">
            <div class="box-header with-border"><h3 class="ayuda_veh_title">Documentaciones asignadas a la orden de trabajo</h3></div>
            <div class="box-body">
                <table class="table table-hover table-striped table-condensed ayuda_veh_table">
                    <thead><tr><th>Título</th><th>Descripción</th><th class="text-center" style="width:30px;"></th></tr></thead>
                    <tbody>
                        <tr v-for="d in docAsignadas" :key="d.id">
                            <td>{{ d.titulo }}</td>
                            <td>{{ d.descripcion }}</td>
                            <td class="text-center"><i class="fa fa-minus-circle ayuda_veh_remove" @click="quitarDoc(d.id)"></i></td>
                        </tr>
                        <tr v-if="!docAsignadas.length"><td colspan="3" class="ayuda_veh_empty text-muted">Sin documentaciones complementarias asignadas.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="ayuda_veh_actions">
            <button class="btn btn-enod">Actualizar</button>
        </div>

        <p class="ayuda_demo_caption">
            Al asignar un vehículo, sus documentaciones (VTV, seguro) aparecen automáticamente en la tabla "Documentaciones del vehículo".
            Las documentaciones complementarias son aparte, las cargás vos.
        </p>
    </div>
</template>

<script>
const VEHICULOS = [
    { id: 1, nro_interno: '001', marca: 'Toyota',  modelo: 'Hilux 4x4 2022',  patente: 'AB 234 CD', tipo: 'Camioneta' },
    { id: 2, nro_interno: '002', marca: 'Ford',    modelo: 'Ranger XLT 2023', patente: 'AC 887 LM', tipo: 'Camioneta' },
    { id: 3, nro_interno: '003', marca: 'VW',      modelo: 'Amarok 2021',     patente: 'AE 102 NK', tipo: 'Camioneta' },
    { id: 4, nro_interno: '004', marca: 'Iveco',   modelo: 'Daily furgón',    patente: 'AD 556 QR', tipo: 'Furgón' },
];
const DOCS_VEH_POOL = {
    1: [{ id: 11, titulo: 'VTV Hilux',  descripcion: 'VTV vigente hasta 10/11/2026' },
        { id: 12, titulo: 'Seguro',     descripcion: 'Póliza La Caja vence 15/12/2026' }],
    3: [{ id: 31, titulo: 'VTV Amarok', descripcion: 'Vence en 10 días' }],
};
const DOCS = [
    { id: 101, titulo: 'Plan de seguridad', descripcion: 'PDS de la obra Tramo 12' },
    { id: 102, titulo: 'Procedimiento de manejo defensivo', descripcion: 'Capacitación obligatoria 2026' },
    { id: 103, titulo: 'Mapa de riesgos vial', descripcion: 'Ruta NEA' },
];

export default {
    name: 'ayuda-demo-asignar-vehiculos',
    data() {
        return {
            vehSel: '', docSel: '',
            vehAsignados: [VEHICULOS[0], VEHICULOS[2]],
            docAsignadas: [DOCS[0]],
        };
    },
    computed: {
        vehDisponibles() {
            const used = new Set(this.vehAsignados.map(x => x.id));
            return VEHICULOS.filter(v => !used.has(v.id));
        },
        docDisponibles() {
            const used = new Set(this.docAsignadas.map(x => x.id));
            return DOCS.filter(d => !used.has(d.id));
        },
        docVehiculo() {
            const out = [];
            this.vehAsignados.forEach(v => {
                if (DOCS_VEH_POOL[v.id]) out.push(...DOCS_VEH_POOL[v.id]);
            });
            return out;
        },
    },
    methods: {
        agregarVehiculo() {
            const v = VEHICULOS.find(x => x.id === Number(this.vehSel));
            if (v) { this.vehAsignados.push(v); this.vehSel = ''; }
        },
        quitarVehiculo(id) { this.vehAsignados = this.vehAsignados.filter(v => v.id !== id); },
        agregarDoc() {
            const d = DOCS.find(x => x.id === Number(this.docSel));
            if (d) { this.docAsignadas.push(d); this.docSel = ''; }
        },
        quitarDoc(id) { this.docAsignadas = this.docAsignadas.filter(d => d.id !== id); },
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
.ayuda_veh_box {
    border: 1px solid #eef0f3; border-top: 3px solid #FFCC00;
    border-radius: 4px; box-shadow: none; margin-bottom: 14px;
}
.ayuda_veh_box .box-body { padding: 14px; }
.ayuda_veh_box .box-header { border-bottom: 1px solid #eef0f3; padding: 10px 14px; }
.ayuda_veh_title { margin: 0; font-size: 13.5px; font-weight: 600; color: #d4a800; }
.ayuda_veh_box label { font-size: 13px; color: #4c5661; margin-bottom: 4px; font-weight: 600; }
.ayuda_veh_box .form-control { height: 34px; border-radius: 4px; }
.ayuda_veh_box .btn-default { padding: 4px 10px; font-size: 13px; }
.ayuda_veh_box .btn-default i { color: #4c5661; font-size: 16px; }

.ayuda_veh_table { margin: 0; }
.ayuda_veh_table thead th {
    border-bottom: 2px solid #FFCC00; background: #fafbfc;
    color: #1a1a1a; font-size: 13px; font-weight: 700; padding: 6px 10px;
}
.ayuda_veh_table tbody td { padding: 8px 10px; font-size: 13px; vertical-align: middle; }
.ayuda_veh_remove {
    color: #1a1a1a; cursor: pointer; font-size: 16px;
    background: #f3f4f6; border-radius: 50%; padding: 2px;
    transition: all 0.12s ease;
}
.ayuda_veh_remove:hover { background: #dc3545; color: #fff; }
.ayuda_veh_empty { font-style: italic; padding: 14px 10px !important; text-align: center; }

.ayuda_veh_actions { margin: 14px 0 0; }
.ayuda_veh_actions .btn { padding: 6px 18px; font-weight: 700; }

.ayuda_demo_caption {
    margin: 10px 0 0; font-size: 12px; color: #6b7280; font-style: italic;
}
</style>
