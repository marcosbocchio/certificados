<template>
    <div>
        <div class="small-box" :class="[class_color_cuadro_largo, {small_box_opacity: !habilitado_sn}, {pointer: (tablero_sn && habilitado_sn)}, {not_allowed: !habilitado_sn}]">
          <div class="inner">
            <div v-if="src_icono" class="card-icon-bg card-icon-bg--svg">
              <img :src="src_icono.replace('/img/tablero/', '/img/tablero/white/')" alt="">
            </div>
            <div v-else-if="icono" class="card-icon-bg">
              <i :class="icono"></i>
            </div>
            <div class="card-nums">
              <span class="num-primary">{{ !invertir_cantidad_sn ? cantidad_1 : cantidad_2 }}</span>
              <span class="num-secondary" v-if="cantidad_2 >= 0">{{ !invertir_cantidad_sn ? cantidad_2 : cantidad_1 }}</span>
            </div>
          </div>
          <div class="card-footer-enod">
            <span v-if="tablero_sn">{{ titulo }}<span v-if="titulo_2" class="footer-sep"> | {{ titulo_2 }}</span></span>
            <span v-else>{{ titulo }}<span v-if="titulo_2" class="footer-sep"> | {{ titulo_2 }}</span></span>
          </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {

        titulo: {
            type: String,
            required: true,
        },

        titulo_2: {
            type: String,
            required: false,
        },

        tablero_sn: {
            type: Boolean,
            required: false,
            default: true
        },

        class_color_titulo: {
            type: String,
            required: false,
            default: ''
        },

        class_color_sub_titulo: {
            type: String,
            required: false,
            default: ''
        },

        src_icono: {
            type: String,
            required: false,
            default: ''
        },

        class_color_cuadro: {
            type: String,
            required: false,
            default: ''
        },

        class_color_cuadro_largo: {
            type: String,
            required: true,
        },

        class_footer_img: {
            type: String,
            required: false,
        },

        cantidad_1: {
            type: Number,
            required: true,
        },

        cantidad_2: {
            type: Number,
            required: false,
            default: -1
        },

        habilitado_sn: {
            type: Boolean,
            required: true
        },

        invertir_cantidad_sn: {
            type: Boolean,
            required: false,
            default: false
        },

        icono: {
            type: String,
            required: false,
            default: ''
        }

    }
}
</script>
