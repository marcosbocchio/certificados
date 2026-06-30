<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Vista solo lectura</div>

        <div class="ayuda_vis_grid">
            <div class="box box-custom-enod">
                <div class="box-header with-border"><h3 class="ayuda_vis_title">Operadores asignados a la orden de trabajo</h3></div>
                <div class="box-body">
                    <table class="table table-hover table-striped table-condensed ayuda_vis_table">
                        <thead><tr><th>Nombre</th></tr></thead>
                        <tbody>
                            <tr v-for="o in operadores" :key="o.id"><td>{{ o.nombre }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="box box-custom-enod">
                <div class="box-header with-border"><h3 class="ayuda_vis_title">Ayudantes asignados a la orden de trabajo</h3></div>
                <div class="box-body">
                    <table class="table table-hover table-striped table-condensed ayuda_vis_table">
                        <thead><tr><th>Nombre</th></tr></thead>
                        <tbody>
                            <tr v-for="a in ayudantes" :key="a.id"><td>{{ a.nombre }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="box box-custom-enod ayuda_vis_full">
            <div class="box-header with-border"><h3 class="ayuda_vis_title">Documentación</h3></div>
            <div class="box-body">
                <table class="table table-hover table-striped table-condensed ayuda_vis_table">
                    <thead>
                        <tr><th>Título</th><th>Descripción</th><th class="text-center" style="width:60px;">PDF</th></tr>
                    </thead>
                    <tbody>
                        <tr v-for="d in docs" :key="d.id">
                            <td>{{ d.titulo }}</td>
                            <td>{{ d.descripcion }}</td>
                            <td class="text-center"><i class="fa fa-file-pdf-o" style="color:#d4a800;"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <p class="ayuda_demo_caption">
            Esta pantalla es de <strong>solo consulta</strong>. Ves quiénes están asignados y descargás la documentación de cada uno.
            No hay botones de agregar ni quitar.
        </p>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-visualizar-operadores',
    data() {
        return {
            operadores: [
                { id: 1, nombre: 'SALDAMANDO EMMANUEL' },
                { id: 2, nombre: 'QUISPE MIGUEL' },
                { id: 3, nombre: 'IFRAN JOAQUIN' },
            ],
            ayudantes: [
                { id: 4, nombre: 'GOMEZ ANA' },
            ],
            docs: [
                { id: 1, titulo: 'Nivel II RI - SALDAMANDO',  descripcion: 'Certificación vigente hasta 08/2027' },
                { id: 2, titulo: 'ART - QUISPE',                descripcion: 'Vigente hasta 12/2026' },
                { id: 3, titulo: 'Capacitación PM - IFRAN',     descripcion: 'Curso interno 2026' },
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
.ayuda_vis_grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    margin-bottom: 14px;
}
.ayuda_vis_grid .box,
.ayuda_vis_full {
    border: 1px solid #eef0f3; border-top: 3px solid #FFCC00;
    border-radius: 4px; box-shadow: none; margin-bottom: 0;
}
.ayuda_vis_grid .box-body,
.ayuda_vis_full .box-body { padding: 0; }
.ayuda_vis_grid .box-header,
.ayuda_vis_full .box-header { border-bottom: 1px solid #eef0f3; padding: 10px 14px; }
.ayuda_vis_title { margin: 0; font-size: 13.5px; font-weight: 600; color: #d4a800; }

.ayuda_vis_table { margin: 0; }
.ayuda_vis_table thead th {
    border-bottom: 2px solid #FFCC00; background: #fafbfc;
    color: #1a1a1a; font-size: 13px; font-weight: 700; padding: 6px 10px;
}
.ayuda_vis_table tbody td { padding: 8px 10px; font-size: 13px; vertical-align: middle; }

.ayuda_demo_caption {
    margin: 10px 0 0; font-size: 12px; color: #6b7280; font-style: italic;
}

@media (max-width: 760px) { .ayuda_vis_grid { grid-template-columns: 1fr; } }
</style>
