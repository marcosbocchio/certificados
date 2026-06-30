<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Listado de {{ cfg.plural }}</div>
        <div class="box box-custom-enod ayuda_real_box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i :class="'fa fa-' + cfg.icono"></i>&nbsp; Gestión de {{ cfg.plural }}
                </h3>
                <div class="box-tools pull-right">
                    <button class="btn btn-enod btn-sm"><i class="fa fa-plus"></i>&nbsp; Nuevo</button>
                </div>
            </div>
            <div class="box-body">
                <!-- Filtros / búsqueda -->
                <div class="ayuda_abm_toolbar">
                    <div class="ayuda_abm_search">
                        <i class="fa fa-search"></i>
                        <input type="text" class="form-control input-sm" v-model="busqueda"
                               :placeholder="'Buscar ' + cfg.singular + '...'" />
                    </div>
                    <select class="form-control input-sm ayuda_abm_pp" v-model="porPagina">
                        <option :value="5">5 por página</option>
                        <option :value="10">10 por página</option>
                        <option :value="25">25 por página</option>
                    </select>
                </div>

                <!-- Tabla -->
                <div class="ayuda_table_wrap">
                    <table class="table table-hover table-striped table-bordered table-condensed ayuda_real_table">
                        <thead>
                            <tr>
                                <th v-for="(col, i) in cfg.columnas" :key="i">{{ col }}</th>
                                <th class="text-center" style="width:90px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(fila, i) in filasFiltradas" :key="i">
                                <td v-for="(valor, j) in fila" :key="j">
                                    <strong v-if="j === 0">{{ valor }}</strong>
                                    <span v-else>{{ valor }}</span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-default btn-xs" title="Ver"><i class="fa fa-eye"></i></button>
                                    <button class="btn btn-enod btn-xs" title="Editar"><i class="fa fa-pencil"></i></button>
                                    <button class="btn btn-enod-danger btn-xs" title="Eliminar"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr v-if="!filasFiltradas.length">
                                <td :colspan="cfg.columnas.length + 1" class="text-center text-muted ayuda_empty">
                                    <i class="fa fa-info-circle"></i>&nbsp;
                                    Sin resultados para "<strong>{{ busqueda }}</strong>".
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Paginador -->
                <div class="ayuda_abm_footer">
                    <span class="text-muted">Mostrando {{ filasFiltradas.length }} de {{ cfg.filas.length }} {{ cfg.plural }}</span>
                    <ul class="pagination pagination-sm ayuda_abm_pagination">
                        <li class="disabled"><a href="#" @click.prevent>«</a></li>
                        <li class="active"><a href="#" @click.prevent>1</a></li>
                        <li class="disabled"><a href="#" @click.prevent>»</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="ayuda_demo_caption">
            <i class="fa fa-eye"></i> Ver detalle ·
            <i class="fa fa-pencil"></i> Editar registro ·
            <i class="fa fa-trash"></i> Eliminar (solo si no tiene registros asociados).
            El botón <strong>Nuevo</strong> abre el formulario de alta.
        </div>
    </div>
</template>

<script>
import { ABM } from './abm-config.js';

export default {
    name: 'ayuda-demo-abm-tabla',
    props: {
        entidad: { type: String, required: true,
                   validator: v => Object.keys(ABM).includes(v) },
    },
    data() { return { busqueda: '', porPagina: 10 }; },
    computed: {
        cfg() { return ABM[this.entidad]; },
        filasFiltradas() {
            const q = this.busqueda.trim().toLowerCase();
            if (!q) return this.cfg.filas;
            return this.cfg.filas.filter(f => f.some(v => String(v).toLowerCase().includes(q)));
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

.ayuda_abm_toolbar {
    display: flex; gap: 8px; margin-bottom: 12px;
    align-items: center;
}
.ayuda_abm_search {
    position: relative; flex: 1;
}
.ayuda_abm_search i.fa-search {
    position: absolute; top: 50%; left: 10px;
    transform: translateY(-50%); color: #9ca3af; z-index: 1;
}
.ayuda_abm_search input.form-control { padding-left: 30px; }
.ayuda_abm_pp { width: 130px; flex-shrink: 0; }

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
.ayuda_real_table .btn-xs { margin: 0 1px; }
.ayuda_empty { padding: 16px !important; font-style: italic; }

.ayuda_abm_footer {
    display: flex; justify-content: space-between; align-items: center;
    margin-top: 10px; font-size: 12px;
}
.ayuda_abm_pagination { margin: 0; }

.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
</style>
