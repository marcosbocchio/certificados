<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Ejemplo: flujo de creación de una OT</div>
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
.ayuda_demo_block {
    margin: 12px 0 20px;
}
.ayuda_demo_label {
    font-size: 12px;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 10px;
    font-weight: 600;
}
.ayuda_wizard {
    list-style: none;
    counter-reset: pasos;
    padding: 0;
    margin: 0;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 10px;
}
.ayuda_wizard_item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 12px 14px;
    background: #fff;
    border: 1px solid #e3e8ee;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.18s ease;
    position: relative;
}
.ayuda_wizard_item:hover {
    border-color: #2e86c1;
    box-shadow: 0 4px 12px rgba(46, 134, 193, 0.12);
}
.ayuda_wizard_item.is-active {
    background: #eaf4fb;
    border-color: #2e86c1;
}
.ayuda_wizard_item.is-done {
    background: #f0fbf3;
    border-color: #28a745;
}
.ayuda_wizard_num {
    width: 32px; height: 32px;
    border-radius: 50%;
    background: #d6dce3;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 14px;
    flex-shrink: 0;
}
.ayuda_wizard_item.is-active .ayuda_wizard_num { background: #2e86c1; }
.ayuda_wizard_item.is-done .ayuda_wizard_num { background: #28a745; }
.ayuda_wizard_text strong {
    display: block;
    font-size: 13.5px;
    color: #1f2937;
    margin-bottom: 2px;
}
.ayuda_wizard_text small {
    display: block;
    font-size: 11.5px;
    color: #6b7280;
    line-height: 1.35;
}
.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 11px;
    color: #9ca3af;
    font-style: italic;
}
</style>
