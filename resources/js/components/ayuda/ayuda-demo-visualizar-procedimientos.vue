<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Vista solo lectura</div>

        <div class="box box-custom-enod">
            <div class="box-header with-border"><h3 class="ayuda_vis_title">Procedimientos Enod</h3></div>
            <div class="box-body">
                <table class="table table-hover table-striped table-condensed ayuda_vis_table">
                    <thead><tr>
                        <th>Tipo</th><th>Título</th><th>Descripción</th><th>Método</th><th class="text-center" style="width:60px;">PDF</th>
                    </tr></thead>
                    <tbody>
                        <tr v-for="p in procEnod" :key="p.id">
                            <td>{{ p.tipo }}</td>
                            <td>{{ p.titulo }}</td>
                            <td>{{ p.descripcion }}</td>
                            <td>{{ p.metodo }}</td>
                            <td class="text-center"><i class="fa fa-file-pdf-o" style="color:#d4a800;"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box box-custom-enod ayuda_vis_full">
            <div class="box-header with-border"><h3 class="ayuda_vis_title">Procedimientos clientes</h3></div>
            <div class="box-body">
                <table class="table table-hover table-striped table-condensed ayuda_vis_table">
                    <thead><tr>
                        <th>Tipo Sol.</th><th>Obra N°</th><th>EPS / WPS</th><th>PQR</th><th>Proc. Reparación</th>
                    </tr></thead>
                    <tbody>
                        <tr v-for="p in procCliente" :key="p.id">
                            <td>{{ p.tipoSol }}</td>
                            <td>{{ p.obra }}</td>
                            <td>{{ p.eps }}</td>
                            <td>{{ p.pqr }}</td>
                            <td>{{ p.rep }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <p class="ayuda_demo_caption">
            Vista de <strong>consulta</strong>. No hay botón "Nuevo", ni formulario para agregar.
            Solo ves los procedimientos cargados y descargás el PDF de los Enod desde el ícono.
        </p>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-visualizar-procedimientos',
    data() {
        return {
            procEnod: [
                { id: 1, tipo: 'Procedimiento', titulo: 'PR-RI-007', descripcion: 'Radiografía industrial DDSE', metodo: 'RI' },
                { id: 2, tipo: 'Procedimiento', titulo: 'PR-PM-002', descripcion: 'Partículas magnéticas',         metodo: 'PM' },
                { id: 3, tipo: 'Procedimiento', titulo: 'PR-LP-004', descripcion: 'Líquidos penetrantes',           metodo: 'LP' },
            ],
            procCliente: [
                { id: 1, tipoSol: 'LR', obra: '777', eps: 'EPS-API-1104', pqr: 'PQR-001/24', rep: 'PR-REP-007' },
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
