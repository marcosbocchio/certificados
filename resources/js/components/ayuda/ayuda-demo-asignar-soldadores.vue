<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Pantalla de soldadores y usuarios cliente</div>

        <!-- Soldadores -->
        <div class="box box-custom-enod ayuda_sol_box">
            <div class="box-body">
                <div class="form-group">
                    <label>Soldadores</label>
                    <select class="form-control" v-model="solSel">
                        <option value="">— elegí un soldador —</option>
                        <option v-for="s in solDisponibles" :key="s.id" :value="s.id">{{ s.nombre }} ({{ s.codigo }})</option>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-default" @click="agregarSoldador" :disabled="!solSel">
                        <i class="fa fa-plus-circle"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="box box-custom-enod ayuda_sol_box">
            <div class="box-header with-border"><h3 class="ayuda_sol_title">Soldadores Asignados Orden de Trabajo</h3></div>
            <div class="box-body">
                <table class="table table-hover table-striped table-condensed ayuda_sol_table">
                    <thead><tr><th>CODIGO</th><th>NOMBRE</th><th class="text-center" style="width:30px;"></th></tr></thead>
                    <tbody>
                        <tr v-for="s in solAsignados" :key="s.id">
                            <td>{{ s.codigo }}</td>
                            <td>{{ s.nombre }}</td>
                            <td class="text-center"><i class="fa fa-minus-circle ayuda_sol_remove" @click="quitarSoldador(s.id)"></i></td>
                        </tr>
                        <tr v-if="!solAsignados.length"><td colspan="3" class="ayuda_sol_empty text-muted">Todavía no asignaste soldadores.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Usuarios Cliente -->
        <div class="box box-custom-enod ayuda_sol_box">
            <div class="box-body">
                <div class="form-group">
                    <label>Usuarios Cliente</label>
                    <select class="form-control" v-model="userSel">
                        <option value="">— elegí un usuario cliente —</option>
                        <option v-for="u in userDisponibles" :key="u.id" :value="u.id">{{ u.name }}</option>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-default" @click="agregarUsuario" :disabled="!userSel">
                        <i class="fa fa-plus-circle"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="box box-custom-enod ayuda_sol_box">
            <div class="box-header with-border"><h3 class="ayuda_sol_title">Usuarios del Cliente Asignados Orden de Trabajo</h3></div>
            <div class="box-body">
                <table class="table table-hover table-striped table-condensed ayuda_sol_table">
                    <thead><tr><th>NOMBRE</th><th>EMAIL</th><th class="text-center" style="width:30px;"></th></tr></thead>
                    <tbody>
                        <tr v-for="u in userAsignados" :key="u.id">
                            <td>{{ u.name }}</td>
                            <td>{{ u.email }}</td>
                            <td class="text-center"><i class="fa fa-minus-circle ayuda_sol_remove" @click="quitarUsuario(u.id)"></i></td>
                        </tr>
                        <tr v-if="!userAsignados.length"><td colspan="3" class="ayuda_sol_empty text-muted">Todavía no asignaste usuarios cliente.</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="ayuda_sol_actions">
            <button class="btn btn-enod">Actualizar</button>
        </div>

        <p class="ayuda_demo_caption">
            Soldadores y usuarios cliente comparten esta pantalla. Si la lista de soldadores está vacía, primero hay que cargarlos en
            <strong>Gestionar soldadores</strong> para ese cliente.
        </p>
    </div>
</template>

<script>
const SOLDADORES = [
    { id: 1, codigo: 'S-104', nombre: 'A. Gómez' },
    { id: 2, codigo: 'S-118', nombre: 'M. Suárez' },
    { id: 3, codigo: 'S-122', nombre: 'C. Núñez' },
    { id: 4, codigo: 'S-130', nombre: 'R. Vargas' },
];
const USERS = [
    { id: 1, name: 'YPF Supervisor obra', email: 'sup@ypf.com' },
    { id: 2, name: 'YPF Inspector calidad', email: 'calidad@ypf.com' },
    { id: 3, name: 'Techint Ingeniero', email: 'ing@techint.com' },
];

export default {
    name: 'ayuda-demo-asignar-soldadores',
    data() {
        return {
            solSel: '', userSel: '',
            solAsignados: [SOLDADORES[0], SOLDADORES[1]],
            userAsignados: [USERS[0]],
        };
    },
    computed: {
        solDisponibles() {
            const used = new Set(this.solAsignados.map(x => x.id));
            return SOLDADORES.filter(s => !used.has(s.id));
        },
        userDisponibles() {
            const used = new Set(this.userAsignados.map(x => x.id));
            return USERS.filter(u => !used.has(u.id));
        },
    },
    methods: {
        agregarSoldador() {
            const item = SOLDADORES.find(s => s.id === Number(this.solSel));
            if (item) { this.solAsignados.push(item); this.solSel = ''; }
        },
        quitarSoldador(id) { this.solAsignados = this.solAsignados.filter(s => s.id !== id); },
        agregarUsuario() {
            const item = USERS.find(u => u.id === Number(this.userSel));
            if (item) { this.userAsignados.push(item); this.userSel = ''; }
        },
        quitarUsuario(id) { this.userAsignados = this.userAsignados.filter(u => u.id !== id); },
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
.ayuda_sol_box {
    border: 1px solid #eef0f3;
    border-top: 3px solid #FFCC00;
    border-radius: 4px;
    box-shadow: none;
    margin-bottom: 14px;
}
.ayuda_sol_box .box-body { padding: 14px; }
.ayuda_sol_box .box-header { border-bottom: 1px solid #eef0f3; padding: 10px 14px; }
.ayuda_sol_title {
    margin: 0; font-size: 13.5px; font-weight: 600; color: #d4a800;
}
.ayuda_sol_box label { font-size: 13px; color: #4c5661; margin-bottom: 4px; font-weight: 600; }
.ayuda_sol_box .form-control { height: 34px; border-radius: 4px; }
.ayuda_sol_box .btn-default { padding: 4px 10px; font-size: 13px; }
.ayuda_sol_box .btn-default i { color: #4c5661; font-size: 16px; }

.ayuda_sol_table { margin: 0; }
.ayuda_sol_table thead th {
    border-bottom: 2px solid #FFCC00;
    background: #fafbfc;
    color: #1a1a1a;
    font-size: 13px;
    font-weight: 700;
    padding: 6px 10px;
}
.ayuda_sol_table tbody td { padding: 8px 10px; font-size: 13px; vertical-align: middle; }
.ayuda_sol_remove {
    color: #1a1a1a; cursor: pointer; font-size: 16px;
    background: #f3f4f6; border-radius: 50%; padding: 2px;
    transition: all 0.12s ease;
}
.ayuda_sol_remove:hover { background: #dc3545; color: #fff; }
.ayuda_sol_empty { font-style: italic; padding: 14px 10px !important; text-align: center; }

.ayuda_sol_actions { margin: 14px 0 0; }
.ayuda_sol_actions .btn { padding: 6px 18px; font-weight: 700; }

.ayuda_demo_caption {
    margin: 10px 0 0; font-size: 12px; color: #6b7280; font-style: italic;
}
</style>
