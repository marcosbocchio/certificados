<template>
    <div class="ayuda_imp_wrap">
        <table class="table table-condensed ayuda_imp">
            <thead>
                <tr>
                    <th style="width:25%;">Módulo afectado</th>
                    <th>Efecto</th>
                    <th class="text-center" style="width:120px;">Reversible</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(it, i) in impactos" :key="i" :class="{ 'ayuda_imp_critico': !it.reversible }">
                    <td><strong>{{ it.modulo }}</strong></td>
                    <td>{{ it.efecto }}</td>
                    <td class="text-center">
                        <span v-if="it.reversible === true" class="text-success"><i class="fa fa-undo"></i> Sí</span>
                        <span v-else-if="it.reversible === 'parcial'" class="text-warning"><i class="fa fa-undo"></i> Parcial</span>
                        <span v-else class="text-danger"><i class="fa fa-lock"></i> No</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: 'ayuda-tabla-impacto',
    props: { impactos: { type: Array, required: true } },
};
</script>

<style scoped>
.ayuda_imp_wrap { margin: 8px 0 12px; overflow-x: auto; font-family: 'Montserrat', sans-serif; }
.ayuda_imp { background: #fff; border: 1px solid #eef0f3; min-width: 540px; margin-bottom: 0; }
.ayuda_imp > thead > tr > th {
    background: #fafbfc;
    border-bottom: 2px solid #FFCC00;
    color: #4c5661;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    font-weight: 700;
    padding: 8px 10px;
}
.ayuda_imp > tbody > tr > td {
    font-size: 12.5px;
    vertical-align: middle;
    padding: 8px 10px;
    border-top: 1px solid #f3f4f6;
}
.ayuda_imp_critico { background: #fef7f7; }
.ayuda_imp_critico td:first-child { border-left: 3px solid #dc3545; padding-left: 8px; }
</style>
