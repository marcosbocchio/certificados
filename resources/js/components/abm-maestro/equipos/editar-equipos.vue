<template>
    <form v-on:submit.prevent="storeRegistro" method="post">
    <div class="modal fade" id="editar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar</h4>
                </div>

                <div class="modal-body">                    

                   <div class="col-md-12">
                     <div class="form-group">                   
                        <label for="codigo">Código *</label>                   
                        <input autocomplete="off" v-model="Registro.codigo" type="text" name="codigo" class="form-control" value="">
                     </div>
                   </div>
                    
                   <div class="col-md-12">
                     <div class="form-group">
                        <label for="name">Descripción</label>                   
                        <input autocomplete="off" type="text" name="descripcion" class="form-control" v-model="Registro.descripcion" value="">  
                     </div>
                   </div>
            

                   <div class="col-md-12">
                        <div class="form-group">
                            <label for="metodo_ensayo">Método de Ensayo *</label>
                            <input v-if="metodo_ensayos.metodo == 'US'" type="checkbox" id="checkbox" v-model="Registro.palpador_sn" style="float:right"> 
                            <label v-if="metodo_ensayos.metodo == 'US'" for="tipo" style="float:right; margin-right: 5px;">PALPADOR</label>
                            
                            <!-- v-select with metodo and descripcion -->
                            <v-select 
                                v-model="metodo_ensayos" 
                                label="metodo" 
                                :options="metodos_ensayos" 
                                @input="resetInstrumentoMedicion">
                                <template slot="option" slot-scope="option">
                                    <span class="upSelect">{{ option.metodo }}</span> <br>
                                    <span class="downSelect">{{ option.descripcion }}</span>
                                </template>
                                <template slot="selected-option" slot-scope="option">
                                    <span>{{ option.metodo }} - {{ option.descripcion }}</span>
                                </template>
                            </v-select>
                        </div>
                    </div>

                    <div class="col-md-12">
                       <div class="form-group">          
                          <label v-if="metodo_ensayos.metodo == 'RI'" for="instrumento_medicion">Tipo Equipamiento *</label>
                          <label v-else for="instrumento_medicion">Tipo Equipamiento</label>
                          <v-select v-model="tipo_equipamiento" :options="tipos_equipamiento" label="codigo"></v-select>
                       </div>
                    </div>            

                    <div class="col-md-12">
                       <div class="form-group">          
                          <label for="instrumento_medicion">Instrumento Medición </label>
                          <v-select v-model="Registro.instrumento_medicion" :options="instrumentos_mediciones" :disabled="((metodo_ensayos.metodo != 'LP') && (metodo_ensayos.metodo != 'PM'))"></v-select>
                       </div>
                    </div>

                </div>
            
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Guardar">
                    <button type="button" class="btn btn-default" name="button" data-dismiss="modal" >Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</template>

<script>
 import {mapState} from 'vuex'
 import { eventEditRegistro } from '../../event-bus';
 export default {

    props : {

        selectRegistro : {
          type : Object,
          required : false,           
        }

    },
    data() { return {
    
        Registro : {           
            'codigo': '',
            'descripcion': '',
            'instrumento_medicion': '',     
            'palpador_sn':false,      
        
         },
         tipo_equipamiento: '',
         instrumentos_mediciones :  ['Luxómetro luz blanca','Lampara luz UV'] ,
         metodo_ensayos :'',          
         errors:{},        
        }    
    },
    
     created: function () {         
        eventEditRegistro.$on('editar',function() { this.openModal(); }.bind(this)); 
        this.$store.dispatch('loadMetodosEnsayos');
        this.$store.dispatch('loadTiposEquipamiento');
    },
  
    computed :{    
        ...mapState(['url','metodos_ensayos','tipos_equipamiento'])
    }, 
   
    methods: {
           openModal : function(){
               
                this.$nextTick(function () { 

                    this.Registro.codigo = this.selectRegistro.codigo;
                    this.Registro.descripcion = this.selectRegistro.descripcion;
                    this.Registro.palpador_sn = this.selectRegistro.palpador_sn;         
                    this.Registro.instrumento_medicion = this.selectRegistro.instrumento_medicion;         
                    this.metodo_ensayos = this.selectRegistro.metodo_ensayos;   
                    this.tipo_equipamiento = this.selectRegistro.tipo_equipamiento;                
                    $('#editar').modal('show');    
                    this.$forceUpdate();
                })
            },

            resetInstrumentoMedicion : function () {               
             
                this.Registro.instrumento_medicion = '';
               
            },   

            storeRegistro: function(){           

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'equipos/' + this.selectRegistro.id;                         
                axios.put(urlRegistros, {                       
                    ...this.Registro,     
                    'tipo_equipamiento': this.tipo_equipamiento,         
                    'metodo_ensayos' : this.metodo_ensayos,               
                }).then(response => {
                    this.$emit('update');
                    this.errors= [];
                    $('#editar').modal('hide');
                    toastr.success('Equipo editado con éxito');         
                    this.Registro= {}                  
                }).catch(error => {                   
                    this.errors = error.response.data.errors;
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