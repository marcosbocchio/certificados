<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Formulario de nuevo certificado</div>

        <!-- Cabecera del certificado (certificado-header) -->
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

        <!-- Fecha / N° / Título / Información adicional -->
        <div class="box box-custom-enod ayuda_real_box">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Fecha <span class="ayuda_req">*</span></label>
                            <input type="text" class="form-control" value="25-06-2026" disabled />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Certificado N°</label>
                            <input type="text" class="form-control" value="00000212" disabled />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Título</label>
                            <input type="text" class="form-control" value="25-06-2026 - 25-06-2026" disabled />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Información adicional</label>
                            <textarea class="form-control" rows="2" disabled>Certificación semanal de servicios NDT del tramo 12.</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Box Partes sin certificados -->
        <div class="box box-custom-enod ayuda_real_box">
            <div class="box-header with-border">
                <h3 class="box-title">Partes sin certificados</h3>
            </div>
            <div class="box-body">
                <div class="ayuda_table_wrap">
                    <table class="table table-hover table-striped table-condensed ayuda_real_table">
                        <thead>
                            <tr>
                                <th style="width:34px;" class="text-center">Sel.</th>
                                <th>Parte N°</th>
                                <th>Obra</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(p, i) in partes" :key="i" :class="{ 'ayuda_row_selected': p.sel }">
                                <td class="text-center"><input type="checkbox" v-model="p.sel" /></td>
                                <td><strong>{{ p.numero }}</strong></td>
                                <td>{{ p.obra }}</td>
                                <td>{{ p.fecha }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p class="ayuda_hint"><i class="fa fa-info-circle"></i> Se tildan los partes diarios pendientes; al seleccionarlos se cargan sus servicios y productos. La selección incluye automáticamente los partes anteriores.</p>
            </div>
        </div>

        <!-- Box Servicios -->
        <div class="box box-custom-enod ayuda_real_box">
            <div class="box-header with-border">
                <h3 class="box-title">Servicios</h3>
            </div>
            <div class="box-body">
                <div class="ayuda_table_wrap">
                    <table class="table table-hover table-striped table-bordered table-condensed ayuda_real_table">
                        <thead>
                            <tr>
                                <th>Parte N°</th>
                                <th>Obra</th>
                                <th>Servicio</th>
                                <th>Descripción</th>
                                <th>Fecha</th>
                                <th class="text-center">Combinación</th>
                                <th class="text-center">Cantidad</th>
                                <th style="width:42px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(s, i) in servicios" :key="i">
                                <td>{{ s.parte }}</td>
                                <td>{{ s.obra }}</td>
                                <td>{{ s.servicio }}</td>
                                <td>{{ s.descripcion }}</td>
                                <td>{{ s.fecha }}</td>
                                <td class="text-center">{{ s.combinacion }}</td>
                                <td class="text-center"><strong>{{ s.cantidad }}</strong></td>
                                <td class="text-center"><i class="fa fa-minus-circle"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p class="ayuda_hint"><i class="fa fa-info-circle"></i> Los servicios que caen el mismo día se pueden <strong>combinar</strong> (ej. RI + PM). El botón de combinación permite separarlos o volver a combinarlos.</p>
            </div>
        </div>

        <!-- Box Productos (según modalidad de cobro) -->
        <div class="box box-custom-enod ayuda_real_box">
            <div class="box-header with-border">
                <h3 class="box-title">Productos</h3>
            </div>
            <div class="box-body">
                <div class="ayuda_modo_switch">
                    <button class="btn btn-xs" :class="modo === 'PLACAS' ? 'btn-enod' : 'btn-default'" @click="modo = 'PLACAS'">Modalidad PLACAS</button>
                    <button class="btn btn-xs" :class="modo === 'COSTURAS' ? 'btn-enod' : 'btn-default'" @click="modo = 'COSTURAS'">Modalidad COSTURAS</button>
                </div>

                <div class="ayuda_table_wrap" v-if="modo === 'PLACAS'">
                    <table class="table table-hover table-striped table-condensed ayuda_real_table">
                        <thead>
                            <tr><th>Parte N°</th><th>Placas</th><th>CM</th></tr>
                        </thead>
                        <tbody>
                            <tr v-for="(pr, i) in productosPlacas" :key="i">
                                <td>{{ pr.parte }}</td>
                                <td>{{ pr.placas }}</td>
                                <td>{{ pr.cm }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="ayuda_table_wrap" v-else>
                    <table class="table table-hover table-striped table-condensed ayuda_real_table">
                        <thead>
                            <tr><th>Parte N°</th><th>Costuras</th><th>Pulgadas</th></tr>
                        </thead>
                        <tbody>
                            <tr v-for="(pr, i) in productosCosturas" :key="i">
                                <td>{{ pr.parte }}</td>
                                <td>{{ pr.costuras }}</td>
                                <td>{{ pr.pulgadas }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p class="ayuda_hint"><i class="fa fa-info-circle"></i> La tabla de productos depende de la <strong>modalidad de cobro</strong> de la OT: por <strong>PLACAS</strong> (placas / CM) o por <strong>COSTURAS</strong> (costuras / pulgadas). Se muestra una u otra, nunca las dos.</p>
            </div>
        </div>

        <div class="enod-form-actions enod-form-actions--end">
            <button class="btn btn-enod" disabled><i class="fa fa-save"></i>&nbsp; Guardar</button>
        </div>

        <div class="ayuda_demo_caption">
            El certificado consolida los <strong>servicios</strong> y <strong>productos</strong> de los partes seleccionados.
            El N° de certificado es numérico con relleno de ceros (ej. 00000212). Probá cambiar la modalidad de cobro para ver
            cómo cambia la tabla de productos.
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-form-certificado',
    data() {
        return {
            modo: 'PLACAS',
            partes: [
                { numero: '00000089', obra: 'T12', fecha: '25-06-2026', sel: true },
                { numero: '00000088', obra: 'T12', fecha: '24-06-2026', sel: true },
                { numero: '00000087', obra: 'T12', fecha: '20-06-2026', sel: false },
            ],
            servicios: [
                { parte: '00000089', obra: 'T12', servicio: 'RI', descripcion: 'Radiografía industrial', fecha: '25-06-2026', combinacion: 'PM + RI', cantidad: 18 },
                { parte: '00000089', obra: 'T12', servicio: 'PM', descripcion: 'Partículas magnéticas',   fecha: '25-06-2026', combinacion: 'PM + RI', cantidad: 22 },
                { parte: '00000088', obra: 'T12', servicio: 'US', descripcion: 'Ultrasonido',             fecha: '24-06-2026', combinacion: 'US',      cantidad: 8 },
            ],
            productosPlacas: [
                { parte: '00000089', placas: 18, cm: 350 },
                { parte: '00000088', placas: 12, cm: 240 },
            ],
            productosCosturas: [
                { parte: '00000089', costuras: 6, pulgadas: 48 },
                { parte: '00000088', costuras: 4, pulgadas: 32 },
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
.ayuda_real_table .label { font-size: 11px; padding: 3px 8px; }
.ayuda_real_table .fa-minus-circle { color: #9aa1a9; }
.ayuda_row_selected { background: #fffdf5 !important; }

.ayuda_modo_switch { margin-bottom: 10px; }
.ayuda_modo_switch .btn { margin-right: 6px; }

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
