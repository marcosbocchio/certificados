<template>
<div>
    <form v-on:submit.prevent="storeRegistro" method="post">
        <div class="modal fade" id="revisiones-informes">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Revisiones</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="numero_ot">OT Nº</label>
                                    <input autocomplete="off" type="text" name="numero_ot" v-model="ot.numero" class="form-control" disabled>
                               </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="numero_informe">Informe N°</label>
                                    <input autocomplete="off" type="text" name="numero_informe" v-model="registro_revisiones.numero_formateado" class="form-control" disabled>
                               </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-custom-enod top-buffer">
                                    <div class="box-body no-padding">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Revisiones del informe</h3>
                                    </div>
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped table-condensed">
                                            <thead>
                                                <tr>
                                                    <th>Nº Rev.</th>
                                                    <th>Usuario alta</th>
                                                    <th>Fecha</th>
                                                    <th class="col-lg-1">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr v-for="(registro,k) in registros.data" :key="k">
                                                    <td>{{ registro.revision}}</td>
                                                    <td>{{ registro.name }}</td>
                                                    <td>{{moment(registro.fecha)}}</td>
                                                    <td width="10px"> <a :href="'/pdf/informe/' + registro.id " target="_blank"  class="btn btn-default btn-sm" title="Informe"><span class="fa fa-file-pdf-o"></span></a></td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        <div v-if="loading" class="overlay">
                                            <loading-spin></loading-spin>
                                        </div>
                                        </div>

                                        <pagination
                                                :data="registros" @pagination-change-page="getResults" :limit="3" >
                                                <span slot="prev-nav">&lt; Previous</span>
                                                <span slot="next-nav">Next &gt;</span>
                                        </pagination>

                                    </div>

                                </div>
                            </div>
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
        registro_revisiones: 0,
    }},

    created: function () {

        eventModal.$on('open_revisiones',function(registro,ot_data) {
            this.registro_revisiones = registro ;
            this.ot = ot_data;
            this.openModal();

        }.bind(this));

    },

    computed :{

       ...mapState(['url']),

    },

    methods: {

        openModal : function(){

            $('#revisiones-informes').modal('show');
            this.getResults();
        },

        getResults : function(page = 1){
            this.registros = [];
            this.loading = true,
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'informes/revisiones/ot/' + this.registro_revisiones.ot_id + '/metodo/' + this.registro_revisiones.metodo + '/informe_id/' + this.registro_revisiones.id + '?page='+ page + '&api_token=' + Laravel.user.api_token;
            console.log(urlRegistros);
            axios.get(urlRegistros).then(response =>{

                console.log(response.data);
                this.registros = response.data

            }).finally(() =>

                this.loading = false,
                )
            this.$forceUpdate();

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
