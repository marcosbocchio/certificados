<template>
    <div class="row">

       <div class="col-lg-12">
          <cuadro-largo-enod
              :titulo = "'INFORMES'"
              :class_color_titulo = "'color_3'"
              :class_color_sub_titulo = "'color_2'"
              :cantidad_1 ="CantInformes"
              :src_icono ="'/img/tablero/icono-enod-informes.svg'"
              :class_color_cuadro = "'bg-custom-6'"
              :class_color_cuadro_largo = "'bg-custom-8'"
              :habilitado_sn =" $can('T_informes_acceder') ?  true : false"
              :class_footer_img ="'footer-oper-inf'"
          >
          </cuadro-largo-enod>
       </div>

        <div class="clearfix"></div>

       <div class="col-md-12">
           <div v-show="$can('T_informes_edita')">
                <div class="box box-custom-enod top-buffer">
                    <div class="box-header with-border">
                        <h3 class="box-title">Agregar Informes</h3>

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
                                        <button class="btn btn-enod" :disabled="!metodo_selected"><span class="fa fa-plus-circle"></span>
                                            Nuevo
                                    </button>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
           </div>
       </div>
       <div class="col-md-12">
            <div class="box box-custom-enod top-buffer">
                <div class="box-header with-border">
                    <h3 class="box-title">Informes asignados a la orden de trabajo</h3>

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
                                    <th class="col-lg-1">Tipo</th>
                                    <th class="col-lg-2">N°</th>
                                    <th class="col-lg-1">Nº Rev.</th>
                                    <th class="col-lg-1">Obra</th>
                                    <th class="col-lg-3">Usuario alta</th>
                                    <th class="col-lg-2">Fecha</th>
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
                                    <td> {{ot_informe.revision}}</td>
                                    <td> {{ot_informe.obra}}</td>
                                    <td> {{ot_informe.name}}</td>
                                    <td> {{ot_informe.fecha_formateada}}</td>
                                    <td v-if="!ot_informe.importable_sn" width="10px">
                                        <button  @click.prevent="VerificarRevision(ot_informe)" class="btn btn-warning btn-sm" title="Editar" :disabled="!$can('T_informes_edita')"><span class="fa fa-edit"></span></button>
                                    </td>
                                    <td v-else width="10px">
                                        <button @click.prevent="EditInformeImportable(ot_informe.id)" class="btn btn-warning btn-sm" title="Editar" :disabled="!$can('T_informes_edita')"><span class="fa fa-edit"></span></button>
                                    </td>

                                    <td v-if="!ot_informe.importable_sn" width="10px">
                                        <button @click="confirmarClanacion(k)" class="btn btn-default btn-sm" title="Clonar" :disabled="!$can('T_informes_edita')"><app-icon img="clone" color="black"></app-icon></button>
                                    </td>
                                    <td v-if="ot_informe.metodo == 'RI'">
                                        <a :href="'/placas/informe/' + ot_informe.id" class="btn btn-default btn-sm" title="Digitalización"><img width="16px" :src="'/img/carestream.ico'"></a>
                                    </td>
                                    <td v-if="ot_informe.metodo == 'US'">
                                        <a :href="'/placas/informe/' + ot_informe.id" class="btn btn-default btn-sm" title="Digitalización"><img width="16px" :src="'/img/IconoUS.ico'"></a>
                                    </td>
                                    <td v-if="!ot_informe.importable_sn" width="10px"> <a :href="'/pdf/informe/' + ot_informe.id " target="_blank"  class="btn btn-default btn-sm" title="Informe"><span class="fa fa-file-pdf-o"></span></a></td>
                                    <td v-else><a :href="'/' + ot_informe.path " target="_blank" title="Informe" class="btn btn-default btn-sm"><span class="fa fa-file-pdf-o"></span></a></td>
                                    <td v-if="!ot_informe.importable_sn" width="10px">
                                        <button @click="informesEscaneados(ot_informe.id)" :disabled="!$can('T_informes_edita')" class="btn btn-default btn-sm" title="Informes escaneados"><span class="fa fa-cloud-upload"></span></button>
                                    </td>
                                    <td v-if="!ot_informe.firma && !ot_informe.importable_sn" width="10px">
                                        <button @click="confirmarfirma(k)" class="btn btn-default btn-sm" title="Firmar" :disabled="!Permitefirmar(ot_informe.metodo)"><span class="glyphicon glyphicon-pencil"></span></button>
                                    </td>
                                    <td v-else-if="!ot_informe.importable_sn"><a class="btn btn-default btn-sm" title="Firmado"><img width="16px" :src="'/img/firma.png'"></a></td>
                                    <td>
                                        <button class="btn btn-default btn-sm" title="Revisiones" v-on:click.prevent="RevisionesInforme(ot_informe)"><span class="fa fa-table"></span></button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <pagination
                        :data="ot_informes" @pagination-change-page="getResults" :limit="3">
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                </div>
                <div v-if="loading_table" class="overlay">
                      <loading-spin></loading-spin>
                </div>
            </div>
        <div class="clearfix"></div>

        <informes-importables :metodo_ensayo="metodo_ensayo" :otdata="this.ot_data" @store="getResults(ot_informes.current_page)"></informes-importables>
        <informes-revisiones></informes-revisiones>
        <confirmar-modal></confirmar-modal>
        <loading :active.sync="isLoading"
            :loader="'bars'"
            :color="'red'">
        </loading>
    </div>
    </div>
</template>

<script>
import {mapState} from 'vuex'
import { eventNewRegistro, eventEditRegistro } from '../../event-bus';
import { eventModal } from '../../event-bus';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
export default {
    components: {

      Loading

    },
    props :{

    usuario_metodos_data : {
        type : Array,
        required : true,
    },

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
      metodo_selected:false,
      informe_id_select: 0,
      index_informe:0,
      loading_table : false,

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

        eventModal.$on('confirmar_accion',function(accion) {

            switch (accion) {
                case 'clonar':
                    this.ClonarInforme();
                    break;
                case 'revision':
                    this.EditInforme();
                    break;
                case 'firmar':
                    this.firmar();
                    break;
                default:
                    break;
            }

        }.bind(this));
  },

  mounted : function(){

      this.getResults();
      this.ContarInformes();
  },

  computed :{

       ...mapState(['url','CantInformes','DDPPI','ParametroGeneral','isLoading'])
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

            this.$store.commit('loading', true);
            this.$store.dispatch('loadParametrosGenerales','ddppi').then(response => {

                this.$store.dispatch('loadDDPPI',this.ot_data.id).then(response => {

                    if(this.DDPPI ){

                        if(this.metodo_ensayo.importable_sn){

                             this.$store.commit('loading', false);
                             eventNewRegistro.$emit('open',this.modelo);
                        }else{

                            window.location.href=  '/area/enod/ot/' + this.ot_data.id + '/informe/metodo/' + this.metodo_ensayo.metodo + '/create' ;
                        }
                    }
                    else
                    {

                        toastr.error('No se puede crear el informe. Existen informes de hace ' + this.ParametroGeneral.valor + ' días' + ' sin parte asociado' );
                         this.$store.commit('loading', false);
                    }

                });

            });
        },

        ContarInformes : function(){

                this.$store.dispatch('loadContarInformes',this.ot_data.id);

            },

        VerificarRevision : function(informe){
            this.informe_id_select = informe.id;
            if(informe.firma){

                eventModal.$emit('abrir_confirmar_accion','El informe ' + informe.numero_formateado  +' está firmado, la modificación generará una nueva revisión.','revision');

            }else{

                this.EditInforme();
            }

        },

        EditInforme : function(informe){

            this.$store.commit('loading', true);
            window.location.href =  '/area/enod/ot/' + this.ot_data.id + '/informe/' + this.informe_id_select + '/edit';

        },

        EditInformeImportable : function(informe_id){

            eventEditRegistro.$emit('edit',informe_id);

        },

        confirmarClanacion : function(k){
            this.index_informe = k;
            eventModal.$emit('abrir_confirmar_accion','Está seguro que quiere clonar el informe N° ' + this.ot_informes.data[this.index_informe].numero_formateado + ' ?','clonar' );

        },

        confirmarfirma : function(k){
            this.index_informe = k;
            eventModal.$emit('abrir_confirmar_accion','Está seguro de firmar el informe N° ' + this.ot_informes.data[this.index_informe].numero_formateado + ' ?','firmar' );

        },

         async ClonarInforme (){

          this.loading_table = true;
          axios.defaults.baseURL = this.url ;
          var urlRegistros = 'informes/' + this.ot_informes.data[this.index_informe].id + '/clonar';
          await axios.put(urlRegistros).then(response => {
                this.getResults();
                this.ContarInformes();
                toastr.success('El Informe N° ' + this.ot_informes.data[this.index_informe].numero_formateado + ' fue clonado con éxito');

            }).catch(error => {
                this.errors = error.response.data.errors;
                $.each( this.errors, function( key, value ) {
                    toastr.error(value);
                    console.log( key + ": " + value );
                });

                    if((typeof(this.errors)=='undefined') && (error)){

                    toastr.error("Ocurrió un error al procesar la solicitud");

            }
            }).finally(()=> { this.loading_table = false;});


        },

        async firmar (){

            this.loading_table = true;
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'informes/' + this.ot_informes.data[this.index_informe].id + '/firmar';
            await axios.put(urlRegistros).then(response => {
            this.ot_informes.data[this.index_informe].firma = response.data.firma;
            toastr.success('El Informe N° '+ this.ot_informes.data[this.index_informe].numero_formateado +'  fue firmado con éxito');

            }).catch(error => {
                this.errors = error.response.data.errors;
                $.each( this.errors, function( key, value ) {
                    toastr.error(value);
                    console.log( key + ": " + value );
                });

                    if((typeof(this.errors)=='undefined') && (error)){

                    toastr.error("Ocurrió un error al procesar la solicitud");

                }
            }).finally(()=> { this.loading_table = false;});

        },

        informesEscaneados(id){

            window.location.href =  '/documentos-escaneados/ot/' + this.ot_data.id + '/informe/' + id ;

        },

        RevisionesInforme : function(registro){

            eventModal.$emit('open_revisiones', registro,this.ot_data);

        },

         selectPosInforme : function(index){

            this.index_informe = JSON.parse(JSON.stringify(index));

         },

        Permitefirmar : function(metodo){

            return (this.usuario_metodos_data.findIndex(elem => elem.metodo == metodo) == -1) ? false : true;

        }

        },

}
</script>
