<template>
    <form v-on:submit.prevent="storeRegistro" method="post">
    <div class="modal fade" id="nuevo">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Crear</h4>
                </div>
                <div class="modal-body">


                    <label for="codigo">Código *</label>
                    <input autocomplete="off" v-model="newRegistro.codigo" type="text" name="codigo" class="form-control" value="">

                    <label for="name">Nombre *</label>
                    <input autocomplete="off" type="text" name="nombre" class="form-control" v-model="newRegistro.nombre" value="">

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
 import { eventNewRegistro } from '../../event-bus';
export default {

    props : {

        modelo : {
           type : String,
           required : false,
          }

    },
    data() { return {

        newRegistro : {
            'codigo'  : '',
            'nombre' : '',
         },
        errors:{},
        cliente_id:'',
         }

    },

    watch : {

        modelo : function(val){

            this.cliente_id = val.substring(val.lastIndexOf("/") + 1, val.length)

        },

    },

 created: function () {

    eventNewRegistro.$on('open',function(){

          this.openModal();

    }.bind(this))
    this.cliente_id = this.modelo.substring(this.modelo.lastIndexOf("/") + 1, this.modelo.length)
    },
    computed :{

         ...mapState(['url'])
    },


    methods: {
           openModal : function(){
                 console.log('entro en open modal nuevo');
                this.newRegistro = {
                        'codigo'  : '',
                        'nombre' : '',
                     },

                $('#nuevo').modal('show');
                $( document ).ready(function() {
                    setTimeout(function(){
                        $("#pass").attr('readonly', false);
                        $("#pass").focus();
                    },500);
                });
            },

            storeRegistro: function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'plantas/cliente/' + this.cliente_id;
                axios.post(urlRegistros, {

                ...this.newRegistro,
                'cliente_id' : this.cliente_id,


                }).then(response => {
                  this.$emit('store');
                  this.errors=[];
                  $('#nuevo').modal('hide');
                  toastr.success('Planta creada con éxito');
                  this.newRegistro={}

                }).catch(error => {
                    console.log(error);
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
