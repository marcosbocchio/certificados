<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Ejemplo: tabla de defectos por soldador (click en una fila para ver el detalle)</div>
        <table class="ayuda_demo_table table table-striped table-hover">
            <thead>
                <tr>
                    <th>Cuño</th>
                    <th class="text-center">Cord.</th>
                    <th class="text-center">Cant.</th>
                    <th>Porcentaje</th>
                    <th class="text-center">Placas Total</th>
                    <th class="text-center">Placas Rech.</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(s, i) in soldadores"
                    :key="i"
                    @click="seleccionado = i"
                    class="ayuda_demo_clickable"
                    :class="{ 'ayuda_demo_selected': seleccionado === i }"
                >
                    <td><strong>{{ s.codigo }}</strong> - {{ s.nombre }}</td>
                    <td class="text-center">{{ s.cordones }}</td>
                    <td class="text-center">{{ s.cantidad }}</td>
                    <td>
                        <div class="ayuda_demo_progress">
                            <div class="ayuda_demo_progress_bar" :style="{ width: s.porcentaje + '%', background: s.color }"></div>
                        </div>
                        <span class="ayuda_demo_badge_pct" :style="{ background: s.color }">{{ s.porcentaje }}%</span>
                    </td>
                    <td class="text-center">{{ s.placas_total }}</td>
                    <td class="text-center">{{ s.placas_rech }}</td>
                </tr>
            </tbody>
        </table>
        <div v-if="soldadorSeleccionado" class="ayuda_demo_detalle">
            <strong>Detalle de {{ soldadorSeleccionado.codigo }} - {{ soldadorSeleccionado.nombre }}:</strong>
            tipo de defecto más frecuente: <em>{{ soldadorSeleccionado.defecto_top }}</em>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-tabla-soldadores',
    data() {
        return {
            seleccionado: 0,
            soldadores: [
                { codigo: 'W-12', nombre: 'Wilson Pérez',     cordones: 48, cantidad: 7, porcentaje: 14.6, placas_total: 96, placas_rech: 9, color: '#d9534f', defecto_top: 'Falta de fusión (FF)' },
                { codigo: 'S-08', nombre: 'Sergio Quinteros', cordones: 62, cantidad: 5, porcentaje: 8.1,  placas_total: 124, placas_rech: 6, color: '#f0ad4e', defecto_top: 'Porosidad (P)' },
                { codigo: 'J-15', nombre: 'Juan Acosta',      cordones: 71, cantidad: 4, porcentaje: 5.6,  placas_total: 142, placas_rech: 5, color: '#5bc0de', defecto_top: 'Inclusión (I)' },
                { codigo: 'M-03', nombre: 'Mario Lopez',      cordones: 35, cantidad: 2, porcentaje: 5.7,  placas_total: 70,  placas_rech: 3, color: '#5bc0de', defecto_top: 'Falta de fusión (FF)' },
                { codigo: 'C-21', nombre: 'Carlos Rodríguez', cordones: 89, cantidad: 3, porcentaje: 3.4,  placas_total: 178, placas_rech: 4, color: '#5cb85c', defecto_top: 'Porosidad (P)' },
            ],
        };
    },
    computed: {
        soldadorSeleccionado() {
            return this.soldadores[this.seleccionado] || null;
        },
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
    margin-bottom: 8px;
    font-weight: 600;
}
.ayuda_demo_table th {
    background: #f8fafc;
    color: #4c5661;
    font-size: 13px;
    font-weight: 700;
}
.ayuda_demo_table td {
    font-size: 13px;
    vertical-align: middle;
}
.ayuda_demo_clickable {
    cursor: pointer;
    transition: background 0.15s;
}
.ayuda_demo_selected {
    background: #fff7dd !important;
    border-left: 3px solid #d99000;
}
.ayuda_demo_progress {
    background: #eef3f8;
    border-radius: 999px;
    height: 8px;
    width: 100%;
    overflow: hidden;
    margin-bottom: 4px;
}
.ayuda_demo_progress_bar {
    height: 100%;
    transition: width 0.3s;
}
.ayuda_demo_badge_pct {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 999px;
    font-size: 11px;
    color: #fff;
    font-weight: 700;
}
.ayuda_demo_detalle {
    margin-top: 10px;
    padding: 10px 14px;
    background: #fff7dd;
    border-left: 3px solid #d99000;
    border-radius: 6px;
    font-size: 13px;
}

/* Scroll horizontal en mobile */
.ayuda_demo_block {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}
.ayuda_demo_table {
    min-width: 560px;
}

@media (max-width: 600px) {
    .ayuda_demo_table th,
    .ayuda_demo_table td {
        font-size: 12px;
        padding: 6px 4px;
    }
    .ayuda_demo_badge_pct {
        font-size: 10px;
        padding: 1px 6px;
    }
    .ayuda_demo_detalle {
        font-size: 12px;
        padding: 8px 10px;
    }
}
</style>
