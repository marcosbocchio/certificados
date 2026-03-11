
<template>
    <div class="row">
        <div class="col-md-3">
            <div class="box box-custom-enod">
                <div class="box-body box-profile">
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item pointer">
                            <div v-show="!selTipo_equipamiento">
                                <span class="titulo-li">Tipo Equipamiento</span>
                                <a @click="selTipo_equipamiento = !selTipo_equipamiento" class="pull-right">
                                    <div v-if="tipo_equipamiento">{{tipo_equipamiento.codigo}}</div>
                                    <div v-else><span class="seleccionar">Seleccionar</span></div>
                                </a>
                            </div>
                            <v-select v-show="selTipo_equipamiento" v-model="tipo_equipamiento" label="codigo" :options="tipos_equipamiento" @input="CambioTipoEquipamiento()" ></v-select>
                        </li>

                        <li class="list-group-item pointer">
                            <label>
                                <input type="checkbox" v-model="vencidas_sn">
                                <span style="margin-left:20px">Documentación vencida</span>
                            </label>
                        </li>
                        <li class="list-group-item pointer">
                             <label>
                                 <input type="checkbox" v-model="noVencidas_sn">
                                 <span style="margin-left:20px">Documentación No vencida</span>
                            </label>
                        </li>         
                        <li class="list-group-item pointer">
                             <label>
                                 <input type="checkbox" v-model="todos_sn">
                                 <span style="margin-left:20px">Sin Cert. Verif / Doc. </span>
                            </label>
                        </li>                                            
                    </ul>
                    <a  @click="Buscar()">
                        <button class="btn btn-enod btn-block"><span class="fa fa-search"></span>
                            Buscar
                        </button>
                    </a>
                </div>
            </div>
            <div class="box">       
                <div class="box-body box-profile">    
                    <ul>
                        <li>
                            Para el vencimiento se tiene en cuenta el "certificado de verificación" de la documentación.                           
                        </li>
                   </ul>       
                </div>
            </div> 
        </div>

        <div class="col-md-9">
            <tabs :options="{ useUrlFragment: false }" @clicked="tabClicked" @changed="tabChanged">
                <tab name="Interno Equipos">  
                    <div  v-if="(TablaInternoEquipos.data && TablaInternoEquipos.data.length)">
                        <div class="row">
                            <div class="col-lg-4">
                                <a class="btn btn-default" :href="'/pdf/reporte-interno-equipos-ri/tipo_equipamiento/' + (tipo_equipamiento ? tipo_equipamiento.id : 'null') + '/vencidas_sn/' + vencidas_sn + '/noVencidas_sn/' + noVencidas_sn + /todos_sn/ + this.todos_sn + '?&api_token=' + Laravel.user.api_token" target="_blank">Exportar PDF</a>
                            </div>
                        </div>                           
                    </div>
                    <div class="row" style="margin-top: 25px;">
                        <div class="col-lg-12">
                            <div v-if="(TablaInternoEquipos.data && TablaInternoEquipos.data.length)">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Interno Equipos</h3>
                                    </div>     

                                    <div class="box-body">
                                        <div class="table-responsive">
                                        <table class="table table-striped table-condensed">
                                            <tbody>
                                                <tr>
                                                    <th class="col-md-1">Método</th>
                                                    <th class="col-md-1">N° Int</th>
                                                    <th class="col-md-1">N° serie</th>
                                                    <th class="col-md-2">Equipo</th>
                                                    <th class="col-md-3">Tipo equipamiento</th>
                                                    <th class="col-md-3">Usuario</th>
                                                    <th class="col-md-1">Fecha cad.</th>
                                                    <th style="text-align: center;" class="col-md-1">Doc.</th>
                                                </tr>
                                                <tr v-for="(item,k) in TablaInternoEquipos.data" :key="k" :class="[item.vencida_sn ? 'vencidas' : (item.cant_notificaciones ? 'notificadas' : '')]">
                                                    <td>{{ item.metodo }}</td>
                                                    <td>{{ item.nro_interno }} </td>                                 
                                                    <td>{{ item.nro_serie }} </td>
                                                    <td>{{ item.equipo_codigo}} </td>
                                                    <td>{{ item.tipo_equipamiento_codigo }} </td>
                                                    <td>{{ item.name }}</td>
                                                    <td>{{ item.fecha_cad_formateada }}</td>
                                                    <td align="center" width="10px"> <a :href="'/' + item.path " target="_blank" title="Imagen"><span class="fa fa-file-image-o"></span></a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <table width="100%" class="bordered">
                                    <tbody>
                                        <tr>
                                            <td style="font-size: 12px;height: 18px;width:75px;height: 30px"><span class="EspecialCaracter" style="margin-left:5px;color:red">█ </span>Vencidas</td>
                                            <td style="font-size: 12px;height: 18px"><span class="EspecialCaracter" style="margin-left:5px;color:blue">█ </span>Notificado</td>
                                        </tr>
                                    </tbody>
                                </table>                                
                              </div>
                            </div>
                            <div v-else>
                                <h4>No hay datos para mostrar</h4>
                            </div>
                        </div>
                    </div>
                </tab>
              </tabs>
                <pagination :data="TablaInternoEquipos" @pagination-change-page="Buscar" :limit="3"><span slot="prev-nav">&lt; Previous</span>
                <span slot="next-nav">Next &gt;</span> </pagination>
        </div>

         <loading
            :active.sync="isLoading"
            :loader="'bars'"
            :color="'red'">
         </loading>
    </div>
</template>

<script>
import {mapState} from 'vuex';
import Tabs from 'vue-tabs-component';
import Loading from 'vue-loading-overlay';

export default {

    components: {
      Loading,
    },
    props: {

      user : {
        type : Object,
        required : true,
      },

    },

    data() { return {

      tipo_equipamiento: '',
      selTipo_equipamiento: false,   
      vencidas_sn : true,
      noVencidas_sn : true,
      todos_sn: false,
      TablaInternoEquipos: {},
     }

    },

    mounted() {
      this.$store.dispatch('loadTiposEquipamiento');
    },

    computed :{
        ...mapState(['isLoading','tipos_equipamiento','url']),
    },

    methods :{

      async CambioTipoEquipamiento() {

        this.selTipo_equipamiento = !this.selTipo_equipamiento;

      },
      async Buscar (page = 1) { 
        this.$store.commit('loading', true);
        this.TablaInternoEquipos = {};
        try {
          let url = 'reporte-interno-equipos-ri/tipo_equipamiento/' + (this.tipo_equipamiento ? this.tipo_equipamiento.id : 'null') + '/vencidas_sn/' + this.vencidas_sn + '/noVencidas_sn/' + this.noVencidas_sn + '/todos_sn/' + this.todos_sn + '?page='+ page + '&api_token=' + Laravel.user.api_token;
          let res = await axios.get(url);
          this.TablaInternoEquipos = res.data;
          console.log(this.TablaInternoEquipos);
          console.log(this.TablaInternoEquipos.data.length);
        }catch(error){

        }finally {this.$store.commit('loading', false);}

     },    
      tabClicked (selectedTab) {
          console.log('Current tab re-clicked:' + selectedTab.tab.name);
      },

      tabChanged (selectedTab) {
            console.log('Tab changed to:' + selectedTab.tab.name);
      },    
      
      exportarPdf () {
        window.location.href =  '/pdf/reporte-interno-equipos-ri/tipo_equipamiento/' + (this.tipo_equipamiento ? this.tipo_equipamiento.id : 'null') + '/vencidas_sn/' + this.vencidas_sn + '/noVencidas_sn/' + this.noVencidas_sn + '?&api_token=' + Laravel.user.api_token;
      }      

    }
  }

</script>

<style scoped>
.vencidas {
    color:red;
}

.notificadas {
    color:blue;
}
</style>