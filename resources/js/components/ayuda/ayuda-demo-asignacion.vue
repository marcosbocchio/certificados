<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Asignar {{ config.plural }} a la OT</div>
        <div class="box box-custom-enod ayuda_real_box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i :class="'fa fa-' + config.icono"></i>&nbsp;
                    Asignar {{ config.plural }} · OT-1542
                </h3>
            </div>
            <div class="box-body">
                <!-- Buscador -->
                <div class="ayuda_asign_search">
                    <i class="fa fa-search"></i>
                    <input type="text" class="form-control" v-model="busqueda"
                           :placeholder="'Buscar ' + config.singular + ' por ' + config.placeholderBusqueda + '...'" />
                </div>

                <div class="row ayuda_asign_grid">
                    <!-- Disponibles -->
                    <div class="col-sm-6">
                        <div class="ayuda_asign_col">
                            <div class="ayuda_asign_col_head">
                                <i class="fa fa-list"></i>
                                Disponibles
                                <span class="badge">{{ disponibles.length }}</span>
                            </div>
                            <ul class="ayuda_asign_list">
                                <li v-for="(item, i) in disponibles" :key="i"
                                    @click="asignar(item)"
                                    class="ayuda_asign_item">
                                    <div class="ayuda_asign_item_main">
                                        <strong>{{ item[config.campos[0]] }}</strong>
                                        <small>{{ item[config.campos[1]] }}</small>
                                    </div>
                                    <span class="ayuda_asign_action">
                                        <i class="fa fa-plus-circle"></i>
                                    </span>
                                </li>
                                <li v-if="!disponibles.length" class="ayuda_asign_empty">
                                    <i class="fa fa-info-circle"></i>&nbsp; Sin resultados.
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Asignados -->
                    <div class="col-sm-6">
                        <div class="ayuda_asign_col ayuda_asign_col--selected">
                            <div class="ayuda_asign_col_head">
                                <i class="fa fa-check-circle"></i>
                                Asignados a esta OT
                                <span class="badge ayuda_badge_ok">{{ asignados.length }}</span>
                            </div>
                            <ul class="ayuda_asign_list">
                                <li v-for="(item, i) in asignados" :key="i" class="ayuda_asign_item ayuda_asign_item--selected">
                                    <div class="ayuda_asign_item_main">
                                        <strong>{{ item[config.campos[0]] }}</strong>
                                        <small>{{ item[config.campos[1]] }}</small>
                                        <span v-if="item.alerta" class="label label-danger ayuda_alerta_chip"
                                              :title="item.alerta">
                                            <i class="fa fa-warning"></i>
                                        </span>
                                    </div>
                                    <span class="ayuda_asign_action ayuda_asign_action--del" @click="quitar(item)">
                                        <i class="fa fa-times-circle"></i>
                                    </span>
                                </li>
                                <li v-if="!asignados.length" class="ayuda_asign_empty">
                                    Nada asignado todavía. Click en un ítem de la izquierda.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="enod-form-actions enod-form-actions--end">
                    <button class="btn btn-default" disabled>Cancelar</button>
                    <button class="btn btn-enod" disabled>
                        <i class="fa fa-save"></i>&nbsp; Actualizar asignación
                    </button>
                </div>
            </div>
        </div>
        <div class="ayuda_demo_caption">
            <span v-html="config.captionHTML"></span>
            Hacé click en un ítem de la izquierda para asignarlo. Probá con el buscador.
        </div>
    </div>
</template>

<script>
const CONFIG = {
    operador: {
        singular: 'operador',
        plural: 'operadores',
        icono: 'users',
        placeholderBusqueda: 'nombre o función',
        campos: ['nombre', 'funcion'],
        captionHTML: 'La <i class="fa fa-warning text-danger"></i> indica que el operador tiene documentación próxima a vencer.',
        disponibles: [
            { nombre: 'Juan Pérez',     funcion: 'Operador RI Nivel II',     alerta: '' },
            { nombre: 'Marcos Aguirre', funcion: 'Asistente',                 alerta: '' },
            { nombre: 'Lucía Mendoza',  funcion: 'Inspector cliente',         alerta: '' },
            { nombre: 'Diego Salas',    funcion: 'Operador PM Nivel II',      alerta: 'ART vence en 5 días' },
            { nombre: 'Ana Torres',     funcion: 'Operador LP Nivel I',       alerta: '' },
            { nombre: 'Roberto Cruz',   funcion: 'Operador US Nivel II',      alerta: '' },
        ],
        asignadosIniciales: [0, 1],
    },
    soldador: {
        singular: 'soldador',
        plural: 'soldadores y usuarios cliente',
        icono: 'fire',
        placeholderBusqueda: 'código o nombre',
        campos: ['codigo', 'nombre'],
        captionHTML: 'Los soldadores asignados quedan disponibles después en el formulario de informes RI (pasadas).',
        disponibles: [
            { codigo: 'S-104', nombre: 'A. Gómez - GTAW / SMAW',            alerta: '' },
            { codigo: 'S-118', nombre: 'M. Suárez - SMAW',                   alerta: '' },
            { codigo: 'S-122', nombre: 'C. Núñez - SMAW',                    alerta: 'EPS-API-1104 vencido' },
            { codigo: 'S-130', nombre: 'R. Vargas - GTAW / FCAW',            alerta: '' },
            { codigo: 'S-145', nombre: 'P. Acosta - SMAW',                   alerta: '' },
            { codigo: 'USR-CL', nombre: 'YPF Supervisor obra (cliente)',     alerta: '' },
        ],
        asignadosIniciales: [0, 1, 2],
    },
    vehiculo: {
        singular: 'vehículo',
        plural: 'vehículos',
        icono: 'truck',
        placeholderBusqueda: 'patente o modelo',
        campos: ['patente', 'modelo'],
        captionHTML: 'La documentación del vehículo (VTV, seguro, RTO) viaja con la OT y la ve también el cliente.',
        disponibles: [
            { patente: 'AB 234 CD', modelo: 'Toyota Hilux 4x4 - 2022',       alerta: '' },
            { patente: 'AC 887 LM', modelo: 'Ford Ranger XLT - 2023',         alerta: '' },
            { patente: 'AE 102 NK', modelo: 'VW Amarok - 2021',               alerta: 'VTV vence en 10 días' },
            { patente: 'AD 556 QR', modelo: 'Iveco Daily furgón - 2020',      alerta: '' },
            { patente: 'AB 778 XY', modelo: 'Toyota Hilux 4x4 - 2024',        alerta: '' },
        ],
        asignadosIniciales: [0, 2],
    },
    procedimiento: {
        singular: 'procedimiento',
        plural: 'procedimientos',
        icono: 'file-text-o',
        placeholderBusqueda: 'código o método',
        campos: ['codigo', 'descripcion'],
        captionHTML: 'Para algunos métodos NDT el procedimiento es <strong>obligatorio</strong>: si falta, el informe no se puede firmar.',
        disponibles: [
            { codigo: 'PR-RI-007',  descripcion: 'Radiografía industrial - DDSE rev.3',          alerta: '' },
            { codigo: 'PR-PM-002',  descripcion: 'Partículas magnéticas - Yugo rev.2',           alerta: '' },
            { codigo: 'PR-LP-004',  descripcion: 'Líquidos penetrantes - Solv. removible rev.1', alerta: '' },
            { codigo: 'PR-US-009',  descripcion: 'Ultrasonido convencional rev.4',                alerta: '' },
            { codigo: 'PR-US-012',  descripcion: 'Phase Array rev.2',                              alerta: '' },
            { codigo: 'PR-VT-001',  descripcion: 'Inspección visual rev.5',                        alerta: '' },
        ],
        asignadosIniciales: [0, 1, 2],
    },
};

export default {
    name: 'ayuda-demo-asignacion',
    props: {
        entidad: { type: String, required: true,
                   validator: v => Object.keys(CONFIG).includes(v) },
    },
    data() {
        const cfg = CONFIG[this.entidad];
        return {
            busqueda: '',
            asignadosIdx: [...cfg.asignadosIniciales],
            todos: cfg.disponibles.map((d, i) => ({ ...d, _i: i })),
        };
    },
    computed: {
        config() { return CONFIG[this.entidad]; },
        disponibles() {
            const q = this.busqueda.trim().toLowerCase();
            return this.todos
                .filter(t => !this.asignadosIdx.includes(t._i))
                .filter(t => !q || (
                    String(t[this.config.campos[0]]).toLowerCase().includes(q) ||
                    String(t[this.config.campos[1]]).toLowerCase().includes(q)
                ));
        },
        asignados() {
            return this.asignadosIdx.map(i => this.todos[i]);
        },
    },
    methods: {
        asignar(item) {
            if (!this.asignadosIdx.includes(item._i)) this.asignadosIdx.push(item._i);
        },
        quitar(item) {
            this.asignadosIdx = this.asignadosIdx.filter(i => i !== item._i);
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
.ayuda_real_box {
    border: 1px solid #eef0f3;
    border-top: 3px solid #FFCC00;
    border-radius: 4px;
    box-shadow: none;
}
.ayuda_real_box .box-header { border-bottom: 1px solid #eef0f3; padding: 10px 14px; }
.ayuda_real_box .box-title { font-size: 14px; font-weight: 700; color: #1a1a1a; }
.ayuda_real_box .box-title i { color: #FFCC00; }
.ayuda_real_box .box-body { padding: 14px; }

.ayuda_asign_search {
    position: relative;
    margin-bottom: 12px;
}
.ayuda_asign_search i.fa-search {
    position: absolute; top: 50%; left: 12px;
    transform: translateY(-50%);
    color: #9ca3af; z-index: 1;
}
.ayuda_asign_search input.form-control {
    padding-left: 32px;
    height: 34px;
}

.ayuda_asign_grid { display: flex; flex-wrap: wrap; margin: 0 -8px; }
.ayuda_asign_col {
    background: #fafbfc;
    border: 1px solid #eef0f3;
    border-radius: 4px;
    height: 100%;
    overflow: hidden;
}
.ayuda_asign_col--selected {
    background: #fffdf5;
    border-color: #f0df9a;
    border-left: 3px solid #FFCC00;
}
.ayuda_asign_col_head {
    padding: 8px 12px;
    font-size: 11.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #4c5661;
    background: #fff;
    border-bottom: 1px solid #eef0f3;
    display: flex;
    align-items: center;
    gap: 6px;
}
.ayuda_asign_col_head .badge {
    margin-left: auto;
    background: #6b7280;
    color: #fff;
    font-size: 10px;
}
.ayuda_asign_col_head .ayuda_badge_ok {
    background: #1b6b34;
}

.ayuda_asign_list {
    list-style: none;
    margin: 0;
    padding: 0;
    max-height: 260px;
    overflow-y: auto;
}
.ayuda_asign_item {
    display: flex;
    align-items: center;
    padding: 8px 12px;
    border-bottom: 1px solid #f3f4f6;
    cursor: pointer;
    transition: background 0.1s ease;
    gap: 8px;
}
.ayuda_asign_item:last-child { border-bottom: 0; }
.ayuda_asign_item:hover { background: #fff7d6; }
.ayuda_asign_item--selected { cursor: default; background: transparent; }
.ayuda_asign_item--selected:hover { background: transparent; }
.ayuda_asign_item_main {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
}
.ayuda_asign_item_main strong {
    font-size: 13px;
    color: #1a1a1a;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 6px;
}
.ayuda_asign_item_main small {
    font-size: 11.5px;
    color: #6b7280;
    line-height: 1.3;
}
.ayuda_asign_action {
    color: #1b6b34;
    font-size: 16px;
    flex-shrink: 0;
}
.ayuda_asign_action--del {
    color: #dc3545;
    cursor: pointer;
}
.ayuda_alerta_chip {
    font-size: 9.5px;
    padding: 2px 5px;
    background: #fdecec;
    color: #8a1f2a;
    border: 1px solid #f5b5bb;
}
.ayuda_asign_empty {
    padding: 14px;
    text-align: center;
    color: #9ca3af;
    font-style: italic;
    font-size: 12.5px;
}

.enod-form-actions { border-top: 1px solid #eef0f3; padding-top: 12px; margin-top: 12px; }

.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}

@media (max-width: 768px) {
    .ayuda_asign_grid > div { padding: 6px 8px; }
}
</style>
