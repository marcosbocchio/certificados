<template>
    <div class="ayuda_indice">
        <div class="ayuda_indice_hero">
            <div class="ayuda_indice_hero_icon"><i class="fa fa-life-ring"></i></div>
            <div>
                <h1>Centro de ayuda</h1>
                <p>
                    Punto de entrada a la documentación del sistema. Cada tarjeta agrupa los temas
                    de un módulo: usá el buscador o filtrá por categoría para llegar directo al artículo que necesitás.
                </p>
            </div>
        </div>

        <div class="ayuda_indice_toolbar">
            <div class="ayuda_indice_search">
                <i class="fa fa-search"></i>
                <input
                    type="text"
                    v-model="busqueda"
                    placeholder="Buscar tema, módulo o palabra clave..."
                    @keydown.esc="busqueda = ''"
                />
                <button v-if="busqueda" class="ayuda_indice_search_clear" @click="busqueda = ''" title="Limpiar">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="ayuda_indice_filtros">
                <button
                    v-for="cat in categorias"
                    :key="cat.id"
                    class="ayuda_indice_chip"
                    :class="{ 'is-active': categoria === cat.id }"
                    @click="categoria = cat.id"
                >
                    <i :class="'fa fa-' + cat.icono"></i> {{ cat.label }}
                </button>
            </div>
        </div>

        <p v-if="totalResultados === 0" class="ayuda_indice_vacio">
            <i class="fa fa-info-circle"></i> No se encontraron artículos para "<strong>{{ busqueda }}</strong>".
        </p>

        <div class="ayuda_indice_grid">
            <article
                v-for="(seccion, idx) in seccionesVisibles"
                :key="idx"
                class="ayuda_indice_card"
                :class="'ayuda_indice_card--' + seccion.color"
            >
                <header class="ayuda_indice_card_head">
                    <div class="ayuda_indice_card_icon"><i :class="'fa fa-' + seccion.icono"></i></div>
                    <div>
                        <h2>{{ seccion.titulo }}</h2>
                        <p>{{ seccion.descripcion }}</p>
                    </div>
                </header>
                <ul class="ayuda_indice_links">
                    <li v-for="(link, j) in seccion.linksVisibles" :key="j">
                        <a :href="link.href">
                            <span class="ayuda_indice_link_titulo" v-html="resaltar(link.label)"></span>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </article>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-indice',
    props: {
        secciones: { type: Array, required: true },
    },
    data() {
        return {
            busqueda: '',
            categoria: 'todas',
            categorias: [
                { id: 'todas',    label: 'Todas',       icono: 'th-large' },
                { id: 'inicio',   label: 'Inicio',      icono: 'play-circle' },
                { id: 'operativo',label: 'Operativo',   icono: 'cogs' },
                { id: 'documental',label: 'Documental', icono: 'file-text' },
                { id: 'maestros', label: 'Maestros',    icono: 'database' },
                { id: 'interno',  label: 'Interno',     icono: 'briefcase' },
                { id: 'dosimetria',label: 'Dosimetría', icono: 'bolt' },
                { id: 'extras',   label: 'Multimedia',  icono: 'image' },
            ],
        };
    },
    computed: {
        seccionesVisibles() {
            const q = this.busqueda.trim().toLowerCase();
            return this.secciones
                .filter(s => this.categoria === 'todas' || s.categoria === this.categoria)
                .map(s => {
                    const links = q
                        ? s.links.filter(l => l.label.toLowerCase().includes(q))
                        : s.links;
                    return { ...s, linksVisibles: links };
                })
                .filter(s => s.linksVisibles.length > 0);
        },
        totalResultados() {
            return this.seccionesVisibles.reduce((n, s) => n + s.linksVisibles.length, 0);
        },
    },
    methods: {
        resaltar(texto) {
            const q = this.busqueda.trim();
            if (!q) return this.escapar(texto);
            const re = new RegExp('(' + q.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'ig');
            return this.escapar(texto).replace(re, '<mark>$1</mark>');
        },
        escapar(s) {
            const d = document.createElement('div');
            d.textContent = s;
            return d.innerHTML;
        },
    },
};
</script>

<style scoped>
.ayuda_indice {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 12px;
}

.ayuda_indice_hero {
    display: flex;
    gap: 18px;
    align-items: flex-start;
    background: linear-gradient(135deg, #1f4e7a 0%, #2e86c1 100%);
    color: #fff;
    padding: 26px 28px;
    border-radius: 14px;
    box-shadow: 0 6px 24px rgba(31, 78, 122, 0.18);
    margin-bottom: 24px;
}
.ayuda_indice_hero_icon {
    font-size: 38px;
    background: rgba(255, 255, 255, 0.15);
    width: 64px; height: 64px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.ayuda_indice_hero h1 {
    margin: 0 0 6px;
    font-size: 24px;
    font-weight: 700;
}
.ayuda_indice_hero p {
    margin: 0;
    font-size: 14px;
    opacity: 0.92;
    line-height: 1.5;
}

.ayuda_indice_toolbar {
    background: #fff;
    border: 1px solid #e3e8ee;
    border-radius: 12px;
    padding: 14px 16px;
    margin-bottom: 22px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.03);
}
.ayuda_indice_search {
    position: relative;
    margin-bottom: 12px;
}
.ayuda_indice_search i.fa-search {
    position: absolute;
    top: 50%; left: 14px;
    transform: translateY(-50%);
    color: #9ca3af;
}
.ayuda_indice_search input {
    width: 100%;
    padding: 10px 38px 10px 38px;
    border: 1px solid #d6dce3;
    border-radius: 8px;
    font-size: 14px;
    background: #f9fafb;
    transition: all 0.15s ease;
}
.ayuda_indice_search input:focus {
    outline: none;
    background: #fff;
    border-color: #2e86c1;
    box-shadow: 0 0 0 3px rgba(46, 134, 193, 0.12);
}
.ayuda_indice_search_clear {
    position: absolute;
    top: 50%; right: 8px;
    transform: translateY(-50%);
    background: transparent;
    border: 0;
    color: #6b7280;
    cursor: pointer;
    padding: 6px 8px;
}

.ayuda_indice_filtros {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}
.ayuda_indice_chip {
    border: 1px solid #d6dce3;
    background: #fff;
    color: #4c5661;
    padding: 5px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s ease;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.ayuda_indice_chip:hover { background: #f1f5f9; }
.ayuda_indice_chip.is-active {
    background: #2e86c1;
    border-color: #2e86c1;
    color: #fff;
}

.ayuda_indice_vacio {
    background: #fff8e1;
    border: 1px solid #ffe7a0;
    color: #8a6d3b;
    padding: 14px 18px;
    border-radius: 10px;
    text-align: center;
    margin-bottom: 16px;
}

.ayuda_indice_grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(330px, 1fr));
    gap: 18px;
}

.ayuda_indice_card {
    background: #fff;
    border: 1px solid #e3e8ee;
    border-radius: 12px;
    padding: 18px 18px 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.03);
    transition: all 0.2s ease;
    display: flex;
    flex-direction: column;
}
.ayuda_indice_card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

.ayuda_indice_card_head {
    display: flex;
    gap: 12px;
    align-items: flex-start;
    border-bottom: 1px solid #f1f5f9;
    padding-bottom: 12px;
    margin-bottom: 8px;
}
.ayuda_indice_card_icon {
    width: 44px; height: 44px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
    color: #fff;
}
.ayuda_indice_card h2 {
    margin: 0 0 4px;
    font-size: 16px;
    font-weight: 700;
    color: #1f2937;
}
.ayuda_indice_card_head p {
    margin: 0;
    font-size: 12.5px;
    color: #6b7280;
    line-height: 1.4;
}

.ayuda_indice_links {
    list-style: none;
    margin: 0;
    padding: 0;
    flex: 1;
}
.ayuda_indice_links li { border-bottom: 1px solid #f8fafc; }
.ayuda_indice_links li:last-child { border-bottom: 0; }
.ayuda_indice_links a {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 4px;
    color: #374151;
    font-size: 13.5px;
    text-decoration: none;
    transition: all 0.12s ease;
    border-radius: 6px;
}
.ayuda_indice_links a:hover {
    background: #f8fafc;
    color: #2e86c1;
    padding-left: 10px;
}
.ayuda_indice_links a i { color: #9ca3af; font-size: 14px; }
.ayuda_indice_links a:hover i { color: #2e86c1; }

.ayuda_indice_links mark {
    background: #fff3a0;
    color: inherit;
    padding: 0 2px;
    border-radius: 3px;
}

/* Color por categoría */
.ayuda_indice_card--azul    .ayuda_indice_card_icon { background: #2e86c1; }
.ayuda_indice_card--verde   .ayuda_indice_card_icon { background: #28a745; }
.ayuda_indice_card--violeta .ayuda_indice_card_icon { background: #7c3aed; }
.ayuda_indice_card--naranja .ayuda_indice_card_icon { background: #d99000; }
.ayuda_indice_card--turquesa .ayuda_indice_card_icon { background: #14b8a6; }
.ayuda_indice_card--rosa    .ayuda_indice_card_icon { background: #ec4899; }
.ayuda_indice_card--gris    .ayuda_indice_card_icon { background: #64748b; }

@media (max-width: 600px) {
    .ayuda_indice_hero { flex-direction: column; padding: 20px; }
    .ayuda_indice_hero_icon { width: 50px; height: 50px; font-size: 28px; }
    .ayuda_indice_hero h1 { font-size: 20px; }
    .ayuda_indice_grid { grid-template-columns: 1fr; }
}
</style>
