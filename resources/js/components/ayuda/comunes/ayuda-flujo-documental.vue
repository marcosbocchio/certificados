<template>
    <div class="ayuda_flujo">
        <div class="ayuda_flujo_label">Ciclo documental Enod</div>
        <div class="ayuda_flujo_grid">
            <div v-for="(p, i) in pasos" :key="i" class="ayuda_flujo_paso">
                <a :href="p.ruta" class="ayuda_flujo_card">
                    <div class="ayuda_flujo_icon"><i :class="'fa fa-' + p.icono"></i></div>
                    <div class="ayuda_flujo_text">
                        <strong>{{ p.titulo }}</strong>
                        <small>{{ p.detalle }}</small>
                    </div>
                </a>
                <i v-if="i < pasos.length - 1" class="fa fa-long-arrow-right ayuda_flujo_arrow"></i>
            </div>
        </div>
        <p class="ayuda_flujo_caption">
            Cada paso usa información del anterior. Si la OT está mal cargada, todo el resto se ve afectado.
        </p>
    </div>
</template>

<script>
export default {
    name: 'ayuda-flujo-documental',
    data() {
        return {
            pasos: [
                { titulo: 'OT',         detalle: 'Configura cliente, servicios, operadores',  icono: 'clipboard',         ruta: '/crear_ot' },
                { titulo: 'Informes',   detalle: 'Evidencia técnica por método (RI, PM, …)',   icono: 'file-text-o',       ruta: '/generar_informes' },
                { titulo: 'Parte',      detalle: 'Consolida jornada con informes',              icono: 'calendar-check-o',  ruta: '/crear_parte_diario' },
                { titulo: 'Certificado',detalle: 'Cierra partes en salida formal',              icono: 'certificate',       ruta: '/crear_certificados' },
                { titulo: 'Remito',     detalle: 'Mueve productos/equipos asociados',           icono: 'truck',              ruta: '/ayuda_creacion_remito' },
            ],
        };
    },
};
</script>

<style scoped>
.ayuda_flujo { margin: 16px 0 24px; font-family: 'Montserrat', sans-serif; }
.ayuda_flujo_label {
    font-size: 11px; color: #6b7280;
    text-transform: uppercase; letter-spacing: 0.06em;
    margin-bottom: 10px; font-weight: 700;
}
.ayuda_flujo_grid {
    display: flex;
    flex-wrap: wrap;
    align-items: stretch;
    gap: 4px;
}
.ayuda_flujo_paso {
    display: flex;
    align-items: center;
    flex: 1 1 180px;
    min-width: 0;
}
.ayuda_flujo_card {
    flex: 1;
    display: flex;
    gap: 10px;
    padding: 12px 12px;
    background: #fff;
    border: 1px solid #eef0f3;
    border-top: 3px solid #FFCC00;
    border-radius: 4px;
    text-decoration: none;
    color: #1a1a1a;
    transition: all 0.12s ease;
    align-items: center;
}
.ayuda_flujo_card:hover {
    border-color: #FFCC00;
    background: #fffdf5;
    transform: translateY(-1px);
}
.ayuda_flujo_icon {
    width: 36px; height: 36px;
    border-radius: 50%;
    background: #fffdf5;
    color: #d4a800;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}
.ayuda_flujo_text { flex: 1; min-width: 0; }
.ayuda_flujo_text strong {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #1a1a1a;
}
.ayuda_flujo_text small {
    display: block;
    font-size: 11px;
    color: #6b7280;
    line-height: 1.35;
}
.ayuda_flujo_arrow {
    color: #d1d5db;
    font-size: 16px;
    padding: 0 4px;
    flex-shrink: 0;
}
.ayuda_flujo_caption {
    margin: 10px 0 0;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
@media (max-width: 768px) {
    .ayuda_flujo_paso { flex-basis: 100%; }
    .ayuda_flujo_arrow {
        transform: rotate(90deg);
        margin: 4px auto;
        display: block;
        width: 100%;
        text-align: center;
    }
}
</style>
