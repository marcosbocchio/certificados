<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Métodos de ensayo habilitados según los servicios cargados en la OT</div>
        <div class="ayuda_metodos_grid">
            <div
                v-for="m in metodos"
                :key="m.codigo"
                class="ayuda_metodo_card"
                :class="{ 'is-disabled': !m.habilitado, 'is-active': seleccionado === m.codigo }"
                @click="m.habilitado && (seleccionado = m.codigo)"
                :title="m.habilitado ? 'Click para crear informe ' + m.codigo : 'Servicio ' + m.codigo + ' no cargado en la OT'"
            >
                <div class="ayuda_metodo_codigo">{{ m.codigo }}</div>
                <div class="ayuda_metodo_nombre">{{ m.nombre }}</div>
                <div class="ayuda_metodo_estado">
                    <i v-if="m.habilitado" class="fa fa-check-circle"></i>
                    <i v-else class="fa fa-lock"></i>
                </div>
            </div>
        </div>
        <div class="ayuda_demo_caption">
            <span class="label label-success">Habilitado</span> = el servicio fue cargado en la OT.
            <span class="label label-default">Bloqueado</span> = el método no aparece en la OT, primero hay que agregar el servicio correspondiente.
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-selector-metodo',
    data() {
        return {
            seleccionado: 'RI',
            metodos: [
                { codigo: 'RI',  nombre: 'Radiografía Industrial',     habilitado: true  },
                { codigo: 'PM',  nombre: 'Partículas Magnéticas',      habilitado: true  },
                { codigo: 'LP',  nombre: 'Líquidos Penetrantes',       habilitado: true  },
                { codigo: 'US',  nombre: 'Ultrasonido',                habilitado: true  },
                { codigo: 'RD',  nombre: 'Radiografía Digital',        habilitado: true  },
                { codigo: 'TT',  nombre: 'Tratamiento Térmico',        habilitado: false },
                { codigo: 'CV',  nombre: 'Inspección Visual',          habilitado: true  },
                { codigo: 'DZ',  nombre: 'Dureza',                     habilitado: false },
                { codigo: 'RG',  nombre: 'Réplica Metalográfica',      habilitado: false },
                { codigo: 'PMI', nombre: 'Identif. Positiva Material', habilitado: false },
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
.ayuda_metodos_grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    gap: 8px;
}
.ayuda_metodo_card {
    background: #fff;
    border: 1px solid #eef0f3;
    border-radius: 4px;
    padding: 14px 12px 12px;
    cursor: pointer;
    transition: all 0.12s ease;
    position: relative;
    text-align: center;
}
.ayuda_metodo_card:not(.is-disabled):hover {
    border-color: #FFCC00;
    transform: translateY(-1px);
}
.ayuda_metodo_card.is-active {
    background: #fffdf5;
    border-color: #FFCC00;
    border-top: 3px solid #FFCC00;
    padding-top: 12px;
}
.ayuda_metodo_card.is-disabled {
    background: #fafbfc;
    cursor: not-allowed;
    opacity: 0.55;
}
.ayuda_metodo_codigo {
    font-size: 22px;
    font-weight: 700;
    color: #1a1a1a;
    letter-spacing: -0.02em;
    line-height: 1;
    margin-bottom: 4px;
}
.ayuda_metodo_card.is-disabled .ayuda_metodo_codigo { color: #9ca3af; }
.ayuda_metodo_nombre {
    font-size: 11px;
    color: #6b7280;
    line-height: 1.3;
    min-height: 28px;
}
.ayuda_metodo_estado {
    position: absolute;
    top: 6px; right: 8px;
    font-size: 12px;
}
.ayuda_metodo_card:not(.is-disabled) .ayuda_metodo_estado { color: #1b6b34; }
.ayuda_metodo_card.is-disabled .ayuda_metodo_estado { color: #9ca3af; }
.ayuda_demo_caption {
    margin-top: 10px;
    font-size: 12px;
    color: #6b7280;
}
.ayuda_demo_caption .label { font-size: 10px; padding: 2px 7px; margin-right: 2px; }
</style>
