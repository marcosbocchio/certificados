<template>
    <div class="ayuda_demo_filtros_wrap">
        <div class="ayuda_demo_filtros_label">
            <span class="ayuda_demo_filtros_label_main">REPORTE</span>
            <span class="ayuda_demo_filtros_label_sub">Seguimiento de costuras / Plano-isométrico</span>
        </div>
        <div class="ayuda_demo_filtros_panel">
            <div class="ayuda_demo_filtros_field">
                <label>Cliente</label>
                <span>Cliente Demo SA</span>
            </div>
            <div class="ayuda_demo_filtros_field">
                <label>OT</label>
                <span>OT-2026-001</span>
            </div>
            <div class="ayuda_demo_filtros_field">
                <label>Obra</label>
                <span>Gasoducto Norte</span>
            </div>
            <div class="ayuda_demo_filtros_field">
                <label>Componente</label>
                <span>Cañería principal</span>
            </div>
            <div class="ayuda_demo_filtros_input">
                <input type="text" value="125" disabled placeholder="PK" />
            </div>
            <div class="ayuda_demo_filtros_input">
                <input type="text" value="ISO-PL-0245" disabled placeholder="Plano Isométrico" />
            </div>
            <div class="ayuda_demo_filtros_input">
                <input type="text" value="J15" disabled placeholder="Costura" />
            </div>
            <div class="ayuda_demo_filtros_field">
                <label>Soldador</label>
                <span>S-07 — Pérez, J.</span>
            </div>
            <div class="ayuda_demo_filtros_checks">
                <label><input type="checkbox" disabled /> Rechazados</label>
                <label><input type="checkbox" disabled /> Reparaciones</label>
            </div>
            <button class="ayuda_demo_filtros_btn" disabled>
                <i class="fa fa-search"></i> Buscar
            </button>
        </div>
        <div class="ayuda_demo_filtros_caption">Vista de ejemplo del panel de filtros — no funcional</div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-costuras-filtros',
};
</script>

<style scoped>
.ayuda_demo_filtros_wrap {
    max-width: 260px;
    margin: 14px 0;
}
.ayuda_demo_filtros_label {
    margin-bottom: 6px;
}
.ayuda_demo_filtros_label_main {
    font-size: 10px;
    color: #6b7280;
    letter-spacing: 0.08em;
    font-weight: 700;
    text-transform: uppercase;
    display: block;
}
.ayuda_demo_filtros_label_sub {
    font-size: 11px;
    color: #6b7280;
}
.ayuda_demo_filtros_panel {
    background: #fff;
    border: 1px solid #e6eaf0;
    border-top: 3px solid #d99000;
    border-radius: 6px;
    padding: 14px;
}
.ayuda_demo_filtros_field {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #edf1f5;
    font-size: 13px;
}
.ayuda_demo_filtros_field label {
    color: #4c5661;
    font-weight: 700;
    font-size: 12px;
    margin: 0;
}
.ayuda_demo_filtros_field span {
    color: #6b7280;
    font-size: 11px;
    text-align: right;
}
.ayuda_demo_filtros_input {
    padding: 10px 0 6px;
    border-bottom: 1px solid #edf1f5;
}
.ayuda_demo_filtros_input input {
    width: 100%;
    border: 1px solid #d4d4d8;
    border-radius: 4px;
    padding: 5px 8px;
    font-size: 12px;
    background: #fafbfd;
    cursor: not-allowed;
}
.ayuda_demo_filtros_checks {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
    padding: 10px 0 4px;
}
.ayuda_demo_filtros_checks label {
    font-size: 12px;
    color: #4c5661;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 5px;
    cursor: not-allowed;
}
.ayuda_demo_filtros_btn {
    width: 100%;
    margin-top: 10px;
    padding: 8px 12px;
    background: #f0ad4e;
    color: #fff;
    border: 1px solid #eea236;
    border-radius: 4px;
    font-size: 13px;
    font-weight: 700;
    cursor: not-allowed;
}
.ayuda_demo_filtros_btn i {
    margin-right: 4px;
}
.ayuda_demo_filtros_caption {
    margin-top: 6px;
    font-size: 11px;
    color: #9ca3af;
    font-style: italic;
}
</style>
