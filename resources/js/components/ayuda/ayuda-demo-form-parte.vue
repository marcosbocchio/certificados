<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Formulario de nuevo parte diario</div>

        <!-- Cabecera del parte (parte-header) -->
        <div class="box box-custom-enod ayuda_real_box">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Cliente</label>
                            <input type="text" class="form-control" value="Techint S.A." disabled />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Proyecto</label>
                            <input type="text" class="form-control" value="Gasoducto NEA" disabled />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Obra N°</label>
                            <input type="text" class="form-control" value="T12" disabled />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Orden de Trabajo N°</label>
                            <input type="text" class="form-control" value="1542" disabled />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fecha / Tipo Servicio (turno) / Horario -->
        <div class="box box-custom-enod ayuda_real_box">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Fecha <span class="ayuda_req">*</span></label>
                            <input type="checkbox" checked disabled style="float:right" />
                            <label style="float:right;margin-right:5px;font-weight:400;">Permitir Anteriores</label>
                            <input type="text" class="form-control" value="25-06-2026" disabled />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Tipo Servicio <span class="ayuda_req">*</span></label>
                            <select class="form-control" disabled><option>Diurno</option></select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Horario <span class="ayuda_req">*</span></label>
                            <input type="text" class="form-control" value="07-16" placeholder="HH-HH" disabled />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label style="display:block;">&nbsp;</label>
                            <input type="checkbox" disabled />
                            <label style="margin-left:5px;font-weight:400;">Movilidad Propia</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Box Responsabilidades -->
        <div class="box box-custom-enod ayuda_real_box">
            <div class="box-header with-border">
                <h3 class="box-title">Responsabilidades</h3>
            </div>
            <div class="box-body">
                <table class="table table-condensed ayuda_real_table">
                    <thead>
                        <tr><th>Operador</th><th>Responsabilidad</th><th style="width:42px;"></th></tr>
                    </thead>
                    <tbody>
                        <tr><td>Juan Pérez</td><td>OPERADOR</td><td class="text-center"><i class="fa fa-minus-circle"></i></td></tr>
                        <tr><td>Marcos Aguirre</td><td>AYUDANTE</td><td class="text-center"><i class="fa fa-minus-circle"></i></td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Box Informes sin parte diario -->
        <div class="box box-custom-enod ayuda_real_box">
            <div class="box-header with-border">
                <h3 class="box-title">Informes sin parte diario</h3>
            </div>
            <div class="box-body">
                <table class="table table-condensed ayuda_real_table">
                    <thead>
                        <tr>
                            <th style="width:34px;" class="text-center"><i class="fa fa-check"></i></th>
                            <th>Tipo</th>
                            <th>Informe</th>
                            <th>Obra</th>
                            <th>Planta</th>
                            <th>Fecha</th>
                            <th>Solicitante</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td class="text-center"><input type="checkbox" checked disabled /></td><td>RI</td><td>00001204</td><td>T12</td><td>NEA</td><td>25-06-2026</td><td>L. Mendoza</td></tr>
                        <tr><td class="text-center"><input type="checkbox" checked disabled /></td><td>PM</td><td>00000876</td><td>T12</td><td>NEA</td><td>25-06-2026</td><td>L. Mendoza</td></tr>
                        <tr><td class="text-center"><input type="checkbox" disabled /></td><td>US</td><td>00000341</td><td>T12</td><td>NEA</td><td>25-06-2026</td><td>&nbsp;</td></tr>
                    </tbody>
                </table>
                <p class="ayuda_hint"><i class="fa fa-info-circle"></i> Se listan los informes pendientes de la OT que coinciden con la fecha y obra elegidas. Tildá los que pertenezcan a esta jornada.</p>
            </div>
        </div>

        <!-- Box Servicios -->
        <div class="box box-custom-enod ayuda_real_box">
            <div class="box-header with-border">
                <h3 class="box-title">Servicios</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-condensed ayuda_real_table">
                    <thead>
                        <tr><th>Método</th><th>Descripción</th><th class="text-center">Cant.</th><th style="width:42px;"></th></tr>
                    </thead>
                    <tbody>
                        <tr><td>RI</td><td>Radiografía industrial - placas</td><td class="text-center">18</td><td class="text-center"><i class="fa fa-minus-circle"></i></td></tr>
                        <tr><td>PM</td><td>Partículas magnéticas</td><td class="text-center">22</td><td class="text-center"><i class="fa fa-minus-circle"></i></td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Box Observaciones -->
        <div class="box box-custom-enod ayuda_real_box">
            <div class="box-body">
                <div class="form-group">
                    <label>Observaciones</label>
                    <textarea class="form-control" rows="3" disabled>Jornada sin novedades. Se completó el tramo previsto.</textarea>
                </div>
            </div>
        </div>

        <div class="enod-form-actions enod-form-actions--end">
            <button class="btn btn-enod" disabled><i class="fa fa-save"></i>&nbsp; Guardar</button>
        </div>

        <div class="ayuda_demo_caption">
            La cabecera (Cliente, Proyecto, Obra y OT) viene fijada por la orden de trabajo. La <strong>Fecha</strong> y la obra
            filtran los <strong>informes sin parte diario</strong> disponibles. <strong>Tipo Servicio</strong> es el turno
            (Diurno / Nocturno) y el <strong>Horario</strong> se carga en un solo campo con formato HH-HH.
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-form-parte',
};
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
    margin-bottom: 12px;
}
.ayuda_real_box .box-header { border-bottom: 1px solid #eef0f3; padding: 10px 14px; }
.ayuda_real_box .box-title { font-size: 14px; font-weight: 700; color: #1a1a1a; }
.ayuda_real_box .box-title i { color: #FFCC00; }
.ayuda_real_box .box-body { padding: 14px; }
.ayuda_real_box .form-control[disabled] { background: #fafbfc; cursor: not-allowed; color: #4c5661; }
.ayuda_real_box label { font-size: 12px; color: #4c5661; margin-bottom: 4px; }
.ayuda_req { color: #dc3545; font-weight: 700; }

.ayuda_real_table { background: #fff; margin-bottom: 0; }
.ayuda_real_table > thead > tr > th {
    background: #fafbfc;
    border-bottom: 2px solid #FFCC00;
    color: #4c5661;
    font-size: 11.5px;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    font-weight: 700;
    white-space: nowrap;
}
.ayuda_real_table > tbody > tr > td { font-size: 13px; vertical-align: middle; }
.ayuda_real_table .fa-minus-circle { color: #9aa1a9; }

.ayuda_hint { margin: 10px 0 0; font-size: 12px; color: #6b7280; }
.ayuda_hint i { color: #d4a800; margin-right: 4px; }

.enod-form-actions { border-top: 1px solid #eef0f3; padding-top: 12px; margin-top: 4px; }

.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
</style>
