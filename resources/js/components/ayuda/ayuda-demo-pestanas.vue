<template>
    <div class="ayuda_demo_pestanas">
        <div class="ayuda_demo_pestanas_header">
            <h3>Vista previa interactiva del reporte</h3>
            <p class="ayuda_demo_pestanas_hint">
                Esta es una versión de muestra con datos de ejemplo. Hace clic en cada pestaña para ver cómo está organizada
                la información en el reporte real.
            </p>
        </div>

        <tabs :options="{ useUrlFragment: false }">
            <tab name="Índices de rechazos">
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

            <tab name="Defectología">
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

            <tab name="Defectología / Producción">
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

            <tab name="Indicaciones">
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
