<template>
    <div>
        <!-- small box -->
        <div class="small-box bg-custom-6">
            <div class="inner">

                <h3 >{{CantInformes}}</h3>

                <p>Informes</p>
            </div>
            <div class="icon">
                <i class="fa fa-list-alt"></i>
            </div>
            <a href="#" class="small-box-footer">Detail <i class="fa  fa-arrow-circle-down"></i></a>
        </div>
        <div class="clearfix"></div>

           <div v-show="$can('T_informes_edita')">
                <div class="box box-custom-enod top-buffer">
                    <div class="box-header with-border">
                        <h3 class="box-title">AGREGAR INFORME</h3>
                
                        <div class="box-body">           
                            <div class="form-group">
                                <label for="name">Tipo</label>      
                                <v-select v-model="metodo_ensayo" label="metodo" :options="ot_metodos_ensayos_data">
                                    <template slot="option" slot-scope="option">
                                        <span class="upSelect">{{ option.metodo }}</span> <br> 
                                        <span class="downSelect"> {{ option.descripcion }} </span>
                                    </template>  
                                </v-select>
                            </div>                            
                            <div class="form-group">                    
                                <span>
                                    <a  @click="NuevoInforme(ot_data.id)">
                                        <button class="btn btn-primary" :disabled="!metodo_selected"><span class="fa fa-plus-circle"></span> 
                                            Nuevo
                                    </button>
                                    </a>                              
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
           </div>

            <div class="box box-custom-enod top-buffer">
                <div class="box-header with-border">
                    <h3 class="box-title">INFORMES ORDEN DE TRABAJO</h3>

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
                                    <th class="col-lg-1">OBRA</th>
                                    <th class="col-lg-4">USUARIO ALTA</th> 
                                    <th class="col-lg-2" >FECHA</th>                                                  
                                    <th class="col-lg-2" colspan="5">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(ot_informe,k) in ot_informes.data" :key="k">                                 
                                    <td> 
                                        <div v-if="ot_informe.metodo != 'US'">
                                           {{ot_informe.metodo}}
                                        </div>
                                        <div v-else>
                                            {{ot_informe.tecnica}}
                                        </div>
                                    </td>
                                    <td>
                                        <div v-if="ot_informe.metodo == 'RI' && ot_informe.gasoducto_sn">
                                            <div v-if="ot_informe.km">
                                                {{ot_informe.km}}-{{ot_informe.tipo_soldadura_codigo}}-{{ot_informe.numero_formateado}}
                                            </div>
                                            <div v-else>
                                                {{ot_informe.tipo_soldadura_codigo}}-{{ot_informe.numero_formateado}}
                                            </div>
                                        </div>
                                        <div v-else>
                                             {{ot_informe.numero_formateado}}       
                                        </div>        
                                    </td>   
                                    <td> {{ot_informe.obra}}</td>  
                                    <td> {{ot_informe.name}}</td>     
                                    <td> {{ot_informe.fecha_formateada}}</td>              
                                    <td v-if="!ot_informe.importable_sn" width="10px"> 
                                        <button   @click.prevent="EditInforme(ot_informe.id)" class="btn btn-warning btn-sm" title="Editar" :disabled="!$can('T_informes_edita')"><span class="fa fa-edit"></span></button>
                                    </td>
                                    <td v-else width="10px"> 
                                        <button @click.prevent="EditInformeImportable(ot_informe.id)" class="btn btn-warning btn-sm" title="Editar" :disabled="!$can('T_informes_edita')"><span class="fa fa-edit"></span></button>                                       
                                    </td>

                                    <td v-if="!ot_informe.importable_sn" width="10px"> 
                                        <button @click="ClonarInforme(k)" class="btn btn-default btn-sm" title="Clonar" :disabled="!$can('T_informes_edita')"><app-icon img="clone" color="black"></app-icon></button>
                                    </td>
                                    <td v-if="ot_informe.metodo == 'RI'"> 
                                        <a :href="AppUrl + '/placas/informe/' + ot_informe.id" class="btn btn-default btn-sm" title="Digitalización"><img width="16px" :src="AppUrl + '/img/carestream.ico'"></a>
                                    </td> 
                                    <td v-if="ot_informe.metodo == 'US'"> 
                                        <a :href="AppUrl + '/placas/informe/' + ot_informe.id" class="btn btn-default btn-sm" title="Digitalización"><img width="16px" :src="AppUrl + '/img/IconoUS.ico'"></a>
                                    </td> 
                                    <td v-if="!ot_informe.importable_sn" width="10px"> <a :href="AppUrl + '/pdf/informe/' + ot_informe.id " target="_blank"  class="btn btn-default btn-sm" title="Informe"><span class="fa fa-file-pdf-o"></span></a></td> 
                                    <td v-else><a :href="AppUrl + '/' + ot_informe.path " target="_blank" title="Informe" class="btn btn-default btn-sm"><span class="fa fa-file-pdf-o"></span></a></td> 
                                    <td v-if="!ot_informe.importable_sn" width="10px"> 
                                        <button @click="informesEscaneados(ot_informe.id)" :disabled="!$can('T_informes_edita')" class="btn btn-default btn-sm" title="Informes escaneados"><span class="fa fa-cloud-upload"></span></button>
                                    </td>  
                                    <td v-if="!ot_informe.firma && !ot_informe.importable_sn" width="10px"> 
                                        <button @click="firmar(k)" class="btn btn-default btn-sm" title="Firmar" :disabled="!$can('T_informes_edita')"><span class="glyphicon glyphicon-pencil"></span></button>                                      
                                    </td>   
                                    <td v-else-if="!ot_informe.importable_sn"><a class="btn btn-default btn-sm" title="Firmado"><img width="16px" :src="AppUrl + '/img/firma.png'"></a></td>

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
        <div class="clearfix"></div>
        <informes-importables :metodo_ensayo="metodo_ensayo" :otdata="this.ot_data" @store="getResults(ot_informes.current_page)"></informes-importables>
    </div>    
</template>

<script>
import {mapState} from 'vuex'
import { eventNewRegistro, eventEditRegistro } from '../../event-bus';
export default {

    props :{
    ot_metodos_ensayos_data: {
    type : Array,
    required : false
    },    

    ot_data : {
        type: Object,
        required:true,
    },
    
  },

    data () { return {

      ot_informes :{},
      metodo_ensayo:{},  
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
                var urlRegistros = 'informes/ot/' + this.ot_data.id + '/paginate' + '?page='+ page;   
                axios.get(urlRegistros).then(response =>{
                this.ot_informes = response.data
                });

        },

        NuevoInforme: function(ot_id){

            
            this.$store.dispatch('loadParametrosGenerales','ddppi').then(response => {

                this.$store.dispatch('loadDDPPI',this.ot_data.id).then(response => {
        
                    if(this.DDPPI ){

                        if(this.metodo_ensayo.importable_sn){

                            console.log('el metodo es importable');
                             eventNewRegistro.$emit('open',this.modelo);

                        }else{

                            window.location.href= this.AppUrl + '/area/enod/ot/' + this.ot_data.id + '/informe/metodo/' + this.metodo_ensayo.metodo + '/create' ;

                        }     
                    }
                    else
                    {

                        toastr.error('No se puede crear el informe. Existen informes de hace ' + this.ParametroGeneral.valor + ' días' + ' sin parte asociado' );
                        
                    }                      

                });

            });

        },

        ContarInformes : function(){
                
                this.$store.dispatch('loadContarInformes',this.ot_data.id);

            },

        EditInforme : function(id){

            window.location.href = this.AppUrl + '/area/enod/ot/' + this.ot_data.id + '/informe/' + id +'/edit'

        },

        EditInformeImportable : function(informe_id){

            eventEditRegistro.$emit('edit',informe_id);

        },

        ClonarInforme : function (index){

            axios.defaults.baseURL = this.url ;
                var urlRegistros = 'informes/' + this.ot_informes.data[index].id + '/clonar';                      
                axios.put(urlRegistros).then(response => {
                  this.getResults();
                  this.ContarInformes();
                  toastr.success('El Informe N°' + (this.ot_informes.data[index].prefijo ? this.ot_informes.data[index].prefijo : '') +'-'+ this.ot_informes.data[index].numero_formateado + ' fue clonado con éxito');                
                  
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

        },

        informesEscaneados(id){

            window.location.href = this.AppUrl + '/documentos-escaneados/ot/' + this.ot_data.id + '/informe/' + id ;

        }
    },
    
}
</script>