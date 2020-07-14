<template>
    <div>
        <div class="col-sm-10 hidden-xs" >
            <div class="small-box" style="height: 125px;">
                <p>adfadf</p>
            </div>
        </div>
        <div class="col-sm-2" >
            <div class="small-box"  :class="[class_color_cuadro ,{flash : tablero_sn},{small_box_opacity : !habilitado_sn}, {pointer : (tablero_sn && habilitado_sn)},{not_allowed : !habilitado_sn}  ] ">
            <div class="inner">
                <img :src="src_icono" width="100px" />
                <p class="posicion_1 color_cant_1" >
                <div v-if="!invertir_cantidad_sn">
                    <p class="posicion_1 color_cant_1" > {{ cantidad_1 }} </p>    
                </div>
                <div v-else>
                    <p class="posicion_1 color_cant_1" > {{ cantidad_2}} </p>    
                </div>
                        
                <div v-if="cantidad_2 >= 0">
                <div v-if="!invertir_cantidad_sn">
                    <p class="posicion_2 color_cant_2" > {{ cantidad_2 }} </p>    
                </div>
                <div v-else>
                    <p class="posicion_2 color_cant_2" > {{ cantidad_1}} </p>    
                </div>
                </div>
            </div>
                <div :class="class_footer_img">
                <a href="#" class="small-box-footer" >
                    <div v-if="tablero_sn"  :class="class_color_sub_titulo" style="line-height: 1.9;">                      
                        {{ titulo }}           
                        <div v-if="titulo_2" style="display:inline-block" class="color_cant_1">
                        <span style="color:#535353;font-weight: bold;"> | </span> {{ titulo_2 }}
                        </div> 
                    </div>
                    <div v-else>
                        &nbsp;
                    </div>
                    </a> 
                </div>  
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
         }

         
         }
}
</script>


<style >

.small-box {
  text-align: center !important;
  border-radius: 10px;
  -webkit-box-shadow: 1px 1px 10px -1px rgba(0,0,0,0.75);
  -moz-box-shadow: 1px 1px 10px -1px rgba(0,0,0,0.75);
  box-shadow: 1px 1px 10px -1px rgba(0,0,0,0.75);
}

.small-box .inner .titulo {

  font-size: 12px;
  font-weight: bold;
  margin-top: -10px;
  
}

.color_1, .color_cant_1  {
  color: rgb(255, 255, 255);
}
  
.color_2 {
  color: rgb(32, 32, 32);
}

.color_3, .color_cant_2 {
  color: rgb(255, 204, 0);
}

.small-box .inner {

    padding-bottom: 0px;
}


.small-box .inner .posicion_1 {
  position: absolute;;
  font-size: 26px; 
  top: 0;
  right: 20px;
  color: white;
}


.small-box .inner .posicion_2 {
  position: absolute;;
  font-size: 26px; 
  bottom: 15px;
  right: 20px;
  color: rgb(255, 204, 0);
}

.small-box .small-box-footer {
  font-size: 11px;
  font-weight: 600;
  font-family: 'Montserrat',sans-serif;
  padding-bottom: 0;
}

.zoom:hover  {

  -ms-transform: scale(1.03); /* IE 9 */
  -webkit-transform: scale(1.03); /* Safari 3-8 */
  transform: scale(1.03); 
  transition: 0.99s;

}

.flash:hover {

  opacity: 1;
	-webkit-animation: flash 1.5s;
	animation: flash 1.5s;

}

@-webkit-keyframes flash {
	0% {
		opacity: .4;
	}
	100% {
		opacity: 1;
	}
}
@keyframes flash {
	0% {
		opacity: .4;
	}
	100% {
		opacity: 1;
	}
}

.small_box_opacity {  
    
    opacity: 0.5;
}

  .footer-oper-inf {

    background-image: url("/img/tablero/barra-oper-inf.svg") !important;
    background-size:     cover;                   
    background-repeat:   no-repeat;
    background-position: center center;
    
    }

  .footer-equipos-partes {

    background-image: url("/img/tablero/barra-equipos-partes.svg") !important;
    background-size:     cover;                   
    background-repeat:   no-repeat;
    background-position: center center;  
  }

  .footer-proc-cert {

    background-image: url("/img/tablero/barra-proc-cert.svg") !important;
    background-size:     cover;                   
    background-repeat:   no-repeat;
    background-position: center center;  
   }

   .footer-doc-remitos {

    background-image: url("/img/tablero/barra-doc-remitos.svg") !important;
    background-size:     cover;                   
    background-repeat:   no-repeat;
    background-position: center center;  
    }
</style>