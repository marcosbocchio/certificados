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
                
                   
                    <label for="numero_serie">N° Serie (*)</label>   

                    <input type="checkbox" id="checkbox" v-model="editRegistro.activo_sn" style="float:right"> 
                    <label for="tipo" style="float:right;margin-right: 5px;">ACTIVO</label>     

                    <input autocomplete="off" v-model="editRegistro.nro_serie" type="text" name="numero_serie" class="form-control" value="">

                    <label for="numero_interno">N° Interno (*)</label> 
                    <input autocomplete="off" v-model="editRegistro.nro_interno" type="text" name="numero_interno" class="form-control" value="">                  

                    <label for="equipos">Equipo (*)</label>      
                    <v-select v-model="equipo" label="codigo" :options="equipos"></v-select>              

                    <label>Fuente </label>
                    <v-select  v-model="interno_fuente" :options="interno_fuentes_activos" label="nro_serie">
                        <template slot="option" slot-scope="option">
                            <span class="upSelect">{{ option.nro_serie }}</span> <br> 
                            <span class="downSelect"> {{ option.fuente.codigo }} </span>
                        </template>
                    </v-select>                         

                    <label for="voltaje">Voltaje</label>
                    <input v-model="editRegistro.voltaje" type="number" name="voltaje" class="form-control" value="">   

                    <label for="amperaje">Amperaje</label>
                    <input v-model="editRegistro.amperaje" type="number" name="amperaje" class="form-control" value="">             
              
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
    
        editRegistro : {           
            'nro_serie'  : '',
            'nro_interno'  : '',
            'voltaje' : '', 
            'amperaje' : '', 
            'activo_sn' : true,      
         },
         equipo :'',          
         interno_fuente :'', 
        errors:{},        
         }
    
    },
    
 created: function () {    
     
    eventEditRegistro.$on('editar',function() {
         
                 this.openModal();
             
    }.bind(this)); 
   this.$store.dispatch('loadEquipos');
   this.$store.dispatch('loadInternoFuentesActivos');

    },
  
    computed :{
    
         ...mapState(['url','equipos','interno_fuentes_activos'])
    }, 
   
    methods: {
           openModal : function(){
           console.log('entro en open modal');            
            this.$nextTick(function () { 

                this.editRegistro.nro_serie = this.selectRegistro.nro_serie;
                this.editRegistro.nro_interno = this.selectRegistro.nro_interno;
                this.editRegistro.voltaje = this.selectRegistro.voltaje;
                this.editRegistro.amperaje = this.selectRegistro.amperaje;
                this.editRegistro.activo_sn = this.selectRegistro.activo_sn;  
                this.editRegistro.curie = this.selectRegistro.curie; 
                this.equipo = this.selectRegistro.equipo;   
                this.interno_fuente = this.selectRegistro.interno_fuente;             
              
                $('#editar').modal('show');               

                this.$forceUpdate();
            })
            },

            storeRegistro: function(){           

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'interno_equipos/' + this.selectRegistro.id;                         
                axios.put(urlRegistros, {   
                    
                ...this.editRegistro,     
                'equipo' : this.equipo,    
                'interno_fuente' : this.interno_fuente,                    
              
                }).then(response => {
                  this.$emit('update');
                  this.errors=[];
                  $('#editar').modal('hide');
                  toastr.success('Interno Equipo editado con éxito');         
                  this.editRegistro={}
                  
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