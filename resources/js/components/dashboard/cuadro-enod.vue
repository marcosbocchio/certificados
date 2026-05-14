<template>
    <div>
        <div class="small-box zoom" :class="[class_color_cuadro ,{flash : tablero_sn},{small_box_opacity : !habilitado_sn}, {pointer : (tablero_sn && habilitado_sn)},{not_allowed : !habilitado_sn}  ] ">
          <div v-if="loading_sn" class="cuadro-loading-badge">
            <i class="fas fa-spinner fa-spin"></i>
          </div>
          <div class="inner">
            <div v-if="icono" class="card-icon-bg">
              <i :class="icono"></i>
            </div>
            <div class="card-nums">
              <span class="num-primary">{{ !invertir_cantidad_sn ? cantidad_1 : cantidad_2 }}</span>
              <span class="num-secondary" v-if="cantidad_2 >= 0">{{ !invertir_cantidad_sn ? cantidad_2 : cantidad_1 }}</span>
            </div>
          </div>
          <div class="card-footer-enod">
            <span v-if="tablero_sn">{{ titulo }}<span v-if="titulo_2" class="footer-sep"> | {{ titulo_2 }}</span></span>
            <span v-else>&nbsp;</span>
          </div>
        </div>     
    </div>
</template>
<script>
export default {
    props : {

        titulo : {
             type: String,
             required:true,
        },

        titulo_2 : {
             type: String,
             required:false,
        },

        tablero_sn : {
            type : Boolean,
            required : false,
            default:true
        },

        class_color_titulo : {
            type : String,
            required : true,
        },

        class_color_sub_titulo : {
            type : String,
            required : true,
        },

        src_icono : {
            type : String,
            required : true,
        },

        class_color_cuadro : {
            type : String,
            required : true,
        },

        class_footer_img : {
            type : String,
            required : false,
        },

        cantidad_1 : { 
            type : Number,
            required : true,  
         },

        cantidad_2 : { 
            type : Number,
            required : false,
            default : -1  
         },   

         habilitado_sn : {
             type: Boolean,
             required:true
         },

         invertir_cantidad_sn : {
             type: Boolean,
             required:false,
             default:false
         },

         loading_sn : {
             type: Boolean,
             required:false,
             default:false
         },

         icono : {
             type: String,
             required: false,
             default: ''
         }

         }
}
</script>


<style>

.small-box {
  position: relative;
  border-radius: 8px;
  box-shadow: 0 4px 16px rgba(0,0,0,0.22), 0 1px 4px rgba(0,0,0,0.12);
  overflow: hidden;
}

.small-box .inner {
  position: relative;
  padding: 18px 16px 10px;
  min-height: 85px;
  display: flex;
  align-items: center;
  justify-content: flex-end;
  overflow: hidden;
}

.card-icon-bg {
  position: absolute;
  left: -8px;
  top: 50%;
  transform: translateY(-58%);
  font-size: 88px;
  line-height: 1;
  opacity: 0.22;
  pointer-events: none;
  user-select: none;
  color: #ffffff;
}

.card-nums {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
}

.num-primary {
  font-size: 32px;
  font-weight: 700;
  color: #ffffff;
  line-height: 1.1;
}

.num-secondary {
  font-size: 18px;
  font-weight: 600;
  color: rgba(255,255,255,0.65);
  line-height: 1.2;
}

.card-footer-enod {
  background-color: rgba(0,0,0,0.20);
  border-top: 1px solid rgba(255,255,255,0.08);
  padding: 7px 12px;
  font-size: 10px;
  font-weight: 700;
  font-family: 'Montserrat', sans-serif;
  color: rgba(255,255,255,0.70);
  text-align: center;
  letter-spacing: 0.6px;
  text-transform: uppercase;
}

.footer-sep {
  color: rgba(255,255,255,0.35);
  font-weight: 400;
}

.cuadro-loading-badge {
  position: absolute;
  top: 8px;
  left: 8px;
  width: 22px;
  height: 22px;
  border-radius: 50%;
  background: rgba(255,255,255,0.9);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 2;
  pointer-events: none;
}

.cuadro-loading-badge i {
  font-size: 12px;
  color: #4F8CFF;
}

.zoom:hover {
  transform: scale(1.03);
  transition: 0.2s;
}

.flash:hover {
  opacity: 1;
  -webkit-animation: flash 1.5s;
  animation: flash 1.5s;
}

@-webkit-keyframes flash {
  0% { opacity: .4; }
  100% { opacity: 1; }
}
@keyframes flash {
  0% { opacity: .4; }
  100% { opacity: 1; }
}

.small_box_opacity { opacity: 0.5; }

</style>
