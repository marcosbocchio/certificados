<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Ejemplo: listado de partes diarios de una OT</div>
        <table class="ayuda_demo_table table table-striped">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Fecha</th>
                    <th>Tipo de servicio</th>
                    <th>Usuario alta</th>
                    <th class="text-center">Informes</th>
                    <th class="text-center">Firma</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(p, i) in filas" :key="i">
                    <td><strong>{{ p.numero }}</strong></td>
                    <td>{{ p.fecha }}</td>
                    <td>{{ p.tipo }}</td>
                    <td>{{ p.usuario }}</td>
                    <td class="text-center"><span class="ayuda_demo_chip">{{ p.informes }}</span></td>
                    <td class="text-center">
                        <span class="ayuda_demo_badge" :class="badge(p.firma)">
                            <i :class="iconoFirma(p.firma)"></i> {{ p.firma }}
                        </span>
                    </td>
                    <td class="text-center">
                        <button class="ayuda_demo_iconbtn" title="Ver PDF"><i class="fa fa-file-pdf-o"></i></button>
                        <button class="ayuda_demo_iconbtn" :disabled="p.firma === 'Firmado'" title="Editar"><i class="fa fa-pencil"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="ayuda_demo_caption">
            La columna <strong>Firma</strong> resume el estado documental: una vez firmado, el parte queda inmutable y disponible para certificados.
            La columna <strong>Informes</strong> indica cuántos informes técnicos fueron consolidados en esa jornada.
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-tabla-partes',
    data() {
        return {
            filas: [
                { numero: 'P-0089', fecha: '25/06/2026', tipo: 'Radiografía industrial', usuario: 'Juan Pérez',    informes: 5, firma: 'Pendiente' },
                { numero: 'P-0088', fecha: '24/06/2026', tipo: 'Partículas magnéticas',  usuario: 'Lucía Mendoza', informes: 3, firma: 'Firmado' },
                { numero: 'P-0087', fecha: '20/06/2026', tipo: 'Radiografía industrial', usuario: 'Juan Pérez',    informes: 7, firma: 'Firmado' },
                { numero: 'P-0086', fecha: '18/06/2026', tipo: 'Ultrasonido',            usuario: 'Diego Salas',   informes: 2, firma: 'Firmado' },
                { numero: 'P-0085', fecha: '15/06/2026', tipo: 'Líquidos penetrantes',   usuario: 'Marcos Aguirre',informes: 4, firma: 'Anulado' },
            ],
        };
    },
    methods: {
        badge(f) {
            return {
                'Firmado':   'ayuda_demo_badge--success',
                'Pendiente': 'ayuda_demo_badge--warning',
                'Anulado':   'ayuda_demo_badge--danger',
            }[f];
        },
        iconoFirma(f) {
            return {
                'Firmado':   'fa fa-check-circle',
                'Pendiente': 'fa fa-clock-o',
                'Anulado':   'fa fa-ban',
            }[f];
        },
    },
};
</script>

<style scoped>
.ayuda_demo_block { margin: 12px 0 20px; overflow-x: auto; }
.ayuda_demo_label {
    font-size: 12px; color: #6b7280;
    text-transform: uppercase; letter-spacing: 0.06em;
    margin-bottom: 8px; font-weight: 600;
}
.ayuda_demo_table { min-width: 680px; }
.ayuda_demo_table th {
    background: #f8fafc; color: #4c5661;
    font-size: 13px; font-weight: 700;
}
.ayuda_demo_table td { font-size: 13px; vertical-align: middle; }
.ayuda_demo_chip {
    display: inline-block; min-width: 28px;
    padding: 2px 9px; border-radius: 999px;
    font-size: 12px; font-weight: 700;
    background: #eaf4fb; color: #1f4e7a;
}
.ayuda_demo_badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 3px 9px; border-radius: 999px;
    font-size: 11.5px; font-weight: 700;
}
.ayuda_demo_badge--success { background: #dff0d8; color: #2c7a2c; }
.ayuda_demo_badge--warning { background: #fff3cd; color: #8a6d3b; }
.ayuda_demo_badge--danger  { background: #f8d7da; color: #a94442; }
.ayuda_demo_iconbtn {
    background: transparent; border: 0;
    color: #4c5661; padding: 4px 6px;
    cursor: pointer; font-size: 14px;
}
.ayuda_demo_iconbtn:hover { color: #2e86c1; }
.ayuda_demo_iconbtn:disabled { color: #d6dce3; cursor: not-allowed; }
.ayuda_demo_caption {
    margin-top: 6px; font-size: 11px;
    color: #9ca3af; font-style: italic;
}
</style>
