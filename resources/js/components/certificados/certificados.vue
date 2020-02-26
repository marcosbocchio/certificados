<template>
    <div class="row">
        <div class="col-md-12">
            <form @submit.prevent="editmode ?  Update() : Store()"  method="post">
                <parte-header :otdata="otdata" :certificado_sn="true"></parte-header>

                    <div class="box box-custom-enod">
                         <div class="box-body"> 
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="fecha">Fecha *</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                        </div>
                                            <Datepicker v-model="fecha" :input-class="'form-control pull-right'" :language="es"></Datepicker>   
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" >
                                    <label for="numero">Certificado N° </label>
                                    <input type="number" v-model="numero_code" class="form-control" id="numero" disabled>
                                </div>                            
                            </div>

                        </div>
                    </div>

                    <div class="box box-custom-enod">
                        <div class="box-header with-border">
                            <h3 class="box-title">Partes sin Certificados</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>                       
                            </div>
                        </div>
                         <div class="box-body">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th class="col-md-2">SEL.</th>                                                                
                                            <th class="col-md-3">PARTE N°</th>  
                                            <th class="col-md-3">OBRA</th> 
                                            <th class="col-md-4">FECHA</th>                                      
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(parte,k) in partes" :key="k">
                                            <td>
                                                <input type="checkbox" id="informe_sel" v-model="partes[k].parte_sel" @change="getParte(k)" @click="seleccinarAnteriores(k)">
                                            </td>                                                                                          
                                            <td>{{ parte.numero_formateado}}</td>
                                            <td>{{ parte.obra}}</td>  
                                            <td>{{ parte.fecha_formateada}}</td>                                                                                                                      
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                            </div>                                                
                        </div>
                    </div>

                    <div v-show="TablaPartesServicios.length">
                        <div class="box box-custom-enod">
                            <div class="box-header with-border">
                                <h3 class="box-title">Servicios</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>                       
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>                                                                                                      
                                                <th class="col-md-3">PARTE N°</th>  
                                                <th class="col-md-3">SERVICIO</th> 
                                                <th class="col-md-3">DESCRIPCIÓN</th>
                                                <th class="col-md-2">CANTIDAD</th>     
                                            <th class="col-md-1">&nbsp;</th>                                                                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item,k) in TablaPartesServicios" :key="k" @click="selectPosTablaPartesServicios(k)">                                        

                                                <td v-if="item.visible">{{ item.numero_formateado}}</td>
                                                <td v-if="item.visible">{{ item.abreviatura}}</td> 
                                                <td v-if="item.visible">{{ item.servicio_descripcion}}</td>  

                                                <td v-if="item.visible">                                                                                                                                                                     
                                                    <div v-if="indexTablaPartesServicios == k ">      
                                                        <input type="number" v-model="TablaPartesServicios[k].cant_final" maxlength="10">  
                                                    </div>                                             
                                                    <div v-else>
                                                        {{ item.cant_final }}
                                                    </div>  
                                                </td> 
                                                <td style="text-align:center" v-if="item.visible"> 
                                                    <a  @click="RemoveTablaPartesServicios(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a>
                                                </td>
                                        
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>                                                
                            </div>
                        </div>
                    </div>

                    <div v-show="TablaPartesProductosPorCosturas.length">
                        <div class="box box-custom-enod">
                            <div class="box-header with-border">
                                <h3 class="box-title">Productos</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>                       
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>   
                                                <th class="col-md-3">PARTE N°</th>                                                                                           
                                                <th class="col-md-3">COSTURAS</th>  
                                                <th class="col-md-3">PULGADAS</th>                                                                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item,k) in TablaPartesProductosPorCosturas" :key="k" @click="selectPosTablaPartesProductosPorCosturas(k)">                                                                                         
                                                <td>{{ item.numero_formateado}}</td>
                                                <td>
                                                   <div v-if="indexTablaPartesProductosPorCosturas == k ">      
                                                        <input type="number" v-model="TablaPartesProductosPorCosturas[k].costuras_final" maxlength="10">  
                                                    </div>                                             
                                                    <div v-else>
                                                        {{ item.costuras_final }}
                                                    </div>                                               
                                                 
                                                </td>
                                                <td>{{ item.pulgadas}}</td>                                                                                                                                                            
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>                                                
                            </div>
                        </div>
                    </div>

                    <div v-show="TablaPartesProductosPorPlacas.length">
                        <div class="box box-custom-enod">
                            <div class="box-header with-border">
                                <h3 class="box-title">Productos</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>                       
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>       
                                                <th class="col-md-3">PARTE N°</th>                                                                                                 
                                                <th class="col-md-3">PLACAS</th>  
                                                <th class="col-md-3">CM</th>                                                                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item,k) in TablaPartesProductosPorPlacas" :key="k" @click="selectPosTablaPartesProductosPorPlacas(k)">  
                                                <td>{{ item.numero_formateado}}</td>                                                                                       
                                                <td>                                                  
                                                    <div v-if="indexTablaPartesProductosPorPlacas == k ">      
                                                        <input type="number" v-model="TablaPartesProductosPorPlacas[k].placas_final" maxlength="10">  
                                                    </div>                                             
                                                    <div v-else>
                                                        {{ item.placas_final }}
                                                    </div>   
                                                </td>
                                                <td>{{ item.cm}}</td>  
                                                                                                                                                            
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>                                                
                            </div>
                        </div>
                    </div>
                <button class="btn btn-primary" type="submit">Guardar</button> 
            </form>
        </div>
    </div>    
</template>

<script>
import {mapState} from 'vuex';
import {en, es} from 'vuejs-datepicker/dist/locale';
import Datepicker from 'vuejs-datepicker';
import {sprintf} from '../../functions/sprintf.js'

export default {

    components: {

      Datepicker
      
    },

    props : {

      editmode : {
        type : Boolean,
        required : false,    
        default : false
      },  

      otdata : {
        type : Object,
        required : true
      }, 
      
      certificado_data : {
     type : Object,
      required : false
      },

      servicios_data : {
      type : [ Array ],  
      required : false
      },

      productos_placas_data : {
      type : [ Array ],  
      required : false
      },

      productos_costura_data : {
      type : [ Array ],  
      required : false
      },
    },

    data () { return{

        errors:[],
        en: en,
        es: es,
        numero:'',      
        fecha:'',   
        partes:[],
        modo_cobro:'',
        TablaPartesServicios:[],
        TablaPartesProductosPorPlacas:[],
        TablaPartesProductosPorCosturas:[],
        indexTablaPartesProductosPorPlacas:-1,
        indexTablaPartesProductosPorCosturas:-1,
        indexTablaPartesServicios:-1,
       }
    },

    created : function() {

        this.CargaDeDatos();  

    },

      mounted : function() {    

        this.getNumeroCertificado();
        this.getModalidadCobro();

      },       
      

    computed :{

        ...mapState(['url','AppUrl']),     

        numero_code : function()  {

               if(this.numero){

                   return   sprintf("%08d",this.numero) ;
                  
               }
        },       
     },

      methods : { 

          CargaDeDatos : function(){

             if(this.editmode) {

                this.fecha  = this.certificado_data.fecha;   
                this.numero = this.certificado_data.numero;

                this.$nextTick(function(){

                   this.setCerficadoServicios(); 
                   this.setCerficadoProductos();
                   this.getPartesPendientesYEditableCertificado(); 

               });      

             }else{      

                  this.getPartesPendientesCertificado();

             }

          },

        getModalidadCobro : function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'certificados/ot/' + this.otdata.id + '/modalidad_cobro' + '?api_token=' + Laravel.user.api_token;  
            axios.get(urlRegistros).then(response =>{                
              
                let reg = response.data;
                this.modo_cobro = reg.length ? 'COSTURAS' : 'PLACAS'              

            });
        },

        seleccinarAnteriores :function(index){

            if(!this.partes[index].parte_sel){

                for ( let x = index ; x >= 0; x--) {
                    
                    if(!this.partes[x].parte_sel){

                        this.$nextTick(function(){

                        this.partes[x].parte_sel = true;
                        this.getParte(x);

                        });
    
                    }
                    
                }

            }

        },

        setCerficadoServicios : function(){

            this.TablaPartesServicios =  JSON.parse(JSON.stringify(this.servicios_data));  

            this.TablaPartesServicios.forEach(function(item) {

                if(item.cant_final == null){
                    item.visible = false;
                }else{
                     item.visible = true;
                }
            }.bind(this))
        },

        getPartesPendientesYEditableCertificado : function(){

             axios.defaults.baseURL = this.url ;
             var urlRegistros = 'partes/ot/' + this.otdata.id + '/certificado/'+ this.certificado_data.id + '/pendientes_editables_certificado' + '?api_token=' + Laravel.user.api_token;        
             axios.get(urlRegistros).then(response =>{
             console.log('certificados pendientes y editables')   
             console.log(response.data)   
             this.partes = JSON.parse(JSON.stringify(response.data));   


                 this.servicios_data.forEach(function(item){

                     if(this.partes.map(x => x.id).indexOf(item.parte_id) !== -1){

                         this.partes[this.partes.map(x => x.id).indexOf(item.parte_id)].parte_sel = true;
                     }


                 }.bind(this));

                 this.productos_costura_data.forEach(function(item){

                     if(this.partes.map(x => x.id).indexOf(item.parte_id) !== -1){

                         this.partes[this.partes.map(x => x.id).indexOf(item.parte_id)].parte_sel = true;
                     }


                 }.bind(this));

                 this.productos_placas_data.forEach(function(item){

                     if(this.partes.map(x => x.id).indexOf(item.parte_id) !== -1){

                         this.partes[this.partes.map(x => x.id).indexOf(item.parte_id)].parte_sel = true;
                     }


                 }.bind(this));

            });

        },

        setCerficadoProductos : function(){

            this.TablaPartesProductosPorPlacas =  JSON.parse(JSON.stringify(this.productos_placas_data));  
            this.TablaPartesProductosPorCosturas =  JSON.parse(JSON.stringify(this.productos_costura_data));  

        },

        getParte : function(index){ 

           if(this.partes[index].parte_sel){               
              
                    this.getServiciosParte(this.partes[index].id);
                    this.getProductosParte(this.partes[index].id);
            }else{
                    this.deleteServiciosParte(this.partes[index].id)   
                    this.deleteProductosParte(this.partes[index].id)                   

            }
        },

        getServiciosParte : function(id){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'certificados/parte/' + id + '/servicios' + '?api_token=' + Laravel.user.api_token;  
            axios.get(urlRegistros).then(response =>{
             
                let parte_servicios = response.data  

                    parte_servicios.forEach(function(item) {          

                        let cantidad = (Math.round(item.cantidad * 100) / 100).toFixed(2);
                        this.TablaPartesServicios.push({                           
                        
                            parte_id : item.parte_id,
                            numero_formateado : item.numero_formateado,
                            unidades_medidas_id : item.unidad_medida_id, 
                            unidad_medida_codigo:item.unidad_medida_codigo,  
                            servicio_id : item.servicio_id,
                            servicio_descripcion : item.servicio_descripcion,
                            cant_original: cantidad,                       
                            cant_final: cantidad,   
                            abreviatura :item.abreviatura,               
                            visible : true

                        });             

                   }.bind(this));
        
             });
           
        },

        getProductosParte : function(id){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'certificados/parte/' + id + '/modo_cobro/'+ this.modo_cobro +'/productos' + '?api_token=' + Laravel.user.api_token;  
            axios.get(urlRegistros).then(response =>{ 

                console.log(urlRegistros);
                console.log(response.data);
                let parte_productos = response.data    
                
                parte_productos.forEach(function(item) {

                    let cantidad = (Math.round(item.cantidad * 100) / 100).toFixed(2);
                    
                    if(this.modo_cobro=='PLACAS'){

                        this.TablaPartesProductosPorPlacas.push({                           
                        
                            parte_id : item.parte_id,
                            numero_formateado : item.numero_formateado,
                            cm : item.cm_final, 
                            placas_original:item.cantidad, 
                            placas_final:item.cantidad,              
                            visible : true
    
                        });   
                    }else if(this.modo_cobro=='COSTURAS'){

                        this.TablaPartesProductosPorCosturas.push({                           
                        
                            parte_id : item.parte_id,
                            numero_formateado : item.numero_formateado,
                            pulgadas : item.pulgadas_final, 
                            costuras_original:item.cantidad,
                            costuras_final:item.cantidad,              
                            visible : true
    
                        });  
                        

                    }

                }.bind(this));            

            });
            
        },

        deleteServiciosParte : function(id){

            this.TablaPartesServicios = this.TablaPartesServicios.filter(function(item) {
                return item.parte_id != id; 
            });

        },

        
        deleteProductosParte : function(id){

           this.TablaPartesProductosPorPlacas = this.TablaPartesProductosPorPlacas.filter(function(item) {
                return item.parte_id != id; 
            });

           this.TablaPartesProductosPorCosturas = this.TablaPartesProductosPorCosturas.filter(function(item) {
                return item.parte_id != id; 
            });
            
        },

        getPartesPendientesCertificado: function(){
             
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'partes/ot/' + this.otdata.id + '/pendientes_certificados' + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
               this.partes = response.data;
            });
               
        },

       getNumeroCertificado: function(){ 

              if(!this.editmode) { 

                    axios.defaults.baseURL = this.url ;
                    var urlRegistros = 'certificados/generar-numero-certificado'  + '?api_token=' + Laravel.user.api_token;         
                    axios.get(urlRegistros).then(response =>{

                    this.numero_inf_generado = response.data                      
                
                    if(this.numero_inf_generado.length){

                        this.numero =  this.numero_inf_generado[0].numero_certificado
                    }else{

                        this.numero = 1;
                    }                   
                    
                    });   
              }
          },

       selectPosTablaPartesProductosPorPlacas: function(index){ 

            this.indexTablaPartesProductosPorPlacas = index ;            

       },   

      selectPosTablaPartesProductosPorCosturas: function(index){ 

            this.indexTablaPartesProductosPorCosturas = index ;    

       },   

       selectPosTablaPartesServicios: function(index){ 

            this.indexTablaPartesServicios = index ;    

       },

       RemoveTablaPartesServicios: function(index){ 

           this.TablaPartesServicios[index].visible = false;
           this.TablaPartesServicios[index].cant_final=''; 
       },  

        Store : function(){


            this.errors =[];
          
            var urlRegistros = 'certificados' ;      
            axios({
              method: 'post',
              url : urlRegistros,    
              data : {     
                'ot'                                 : this.otdata, 
                'numero'                             : this.numero,                  
                'fecha'                              : this.fecha,
                'TablaPartesServicios'               : this.TablaPartesServicios,
                'TablaPartesProductosPorPlacas'      : this.TablaPartesProductosPorPlacas,     
                'TablaPartesProductosPorCosturas'    : this.TablaPartesProductosPorCosturas,

          }
          
          }).then(response => {
          this.response = response.data
          toastr.success('Certificado N°' +  this.numero_code + ' fue creado con éxito ');
           console.log(response.data);  
        }).catch(error => {
               
               this.errors = error.response.data.errors;
                console.log(error.response);
               $.each( this.errors, function( key, value ) {
                   toastr.error(value);
                     console.log( key + ": " + value );
               });

               if((typeof(this.errors)=='undefined') && (error)){

                     toastr.error("Ocurrió un error al procesar la solicitud");                     
                  
                }

           });    

        },

        Update : function() {
          
            this.errors =[];        
            var urlRegistros = 'certificados/' + this.certificado_data.id  ;      
            axios({
              method: 'put',
              url : urlRegistros,    
              data : {
                'ot'                   : this.otdata, 
                'numero'                             : this.numero,                  
                'fecha'                              : this.fecha,
                'TablaPartesServicios'               : this.TablaPartesServicios,
                'TablaPartesProductosPorPlacas'      : this.TablaPartesProductosPorPlacas,     
                'TablaPartesProductosPorCosturas'    : this.TablaPartesProductosPorCosturas,               
          }}
           
        ).then(response => {
          this.response = response.data
          toastr.success('Certificado N°' +  this.numero_code + ' fue actualizado con éxito ');
           console.log(response.data);  
        }).catch(error => {
               
               this.errors = error.response.data.errors;
                console.log(error.response);
               $.each( this.errors, function( key, value ) {
                   toastr.error(value);
                   console.log( key + ": " + value );
               });

               if((typeof(this.errors)=='undefined') && (error)){

                     toastr.error("Ocurrió un error al procesar la solicitud");                     
                  
                }

           }); 

        }
       

      }
}
</script>

<style scoped>

.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
     background-color: #eee;
}
</style>