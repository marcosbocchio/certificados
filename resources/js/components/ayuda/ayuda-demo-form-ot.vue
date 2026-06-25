<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Ejemplo: formulario de Nueva OT</div>
        <div class="ayuda_form_demo">
            <div class="ayuda_form_demo_header">
                <i class="fa fa-clipboard"></i> Nueva orden de trabajo
            </div>
            <div class="ayuda_form_demo_body">
                <div class="ayuda_form_row">
                    <label>Proyecto</label>
                    <input type="text" value="Gasoducto NEA - Tramo 12" disabled />
                </div>
                <div class="ayuda_form_grid">
                    <div class="ayuda_form_row">
                        <label>FST N°</label>
                        <input type="text" value="P-2026-0087" disabled />
                    </div>
                    <div class="ayuda_form_row">
                        <label>OT N°</label>
                        <input type="text" value="OT-1542" disabled />
                    </div>
                    <div class="ayuda_form_row">
                        <label>Fecha</label>
                        <input type="text" value="25/06/2026" disabled />
                    </div>
                </div>
                <div class="ayuda_form_grid">
                    <div class="ayuda_form_row">
                        <label>Cliente <span class="ayuda_req">*</span></label>
                        <select disabled><option>YPF S.A.</option></select>
                    </div>
                    <div class="ayuda_form_row">
                        <label>Comitente</label>
                        <select disabled><option>Techint Ingeniería</option></select>
                    </div>
                </div>
                <div class="ayuda_form_row">
                    <label>Responsable OT <span class="ayuda_req">*</span></label>
                    <select disabled><option>Juan Pérez (operador asignado)</option></select>
                </div>
                <div class="ayuda_form_row">
                    <label>Servicios</label>
                    <div class="ayuda_chips_row">
                        <span class="ayuda_chip">RI - Radiografía Industrial</span>
                        <span class="ayuda_chip">PM - Partículas Magnéticas</span>
                        <button class="ayuda_chip_add" disabled><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="ayuda_form_row">
                    <label>EPP requeridos</label>
                    <div class="ayuda_chips_row">
                        <span class="ayuda_chip ayuda_chip--epp">Casco</span>
                        <span class="ayuda_chip ayuda_chip--epp">Dosímetro</span>
                        <span class="ayuda_chip ayuda_chip--epp">Calzado de seguridad</span>
                    </div>
                </div>
                <div class="ayuda_form_actions">
                    <button class="ayuda_btn_demo ayuda_btn_demo--secondary" disabled>Cancelar</button>
                    <button class="ayuda_btn_demo ayuda_btn_demo--primary" disabled>
                        <i class="fa fa-save"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
        <div class="ayuda_demo_caption">
            Vista previa del formulario real. Los campos con <span class="ayuda_req">*</span> son obligatorios.
            "Servicios" y "Responsable OT" son los dos datos más sensibles: condicionan los métodos disponibles después en informes.
        </div>
    </div>
</template>

<script>
export default { name: 'ayuda-demo-form-ot' };
</script>

<style scoped>
.ayuda_demo_block {
    margin: 12px 0 20px;
}
.ayuda_demo_label {
    font-size: 12px;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 8px;
    font-weight: 600;
}
.ayuda_form_demo {
    background: #fff;
    border: 1px solid #e3e8ee;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 6px rgba(0,0,0,0.04);
}
.ayuda_form_demo_header {
    background: linear-gradient(135deg, #1f4e7a 0%, #2e86c1 100%);
    color: #fff;
    padding: 12px 16px;
    font-weight: 700;
    font-size: 14px;
}
.ayuda_form_demo_header i { margin-right: 8px; }
.ayuda_form_demo_body {
    padding: 16px;
}
.ayuda_form_row {
    margin-bottom: 12px;
}
.ayuda_form_row label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: #4c5661;
    margin-bottom: 4px;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}
.ayuda_form_row input,
.ayuda_form_row select {
    width: 100%;
    padding: 7px 10px;
    border: 1px solid #d6dce3;
    border-radius: 6px;
    background: #f9fafb;
    font-size: 13px;
    color: #374151;
    cursor: not-allowed;
}
.ayuda_form_grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 10px;
    margin-bottom: 12px;
}
.ayuda_form_grid .ayuda_form_row { margin-bottom: 0; }

.ayuda_req { color: #dc3545; font-weight: 700; }

.ayuda_chips_row {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    padding: 6px;
    background: #f9fafb;
    border: 1px dashed #d6dce3;
    border-radius: 6px;
    min-height: 40px;
}
.ayuda_chip {
    background: #eaf4fb;
    color: #1f4e7a;
    border: 1px solid #cbe2f1;
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}
.ayuda_chip--epp {
    background: #fff3cd;
    color: #8a6d3b;
    border-color: #ffe7a0;
}
.ayuda_chip_add {
    background: #2e86c1;
    color: #fff;
    border: 0;
    width: 26px; height: 26px;
    border-radius: 50%;
    font-size: 12px;
    cursor: not-allowed;
}

.ayuda_form_actions {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
    padding-top: 12px;
    border-top: 1px solid #f1f5f9;
}
.ayuda_btn_demo {
    padding: 7px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 700;
    border: 0;
    cursor: not-allowed;
}
.ayuda_btn_demo--primary { background: #28a745; color: #fff; }
.ayuda_btn_demo--secondary { background: #e3e8ee; color: #4c5661; }

.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 11px;
    color: #9ca3af;
    font-style: italic;
}

@media (max-width: 600px) {
    .ayuda_form_grid { grid-template-columns: 1fr; }
}
</style>
