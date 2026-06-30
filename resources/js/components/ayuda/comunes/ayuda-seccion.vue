<template>
    <section class="ayuda_seccion" :id="id">
        <header class="ayuda_seccion_head">
            <span v-if="numero" class="ayuda_seccion_num">{{ numero }}</span>
            <h2 class="ayuda_seccion_titulo">{{ titulo }}</h2>
        </header>
        <div class="ayuda_seccion_body"><slot></slot></div>
    </section>
</template>

<script>
export default {
    name: 'ayuda-seccion',
    props: {
        titulo: { type: String, required: true },
        numero: { type: [Number, String], default: '' },
        id: { type: String, default: '' },
    },
};
</script>

<style scoped>
.ayuda_seccion {
    margin: 0 0 28px;
    font-family: 'Montserrat', sans-serif;
    scroll-margin-top: 80px;
}
.ayuda_seccion_head {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 1px solid #eef0f3;
}
.ayuda_seccion_num {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 22px; height: 22px;
    border-radius: 50%;
    background: #FFCC00;
    color: #1a1a1a;
    font-size: 12px;
    font-weight: 700;
    flex-shrink: 0;
}
.ayuda_seccion_titulo {
    margin: 0;
    font-size: 17px;
    font-weight: 700;
    color: #1a1a1a;
    letter-spacing: -0.01em;
}
.ayuda_seccion_body { font-size: 14px; line-height: 1.65; color: #4c5661; }
.ayuda_seccion_body >>> p:last-child { margin-bottom: 0; }
</style>
