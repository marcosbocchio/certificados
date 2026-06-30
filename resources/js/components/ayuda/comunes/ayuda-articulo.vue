<template>
    <article v-if="datos" class="ayuda_articulo">
        <!-- 1. Hero -->
        <header class="ayuda_articulo_hero">
            <h1>{{ heroData.titulo }}</h1>
            <p v-if="heroData.descripcion">{{ heroData.descripcion }}</p>
            <p v-if="heroData.subtexto" class="ayuda_articulo_subtexto">{{ heroData.subtexto }}</p>
        </header>

        <!-- Selector de variantes (si la entidad las declara) -->
        <nav v-if="datos.variantes && datos.variantes.length" class="ayuda_articulo_tabs">
            <button
                v-for="v in datos.variantes"
                :key="v.id"
                class="ayuda_articulo_tab"
                :class="{ 'is-active': varianteActiva === v.id }"
                @click="varianteActiva = v.id"
            >
                {{ v.label }}
                <small v-if="v.descripcion">— {{ v.descripcion }}</small>
            </button>
        </nav>

        <!-- 2. Antes de empezar -->
        <ayuda-seccion v-if="dependencias.length" titulo="Antes de empezar" :numero="1" id="dependencias">
            <p>Verificá que estos elementos existan antes de abrir el formulario:</p>
            <ayuda-tabla-dependencias :items="dependencias"></ayuda-tabla-dependencias>
        </ayuda-seccion>

        <!-- 3. Campos del formulario -->
        <ayuda-seccion v-if="campos.length" titulo="Campos del formulario" :numero="2" id="campos">
            <p v-if="datos.campos_intro">{{ datos.campos_intro }}</p>
            <ayuda-tabla-campos :campos="campos"></ayuda-tabla-campos>
            <component v-if="datos.demo" :is="datos.demo" v-bind="demoProps"></component>
        </ayuda-seccion>

        <!-- 4. Estados y permisos -->
        <ayuda-seccion v-if="datos.estados && datos.estados.length" titulo="Estados y permisos" :numero="3" id="estados">
            <p v-if="datos.estados_intro">{{ datos.estados_intro }}</p>
            <ayuda-tabla-estados
                :estados="datos.estados"
                :transiciones="datos.transiciones || []">
            </ayuda-tabla-estados>
        </ayuda-seccion>

        <!-- 5. Validaciones y errores comunes -->
        <ayuda-seccion v-if="errores.length" titulo="Validaciones y errores comunes" :numero="4" id="errores">
            <p>Mensajes y situaciones más frecuentes con la causa real (según el código) y cómo resolverlos:</p>
            <ayuda-tabla-errores :errores="errores"></ayuda-tabla-errores>
        </ayuda-seccion>

        <!-- 6. Cálculos automáticos -->
        <ayuda-seccion v-if="calculos.length" titulo="Cálculos automáticos" :numero="5" id="calculos">
            <p>Lo que el sistema calcula sin intervención del usuario:</p>
            <ul class="ayuda_calc_list">
                <li v-for="(c, i) in calculos" :key="i">
                    <strong>{{ c.que }}</strong> — {{ c.como }}
                    <code v-if="c.formula" class="ayuda_calc_formula">{{ c.formula }}</code>
                </li>
            </ul>
        </ayuda-seccion>

        <!-- 7. Edición y revisiones -->
        <ayuda-seccion v-if="edicion" titulo="Edición y revisiones" :numero="6" id="edicion">
            <p v-if="edicion.texto">{{ edicion.texto }}</p>
            <ayuda-callout
                v-for="(co, i) in (edicion.callouts || [])"
                :key="i"
                :tipo="co.tipo"
                :titulo="co.titulo">
                <span v-html="co.contenido"></span>
            </ayuda-callout>
        </ayuda-seccion>

        <!-- 8. Impacto cruzado -->
        <ayuda-seccion v-if="impacto.length" titulo="Impacto cruzado" :numero="7" id="impacto">
            <p>Qué afecta esta operación en otros módulos del sistema:</p>
            <ayuda-tabla-impacto :impactos="impacto"></ayuda-tabla-impacto>
        </ayuda-seccion>

        <!-- Secciones extras (escape hatch) -->
        <ayuda-seccion
            v-for="(extra, i) in (datos.secciones_extras || [])"
            :key="'extra-' + i"
            :titulo="extra.titulo"
            :numero="8 + i"
            :id="'extra-' + i">
            <div v-html="extra.html"></div>
        </ayuda-seccion>

        <!-- 9. Artículos relacionados -->
        <ayuda-seccion
            v-if="datos.relacionados && datos.relacionados.length"
            titulo="Artículos relacionados"
            :numero="(8 + (datos.secciones_extras || []).length)"
            id="relacionados">
            <ayuda-relacionados :items="datos.relacionados"></ayuda-relacionados>
        </ayuda-seccion>

        <!-- Metadato de origen (footer técnico) -->
        <footer v-if="datos.fuente_codigo" class="ayuda_articulo_fuente">
            <small>
                <i class="fa fa-code"></i>
                Datos verificados contra:
                <code v-if="datos.fuente_codigo.controller">{{ datos.fuente_codigo.controller }}</code>
                <code v-if="datos.fuente_codigo.model">{{ datos.fuente_codigo.model }}</code>
                <code v-if="datos.fuente_codigo.request">{{ datos.fuente_codigo.request }}</code>
            </small>
        </footer>
    </article>

    <div v-else class="ayuda_articulo_error">
        <ayuda-callout tipo="error" titulo="Entidad no encontrada">
            La entidad <code>{{ entidad }}</code> no tiene un archivo de datos en
            <code>resources/js/components/ayuda/datos/</code>.
        </ayuda-callout>
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
    data() {
        return {
            varianteActiva: '',
        };
    },
    created() {
        if (this.datos && this.datos.variantes && this.datos.variantes.length) {
            const inicial = this.variante || this.datos.variantes[0].id;
            this.varianteActiva = inicial;
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
        dependencias()  { return this.resolver('dependencias', []); },
        campos()        { return this.resolver('campos', []); },
        errores()       { return this.resolver('errores', []); },
        calculos()      { return this.resolver('calculos', []); },
        edicion()       { return this.resolverObj('edicion'); },
        impacto()       { return this.resolver('impacto', []); },
        demoProps()     { return (this.variante_obj && this.variante_obj.demoProps) || this.datos.demoProps || {}; },
    },
    methods: {
        resolver(key, fallback) {
            // Si campos es {ducto: [...], planta: [...]} → resuelve por variante.
            const base = this.datos[key];
            if (!base) return fallback;
            if (Array.isArray(base)) return base;
            // Es objeto con keys de variante → tomar la activa, fallback a la primera key
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
                // mapa por variante
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
.ayuda_articulo {
    max-width: 980px;
    margin: 0 auto;
    font-family: 'Montserrat', sans-serif;
    color: #2b2f33;
}
.ayuda_articulo_hero {
    padding: 4px 0 16px 18px;
    border-left: 3px solid #FFCC00;
    margin-bottom: 22px;
}
.ayuda_articulo_hero h1 {
    margin: 0 0 8px;
    font-size: 24px;
    font-weight: 700;
    color: #1a1a1a;
    letter-spacing: -0.01em;
    padding-bottom: 6px;
    border-bottom: 0;
}
.ayuda_articulo_hero p {
    margin: 0 0 6px;
    font-size: 14px;
    color: #4c5661;
    line-height: 1.6;
}
.ayuda_articulo_subtexto { color: #6b7280; font-size: 13px !important; }

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
    padding: 7px 14px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.12s ease;
    display: inline-flex;
    align-items: baseline;
    gap: 5px;
}
.ayuda_articulo_tab small { color: #9ca3af; font-weight: 400; font-size: 11.5px; }
.ayuda_articulo_tab:hover {
    border-color: #1a1a1a;
    color: #1a1a1a;
}
.ayuda_articulo_tab.is-active {
    background: #FFCC00;
    border-color: #FFCC00;
    color: #1a1a1a;
}
.ayuda_articulo_tab.is-active small { color: #5c4a00; }

.ayuda_calc_list {
    list-style: none;
    padding: 0;
    margin: 8px 0 12px;
}
.ayuda_calc_list li {
    padding: 8px 12px;
    background: #fafbfc;
    border-left: 3px solid #2e86c1;
    border-radius: 0 4px 4px 0;
    margin-bottom: 6px;
    font-size: 13px;
    line-height: 1.55;
}
.ayuda_calc_list li strong { color: #1a1a1a; }
.ayuda_calc_formula {
    display: inline-block;
    background: #fff;
    border: 1px solid #d6dce3;
    color: #4c5661;
    padding: 1px 6px;
    border-radius: 3px;
    font-size: 11.5px;
    font-family: 'Courier New', monospace;
    margin-left: 4px;
}

.ayuda_articulo_fuente {
    margin-top: 30px;
    padding-top: 12px;
    border-top: 1px dashed #e5e7eb;
    text-align: right;
}
.ayuda_articulo_fuente small {
    color: #9ca3af;
    font-size: 11px;
}
.ayuda_articulo_fuente code {
    background: #fafbfc;
    border: 1px solid #eef0f3;
    color: #6b7280;
    padding: 1px 5px;
    border-radius: 3px;
    font-size: 10.5px;
    margin-left: 4px;
}

.ayuda_articulo_error { max-width: 980px; margin: 24px auto; padding: 0 12px; }
</style>
