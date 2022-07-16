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

                        <label for="name">Descripción *</label>
                        <input autocomplete="off" type="text" name="descripcion" class="form-control" v-model="editRegistro.descripcion" value="">

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
            'descripcion' : '',
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
                this.editRegistro.descripcion = this.selectRegistro.descripcion;
                this.editRegistro.updated_at = this.selectRegistro.updated_at;

                console.log(this.selectRegistro.cliente_id);

                $('#editar').modal('show');

                this.$forceUpdate();
            })
            },

            storeRegistro: function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'tipos_equipamiento/' + this.selectRegistro.id;
                axios.put(urlRegistros, {

                ...this.editRegistro,

                }).then(response => {
                  this.$emit('update');
                  this.errors=[];
                  $('#editar').modal('hide');
                  this.$showMessagePreset('success','code-edit');
                  this.editRegistro={}

                }).catch(error => {
                    console.log(error);
                    this.errors = error.response.data.errors;
                    $.each( this.errors, function( key, value ) {
                        this.$showMessages('error',[value]);
                        console.log( key + ": " + value );
                    }.bind(this));

                     if((typeof(this.errors)=='undefined') && (error)){

                    this.$showMessagePreset('error','code-500');
                }
                });
              }
        }

}
</script>