<template>
 <div class="row">
      <back-dashboard></back-dashboard>
       <div class="col-lg-12">
          <cuadro-largo-enod
              :titulo = "'PARTES'"
              :class_color_titulo = "'color_3'"
              :class_color_sub_titulo = "'color_2'"
              :cantidad_1 ="CantPartes"
              :src_icono ="'/img/tablero/icono-enod-partes.svg'"
              :class_color_cuadro = "'bg-custom-7'"
              :class_color_cuadro_largo = "'bg-custom-5'"
              :habilitado_sn =" $can('T_partes_acceder') ?  true : false"
              :class_footer_img ="'footer-equipos-partes'"
          >
          </cuadro-largo-enod>
       </div>
       <div v-show="parte_esp == 1">

       
       <div class="clearfix"></div>

        <div class="col-md-12">
           <div v-show="$can('T_partes_edita')">
                <a :href="'/area/enod/ot/' + ot_id_data + '/parte-manual' " class="btn btn-enod pull-left"><span class="fa fa-plus-circle"></span> Nuevo</a>
           </div>
        </div>
        <div class="col-md-12">
            <div class="box box-custom-enod top-buffer">
                <div class="box-header with-border">
                    <h3 class="box-title">Parte manual</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th class="col-sm-4">Numero</th>
                                    <th class="col-lg-4">Usuario alta</th>
                                    <th class="col-sm-4">Fecha</th>
                                    <th class="col-sm-2">&nbsp;</th> <!-- Columna para botón de editar -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí iterarás sobre los datos para mostrar las filas -->
                                <tr v-for="(parte, index) in partes.data" :key="index">
                                    <td>{{ parte.numero_formateado }}</td>
                                    <td>{{ parte.nombre_usuario }}</td>
                                    <td>{{ parte.fecha_formateada }}</td>
                                    <td width="10px">
                                        <!-- Botón de editar -->
                                        <button @click="editParteManual(parte.id)" class="btn btn-warning btn-sm">
                                            <span class="fa fa-edit"></span>
                                        </button>
                                    </td>
                                    <td width="10px">
                                        <button @click="informesEscaneadosManual(parte.id)" class="btn btn-default btn-sm" title="Informes escaneados"><span class="fa fa-cloud-upload"></span></button>
                                    </td>
                                    <td width="10px">
                                        <!-- Botón de PDF -->
                                        <button @click="generatePDFManual(parte.id)" class="btn btn-default btn-sm">
                                            <span class="fa fa-file-pdf-o"></span>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <pagination
                        :data="partes" 
                        @pagination-change-page="fetchPartesPaginadas"
                        :limit="3">
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                </div>
            </div>
        </div>
    </div>        
                <div class="col-md-12">
           <div v-show="$can('T_partes_edita')">
                <a :href="'/area/enod/ot/' + ot_id_data + '/parte' " class="btn btn-enod pull-left"><span class="fa fa-plus-circle"></span> Nuevo</a>
           </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12">
            <div class="box box-custom-enod top-buffer">
                <div class="box-header with-border">
                    <h3 class="box-title">Partes asignados a la orden de trabajo</h3>

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
                                    <th class="col-sm-4">N°</th>
                                    <th class="col-sm-3">Tipo Servicio</th>
                                    <th class="col-lg-3">Usuario alta</th>
                                    <th class="col-sm-2">Fecha</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(ot_parte,k) in ot_partes.data" :key="k">
                                    <td> {{ot_parte.numero_formateado}}</td>
                                    <td> {{ot_parte.tipo_servicio}} </td>
                                    <td>{{ ot_parte.name }}</td>
                                    <td> {{ot_parte.fecha}}</td>
                                    <td width="10px">
                                        <button @click.prevent="editParte(ot_parte.id)" class="btn btn-warning btn-sm" title="Editar" :disabled="!$can('T_partes_edita')"><span class="fa fa-edit"></span></button>
                                    </td>

                                    <td width="10px" v-show="$can('T_partes_edita')">
                                        <a :href="'/pdf/parte/' + ot_parte.id + '/original' " target="_blank"  class="btn btn-default btn-sm" title="Informe original"><span class="fa fa-file-pdf-o"></span></a>
                                    </td>

                                    <td width="10px">
                                        <a :href="'/pdf/parte/' + ot_parte.id + '/final' " target="_blank"  class="btn btn-default btn-sm" title="Informe"><span class="fa fa-file-pdf-o"></span></a>
                                    </td>
                                    <td width="10px">
                                        <button @click="informesEscaneados(ot_parte.id)" :disabled="!$can('T_partes_edita')" class="btn btn-default btn-sm" title="Informes escaneados"><span class="fa fa-cloud-upload"></span></button>
                                    </td>
                                    <td v-if="!ot_parte.firma" width="10px">
                                        <button @click="confirmarfirma(k)" class="btn btn-default btn-sm" title="Firmar" :disabled="!$can('T_partes_edita')"><span class="glyphicon glyphicon-pencil"></span></button>
                                   </td>
                                   <td v-else><a class="btn btn-default btn-sm" title="Firmado"><img width="16px" :src="'/img/firma.png'"></a></td>

                               </tr>
                            </tbody>
                        </table>
                    </div>
                    <pagination
                        :data="ot_partes" @pagination-change-page="getResults" :limit="3" >
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                </div>
                <div v-if="loading_table" class="overlay">
                      <loading-spin></loading-spin>
                </div>
            </div>
        </div>
    <div class="clearfix"></div>
    <confirmar-modal></confirmar-modal>
 </div>
</template>
<script>
import { eventModal } from '../../event-bus';
import {mapState} from 'vuex'
export default {
    props :{

     ot_id_data : '',
     ot_data:{},
     parte_esp:'',

  },

  data () { return {

      ot_partes :{},
      index_parte:0,
      loading_table : false,
      partes: [],
    }
  },
  created : function() {
    this.getResults();
    this.fetchPartesPaginadas();
    this.$store.dispatch('loadContarPartes',this.ot_id_data);

    eventModal.$on('confirmar_accion',function(accion) {

        switch (accion) {
            case 'firmar':
                this.firmar();
                break;
            default:
                break;
        }

    }.bind(this));

  },

  computed :{

       ...mapState(['url','CantPartes'])
     },

  methods : {
    fetchPartesPaginadas(page = 1) {
    axios.get(`partes-manuales/paginate?ot_id=${this.ot_data.id}&page=${page}`)
    .then(response => {
        this.partes = response.data;  // Asegúrate de que la respuesta contiene los datos de paginación esperados
        console.log(this.partes); // Esto te ayudará a verificar que la paginación funciona correctamente
    })
    .catch(error => {
        if (error.response) {
            console.error('Error al obtener partes manuales:', error.response.status);
        } else if (error.request) {
            console.error('Error al realizar la solicitud:', error.request);
        } else {
            console.error('Error:', error.message);
        }
    });
},
      getResults :function(page = 1){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'partes/ot/' + this.ot_id_data + '/paginate' + '?page='+ page;
            axios.get(urlRegistros).then(response =>{
            this.ot_partes = response.data
            });

        },
        editParteManual(id) {
            // Método para redireccionar a la página de edición del parte con el ID proporcionado
            window.location.href = '/partes-manuales/' + id + '/edit'; // Modifiqué la ruta para editar
        },
        generatePDFManual(id) {
            console.log(id);
            window.open('/pdf-partemanual/' + id, '_blank'); // Modifiqué la ruta para el PDF
        },
        editParte : function(id){

            window.location.href =  '/area/enod/ot/' + this.ot_id_data + '/parte/' + id +'/edit'
        },

        confirmarfirma : function(k){
            this.index_parte = k;
            eventModal.$emit('abrir_confirmar_accion','Está seguro de firmar el parte N° ' + this.ot_partes.data[this.index_parte].numero_formateado + ' ?','firmar' );

        },

        firmar : function(){

            this.loading_table = true;
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'partes/' + this.ot_partes.data[this.index_parte].id + '/firmar';
            axios.put(urlRegistros).then(response => {
            console.log(response.data);
            this.ot_partes.data[this.index_parte].firma = response.data.firma;
            toastr.success('El Parte N° ' + this.ot_partes.data[this.index_parte].numero_formateado + ' fue firmado con éxito');

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

            window.location.href =  '/documentos-escaneados/ot/' + this.ot_id_data + '/partemanual/' + id ;

        },
        informesEscaneadosManual(id){

            window.location.href =  '/documentos-escaneados/ot/' + this.ot_id_data + '/partemanual/' + id ;

        }
    },
}
</script>
