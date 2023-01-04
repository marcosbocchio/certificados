<template>
<div>
    <form>
        <div class="modal fade" id="clonacion-masiva">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Clonación Masiva</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="numero_informe">Desde</label>
                                    <input type="number" name="desde" v-model="desde" class="form-control">
                               </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="numero_informe">Hasta</label>
                                    <input type="number" name="desde" v-model="hasta" class="form-control">
                               </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="ClonacionMasiva" data-dismiss="modal" >Clonar</button>
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
        desde: 0,
        hasta: 0,
    }},

    created: function () {

        eventModal.$on('open_clonacion_masiva',function() {
            this.openModal();
        }.bind(this));

    },

    computed :{

       ...mapState(['url']),

    },

    methods: {

        openModal : function(){

            $('#clonacion-masiva').modal('show');
        },

        ClonacionMasiva: function () {
            if(parseFloat(this.hasta) < parseFloat(this.desde)){
                this.$showMessages('error',['El número final debe ser menor al número inicial.']);
            } else {
                this.$emit('actualizarTabla',parseFloat(this.desde),parseFloat(this.hasta))
            }
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
