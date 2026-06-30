<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Tablero principal de una OT</div>
        <p class="ayuda_demo_intro">
            Al entrar a una Orden de Trabajo, ves estas 8 secciones. Cada una es una "card" clicable que abre la pantalla correspondiente.
            El número arriba a la derecha indica cuántos elementos hay cargados de ese tipo.
        </p>

        <div class="ayuda_tab_grid">
            <div v-for="c in cards" :key="c.titulo" class="ayuda_tab_card" :class="c.fondo">
                <div class="ayuda_tab_n">{{ c.cant }}</div>
                <div class="ayuda_tab_icon"><i :class="'fa fa-' + c.icono"></i></div>
                <div class="ayuda_tab_titulo">
                    {{ c.titulo }}<span v-if="c.titulo2"> | <em>{{ c.titulo2 }}</em></span>
                </div>
            </div>
        </div>

        <div class="ayuda_tab_footer">
            <button class="btn btn-enod"><i class="fa fa-plus"></i>&nbsp; Nueva OT</button>
            <div class="ayuda_tab_search">
                <input type="text" class="form-control" placeholder="Buscar..." />
                <button class="btn btn-enod"><i class="fa fa-search"></i></button>
            </div>
        </div>

        <p class="ayuda_demo_caption">
            <strong>+ Nueva OT</strong> abre el formulario en blanco. El buscador filtra entre las OT que tu usuario puede ver.
        </p>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-tablero-ot',
    data() {
        return {
            cards: [
                { titulo: 'OPERADORES',     cant: 3, icono: 'users',         fondo: 'fondo-gris' },
                { titulo: 'EQUIPOS',         cant: 2, icono: 'cogs',          fondo: 'fondo-negro' },
                { titulo: 'PROCEDIMIENTOS', cant: 1, icono: 'shield',        fondo: 'fondo-amarillo' },
                { titulo: 'VEHÍCULOS',       cant: 1, titulo2: '0',           icono: 'truck',          fondo: 'fondo-gris-claro' },
                { titulo: 'CUÑOS',           cant: 4, titulo2: '0', icono: 'fire',           fondo: 'fondo-gris-claro' },
                { titulo: 'INFORMES',        cant: 5, icono: 'file-text',     fondo: 'fondo-gris' },
                { titulo: 'PARTES',          cant: 2, icono: 'calendar-check-o', fondo: 'fondo-negro' },
                { titulo: 'CERTIFICADOS',    cant: 1, icono: 'certificate',   fondo: 'fondo-amarillo' },
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
.ayuda_demo_intro { font-size: 13px; color: #4c5661; margin-bottom: 12px; }

.ayuda_tab_grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
    gap: 10px;
}

.ayuda_tab_card {
    position: relative;
    height: 120px;
    border-radius: 4px;
    padding: 12px 14px 14px;
    color: #fff;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    overflow: hidden;
}
.ayuda_tab_card.fondo-gris        { background: #6b6b6b; }
.ayuda_tab_card.fondo-gris-claro  { background: #9b9b9b; }
.ayuda_tab_card.fondo-negro       { background: #1a1a1a; }
.ayuda_tab_card.fondo-amarillo    { background: #FFCC00; color: #1a1a1a; }

.ayuda_tab_n {
    position: absolute;
    top: 8px; right: 14px;
    font-size: 20px;
    font-weight: 700;
}
.ayuda_tab_icon {
    font-size: 38px;
    text-align: center;
    margin-top: 8px;
    opacity: 0.85;
}
.ayuda_tab_card.fondo-amarillo .ayuda_tab_icon { color: #fff; opacity: 0.95; }
.ayuda_tab_titulo {
    margin-top: auto;
    background: #1a1a1a;
    color: #fff;
    padding: 5px 10px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.04em;
    border-radius: 0 0 4px 4px;
    margin: 0 -14px -14px;
}
.ayuda_tab_card.fondo-amarillo .ayuda_tab_titulo { color: #FFCC00; }
.ayuda_tab_titulo em { color: #FFCC00; font-style: normal; }

.ayuda_tab_footer {
    margin-top: 18px;
    display: flex; justify-content: space-between; align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}
.ayuda_tab_footer .btn-enod { padding: 7px 16px; font-weight: 700; }
.ayuda_tab_search {
    display: flex; gap: 0;
    width: 280px; max-width: 100%;
}
.ayuda_tab_search input.form-control { border-radius: 4px 0 0 4px; height: 34px; }
.ayuda_tab_search .btn { border-radius: 0 4px 4px 0; padding: 0 14px; }

.ayuda_demo_caption {
    margin: 10px 0 0; font-size: 12px; color: #6b7280; font-style: italic;
}
</style>
