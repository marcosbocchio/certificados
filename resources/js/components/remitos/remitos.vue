<template>
 <div class="row">
       <div class="col-md-12">
            <form @submit.prevent="editmode ?  Update() : Store()"  method="post">
                <informe-header :otdata="otdata"></informe-header>
                 <div class="box box-danger">
                    <div class="box-body">  
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha">Fecha (*)</label>
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
                                <label for="prefijo">Prefijo N° (*)</label>
                                <input type="number" v-model="prefijo" class="form-control" id="prefijo" @change="formatearPrefijo(prefijo,4)" min="1" max="9999"/>
                            </div>                            
                        </div>  
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="numero">Remito N° (*)</label>
                                <input type="number" v-model="numero" class="form-control" id="numero"  @change="formatearNumero(numero,8)" min="1" max="99999999"/>
                            </div>                            
                        </div>  
                        <div class="col-md-6">
                            <div class="form-group" >
                                <label for="receptor">Receptor (*)</label>
                                <input type="text" v-model="receptor" class="form-control" id="receptor" maxlength="45" >
                            </div>                            
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" >
                                <label for="destino">Lugar Destino (*)</label>
                                <input type="text" v-model="destino" class="form-control" id="destino" maxlength="100">
                            </div>                            
                        </div>
                    </div>
                 </div>   
                 <div class="box box-danger">
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

                            <v-select v-model="medida" :options="medidas" label="descripcion">
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
                        <div class="col-md-1"> 
                            <div class="form-group">                    
                            <span>
                                <i class="fa fa-plus-circle" @click="addProducto()"></i>
                            </span>
                            </div>
                        </div> 
                            <div v-show="inputsProductos.length">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>
                                            <th style="width: 500px">Productos</th>                                         
                                            <th>Medidas</th>                     
                                            <th>cant</th>                    
                                            <th colspan="2">&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(inputsProducto,k) in inputsProductos" :key="k">
                                                <td> {{ inputsProducto.producto.descripcion}}</td>                                                        
                                                <td> {{ inputsProducto.medida.descripcion}}&nbsp; &nbsp; {{inputsProducto.medida.codigo }}</td>  
                                                <td> {{ inputsProducto.cantidad_productos}}</td>                                  
                                                <td> <i class="fa fa-minus-circle" @click="removeProducto(k)" ></i></td>
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
      }

    },
    data (){return{  

        errors:[],
         en: en,
         es: es, 

        fecha:'',
        numero:'',
        prefijo:'',
        receptor:'',
        destino:'',
        producto:'',
        medida:'',
        cantidad_productos:'',

        productos:[],
        medidas:[],
        inputsProductos:[],

        numero_formatedo:'',
        prefijo_formateado:''
    }},

     created : function() {

        this.getProductos();  
        this.setEdit();   

    },

    computed :{

        ...mapState(['url','AppUrl']),


       
     },

    methods : {

        setEdit : function(){

            if(this.editmode) {               
            
               this.fecha   = this.remitodata.fecha;            
               this.numero = this.remitodata.numero;   
               this.prefijo = this.remitodata.prefijo;
               this.receptor = this.remitodata.receptor;
               this.destino = this.remitodata.destino;
               this.inputsProductos = this.detalledata;   
                
              this.formatearPrefijo(this.prefijo,4);
              this.formatearNumero(this.numero,8);

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
                this.inputsProductos.push({ 
                    producto:this.producto,             
                    medida : this.medida,              
                    cantidad_productos:this.cantidad_productos,             
                    });
                this.producto='',        
                this.medida ='',       
                this.cantidad_productos='1'

            },

        removeProducto(index) {
            this.inputsProductos.splice(index, 1);
        },

        Store : function(){
         
          this.errors =[];
          
            var urlRegistros = 'remitos' ;      
            axios({
              method: 'post',
              url : urlRegistros,    
              data : {             
                'ot'              : this.otdata,            
                'fecha'           : this.fecha,
                'prefijo'         : this.prefijo,
                'numero'          : this.numero,     
                'receptor'        : this.receptor,
                'destino'         : this.destino,          
                'detalles'        : this.inputsProductos,    
          }
          
          }).then(response => {
          this.response = response.data
          toastr.success('Remito N° ' +  this.prefijo + '-' + this.numero + ' fue creado con éxito ');
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

            console.log('entro para actualizar' );
            this.errors =[];        
            var urlRegistros = 'remitos/' + this.remitodata.id  ;      
            axios({
              method: 'put',
              url : urlRegistros,    
              data : {
                'ot'              : this.otdata,            
                'fecha'           : this.fecha,
                'prefijo'         : this.prefijo,
                'numero'          : this.numero,     
                'receptor'        : this.receptor,
                'destino'         : this.destino,          
                'detalles'        : this.inputsProductos,                     
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
