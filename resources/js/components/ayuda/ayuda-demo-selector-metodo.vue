<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Agregar informe: elegir método y presionar "Nuevo"</div>
        <div class="box box-custom-enod ayuda_real_box">
            <div class="box-header with-border">
                <h3 class="box-title">Agregar Informes</h3>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label>Tipo</label>
                    <div class="ayuda_vselect" @click="abierto = !abierto">
                        <div class="ayuda_vselect_value">
                            <template v-if="seleccionado">
                                <span class="ayuda_vselect_cod">{{ seleccionado.metodo }}</span>
                                <span class="ayuda_vselect_desc">{{ seleccionado.descripcion }}</span>
                            </template>
                            <span v-else class="ayuda_vselect_ph">Seleccionar método...</span>
                        </div>
                        <i class="fa fa-caret-down"></i>
                    </div>
                    <ul v-if="abierto" class="ayuda_vselect_menu">
                        <li v-for="m in metodos" :key="m.metodo" @click.stop="seleccionar(m)">
                            <span class="ayuda_vselect_cod">{{ m.metodo }}</span>
                            <span class="ayuda_vselect_desc">{{ m.descripcion }}</span>
                        </li>
                    </ul>
                </div>
                <div class="form-group">
                    <button class="btn btn-enod" :disabled="!seleccionado">
                        <span class="fa fa-plus-circle"></span>&nbsp; Nuevo
                    </button>
                </div>
            </div>
        </div>
        <div class="ayuda_demo_caption">
            En la lista <strong>solo aparecen los métodos cuyos servicios fueron cargados en la OT</strong>.
            Si el método que necesitás no está, primero hay que agregar el servicio correspondiente a la orden de trabajo.
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-selector-metodo',
    data() {
        return {
            abierto: false,
            seleccionado: { metodo: 'RI', descripcion: 'Radiografía Industrial' },
            metodos: [
                { metodo: 'RI', descripcion: 'Radiografía Industrial' },
                { metodo: 'US', descripcion: 'Ultrasonido' },
                { metodo: 'PM', descripcion: 'Partículas Magnéticas' },
            ],
        };
    },
    methods: {
        seleccionar(m) {
            this.seleccionado = m;
            this.abierto = false;
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
.ayuda_real_box .box-body { padding: 14px; }
.ayuda_real_box label { font-size: 12px; color: #4c5661; margin-bottom: 4px; display: block; }

.ayuda_vselect {
    position: relative;
    background: #fff;
    border: 1px solid #ced4da;
    border-radius: 4px;
    padding: 7px 12px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: 360px;
}
.ayuda_vselect:hover { border-color: #FFCC00; }
.ayuda_vselect_value { display: flex; flex-direction: column; line-height: 1.2; }
.ayuda_vselect_cod { font-size: 14px; font-weight: 700; color: #1a1a1a; }
.ayuda_vselect_desc { font-size: 11px; color: #6b7280; }
.ayuda_vselect_ph { font-size: 13px; color: #9ca3af; }
.ayuda_vselect .fa { color: #6b7280; }
.ayuda_vselect_menu {
    list-style: none;
    margin: 2px 0 0;
    padding: 4px 0;
    border: 1px solid #eef0f3;
    border-radius: 4px;
    background: #fff;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    max-width: 360px;
}
.ayuda_vselect_menu li {
    padding: 6px 12px;
    cursor: pointer;
}
.ayuda_vselect_menu li:hover { background: #fffdf5; }
.ayuda_vselect_menu .ayuda_vselect_cod { display: block; }
.ayuda_vselect_menu .ayuda_vselect_desc { display: block; }

.ayuda_demo_caption {
    margin-top: 10px;
    font-size: 12px;
    color: #6b7280;
}
</style>
