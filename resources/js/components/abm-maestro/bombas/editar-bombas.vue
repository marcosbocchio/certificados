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
                     <label for="designacion">Designación *</label>
                    <input v-model="editRegistro.designacion" type="text" name="designacion" class="form-control" value="">

                    <label for="marca">Marca *</label>
                    <input type="text" name="marca" class="form-control" v-model="editRegistro.marca" value="">

                    <label for="caudal">Caudal (CFM) *</label>
                    <input type="number" step="0.01" name="caudal" class="form-control" v-model="editRegistro.caudal" value="">

                    <label for="voltaje">Voltaje *</label>
                    <input type="number" name="voltaje" step="0.01" class="form-control" v-model="editRegistro.voltaje" value="">
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
                'designacion'  : '',
                'marca'  : '',
                'caudal':'',
                'voltaje':'',
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

                this.editRegistro.designacion = this.selectRegistro.designacion;
                this.editRegistro.marca = this.selectRegistro.marca;
                this.editRegistro.caudal=this.selectRegistro.caudal;
                this.editRegistro.voltaje=this.selectRegistro.voltaje;
                $('#editar').modal('show');

                this.$forceUpdate();
            })
            },

            storeRegistro: function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'bombas/' + this.selectRegistro.id;
                axios.put(urlRegistros, {

                ...this.editRegistro,


                }).then(response => {
                  this.$emit('update');
                  this.errors=[];
                  $('#editar').modal('hide');
                  toastr.success('Bomba editada con éxito');
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
