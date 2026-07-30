<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Encabezado del informe {{ metodo }}</div>
        <div class="box box-custom-enod ayuda_real_box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-file-text-o"></i>&nbsp;
                    Informe {{ metodo }} N° <span class="ayuda_numero">{{ numero }}</span>
                    <span class="label label-default ayuda_rev">Rev. 0</span>
                </h3>
            </div>
            <div class="box-body">
                <!-- Encabezado comun -->
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Cliente</label>
                            <input type="text" class="form-control" value="Transportadora del Norte S.A." disabled />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Proyecto</label>
                            <input type="text" class="form-control" value="Ampliación NEA 2026" disabled />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label>OT N°</label>
                            <input type="text" class="form-control" value="OT-1542" disabled />
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label>Obra N° <span class="ayuda_req">*</span></label>
                            <select class="form-control" disabled><option>Gasoducto NEA - T12</option></select>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label>Planta</label>
                            <select class="form-control" disabled><option>Planta compresora Km 150</option></select>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6" v-if="metodo === 'RI'">
                        <div class="form-group">
                            <label>Tipo informe RI <span class="ayuda_req">*</span></label>
                            <select class="form-control" v-model="tipoRI">
                                <option>Ducto</option>
                                <option>Planta</option>
                                <option>Perfiles</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Componente</label>
                            <input type="text" class="form-control" value="Cañería API 5L X60" disabled />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Material</label>
                            <input type="text" class="form-control" value="Acero al carbono" disabled />
                        </div>
                    </div>
                </div>

                <!-- Campos especificos por metodo -->
                <div class="row" v-if="metodo === 'RI' && tipoRI === 'Ducto'">
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label>PK <span class="ayuda_req">*</span></label>
                            <input type="text" class="form-control" value="125+450" disabled />
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label>Tipo Sol.</label>
                            <select class="form-control" disabled><option>LR - Línea regular</option></select>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label>Espesor (mm)</label>
                            <input type="text" class="form-control" value="12.7" disabled />
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label>Reparación</label>
                            <select class="form-control" disabled><option>No</option></select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>EPS / WPS</label>
                            <select class="form-control" disabled><option>EPS-API-1104</option></select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>PQR</label>
                            <select class="form-control" disabled><option>PQR-001/24</option></select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Procedimiento</label>
                            <select class="form-control" disabled><option>PR-{{ metodo }}-007</option></select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Equipo</label>
                            <select class="form-control" disabled><option>{{ equipoEjemplo }}</option></select>
                        </div>
                    </div>
                    <div class="col-sm-4" v-if="metodo === 'RI'">
                        <div class="form-group">
                            <label>Técnica</label>
                            <select class="form-control" disabled><option>DDSE - Doble pared simple exposición</option></select>
                        </div>
                    </div>
                    <div class="col-sm-4" v-if="metodo === 'PM' || metodo === 'LP'">
                        <div class="form-group">
                            <label>Método de trabajo</label>
                            <select class="form-control" disabled><option>{{ metodoTrabajo }}</option></select>
                        </div>
                    </div>
                    <div class="col-sm-4" v-if="metodo === 'PM'">
                        <div class="form-group">
                            <label>Partículas</label>
                            <select class="form-control" disabled><option>Fluorescentes (vía húmeda)</option></select>
                        </div>
                    </div>
                    <div class="col-sm-4" v-if="metodo === 'LP'">
                        <div class="form-group">
                            <label>Líquido penetrante</label>
                            <select class="form-control" disabled><option>Rojo visible Magnaflux SKL-SP</option></select>
                        </div>
                    </div>
                    <div class="col-sm-4" v-if="metodo === 'US'">
                        <div class="form-group">
                            <label>Técnica</label>
                            <select class="form-control" v-model="tecnicaUS">
                                <option>US convencional</option>
                                <option>Phase Array</option>
                                <option>Medición de espesores</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row" v-if="metodo === 'PM' || metodo === 'LP'">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Ins. Medición</label>
                            <select class="form-control" disabled><option>{{ instMedicion }}</option></select>
                        </div>
                    </div>
                    <div class="col-sm-6" v-if="metodo === 'LP'">
                        <div class="form-group">
                            <label>Revelador</label>
                            <select class="form-control" disabled><option>SKD-S2 (no acuoso)</option></select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Observaciones</label>
                    <textarea class="form-control noresize" rows="2" disabled>Inspección sin novedades. Condiciones ambientales: 22°C, HR 55%.</textarea>
                </div>

                <div class="enod-form-actions enod-form-actions--end">
                    <button class="btn btn-default" disabled>Cancelar</button>
                    <button class="btn btn-default" disabled><i class="fa fa-copy"></i>&nbsp; Clonar</button>
                    <button class="btn btn-enod" disabled><i class="fa fa-save"></i>&nbsp; Guardar</button>
                </div>
            </div>
        </div>
        <div class="ayuda_demo_caption">
            <span v-if="metodo === 'RI'">En <strong>ducto</strong> la numeración usa PK y tipo de soldadura ({{ '`150-LR-RI001`' }}); en <strong>planta</strong> queda como correlativo por OT ({{ '`RI001`' }}).</span>
            <span v-if="metodo === 'PM'">Las opciones de partículas dependen del método de trabajo. Solo se ven equipos creados para PM.</span>
            <span v-if="metodo === 'LP'">El método de trabajo define qué luxómetro/lámpara y qué líquidos están disponibles.</span>
            <span v-if="metodo === 'US'">Cambiá la técnica para ver cómo varían las calibraciones y mediciones requeridas.</span>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-form-informe',
    props: {
        metodo: { type: String, required: true, validator: v => ['RI','PM','LP','US'].includes(v) },
    },
    data() {
        return {
            tipoRI: 'Ducto',
            tecnicaUS: 'US convencional',
        };
    },
    computed: {
        numero() {
            return {
                'RI': this.tipoRI === 'Ducto' ? '150-LR-RI001' : 'RI001',
                'PM': 'PM015',
                'LP': 'LP008',
                'US': 'US042',
            }[this.metodo];
        },
        equipoEjemplo() {
            return {
                'RI': 'RX SPELLMAN 200 kV',
                'PM': 'Yugo electromagnético Y-7',
                'LP': '— (no aplica)',
                'US': 'OmniScan MX2',
            }[this.metodo];
        },
        metodoTrabajo() {
            return this.metodo === 'PM' ? 'Yugo - Vía húmeda fluorescente' : 'Solvente removible - Color contraste';
        },
        instMedicion() {
            return this.metodo === 'PM' ? 'Gauss-metro / Lámpara UV' : 'Luxómetro luz blanca';
        },
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
.ayuda_real_box {
    border: 1px solid #eef0f3;
    border-top: 3px solid #FFCC00;
    border-radius: 4px;
    box-shadow: none;
}
.ayuda_real_box .box-header { border-bottom: 1px solid #eef0f3; padding: 10px 14px; }
.ayuda_real_box .box-title { font-size: 14px; font-weight: 700; color: #1a1a1a; }
.ayuda_real_box .box-title i { color: #FFCC00; }
.ayuda_real_box .box-body { padding: 14px; }
.ayuda_real_box .form-control[disabled],
.ayuda_real_box textarea[disabled] { background: #fafbfc; cursor: not-allowed; color: #4c5661; }
.ayuda_real_box label { font-size: 12px; color: #4c5661; margin-bottom: 4px; }

.ayuda_req { color: #dc3545; font-weight: 700; }
.ayuda_numero { color: #d4a800; font-family: 'Courier New', monospace; font-size: 13px; }
.ayuda_rev { margin-left: 6px; font-size: 10px; font-weight: 600; }

.enod-form-actions { border-top: 1px solid #eef0f3; padding-top: 12px; margin-top: 12px; }

.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
</style>
