<template>
    <div class="row">    
        
       <div class="col-lg-3 col-xs-6">
          <cuadro-enod
              :titulo = "'VEHÍCULO / DOC.'"
              :class_color_titulo = "'color_titulo_2'"
              :cantidad_1 ="ot_vehiculos.length"
              :cantidad_2 ="ot_documentaciones.length"
              :src_icono ="'/img/tablero/icono-enod-documentacion.svg'"
              :class_color_cuadro = "'bg-custom-4'"   
              :habilitado_sn ="true"
          >
          </cuadro-enod>
       </div>

        <div class="clearfix"></div>

        <div class="col-md-12">
            <div v-show="$can('T_doc_actualiza')">
                <div class="box box-custom-enod">
                    <div class="box-body">  
                        <div class="form-group">
                            <label>Vehículos</label>             
                            <v-select  v-model="vehiculo" :options="vehiculos" label="nro_interno">
                                <template slot="option" slot-scope="option">
                                    <span class="upSelect">{{ option.nro_interno }} </span> <br> 
                                    <span class="downSelect"> {{ option.marca }} - {{ option.patente }} </span>
                                </template>
                            </v-select>      
                        </div> 
                        <div class="form-group">                    
                            <span>
                            <button type="button" @click="addVehiculo(vehiculo.id)"><span class="fa fa-plus-circle"></span></button> 
                            </span>
                        </div>
                    </div>                
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="box box-custom-enod top-buffer">
                <div class="box-header with-border">
                <h3 class="box-title">VEHÍCULOS ASIGNADOS A LA ORDEN DE TRABAJO</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>                       
                </div>
                </div>
                <div class="box-body">                        
                    <div class="table-responsive">          
                        <table class="table table-hover table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th>N° INT.</th>                                                     
                                    <th>MARCA</th>
                                    <th>MODELO</th>
                                    <th>PATENTE</th>
                                    <th>TIPO</th>
                                    <th colspan="1">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item,k) in ot_vehiculos" :key="k" :class="{selected: index_vehiculo == k}" class="pointer"  @click="selectVehiculo(k)">                                 
                                    <td> {{item.nro_interno}}</td>     
                                    <td> {{item.marca}}</td>    
                                    <td> {{item.modelo}}</td>
                                    <td> {{item.patente}}</td>
                                    <td> {{item.tipo}}</td> 
                                    <td> <i class="fa fa-minus-circle" @click="removeVehiculo(k)" ></i></td>
                                </tr>                       
                                
                            </tbody>
                        </table>                     
                    </div>
                </div> 
            </div> 
        </div>
    
        <div class="col-md-12">
 
            <div class="box box-custom-enod top-buffer">
                <div class="box-header with-border">
                <h3 class="box-title">DOCUMENTACIONES DEL VEHÍCULO</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>                       
                </div>
                </div>
                <div class="box-body">                        
                    <div class="table-responsive">          
                        <table class="table table-hover table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th class="col-md-2">TÍTULO</th>                                                     
                                    <th class="col-md-9">DESCRIPCIÓN</th>
                                     <th class="col-md-1">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item,k) in vehiculos_documentaciones" :key="k">                                 
                                    <td> {{item.titulo}}</td>     
                                    <td> {{item.descripcion}}</td>     
                                    <td width="10px"> <a :href="AppUrl + '/' + item.path " target="_blank" title="Imagen"><span class="fa fa-file-image-o"></span></a></td>
                                </tr>                                     
                            </tbody>
                        </table>                     
                    </div>
                </div> 
            <div v-if="isLoadingC" class="overlay">
                <loading-spin></loading-spin>
            </div>
            </div> 
        </div>   

        <div class="col-md-12">
            <div v-show="$can('T_doc_actualiza')">
                <div class="box box-custom-enod">
                    <div class="box-body">  
                        <div class="form-group">
                            <label>Documentaciones</label>             
                            <v-select v-model="documentacion" :options="documentaciones" label="titulo">
                                <template slot="option" slot-scope="option">
                                    <span class="upSelect">{{ option.titulo }} </span> <br> 
                                    <span class="downSelect"> {{ option.descripcion }} </span>
                                </template>
                            </v-select>        
                        </div> 
                        <div class="form-group">                    
                            <span>
                            <button type="button" @click="addDocumentacion(documentacion.id)"><span class="fa fa-plus-circle"></span></button> 
                            </span>
                        </div>
                    </div>                
                </div>
            </div>
        </div>

        <div class="col-md-12">
 
            <div class="box box-custom-enod top-buffer">
                <div class="box-header with-border">
                <h3 class="box-title">DOCUMENTACIONES ASIGNADAS A LA ORDEN DE TRABAJO</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>                       
                </div>
                </div>
                <div class="box-body">                        
                    <div class="table-responsive">          
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th class="col-md-2">TÍTULO</th>                                                     
                                    <th class="col-md-9">DESCRIPCIÓN</th>
                                    <th colspan="1">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(ot_documentacion,k) in ot_documentaciones" :key="k">                                 
                                    <td> {{ot_documentacion.titulo}}</td>     
                                    <td> {{ot_documentacion.descripcion}}</td>     
                                    <td width="10px"> <a :href="AppUrl + '/' + ot_documentacion.path " target="_blank" title="Imagen"><span class="fa fa-file-image-o"></span></a></td>
                                    <td> <i class="fa fa-minus-circle" @click="removeDocumentacion(k)" ></i></td>
                                </tr>                       
                                
                            </tbody>
                        </table>                     
                    </div>
                </div> 
            </div> 
            <div v-show="$can('T_doc_actualiza')">
                <button class="btn btn-primary" v-on:click.prevent="submit()">Actualizar</button>                     
            </div> 
        </div>   
    </div>   
</template>

<script>
import {mapState} from 'vuex'
export default {
    props :{

    documentaciones_data : {
    type : Array,
    required : false

     },  
     
    vehiculos_data : {
    type : Array,
    required : false

     },

    ot_data : {
    type : Object,
    required : false
     },
    
  }, 

data () { return {

      ot_documentaciones :[],
      documentaciones:[],
      vehiculos_documentaciones:[],
      ot_vehiculos:[],
      documentacion:'',
      vehiculo:'',
      index_vehiculo :'-1',
      isLoadingC : false,

    }    
  },
  computed :{

       ...mapState(['url','AppUrl','vehiculos'])
    },

  created : function(){
    
    this.ot_documentaciones =  JSON.parse(JSON.stringify(this.documentaciones_data));  
    this.ot_vehiculos =  JSON.parse(JSON.stringify(this.vehiculos_data));
    this.getDocumentaciones();
    this.$store.dispatch('loadVehiculos');    

  },
methods : {

    selectVehiculo :  function(k){

        this.index_vehiculo = k ;
        let id = this.ot_vehiculos[k].id ;
        this.isLoadingC  = true;
        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'documentaciones/vehiculos/' + id + '?api_token=' + Laravel.user.api_token;      
        axios.get(urlRegistros).then(response =>{

                this.vehiculos_documentaciones = response.data              
                this.isLoadingC  = false;
            });  
        
    },  

  getDocumentaciones : function(){
             
        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'documentaciones/ot?api_token=' + Laravel.user.api_token;        
        axios.get(urlRegistros).then(response =>{
        this.documentaciones = response.data
        });
             
  },

  addVehiculo : function(id){

        if (this.existeVehiculo(id)){

           toastr.error('El Vehículo ya existe en la OT');  

        }else if(this.vehiculo.id){

            this.ot_vehiculos.push({ 
                 ...this.vehiculo
            });

            this.vehiculo = '';
        }
  },

  addDocumentacion : function(id){

        if (this.existeDocumentacion(id)){

             toastr.error('El Documento ya existe en la OT');  

        }else if(this.documentacion.id){

            this.ot_documentaciones.push({ 
                 ...this.documentacion
            });

            this.documentacion = '';
        }
  },

  removeDocumentacion: function(index){

         this.ot_documentaciones.splice(index, 1);        

    },

  removeVehiculo: function(index){

         this.ot_vehiculos.splice(index, 1);        

    },

  existeVehiculo : function(id){

        let existe = false;
        console.log(id);
        this.ot_vehiculos.forEach(function (vehiculo) {           
            if(vehiculo.id == id){              
                existe = true ;
            }
            
        });

        return existe;
    },
  
  existeDocumentacion : function(id){

        let existe = false;
        this.ot_documentaciones.forEach(function (documento) {           
            if(documento.id == id){              
                existe = true ;
            }
            
        });

        return existe;
    },

  submit :function () {
       

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'ot_documentaciones';  
                        
            axios.post(urlRegistros, {   
                    
                documentaciones : this.ot_documentaciones,
                vehiculos : this.ot_vehiculos,
                ot : this.ot_data                

            }).then(response => {            
                this.errors=[];     
                console.log(response);                  
                toastr.success('Documentación OT actualizada con éxito');                
                
            }).catch(error => {
               
                this.errors = error.response.data.errors;                 
                $.each( this.errors, function( key, value ) {
                    toastr.error(value,key);
                    console.log( key + ": " + value );
                });
                
                if(this.errors = [] && error){

                     toastr.error("Ocurrio un error al procesar la solicitud");                     
                     this.ot_documentaciones = this.documentaciones_data;   
                }
  
            });
        }  
}
}
</script>