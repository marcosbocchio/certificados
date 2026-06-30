<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Vista solo lectura</div>

        <div class="box box-custom-enod">
            <div class="box-header with-border"><h3 class="ayuda_vis_title">Vehículos asignados a la orden de trabajo</h3></div>
            <div class="box-body">
                <table class="table table-hover table-striped table-condensed ayuda_vis_table">
                    <thead><tr>
                        <th>N° INT.</th><th>Marca</th><th>Modelo</th><th>Patente</th><th>Tipo</th>
                    </tr></thead>
                    <tbody>
                        <tr v-for="v in vehiculos" :key="v.id">
                            <td>{{ v.nro }}</td>
                            <td>{{ v.marca }}</td>
                            <td>{{ v.modelo }}</td>
                            <td>{{ v.patente }}</td>
                            <td>{{ v.tipo }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box box-custom-enod">
            <div class="box-header with-border"><h3 class="ayuda_vis_title">Documentaciones del vehículo</h3></div>
            <div class="box-body">
                <table class="table table-hover table-striped table-condensed ayuda_vis_table">
                    <thead><tr>
                        <th>Título</th><th>Descripción</th><th class="text-center" style="width:60px;">Archivo</th>
                    </tr></thead>
                    <tbody>
                        <tr v-for="d in docVeh" :key="d.id">
                            <td>{{ d.titulo }}</td>
                            <td>{{ d.descripcion }}</td>
                            <td class="text-center"><i class="fa fa-file-image-o" style="color:#d4a800;"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box box-custom-enod">
            <div class="box-header with-border"><h3 class="ayuda_vis_title">Documentaciones asignadas a la orden de trabajo</h3></div>
            <div class="box-body">
                <table class="table table-hover table-striped table-condensed ayuda_vis_table">
                    <thead><tr>
                        <th>Título</th><th>Descripción</th><th class="text-center" style="width:60px;">Archivo</th>
                    </tr></thead>
                    <tbody>
                        <tr v-for="d in docExt" :key="d.id">
                            <td>{{ d.titulo }}</td>
                            <td>{{ d.descripcion }}</td>
                            <td class="text-center"><i class="fa fa-file-image-o" style="color:#d4a800;"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <p class="ayuda_demo_caption">
            Vista de <strong>consulta</strong>. Ves los vehículos asignados, la documentación de cada uno (VTV, seguro, etc.)
            y las documentaciones complementarias sumadas a la OT. Sin agregar ni quitar.
        </p>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-visualizar-vehiculos',
    data() {
        return {
            vehiculos: [
                { id: 1, nro: '001', marca: 'Toyota', modelo: 'Hilux 4x4 2022', patente: 'AB 234 CD', tipo: 'Camioneta' },
                { id: 3, nro: '003', marca: 'VW',     modelo: 'Amarok 2021',    patente: 'AE 102 NK', tipo: 'Camioneta' },
            ],
            docVeh: [
                { id: 1, titulo: 'VTV Hilux',   descripcion: 'Vigente hasta 10/11/2026' },
                { id: 2, titulo: 'Seguro',      descripcion: 'Póliza La Caja vence 15/12/2026' },
                { id: 3, titulo: 'VTV Amarok',  descripcion: 'Vence en 10 días' },
            ],
            docExt: [
                { id: 1, titulo: 'Plan de seguridad', descripcion: 'PDS de la obra Tramo 12' },
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
.box {
    border: 1px solid #eef0f3; border-top: 3px solid #FFCC00;
    border-radius: 4px; box-shadow: none; margin-bottom: 14px;
}
.box-body { padding: 0; }
.box-header { border-bottom: 1px solid #eef0f3; padding: 10px 14px; }
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
</style>
