<template>
    <div class="ayuda_demo_filtros">
        <div class="ayuda_demo_label">Ejemplo del panel de filtros (no funcional)</div>
        <div class="ayuda_demo_filtros_grid">
            <div class="ayuda_demo_field">
                <label>Cliente</label>
                <input type="text" class="form-control" :value="cliente" disabled />
            </div>
            <div class="ayuda_demo_field">
                <label>OT</label>
                <input type="text" class="form-control" :value="ot" disabled />
            </div>
            <div class="ayuda_demo_field">
                <label>Obra</label>
                <input type="text" class="form-control" :value="obra" disabled />
            </div>
            <div class="ayuda_demo_field">
                <label>Componente</label>
                <input type="text" class="form-control" :value="componente" disabled />
            </div>
            <div class="ayuda_demo_field">
                <label>PK</label>
                <input type="text" class="form-control" :value="pk" disabled />
            </div>
            <div class="ayuda_demo_field">
                <label>Fecha desde</label>
                <input type="text" class="form-control" :value="fechaDesde" disabled />
            </div>
            <div class="ayuda_demo_field">
                <label>Fecha hasta</label>
                <input type="text" class="form-control" :value="fechaHasta" disabled />
            </div>
            <div class="ayuda_demo_field ayuda_demo_field--button">
                <button class="btn btn-primary" disabled>Buscar</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-filtros',
    data() {
        return {
            cliente: 'Cliente Demo SA',
            ot: 'OT-2026-001',
            obra: 'Gasoducto Norte',
            componente: 'Cañería principal',
            pk: '125',
            fechaDesde: '01/05/2026',
            fechaHasta: '31/05/2026',
        };
    },
};
</script>

<style scoped>
.ayuda_demo_filtros {
    background: #fafbfd;
    border: 1px solid #e6eaf0;
    border-radius: 10px;
    padding: 16px;
    margin: 12px 0;
}
.ayuda_demo_label {
    font-size: 12px;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 12px;
    font-weight: 600;
}
.ayuda_demo_filtros_grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 12px;
    align-items: end;
}
.ayuda_demo_field label {
    display: block;
    font-size: 12px;
    color: #4c5661;
    font-weight: 600;
    margin-bottom: 4px;
}
.ayuda_demo_field input {
    background: #fff;
    cursor: not-allowed;
}
.ayuda_demo_field--button {
    align-self: end;
}
.ayuda_demo_field--button button {
    width: 100%;
    cursor: not-allowed;
}
</style>
