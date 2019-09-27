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
                    
                           
                     <div class="form-group">
                        <label for="codigo">Visible OT</label>             
                        <input type="checkbox" id="checkbox" v-model="editRegistro.visible_ot"> 
                    </div>

                    <label for="codigo">Código (*)</label>                   
                    <input autocomplete="off" v-model="editRegistro.codigo" type="text" name="codigo" class="form-control" value="">
                    
                    <label for="name">Descripción</label>                   
                    <input autocomplete="off" type="text" name="descripcion" class="form-control" v-model="editRegistro.descripcion" value="">

                     <label for="name">Unidad Medida (*)</label>      
                    <v-select v-model="unidad_medida" label="codigo" :options="unidades_medidas"></v-select>
                    
                  
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
            'codigo'  : '',
            'descripcion' : '',           
         },

         unidad_medida :{},     
         errors:{},        
         }
    
    },
 created: function () {    
     
    eventEditRegistro.$on('editar',function() {
         
                 this.openModal();
             
    }.bind(this)); 
   this.$store.dispatch('loadUnidadesMedidas');
    },
  
    computed :{
    
         ...mapState(['url','unidades_medidas'])
    }, 
   
    methods: {
           openModal : function(){
               console.log('entro en open modal');            
            this.$nextTick(function () { 
                this.editRegistro.codigo = this.selectRegistro.codigo;
                this.editRegistro.descripcion = this.selectRegistro.descripcion;   
                this.editRegistro.visible_ot  =this.selectRegistro.visible_ot;
                this.unidad_medida = this.selectRegistro.unidad_medidas;            

                console.log(this.selectRegistro.cliente_id);
              
                $('#editar').modal('show');               

                this.$forceUpdate();
            })
            },

            storeRegistro: function(){           

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'productos/' + this.selectRegistro.id;                         
                axios.put(urlRegistros, {   
                    
                ...this.editRegistro,    
                'unidad_medida' : this.unidad_medida,                       
              
                }).then(response => {
                  this.$emit('update');
                  this.errors=[];
                  $('#editar').modal('hide');
                  toastr.success('producto editado con éxito');         
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