<template>
 <div>
     <div class="col-md-12">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ot_remitos.length}}</h3>

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
                                    <th>FECHA</th>                                                
                                    <th colspan="2">ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(ot_remito,k) in ot_remitos" :key="k">                                 
                                    <td> {{ot_remito.prefijo_formateado}}-{{ot_remito.numero_formateado}}</td>
                                    <td> {{ot_remito.receptor}} </td>     
                                    <td> {{ot_remito.destino}}</td>     
                                    <td> {{ot_remito.fecha}}</td>              
                                    <td width="10px"> <a :href="AppUrl + '/area/enod/ot/' + ot_id_data + '/remito/' + ot_remito.id +'/edit' "   class="btn btn-warning btn-sm" title="Editar"><span class="fa fa-edit"></span></a></td>
                                    <td v-if="ot_remito.interno_sn" width="10px"> <a :href="AppUrl + '/api/pdf/remito/' + ot_remito.id " target="_blank"  class="btn btn-default btn-sm" title="pdf"><span class="fa fa-file-pdf-o"></span></a></td>
                                    <td v-else width="10px"> <a :href="AppUrl + '/api/pdf/remito/' + ot_remito.id " target="_blank"  class="btn btn-default btn-sm" title="Imprimir"><span class="fa fa-print"></span></a></td>                                  
                                    
                                </tr>                       
                                
                            </tbody>
                        </table>                     
                    </div>
                </div>
            </div>
        </div>    
 </div>
    
</template>
<script>
import {mapState} from 'vuex'
export default {
    props :{

    remitos_data : {
    type : Array,
    required : false
     },

     ot_id_data : '',
    
  }, 

  data () { return {

      ot_remitos :[],

    }    
  },

  created : function() {

      this.ot_remitos =  JSON.parse(JSON.stringify(this.remitos_data)); 
  },
  
  computed :{

       ...mapState(['url','AppUrl'])
     },  
}
</script>