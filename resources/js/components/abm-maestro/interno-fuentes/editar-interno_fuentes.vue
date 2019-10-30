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

                    <label for="curie">Curie</label>
                    <input v-model="editRegistro.curie" type="number" name="curie" class="form-control" value="" step="2">                
              
                    <label for="name">Fuente (*)</label>      
                    <v-select v-model="fuente" label="codigo" :options="fuentes"></v-select>
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
            'curie' : '', 
            'activo_sn' : true,      
         },
         fuente :{
             'codigo' : '',
             'descripcion':''
         },       
        errors:{},        
         }
    
    },
    
 created: function () {    
     
    eventEditRegistro.$on('editar',function() {
         
                 this.openModal();
             
    }.bind(this)); 
   this.$store.dispatch('loadFuentes');

    },
  
    computed :{
    
         ...mapState(['url','fuentes'])
    }, 
   
    methods: {
           openModal : function(){
               console.log('entro en open modal');            
            this.$nextTick(function () { 

                this.editRegistro.nro_serie = this.selectRegistro.nro_serie;
                this.editRegistro.activo_sn = this.selectRegistro.activo_sn;  
                this.editRegistro.curie = this.selectRegistro.curie; 
                this.fuente = this.selectRegistro.fuente;               
              
                $('#editar').modal('show');               

                this.$forceUpdate();
            })
            },

            storeRegistro: function(){           

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'interno_fuentes/' + this.selectRegistro.id;                         
                axios.put(urlRegistros, {   
                    
                ...this.editRegistro,     
                'fuente' : this.fuente,                       
              
                }).then(response => {
                  this.$emit('update');
                  this.errors=[];
                  $('#editar').modal('hide');
                  toastr.success('Interno Fuente editado con éxito');         
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