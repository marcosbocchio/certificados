<template>
    <div class="row">
       <back-dashboard></back-dashboard>
       <div class="col-lg-12">
         <a @click="EntrarCuadro('certificados')">
          <cuadro-largo-enod
              :titulo = "'CERTIFICADOS'"
              :class_color_titulo = "'color_2'"
              :class_color_sub_titulo = "'color_1'"
              :cantidad_1 ="CantCertificados"
              :src_icono ="'/img/tablero/icono-enod-certificados.svg'"
              :class_color_cuadro = "'bg-custom-8'"
              :class_color_cuadro_largo = "'bg-custom-2'"
              :habilitado_sn =" $can('T_certif_acceder') ?  true : false"
              :class_footer_img ="'footer-proc-cert'"
          >
          </cuadro-largo-enod>
         </a>
       </div>

        <div class="col-md-12">
            <div v-show="$can('T_certif_edita')">
                <a :href="'/area/enod/ot/' + ot_id_data + '/certificado' " class="btn btn-enod pull-left"> <span class="fa fa-plus-circle"></span> Nuevo</a>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="col-md-12">
            <div class="box box-custom-enod top-buffer">
                <div class="box-header with-border">
                    <h3 class="box-title">Certificados asignados a la orden de trabajo</h3>

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
                                    <th class="col-lg-2">N°</th>
                                    <th class="col-lg-9">Fecha</th>
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
                                        <a :href="'/pdf/certificado/' + ot_certificado.id + '/original' " target="_blank"  class="btn btn-default btn-sm" title="Informe original"><span class="fa fa-file-pdf-o"></span></a>
                                    </td>

                                    <td width="10px">
                                        <a :href="'/pdf/certificado/' + ot_certificado.id + '/final' " target="_blank"  class="btn btn-default btn-sm" title="Informe"><span class="fa fa-file-pdf-o"></span></a>
                                    </td>
                                    <td width="10px">
                                        <button @click="informesEscaneados(ot_certificado.id)" :disabled="!$can('T_certif_edita')" class="btn btn-default btn-sm" title="Informes escaneados"><span class="fa fa-cloud-upload"></span></button>
                                    </td>
                                    <td width="10px">
                                        <button @click="exportarAExcel(ot_certificado.id)" class="btn btn-default btn-sm" title="Informes escaneados"><span class="fa fa-file-excel-o"></span></button>
                                    </td>                                    
                                    <td v-if="!ot_certificado.firma" width="10px">
                                        <button @click="confirmarfirma(k)" class="btn btn-default btn-sm" title="Firmar" :disabled="!$can('T_certif_edita')"><span class="glyphicon glyphicon-pencil"></span></button>
                                   </td>
                                   <td v-else><a class="btn btn-default btn-sm" title="Firmado"><img width="16px" :src="'/img/firma.png'"></a></td>

                               </tr>
                            </tbody>
                        </table>
                    </div>
                    <pagination
                        :data="ot_certificados" @pagination-change-page="getResults" :limit="3">
                        <span slot="prev-nav">&lt; Previous</span>
                        <span slot="next-nav">Next &gt;</span>
                    </pagination>
                </div>
                <div v-if="loading_table" class="overlay">
                      <loading-spin></loading-spin>
                </div>
            </div>
        </div>
        <confirmar-modal></confirmar-modal>

    </div>
</template>

<script>
import { eventModal } from '../../event-bus';
import {mapState} from 'vuex'
import XLSX from 'xlsx'
import {sprintf} from '../../../functions/sprintf.js'
import moment from 'moment';

export default {

    props :{

     ot_id_data : '',

  },

  data () { return {

      ot_certificados :{},
      index_certificado:false,
      loading_table : false,
    }

  },

  created : function() {

    this.getResults();
    this.$store.dispatch('loadContarCertificados',this.ot_id_data);

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

  computed: {
       ...mapState(['url','CantCertificados'])
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

            window.location.href ='/area/enod/ot/' + this.ot_id_data + '/certificado/' + id +'/edit'
        },

        confirmarfirma : function(k){
            this.index_certificado = k;
            eventModal.$emit('abrir_confirmar_accion','Está seguro de firmar el certificado N° ' + this.ot_certificados.data[this.index_certificado].numero_formateado + ' ?','firmar' );

        },

        exportarAExcel: async function (id, estado = 'final') {
            
            let data
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'certificados/id/'+ id + '/estado/' + estado + '?api_token=' + Laravel.user.api_token;
            await axios.get(urlRegistros).then(response =>{
               data = response.data
               console.log(data)
            });
            
            var rowsCertificadoParte = await this.getCertificadosParteData(data)
            var rowsCertificadoServiciosParte = await this.getCertificadosServiciosData(data)
            var rowsCertificadoProdutoParte = await this.getCertificadosProductoData(data)
            var rowsCertificadoServiciosTotaltes = await this.getCertificadosServiciosTotaltesData(data)
            var rowsCertificadoProductoTotaltes = await this.getCertificadosProductosTotaltesData(data)

            const cellsMerge = [ { s: {c:0, r:0}, e: {c:8, r:0} },
                                 { s: {c:0, r:1}, e: {c:8, r:1} },
                                 { s: {c:0, r:2}, e: {c:8, r:2} },
                                 { s: {c:0, r:3}, e: {c:8, r:3} },
                                 { s: {c:0, r:4}, e: {c:8, r:4} },

                                 { s: {c:0, r:6}, e: {c:0, r:7} },
                                 { s: {c:1, r:6}, e: {c:1, r:7} },
                                 { s: {c:2, r:6}, e: {c:2, r:7} },
                                 { s: {c:3, r:6}, e: {c:11, r:6} },
                                 { s: {c:12, r:6}, e: {c:28, r:6} }
                                ]
            var ws = XLSX.utils.aoa_to_sheet([ "SheetJS".split("") ]);
            /* Header de la tabla*/ 
            var unidad_medida = (data.modalidadCobro == 'COSTURAS') ? '"' : 'Cm'
            XLSX.utils.sheet_add_aoa(ws, [['Día','Parte','Obra','SERVICIOS']], {origin: "A7"});
            XLSX.utils.sheet_add_aoa(ws, [[data.modalidadCobro + ' en ' + unidad_medida]], {origin: "M7"});            
            XLSX.utils.sheet_add_aoa(ws, [data.servicios_abreviaturas], {origin: "D8"});
            XLSX.utils.sheet_add_aoa(ws, [data.productos_unidades_medidas], {origin: "M8"});

            XLSX.utils.sheet_add_json(ws, rowsCertificadoParte, { skipHeader: true, origin: 'A9' })
            XLSX.utils.sheet_add_json(ws, rowsCertificadoServiciosParte.concat(rowsCertificadoServiciosTotaltes), { skipHeader: true, origin: 'D9' })
            XLSX.utils.sheet_add_json(ws, rowsCertificadoProdutoParte.concat(rowsCertificadoProductoTotaltes), { skipHeader: true, origin: 'M9' })
            XLSX.utils.sheet_add_json(ws, data.servicios_footer, { skipHeader: true, origin: -1 })

            /* Header de Excel */
            ws.A1 = { v: 'CERTIFICADO Nº: ' + sprintf("%08d",data.certificado.numero) + ' / ' + data.certificado.titulo}
            ws.A2 = { v: 'FECHA: ' + moment(data.certificado.fecha).format('DD-MM-YYYY') }
            ws.A3 = { v: 'CLIENTE: ' + data.cliente.nombre_fantasia }
            ws.A4 = { v: 'PROYECTO: ' + data.ot.proyecto }
            ws.A5 = { v: ('OBRA: ' + (data.ot.obra ? data.ot.obra : ' - ') + ' / OT Nº: ' + data.ot.numero + ' / FST Nº: ' + data.ot.presupuesto) }
            // Combino las columnas que están definidas en cellMerge
            cellsMerge.forEach(function (item) {
                // var merge = XLSX.utils.decode_range(item)
                if (!ws['!merges']) ws['!merges'] = []
                ws['!merges'].push(item)
            })  
            const wb = XLSX.utils.book_new()
            XLSX.utils.book_append_sheet(wb, ws, 'SheetJS')
            XLSX.writeFile(wb, 'CERTIFICADO-' + sprintf("%08d",data.certificado.numero) + '.xlsx')            
        },

        getCertificadosParteData: async function (data) {

          var resultado =  data.partes_certificados.map(function(obj) {
                var objTemp = {}
                objTemp.fecha = obj.fecha_formateada
                objTemp.parte_numero = obj.parte_numero
                objTemp.obra =  !data.ot.obra ? obj.obra : ''                
                return objTemp 
            })
        return resultado
        },

        getCertificadosServiciosData: async function (data) {

          var resultado =  data.partes_certificados.map(function(obj) {
                var objTemp = {}               
                data.servicios_abreviaturas.forEach (function(item_abreviatura,index) {
                    var existeServicioEnParte = false
                    data.servicios_parte.forEach(function(item_servicio) {
                        if ((item_abreviatura == item_servicio.abreviatura)&&(item_servicio.parte_numero == obj.parte_numero)) {
                            objTemp[index] = item_servicio.cantidad
                            existeServicioEnParte = true
                        } 
                    })
                    
                    if (!existeServicioEnParte) objTemp[index] = ''                        

                } )
                return objTemp 
            }.bind(this))
        return resultado
        },  
        getCertificadosProductoData: async function (data) {

          var resultado =  data.partes_certificados.map(function(obj) {
                var objTemp = {}               
                data.productos_unidades_medidas.forEach (function(item_pro_uni_med,index) {
                    var existeProductoEnParte = false
                    data.productos_parte.forEach(function(item_producto) {
                        if ((item_pro_uni_med == item_producto.unidad_medida_producto)&&(item_producto.parte_numero == obj.parte_numero)) {
                            objTemp[index] = item_producto.cantidad
                            existeProductoEnParte = true
                        }  
                    })

                    if (!existeProductoEnParte) objTemp[index] = ''

                } )
                return objTemp 
            }.bind(this))
        return resultado
        },          

        getCertificadosServiciosTotaltesData: async function (data) {
            var resultado = []
            var objTemp = {}
                data.servicios_abreviaturas.forEach(function(obj,index) {
                    var total_servicio = 0;
                    data.servicios_parte.forEach(function(item_servicio) {
                        if(obj == item_servicio.abreviatura) {
                            total_servicio += item_servicio.cantidad
                        }
                    })
                objTemp[index] = total_servicio
            }.bind(this))            
            resultado.push(objTemp)
            return resultado
        },

        getCertificadosProductosTotaltesData: async function (data) {
            var resultado = []
            var objTemp = {}
                data.productos_unidades_medidas.forEach(function(obj,index) {
                    var total_producto = 0;
                    data.productos_parte.forEach(function(item_producto) {
                        if(obj == item_producto.unidad_medida_producto) {
                            total_producto += item_producto.cantidad
                        }
                    })
                objTemp[index] = total_producto
            }.bind(this))            
            resultado.push(objTemp)
            return resultado
        },        
        firmar: function() {
            this.loading_table = true;
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'certificados/' + this.ot_certificados.data[this.index_certificado].id + '/firmar';
            axios.put(urlRegistros).then(response => {
                console.log(response.data);
                this.ot_certificados.data[this.index_certificado].firma = response.data.firma;
                toastr.success('El Certificado N° ' + this.ot_certificados.data[this.index_certificado].numero_formateado + ' fue firmado con éxito');

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

            window.location.href ='/documentos-escaneados/ot/' + this.ot_id_data + '/certificado/' + id ;

        }

    },


}
</script>
