<template>
    <div class="ayuda_est_wrap">
        <!-- Tabla de estados -->
        <table class="table table-condensed ayuda_est">
            <thead>
                <tr>
                    <th>Estado</th>
                    <th>Descripción</th>
                    <th class="text-center">¿Editable?</th>
                    <th>Permiso</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(e, i) in estados" :key="i">
                    <td>
                        <span class="label" :class="badge(e.color)">
                            <i v-if="e.icono" :class="'fa fa-' + e.icono"></i>
                            {{ e.nombre }}
                        </span>
                    </td>
                    <td>{{ e.descripcion }}</td>
                    <td class="text-center">
                        <span v-if="e.editable === true" class="text-success"><i class="fa fa-check"></i> Sí</span>
                        <span v-else-if="e.editable === 'parcial'" class="text-warning"><i class="fa fa-adjust"></i> Parcial</span>
                        <span v-else class="text-danger"><i class="fa fa-lock"></i> No</span>
                    </td>
                    <td><code v-if="e.permiso">{{ e.permiso }}</code><span v-else class="text-muted">—</span></td>
                </tr>
            </tbody>
        </table>

        <!-- Transiciones -->
        <div v-if="transiciones && transiciones.length" class="ayuda_est_trans">
            <h4>Transiciones</h4>
            <ul class="ayuda_trans_list">
                <li v-for="(t, i) in transiciones" :key="i" :class="{ 'is-irreversible': t.irreversible }">
                    <span class="label" :class="badge(estadoColor(t.de))">{{ t.de }}</span>
                    <i class="fa fa-long-arrow-right ayuda_trans_arrow"></i>
                    <span class="label" :class="badge(estadoColor(t.a))">{{ t.a }}</span>
                    <span class="ayuda_trans_accion">{{ t.accion }}</span>
                    <code v-if="t.permiso" class="ayuda_trans_permiso">{{ t.permiso }}</code>
                    <span v-if="t.irreversible" class="label label-danger" title="Irreversible">
                        <i class="fa fa-lock"></i> Irreversible
                    </span>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-tabla-estados',
    props: {
        estados: { type: Array, required: true },
        transiciones: { type: Array, default: () => [] },
    },
    methods: {
        badge(color) {
            return {
                verde:    'label-success',
                amarillo: 'label-warning',
                rojo:     'label-danger',
                gris:     'label-default',
                azul:     'label-info',
                negro:    'ayuda_est_label_dark',
            }[color] || 'label-default';
        },
        estadoColor(nombre) {
            const e = this.estados.find(x => x.nombre === nombre);
            return e ? e.color : 'gris';
        },
    },
};
</script>

<style scoped>
.ayuda_est_wrap { font-family: 'Montserrat', sans-serif; margin: 8px 0 12px; }
.ayuda_est { background: #fff; border: 1px solid #eef0f3; margin-bottom: 14px; }
.ayuda_est > thead > tr > th {
    background: #fafbfc;
    border-bottom: 2px solid #FFCC00;
    color: #4c5661;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    font-weight: 700;
    padding: 8px 10px;
}
.ayuda_est > tbody > tr > td {
    font-size: 12.5px;
    vertical-align: middle;
    padding: 8px 10px;
    border-top: 1px solid #f3f4f6;
}
.ayuda_est .label { font-size: 11px; padding: 3px 8px; font-weight: 700; }
.ayuda_est .label i { margin-right: 3px; }
code {
    background: #fffdf5;
    border: 1px solid #f0df9a;
    color: #5c4a00;
    padding: 1px 5px;
    border-radius: 3px;
    font-size: 11px;
}

.ayuda_est_trans h4 {
    font-size: 12px;
    color: #4c5661;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin: 0 0 8px;
    font-weight: 700;
}
.ayuda_trans_list { list-style: none; padding: 0; margin: 0; }
.ayuda_trans_list li {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    background: #fafbfc;
    border-left: 3px solid #FFCC00;
    border-radius: 0 4px 4px 0;
    margin-bottom: 6px;
    font-size: 12.5px;
}
.ayuda_trans_list li.is-irreversible { border-left-color: #dc3545; background: #fef7f7; }
.ayuda_trans_arrow { color: #6b7280; font-size: 13px; }
.ayuda_trans_accion { color: #4c5661; font-style: italic; }
.ayuda_trans_permiso { margin-left: 4px; }
.ayuda_est_label_dark { background: #1a1a1a; color: #fff; }
</style>
