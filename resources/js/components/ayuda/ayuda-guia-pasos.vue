<template>
    <div class="ayuda_guia_pasos">
        <p v-if="intro">{{ intro }}</p>
        <ol class="ayuda_guia_lista">
            <li v-for="(p, i) in pasos" :key="i">
                <span class="ayuda_guia_num">{{ i + 1 }}</span>
                <div>
                    <strong>{{ p.titulo }}</strong>
                    <span v-if="p.detalle">{{ p.detalle }}</span>
                </div>
            </li>
        </ol>
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
    name: 'ayuda-guia-pasos',
    props: {
        intro: { type: String, default: '' },
        pasos: { type: Array, required: true },
        callouts: { type: Array, default: () => [] },
    },
};
</script>

<style scoped>
.ayuda_guia_lista { list-style: none; padding: 0; margin: 8px 0 12px; }
.ayuda_guia_lista li {
    display: flex;
    gap: 12px;
    align-items: flex-start;
    padding: 10px 14px;
    background: #fafbfc;
    border: 1px solid #eef0f3;
    border-radius: 4px;
    margin-bottom: 6px;
    font-size: 13.5px;
    line-height: 1.55;
}
.ayuda_guia_lista li strong { display: block; color: #1a1a1a; }
.ayuda_guia_lista li span:not(.ayuda_guia_num) { color: #4c5661; }
.ayuda_guia_num {
    flex-shrink: 0;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: #FFCC00;
    color: #1a1a1a;
    font-size: 12px;
    font-weight: 700;
    text-align: center;
    line-height: 24px;
    margin-top: 1px;
}
</style>
