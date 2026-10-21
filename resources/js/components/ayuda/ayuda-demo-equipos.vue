<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Listado de equipos</div>
        <div class="box box-custom-enod ayuda_real_box">
            <div class="box-body">
                <div class="ayuda_abm_toolbar">
                    <button class="btn btn-enod btn-sm" tabindex="-1"><i class="fa fa-plus-circle"></i>&nbsp; Nuevo</button>
                    <div class="ayuda_abm_search">
                        <i class="fa fa-search"></i>
                        <input type="text" class="form-control input-sm" placeholder="Buscar..." disabled />
                    </div>
                </div>
                <div class="ayuda_table_wrap">
                    <table class="table table-hover table-striped table-condensed ayuda_real_table">
                        <thead>
                            <tr>
                                <th>Código</th><th>Descripción</th><th>Método</th><th>Tipo equipamiento</th><th>Inst. medición</th>
                                <th style="width:90px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(f, i) in filas" :key="i">
                                <td><strong>{{ f.codigo }}</strong></td>
                                <td>{{ f.descripcion }}</td>
                                <td><ayuda-chip-metodo v-for="m in f.metodos" :key="m" :metodo="m"></ayuda-chip-metodo></td>
                                <td>{{ f.tipo }}</td>
                                <td>{{ f.instrumento }}</td>
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
        <div class="ayuda_demo_caption">Datos de ejemplo. El método principal va primero en cada fila.</div>

        <div class="ayuda_demo_label ayuda_demo_label--gap">Formulario de alta (botón Nuevo)</div>
        <div class="box box-custom-enod ayuda_real_box ayuda_form_box">
            <div class="box-header with-border"><h3 class="box-title">Crear</h3></div>
            <div class="box-body">
                <div class="form-group">
                    <label>Código <span class="ayuda_req">*</span></label>
                    <input type="text" class="form-control" value="DEMO-001" disabled />
                </div>
                <div class="form-group">
                    <label>Descripción</label>
                    <input type="text" class="form-control" value="Detector digital de ejemplo" disabled />
                </div>
                <div class="form-group">
                    <label>Método de Ensayo <span class="ayuda_req">*</span></label>
                    <div class="ayuda_tags">
                        <span v-for="m in seleccion" :key="m" class="ayuda_tag">{{ m }} <i class="fa fa-times"></i></span>
                    </div>
                    <small class="text-muted">El primero es el principal. La lista queda abierta para sumar más.</small>
                </div>
                <div class="form-group">
                    <label>Tipo Equipamiento <span class="ayuda_req">*</span></label>
                    <select class="form-control" disabled><option>EQUIPO - PROYECTOR</option></select>
                    <small class="text-muted">El asterisco aparece porque uno de los métodos es RI.</small>
                </div>
                <div class="form-group">
                    <label>Instrumento Medición</label>
                    <select class="form-control" disabled><option>Deshabilitado: solo con LP o PM</option></select>
                </div>
                <div class="enod-form-actions enod-form-actions--end">
                    <button class="btn btn-default" disabled>Cancelar</button>
                    <button class="btn btn-enod" disabled><i class="fa fa-save"></i>&nbsp; Guardar</button>
                </div>
            </div>
        </div>
        <div class="ayuda_demo_caption">Los campos con <span class="ayuda_req">*</span> son obligatorios.</div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-equipos',
    data() {
        return {
            seleccion: ['RI', 'RD'],
            filas: [
                { codigo: 'DEMO-001', descripcion: 'Detector digital de ejemplo', metodos: ['RI', 'RD'], tipo: 'EQUIPO - PROYECTOR', instrumento: '' },
                { codigo: 'DEMO-002', descripcion: 'Yugo magnético de ejemplo',    metodos: ['PM'],       tipo: '', instrumento: 'Luxómetro luz blanca' },
                { codigo: 'DEMO-003', descripcion: 'Lámpara para PM y LP',         metodos: ['PM', 'LP'], tipo: '', instrumento: 'Lampara luz UV' },
                { codigo: 'DEMO-004', descripcion: 'Equipo US con palpador',       metodos: ['US'],       tipo: '', instrumento: '' },
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

.ayuda_abm_toolbar { display: flex; gap: 8px; margin-bottom: 12px; align-items: center; }
.ayuda_abm_search { position: relative; flex: 1; }
.ayuda_abm_search i.fa-search {
    position: absolute; top: 50%; left: 10px;
    transform: translateY(-50%); color: #9ca3af; z-index: 1;
}
.ayuda_abm_search input.form-control { padding-left: 30px; }

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

.ayuda_tags {
    display: flex; flex-wrap: wrap; gap: 4px; align-items: center;
    border: 1px solid #d2d6de; border-radius: 3px; padding: 4px 8px;
    min-height: 34px; background: #fff; margin-bottom: 4px;
}
.ayuda_tag {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 1px 6px 1px 8px; border: 1px solid #d2d6de; border-radius: 4px;
    background: #f0f0f0; font-size: 12px; color: #333;
}
.ayuda_tag i { color: #4c5661; font-size: 11px; }

.enod-form-actions { border-top: 1px solid #eef0f3; padding-top: 12px; margin-top: 8px; }

.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
</style>
