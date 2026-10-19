<template>
    <span class="ayuda_chip_metodo">{{ metodo }}</span>
</template>

<script>
export default {
    name: 'ayuda-chip-metodo',
    props: { metodo: { type: String, required: true } },
};
</script>

<style scoped>
/* Misma etiqueta que usa la columna Método de las tablas del sistema */
.ayuda_chip_metodo {
    display: inline-block;
    margin: 1px 4px 1px 0;
    padding: 0 8px;
    border-radius: 10px;
    background: #e8edf2;
    color: #333;
    font-size: 11px;
    font-weight: 600;
    line-height: 18px;
    white-space: nowrap;
}
</style>
