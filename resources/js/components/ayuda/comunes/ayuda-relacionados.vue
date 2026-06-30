<template>
    <ul class="ayuda_rel">
        <li v-for="(it, i) in items" :key="i">
            <a :href="it.ruta">{{ it.titulo }}</a>
        </li>
    </ul>
</template>

<script>
export default {
    name: 'ayuda-relacionados',
    props: { items: { type: Array, required: true } },
};
</script>

<style scoped>
.ayuda_rel {
    list-style: none;
    padding: 0;
    margin: 0;
    font-family: 'Montserrat', sans-serif;
}
.ayuda_rel li {
    padding: 7px 0;
    border-bottom: 1px solid #eef0f3;
}
.ayuda_rel li:last-child { border-bottom: 0; }
.ayuda_rel a {
    color: #2b2f33;
    font-size: 13.5px;
    text-decoration: none;
    display: inline-block;
    padding-left: 0;
    transition: all 0.1s ease;
}
.ayuda_rel a::before {
    content: "›";
    color: #FFCC00;
    font-weight: 700;
    margin-right: 8px;
}
.ayuda_rel a:hover {
    color: #1a1a1a;
    padding-left: 4px;
}
</style>
