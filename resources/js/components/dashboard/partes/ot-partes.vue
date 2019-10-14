<template>
 <div>
     <div class="col-md-12">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>{{ot_partes.length}}</h3>

              <p>Partes</p>
            </div>
            <div class="icon">
              <i class="fa fa-file-pdf-o"></i>
            </div>
            <a href="#" class="small-box-footer">Detail <i class="fa  fa-arrow-circle-down"></i></a>
          </div>
        </div>
        <div class="col-sm-12">
            <a :href="AppUrl + '/area/enod/ot/' + ot_id_data + '/parte' " class="btn btn-primary pull-left">Nuevo</a>
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
                                    <th>Tipo Servicio</th> 
                                    <th>FECHA</th>                                                
                                    <th colspan="3">ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(ot_parte,k) in ot_partes" :key="k">                                 
                                    <td> {{ot_parte.id}}</td>
                                    <td> {{ot_parte.tipo_servicio}} </td>     
                                    <td> {{ot_parte.fecha}}</td>              
                                    <td width="10px"> <a :href="AppUrl + '/area/enod/ot/' + ot_id_data + '/parte/' + ot_parte.id +'/edit' "   class="btn btn-warning btn-sm" title="Editar"><span class="fa fa-edit"></span></a></td>
                                    <td width="10px"> <a :href="AppUrl + '/api/pdf/parte/' + ot_parte.id + '/original' " target="_blank"  class="btn btn-default btn-sm" title="pdf"><span class="fa fa-file-pdf-o"></span></a></td>             
                                    <td width="10px"> <a :href="AppUrl + '/api/pdf/parte/' + ot_parte.id + '/final' " target="_blank"  class="btn btn-default btn-sm" title="pdf"><span class="fa fa-file-pdf-o"></span></a></td>                                    
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

    partes_data : {
    type : Array,
    required : false
     },

     ot_id_data : '',
    
  }, 

  data () { return {

      ot_partes :[],

    }    
  },

  created : function() {

      this.ot_partes =  JSON.parse(JSON.stringify(this.partes_data)); 
  },
  
  computed :{

       ...mapState(['url','AppUrl'])
     },  
}
</script>