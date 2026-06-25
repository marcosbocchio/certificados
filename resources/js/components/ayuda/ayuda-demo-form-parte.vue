<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Ejemplo: cabecera del parte diario</div>
        <div class="ayuda_form_demo">
            <div class="ayuda_form_demo_header">
                <i class="fa fa-calendar-check-o"></i> Nuevo parte diario - OT-1542
            </div>
            <div class="ayuda_form_demo_body">
                <div class="ayuda_form_grid">
                    <div class="ayuda_form_row">
                        <label>Fecha <span class="ayuda_req">*</span></label>
                        <input type="text" value="25/06/2026" disabled />
                    </div>
                    <div class="ayuda_form_row">
                        <label>Obra</label>
                        <select disabled><option>Gasoducto NEA - T12</option></select>
                    </div>
                    <div class="ayuda_form_row">
                        <label>Tipo de servicio <span class="ayuda_req">*</span></label>
                        <select disabled><option>Radiografía industrial</option></select>
                    </div>
                </div>
                <div class="ayuda_form_grid">
                    <div class="ayuda_form_row">
                        <label>Horario inicio</label>
                        <input type="text" value="07:30" disabled />
                    </div>
                    <div class="ayuda_form_row">
                        <label>Horario fin</label>
                        <input type="text" value="16:00" disabled />
                    </div>
                </div>

                <div class="ayuda_tabs_demo">
                    <button v-for="(t, i) in tabs" :key="i" :class="['ayuda_tab', { 'is-active': activa === i }]" @click="activa = i">
                        <i :class="'fa fa-' + t.icono"></i> {{ t.label }}
                        <span v-if="t.badge" class="ayuda_tab_badge">{{ t.badge }}</span>
                    </button>
                </div>
                <div class="ayuda_tabs_panel">
                    <p v-if="activa === 0"><i class="fa fa-info-circle"></i> Se listan los informes <strong>pendientes</strong> de la OT que coinciden con la fecha y obra elegidas. Tildá los que pertenezcan a esta jornada.</p>
                    <p v-if="activa === 1"><i class="fa fa-users"></i> Operadores que trabajaron en la jornada. Cada uno con hora de inicio, fin y novedades.</p>
                    <p v-if="activa === 2"><i class="fa fa-truck"></i> Vehículos usados, con kilometraje inicial y final.</p>
                    <p v-if="activa === 3"><i class="fa fa-cog"></i> Servicios o cantidades extra que no quedan cubiertos solo por los informes.</p>
                </div>

                <div class="ayuda_form_actions">
                    <button class="ayuda_btn_demo ayuda_btn_demo--secondary" disabled>Cancelar</button>
                    <button class="ayuda_btn_demo ayuda_btn_demo--primary" disabled><i class="fa fa-save"></i> Guardar parte</button>
                </div>
            </div>
        </div>
        <div class="ayuda_demo_caption">
            La fecha y la obra elegidas son las que filtran los <strong>informes pendientes</strong> disponibles. Si esos dos campos están mal, después no aparecen los informes que esperás asociar.
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-form-parte',
    data() {
        return {
            activa: 0,
            tabs: [
                { label: 'Informes',     icono: 'file-text',  badge: 5 },
                { label: 'Responsables', icono: 'users',      badge: 3 },
                { label: 'Vehículos',    icono: 'truck',      badge: 1 },
                { label: 'Servicios',    icono: 'cog',        badge: null },
            ],
        };
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
.ayuda_form_demo {
    background: #fff;
    border: 1px solid #e3e8ee;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 6px rgba(0,0,0,0.04);
}
.ayuda_form_demo_header {
    background: linear-gradient(135deg, #6f42c1 0%, #9c27b0 100%);
    color: #fff; padding: 12px 16px;
    font-weight: 700; font-size: 14px;
}
.ayuda_form_demo_header i { margin-right: 8px; }
.ayuda_form_demo_body { padding: 16px; }

.ayuda_form_grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 10px; margin-bottom: 12px;
}
.ayuda_form_row label {
    display: block; font-size: 11px; font-weight: 700;
    color: #4c5661; margin-bottom: 4px;
    text-transform: uppercase; letter-spacing: 0.03em;
}
.ayuda_form_row input,
.ayuda_form_row select {
    width: 100%; padding: 6px 9px;
    border: 1px solid #d6dce3; border-radius: 6px;
    background: #f9fafb; font-size: 13px;
    color: #374151; cursor: not-allowed;
}
.ayuda_req { color: #dc3545; font-weight: 700; }

.ayuda_tabs_demo {
    display: flex; flex-wrap: wrap; gap: 4px;
    border-bottom: 2px solid #e3e8ee;
    margin: 12px 0 0;
}
.ayuda_tab {
    background: transparent; border: 0;
    padding: 8px 14px; font-size: 13px;
    color: #6b7280; cursor: pointer;
    border-bottom: 3px solid transparent;
    font-weight: 600;
    position: relative;
    margin-bottom: -2px;
}
.ayuda_tab i { margin-right: 5px; }
.ayuda_tab.is-active {
    color: #6f42c1;
    border-bottom-color: #6f42c1;
}
.ayuda_tab_badge {
    display: inline-block;
    background: #6f42c1; color: #fff;
    border-radius: 999px;
    padding: 0 6px;
    font-size: 10px; font-weight: 700;
    margin-left: 4px;
}
.ayuda_tabs_panel {
    background: #faf7fd;
    border: 1px solid #ede0f7;
    border-top: 0;
    border-radius: 0 0 6px 6px;
    padding: 12px 14px;
    font-size: 13px;
    color: #4c5661;
}
.ayuda_tabs_panel p { margin: 0; }
.ayuda_tabs_panel i { margin-right: 6px; color: #6f42c1; }

.ayuda_form_actions {
    display: flex; justify-content: flex-end; gap: 8px;
    padding-top: 14px; margin-top: 14px;
    border-top: 1px solid #f1f5f9;
}
.ayuda_btn_demo {
    padding: 7px 16px; border-radius: 6px;
    font-size: 13px; font-weight: 700;
    border: 0; cursor: not-allowed;
}
.ayuda_btn_demo--primary { background: #28a745; color: #fff; }
.ayuda_btn_demo--secondary { background: #e3e8ee; color: #4c5661; }
.ayuda_demo_caption {
    margin-top: 8px; font-size: 11px;
    color: #9ca3af; font-style: italic;
}

@media (max-width: 600px) {
    .ayuda_form_grid { grid-template-columns: 1fr; }
}
</style>
