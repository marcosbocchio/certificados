<template>
    <div>
          <!-- small box -->
        <div class="small-box bg-custom-8">
            <div class="inner">

              <h3>{{CantCertificados}}</h3>

              <p>Certificados</p>
            </div>
            <div class="icon">
               <i class="fa fa-check-square-o"></i>
            </div>
            <a href="#" class="small-box-footer">Detail <i class="fa  fa-arrow-circle-down"></i></a>
        </div>

        <div v-show="$can('T_certif_edita')">        
            <a :href="AppUrl + '/area/enod/ot/' + ot_id_data + '/certificado' " class="btn btn-primary pull-left"> <span class="fa fa-plus-circle"></span> Nuevo</a>     
        </div> 

        <div class="clearfix"></div>
    
            <div class="box box-custom-enod top-buffer">
                <div class="box-header with-border">
                    <div class="table-responsive">          
                        <table class="table table-hover table-striped table-condensed">
                            <thead>
                                <tr>                                     
                                    <th class="col-lg-2">N°</th>                                    
                                    <th class="col-lg-9">FECHA</th>                                                
                                    <th  class="col-lg-1" colspan="4">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(ot_certificado,k) in ot_certificados.data" :key="k">                                 
                                    <td> {{ot_certificado.numero_formateado}}</td>
                                    <td> {{ot_certificado.fecha}}</td>              
                                    <td width="10px"> 
                                        <button @click.prevent="editCertificado(ot_certificado.id)" class="btn btn-warning btn-sm" title="Editar" :disabled="!$can('T_certif_edita')"><span class="fa fa-edit"></span></button>
                                    </td>

                                    <td width="10px" v-show="$can('T_certif_edita')"> 
                                        <a :href="AppUrl + '/pdf/certificado/' + ot_certificado.id + '/original' " target="_blank"  class="btn btn-default btn-sm" title="Informe original"><span class="fa fa-file-pdf-o"></span></a>
                                    </td>    

                                    <td width="10px"> 
                                        <a :href="AppUrl + '/pdf/certificado/' + ot_certificado.id + '/final' " target="_blank"  class="btn btn-default btn-sm" title="Informe"><span class="fa fa-file-pdf-o"></span></a>
                                    </td> 
                                    <td width="10px"> 
                                        <button @click="informesEscaneados(ot_certificado.id)" :disabled="!$can('T_certif_edita')" class="btn btn-default btn-sm" title="Informes escaneados"><span class="fa fa-cloud-upload"></span></button>
                                    </td>                                     
                                    <td v-if="!ot_certificado.firma" width="10px">
                                        <button @click="firmar(k)" class="btn btn-default btn-sm" title="Firmar" :disabled="!$can('T_certif_edita')"><span class="glyphicon glyphicon-pencil"></span></button>                                       
                                   </td>
                                   <td v-else><a class="btn btn-default btn-sm" title="Firmado"><img width="16px" :src="AppUrl + '/img/firma.png'"></a></td>

                               </tr>                      
                            </tbody>
                        </table>                     
                    </div>
                    <pagination 
                        :data="ot_certificados" @pagination-change-page="getResults" >
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span> 
                    </pagination>
                </div>
            </div>
    </div>
</template>

<script>
import {mapState} from 'vuex'
import {sprintf} from '../../../functions/sprintf.js'
export default {

    props :{

     ot_id_data : '',
    
  }, 

  data () { return {

      ot_certificados :{},

    }    
  },

  created : function() {

      this.getResults();
      this.$store.dispatch('loadContarCertificados',this.ot_id_data);
     
  },

  computed :{

       ...mapState(['url','AppUrl','CantCertificados'])
     },  

  methods : {

      getResults :function(page = 1){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'certificados/ot/' + this.ot_id_data + '/paginate' + '?page='+ page;   
            axios.get(urlRegistros).then(response =>{
            this.ot_certificados = response.data
            });

        },     

        editCertificado : function(id){

            window.location.href = this.AppUrl + '/area/enod/ot/' + this.ot_id_data + '/certificado/' + id +'/edit'
        },


        firmar : function(index){

            axios.defaults.baseURL = this.url ;
                var urlRegistros = 'certificados/' + this.ot_certificados.data[index].id + '/firmar';                      
                axios.put(urlRegistros).then(response => {
                  console.log(response.data); 
                  this.ot_certificados.data[index].firma = response.data.firma;    
                  toastr.success('El Certificado N° ' + this.ot_certificados.data[index].numero_formateado + ' fue firmado con éxito');                
                  
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

            window.location.href = this.AppUrl + '/documentos-escaneados/ot/' + this.ot_id_data + '/certificado/' + id ;

        }
        
    },


}
</script>