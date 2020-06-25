<template>
    <div>
        <div class="small-box zoom" :class="[class_color_cuadro ,{small_box_opacity : !habilitado_sn}, {pointer : habilitado_sn},{not_allowed : !habilitado_sn}  ] ">
          <div class="inner">
            <img :src="src_icono" width="80px" />
            <p class="cant" >{{ cantidad_1 }}</p>
            <p class="titulo" :class="class_color_titulo">{{ titulo }}</p>
          </div>
           <div class="footer-mas-info">
                <a href="#" class="small-box-footer" > > Más info</a>  
           </div>           
        </div>     
    </div>
</template>
<script>
export default {
    props : {

        titulo : {
            type : String,
            required : true
        },

        class_color_titulo : {
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

  font-size: 13px;
  font-weight: bold;
  margin-top: -10px;
  
}

.color_titulo_1 {

  color: rgb(255, 203, 58);

}

.color_titulo_2 {
    
  color: rgb(32, 32, 32);

}

.small-box .inner {

    padding-bottom: 0px;
}

.small-box .inner .cant {

  position: absolute;;
  font-size: 26px; 
  top: 0;
  right: 20px;
  color: white;
}

.small-box .small-box-footer {

  font-weight: 600;
  color: rgb(32,32,32);
  background-color: rgb(255, 203, 58);
}

.zoom:hover  {

  -ms-transform: scale(1.03); /* IE 9 */
  -webkit-transform: scale(1.03); /* Safari 3-8 */
  transform: scale(1.03); 
  transition: 0.99s;
}

.footer-mas-info {

background-image: url("/img/tablero/footer-operadores.png") !important;
background-size:     cover;                   
background-repeat:   no-repeat;
background-position: center center;  

}

.small_box_opacity {  
    
    opacity: 0.7;
}

</style>