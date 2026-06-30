<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Formulario de Nueva OT</div>
        <div class="box box-custom-enod ayuda_real_box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-clipboard"></i>&nbsp; Nueva orden de trabajo</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Proyecto</label>
                            <input type="text" class="form-control" value="Gasoducto NEA - Tramo 12" disabled />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>FST N°</label>
                            <input type="text" class="form-control" value="P-2026-0087" disabled />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>OT N°</label>
                            <input type="text" class="form-control" value="OT-1542" disabled />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Fecha</label>
                            <input type="text" class="form-control" value="25/06/2026" disabled />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Cliente <span class="ayuda_req">*</span></label>
                            <select class="form-control" disabled><option>YPF S.A.</option></select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Comitente</label>
                            <select class="form-control" disabled><option>Techint Ingeniería</option></select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Responsable OT <span class="ayuda_req">*</span></label>
                            <select class="form-control" disabled><option>Juan Pérez (operador asignado)</option></select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Servicios</label>
                    <div class="ayuda_chips_box">
                        <span class="label label-warning ayuda_chip">RI - Radiografía Industrial</span>
                        <span class="label label-warning ayuda_chip">PM - Partículas Magnéticas</span>
                        <button class="btn btn-enod btn-xs ayuda_chip_add" disabled><i class="fa fa-plus"></i></button>
                    </div>
                </div>

                <div class="form-group">
                    <label>EPP requeridos</label>
                    <div class="ayuda_chips_box">
                        <span class="label label-default ayuda_chip">Casco</span>
                        <span class="label label-default ayuda_chip">Dosímetro</span>
                        <span class="label label-default ayuda_chip">Calzado de seguridad</span>
                    </div>
                </div>

                <div class="enod-form-actions enod-form-actions--end">
                    <button class="btn btn-default" disabled>Cancelar</button>
                    <button class="btn btn-enod" disabled><i class="fa fa-save"></i>&nbsp; Guardar</button>
                </div>
            </div>
        </div>
        <div class="ayuda_demo_caption">
            Vista previa del formulario real. Los campos con <span class="ayuda_req">*</span> son obligatorios.
            "Servicios" y "Responsable OT" son los datos más sensibles: condicionan los métodos disponibles después en informes.
        </div>
    </div>
</template>

<script>
export default { name: 'ayuda-demo-form-ot' };
</script>

<style scoped>
.ayuda_demo_block { margin: 16px 0 20px; font-family: 'Montserrat', sans-serif; }
.ayuda_demo_label {
    font-size: 11px; color: #6b7280;
    text-transform: uppercase; letter-spacing: 0.06em;
    margin-bottom: 8px; font-weight: 700;
}
.ayuda_real_box {
    border: 1px solid #eef0f3;
    border-top: 3px solid #FFCC00;
    border-radius: 4px;
    box-shadow: none;
    margin-bottom: 0;
}
.ayuda_real_box .box-header { border-bottom: 1px solid #eef0f3; padding: 10px 14px; }
.ayuda_real_box .box-title { font-size: 14px; font-weight: 700; color: #1a1a1a; }
.ayuda_real_box .box-title i { color: #FFCC00; }
.ayuda_real_box .box-body { padding: 14px; }
.ayuda_real_box .form-control[disabled] { background: #fafbfc; cursor: not-allowed; color: #4c5661; }
.ayuda_real_box label { font-size: 12px; color: #4c5661; margin-bottom: 4px; }

.ayuda_req { color: #dc3545; font-weight: 700; }

.ayuda_chips_box {
    background: #fafbfc;
    border: 1px dashed #e5e7eb;
    border-radius: 4px;
    padding: 8px;
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    align-items: center;
    min-height: 40px;
}
.ayuda_chip { font-size: 12px; padding: 4px 9px; }
.ayuda_chip_add { width: 26px; height: 22px; padding: 0; }

.enod-form-actions { border-top: 1px solid #eef0f3; padding-top: 12px; margin-top: 12px; }

.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
</style>
