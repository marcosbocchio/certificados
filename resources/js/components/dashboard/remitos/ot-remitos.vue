<template>
 <div>
     <div class="col-md-12">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{CantRemitos}}</h3>

              <p>Remitos</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">Detail <i class="fa  fa-arrow-circle-down"></i></a>
          </div>
        </div>
        <div class="col-sm-12">
            <a :href="AppUrl + '/area/enod/ot/' + ot_id_data + '/remito' " class="btn btn-primary pull-left">Nuevo</a>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12">
            <div class="box box-danger top-buffer">
                <div class="box-header with-border">
                    <div class="table-responsive">          
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>                                     
                                    <th>N°</th>
                                    <th>RECEPTOR</th> 
                                    <th>DESTINO</th> 
                                    <th style="text-align: center;">INTERNO S/N</th> 
                                    <th>FECHA</th>                                                
                                    <th colspan="2">ACCIÓN</th>
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
                                    <td width="10px"> <a :href="AppUrl + '/area/enod/ot/' + ot_id_data + '/remito/' + ot_remito.id +'/edit' "   class="btn btn-warning btn-sm" title="Editar"><span class="fa fa-edit"></span></a></td>
                                    <td v-if="ot_remito.interno_sn" width="10px"> <a :href="AppUrl + '/api/pdf/remito/' + ot_remito.id " target="_blank"  class="btn btn-default btn-sm" title="Informe"><span class="fa fa-file-pdf-o"></span></a></td>
                                    <td v-else width="10px"> <a :href="AppUrl + '/api/pdf/remito/' + ot_remito.id " target="_blank"  class="btn btn-default btn-sm" title="Imprimir"><span class="fa fa-print"></span></a></td>                                  
                                    
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

 }
}
</script>