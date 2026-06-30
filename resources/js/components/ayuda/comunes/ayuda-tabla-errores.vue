<template>
    <div class="ayuda_err_wrap">
        <table class="table table-condensed ayuda_err">
            <thead>
                <tr>
                    <th style="width:32%;">Mensaje / situación</th>
                    <th style="width:34%;">Causa</th>
                    <th>Cómo resolverlo</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(e, i) in errores" :key="i">
                    <td><code class="ayuda_err_msg">{{ e.mensaje }}</code></td>
                    <td>{{ e.causa }}</td>
                    <td>{{ e.solucion }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: 'ayuda-tabla-errores',
    props: { errores: { type: Array, required: true } },
};
</script>

<style scoped>
.ayuda_err_wrap { margin: 8px 0 12px; overflow-x: auto; font-family: 'Montserrat', sans-serif; }
.ayuda_err { background: #fff; border: 1px solid #eef0f3; min-width: 600px; margin-bottom: 0; }
.ayuda_err > thead > tr > th {
    background: #fef7f7;
    border-bottom: 2px solid #dc3545;
    color: #4c5661;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    font-weight: 700;
    padding: 8px 10px;
}
.ayuda_err > tbody > tr > td {
    font-size: 12.5px;
    vertical-align: top;
    padding: 8px 10px;
    line-height: 1.5;
    border-top: 1px solid #f3f4f6;
}
.ayuda_err_msg {
    background: #fdecec;
    border: 1px solid #f5b5bb;
    color: #8a1f2a;
    padding: 2px 6px;
    border-radius: 3px;
    font-size: 11.5px;
    font-family: 'Courier New', monospace;
    display: inline-block;
    line-height: 1.4;
}
</style>
