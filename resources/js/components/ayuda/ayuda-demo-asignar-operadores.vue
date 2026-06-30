<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Pantalla de asignar operadores</div>

        <div class="ayuda_op_grid">
            <!-- Columna Operador -->
            <div class="box box-custom-enod">
                <div class="box-body">
                    <div class="form-group">
                        <label>Operador</label>
                        <select class="form-control" v-model="operadorSel">
                            <option value="">— elegí un operador —</option>
                            <option v-for="o in disponiblesOperador" :key="o.id" :value="o.id">{{ o.nombre }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-default" @click="asignar('operador')" :disabled="!operadorSel" title="Agregar operador">
                            <i class="fa fa-plus-circle"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Columna Ayudante -->
            <div class="box box-custom-enod">
                <div class="box-body">
                    <div class="form-group">
                        <label>Ayudante</label>
                        <select class="form-control" v-model="ayudanteSel">
                            <option value="">— elegí un ayudante —</option>
                            <option v-for="o in disponiblesAyudante" :key="o.id" :value="o.id">{{ o.nombre }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-default" @click="asignar('ayudante')" :disabled="!ayudanteSel" title="Agregar ayudante">
                            <i class="fa fa-plus-circle"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Lista operadores asignados -->
            <div class="box box-custom-enod">
                <div class="box-header with-border">
                    <h3 class="ayuda_op_title">Operadores asignados a la orden de trabajo</h3>
                </div>
                <div class="box-body">
                    <table class="table table-hover table-striped table-condensed ayuda_op_table">
                        <thead>
                            <tr><th>Nombre</th><th class="text-center" style="width:30px;"></th></tr>
                        </thead>
                        <tbody>
                            <tr v-for="o in asignadosOperador" :key="o.id">
                                <td>{{ o.nombre }}</td>
                                <td class="text-center"><i class="fa fa-minus-circle ayuda_op_remove" @click="quitar(o.id, 'operador')" title="Quitar"></i></td>
                            </tr>
                            <tr v-if="!asignadosOperador.length"><td colspan="2" class="text-muted ayuda_op_empty">Todavía no asignaste operadores.</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Lista ayudantes asignados -->
            <div class="box box-custom-enod">
                <div class="box-header with-border">
                    <h3 class="ayuda_op_title">Ayudantes asignados a la orden de trabajo</h3>
                </div>
                <div class="box-body">
                    <table class="table table-hover table-striped table-condensed ayuda_op_table">
                        <thead>
                            <tr><th>Nombre</th><th class="text-center" style="width:30px;"></th></tr>
                        </thead>
                        <tbody>
                            <tr v-for="o in asignadosAyudante" :key="o.id">
                                <td>{{ o.nombre }}</td>
                                <td class="text-center"><i class="fa fa-minus-circle ayuda_op_remove" @click="quitar(o.id, 'ayudante')" title="Quitar"></i></td>
                            </tr>
                            <tr v-if="!asignadosAyudante.length"><td colspan="2" class="text-muted ayuda_op_empty">Todavía no asignaste ayudantes.</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="ayuda_op_actions">
            <button class="btn btn-enod">Actualizar</button>
        </div>

        <p class="ayuda_demo_caption">
            Probá agregar y quitar — la lista se actualiza al instante. En el sistema real, el botón <strong>Actualizar</strong> graba los cambios.
        </p>
    </div>
</template>

<script>
const POOL = [
    { id: 1, nombre: 'SALDAMANDO EMMANUEL' },
    { id: 2, nombre: 'QUISPE MIGUEL' },
    { id: 3, nombre: 'IFRAN JOAQUIN' },
    { id: 4, nombre: 'PEREZ JUAN' },
    { id: 5, nombre: 'GOMEZ ANA' },
    { id: 6, nombre: 'TORRES LUIS' },
];

export default {
    name: 'ayuda-demo-asignar-operadores',
    data() {
        return {
            operadorSel: '',
            ayudanteSel: '',
            asignadosOperador: [POOL[0], POOL[1], POOL[2]],
            asignadosAyudante: [],
        };
    },
    computed: {
        disponiblesOperador() {
            const usados = new Set(this.asignadosOperador.map(x => x.id));
            return POOL.filter(o => !usados.has(o.id));
        },
        disponiblesAyudante() {
            const usados = new Set(this.asignadosAyudante.map(x => x.id));
            return POOL.filter(o => !usados.has(o.id));
        },
    },
    methods: {
        asignar(rol) {
            const id = rol === 'operador' ? this.operadorSel : this.ayudanteSel;
            const item = POOL.find(p => p.id === Number(id));
            if (!item) return;
            if (rol === 'operador') { this.asignadosOperador.push(item); this.operadorSel = ''; }
            else { this.asignadosAyudante.push(item); this.ayudanteSel = ''; }
        },
        quitar(id, rol) {
            if (rol === 'operador') this.asignadosOperador = this.asignadosOperador.filter(x => x.id !== id);
            else this.asignadosAyudante = this.asignadosAyudante.filter(x => x.id !== id);
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

.ayuda_op_grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}
.ayuda_op_grid .box {
    border: 1px solid #eef0f3;
    border-top: 3px solid #FFCC00;
    border-radius: 4px;
    box-shadow: none;
    margin-bottom: 0;
}
.ayuda_op_grid .box-body { padding: 14px; }
.ayuda_op_grid label { font-size: 13px; color: #4c5661; margin-bottom: 4px; font-weight: 600; }

.ayuda_op_grid .form-control {
    height: 34px;
    border-radius: 4px;
}
.ayuda_op_grid .btn {
    padding: 4px 10px;
    font-size: 13px;
}
.ayuda_op_grid .btn-default i { color: #4c5661; font-size: 16px; }

.ayuda_op_grid .box-header { border-bottom: 1px solid #eef0f3; padding: 10px 14px; }
.ayuda_op_title {
    margin: 0;
    font-size: 13.5px;
    font-weight: 600;
    color: #d4a800;
}

.ayuda_op_table { margin: 0; }
.ayuda_op_table thead th {
    border-bottom: 2px solid #FFCC00;
    background: #fafbfc;
    color: #1a1a1a;
    font-size: 13px;
    font-weight: 700;
    padding: 6px 10px;
}
.ayuda_op_table tbody td {
    padding: 8px 10px;
    font-size: 13px;
    color: #2b2f33;
    vertical-align: middle;
}
.ayuda_op_remove {
    color: #1a1a1a;
    cursor: pointer;
    font-size: 16px;
    background: #f3f4f6;
    border-radius: 50%;
    padding: 2px;
    transition: all 0.12s ease;
}
.ayuda_op_remove:hover { background: #dc3545; color: #fff; }
.ayuda_op_empty { font-style: italic; padding: 14px 10px !important; text-align: center; }

.ayuda_op_actions { margin: 14px 0 0; }
.ayuda_op_actions .btn { padding: 6px 18px; font-weight: 700; }

.ayuda_demo_caption {
    margin: 10px 0 0;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}

@media (max-width: 760px) { .ayuda_op_grid { grid-template-columns: 1fr; } }
</style>
