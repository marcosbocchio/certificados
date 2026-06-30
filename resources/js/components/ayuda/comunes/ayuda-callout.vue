<template>
    <aside class="ayuda_callout" :class="'ayuda_callout--' + tipo">
        <div class="ayuda_callout_icon">
            <i :class="iconoClase"></i>
        </div>
        <div class="ayuda_callout_body">
            <strong v-if="titulo" class="ayuda_callout_title">{{ titulo }}</strong>
            <div class="ayuda_callout_content"><slot></slot></div>
        </div>
    </aside>
</template>

<script>
export default {
    name: 'ayuda-callout',
    props: {
        tipo: {
            type: String,
            default: 'info',
            validator: v => ['info', 'tip', 'warning', 'error', 'irreversible'].includes(v),
        },
        titulo: { type: String, default: '' },
    },
    computed: {
        iconoClase() {
            return {
                info:          'fa fa-info-circle',
                tip:           'fa fa-lightbulb-o',
                warning:       'fa fa-exclamation-triangle',
                error:         'fa fa-times-circle',
                irreversible:  'fa fa-lock',
            }[this.tipo];
        },
    },
};
</script>

<style scoped>
.ayuda_callout {
    display: flex;
    gap: 12px;
    padding: 12px 14px;
    border-left: 3px solid #FFCC00;
    background: #fffdf5;
    border-radius: 0 4px 4px 0;
    margin: 12px 0;
    font-family: 'Montserrat', sans-serif;
}
.ayuda_callout_icon {
    flex-shrink: 0;
    font-size: 18px;
    color: #d4a800;
    line-height: 1.4;
}
.ayuda_callout_body { flex: 1; font-size: 13px; color: #4c5661; line-height: 1.55; }
.ayuda_callout_title {
    display: block;
    color: #1a1a1a;
    font-weight: 700;
    margin-bottom: 4px;
    font-size: 13px;
}
.ayuda_callout_content >>> p:last-child { margin-bottom: 0; }

.ayuda_callout--info        { background: #eef5fb; border-left-color: #2e86c1; }
.ayuda_callout--info .ayuda_callout_icon { color: #2e86c1; }

.ayuda_callout--tip         { background: #f0fbf3; border-left-color: #28a745; }
.ayuda_callout--tip .ayuda_callout_icon { color: #28a745; }

.ayuda_callout--warning     { background: #fffdf5; border-left-color: #FFCC00; }
.ayuda_callout--warning .ayuda_callout_icon { color: #d4a800; }

.ayuda_callout--error       { background: #fdecec; border-left-color: #dc3545; }
.ayuda_callout--error .ayuda_callout_icon { color: #dc3545; }

.ayuda_callout--irreversible { background: #1a1a1a; border-left-color: #FFCC00; color: #fff; }
.ayuda_callout--irreversible .ayuda_callout_icon { color: #FFCC00; }
.ayuda_callout--irreversible .ayuda_callout_body { color: #f0f0f0; }
.ayuda_callout--irreversible .ayuda_callout_title { color: #FFCC00; }
</style>
