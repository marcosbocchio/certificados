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

                    <label for="designacion">Designación *</label>
                    <input v-model="newRegistro.designacion" type="text" name="designacion" class="form-control" value="">

                    <label for="marca">Marca *</label>
                    <input type="text" name="marca" class="form-control" v-model="newRegistro.marca" value="">

                    <label for="caudal">Caudal *</label>
                    <input type="number" step="0.01" name="caudal" class="form-control" v-model="newRegistro.caudal" value="">

                    <label for="voltaje">Voltaje *</label>
                    <input type="number" step="0.01" name="voltaje" class="form-control" v-model="newRegistro.voltaje" value="">

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
    data() { return {

        newRegistro : {
                    'designacion'  : '',
                    'marca'  : '',
                    'caudal':'',
                    'voltaje':'',
         },


        errors:{},
         }

    },
 created: function () {

    eventNewRegistro.$on('open', this.openModal)

    },
    computed :{

         ...mapState(['url'])
    },


    methods: {
           openModal : function(){

                this.newRegistro = {
                    'designacion'  : '',
                    'marca'  : '',
                    'caudal':'',
                    'voltaje':'',
                };


                $('#nuevo').modal('show');

            },

            storeRegistro: function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'bombas';
                axios.post(urlRegistros, {

                ...this.newRegistro,


                }).then(response => {
                  this.$emit('store');
                  this.errors=[];
                  $('#nuevo').modal('hide');
                  toastr.success('Bomba creada con éxito');
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
