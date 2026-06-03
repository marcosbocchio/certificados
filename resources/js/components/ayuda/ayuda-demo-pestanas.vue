<template>
    <div class="ayuda_demo_pestanas">
        <div class="ayuda_demo_pestanas_header">
            <h3>Vista previa interactiva del reporte</h3>
            <p class="ayuda_demo_pestanas_hint">
                Esta es una versión de muestra con datos de ejemplo. Hace clic en cada pestaña para ver cómo está organizada
                la información en el reporte real.
            </p>
        </div>

        <div class="ayuda_demo_layout">
            <!-- Columna izquierda: filtros (réplica del reporte real) -->
            <aside class="ayuda_demo_sidebar">
                <div class="ayuda_demo_sidebar_label">
                    <span class="ayuda_demo_sidebar_label_main">REPORTE</span>
                    <span class="ayuda_demo_sidebar_label_sub">Análisis de rechazo y defectología</span>
                </div>
                <div class="ayuda_demo_sidebar_field">
                    <label>Cliente</label>
                    <span class="ayuda_demo_sidebar_value">Cliente Demo SA</span>
                </div>
                <div class="ayuda_demo_sidebar_field">
                    <label>OT</label>
                    <span class="ayuda_demo_sidebar_value">OT-2026-001</span>
                </div>
                <div class="ayuda_demo_sidebar_field">
                    <label>Obra</label>
                    <span class="ayuda_demo_sidebar_value">Gasoducto Norte</span>
                </div>
                <div class="ayuda_demo_sidebar_field">
                    <label>Componente</label>
                    <span class="ayuda_demo_sidebar_value">Cañería principal</span>
                </div>
                <div class="ayuda_demo_sidebar_input">
                    <input type="text" value="125" disabled placeholder="PK" />
                </div>
                <div class="ayuda_demo_sidebar_dates">
                    <div>
                        <label>Desde</label>
                        <span>01/05/2026</span>
                    </div>
                    <div>
                        <label>Hasta</label>
                        <span>31/05/2026</span>
                    </div>
                </div>
                <button class="ayuda_demo_sidebar_btn" disabled>
                    <i class="fa fa-search"></i> Buscar
                </button>
            </aside>

            <!-- Columna derecha: pestañas con contenido -->
            <div class="ayuda_demo_content">
                <tabs :options="{ useUrlFragment: false }" @changed="onTabChanged">
            <tab name="Índices de rechazos" id="demo-indices">
                <div class="ayuda_demo_tab_content">
                    <p class="ayuda_demo_tab_intro">
                        Muestra cuántas soldaduras se aprobaron o rechazaron, agrupadas por diámetro y espesor.
                    </p>
                    <ayuda-demo-tabla-rechazos></ayuda-demo-tabla-rechazos>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <ayuda-demo-grafico-pie></ayuda-demo-grafico-pie>
                        </div>
                    </div>
                </div>
            </tab>

            <tab name="Defectología" id="demo-defectologia">
                <div class="ayuda_demo_tab_content">
                    <p class="ayuda_demo_tab_intro">
                        Lista los tipos de defecto encontrados y muestra dónde se ubican en la soldadura.
                    </p>
                    <table class="ayuda_demo_table table table-striped">
                        <thead>
                            <tr>
                                <th>Abreviatura</th>
                                <th>Descripción</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-center">Porcentaje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(d, i) in defectos" :key="i">
                                <td><strong>{{ d.codigo }}</strong></td>
                                <td>{{ d.descripcion }}</td>
                                <td class="text-center">{{ d.cantidad }}</td>
                                <td class="text-center">{{ d.porcentaje }}%</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <ayuda-demo-grafico-doughnut></ayuda-demo-grafico-doughnut>
                        </div>
                    </div>
                </div>
            </tab>

            <tab name="Defectología / Producción" id="demo-produccion">
                <div class="ayuda_demo_tab_content">
                    <p class="ayuda_demo_tab_intro">
                        Muestra los defectos atribuidos a cada soldador. Hace clic en una fila para destacarla.
                    </p>
                    <ayuda-demo-tabla-soldadores></ayuda-demo-tabla-soldadores>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <ayuda-demo-grafico-barras></ayuda-demo-grafico-barras>
                        </div>
                    </div>
                </div>
            </tab>

            <tab name="Indicaciones" id="demo-indicaciones">
                <div class="ayuda_demo_tab_content">
                    <p class="ayuda_demo_tab_intro">
                        Lista las indicaciones (observaciones sin posición exacta) detectadas en los informes.
                    </p>
                    <table class="ayuda_demo_table table table-striped">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Descripción</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-center">Porcentaje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(d, i) in indicaciones" :key="i">
                                <td><strong>{{ d.codigo }}</strong></td>
                                <td>{{ d.descripcion }}</td>
                                <td class="text-center">{{ d.cantidad }}</td>
                                <td class="text-center">{{ d.porcentaje }}%</td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="ayuda_demo_tab_hint">
                        En el reporte real, hace clic sobre una porción del gráfico para ver el detalle por posición.
                    </p>
                </div>
            </tab>
                </tabs>
            </div>
        </div>
    </div>
</template>

<script>
import Tabs from 'vue-tabs-component';
import 'vue-tabs-component/docs/resources/tabs-component.css';
import AyudaDemoTablaRechazos from './ayuda-demo-tabla-rechazos.vue';
import AyudaDemoTablaSoldadores from './ayuda-demo-tabla-soldadores.vue';
import AyudaDemoGraficoPie from './ayuda-demo-grafico-pie.vue';
import AyudaDemoGraficoDoughnut from './ayuda-demo-grafico-doughnut.vue';
import AyudaDemoGraficoBarras from './ayuda-demo-grafico-barras.vue';

Vue.use(Tabs);

export default {
    name: 'ayuda-demo-pestanas',
    components: {
        'ayuda-demo-tabla-rechazos': AyudaDemoTablaRechazos,
        'ayuda-demo-tabla-soldadores': AyudaDemoTablaSoldadores,
        'ayuda-demo-grafico-pie': AyudaDemoGraficoPie,
        'ayuda-demo-grafico-doughnut': AyudaDemoGraficoDoughnut,
        'ayuda-demo-grafico-barras': AyudaDemoGraficoBarras,
    },
    methods: {
        onTabChanged() {
            // Los charts dentro de tabs ocultas se renderizan con tamaño 0.
            // Al cambiar de tab, disparamos un resize para que se redibujen al tamaño correcto.
            this.$nextTick(() => {
                setTimeout(() => {
                    window.dispatchEvent(new Event('resize'));
                }, 50);
            });
        },
    },
    mounted() {
        // Trigger inicial al montar — el primer tab también necesita el resize para dibujarse OK
        this.$nextTick(() => {
            setTimeout(() => {
                window.dispatchEvent(new Event('resize'));
            }, 100);
        });
    },
    data() {
        return {
            defectos: [
                { codigo: 'FF', descripcion: 'Falta de fusión',  cantidad: 12, porcentaje: 50.0 },
                { codigo: 'P',  descripcion: 'Porosidad',         cantidad: 6,  porcentaje: 25.0 },
                { codigo: 'I',  descripcion: 'Inclusión',         cantidad: 3,  porcentaje: 12.5 },
                { codigo: 'F',  descripcion: 'Fisura',            cantidad: 2,  porcentaje: 8.3 },
                { codigo: 'NP', descripcion: 'Nido de poros',     cantidad: 1,  porcentaje: 4.2 },
            ],
            indicaciones: [
                { codigo: 'NP', descripcion: 'Nido de poros',          cantidad: 8, porcentaje: 53.3 },
                { codigo: 'I',  descripcion: 'Inclusión',              cantidad: 4, porcentaje: 26.7 },
                { codigo: 'M',  descripcion: 'Marca de identificación', cantidad: 3, porcentaje: 20.0 },
            ],
        };
    },
};
</script>

<style scoped>
.ayuda_demo_pestanas {
    background: #fff;
    border: 1px solid #e6eaf0;
    border-radius: 14px;
    padding: 20px 22px;
    margin: 16px 0;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
}
.ayuda_demo_pestanas_header h3 {
    color: #d99000;
    font-size: 18px;
    margin-top: 0;
    margin-bottom: 6px;
    font-weight: 700;
}
.ayuda_demo_pestanas_hint {
    font-size: 13px;
    color: #6b7280;
    margin-bottom: 16px;
}

/* Layout 2 columnas (réplica del reporte real) */
.ayuda_demo_layout {
    display: grid;
    grid-template-columns: 240px 1fr;
    gap: 18px;
    align-items: start;
}
@media (max-width: 768px) {
    .ayuda_demo_layout {
        grid-template-columns: 1fr;
    }
}

/* Sidebar de filtros */
.ayuda_demo_sidebar {
    background: #fff;
    border: 1px solid #e6eaf0;
    border-top: 3px solid #d99000;
    border-radius: 6px;
    padding: 14px;
    font-size: 13px;
}
.ayuda_demo_sidebar_label {
    margin-bottom: 14px;
}
.ayuda_demo_sidebar_label_main {
    font-size: 10px;
    color: #6b7280;
    letter-spacing: 0.08em;
    font-weight: 700;
    text-transform: uppercase;
    display: block;
    margin-bottom: 2px;
}
.ayuda_demo_sidebar_label_sub {
    font-size: 11px;
    color: #6b7280;
}
.ayuda_demo_sidebar_field {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #edf1f5;
}
.ayuda_demo_sidebar_field label {
    color: #4c5661;
    font-weight: 700;
    font-size: 12px;
    margin: 0;
}
.ayuda_demo_sidebar_value {
    color: #6b7280;
    font-size: 11px;
    text-align: right;
}
.ayuda_demo_sidebar_input {
    padding: 10px 0 6px;
    border-bottom: 1px solid #edf1f5;
}
.ayuda_demo_sidebar_input input {
    width: 100%;
    border: 1px solid #d4d4d8;
    border-radius: 4px;
    padding: 5px 8px;
    font-size: 12px;
    background: #fafbfd;
    cursor: not-allowed;
}
.ayuda_demo_sidebar_dates {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
    padding: 10px 0;
}
.ayuda_demo_sidebar_dates label {
    font-size: 11px;
    color: #6b7280;
    margin: 0;
    display: block;
}
.ayuda_demo_sidebar_dates span {
    font-size: 11px;
    color: #4c5661;
    border-bottom: 1px solid #d4d4d8;
    display: block;
    padding-bottom: 2px;
}
.ayuda_demo_sidebar_btn {
    width: 100%;
    margin-top: 10px;
    padding: 8px 12px;
    background: #f0ad4e;
    color: #fff;
    border: 1px solid #eea236;
    border-radius: 4px;
    font-size: 13px;
    font-weight: 700;
    cursor: not-allowed;
}
.ayuda_demo_sidebar_btn i {
    margin-right: 4px;
}

/* Contenido derecha */
.ayuda_demo_content {
    min-width: 0; /* permite que charts hagan resize bien dentro de grid */
}
.ayuda_demo_tab_content {
    padding: 18px 4px;
}
.ayuda_demo_tab_intro {
    font-size: 14px;
    color: #4c5661;
    margin-bottom: 12px;
}
.ayuda_demo_tab_hint {
    margin-top: 12px;
    padding: 10px 14px;
    background: #f7f9fc;
    border-left: 3px solid #d99000;
    border-radius: 6px;
    font-size: 13px;
    color: #4c5661;
}
.ayuda_demo_table th {
    background: #f8fafc;
    color: #4c5661;
    font-size: 13px;
    font-weight: 700;
}
.ayuda_demo_table td {
    font-size: 13px;
}
</style>
