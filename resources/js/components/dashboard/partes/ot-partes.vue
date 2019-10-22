<template>
 <div>
     <div class="col-md-12">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>{{CantPartes}}</h3>

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
                                    <th colspan="4">ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(ot_parte,k) in ot_partes.data" :key="k">                                 
                                    <td> {{ot_parte.id}}</td>
                                    <td> {{ot_parte.tipo_servicio}} </td>     
                                    <td> {{ot_parte.fecha}}</td>              
                                    <td width="10px"> <a :href="AppUrl + '/area/enod/ot/' + ot_id_data + '/parte/' + ot_parte.id +'/edit' "   class="btn btn-warning btn-sm" title="Editar"><span class="fa fa-edit"></span></a></td>
                                    <td width="10px"> <a :href="AppUrl + '/api/pdf/parte/' + ot_parte.id + '/original' " target="_blank"  class="btn btn-default btn-sm" title="pdf"><span class="fa fa-file-pdf-o"></span></a></td>             
                                    <td width="10px"> <a :href="AppUrl + '/api/pdf/parte/' + ot_parte.id + '/final' " target="_blank"  class="btn btn-default btn-sm" title="pdf"><span class="fa fa-file-pdf-o"></span></a></td> 
                                    <td v-if="!ot_parte.firma" width="10px"> <a  @click="firmar(k)"  class="btn btn-default btn-sm" title="Firmar"><span class="glyphicon glyphicon-pencil"></span> </a></td>                                   

                                </tr>                      
                            </tbody>
                        </table>                     
                    </div>
                    <pagination 
                        :data="ot_partes" @pagination-change-page="getResults" >
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span> 
                    </pagination>
                </div>
            </div>
        </div>    
 </div>
    
</template>
<script>
import {mapState} from 'vuex'
export default {
    props :{

     ot_id_data : '',
    
  }, 

  data () { return {

      ot_partes :{},

    }    
  },

  created : function() {

      this.getResults();
      this.$store.dispatch('loadContarPartes',this.ot_id_data);
  },
  
  computed :{

       ...mapState(['url','AppUrl','CantPartes'])
     },  

  methods : {

      getResults :function(page = 1){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'partes/ot/' + this.ot_id_data + '/paginate' + '?page='+ page;   
                axios.get(urlRegistros).then(response =>{
                this.ot_partes = response.data
                });

        },

        firmar : function(index){

            axios.defaults.baseURL = this.url ;
                var urlRegistros = 'partes/' + this.ot_partes[index].id + '/firmar';                      
                axios.put(urlRegistros).then(response => {
                  console.log(response.data); 
                  this.ot_partes[index].firma = response.data.firma;    
                  toastr.success('El Parte N° ' +response.data.id + ' fue firmado con éxito');                
                  
                }).catch(error => {                   
                    this.errors = error.response.data.errors;
                    $.each( this.errors, function( key, value ) {
                        toastr.error(value);
                        console.log( key + ": " + value );
                    });

                     if((typeof(this.errors)=='undefined') && (error)){

                     toastr.error("Ocurrió un error al procesar la solicitud");                     
                  
                }
                });

        }
    },
}
</script>