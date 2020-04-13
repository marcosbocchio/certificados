<template>
    <div>
     
          <!-- small box -->
          <div class="small-box bg-custom-4">
            <div class="inner">
              <h3>{{ ot_documentaciones.length }}</h3>
              <p>Documentaciones</p>
            </div>
            <div class="icon">
              <i class="fa fa-file-pdf-o"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
          <div class="clearfix"></div>

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
                                        <th>TÍTULO</th>                                                     
                                        <th>DESCRIPCIÓN</th>
                                        <th colspan="2">&nbsp;</th>
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
    <div class="clearfix"></div> 
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
     

    ot_data : {
    type : Object,
    required : false
     },
    
  }, 

data () { return {

      ot_documentaciones :[],
      documentaciones:[],
      documentacion:''

    }    
  },
  computed :{

       ...mapState(['url','AppUrl'])
    },

  created : function(){
    
    this.ot_documentaciones =  JSON.parse(JSON.stringify(this.documentaciones_data));  
    this.getDocumentaciones();

  },
methods : {

  getDocumentaciones : function(){
             
        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'documentaciones/ot?api_token=' + Laravel.user.api_token;        
        axios.get(urlRegistros).then(response =>{
        this.documentaciones = response.data
        });
             
  },

  addDocumentacion : function(id){

      console.log('entro en add soldador');
        if (this.existeDocumentacion(id)){
                toastr.error('El Documento ya existe en la OT');  
        }else if(this.documentacion.id){
               console.log('agregando soldador');
            this.ot_documentaciones.push({ 
                 ...this.documentacion
            });
            this.documentacion = '';
        }


  },

  removeDocumentacion: function(index){

         this.ot_documentaciones.splice(index, 1);        

    },
  
  existeDocumentacion : function(id){

        let existe = false;
        this.ot_documentaciones.forEach(function (documento) {           
            console.log(documento.id,'==',id);
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