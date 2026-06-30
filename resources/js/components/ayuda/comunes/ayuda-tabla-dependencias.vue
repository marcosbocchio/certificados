<template>
    <ul class="ayuda_dep_list">
        <li v-for="(it, i) in items" :key="i" class="ayuda_dep_item" :class="{ 'is-critico': it.critico }">
            <span class="ayuda_dep_marca">
                <i :class="it.critico ? 'fa fa-exclamation-circle' : 'fa fa-check-circle-o'"></i>
            </span>
            <div class="ayuda_dep_body">
                <strong>{{ it.entidad }}</strong>
                <span class="ayuda_dep_sep">·</span>
                <span>{{ it.descripcion }}</span>
                <a v-if="it.ruta" :href="it.ruta" class="ayuda_dep_link">
                    <i class="fa fa-external-link"></i> Ver artículo
                </a>
                <span v-if="it.critico" class="label label-danger ayuda_dep_badge">Crítico</span>
                <span v-else class="label label-default ayuda_dep_badge">Recomendado</span>
            </div>
        </li>
    </ul>
</template>

<script>
export default {
    name: 'ayuda-tabla-dependencias',
    props: { items: { type: Array, required: true } },
};
</script>

<style scoped>
.ayuda_dep_list { list-style: none; padding: 0; margin: 8px 0 12px; font-family: 'Montserrat', sans-serif; }
.ayuda_dep_item {
    display: flex;
    gap: 10px;
    padding: 10px 12px;
    background: #fff;
    border: 1px solid #eef0f3;
    border-left: 3px solid #d1d5db;
    border-radius: 0 4px 4px 0;
    margin-bottom: 6px;
    align-items: flex-start;
}
.ayuda_dep_item.is-critico { border-left-color: #dc3545; background: #fef7f7; }
.ayuda_dep_marca {
    color: #6b7280;
    font-size: 16px;
    flex-shrink: 0;
    line-height: 1.4;
}
.ayuda_dep_item.is-critico .ayuda_dep_marca { color: #dc3545; }
.ayuda_dep_body {
    flex: 1;
    font-size: 13px;
    color: #4c5661;
    line-height: 1.5;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 5px;
}
.ayuda_dep_body strong { color: #1a1a1a; font-weight: 700; }
.ayuda_dep_sep { color: #d1d5db; }
.ayuda_dep_link {
    font-size: 12px;
    color: #2e86c1;
    text-decoration: none;
    border-bottom: 1px solid transparent;
    margin-left: 4px;
}
.ayuda_dep_link:hover { border-bottom-color: #2e86c1; color: #2e86c1; }
.ayuda_dep_badge {
    font-size: 10px;
    padding: 2px 7px;
    margin-left: auto;
}
</style>
