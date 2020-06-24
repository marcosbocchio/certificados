<template>
<div>
    <form v-on:submit.prevent="storeRegistro" method="post">
        <div class="modal fade" id="trazabilidad-fuente">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Trazabilidad Fuente</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="numero_interno">Equipo</label> 
                                    <input autocomplete="off" type="text" name="numero_interno" class="form-control" disabled :value="registro_Interno_equipo.nro_interno +  (registro_Interno_equipo ? ('-' + registro_Interno_equipo.equipo.codigo) : '')">                  
                               </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box box-custom-enod top-buffer">
                                    <div class="box-body no-padding">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped  table-condensed">
                                            <thead>
                                                <tr>            
                                                <th>Fuente</th>
                                                <th>Alta</th>
                                                <th>Baja</th>             
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(registro,k) in registros.data" :key="k">                
                                                <td>{{ registro.interno_fuente.nro_serie }} - {{registro.interno_fuente.fuente.codigo}}</td>   
                                                <td>{{moment(registro.fecha_alta)}}</td>
                                                <td>{{moment(registro.fecha_baja)}}</td>
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
import { eventModal } from '../event-bus';
import moment from 'moment';

export default {

    data() {return {  

        registros :{},
        loading:false,
        registro_Interno_equipo: 0,
    }},

    created: function () {    
        
        eventModal.$on('trazabilidad_fuente',function(registro) {
            
            this.registro_Interno_equipo = registro ;
            this.openModal();
                
        }.bind(this)); 

    },

    computed :{

       ...mapState(['url','AppUrl']),

    },

    methods: {

        openModal : function(){
          
            $('#trazabilidad-fuente').modal('show');    
            this.getResults();
        },

        getResults : function(page = 1){

            this.loading = true,     
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'trazabilidad_fuente/interno_equipo/' + this.registro_Interno_equipo.id + '?page='+ page + '&api_token=' + Laravel.user.api_token;    
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