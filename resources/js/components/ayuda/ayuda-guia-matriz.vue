<template>
    <div class="ayuda_guia_matriz">
        <p v-if="intro">{{ intro }}</p>
        <div class="ayuda_guia_matriz_wrap">
            <table class="table table-condensed ayuda_guia_matriz_tabla">
                <thead>
                    <tr>
                        <th v-for="(c, i) in columnas" :key="i">{{ c }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(f, i) in filas" :key="i">
                        <td v-for="(celda, j) in f" :key="j">
                            <strong v-if="j === 0">{{ celda }}</strong>
                            <span v-else>{{ celda }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <ayuda-callout
            v-for="(c, i) in callouts"
            :key="'c' + i"
            :tipo="c.tipo"
            :titulo="c.titulo">
            {{ c.texto }}
        </ayuda-callout>
    </div>
</template>

<script>
export default {
    name: 'ayuda-guia-matriz',
    props: {
        intro: { type: String, default: '' },
        columnas: { type: Array, required: true },
        filas: { type: Array, required: true },
        callouts: { type: Array, default: () => [] },
    },
};
</script>

<style scoped>
.ayuda_guia_matriz_wrap { overflow-x: auto; margin: 8px 0 12px; }
.ayuda_guia_matriz_tabla { font-size: 13px; margin: 0; }
.ayuda_guia_matriz_tabla th {
    background: #fafbfc;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #4c5661;
}
.ayuda_guia_matriz_tabla td { vertical-align: top; line-height: 1.5; }
</style>
