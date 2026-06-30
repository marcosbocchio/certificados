<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Buscador de listados</div>
        <div class="box box-custom-enod ayuda_real_box">
            <div class="box-header with-border ayuda_demo_header">
                <h3 class="box-title">
                    <i class="fa fa-list"></i>&nbsp; Listado de OT
                </h3>
                <div class="ayuda_box_tools">
                    <div class="ayuda_search_wrap">
                        <i class="fa fa-search"></i>
                        <input type="text" class="form-control input-sm" v-model="busqueda"
                               placeholder="Buscar..." />
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="ayuda_table_wrap">
                    <table class="table table-hover table-striped table-bordered table-condensed ayuda_real_table">
                        <thead>
                            <tr>
                                <th>OT N°</th>
                                <th>Cliente</th>
                                <th>Proyecto</th>
                                <th>Responsable</th>
                                <th class="text-center">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(ot, i) in filtradas" :key="i">
                                <td><strong v-html="resaltar(ot.numero)"></strong></td>
                                <td v-html="resaltar(ot.cliente)"></td>
                                <td v-html="resaltar(ot.proyecto)"></td>
                                <td v-html="resaltar(ot.responsable)"></td>
                                <td class="text-center">
                                    <span class="label" :class="badge(ot.estado)">{{ ot.estado }}</span>
                                </td>
                            </tr>
                            <tr v-if="!filtradas.length">
                                <td colspan="5" class="text-center text-muted ayuda_empty">
                                    <i class="fa fa-info-circle"></i>&nbsp;
                                    Sin coincidencias para "<strong>{{ busqueda }}</strong>".
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="ayuda_resumen">
                    <span class="text-muted">
                        Mostrando <strong>{{ filtradas.length }}</strong> de {{ filas.length }} OT
                    </span>
                </div>
            </div>
        </div>
        <div class="ayuda_demo_caption">
            Probá escribir "<strong>YPF</strong>", "<strong>RI</strong>" o "<strong>Pérez</strong>" en el buscador — el filtro es parcial y mira todos los campos visibles, resaltando las coincidencias en amarillo.
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-buscador',
    data() {
        return {
            busqueda: '',
            filas: [
                { numero: 'OT-1542', cliente: 'YPF S.A.',         proyecto: 'Gasoducto NEA - T12', responsable: 'Juan Pérez',    estado: 'Activa' },
                { numero: 'OT-1541', cliente: 'Techint',          proyecto: 'Planta Río III',       responsable: 'Marcos Aguirre', estado: 'Editando' },
                { numero: 'OT-1538', cliente: 'Pampa Energía',    proyecto: 'Refinería Loma',       responsable: 'Lucía Mendoza',  estado: 'Activa' },
                { numero: 'OT-1530', cliente: 'YPF S.A.',         proyecto: 'Mantto. Tanques 2026', responsable: 'Juan Pérez',    estado: 'Cerrada' },
                { numero: 'OT-1527', cliente: 'Tecpetrol',        proyecto: 'Reparación válvulas',  responsable: 'Diego Salas',   estado: 'Cerrada' },
                { numero: 'OT-1525', cliente: 'YPF S.A.',         proyecto: 'Línea de gas L-090',   responsable: 'Ana Torres',    estado: 'Cerrada' },
            ],
        };
    },
    computed: {
        filtradas() {
            const q = this.busqueda.trim().toLowerCase();
            if (!q) return this.filas;
            return this.filas.filter(f =>
                Object.values(f).some(v => String(v).toLowerCase().includes(q))
            );
        },
    },
    methods: {
        badge(e) {
            return {
                'Activa': 'label-success',
                'Editando': 'label-warning',
                'Cerrada': 'label-default',
            }[e];
        },
        resaltar(texto) {
            const q = this.busqueda.trim();
            const escaped = this.escapar(String(texto));
            if (!q) return escaped;
            const re = new RegExp('(' + q.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'ig');
            return escaped.replace(re, '<mark>$1</mark>');
        },
        escapar(s) {
            const d = document.createElement('div');
            d.textContent = s;
            return d.innerHTML;
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
.ayuda_demo_header {
    border-bottom: 1px solid #eef0f3;
    padding: 10px 14px;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}
.ayuda_real_box .box-title { font-size: 14px; font-weight: 700; color: #1a1a1a; margin: 0; flex: 1; }
.ayuda_real_box .box-title i { color: #FFCC00; }
.ayuda_real_box .box-body { padding: 14px; }

.ayuda_box_tools { display: flex; align-items: center; }
.ayuda_search_wrap {
    position: relative;
    width: 220px;
}
.ayuda_search_wrap i.fa-search {
    position: absolute; top: 50%; left: 10px;
    transform: translateY(-50%);
    color: #9ca3af; z-index: 1;
    font-size: 12px;
}
.ayuda_search_wrap input.form-control {
    padding-left: 30px;
    height: 30px;
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
.ayuda_real_table mark {
    background: #FFCC00;
    color: #1a1a1a;
    padding: 0 2px;
    border-radius: 2px;
}

.ayuda_empty { padding: 16px !important; font-style: italic; }
.ayuda_resumen { margin-top: 8px; font-size: 12px; }

.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
</style>
