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
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="form-group">
                            <label>Contraseña <span class="ayuda_req">*</span></label>
                            <input type="password" class="form-control" v-model="actual" />
                        </div>

                        <div class="form-group">
                            <label>Nueva Contraseña</label>
                            <input type="password" class="form-control" v-model="nueva" />
                        </div>

                        <div class="form-group">
                            <label>Repetir contraseña</label>
                            <input type="password" class="form-control" v-model="repetir" />
                        </div>

                        <div class="enod-form-actions enod-form-actions--end">
                            <button class="btn btn-enod" disabled>Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ayuda_demo_caption">
            Esta función se accede desde <strong>Perfil</strong>. Se ingresa la contraseña actual, la nueva y su repetición;
            la validación se hace en el servidor al guardar.
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
.ayuda_real_box label { font-size: 12px; color: #4c5661; margin-bottom: 4px; }
.ayuda_req { color: #dc3545; font-weight: 700; }

.enod-form-actions { border-top: 1px solid #eef0f3; padding-top: 12px; margin-top: 14px; }

.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
</style>
