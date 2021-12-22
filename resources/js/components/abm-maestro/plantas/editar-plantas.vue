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

                    <div class="modal-body">

                        <label for="codigo">Código *</label>
                        <input autocomplete="off" v-model="editRegistro.codigo" type="text" name="codigo" class="form-control" value="">

                        <label for="name">Nombre *</label>
                        <input autocomplete="off" type="text" name="nombre" class="form-control" v-model="editRegistro.nombre" value="">

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

        editRegistro : {
            'codigo'  : '',
            'nombre' : '',
         },
        errors:{},
         }

    },
 created: function () {

    eventEditRegistro.$on('editar',function() {

                 this.openModal();

    }.bind(this));


    },

    computed :{

         ...mapState(['url'])
    },

    methods: {
           openModal : function(){
               console.log('entro en open modal');
            this.$nextTick(function () {
                this.editRegistro.codigo = this.selectRegistro.codigo;
                this.editRegistro.nombre = this.selectRegistro.nombre;

                $('#editar').modal('show');
                this.$forceUpdate();
            })
            },

            storeRegistro: function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'plantas/' + this.selectRegistro.id;
                axios.put(urlRegistros, {

                ...this.editRegistro,

                }).then(response => {
                  this.$emit('update');
                  this.errors=[];
                  $('#editar').modal('hide');
                  toastr.success('Planta editada con éxito');
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
