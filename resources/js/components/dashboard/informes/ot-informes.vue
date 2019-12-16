<template>
    <div>
        <div class="col-md-12">
            <!-- small box -->
            <div class="small-box bg-red">
            <div class="inner">

                <h3 >{{CantInformes}}</h3>

                <p>Informes</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">Detail <i class="fa  fa-arrow-circle-down"></i></a>
            </div>
        </div>  
        <div class="clearfix"></div>
        <div class="col-md-12">
            <div class="box box-danger top-buffer">
                <div class="box-header with-border">
                    <h3 class="box-title">Agregar Informe</h3>
              
                    <div class="box-body">  
                        <div class="form-group">
                            <label>Tipo</label>
                          <v-select v-model="metodo_ensayo" label="metodo" :options="ot_metodos_ensayos_data" ></v-select> 
                        </div> 
                        <div class="form-group">                    
                            <span>
                            <!--     <a :href="AppUrl + '/area/enod/ot/' + ot_id_data + '/informe/metodo/' + metodo_ensayo.metodo + '/create' " ><button class="btn btn-primary" :disabled="!metodo_selected">Nuevo</button></a> -->                             
                                <a  @click="NuevoInforme(ot_id_data)" ><button class="btn btn-primary" :disabled="!metodo_selected">Nuevo</button></a>                              
                            </span>
                        </div>
                    </div>
                 </div>
            </div>
            <div class="box box-info top-buffer">
                <div class="box-header with-border">
                    <h3 class="box-title">Informes Orden de Trabajo</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>                       
                    </div>
                </div>
             
                <div class="box-body">                        
                    <div class="table-responsive">          
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="col-lg-1">TIPO</th>   
                                    <th class="col-lg-2">N°</th>
                                    <th class="col-lg-6">USUARIO ALTA</th> 
                                    <th class="col-lg-2" >FECHA</th>                                                  
                                    <th class="col-lg-1" colspan="4">ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(ot_informe,k) in ot_informes.data" :key="k">                                 
                                    <td> {{ot_informe.metodo}}</td>
                                    <td>
                                        <div v-if="ot_informe.prefijo != null">
                                             {{ot_informe.prefijo}}-{{ot_informe.numero_formateado}}
                                        </div>
                                        <div v-else>
                                             {{ot_informe.numero_formateado}}       
                                        </div>        
                                    </td>     
                                    <td> {{ot_informe.name}}</td>     
                                    <td> {{ot_informe.fecha}}</td>              
                                    <td width="10px"> <a :href="AppUrl + '/area/enod/ot/' + ot_id_data + '/informe/' + ot_informe.id +'/edit' "   class="btn btn-warning btn-sm" title="Editar"><span class="fa fa-edit"></span></a></td>
                                    <td v-if="ot_informe.metodo == 'RI'"> <a :href="AppUrl + '/placas/informe/' + ot_informe.id"   class="btn btn-default btn-sm" title="Placas informe"><img width="16px" :src="AppUrl + '/img/carestream.ico'"></a></td> 
                                    <td width="10px"> <a :href="AppUrl + '/api/pdf/informe/' + ot_informe.id " target="_blank"  class="btn btn-default btn-sm" title="Informe"><span class="fa fa-file-pdf-o"></span></a></td>  
                                    <td v-if="!ot_informe.firma" width="10px"> <a  @click="firmar(k)"  class="btn btn-default btn-sm" title="Firmar"><span class="glyphicon glyphicon-pencil"></span></a></td>   
                                    <td v-else><a class="btn btn-default btn-sm" title="Firmado"><img width="16px" :src="AppUrl + '/img/firma.png'"></a></td>

                                </tr>                       
                                 
                            </tbody>
                        </table>                     
                    </div>
                    <pagination 
                        :data="ot_informes" @pagination-change-page="getResults" >
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
    ot_metodos_ensayos_data: {
    type : Array,
    required : false
    },    

    ot_id_data : '',
    
  },

    data () { return {

      ot_informes :{},
      metodo_ensayo:'',  
      metodo_selected:false
    
    }    
  },

  watch :{

      metodo_ensayo : function(val){

          if (val == null)
            this.metodo_ensayo = '';
          else  
          this.metodo_selected = val == '' ? false : true
      }
  },

  created : function() {

     // this.ot_informes =  JSON.parse(JSON.stringify(this.ot_informes_data));       
  },

  mounted : function(){

      this.getResults();
      this.ContarInformes();
  },

  computed :{

       ...mapState(['url','AppUrl','CantInformes','DDPPI','ParametroGeneral'])
     },  

    methods : {

        getResults :function(page = 1){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'informes/ot/' + this.ot_id_data + '/paginate' + '?page='+ page;   
                axios.get(urlRegistros).then(response =>{
                this.ot_informes = response.data
                });

        },

        NuevoInforme: function(ot_id){

            this.$store.dispatch('loadParametrosGenerales','ddppi').then(response => {

                this.$store.dispatch('loadDDPPI',this.ot_id_data).then(response => {
        
                    if(this.DDPPI ){
                    
                    window.location.href= this.AppUrl + '/area/enod/ot/' + this.ot_id_data + '/informe/metodo/' + this.metodo_ensayo.metodo + '/create' ;
                    }
                    else
                    {
                        toastr.error('No se puede crear el informe. Existen informes de hace ' + this.ParametroGeneral.valor + ' días' + ' sin parte asociado' );
                        
                    }                      

                });

            });

        },

        ContarInformes : function(){
                
                this.$store.dispatch('loadContarInformes',this.ot_id_data);

            },

        firmar : function(index){

            axios.defaults.baseURL = this.url ;
                var urlRegistros = 'informes/' + this.ot_informes.data[index].id + '/firmar';                      
                axios.put(urlRegistros).then(response => {
                  console.log(response.data); 
                  this.ot_informes.data[index].firma = response.data.firma;    
                  toastr.success('El Informe N° '+  (this.ot_informes.data[index].prefijo ? this.ot_informes.data[index].prefijo : '') +'-'+ this.ot_informes.data[index].numero_formateado +'  fue firmado con éxito');                
                  
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