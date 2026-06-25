<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Ejemplo: barra de filtros del listado de OT</div>
        <div class="ayuda_filtros_ot">
            <div class="ayuda_filtro_row">
                <label>Cliente</label>
                <select v-model="filtros.cliente">
                    <option value="">Todos</option>
                    <option>YPF S.A.</option>
                    <option>Techint Ingeniería</option>
                    <option>Pampa Energía</option>
                </select>
            </div>
            <div class="ayuda_filtro_row">
                <label>Estado</label>
                <select v-model="filtros.estado">
                    <option value="">Todos</option>
                    <option>Editando</option>
                    <option>Activa</option>
                    <option>Cerrada</option>
                </select>
            </div>
            <div class="ayuda_filtro_row">
                <label>Desde</label>
                <input type="text" v-model="filtros.desde" placeholder="dd/mm/aaaa" />
            </div>
            <div class="ayuda_filtro_row">
                <label>Hasta</label>
                <input type="text" v-model="filtros.hasta" placeholder="dd/mm/aaaa" />
            </div>
            <div class="ayuda_filtro_row ayuda_filtro_row--buscar">
                <label>Buscar</label>
                <input type="text" v-model="filtros.texto" placeholder="N° OT, proyecto, obra..." />
            </div>
            <div class="ayuda_filtro_actions">
                <button class="ayuda_btn_demo ayuda_btn_demo--primary"><i class="fa fa-filter"></i> Filtrar</button>
                <button class="ayuda_btn_demo ayuda_btn_demo--secondary" @click="reset"><i class="fa fa-eraser"></i> Limpiar</button>
            </div>
        </div>
        <div class="ayuda_demo_caption">
            Los filtros se combinan: si elegís un cliente y un estado, la tabla queda restringida a OT que cumplan ambos.
            Un cliente externo ve solo sus propias OT.
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-filtros-ot',
    data() {
        return {
            filtros: { cliente: '', estado: 'Activa', desde: '', hasta: '', texto: '' },
        };
    },
    methods: {
        reset() { this.filtros = { cliente: '', estado: '', desde: '', hasta: '', texto: '' }; },
    },
};
</script>

<style scoped>
.ayuda_demo_block { margin: 12px 0 20px; }
.ayuda_demo_label {
    font-size: 12px; color: #6b7280;
    text-transform: uppercase; letter-spacing: 0.06em;
    margin-bottom: 8px; font-weight: 600;
}
.ayuda_filtros_ot {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 10px;
    background: #f9fafb;
    border: 1px solid #e3e8ee;
    border-radius: 10px;
    padding: 14px;
    align-items: end;
}
.ayuda_filtro_row label {
    display: block; font-size: 11px; font-weight: 700;
    color: #4c5661; margin-bottom: 4px;
    text-transform: uppercase; letter-spacing: 0.03em;
}
.ayuda_filtro_row input,
.ayuda_filtro_row select {
    width: 100%; padding: 6px 9px;
    border: 1px solid #d6dce3; border-radius: 6px;
    background: #fff; font-size: 13px;
}
.ayuda_filtro_row--buscar { grid-column: span 2; }
.ayuda_filtro_actions {
    display: flex; gap: 6px;
    grid-column: 1 / -1;
    justify-content: flex-end;
}
.ayuda_btn_demo {
    padding: 7px 14px; border-radius: 6px;
    font-size: 12px; font-weight: 700;
    border: 0; cursor: pointer;
}
.ayuda_btn_demo i { margin-right: 5px; }
.ayuda_btn_demo--primary   { background: #2e86c1; color: #fff; }
.ayuda_btn_demo--secondary { background: #e3e8ee; color: #4c5661; }
.ayuda_demo_caption {
    margin-top: 6px; font-size: 11px;
    color: #9ca3af; font-style: italic;
}
@media (max-width: 600px) {
    .ayuda_filtro_row--buscar { grid-column: span 1; }
}
</style>
