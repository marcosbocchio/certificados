<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Pantalla de procedimientos</div>

        <!-- Botón Nuevo (procedimiento Enod) -->
        <div class="ayuda_proc_topbar">
            <button class="btn btn-enod"><i class="fa fa-plus"></i>&nbsp; Nuevo</button>
        </div>

        <!-- Tabla Procedimientos Enod -->
        <div class="box box-custom-enod ayuda_proc_box">
            <div class="box-header with-border"><h3 class="ayuda_proc_title">Procedimientos Enod</h3></div>
            <div class="box-body">
                <table class="table table-hover table-striped table-condensed ayuda_proc_table">
                    <thead><tr>
                        <th>Tipo</th><th>Título</th><th>Descripción</th><th>Método</th><th class="text-center" style="width:30px;"></th>
                    </tr></thead>
                    <tbody>
                        <tr v-for="p in procsEnod" :key="p.id">
                            <td>{{ p.tipo }}</td>
                            <td>{{ p.titulo }}</td>
                            <td>{{ p.descripcion }}</td>
                            <td>{{ p.metodo }}</td>
                            <td class="text-center"><i class="fa fa-file-pdf-o" style="color:#d4a800;" title="Ver PDF"></i></td>
                        </tr>
                        <tr v-if="!procsEnod.length"><td colspan="5" class="ayuda_proc_empty text-muted">Sin procedimientos Enod cargados.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Procedimientos cliente: formulario inline -->
        <div class="box box-custom-enod ayuda_proc_box">
            <div class="box-header with-border"><h3 class="ayuda_proc_title">Procedimientos clientes</h3></div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-2 col-sm-4">
                        <div class="form-group">
                            <label>Tipo Sol.</label>
                            <select class="form-control" v-model="form.tipoSol">
                                <option value="">— elegí —</option>
                                <option>LR</option>
                                <option>CL</option>
                                <option>JT</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4">
                        <div class="form-group">
                            <label>Obra N°</label>
                            <input type="text" class="form-control" value="777" disabled />
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <div class="form-group">
                            <label>EPS / WPS <span class="ayuda_proc_req">*</span></label>
                            <input type="text" class="form-control" v-model="form.eps" placeholder="EPS-API-1104" />
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <div class="form-group">
                            <label>PQR <span class="ayuda_proc_req">*</span></label>
                            <input type="text" class="form-control" v-model="form.pqr" placeholder="PQR-001/24" />
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <div class="form-group">
                            <label>Proc.Reparación <span class="ayuda_proc_req">*</span></label>
                            <input type="text" class="form-control" v-model="form.rep" placeholder="PR-REP-007" />
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button class="btn btn-default ayuda_proc_add" @click="agregarProcCliente" :disabled="!puedeAgregar" title="Agregar">
                                <i class="fa fa-plus-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <table v-if="procsCliente.length" class="table table-hover table-striped table-condensed ayuda_proc_table" style="margin-top:8px;">
                    <thead><tr>
                        <th>Tipo Sol.</th><th>Obra N°</th><th>EPS / WPS</th><th>PQR</th><th>Proc. Reparación</th><th class="text-center" style="width:30px;"></th>
                    </tr></thead>
                    <tbody>
                        <tr v-for="p in procsCliente" :key="p.id">
                            <td>{{ p.tipoSol }}</td>
                            <td>{{ p.obra }}</td>
                            <td>{{ p.eps }}</td>
                            <td>{{ p.pqr }}</td>
                            <td>{{ p.rep }}</td>
                            <td class="text-center"><i class="fa fa-minus-circle ayuda_proc_remove" @click="quitarProcCliente(p.id)"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="ayuda_proc_actions">
            <button class="btn btn-enod">Actualizar</button>
        </div>

        <p class="ayuda_demo_caption">
            <strong>"Nuevo"</strong> abre un formulario para cargar un procedimiento Enod (con PDF).
            Los <strong>procedimientos del cliente</strong> se cargan inline con EPS/WPS, PQR y Proc. de reparación.
            Los tres campos con <span class="ayuda_proc_req">*</span> son obligatorios.
        </p>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-asignar-procedimientos',
    data() {
        return {
            procsEnod: [
                { id: 1, tipo: 'Procedimiento', titulo: 'PR-RI-007', descripcion: 'Radiografía industrial DDSE',    metodo: 'RI' },
                { id: 2, tipo: 'Procedimiento', titulo: 'PR-PM-002', descripcion: 'Partículas magnéticas - Yugo',    metodo: 'PM' },
                { id: 3, tipo: 'Procedimiento', titulo: 'PR-LP-004', descripcion: 'Líquidos penetrantes',             metodo: 'LP' },
            ],
            procsCliente: [
                { id: 1, tipoSol: 'LR', obra: '777', eps: 'EPS-API-1104', pqr: 'PQR-001/24', rep: 'PR-REP-007' },
            ],
            form: { tipoSol: '', eps: '', pqr: '', rep: '' },
            nextId: 2,
        };
    },
    computed: {
        puedeAgregar() {
            return this.form.eps && this.form.pqr && this.form.rep;
        },
    },
    methods: {
        agregarProcCliente() {
            if (!this.puedeAgregar) return;
            this.procsCliente.push({
                id: this.nextId++,
                tipoSol: this.form.tipoSol || '—',
                obra: '777',
                eps: this.form.eps,
                pqr: this.form.pqr,
                rep: this.form.rep,
            });
            this.form = { tipoSol: '', eps: '', pqr: '', rep: '' };
        },
        quitarProcCliente(id) {
            this.procsCliente = this.procsCliente.filter(p => p.id !== id);
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

.ayuda_proc_topbar { margin-bottom: 10px; }
.ayuda_proc_topbar .btn { padding: 7px 18px; font-weight: 700; }

.ayuda_proc_box {
    border: 1px solid #eef0f3; border-top: 3px solid #FFCC00;
    border-radius: 4px; box-shadow: none; margin-bottom: 14px;
}
.ayuda_proc_box .box-body { padding: 14px; }
.ayuda_proc_box .box-header { border-bottom: 1px solid #eef0f3; padding: 10px 14px; }
.ayuda_proc_title { margin: 0; font-size: 13.5px; font-weight: 600; color: #d4a800; }
.ayuda_proc_box label { font-size: 13px; color: #4c5661; margin-bottom: 4px; font-weight: 600; }
.ayuda_proc_box .form-control { height: 34px; border-radius: 4px; }

.ayuda_proc_req { color: #dc3545; font-weight: 700; }
.ayuda_proc_add { padding: 4px 10px; }
.ayuda_proc_add i { color: #4c5661; font-size: 16px; }

.ayuda_proc_table { margin: 0; }
.ayuda_proc_table thead th {
    border-bottom: 2px solid #FFCC00; background: #fafbfc;
    color: #1a1a1a; font-size: 13px; font-weight: 700; padding: 6px 10px;
}
.ayuda_proc_table tbody td { padding: 8px 10px; font-size: 13px; vertical-align: middle; }
.ayuda_proc_remove {
    color: #1a1a1a; cursor: pointer; font-size: 16px;
    background: #f3f4f6; border-radius: 50%; padding: 2px;
    transition: all 0.12s ease;
}
.ayuda_proc_remove:hover { background: #dc3545; color: #fff; }
.ayuda_proc_empty { font-style: italic; padding: 14px 10px !important; text-align: center; }

.ayuda_proc_actions { margin: 14px 0 0; }
.ayuda_proc_actions .btn { padding: 6px 18px; font-weight: 700; }

.ayuda_demo_caption {
    margin: 10px 0 0; font-size: 12px; color: #6b7280; font-style: italic;
}
</style>
