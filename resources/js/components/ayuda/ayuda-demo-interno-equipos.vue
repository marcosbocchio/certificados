<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Listado de internos de equipos</div>
        <div class="box box-custom-enod ayuda_real_box">
            <div class="box-body">
                <div class="ayuda_abm_toolbar">
                    <button class="btn btn-enod btn-sm" tabindex="-1"><i class="fa fa-plus-circle"></i>&nbsp; Nuevo</button>
                    <label class="ayuda_check_activos"><input type="checkbox" disabled /> Mostrar activos</label>
                </div>
                <div class="ayuda_table_wrap">
                    <table class="table table-condensed ayuda_real_table">
                        <thead>
                            <tr>
                                <th>N° int.</th><th>Tipo equipamiento</th><th>Equipo</th><th>Método</th><th></th>
                                <th>Fuente</th><th>Actividad</th><th>Ubicación</th><th>Baja</th><th style="width:90px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(f, i) in filas" :key="i" :class="{ ayuda_fila_baja: f.baja }">
                                <td><strong>{{ f.nro }}</strong></td>
                                <td>{{ f.tipo }}</td>
                                <td>{{ f.equipo }}</td>
                                <td><ayuda-chip-metodo v-for="m in f.metodos" :key="m" :metodo="m"></ayuda-chip-metodo></td>
                                <td><span class="btn btn-default btn-xs"><i class="fa fa-table"></i></span></td>
                                <td>{{ f.fuente }}</td>
                                <td>{{ f.actividad }}</td>
                                <td>{{ f.frente }}</td>
                                <td>{{ f.baja }}</td>
                                <td class="text-center">
                                    <span class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></span>
                                    <span class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="ayuda_demo_caption">Datos de ejemplo. La fila roja es un interno inactivo. El ícono de grilla de cada fila abre el historial de fuentes.</div>

        <div class="ayuda_demo_label ayuda_demo_label--gap">Formulario de un equipo RI / RD</div>
        <div class="box box-custom-enod ayuda_real_box ayuda_form_box">
            <div class="box-header with-border"><h3 class="box-title">Crear</h3></div>
            <div class="box-body">
                <div class="ayuda_activo"><label><input type="checkbox" checked disabled /> ACTIVO</label></div>
                <div class="form-group">
                    <label>N° Serie</label>
                    <input type="text" class="form-control" value="A-100" disabled />
                </div>
                <div class="form-group">
                    <label>N° Interno <span class="ayuda_req">*</span></label>
                    <input type="text" class="form-control" value="12" disabled />
                </div>
                <div class="form-group">
                    <label>Equipo <span class="ayuda_req">*</span></label>
                    <div class="ayuda_tags"><span class="ayuda_tag">DEMO-001</span></div>
                </div>
                <div class="form-group">
                    <label>Tipo Equipamiento</label>
                    <input type="text" class="form-control" value="EQUIPO - PROYECTOR" disabled />
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group"><label>Fuente</label><select class="form-control" disabled><option>SE 75 - POLYTEC</option></select></div>
                    <div class="col-sm-6 form-group"><label>Foco</label><input type="text" class="form-control" value="3.4" disabled /></div>
                    <div class="col-sm-6 form-group"><label>Voltaje</label><input type="text" class="form-control" value="" disabled /></div>
                    <div class="col-sm-6 form-group"><label>Amperaje</label><input type="text" class="form-control" value="" disabled /></div>
                </div>
                <div class="enod-form-actions enod-form-actions--end">
                    <button class="btn btn-default" disabled>Cancelar</button>
                    <button class="btn btn-enod" disabled><i class="fa fa-save"></i>&nbsp; Guardar</button>
                </div>
            </div>
        </div>
        <div class="ayuda_demo_caption">Los campos Fuente, Foco, Voltaje y Amperaje aparecen porque el equipo tiene RI o RD. Con DZ se piden Probeta y Dureza de calibración.</div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-interno-equipos',
    data() {
        return {
            filas: [
                { nro: '12', tipo: 'EQUIPO - PROYECTOR', equipo: 'DEMO-001', metodos: ['RI', 'RD'], fuente: 'SE 75 - POLYTEC',     actividad: '38 Ci', frente: 'BS.AS (Central)', baja: '' },
                { nro: '13', tipo: 'EQUIPO - PROYECTOR', equipo: 'DEMO-001', metodos: ['RI', 'RD'], fuente: 'IR 192 - QSA GLOBAL', actividad: '21 Ci', frente: 'Obra NEA',        baja: '' },
                { nro: '17', tipo: 'EQUIPO - PROYECTOR', equipo: 'DEMO-001', metodos: ['RI', 'RD'], fuente: '',                    actividad: '',      frente: 'BS.AS (Central)', baja: '04/09/2025' },
                { nro: '31', tipo: '',                   equipo: 'DEMO-004', metodos: ['US'],       fuente: '',                    actividad: '',      frente: 'BS.AS (Central)', baja: '' },
            ],
        };
    },
};
</script>

<style scoped>
.ayuda_demo_block { margin: 16px 0 20px; font-family: 'Montserrat', sans-serif; }
.ayuda_demo_label {
    font-size: 11px; color: #6b7280;
    text-transform: uppercase; letter-spacing: 0.06em;
    margin-bottom: 8px; font-weight: 700;
}
.ayuda_demo_label--gap { margin-top: 22px; }
.ayuda_real_box {
    border: 1px solid #eef0f3;
    border-top: 3px solid #FFCC00;
    border-radius: 4px;
    box-shadow: none;
}
.ayuda_real_box .box-header { border-bottom: 1px solid #eef0f3; padding: 10px 14px; }
.ayuda_real_box .box-title { font-size: 14px; font-weight: 700; color: #1a1a1a; }
.ayuda_real_box .box-body { padding: 14px; }
.ayuda_form_box { max-width: 520px; }
.ayuda_real_box .form-control[disabled] { background: #fafbfc; cursor: not-allowed; color: #4c5661; }
.ayuda_real_box label { font-size: 12px; color: #4c5661; margin-bottom: 4px; }
.ayuda_req { color: #dc3545; font-weight: 700; }

.ayuda_abm_toolbar { display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 12px; align-items: center; justify-content: space-between; }
.ayuda_check_activos { margin: 0; font-weight: 600; cursor: default; }
.ayuda_check_activos input { margin-right: 6px; }
.ayuda_activo { text-align: right; margin-bottom: 8px; }
.ayuda_activo label { font-weight: 700; color: #1a1a1a; }

.ayuda_table_wrap { overflow-x: auto; }
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
.ayuda_real_table .btn-xs { margin: 0 1px; pointer-events: none; }
.ayuda_real_table > tbody > tr.ayuda_fila_baja > td { background: #dc3545; color: #fff; }

.ayuda_tags {
    display: flex; flex-wrap: wrap; gap: 4px; align-items: center;
    border: 1px solid #d2d6de; border-radius: 3px; padding: 4px 8px;
    min-height: 34px; background: #fafbfc;
}
.ayuda_tag { font-size: 13px; color: #4c5661; }

.enod-form-actions { border-top: 1px solid #eef0f3; padding-top: 12px; margin-top: 8px; }

.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
</style>
