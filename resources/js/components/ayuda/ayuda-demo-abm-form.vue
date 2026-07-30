<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Formulario de alta de {{ cfg.singular }}</div>
        <div class="box box-custom-enod ayuda_real_box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i :class="'fa fa-' + cfg.icono"></i>&nbsp;
                    {{ modo === 'editar' ? 'Editar' : 'Nuevo' }} {{ cfg.singular }}
                </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div v-for="(campo, i) in cfg.campos" :key="i" :class="'col-sm-' + (campo.col || 6)">
                        <div class="form-group">
                            <label>{{ campo.label }} <span v-if="campo.req" class="ayuda_req">*</span></label>
                            <div v-if="campo.tipo === 'toggle'" class="ayuda_toggle_group">
                                <label v-for="(op, j) in campo.opciones" :key="j" class="ayuda_toggle_item">
                                    <input type="radio" :checked="op === campo.value" disabled /> {{ op }}
                                </label>
                            </div>
                            <div v-else-if="campo.tipo === 'checkboxes'" class="ayuda_checks_group">
                                <label v-for="(op, j) in campo.opciones" :key="j" class="ayuda_check_item">
                                    <input type="checkbox" :checked="(campo.checked || []).includes(op)" disabled /> {{ op }}
                                </label>
                            </div>
                            <select v-else-if="campo.tipo === 'select'" class="form-control" disabled>
                                <option>{{ campo.value }}</option>
                            </select>
                            <input v-else-if="campo.tipo === 'file'" type="text" class="form-control" :value="campo.value" disabled />
                            <input v-else-if="campo.tipo === 'password'" type="password" class="form-control" :value="campo.value" disabled />
                            <input v-else type="text" class="form-control" :value="campo.value" disabled />
                        </div>
                    </div>
                </div>

                <div v-if="cfg.nota" class="ayuda_nota">
                    <i class="fa fa-info-circle"></i>&nbsp; {{ cfg.nota }}
                </div>

                <div class="enod-form-actions enod-form-actions--end">
                    <button class="btn btn-default" disabled>Cancelar</button>
                    <button class="btn btn-enod" disabled>
                        <i class="fa fa-save"></i>&nbsp; Guardar {{ cfg.singular }}
                    </button>
                </div>
            </div>
        </div>
        <div class="ayuda_demo_caption">
            Los campos con <span class="ayuda_req">*</span> son obligatorios. Al editar un registro se abre este mismo formulario con los datos cargados.
        </div>
    </div>
</template>

<script>
import { ABM } from './abm-config.js';

export default {
    name: 'ayuda-demo-abm-form',
    props: {
        entidad: { type: String, required: true,
                   validator: v => Object.keys(ABM).includes(v) },
        modo: { type: String, default: 'nuevo' },
    },
    computed: { cfg() { return ABM[this.entidad]; } },
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
.ayuda_real_box .form-control[disabled] { background: #fafbfc; cursor: not-allowed; color: #4c5661; }
.ayuda_real_box label { font-size: 12px; color: #4c5661; margin-bottom: 4px; }
.ayuda_req { color: #dc3545; font-weight: 700; }

.ayuda_toggle_group { padding-top: 4px; }
.ayuda_toggle_item { margin-right: 18px; font-weight: 600; color: #4c5661; cursor: default; }
.ayuda_toggle_item input { margin-right: 4px; }
.ayuda_checks_group {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    gap: 4px 16px;
    padding: 6px 0 2px;
}
.ayuda_check_item { font-weight: 500; color: #4c5661; margin: 0; cursor: default; }
.ayuda_check_item input { margin-right: 6px; }

.ayuda_nota {
    background: #fffdf5;
    border-left: 3px solid #FFCC00;
    color: #5c4a00;
    padding: 8px 12px;
    border-radius: 0 4px 4px 0;
    font-size: 12.5px;
    margin-bottom: 12px;
}
.ayuda_nota i { color: #d4a800; }

.enod-form-actions { border-top: 1px solid #eef0f3; padding-top: 12px; margin-top: 8px; }

.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
</style>
