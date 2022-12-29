<template>
<div>
    <form>
        <div class="modal fade" id="cambiar-numero">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modificacion N°</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="numero_informe">Informe N°</label>
                                    <input autocomplete="off" type="text" name="numero_informe" v-model="registro.numero" class="form-control">
                               </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="cambiarNumero" data-dismiss="modal" >Guardar</button>
                        <button type="button" class="btn btn-default" name="button" data-dismiss="modal" >Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</template>

<script>
import {mapState} from 'vuex'
import { eventModal } from '../../event-bus';
import moment from 'moment';

export default {

    data() {return {

        registros :{},
        ot :{},
        loading:false,
        registro: 0,
    }},

    created: function () {

        eventModal.$on('open_cambio_numero',function(registro,ot_data) {
            this.registro = registro ;
            this.ot = ot_data;
            this.openModal();
        }.bind(this));

    },

    computed :{

       ...mapState(['url']),

    },

    methods: {

        openModal : function(){

            $('#cambiar-numero').modal('show');
        },

        getResults : function(page = 1){
            this.registros = [];
            this.loading = true,
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'informes/revisiones/ot/' + this.registro.ot_id + '/metodo/' + this.registro.metodo + '/informe_id/' + this.registro.id + '?page='+ page + '&api_token=' + Laravel.user.api_token;
            console.log(urlRegistros);
            axios.get(urlRegistros).then(response =>{

                console.log(response.data);
                this.registros = response.data

            }).finally(() =>

                this.loading = false,
                )
            this.$forceUpdate();

        },
        cambiarNumero: function () {
            var urlRegistros = 'informes/' + this.registro.id + '/cambiar_numero';
            axios.put(urlRegistros, {
                'nuevoNumero': this.registro.numero,
            }).then(response => {
                  this.$emit('actualizarTabla')
                  toastr.success('Numero Informe editado con éxito');
                }).catch(error => {
                    this.errors = error.response.data.errors;
                    $.each( this.errors, function( key, value ) {
                        toastr.error(value);
                        console.log( key + ": " + value );
                    });

                     if((typeof(this.errors)=='undefined') && (error)){

                     toastr.error("Ocurrió un error al procesar la solicitud");

                }
                })
        },
        moment: function (date) {

            return date ? moment(date).format('DD/MM/YYYY') : null;
        }
    }

  }
</script>

<style scoped>

.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
     background-color: #eee;
}
</style>
