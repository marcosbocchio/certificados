<template>
    <div class="ayuda_indice">
        <header class="ayuda_indice_header">
            <h1>Centro de ayuda</h1>
            <p>Documentación del sistema organizada por módulo. Buscá un tema o filtrá por categoría.</p>
        </header>

        <div class="ayuda_indice_toolbar">
            <div class="ayuda_indice_search">
                <i class="fa fa-search"></i>
                <input
                    type="text"
                    v-model="busqueda"
                    class="form-control"
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
                    {{ cat.label }}
                </button>
            </div>
        </div>

        <p v-if="totalResultados === 0" class="ayuda_indice_vacio">
            <i class="fa fa-info-circle"></i> Sin resultados para "<strong>{{ busqueda }}</strong>".
        </p>

        <div class="ayuda_indice_grid">
            <article
                v-for="(seccion, idx) in seccionesVisibles"
                :key="idx"
                class="ayuda_indice_card"
            >
                <header class="ayuda_indice_card_head">
                    <h2>{{ seccion.titulo }}</h2>
                    <p>{{ seccion.descripcion }}</p>
                </header>
                <ul class="ayuda_indice_links">
                    <li v-for="(link, j) in seccion.linksVisibles" :key="j">
                        <a :href="link.href">
                            <span v-html="resaltar(link.label)"></span>
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
    props: { secciones: { type: Array, required: true } },
    data() {
        return {
            busqueda: '',
            categoria: 'todas',
            categorias: [
                { id: 'todas',      label: 'Todas' },
                { id: 'inicio',     label: 'Inicio' },
                { id: 'operativo',  label: 'Operativo' },
                { id: 'documental', label: 'Documental' },
                { id: 'maestros',   label: 'Maestros' },
                { id: 'interno',    label: 'Interno' },
                { id: 'dosimetria', label: 'Dosimetría' },
                { id: 'extras',     label: 'Multimedia' },
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
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 12px;
    font-family: 'Montserrat', sans-serif;
    color: #2b2f33;
}

.ayuda_indice_header {
    padding: 0 0 16px;
    margin-bottom: 20px;
    border-bottom: 1px solid #eef0f3;
}
.ayuda_indice_header h1 {
    margin: 0 0 6px;
    font-size: 24px;
    font-weight: 700;
    color: #1a1a1a;
    letter-spacing: -0.01em;
    padding-bottom: 8px;
    border-bottom: 3px solid #FFCC00;
    display: inline-block;
}
.ayuda_indice_header p {
    margin: 8px 0 0;
    font-size: 14px;
    color: #6b7280;
}

.ayuda_indice_toolbar {
    margin-bottom: 22px;
}
.ayuda_indice_search {
    position: relative;
    margin-bottom: 12px;
}
.ayuda_indice_search i.fa-search {
    position: absolute;
    top: 50%; left: 12px;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 13px;
    z-index: 1;
}
.ayuda_indice_search input.form-control {
    padding-left: 34px;
    padding-right: 36px;
    height: 38px;
    border-radius: 6px;
    border-color: #e5e7eb;
    font-size: 14px;
    box-shadow: none;
}
.ayuda_indice_search input.form-control:focus {
    border-color: #FFCC00;
    box-shadow: 0 0 0 3px rgba(255, 204, 0, 0.18);
}
.ayuda_indice_search_clear {
    position: absolute;
    top: 50%; right: 6px;
    transform: translateY(-50%);
    background: transparent;
    border: 0;
    color: #6b7280;
    cursor: pointer;
    padding: 6px 8px;
    z-index: 2;
}

.ayuda_indice_filtros {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
}
.ayuda_indice_chip {
    border: 1px solid #e5e7eb;
    background: #fff;
    color: #4c5661;
    padding: 4px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.12s ease;
}
.ayuda_indice_chip:hover {
    border-color: #1a1a1a;
    color: #1a1a1a;
}
.ayuda_indice_chip.is-active {
    background: #FFCC00;
    border-color: #FFCC00;
    color: #1a1a1a;
}

.ayuda_indice_vacio {
    background: #fffdf5;
    border-left: 3px solid #FFCC00;
    color: #5c4a00;
    padding: 10px 14px;
    border-radius: 0 4px 4px 0;
    margin-bottom: 16px;
    font-size: 13px;
}

.ayuda_indice_grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(310px, 1fr));
    gap: 14px;
}

.ayuda_indice_card {
    background: #fff;
    border: 1px solid #eef0f3;
    border-top: 3px solid #FFCC00;
    border-radius: 4px;
    padding: 16px 18px 8px;
    transition: border-color 0.12s ease;
    display: flex;
    flex-direction: column;
}
.ayuda_indice_card:hover {
    border-color: #d6dce3;
    border-top-color: #FFCC00;
}

.ayuda_indice_card_head {
    padding-bottom: 10px;
    margin-bottom: 6px;
    border-bottom: 1px solid #f3f4f6;
}
.ayuda_indice_card h2 {
    margin: 0 0 4px;
    font-size: 15px;
    font-weight: 700;
    color: #1a1a1a;
}
.ayuda_indice_card_head p {
    margin: 0;
    font-size: 12.5px;
    color: #6b7280;
    line-height: 1.45;
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
    padding: 7px 2px;
    color: #2b2f33;
    font-size: 13px;
    text-decoration: none;
    transition: all 0.1s ease;
    border-bottom: 0 !important;
}
.ayuda_indice_links a:hover {
    color: #1a1a1a;
    padding-left: 8px;
}
.ayuda_indice_links a i {
    color: #d1d5db;
    font-size: 14px;
    transition: color 0.1s ease;
}
.ayuda_indice_links a:hover i { color: #FFCC00; }
.ayuda_indice_links mark {
    background: #FFCC00;
    color: #1a1a1a;
    padding: 0 2px;
    border-radius: 2px;
}

@media (max-width: 600px) {
    .ayuda_indice_grid { grid-template-columns: 1fr; }
    .ayuda_indice_header h1 { font-size: 20px; }
}
</style>
