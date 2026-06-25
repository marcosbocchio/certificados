<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Flujo paso a paso</div>
        <ol class="ayuda_wizard">
            <li
                v-for="(paso, i) in pasos"
                :key="i"
                class="ayuda_wizard_item"
                :class="{ 'is-active': activo === i, 'is-done': i < activo }"
                @click="activo = i"
            >
                <div class="ayuda_wizard_num">
                    <i v-if="i < activo" class="fa fa-check"></i>
                    <span v-else>{{ i + 1 }}</span>
                </div>
                <div class="ayuda_wizard_text">
                    <strong>{{ paso.titulo }}</strong>
                    <small>{{ paso.detalle }}</small>
                </div>
            </li>
        </ol>
        <div class="ayuda_demo_caption">
            Hacé click en cada paso para resaltarlo. En el sistema real cada paso se cierra al confirmar el anterior.
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-wizard-pasos',
    data() {
        return {
            activo: 1,
            pasos: [
                { titulo: 'Tablero principal', detalle: 'Ingresar al menú principal y abrir el tablero de OT.' },
                { titulo: 'Nueva OT',           detalle: 'Hacer click en el botón "Nueva OT" para iniciar el formulario.' },
                { titulo: 'Completar datos',    detalle: 'Cliente, comitente, responsable, servicios, productos, EPP y riesgos.' },
                { titulo: 'Guardar',            detalle: 'Crear la OT y habilitar su circuito operativo.' },
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
.ayuda_wizard {
    list-style: none;
    padding: 0; margin: 0;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 8px;
}
.ayuda_wizard_item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 12px 14px;
    background: #fff;
    border: 1px solid #eef0f3;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.12s ease;
}
.ayuda_wizard_item:hover {
    border-color: #FFCC00;
}
.ayuda_wizard_item.is-active {
    background: #fffdf5;
    border-color: #FFCC00;
    border-left: 3px solid #FFCC00;
    padding-left: 12px;
}
.ayuda_wizard_item.is-done {
    background: #fff;
    border-color: #e6f4ea;
}
.ayuda_wizard_num {
    width: 28px; height: 28px;
    border-radius: 50%;
    background: #f3f4f6;
    color: #6b7280;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 13px;
    flex-shrink: 0;
}
.ayuda_wizard_item.is-active .ayuda_wizard_num { background: #FFCC00; color: #1a1a1a; }
.ayuda_wizard_item.is-done .ayuda_wizard_num { background: #1b6b34; color: #fff; }
.ayuda_wizard_text strong {
    display: block;
    font-size: 13px;
    color: #1a1a1a;
    margin-bottom: 2px;
    font-weight: 700;
}
.ayuda_wizard_text small {
    display: block;
    font-size: 11.5px;
    color: #6b7280;
    line-height: 1.4;
}
.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
</style>
