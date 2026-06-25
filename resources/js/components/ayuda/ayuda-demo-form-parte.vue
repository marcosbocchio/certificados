<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Cabecera del parte diario</div>
        <div class="box box-custom-enod ayuda_real_box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-calendar-check-o"></i>&nbsp; Nuevo parte diario · OT-1542</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Fecha <span class="ayuda_req">*</span></label>
                            <input type="text" class="form-control" value="25/06/2026" disabled />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Obra</label>
                            <select class="form-control" disabled><option>Gasoducto NEA - T12</option></select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Tipo de servicio <span class="ayuda_req">*</span></label>
                            <select class="form-control" disabled><option>Radiografía industrial</option></select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label>Horario inicio</label>
                            <input type="text" class="form-control" value="07:30" disabled />
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label>Horario fin</label>
                            <input type="text" class="form-control" value="16:00" disabled />
                        </div>
                    </div>
                </div>

                <ul class="nav nav-tabs ayuda_tabs">
                    <li v-for="(t, i) in tabs" :key="i" :class="{ active: activa === i }">
                        <a href="#" @click.prevent="activa = i">
                            <i :class="'fa fa-' + t.icono"></i>&nbsp; {{ t.label }}
                            <span v-if="t.badge !== null" class="badge ayuda_tab_badge">{{ t.badge }}</span>
                        </a>
                    </li>
                </ul>
                <div class="ayuda_tab_panel">
                    <p v-if="activa === 0"><i class="fa fa-info-circle"></i> Se listan los informes <strong>pendientes</strong> de la OT que coinciden con la fecha y obra elegidas. Tildá los que pertenezcan a esta jornada.</p>
                    <p v-if="activa === 1"><i class="fa fa-users"></i> Operadores que trabajaron en la jornada. Cada uno con hora de inicio, fin y novedades.</p>
                    <p v-if="activa === 2"><i class="fa fa-truck"></i> Vehículos usados, con kilometraje inicial y final.</p>
                    <p v-if="activa === 3"><i class="fa fa-cog"></i> Servicios o cantidades extra que no quedan cubiertos solo por los informes.</p>
                </div>

                <div class="enod-form-actions enod-form-actions--end">
                    <button class="btn btn-default" disabled>Cancelar</button>
                    <button class="btn btn-enod" disabled><i class="fa fa-save"></i>&nbsp; Guardar parte</button>
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

.ayuda_tabs { margin-top: 8px; border-bottom: 1px solid #eef0f3; }
.ayuda_tabs > li > a {
    color: #6b7280;
    font-size: 13px;
    font-weight: 600;
    padding: 8px 14px;
    border-radius: 0;
}
.ayuda_tabs > li.active > a,
.ayuda_tabs > li.active > a:hover,
.ayuda_tabs > li.active > a:focus {
    color: #1a1a1a;
    background: #fff;
    border-bottom: 3px solid #FFCC00;
    margin-bottom: -1px;
}
.ayuda_tabs > li > a:hover { background: #fafbfc; color: #1a1a1a; }
.ayuda_tab_badge {
    background: #FFCC00;
    color: #1a1a1a;
    font-size: 10px;
    margin-left: 4px;
}
.ayuda_tab_panel {
    background: #fafbfc;
    border: 1px solid #eef0f3;
    border-top: 0;
    padding: 12px 14px;
    font-size: 13px;
    color: #4c5661;
    margin-bottom: 14px;
    border-radius: 0 0 4px 4px;
}
.ayuda_tab_panel p { margin: 0; }
.ayuda_tab_panel i { color: #d4a800; margin-right: 4px; }

.enod-form-actions { border-top: 1px solid #eef0f3; padding-top: 12px; margin-top: 4px; }

.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
</style>
