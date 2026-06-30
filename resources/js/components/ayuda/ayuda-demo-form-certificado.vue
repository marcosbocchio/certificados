<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Formulario de nuevo certificado</div>
        <div class="box box-custom-enod ayuda_real_box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-certificate"></i>&nbsp; Nuevo certificado · OT-1542
                </h3>
            </div>
            <div class="box-body">
                <!-- Cabecera -->
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>N° certificado</label>
                            <input type="text" class="form-control" value="CERT-0212" disabled />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Fecha <span class="ayuda_req">*</span></label>
                            <input type="text" class="form-control" value="25/06/2026" disabled />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Título</label>
                            <input type="text" class="form-control" value="Avance semanal RI / PM - Tramo 12" disabled />
                        </div>
                    </div>
                </div>

                <!-- Selección de partes -->
                <div class="form-group">
                    <label>Partes diarios disponibles para certificar</label>
                    <div class="ayuda_table_wrap">
                        <table class="table table-hover table-striped table-bordered table-condensed ayuda_real_table">
                            <thead>
                                <tr>
                                    <th style="width:34px;" class="text-center"><i class="fa fa-check"></i></th>
                                    <th>N° parte</th>
                                    <th>Fecha</th>
                                    <th>Tipo de servicio</th>
                                    <th class="text-center">Informes</th>
                                    <th class="text-center">Horas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(p, i) in partes" :key="i" :class="{ 'ayuda_row_selected': p.sel }">
                                    <td class="text-center">
                                        <input type="checkbox" v-model="p.sel" />
                                    </td>
                                    <td><strong>{{ p.numero }}</strong></td>
                                    <td>{{ p.fecha }}</td>
                                    <td>{{ p.tipo }}</td>
                                    <td class="text-center"><span class="label label-warning">{{ p.informes }}</span></td>
                                    <td class="text-center">{{ p.horas }}h</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Resumen consolidado -->
                <div class="ayuda_consolidado" v-if="seleccionados.length">
                    <h4 class="ayuda_consolidado_title">
                        <i class="fa fa-calculator"></i>&nbsp; Servicios consolidados ({{ seleccionados.length }} partes)
                    </h4>
                    <table class="table table-condensed ayuda_consol_table">
                        <thead>
                            <tr>
                                <th>Servicio</th>
                                <th class="text-center">Cant. partes</th>
                                <th class="text-center">Cant. final</th>
                                <th class="text-center">Unidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(s, i) in servicios" :key="i">
                                <td>{{ s.nombre }}</td>
                                <td class="text-center">{{ s.partes }}</td>
                                <td class="text-center"><strong>{{ s.final }}</strong></td>
                                <td class="text-center"><span class="text-muted">{{ s.unidad }}</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else class="ayuda_consolidado ayuda_consolidado--empty">
                    <i class="fa fa-info-circle"></i>&nbsp; Seleccioná al menos un parte para ver el consolidado.
                </div>

                <div class="enod-form-actions enod-form-actions--end">
                    <button class="btn btn-default" disabled>Cancelar</button>
                    <button class="btn btn-enod" disabled :class="{ disabled: !seleccionados.length }">
                        <i class="fa fa-save"></i>&nbsp; Guardar certificado
                    </button>
                </div>
            </div>
        </div>
        <div class="ayuda_demo_caption">
            Probá tildar / destildar partes — el consolidado de <strong>Servicios</strong> se recalcula automáticamente.
            Los certificados no nacen de cero: suman cantidades de los partes seleccionados.
        </div>
    </div>
</template>

<script>
const PARTES = [
    { numero: 'P-0089', fecha: '25/06/2026', tipo: 'Radiografía industrial', informes: 5, horas: 8,  sel: true,
      detalle: { 'Radiografía RI': { cant: 18, unidad: 'placas' }, 'Inspección visual': { cant: 12, unidad: 'm' } } },
    { numero: 'P-0088', fecha: '24/06/2026', tipo: 'Partículas magnéticas',  informes: 3, horas: 7,  sel: true,
      detalle: { 'Partículas magnéticas': { cant: 22, unidad: 'm' } } },
    { numero: 'P-0087', fecha: '20/06/2026', tipo: 'Radiografía industrial', informes: 7, horas: 9,  sel: false,
      detalle: { 'Radiografía RI': { cant: 24, unidad: 'placas' } } },
    { numero: 'P-0086', fecha: '18/06/2026', tipo: 'Ultrasonido',            informes: 2, horas: 6,  sel: false,
      detalle: { 'Ultrasonido': { cant: 8, unidad: 'puntos' } } },
];

export default {
    name: 'ayuda-demo-form-certificado',
    data() { return { partes: PARTES }; },
    computed: {
        seleccionados() { return this.partes.filter(p => p.sel); },
        servicios() {
            const acc = {};
            this.seleccionados.forEach(p => {
                Object.entries(p.detalle).forEach(([nom, { cant, unidad }]) => {
                    if (!acc[nom]) acc[nom] = { nombre: nom, partes: 0, final: 0, unidad };
                    acc[nom].partes += 1;
                    acc[nom].final  += cant;
                });
            });
            return Object.values(acc);
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
.ayuda_row_selected { background: #fffdf5 !important; }

.ayuda_consolidado {
    margin-top: 14px;
    background: #fffdf5;
    border: 1px solid #f0df9a;
    border-left: 3px solid #FFCC00;
    border-radius: 0 4px 4px 0;
    padding: 12px 14px;
}
.ayuda_consolidado--empty {
    background: #fafbfc;
    border: 1px dashed #e5e7eb;
    border-left: 3px solid #d1d5db;
    color: #6b7280;
    font-size: 13px;
    text-align: center;
    padding: 16px;
}
.ayuda_consolidado_title {
    margin: 0 0 10px;
    font-size: 13px;
    font-weight: 700;
    color: #5c4a00;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.ayuda_consol_table {
    background: #fff;
    border: 1px solid #f0df9a;
    margin-bottom: 0;
    font-size: 13px;
}
.ayuda_consol_table th {
    background: #fffdf5;
    color: #5c4a00;
    font-size: 11.5px;
    text-transform: uppercase;
    font-weight: 700;
    border-bottom: 1px solid #f0df9a;
}

.enod-form-actions { border-top: 1px solid #eef0f3; padding-top: 12px; margin-top: 14px; }

.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
</style>
