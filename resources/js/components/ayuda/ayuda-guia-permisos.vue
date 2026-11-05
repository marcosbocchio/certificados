<template>
    <div class="ayuda_perm">
        <p>
            Cada permiso habilita una pantalla o una acción. Los roles agrupan permisos y los usuarios reciben roles.
            Buscá por nombre o por lo que querés habilitar, por ejemplo "informes".
        </p>

        <div class="ayuda_perm_barra">
            <div class="ayuda_perm_buscar">
                <i class="fa fa-search"></i>
                <input type="text" v-model="busqueda" class="form-control" placeholder="Buscar permiso o descripción..." @keydown.esc="busqueda = ''">
            </div>
            <div class="ayuda_perm_chips">
                <button class="ayuda_perm_chip" :class="{ 'is-active': grupo === 'todos' }" @click="grupo = 'todos'">
                    Todos <span>{{ total }}</span>
                </button>
                <button v-for="g in grupos" :key="g.id" class="ayuda_perm_chip" :class="{ 'is-active': grupo === g.id }" @click="grupo = g.id">
                    {{ g.titulo }} <span>{{ g.filas.length }}</span>
                </button>
            </div>
        </div>

        <p v-if="!visibles.length" class="ayuda_perm_vacio">
            <i class="fa fa-info-circle"></i> Ningún permiso coincide con la búsqueda.
        </p>

        <section v-for="g in visibles" :key="g.id" class="ayuda_perm_grupo">
            <h4>{{ g.titulo }}</h4>
            <p v-if="g.detalle" class="ayuda_perm_detalle">{{ g.detalle }}</p>
            <div class="ayuda_perm_wrap">
                <table class="table table-condensed ayuda_perm_tabla">
                    <thead>
                        <tr>
                            <th style="width:26%;">Permiso</th>
                            <th>Qué permite</th>
                            <th style="width:30%;">Para tener en cuenta</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(f, i) in g.filas" :key="i">
                            <td class="ayuda_perm_nombre">{{ f[0] }}</td>
                            <td>{{ f[1] }}</td>
                            <td class="ayuda_perm_nota">{{ f[2] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</template>

<script>
import catalogo from './datos/permisos-catalogo.js';

export default {
    name: 'ayuda-guia-permisos',
    data() {
        return { busqueda: '', grupo: 'todos', grupos: catalogo };
    },
    computed: {
        total() {
            return this.grupos.reduce((n, g) => n + g.filas.length, 0);
        },
        visibles() {
            const q = this.busqueda.trim().toLowerCase();
            return this.grupos
                .filter(g => this.grupo === 'todos' || this.grupo === g.id)
                .map(g => ({
                    id: g.id,
                    titulo: g.titulo,
                    detalle: g.detalle,
                    filas: q ? g.filas.filter(f => f.join(' ').toLowerCase().indexOf(q) > -1) : g.filas,
                }))
                .filter(g => g.filas.length);
        },
    },
};
</script>

<style scoped>
.ayuda_perm_barra { margin: 10px 0 6px; }
.ayuda_perm_buscar { position: relative; max-width: 420px; }
.ayuda_perm_buscar i { position: absolute; left: 11px; top: 11px; color: #9ca3af; }
.ayuda_perm_buscar input { padding-left: 32px; }
.ayuda_perm_chips { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 10px; }
.ayuda_perm_chip {
    background: #fff;
    border: 1px solid #e5e7eb;
    color: #4c5661;
    padding: 5px 12px;
    border-radius: 999px;
    font-size: 12.5px;
    font-weight: 600;
    cursor: pointer;
}
.ayuda_perm_chip span { opacity: .6; margin-left: 3px; }
.ayuda_perm_chip:hover { border-color: #1a1a1a; color: #1a1a1a; }
.ayuda_perm_chip.is-active { background: #FFCC00; border-color: #FFCC00; color: #1a1a1a; }
.ayuda_perm_vacio { color: #6b7280; margin: 16px 0; }
.ayuda_perm_grupo { margin-top: 20px; }
.ayuda_perm_grupo h4 { margin: 0 0 4px; font-size: 15px; font-weight: 700; color: #1a1a1a; }
.ayuda_perm_detalle { font-size: 12.5px; color: #6b7280; margin: 0 0 8px; max-width: 80ch; line-height: 1.5; }
.ayuda_perm_wrap { overflow-x: auto; border: 1px solid #eef0f3; border-radius: 4px; }
.ayuda_perm_tabla { margin: 0; font-size: 13px; min-width: 620px; }
.ayuda_perm_tabla th {
    background: #fafbfc;
    font-size: 11.5px;
    text-transform: uppercase;
    letter-spacing: .04em;
    color: #4c5661;
}
.ayuda_perm_tabla td { vertical-align: top; line-height: 1.5; }
.ayuda_perm_nombre { font-family: Consolas, monospace; font-size: 12.5px; font-weight: 700; color: #1a1a1a; white-space: nowrap; }
.ayuda_perm_nota { color: #6b7280; font-size: 12.5px; }
</style>
