<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Formulario de cambio de contraseña</div>
        <div class="box box-custom-enod ayuda_real_box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-key"></i>&nbsp; Cambiar contraseña
                </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="form-group">
                            <label>Contraseña actual <span class="ayuda_req">*</span></label>
                            <div class="ayuda_password_wrap">
                                <input :type="ver.actual ? 'text' : 'password'" class="form-control" v-model="actual" placeholder="••••••••" />
                                <button class="ayuda_toggle_eye" @click="ver.actual = !ver.actual" type="button">
                                    <i :class="ver.actual ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Nueva contraseña <span class="ayuda_req">*</span></label>
                            <div class="ayuda_password_wrap">
                                <input :type="ver.nueva ? 'text' : 'password'" class="form-control" v-model="nueva" placeholder="Mínimo 8 caracteres" />
                                <button class="ayuda_toggle_eye" @click="ver.nueva = !ver.nueva" type="button">
                                    <i :class="ver.nueva ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
                                </button>
                            </div>

                            <!-- Indicador de fortaleza -->
                            <div v-if="nueva" class="ayuda_strength">
                                <div class="ayuda_strength_bar">
                                    <div class="ayuda_strength_fill" :class="'ayuda_strength_fill--' + fuerza.nivel"
                                         :style="{ width: fuerza.pct + '%' }"></div>
                                </div>
                                <small :class="'text-' + fuerza.color">
                                    <i :class="'fa fa-' + fuerza.icono"></i>&nbsp; {{ fuerza.label }}
                                </small>
                            </div>

                            <!-- Checklist requisitos -->
                            <ul class="ayuda_reqs">
                                <li :class="{ ok: nueva.length >= 8 }">
                                    <i :class="nueva.length >= 8 ? 'fa fa-check' : 'fa fa-circle-o'"></i>
                                    Al menos 8 caracteres
                                </li>
                                <li :class="{ ok: /[A-Z]/.test(nueva) }">
                                    <i :class="/[A-Z]/.test(nueva) ? 'fa fa-check' : 'fa fa-circle-o'"></i>
                                    Una mayúscula
                                </li>
                                <li :class="{ ok: /[0-9]/.test(nueva) }">
                                    <i :class="/[0-9]/.test(nueva) ? 'fa fa-check' : 'fa fa-circle-o'"></i>
                                    Un número
                                </li>
                                <li :class="{ ok: /[^A-Za-z0-9]/.test(nueva) }">
                                    <i :class="/[^A-Za-z0-9]/.test(nueva) ? 'fa fa-check' : 'fa fa-circle-o'"></i>
                                    Un símbolo (opcional)
                                </li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label>Repetir nueva contraseña <span class="ayuda_req">*</span></label>
                            <input :type="ver.nueva ? 'text' : 'password'" class="form-control" v-model="repetir" placeholder="Repetí la nueva contraseña"
                                   :class="{ 'ayuda_input_ok': coinciden, 'ayuda_input_err': repetir && !coinciden }" />
                            <small v-if="repetir && !coinciden" class="text-danger">
                                <i class="fa fa-times"></i>&nbsp; Las contraseñas no coinciden.
                            </small>
                            <small v-else-if="coinciden && nueva" class="text-success">
                                <i class="fa fa-check"></i>&nbsp; Coinciden.
                            </small>
                        </div>

                        <div class="enod-form-actions enod-form-actions--end">
                            <button class="btn btn-default" disabled>Cancelar</button>
                            <button class="btn btn-enod" :disabled="!puedeGuardar">
                                <i class="fa fa-save"></i>&nbsp; Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ayuda_demo_caption">
            Probá tipear una contraseña — el indicador y los requisitos cambian en tiempo real. El botón Guardar solo se habilita cuando todo es válido.
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-cambio-clave',
    data() {
        return {
            actual: '',
            nueva: '',
            repetir: '',
            ver: { actual: false, nueva: false },
        };
    },
    computed: {
        coinciden() { return this.nueva && this.repetir && this.nueva === this.repetir; },
        fuerza() {
            let s = 0;
            if (this.nueva.length >= 8) s++;
            if (this.nueva.length >= 12) s++;
            if (/[A-Z]/.test(this.nueva)) s++;
            if (/[0-9]/.test(this.nueva)) s++;
            if (/[^A-Za-z0-9]/.test(this.nueva)) s++;
            const niveles = [
                { nivel: 'muy-baja', pct: 15, label: 'Muy débil',  color: 'danger',  icono: 'times-circle' },
                { nivel: 'baja',     pct: 30, label: 'Débil',       color: 'danger',  icono: 'times-circle' },
                { nivel: 'media',    pct: 55, label: 'Regular',     color: 'warning', icono: 'exclamation-circle' },
                { nivel: 'buena',    pct: 75, label: 'Buena',       color: 'success', icono: 'check-circle' },
                { nivel: 'fuerte',   pct: 100,label: 'Muy segura',  color: 'success', icono: 'check-circle' },
            ];
            return niveles[Math.min(s, 4)] || niveles[0];
        },
        puedeGuardar() {
            return this.actual && this.nueva.length >= 8 && this.coinciden;
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
.ayuda_real_box label { font-size: 12px; color: #4c5661; margin-bottom: 4px; }
.ayuda_req { color: #dc3545; font-weight: 700; }

.ayuda_password_wrap { position: relative; }
.ayuda_password_wrap input { padding-right: 36px; }
.ayuda_toggle_eye {
    position: absolute; top: 50%; right: 6px;
    transform: translateY(-50%);
    background: transparent; border: 0;
    color: #6b7280; padding: 6px 8px;
    cursor: pointer;
}
.ayuda_toggle_eye:hover { color: #1a1a1a; }

.ayuda_strength { margin-top: 6px; }
.ayuda_strength_bar {
    height: 4px;
    background: #f3f4f6;
    border-radius: 2px;
    overflow: hidden;
    margin-bottom: 3px;
}
.ayuda_strength_fill {
    height: 100%;
    transition: all 0.25s ease;
    border-radius: 2px;
}
.ayuda_strength_fill--muy-baja { background: #dc3545; }
.ayuda_strength_fill--baja     { background: #dc3545; }
.ayuda_strength_fill--media    { background: #d99000; }
.ayuda_strength_fill--buena    { background: #28a745; }
.ayuda_strength_fill--fuerte   { background: #28a745; }

.ayuda_reqs {
    list-style: none;
    padding: 6px 0 0;
    margin: 6px 0 0;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4px 16px;
    border-top: 1px dashed #eef0f3;
}
.ayuda_reqs li {
    font-size: 11.5px;
    color: #9ca3af;
    transition: color 0.15s ease;
}
.ayuda_reqs li i { width: 14px; }
.ayuda_reqs li.ok { color: #1b6b34; }
.ayuda_reqs li.ok i { color: #1b6b34; }

.ayuda_input_ok  { border-color: #28a745 !important; }
.ayuda_input_err { border-color: #dc3545 !important; }

.enod-form-actions { border-top: 1px solid #eef0f3; padding-top: 12px; margin-top: 14px; }

.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
</style>
