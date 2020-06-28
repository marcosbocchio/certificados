<template>
 <div class="row">

       <div class="col-lg-3 col-xs-6">
          <cuadro-enod
              :tablero_sn ="false"
              :titulo = "'REMITOS'"
              :class_color_titulo = "'color_2'"
              :class_color_sub_titulo = "'color_3'"
              :cantidad_1 ="CantRemitos"
              :src_icono ="'/img/tablero/icono-enod-remitos.svg'"
              :class_color_cuadro = "'bg-custom-5'"   
              :habilitado_sn ="true"                  
          >
          </cuadro-enod>
       </div>

        <div class="clearfix"></div>

        <div class="col-md-12">
            <div v-show="$can('T_remitos_edita')">
                <a :href="AppUrl + '/area/enod/ot/' + ot_id_data + '/remito' " class="btn btn-enod pull-left"><span class="fa fa-plus-circle"></span> Nuevo</a>
            </div>
        </div>
        <div class="clearfix"></div>

         <div class="col-md-12">
            <div class="box box-custom-enod top-buffer">
                <div class="box-header with-border">
                    <h3 class="box-title">Remitos asignados a la orden de trabajo</h3>

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
                                    <th>Receptor</th> 
                                    <th>Destino</th> 
                                    <th style="text-align: center;">Interno S/N</th> 
                                    <th>Fecha</th>                                                
                                    <th colspan="2">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(ot_remito,k) in ot_remitos.data" :key="k">                                 
                                    <td> {{ot_remito.prefijo_formateado}}-{{ot_remito.numero_formateado}}</td>
                                    <td> {{ot_remito.receptor}} </td>     
                                    <td> {{ot_remito.destino}}</td>   
                                    <td v-if="ot_remito.interno_sn" style="text-align: center;"> SI </td>   
                                    <td v-if="!ot_remito.interno_sn"  style="text-align: center;"> NO </td>  
                                    <td> {{ot_remito.fecha}}</td>              
                                    <td width="10px"> 
                                        <button @click.prevent="editRemito(k)" class="btn btn-warning btn-sm" title="Editar" :disabled="!$can('T_remitos_edita')"><span class="fa fa-edit"></span></button>
                                    </td>
                                    <td v-if="ot_remito.interno_sn" width="10px"> <a :href="AppUrl + '/pdf/remito/' + ot_remito.id " target="_blank"  class="btn btn-default btn-sm" title="Informe"><span class="fa fa-file-pdf-o"></span></a></td>
                                    <td v-else width="10px"> <a :href="AppUrl + '/pdf/remito/' + ot_remito.id " target="_blank"  class="btn btn-default btn-sm" title="Imprimir"><span class="fa fa-print"></span></a></td>                                  
                                    
                                </tr>                       
                                
                            </tbody>
                        </table>                     
                    </div>
                    <pagination 
                        :data="ot_remitos" @pagination-change-page="getResults" >
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
    props :{

     ot_id_data : '',
    
  }, 

  data () { return {

      ot_remitos :{},

    }    
  },

  created : function() {
      this.getResults();
      this.$store.dispatch('loadContarRemitos',this.ot_id_data);

  },
  
  computed :{

       ...mapState(['url','AppUrl','CantRemitos'])
     },  

 methods : {
     
     getResults :function(page = 1){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'remitos/ot/' + this.ot_id_data + '/paginate' + '?page='+ page;   
                axios.get(urlRegistros).then(response =>{
                this.ot_remitos = response.data
                });

        },

    editRemito : function(index){

        window.location.href = this.AppUrl + '/area/enod/ot/' + this.ot_id_data + '/remito/' + this.ot_remitos.data[index].id +'/edit'

    }

 }
}
</script>