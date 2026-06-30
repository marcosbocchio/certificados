<template>
    <div class="ayuda_articulo_root">
        <!-- Back button (se inyecta en el header del layout, igual que en el sistema) -->
        <enod-back-button fallback-url="/ayuda_general"></enod-back-button>

        <article v-if="datos" class="box box-custom-enod ayuda_articulo">
            <div class="box-body">

                <!-- Hero -->
                <header class="ayuda_articulo_hero">
                    <div class="ayuda_articulo_hero_text">
                        <h2>{{ heroData.titulo }}</h2>
                        <p v-if="heroData.descripcion">{{ heroData.descripcion }}</p>
                    </div>
                    <a v-if="datos.ir_a" :href="datos.ir_a.ruta" class="ayuda_ir_sistema_btn">
                        <i :class="'fa fa-' + (datos.ir_a.icono || 'external-link')"></i>
                        {{ datos.ir_a.label || 'Ir al sistema' }}
                    </a>
                </header>

                <!-- Tabs de variantes -->
                <nav v-if="datos.variantes && datos.variantes.length" class="ayuda_articulo_tabs">
                    <button
                        v-for="v in datos.variantes"
                        :key="v.id"
                        class="ayuda_articulo_tab"
                        :class="{ 'is-active': varianteActiva === v.id }"
                        @click="varianteActiva = v.id"
                    >
                        {{ v.label }}
                    </button>
                </nav>

                <!-- ¿Qué podés hacer? -->
                <ayuda-seccion v-if="acciones.length" titulo="¿Qué podés hacer en esta pantalla?" id="acciones">
                    <ul class="ayuda_acciones">
                        <li v-for="(a, i) in acciones" :key="i">
                            <i :class="'fa fa-' + (a.icono || 'check')"></i>
                            <div>
                                <strong>{{ a.titulo }}</strong>
                                <span v-if="a.detalle">— {{ a.detalle }}</span>
                            </div>
                        </li>
                    </ul>
                </ayuda-seccion>

                <!-- Antes de empezar -->
                <ayuda-seccion v-if="dependencias.length" titulo="Antes de empezar" id="dependencias">
                    <p v-if="datos.dependencias_intro">{{ datos.dependencias_intro }}</p>
                    <ayuda-tabla-dependencias :items="dependencias"></ayuda-tabla-dependencias>
                </ayuda-seccion>

                <!-- Lo que cargás en la pantalla (agrupado por bloques) -->
                <ayuda-seccion v-if="bloques.length" titulo="Lo que cargás en la pantalla" id="bloques">
                    <p v-if="datos.bloques_intro">{{ datos.bloques_intro }}</p>
                    <div class="ayuda_bloques">
                        <div v-for="(b, i) in bloques" :key="i" class="ayuda_bloque">
                            <h4 class="ayuda_bloque_titulo">
                                <i v-if="b.icono" :class="'fa fa-' + b.icono"></i>
                                {{ b.titulo }}
                            </h4>
                            <p v-if="b.descripcion" class="ayuda_bloque_desc">{{ b.descripcion }}</p>
                            <ul class="ayuda_bloque_lista">
                                <li v-for="(c, j) in b.campos" :key="j">
                                    <span class="ayuda_bloque_campo">
                                        {{ c.nombre }}
                                        <span v-if="c.obligatorio" class="ayuda_obl" title="Obligatorio">*</span>
                                    </span>
                                    <span v-if="c.detalle" class="ayuda_bloque_detalle">— {{ c.detalle }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <p class="ayuda_obl_leyenda">
                        <span class="ayuda_obl">*</span> Obligatorio · sin estos campos el sistema no deja guardar.
                    </p>
                </ayuda-seccion>

                <!-- Vista previa de la pantalla -->
                <ayuda-seccion v-if="demoActivo" titulo="Así se ve la pantalla" id="vista">
                    <component :is="demoActivo" v-bind="demoProps"></component>
                </ayuda-seccion>

                <!-- Botones disponibles -->
                <ayuda-seccion v-if="botones.length" titulo="Botones y qué hace cada uno" id="botones">
                    <ul class="ayuda_botones">
                        <li v-for="(b, i) in botones" :key="i">
                            <span class="ayuda_boton_demo" :class="b.estilo || ''">
                                <i v-if="b.icono" :class="'fa fa-' + b.icono"></i>
                                {{ b.label }}
                            </span>
                            <span class="ayuda_boton_desc">— {{ b.descripcion }}</span>
                        </li>
                    </ul>
                </ayuda-seccion>

                <!-- Estados -->
                <ayuda-seccion v-if="datos.estados && datos.estados.length" titulo="¿Cuándo podés editar?" id="estados">
                    <p v-if="datos.estados_intro">{{ datos.estados_intro }}</p>
                    <ayuda-tabla-estados :estados="datos.estados" :transiciones="datos.transiciones || []"></ayuda-tabla-estados>
                </ayuda-seccion>

                <!-- Errores -->
                <ayuda-seccion v-if="errores.length" titulo="Si te pasa esto…" id="errores">
                    <ayuda-tabla-errores :errores="errores"></ayuda-tabla-errores>
                </ayuda-seccion>

                <!-- Cálculos automáticos -->
                <ayuda-seccion v-if="calculos.length" titulo="Lo que el sistema hace solo" id="calculos">
                    <ul class="ayuda_calc_list">
                        <li v-for="(c, i) in calculos" :key="i">
                            <strong>{{ c.que }}</strong> — {{ c.como }}
                        </li>
                    </ul>
                </ayuda-seccion>

                <!-- Edición -->
                <ayuda-seccion v-if="edicion" titulo="Modificar después de guardar" id="edicion">
                    <p v-if="edicion.texto">{{ edicion.texto }}</p>
                    <ayuda-callout
                        v-for="(co, i) in (edicion.callouts || [])"
                        :key="i"
                        :tipo="co.tipo"
                        :titulo="co.titulo">
                        <span v-html="co.contenido"></span>
                    </ayuda-callout>
                </ayuda-seccion>

                <!-- Impacto -->
                <ayuda-seccion v-if="impacto.length" titulo="Qué cambia después de guardar" id="impacto">
                    <ayuda-tabla-impacto :impactos="impacto"></ayuda-tabla-impacto>
                </ayuda-seccion>

                <!-- Extras -->
                <ayuda-seccion
                    v-for="(extra, i) in (datos.secciones_extras || [])"
                    :key="'extra-' + i"
                    :titulo="extra.titulo"
                    :id="'extra-' + i">
                    <div v-html="extra.html"></div>
                </ayuda-seccion>

                <!-- Relacionados -->
                <ayuda-seccion
                    v-if="datos.relacionados && datos.relacionados.length"
                    titulo="También te puede interesar"
                    id="relacionados">
                    <ayuda-relacionados :items="datos.relacionados"></ayuda-relacionados>
                </ayuda-seccion>

                <!-- CTA inferior -->
                <div v-if="datos.ir_a" class="ayuda_articulo_cta_bottom">
                    <a :href="datos.ir_a.ruta" class="ayuda_ir_sistema_btn">
                        <i :class="'fa fa-' + (datos.ir_a.icono || 'external-link')"></i>
                        {{ datos.ir_a.label || 'Ir al sistema' }}
                    </a>
                </div>
            </div>
        </article>

        <article v-else class="box box-custom-enod ayuda_articulo">
            <div class="box-body">
                <ayuda-callout tipo="error" titulo="Sección no disponible">
                    Este artículo todavía no está disponible. Volvé al
                    <a href="/ayuda_general">índice de ayuda</a>.
                </ayuda-callout>
            </div>
        </article>
    </div>
</template>

<script>
import datos from '../datos/index.js';

export default {
    name: 'ayuda-articulo',
    props: {
        entidad: { type: String, required: true },
        variante: { type: String, default: '' },
    },
    data() { return { varianteActiva: '' }; },
    created() {
        if (this.datos && this.datos.variantes && this.datos.variantes.length) {
            this.varianteActiva = this.variante || this.datos.variantes[0].id;
        }
    },
    computed: {
        datos() { return datos[this.entidad] || null; },
        variante_obj() {
            if (!this.datos || !this.datos.variantes) return null;
            return this.datos.variantes.find(v => v.id === this.varianteActiva) || null;
        },
        heroData() {
            const base = this.datos.hero || { titulo: this.entidad };
            const ov = this.variante_obj && this.variante_obj.hero;
            return ov ? Object.assign({}, base, ov) : base;
        },
        acciones()      { return this.resolver('acciones', []); },
        dependencias()  { return this.resolver('dependencias', []); },
        bloques()       { return this.resolver('bloques', []); },
        botones()       { return this.resolver('botones', []); },
        errores()       { return this.resolver('errores', []); },
        calculos()      { return this.resolver('calculos', []); },
        edicion()       { return this.resolverObj('edicion'); },
        impacto()       { return this.resolver('impacto', []); },
        demoActivo() {
            const d = this.datos.demo;
            if (!d) return null;
            if (typeof d === 'string') return d;
            if (typeof d === 'object') {
                if (this.varianteActiva && d[this.varianteActiva]) return d[this.varianteActiva];
                const keys = Object.keys(d);
                return keys.length ? d[keys[0]] : null;
            }
            return null;
        },
        demoProps()     { return (this.variante_obj && this.variante_obj.demoProps) || this.datos.demoProps || {}; },
    },
    methods: {
        resolver(key, fallback) {
            const base = this.datos[key];
            if (!base) return fallback;
            if (Array.isArray(base)) return base;
            if (typeof base === 'object') {
                if (this.varianteActiva && base[this.varianteActiva]) return base[this.varianteActiva];
                const keys = Object.keys(base);
                return keys.length ? base[keys[0]] : fallback;
            }
            return fallback;
        },
        resolverObj(key) {
            const base = this.datos[key];
            if (!base) return null;
            if (typeof base === 'object' && !Array.isArray(base) && !base.texto && !base.callouts) {
                if (this.varianteActiva && base[this.varianteActiva]) return base[this.varianteActiva];
                const keys = Object.keys(base);
                return keys.length ? base[keys[0]] : null;
            }
            return base;
        },
    },
};
</script>

<style scoped>
.ayuda_articulo_root {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 4px;
    font-family: 'Montserrat', sans-serif;
}
.ayuda_articulo {
    margin: 0;
    background: #fff;
    border: 1px solid #eef0f3;
    border-top: 3px solid #FFCC00;
    border-radius: 4px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.ayuda_articulo .box-body { padding: 22px 26px; }

/* Hero */
.ayuda_articulo_hero {
    display: flex;
    gap: 18px;
    align-items: flex-start;
    flex-wrap: wrap;
    margin-bottom: 22px;
    padding-bottom: 16px;
    border-bottom: 1px solid #eef0f3;
}
.ayuda_articulo_hero_text { flex: 1; min-width: 260px; }
.ayuda_articulo_hero h2 {
    margin: 0 0 8px;
    font-size: 22px;
    font-weight: 700;
    color: #1a1a1a;
    letter-spacing: -0.01em;
}
.ayuda_articulo_hero p {
    margin: 0;
    font-size: 14px;
    color: #4c5661;
    line-height: 1.6;
}

/* CTA "Ir al sistema" — estilo enod */
.ayuda_ir_sistema_btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #FFCC00;
    border: 1px solid #FFCC00;
    color: #1a1a1a !important;
    padding: 9px 18px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none !important;
    transition: all 0.12s ease;
    line-height: 1;
    white-space: nowrap;
    align-self: center;
}
.ayuda_ir_sistema_btn:hover,
.ayuda_ir_sistema_btn:focus {
    background: #1a1a1a;
    border-color: #1a1a1a;
    color: #FFCC00 !important;
}
.ayuda_articulo_cta_bottom {
    margin: 28px 0 4px;
    text-align: center;
    padding-top: 20px;
    border-top: 1px solid #eef0f3;
}

/* Tabs */
.ayuda_articulo_tabs {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    margin-bottom: 22px;
    padding-bottom: 8px;
    border-bottom: 1px solid #eef0f3;
}
.ayuda_articulo_tab {
    background: #fff;
    border: 1px solid #e5e7eb;
    color: #4c5661;
    padding: 7px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.12s ease;
}
.ayuda_articulo_tab:hover { border-color: #1a1a1a; color: #1a1a1a; }
.ayuda_articulo_tab.is-active {
    background: #FFCC00;
    border-color: #FFCC00;
    color: #1a1a1a;
}

/* Acciones */
.ayuda_acciones {
    list-style: none;
    padding: 0;
    margin: 8px 0 0;
}
.ayuda_acciones li {
    display: flex;
    gap: 10px;
    padding: 10px 14px;
    background: #fafbfc;
    border: 1px solid #eef0f3;
    border-radius: 4px;
    margin-bottom: 6px;
    align-items: flex-start;
    font-size: 13.5px;
    line-height: 1.55;
}
.ayuda_acciones li > i { color: #d4a800; font-size: 14px; margin-top: 3px; flex-shrink: 0; }
.ayuda_acciones li strong { color: #1a1a1a; font-weight: 700; }

/* Bloques de campos */
.ayuda_bloques {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(290px, 1fr));
    gap: 12px;
    margin: 12px 0 8px;
}
.ayuda_bloque {
    background: #fafbfc;
    border: 1px solid #eef0f3;
    border-top: 3px solid #FFCC00;
    border-radius: 4px;
    padding: 12px 14px;
}
.ayuda_bloque_titulo {
    margin: 0 0 4px;
    font-size: 13px;
    font-weight: 700;
    color: #1a1a1a;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.ayuda_bloque_titulo i { color: #d4a800; margin-right: 5px; }
.ayuda_bloque_desc {
    font-size: 12px;
    color: #6b7280;
    margin: 0 0 8px;
    line-height: 1.5;
}
.ayuda_bloque_lista { list-style: none; padding: 0; margin: 0; }
.ayuda_bloque_lista li {
    padding: 4px 0;
    border-bottom: 1px dashed #eef0f3;
    font-size: 13px;
    line-height: 1.5;
}
.ayuda_bloque_lista li:last-child { border-bottom: 0; }
.ayuda_bloque_campo { color: #1a1a1a; font-weight: 600; }
.ayuda_bloque_detalle { color: #6b7280; font-size: 12.5px; }
.ayuda_obl {
    color: #dc3545;
    font-weight: 700;
    margin-left: 2px;
}
.ayuda_obl_leyenda {
    font-size: 11.5px;
    color: #6b7280;
    margin: 8px 0 0;
}

/* Botones documentados */
.ayuda_botones { list-style: none; padding: 0; margin: 8px 0; }
.ayuda_botones li {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 0;
    border-bottom: 1px solid #f3f4f6;
    font-size: 13.5px;
    flex-wrap: wrap;
}
.ayuda_botones li:last-child { border-bottom: 0; }
.ayuda_boton_demo {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #FFCC00;
    color: #1a1a1a;
    padding: 5px 12px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 700;
    line-height: 1;
    border: 1px solid #FFCC00;
    pointer-events: none;
    flex-shrink: 0;
}
.ayuda_boton_demo.gris { background: #fff; color: #4c5661; border-color: #d6dce3; }
.ayuda_boton_demo.rojo { background: #dc3545; color: #fff; border-color: #dc3545; }
.ayuda_boton_demo.negro { background: #1a1a1a; color: #fff; border-color: #1a1a1a; }
.ayuda_boton_desc { color: #4c5661; font-size: 13px; }

/* Cálculos */
.ayuda_calc_list { list-style: none; padding: 0; margin: 8px 0 4px; }
.ayuda_calc_list li {
    padding: 8px 12px;
    background: #fffdf5;
    border-left: 3px solid #FFCC00;
    border-radius: 0 4px 4px 0;
    margin-bottom: 6px;
    font-size: 13.5px;
    line-height: 1.55;
}
.ayuda_calc_list li strong { color: #1a1a1a; }
</style>
