<template>
 <div class="row">
       <div class="col-lg-3 col-xs-6">
          <cuadro-enod
              :titulo = "'PARTES'"
              :class_color_titulo = "'color_titulo_1'"
              :cantidad_1 ="CantPartes"
              :src_icono ="'/img/tablero/icono-enod-partes.svg'"
              :class_color_cuadro = "'bg-custom-7'"   
              :habilitado_sn ="true"                  
          >
          </cuadro-enod>
       </div>
     
        <div class="clearfix"></div>
        <div class="col-md-12">
            <div class="box box-custom-enod top-buffer">
                <div class="box-header with-border">
                    <div class="table-responsive">          
                        <table class="table table-hover table-striped table-condensed">
                            <thead>
                                <tr>                                     
                                    <th>N°</th>
                                    <th>TIPO SERVICIO</th> 
                                    <th>FECHA</th>                                                
                                    <th colspan="4">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(ot_parte,k) in ot_partes.data" :key="k">                                 
                                    <td> {{ot_parte.numero_formateado}}</td>
                                    <td> {{ot_parte.tipo_servicio}} </td>     
                                    <td> {{ot_parte.fecha}}</td>              
                                    <td width="10px"> 
                                        <button @click.prevent="editParte(ot_parte.id)" class="btn btn-warning btn-sm" title="Editar" :disabled="!$can('T_partes_edita')"><span class="fa fa-edit"></span></button>
                                    </td>
                                    
                                    <td width="10px" v-show="$can('T_partes_edita')"> 
                                        <a :href="AppUrl + '/pdf/parte/' + ot_parte.id + '/original' " target="_blank"  class="btn btn-default btn-sm" title="Informe original"><span class="fa fa-file-pdf-o"></span></a>
                                    </td>    

                                    <td width="10px"> 
                                        <a :href="AppUrl + '/pdf/parte/' + ot_parte.id + '/final' " target="_blank"  class="btn btn-default btn-sm" title="Informe"><span class="fa fa-file-pdf-o"></span></a>
                                    </td> 
                                    <td width="10px"> 
                                        <button @click="informesEscaneados(ot_parte.id)" :disabled="!$can('T_partes_edita')" class="btn btn-default btn-sm" title="Informes escaneados"><span class="fa fa-cloud-upload"></span></button>
                                    </td>  
                                    <td v-if="!ot_parte.firma" width="10px">
                                        <button @click="firmar(k)" class="btn btn-default btn-sm" title="Firmar" :disabled="!$can('T_partes_edita')"><span class="glyphicon glyphicon-pencil"></span></button>                                       
                                   </td>
                                   <td v-else><a class="btn btn-default btn-sm" title="Firmado"><img width="16px" :src="AppUrl + '/img/firma.png'"></a></td>

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
        
        editParte : function(id){

            window.location.href = this.AppUrl + '/area/enod/ot/' + this.ot_id_data + '/parte/' + id +'/edit'
        },

        firmar : function(index){

            axios.defaults.baseURL = this.url ;
                var urlRegistros = 'partes/' + this.ot_partes.data[index].id + '/firmar';                      
                axios.put(urlRegistros).then(response => {
                  console.log(response.data); 
                  this.ot_partes.data[index].firma = response.data.firma;    
                  toastr.success('El Parte N° ' + response.data.id + ' fue firmado con éxito');                
                  
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

        },

        informesEscaneados(id){

            window.location.href = this.AppUrl + '/documentos-escaneados/ot/' + this.ot_id_data + '/parte/' + id ;

        }
    },
}
</script>