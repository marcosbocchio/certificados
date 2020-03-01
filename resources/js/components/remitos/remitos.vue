<template>
 <div class="row">
       <div class="col-md-12">
            <form @submit.prevent="editmode ?  Update() : Store()"  method="post">
                <informe-header :otdata="otdata"></informe-header>
                 <div class="box box-custom-enod">
                    <div class="box-body"> 
                             
                        <div class="col-md-6">
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
                                <label for="prefijo">Prefijo N° *</label>
                                <input type="number" v-model="prefijo" class="form-control" id="prefijo" @change="formatearPrefijo(prefijo,4)" min="1" max="9999" :disabled="interno_sn"/>
                            </div>                            
                        </div>  
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="numero">Remito N° *</label>
                               
                                <input type="checkbox" id="checkbox" v-model="interno_sn" style="float:right"> 
                                <label for="tipo" style="float:right;margin-right: 5px;">INTERNO</label>             
                               
                                <input type="number" v-model="numero" class="form-control" id="numero"  @change="formatearNumero(numero,8)" min="1" max="99999999" :disabled="interno_sn"/>
                            </div>                            
                        </div>  
                         <div class="clearfix"></div>  

                        <div class="col-md-6">
                            <div class="form-group" >
                                <label for="receptor">Receptor *</label>
                                <input type="text" v-model="receptor" class="form-control" id="receptor" maxlength="45">
                            </div>                            
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" >
                                <label for="destino">Lugar Destino *</label>
                                <input type="text" v-model="destino" class="form-control" id="destino" maxlength="100">
                            </div>                            
                        </div>
                    </div>
                 </div>   
                 <div class="box box-custom-enod">
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Productos</label>
                                <v-select v-model="producto" label="descripcion" :options="productos" id="productos" @input="getMedidasProducto()"></v-select>
                            </div>  
                        </div>  
                        <div class="col-md-3">
                            <div class="form-group">  
                            <label>Medidas</label>           

                            <v-select v-model="medida" :options="medidas" label="codigo">
                                <template slot="option" slot-scope="option">
                                    <span class="upSelect">{{ option.descripcion }} </span> 
                                    <span class="downSelect">   {{ option.codigo }} </span>
                                </template>
                            </v-select>
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group"> 
                                <label>Cant.</label>                 
                                <input v-model="cantidad_productos" type="number" class="form-control" id="cantidad_productos" placeholder="">
                            </div>
                        </div>      

                       <div class="clearfix"></div>  

                        <div class="col-md-1">                                               
                            <span>
                              <button type="button" @click="addProducto()"><span class="fa fa-plus-circle"></span></button> 
                            </span>                            
                        </div>
                        
                         <div class="form-group">
                            &nbsp;
                        </div>        

                            <div v-show="inputsProductos.length">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="col-md-7">Productos</th>                                         
                                                    <th class="col-md-2">Medidas</th>                     
                                                    <th class="col-md-2">cant</th>                    
                                                    <th class="col-md-1">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(inputsProducto,k) in inputsProductos" :key="k">
                                                    <td> {{ inputsProducto.producto.descripcion}}</td>                                                        
                                                    <td> {{ inputsProducto.medida.descripcion}}&nbsp; &nbsp; {{inputsProducto.medida.codigo }}</td>  
                                                    <td> {{ inputsProducto.cantidad_productos}}</td>                                  
                                                    <td style="text-align:center"> <i class="fa fa-minus-circle" @click="removeProducto(k)" ></i></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>   
                       </div>
                    </div>    
                    <div class="box box-custom-enod">
                        <div class="box-body">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Equipo *</label>
                                    <v-select  v-model="interno_equipo" :options="interno_equipos_activos" label="nro_interno">
                                        <template slot="option" slot-scope="option">
                                            <span class="upSelect">{{ option.nro_interno }}</span> <br> 
                                            <span class="downSelect"> {{ option.equipo.codigo }} </span>
                                        </template>
                                    </v-select>
                                </div>
                            </div>

                       <div class="clearfix"></div>  

                        <div class="col-md-1">                                               
                            <span>
                              <button type="button" @click="addEquipo(interno_equipo.id)"><span class="fa fa-plus-circle"></span></button> 
                            </span>                            
                        </div>
                        
                         <div class="form-group">
                            &nbsp;
                        </div>           

                        
                       
                            <div v-show="inputsEquipos.length">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th class="col-md-2">N° Int.</th>                                         
                                                <th class="col-md-9">Equipo</th>                                                             
                                                <th class="col-md-1">&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(inputsEquipo,k) in inputsEquipos" :key="k">
                                                <td> {{ inputsEquipo.nro_interno}}</td>                                                        
                                                <td> {{ inputsEquipo.equipo.codigo}}</td>                                                                          
                                                <td style="text-align:center"> <i class="fa fa-minus-circle" @click="removeEquipo(k)" ></i></td>
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


import { toastrWarning,toastrDefault } from '../toastrConfig';

import Datepicker from 'vuejs-datepicker';
import {mapState} from 'vuex';
import {en, es} from 'vuejs-datepicker/dist/locale'
export default {
    components: {

      Datepicker
      
    },

    props :{

      editmode : {
        type : Boolean,
        required : false,    
        default : false
      },  

      otdata : {
        type : Object,
        required : true
      },

      remitodata : {
        type : Object,
        required : false
      },

       detalledata : {
      type : [ Array ],  
      required : false
      },

      remito_interno_equipos_data : {
      type : [ Array ],  
      required : false
      }

    },
    data (){return{  

        errors:[],
         en: en,
         es: es, 
        interno_sn :true, 
        fecha:new Date(), 
        numero:'',
        prefijo:'1',
        receptor:'',
        destino:'',
        producto:'',
        medida:'',
        cantidad_productos:'',
        interno_equipo:'',        

        productos:[],
        medidas:[],
        inputsProductos:[],
        inputsEquipos:[],

        numero_formatedo:'',
        prefijo_formateado:''
    }},

    created : function() {

        this.getProductos();  
        this.$store.dispatch('loadInternoEquiposActivos');       
        this.setEdit();   

    },

    mounted : function() {

         this.getNumeroRemito();
    }, 

    watch :{

        interno_sn : function(val){

            if(val){
               
                this.getNumeroRemito();              
              
            }
        }
    },

    computed :{

        ...mapState(['url','AppUrl','interno_equipos_activos','interno_equipo_show']),
       
     },

    methods : {

        setEdit : function(){

            if(this.editmode) {               
            
               this.fecha   = this.remitodata.fecha;   
               this.interno_sn = this.remitodata.interno_sn;         
               this.numero = this.remitodata.numero;   
               this.prefijo = this.remitodata.prefijo;
               this.receptor = this.remitodata.receptor;
               this.destino = this.remitodata.destino;
               this.inputsProductos = this.detalledata;  
               this.inputsEquipos = this.remito_interno_equipos_data;              
               this.formatearPrefijo(this.prefijo,4);
               this.formatearNumero(this.numero,8);

            }      

        },   

        getNumeroRemito:function(){            
           
            if(!this.editmode) {           

                        axios.defaults.baseURL = this.url ;
                        var urlRegistros = 'remitos/ot/' + this.otdata.id +'/generar-numero-remito'  + '?api_token=' + Laravel.user.api_token;         
                        axios.get(urlRegistros).then(response =>{
                        this.numero_remito_generado = response.data 
                        
                   
                            if(this.numero_remito_generado.length){

                                this.numero =  this.numero_remito_generado[0].numero_remito
                            }else{

                                this.numero = 1;
                            } 

                            this.prefijo = '0'
                            this.formatearPrefijo(this.prefijo,4);        
                            this.formatearNumero(this.numero,8);
                        
                        });   
             }
        },  

        formatearPrefijo : function ( number, width )
                {

                    width -= number.toString().length;
                    if ( width > 0 )
                    {
                       this.prefijo=  new Array( width + (/\./.test( number ) ? 2 : 1) ).join( '0' ) + number;
                    }
                  

                },
         formatearNumero : function ( number, width )
                {

                    width -= number.toString().length;
                    if ( width > 0 )
                    {
                       this.numero=  new Array( width + (/\./.test( number ) ? 2 : 1) ).join( '0' ) + number;
                    }
                  

                },

        getProductos : function(){
                
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'productos' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.productos = response.data
                }); 
                },

        getMedidasProducto : function(){
                    this.medida = '';               
                    axios.defaults.baseURL = this.url ;
                    var urlRegistros = 'medidas/' + this.producto.unidades_medida_id + '?api_token=' + Laravel.user.api_token;         
                    axios.get(urlRegistros).then(response =>{
                    this.medidas = response.data
                    });
                },

        addProducto(index) {

            
            if(!this.producto){
                toastr.error("El campo producto es obligatorio");         
                 return;            
            }

            if(!this.medida){
                    toastr.error("El campo medida es obligatorio");         
                    return;            
            }

            if(!this.cantidad_productos){
                 toastr.error("El campo cantidad de producto es obligatorio");         
                 return;            
            }

                this.inputsProductos.push({ 
                    producto:this.producto,             
                    medida : this.medida,              
                    cantidad_productos:this.cantidad_productos,             
                    });
                this.producto='',        
                this.medida ='',       
                this.cantidad_productos='1'

            },

        existeEquipo : function(id){

            let existe = false;
            this.inputsEquipos.forEach(function (item) {           
               
                if(item.id == id){              
                    existe = true ;
                }
                
            });

            return existe;
        },    

        addEquipo(id) {        
                
        
            if (this.existeEquipo(id)){
                    toastr.error('El Equipo existe en el Remito');  
            }else if(this.interno_equipo){
                
                this.inputsEquipos.push({ 

                    ... this.interno_equipo,       
                        
                    });
                this.getUbicacionEquipo()
                this.interno_equipo=''; 
            }


         },

        getUbicacionEquipo() {
           
         
                  this.$store.dispatch('loadUbicacionInternoEquipo',this.interno_equipo.id)
                  .then(() => {
                    console.log('entro en get ubicacion');    
                    console.log(this.interno_equipo_show.ot_id + ' = ' + this.otdata.id);
                    if((this.interno_equipo_show.ot_id != null) && (this.interno_equipo_show.ot_id !=this.otdata.id)){
                        toastr.options = toastrWarning;
                        toastr.warning('El Equipo ' + this.interno_equipo_show.nro_interno + ' se encuentra en la OT N° ' + this.interno_equipo_show.ot.numero);  
                        toastr.options = toastrDefault;
                    }
                    });

        },
        removeProducto(index) {
            this.inputsProductos.splice(index, 1);
        },

        removeEquipo(index) {
            this.inputsEquipos.splice(index, 1);
        },

        Store : function(){
         
          this.errors =[];
          
            var urlRegistros = 'remitos' ;      
            axios({
              method: 'post',
              url : urlRegistros,    
              data : {             
                'ot'              : this.otdata,      
                'interno_sn'      :this.interno_sn,         
                'fecha'           : this.fecha,
                'prefijo'         : this.prefijo,
                'numero'          : this.numero,     
                'receptor'        : this.receptor,
                'destino'         : this.destino,          
                'detalles'        : this.inputsProductos,  
                'interno_equipos'         : this.inputsEquipos,  
          }
          
          }).then(response => {

          let remito = response.data;
          toastr.success('Remito N° ' +  this.prefijo + '-' + this.numero + ' fue creado con éxito ');
          window.open( this.AppUrl + '/api/pdf/remito/' + remito.id,'_blank');
          window.location.href = this.AppUrl + '/remitos/ot/' + this.otdata.id;
    
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

            console.log('entro para actualizar' );
            this.errors =[];        
            var urlRegistros = 'remitos/' + this.remitodata.id  ;      
            axios({
              method: 'put',
              url : urlRegistros,    
              data : {
                'ot'              : this.otdata,    
                'interno_sn'      :this.interno_sn,   
                'fecha'           : this.fecha,
                'prefijo'         : this.prefijo,
                'numero'          : this.numero,     
                'receptor'        : this.receptor,
                'destino'         : this.destino,          
                'detalles'        : this.inputsProductos,
                'interno_equipos' : this.inputsEquipos,  
                     
          }}
          
      
        ).then(response => {
          this.response = response.data
          toastr.success('Remito N° ' +  this.prefijo + '-' +this.numero + ' fue actualizado con éxito ');
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
