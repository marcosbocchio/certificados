<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Ejemplo: carga de responsables y horas de la jornada</div>
        <table class="ayuda_demo_table table table-striped">
            <thead>
                <tr>
                    <th>Operador</th>
                    <th>Función</th>
                    <th class="text-center">Inicio</th>
                    <th class="text-center">Fin</th>
                    <th class="text-center">Horas</th>
                    <th>Novedades</th>
                    <th class="text-center">—</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(r, i) in filas" :key="i">
                    <td><strong>{{ r.operador }}</strong></td>
                    <td>{{ r.funcion }}</td>
                    <td class="text-center">{{ r.inicio }}</td>
                    <td class="text-center">{{ r.fin }}</td>
                    <td class="text-center"><span class="ayuda_demo_chip">{{ r.horas }}h</span></td>
                    <td>
                        <span v-if="r.novedad" class="ayuda_demo_nov">{{ r.novedad }}</span>
                        <span v-else class="ayuda_demo_dash">—</span>
                    </td>
                    <td class="text-center">
                        <button class="ayuda_demo_iconbtn ayuda_demo_iconbtn--danger" title="Quitar"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
                <tr class="ayuda_total_row">
                    <td colspan="4"><strong>Total horas hombre</strong></td>
                    <td class="text-center"><strong>{{ totalHoras }}h</strong></td>
                    <td colspan="2"></td>
                </tr>
            </tbody>
        </table>
        <div class="ayuda_demo_actions_row">
            <button class="ayuda_btn_demo ayuda_btn_demo--secondary"><i class="fa fa-plus"></i> Agregar operador</button>
        </div>
        <div class="ayuda_demo_caption">
            Si un operador faltó parte del día, registralo en novedades — esto después aparece en el PDF del parte
            y se usa en certificados / reportes de horas hombre.
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-tabla-operarios-horas',
    data() {
        return {
            filas: [
                { operador: 'Juan Pérez',     funcion: 'Operador RI',      inicio: '07:30', fin: '16:00', horas: 8, novedad: '' },
                { operador: 'Marcos Aguirre', funcion: 'Asistente',         inicio: '07:30', fin: '12:00', horas: 4.5, novedad: 'Retiro por turno médico' },
                { operador: 'Lucía Mendoza',  funcion: 'Inspector cliente', inicio: '08:00', fin: '16:00', horas: 8, novedad: '' },
            ],
        };
    },
    computed: {
        totalHoras() {
            return this.filas.reduce((s, r) => s + r.horas, 0);
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
.ayuda_demo_table { min-width: 640px; }
.ayuda_demo_table th {
    background: #f8fafc; color: #4c5661;
    font-size: 13px; font-weight: 700;
}
.ayuda_demo_table td { font-size: 13px; vertical-align: middle; }
.ayuda_demo_chip {
    display: inline-block; padding: 2px 9px;
    border-radius: 999px; font-size: 11.5px; font-weight: 700;
    background: #eaf4fb; color: #1f4e7a;
}
.ayuda_demo_nov {
    display: inline-block; padding: 2px 8px;
    border-radius: 4px; font-size: 11.5px;
    background: #fff3cd; color: #8a6d3b;
}
.ayuda_demo_dash { color: #d6dce3; }
.ayuda_demo_iconbtn {
    background: transparent; border: 0;
    padding: 4px 6px; cursor: pointer;
    font-size: 13px; color: #4c5661;
}
.ayuda_demo_iconbtn--danger:hover { color: #dc3545; }
.ayuda_total_row td { background: #f9fafb; }
.ayuda_demo_actions_row { margin-top: 8px; }
.ayuda_btn_demo {
    padding: 6px 14px; border-radius: 6px;
    font-size: 12px; font-weight: 700;
    border: 0; cursor: pointer;
}
.ayuda_btn_demo--secondary { background: #e3e8ee; color: #4c5661; }
.ayuda_btn_demo i { margin-right: 5px; }
.ayuda_demo_caption {
    margin-top: 8px; font-size: 11px;
    color: #9ca3af; font-style: italic;
}
</style>
