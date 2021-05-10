<template>
 <div class="row">
    <div class="col-md-12">
        <div v-show="$can('T_remitos_edita')">
            <a :href="'/area/enod/remitos' " class="btn btn-enod pull-left"><span class="fa fa-plus-circle"></span> Nuevo</a>
        </div>
    </div>
    <div class="clearfix"></div>

        <div class="col-md-12">
        <div class="box box-custom-enod top-buffer">
            <div class="box-header with-border">
                <h3 class="box-title">Remitos</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Frente origen</th>
                                <th>Frente destino</th>
                                <th>Receptor</th>
                                <th>Destino</th>
                                <th>Fecha</th>
                                <th colspan="2">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(remito,k) in remitos.data" :key="k">
                                <td> {{remito.prefijo_formateado}}-{{remito.numero_formateado}}</td>
                                <td>{{ remito.frente_origen.codigo }}</td>
                                <td>{{ remito.frente_destino.codigo }}</td>
                                <td> {{remito.receptor}} </td>
                                <td> {{remito.destino}}</td>
                                <td> {{remito.fecha}}</td>
                                <!--
                                <td width="10px">
                                    <button @click.prevent="editRemito(k)" class="btn btn-warning btn-sm" title="Editar" :disabled="!$can('T_remitos_edita')"><span class="fa fa-edit"></span></button>
                                </td>
                                -->
                                <td v-if="remito.interno_sn" width="10px"> <a :href="'/pdf/remito/' + remito.id " target="_blank"  class="btn btn-default btn-sm" title="Informe"><span class="fa fa-file-pdf-o"></span></a></td>
                                <td v-else width="10px"> <a :href="'/pdf/remito/' + remito.id " target="_blank"  class="btn btn-default btn-sm" title="Imprimir"><span class="fa fa-print"></span></a></td>

                            </tr>
                        </tbody>
                    </table>
                </div>
                <pagination
                    :data="remitos" @pagination-change-page="getResults" >
                    <span slot="prev-nav">&lt; Previous</span>
                    <span slot="next-nav">Next &gt;</span>
                </pagination>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
 </div>

</template>
<script>
import {mapState} from 'vuex'
export default {

  data () { return {

      remitos :{},

    }
  },

  created : function() {

    this.getResults();

  },

  computed :{

       ...mapState(['url'])
     },

 methods : {

     getResults :function(page = 1){

        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'remitos' + '/paginate' + '?page='+ page;
        axios.get(urlRegistros).then(response =>{
        console.log('remitos',response.data)
        this.remitos = response.data

        });

        },

    editRemito : function(index){

        window.location.href =  '/area/enod/remito/' + this.remitos.data[index].id +'/edit'

    }

 }
}
</script>
