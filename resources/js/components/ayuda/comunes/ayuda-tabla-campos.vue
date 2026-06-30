<template>
    <div class="ayuda_tc_wrap">
        <table class="table table-condensed ayuda_tc">
            <thead>
                <tr>
                    <th>Campo</th>
                    <th>Tipo</th>
                    <th class="text-center">Obligatorio</th>
                    <th>Origen / valores</th>
                    <th>Validación</th>
                    <th>Notas</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(c, i) in campos" :key="i">
                    <td><strong>{{ c.nombre }}</strong></td>
                    <td><span class="ayuda_tc_tipo">{{ c.tipo }}</span></td>
                    <td class="text-center">
                        <span v-if="c.obligatorio === true" class="label label-danger" title="Obligatorio">*</span>
                        <span v-else-if="c.obligatorio === 'condicional'" class="label label-warning" :title="c.condicion || 'Condicional'">cond.</span>
                        <span v-else class="text-muted">—</span>
                    </td>
                    <td>
                        <span v-if="c.origen">{{ c.origen }}</span>
                        <span v-else class="text-muted">—</span>
                    </td>
                    <td>
                        <code v-if="c.validacion">{{ c.validacion }}</code>
                        <span v-else class="text-muted">—</span>
                    </td>
                    <td><small>{{ c.notas || '' }}</small></td>
                </tr>
            </tbody>
        </table>
        <p class="ayuda_tc_leyenda">
            <span class="label label-danger">*</span> Obligatorio &nbsp;·&nbsp;
            <span class="label label-warning">cond.</span> Obligatorio según condición (ver columna "Notas")
        </p>
    </div>
</template>

<script>
export default {
    name: 'ayuda-tabla-campos',
    props: {
        campos: { type: Array, required: true },
    },
};
</script>

<style scoped>
.ayuda_tc_wrap { margin: 8px 0 12px; overflow-x: auto; font-family: 'Montserrat', sans-serif; }
.ayuda_tc { background: #fff; border: 1px solid #eef0f3; min-width: 720px; margin-bottom: 6px; }
.ayuda_tc > thead > tr > th {
    background: #fafbfc;
    border-bottom: 2px solid #FFCC00;
    color: #4c5661;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    font-weight: 700;
    white-space: nowrap;
    padding: 8px 10px;
}
.ayuda_tc > tbody > tr > td {
    font-size: 12.5px;
    vertical-align: top;
    padding: 8px 10px;
    border-top: 1px solid #f3f4f6;
}
.ayuda_tc_tipo {
    display: inline-block;
    background: #f3f4f6;
    color: #4c5661;
    padding: 1px 7px;
    border-radius: 3px;
    font-size: 11px;
    font-family: 'Courier New', monospace;
}
.ayuda_tc code {
    background: #fffdf5;
    border: 1px solid #f0df9a;
    color: #5c4a00;
    padding: 1px 5px;
    border-radius: 3px;
    font-size: 11px;
}
.ayuda_tc .label { font-size: 10px; padding: 2px 6px; }
.ayuda_tc small { color: #6b7280; font-size: 11.5px; line-height: 1.4; display: block; }
.ayuda_tc_leyenda { font-size: 11px; color: #6b7280; margin: 0; }
.ayuda_tc_leyenda .label { font-size: 9.5px; padding: 2px 5px; margin-right: 2px; }
</style>
