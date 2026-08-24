<template>
    <div class="row">
        <div class="col-md-12">
            <form @submit.prevent="editmode ?  Update() : Store()"  method="post">
                <certificado-header :otdata="otdata" :certificado_sn="true"></certificado-header>
                    <div class="box box-custom-enod">
                         <div class="box-body">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Fecha *</label>
                                    <div>
                                        <date-picker v-model="fecha" value-type="YYYY-MM-DD" format="DD-MM-YYYY" placeholder="DD-MM-YYYY" ></date-picker>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group" >
                                    <label for="numero">Certificado N° </label>
                                    <input type="number" v-model="numero_code" class="form-control" id="numero" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Título</label>
                                    <input v-model="titulo" class="form-control" placeholder="" maxlength="40">
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Información adicional</label>
                                    <textarea v-model="info_pedido_cliente" class="form-control noresize" rows="2" placeholder="" maxlength="100"></textarea>
                                </div>
                            </div>

                         </div>
                     </div>

                    <div class="box box-custom-enod">
                        <div class="box-header with-border">
                            <h3 class="box-title">Partes sin certificados</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-default btn-sm" @click="limpiarTodo" :disabled="loading" title="Limpiar Todo">
                                    <app-icon img="trash" color="black"></app-icon>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                         <div class="box-body">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped table-condensed">
                                    <thead>
                                        <tr>
                                            <th class="col-md-1">Sel.</th>
                                            <th class="col-md-3">Parte N°</th>
                                            <th class="col-md-3">Obra</th>
                                            <th class="col-md-3">Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(parte,k) in partes" :key="k">
                                            <td>
                                                <input type="checkbox" :id="'informe_sel_'+k" v-model="partes[k].parte_sel" @change="getPartes(k)" :disabled="loading">
                                            </td>
                                            <td>{{ parte.numero_formateado}}</td>
                                            <td>{{ parte.obra}}</td>
                                            <td>{{ parte.fecha_formateada}}</td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div v-if="loading" class="overlay">
                              <loading-spin></loading-spin>
                        </div>
                    </div>

                    <div v-show="TablaPartesServicios.length">
                        <div class="box box-custom-enod">
                            <div class="box-header with-border">
                                <h3 class="box-title">Servicios</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped table-bordered table-condensed">
                                        <thead>
                                            <tr>
                                                <th class="col-md-1">Parte N°</th>
                                                <th class="col-md-1">Obra</th>
                                                <th class="col-md-2">Servicio</th>
                                                <th class="col-md-4">Descripción</th>
                                                <th class="col-md-1">Fecha</th>
                                                <th class="col-md-1">Combinación</th>
                                                <th class="col-md-1">&nbsp;</th>
                                                <th class="col-md-1">Cantidad</th>
                                            <th class="col-md-1">&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item,k) in TablaPartesServicios" :key="k" @click="selectPosTablaPartesServicios(k)">

                                                <td v-if="item.visible">{{ item.numero_formateado}}</td>
                                                <td v-if="item.visible">{{ item.obra}}</td>
                                                <td v-if="item.visible">{{ item.abreviatura}}</td>
                                                <td v-if="item.visible">{{ item.servicio_descripcion}}</td>

                                                <td v-if="item.visible">{{ item.fecha_formateada}}</td>
                                                <td  v-if="item.visible">

                                                    <div class="input-group col-xs-12">
                                                        <input type="number" :id="'nro_combinacion_'+k" class="form-control form-group-xs text-center"  maxlength="2" v-model="TablaPartesServicios[k].nro_combinacion" disabled >

                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-md btn-default" v-if="!TablaPartesServicios[k].manual_uncombined_sn && Number(TablaPartesServicios[k].nro_combinacion) > 0" @click="borrarCombinacionIndex(k)">X</button>
                                                            <button type="button" class="btn btn-md btn-default" v-else @click="revertirCombinacionIndex(k)" title="Volver a combinación">
                                                                <i class="fa fa-undo"></i>
                                                            </button>
                                                        </span>

                                                    </div>
                                                </td>
                                                <td  v-if="item.visible">
                                                    <span style="display: inline-block;">
                                                        {{ item.combinacion}}
                                                    </span>

                                                </td>


                                                <td v-if="item.visible" style="text-align: center;">
                                                    <div v-if="indexTablaPartesServicios == k ">
                                                        <input type="number" v-model="TablaPartesServicios[k].cant_final"  maxlength="2" style="width: 50px;">
                                                    </div>
                                                    <div v-else>
                                                        {{ item.cant_final }}
                                                    </div>
                                                </td>
                                                <td style="text-align:center" v-if="item.visible">
                                                    <a  @click="RemoveTablaPartesServicios(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a>
                                                </td>

                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div v-if="loading" class="overlay">
                                  <loading-spin></loading-spin>
                            </div>
                        </div>
                    </div>

                    <div v-show="TablaPartesProductosPorCosturas.length && modo_cobro=='COSTURAS'">
                        <div class="box box-custom-enod">
                            <div class="box-header with-border">
                                <h3 class="box-title">Productos</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped table-condensed">
                                        <thead>
                                            <tr>
                                                <th class="col-md-3">Parte N°</th>
                                                <th class="col-md-3">Costuras</th>
                                                <th class="col-md-3">Pulgadas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item,k) in TablaPartesProductosPorCosturas" :key="k" @click="selectPosTablaPartesProductosPorCosturas(k)">
                                                <td>{{ item.numero_formateado}}</td>
                                                <td>
                                                   <div v-if="indexTablaPartesProductosPorCosturas == k ">
                                                        <input type="number" v-model="TablaPartesProductosPorCosturas[k].costuras_final" maxlength="10">
                                                    </div>
                                                    <div v-else>
                                                        {{ item.costuras_final }}
                                                    </div>

                                                </td>
                                                <td>{{ item.pulgadas}}</td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div v-if="loading" class="overlay">
                                  <loading-spin></loading-spin>
                            </div>
                        </div>
                    </div>

                    <div v-show="TablaPartesProductosPorPlacas.length && modo_cobro=='PLACAS'">
                        <div class="box box-custom-enod">
                            <div class="box-header with-border">
                                <h3 class="box-title">Productos</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped table-condensed">
                                        <thead>
                                            <tr>
                                                <th class="col-md-3">Parte N°</th>
                                                <th class="col-md-3">Placas</th>
                                                <th class="col-md-3">CM</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item,k) in TablaPartesProductosPorPlacas" :key="k" @click="selectPosTablaPartesProductosPorPlacas(k)">
                                                <td>{{ item.numero_formateado}}</td>
                                                <td>
                                                    <div v-if="indexTablaPartesProductosPorPlacas == k ">
                                                        <input type="number" v-model="TablaPartesProductosPorPlacas[k].placas_final" maxlength="10">
                                                    </div>
                                                    <div v-else>
                                                        {{ item.placas_final }}
                                                    </div>
                                                </td>
                                                <td>{{ item.cm}}</td>

                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div v-if="loading" class="overlay">
                                  <loading-spin></loading-spin>
                            </div>
                        </div>
                    </div>
                <div class="enod-form-actions enod-form-actions--end">
                    <button class="btn btn-enod" type="submit" :disabled="loading">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import {mapState} from 'vuex';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/es';
import {sprintf} from '../../functions/sprintf.js'
import moment from 'moment';

export default {

    components: {
        DatePicker,

    },

    props : {

      editmode : {
        type : Boolean,
        required : false,
        default : false
      },

      otdata : {
        type : Object,
        required : true
      },

      certificado_data : {
     type : Object,
      required : false
      },

      servicios_data : {
      type : [ Array ],
      required : false
      },

      productos_placas_data : {
      type : [ Array ],
      required : false
      },

      productos_costura_data : {
      type : [ Array ],
      required : false
      },
    },

    data () { return{

        errors:[],
        numero:'',
        titulo :'',
        fecha: moment(new Date()).format('YYYY-MM-DD'),
        info_pedido_cliente:'',
        partes:[],
        modo_cobro:'',
        TablaPartesServicios:[],
        TablaPartesProductosPorPlacas:[],
        TablaPartesProductosPorCosturas:[],
        indexTablaPartesProductosPorPlacas:-1,
        indexTablaPartesProductosPorCosturas:-1,
        indexTablaPartesServicios:-1,
        loading : false,
       }
    },

    created : function() {

        this.CargaDeDatos();

    },

      mounted : function() {

        this.getModalidadCobro();
        this.getNumeroCertificado();

      },

    computed :{

        ...mapState(['url']),

        numero_code : function()  {

               if(this.numero){

                   return   sprintf("%08d",this.numero) ;

               }
        },

        partes_sel: function() {
            return this.partes.filter(e => e.parte_sel)
        },
     },

      methods : {

          CargaDeDatos : function(){

             if(this.editmode) {

                this.fecha  = this.certificado_data.fecha;
                this.numero = this.certificado_data.numero;
                this.titulo = this.certificado_data.titulo;
                this.info_pedido_cliente = this.certificado_data.info_pedido_cliente;

                this.$nextTick(function(){

                   this.setCerficadoServicios();
                   this.setCerficadoProductos();
                   this.getPartesPendientesYEditableCertificado();

               });

             }else{

                  this.getPartesPendientesCertificado();

             }

          },

        getModalidadCobro : function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'certificados/ot/' + this.otdata.id + '/modalidad_cobro' + '?api_token=' + Laravel.user.api_token;
            axios.get(urlRegistros).then(response =>{

                let reg = response.data;
                this.modo_cobro = reg.length ? 'COSTURAS' : 'PLACAS'

            });
        },

        async getPartes(index){

           this.loading = true;
           if(this.partes[index].parte_sel){

                this.partes.forEach(function(item){

                    item.parte_sel = false ;

                }.bind(this));
                this.TablaPartesServicios = [];
                this.TablaPartesProductosPorPlacas = [];
                this.TablaPartesProductosPorCosturas = [];
                await this.seleccionarAnteriores(index);

            }else{

                    this.deleteServiciosParte(this.partes[index].id)
                    this.deleteProductosParte(this.partes[index].id)

            }
           this.loading = false;
        },

        async  seleccionarAnteriores(index){

            this.partes[index].parte_sel = false;
            const idsEnRango = this.partes.slice(0, index + 1).map(function(p){ return p.id; });

            for ( let x = 0 ; x <= index; x++ ) {

                const isLast = x === index;
                const otrosIds = idsEnRango.filter(function(id){ return id !== this.partes[x].id; }.bind(this));
                await this.getServiciosParte(this.partes[x].id, isLast);
                this.getProductosParte(this.partes[x].id, otrosIds);
                this.partes[x].parte_sel = true;

            }

            this.completarTitulo(index);

        },

        completarTitulo :  function(index){

           this.titulo = this.partes[0].fecha_formateada + ' - ' + this.partes[index].fecha_formateada ;

        },

        setCerficadoServicios : function(){

            this.TablaPartesServicios =  JSON.parse(JSON.stringify(this.servicios_data));

            this.TablaPartesServicios.forEach(function(item) {

                if(item.cant_final == null){
                    item.visible = false;
                }else{
                     item.visible = true;
                }
            }.bind(this))
        },

        getPartesPendientesYEditableCertificado : function(){

             axios.defaults.baseURL = this.url ;
             var urlRegistros = 'partes/ot/' + this.otdata.id + '/certificado/'+ this.certificado_data.id + '/pendientes_editables_certificado' + '?api_token=' + Laravel.user.api_token;
             axios.get(urlRegistros).then(response =>{
             this.partes = JSON.parse(JSON.stringify(response.data));

               /*  this.servicios_data.forEach(function(item){

                     if(this.partes.map(x => x.id).indexOf(item.parte_id) !== -1){

                         this.partes[this.partes.map(x => x.id).indexOf(item.parte_id)].parte_sel = true;
                     }


                 }.bind(this));

                 this.productos_costura_data.forEach(function(item){

                     if(this.partes.map(x => x.id).indexOf(item.parte_id) !== -1){

                         this.partes[this.partes.map(x => x.id).indexOf(item.parte_id)].parte_sel = true;
                     }


                 }.bind(this));

                 this.productos_placas_data.forEach(function(item){

                     if(this.partes.map(x => x.id).indexOf(item.parte_id) !== -1){

                         this.partes[this.partes.map(x => x.id).indexOf(item.parte_id)].parte_sel = true;
                     }


                 }.bind(this));
                */
            });

        },

        setCerficadoProductos : function(){

            this.TablaPartesProductosPorPlacas =  JSON.parse(JSON.stringify(this.productos_placas_data));
            this.TablaPartesProductosPorCosturas =  JSON.parse(JSON.stringify(this.productos_costura_data));

        },

        cargarCombinados : function(){

            const longServicios = this.TablaPartesServicios.length;
            if (longServicios === 0) {
                this.CompletarNoCombinados();
                return;
            }

            // Ordenar por fecha, obra y abreviatura para asegurar bloques contiguos por día
            this.TablaPartesServicios.sort((a, b) => {
                const da = new Date(a.fecha);
                const db = new Date(b.fecha);
                if (da - db !== 0) return da - db;
                if ((a.obra || '') < (b.obra || '')) return -1;
                if ((a.obra || '') > (b.obra || '')) return 1;
                if ((a.abreviatura || '') < (b.abreviatura || '')) return -1;
                if ((a.abreviatura || '') > (b.abreviatura || '')) return 1;
                return 0;
            });

            // Limpiar sólo los que no están descombinados manualmente, sin tocar prev_nro_combinacion
            this.TablaPartesServicios.forEach((item) => {
                if (!item.manual_uncombined_sn) {
                    item.nro_combinacion = '';
                    item.combinacion = '';
                }
            });

            // Agrupar por fecha_formateada (ignorar obra)
            const normalizeFecha = (s) => (s || '').replace(/-/g,'/');
            const groups = {};
            this.TablaPartesServicios.forEach((it, idx) => {
                const key = normalizeFecha(it.fecha_formateada);
                if (!groups[key]) {
                    groups[key] = { indices: [], abrev: new Set() };
                }
                groups[key].indices.push(idx);
                if (it.visible && it.combinado_sn && !it.manual_uncombined_sn) {
                    groups[key].abrev.add(it.abreviatura);
                }
            });

            // Generar etiqueta y asignar números por grupo (por fecha)
            let contador = 1;
            Object.keys(groups).sort().forEach((key) => {
                const abrevArray = Array.from(groups[key].abrev);
                if (abrevArray.length >= 2) {
                    abrevArray.sort((a, b) => a.toLowerCase().localeCompare(b.toLowerCase()));
                    const etiqueta = abrevArray.slice().reverse().join(' + ');
                    groups[key].indices.forEach((idx) => {
                        const it = this.TablaPartesServicios[idx];
                        if (!it.manual_uncombined_sn && it.visible && abrevArray.includes(it.abreviatura)) {
                            it.combinacion = etiqueta;
                            it.nro_combinacion = contador;
                        }
                    });
                    contador++;
                }
            });

            this.CompletarNoCombinados();

        },

        getAbrevCombinadas : function(fecha_inicial){

            let index = 0;
            let longServicios = this.TablaPartesServicios.length;
            let abreviaturas = [];
            while(moment(this.TablaPartesServicios[index].fecha).format('DD/MM/YYYY') != fecha_inicial){
                index++;
            }

            while((index < longServicios) && (moment(this.TablaPartesServicios[index].fecha).format('DD/MM/YYYY') == fecha_inicial) ){

                if ((this.TablaPartesServicios[index].combinado_sn)
                    && (!this.TablaPartesServicios[index].manual_uncombined_sn)
                    && (abreviaturas.findIndex(elemento => elemento == this.TablaPartesServicios[index].abreviatura) == -1)){

                        abreviaturas.push(this.TablaPartesServicios[index].abreviatura);
                    }
                index++;
            }


            abreviaturas.sort(function(a, b){return a.toLowerCase().localeCompare(b.toLowerCase());});
            let longAbreviaturas = abreviaturas.length;
            let concatenacion = '';
            index = longAbreviaturas - 1;
            while (index > -1 ) {

                concatenacion = !concatenacion ? abreviaturas[index] : (concatenacion + " + " + abreviaturas[index]);
                index = index - 1;
            }

            abreviaturas.push(concatenacion);

            return abreviaturas;
        },

       CompletarNoCombinados : function(){

        this.TablaPartesServicios.forEach(function(item){
                if(item.nro_combinacion == ''){
                    item.combinacion = item.abreviatura;
                }
            });
       },
       borrarCombinacion : function(nro){
           // Mantención backward-compat si se llamara por nro (no usado ahora)
           this.TablaPartesServicios.forEach(function(item){
               if(item.nro_combinacion == nro){
                   item.prev_nro_combinacion = item.nro_combinacion || null;
                   item.manual_uncombined_sn = true;
                   item.combinacion = '';
                   item.nro_combinacion = '';
               }
           }.bind(this));
           this.CompletarNoCombinados();
       },

       borrarCombinacionIndex : function(index){

           const ref = this.TablaPartesServicios[index];
           const normalize = (s) => (s || '').replace(/-/g,'/');
           const targetFecha = normalize(ref.fecha_formateada);
           const targetObra = ref.obra;
           const targetNro = ref.nro_combinacion;

           // Si no hay número de combinación válido, no hacer nada
           if (!targetNro || parseInt(targetNro) <= 0) {
               return;
           }

            // 1) Construir el grupo por fecha y nro
            const groupIndices = [];
            this.TablaPartesServicios.forEach(function(item, idx){
                if(item.nro_combinacion == targetNro
                  && normalize(item.fecha_formateada) == targetFecha){
                    groupIndices.push(idx);
                }
            });

            // 2) Detectar si en la obra clickeada hay combinación "intra-obra" (2+ abreviaturas)
            const abrevEnObra = new Set();
            groupIndices.forEach((idx) => {
                const it = this.TablaPartesServicios[idx];
                if (it.obra === targetObra && it.visible && !it.manual_uncombined_sn) {
                    abrevEnObra.add(it.abreviatura);
                }
            });
            const intraObra = abrevEnObra.size >= 2;

            if (intraObra) {
                // 3.a Descombinar TODO el grupo (misma fecha y nro)
                this.TablaPartesServicios.forEach(function(item){
                    if(item.nro_combinacion == targetNro
                      && normalize(item.fecha_formateada) == targetFecha){
                        item.prev_nro_combinacion = item.nro_combinacion || null;
                        item.manual_uncombined_sn = true;
                        item.combinacion = '';
                        item.nro_combinacion = '';
                    }
                }.bind(this));
            } else {
                // 3.b Descombinar SOLO el clickeado (obra "otra")
                this.TablaPartesServicios[index].prev_nro_combinacion = this.TablaPartesServicios[index].nro_combinacion || null;
                this.TablaPartesServicios[index].manual_uncombined_sn = true;
                this.TablaPartesServicios[index].combinacion = '';
                this.TablaPartesServicios[index].nro_combinacion = '';
            }

           this.CompletarNoCombinados();
       },

       revertirCombinacion : function(prevNro){
           // Buscar algún índice que cumpla y delegar a la versión por índice
           const idx = this.TablaPartesServicios.findIndex(item => item.manual_uncombined_sn && item.prev_nro_combinacion === prevNro);
           if (idx !== -1) {
               this.revertirCombinacionIndex(idx);
           }
       },

       revertirCombinacionIndex : function(index){

           const ref = this.TablaPartesServicios[index];
           const normalize = (s) => (s || '').replace(/-/g,'/');
           const targetFecha = normalize(ref.fecha_formateada);
           const targetObra = ref.obra;
           const prevNro = ref.prev_nro_combinacion;

           const fechaMatches = function (itm) { return normalize(itm.fecha_formateada) === targetFecha; };

           if (prevNro && parseInt(prevNro) > 0) {
               // 1) Restaurar el estado (salir de manual_uncombined y volver al nro original)
               this.TablaPartesServicios.forEach(function(item){
                   if(item.manual_uncombined_sn
                     && item.prev_nro_combinacion === prevNro
                     && fechaMatches(item)){
                       item.manual_uncombined_sn = false;
                       item.nro_combinacion = item.prev_nro_combinacion;
                   }
               }.bind(this));

               // 2) Recalcular SOLO la etiqueta del grupo restaurado (mismo día, misma obra y mismo nro)
               const abrev = [];
               this.TablaPartesServicios.forEach(function(it){
                   if (fechaMatches(it)
                       && !it.manual_uncombined_sn
                       && Number(it.nro_combinacion) === Number(prevNro)
                       && it.combinado_sn
                       && !abrev.includes(it.abreviatura)) {
                       abrev.push(it.abreviatura);
                   }
               });
               if (abrev.length >= 2) {
                   abrev.sort((a, b) => a.toLowerCase().localeCompare(b.toLowerCase()));
                   const etiqueta = abrev.slice().reverse().join(' + ');
                   this.TablaPartesServicios.forEach(function(it){
                       if (fechaMatches(it)
                           && !it.manual_uncombined_sn
                           && Number(it.nro_combinacion) === Number(prevNro)
                           && abrev.includes(it.abreviatura)) {
                           it.combinacion = etiqueta;
                       }
                   });
                   // Garantizar que la fila de referencia tenga la etiqueta
                   ref.combinacion = etiqueta;
               }
           } else {
               // No hay número previo: crear uno nuevo si hay condiciones para combinar
               // 1) Encontrar abreviaturas combinables en el día/obra, incluyendo SIEMPRE la del item ref
               const targetAbrev = ref.abreviatura;
               const abrev = [];
               this.TablaPartesServicios.forEach(function(it){
                   if (fechaMatches(it)
                       && it.combinado_sn
                       && (!it.manual_uncombined_sn || it === ref)
                       && !abrev.includes(it.abreviatura)) {
                       abrev.push(it.abreviatura);
                   }
               });

               if (abrev.includes(targetAbrev) && abrev.length >= 2) {
                   // 2) Calcular el nuevo número GLOBAL: max existente en toda la tabla + 1
                   let maxNro = 0;
                   this.TablaPartesServicios.forEach(function(it){
                       const n = parseInt(it.nro_combinacion || 0);
                       if (!isNaN(n) && n > maxNro) maxNro = n;
                   });
                   const newNro = maxNro + 1;

                   // 3) Armar etiqueta
                   abrev.sort((a, b) => a.toLowerCase().localeCompare(b.toLowerCase()));
                   const etiqueta = abrev.slice().reverse().join(' + ');

                   // 4) Asignar combinación SOLO a los ítems del día/obra con esas abreviaturas
                   this.TablaPartesServicios.forEach(function(it){
                       if (fechaMatches(it)
                           && it.combinado_sn
                           && abrev.includes(it.abreviatura)) {
                           it.manual_uncombined_sn = false;
                           it.prev_nro_combinacion = newNro;
                           it.nro_combinacion = newNro;
                           it.combinacion = etiqueta;
                       }
                   });
                   // Garantizar que la fila de referencia tenga el número y la etiqueta
                   ref.manual_uncombined_sn = false;
                   ref.prev_nro_combinacion = newNro;
                   ref.nro_combinacion = newNro;
                   ref.combinacion = etiqueta;
               }
           }

           // 3) Completar los que no quedaron combinados
           this.CompletarNoCombinados();
       },

       descombinarItem : function(index){

           let it = this.TablaPartesServicios[index];
           it.manual_uncombined_sn = true;
           it.nro_combinacion = '';
           it.combinacion = it.abreviatura;

       },

       recombinarItem : function(index){

           let it = this.TablaPartesServicios[index];
           it.manual_uncombined_sn = false;
           this.cargarCombinados();

       },

        async getServiciosParte(id, recompute = true){

        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'certificados/parte/' + id + '/servicios' + '?api_token=' + Laravel.user.api_token;
        let res = await axios.get(urlRegistros);
        let parte_servicios = await res.data;
        parte_servicios.forEach(function(item) {

            let cantidad = (Math.round(item.cantidad * 100) / 100).toFixed(2);
            this.TablaPartesServicios.push({

                parte_id : item.parte_id,
                numero_formateado : item.numero_formateado,
                unidades_medidas_id : item.unidad_medida_id,
                unidad_medida_codigo:item.unidad_medida_codigo,
                servicio_id : item.servicio_id,
                servicio_descripcion : item.servicio_descripcion,
                cant_original: cantidad,
                cant_final: cantidad,
                abreviatura :item.abreviatura,
                visible : true,
                nro_combinacion : 0,
                prev_nro_combinacion : null,
                combinado_sn :item.combinado_sn,
                manual_uncombined_sn : false,
                combinacion : '',
                obra : item.obra,
                fecha : item.fecha,
                fecha_formateada : item.fecha_formateada

            });
        }.bind(this));
        if (recompute) this.cargarCombinados();

        },

        getProductosParte : function(id, otrosParteIds){

            axios.defaults.baseURL = this.url ;
            var otrosQuery = (otrosParteIds && otrosParteIds.length) ? ('&otros_parte_ids=' + otrosParteIds.join(',')) : '';
            var urlRegistros = 'certificados/parte/' + id + '/modo_cobro/'+ this.modo_cobro +'/productos' + '?api_token=' + Laravel.user.api_token + otrosQuery;
            axios.get(urlRegistros).then(response =>{

                let parte_productos = response.data

                parte_productos.forEach(function(item) {

                    let cantidad = (Math.round(item.cantidad * 100) / 100).toFixed(2);
                  //  console.log('modalidad de cobro:' , this.modo_cobro);
                    if(this.modo_cobro=='PLACAS'){

                        this.TablaPartesProductosPorPlacas.push({

                            parte_id : item.parte_id,
                            numero_formateado : item.numero_formateado,
                            cm : item.cm_final,
                            placas_original:item.cantidad,
                            placas_final:item.cantidad,
                            visible : true

                        });
                    }else if(this.modo_cobro=='COSTURAS'){

                        this.TablaPartesProductosPorCosturas.push({

                            parte_id : item.parte_id,
                            numero_formateado : item.numero_formateado,
                            pulgadas : item.pulgadas_final,
                            costuras_original:item.cantidad,
                            costuras_final:item.cantidad,
                            visible : true

                        });

                    }

                }.bind(this));

            });

        },

        deleteServiciosParte : function(id){


            this.TablaPartesServicios = this.TablaPartesServicios.filter(function(item) {
                return item.parte_id != id;
            });
        },


        deleteProductosParte : function(id){

           this.TablaPartesProductosPorPlacas = this.TablaPartesProductosPorPlacas.filter(function(item) {
                return item.parte_id != id;
            });

           this.TablaPartesProductosPorCosturas = this.TablaPartesProductosPorCosturas.filter(function(item) {
                return item.parte_id != id;
            });

        },

        limpiarTodo : function(){

            this.loading = true;

            this.partes.forEach(function(item){
                item.parte_sel = false;
            });

            this.TablaPartesServicios = [];
            this.TablaPartesProductosPorPlacas = [];
            this.TablaPartesProductosPorCosturas = [];

            this.indexTablaPartesProductosPorPlacas = -1;
            this.indexTablaPartesProductosPorCosturas = -1;
            this.indexTablaPartesServicios = -1;

            this.titulo = '';

            this.loading = false;
        },

        getPartesPendientesCertificado: function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'partes/ot/' + this.otdata.id + '/pendientes_certificados' + '?api_token=' + Laravel.user.api_token;
            axios.get(urlRegistros).then(response =>{
               this.partes = response.data;
            });

        },

       getNumeroCertificado: function(){

              if(!this.editmode) {

                    axios.defaults.baseURL = this.url ;
                    var urlRegistros = 'certificados/generar-numero-certificado'  + '?api_token=' + Laravel.user.api_token;
                    axios.get(urlRegistros).then(response =>{

                    this.numero_inf_generado = response.data

                    if(this.numero_inf_generado.length){

                        this.numero =  this.numero_inf_generado[0].numero_certificado
                    }else{

                        this.numero = 1;
                    }

                    });
              }
          },

       selectPosTablaPartesProductosPorPlacas: function(index){

            this.indexTablaPartesProductosPorPlacas = index ;

       },

      selectPosTablaPartesProductosPorCosturas: function(index){

            this.indexTablaPartesProductosPorCosturas = index ;

       },

       selectPosTablaPartesServicios: function(index){

            this.indexTablaPartesServicios = index ;

       },

       RemoveTablaPartesServicios: function(index){

           const ref = this.TablaPartesServicios[index];
           // Si pertenece a un grupo combinado activo, primero descombinar ese grupo específico
           const hasGrupo = ref && !ref.manual_uncombined_sn && Number(ref.nro_combinacion) > 0;
           if (hasGrupo) {
               this.borrarCombinacionIndex(index); // esto ya recalcula solo etiquetas del grupo vía CompletarNoCombinados
           }

           // Luego ocultar solo la fila
           this.TablaPartesServicios[index].visible = false;
           this.TablaPartesServicios[index].cant_final='';

           // Evitar recomputar globalmente para no renumerar otros grupos
           // this.cargarCombinados();

       },

        Store : function(){


            this.errors =[];
            this.loading = true;
            var urlRegistros = 'certificados' ;
            axios({
              method: 'post',
              url : urlRegistros,
              data : {
                'ot'                                 : this.otdata,
                'numero'                             : this.numero,
                'titulo'                             : this.titulo,
                'fecha'                              : this.fecha,
                'partes_sel'                         : this.partes_sel,
                'info_pedido_cliente'                : this.info_pedido_cliente,
                'TablaPartesServicios'               : this.TablaPartesServicios,
                'TablaPartesProductosPorPlacas'      : this.TablaPartesProductosPorPlacas,
                'TablaPartesProductosPorCosturas'    : this.TablaPartesProductosPorCosturas,

          }

          }).then(response => {

          let certificado = response.data;
          toastr.success('Certificado N°' +  this.numero_code + ' fue creado con éxito ');
          window.open('/pdf/certificado/' + certificado.id + '/final/agrupado','_blank');
          window.location.href ='/certificados/ot/' + this.otdata.id;

        }).catch(error => {

               this.errors = error.response.data.errors;
                console.log(error.response);
               $.each( this.errors, function( key, value ) {
                   toastr.error(value);
                     console.log( key + ": " + value );
               });

               if((typeof(this.errors)=='undefined') && (error)){

                     toastr.error("Ocurrió un error al procesar la solicitud");

                }

               }).finally( () => loading = false)

        },

        Update : function() {

            this.errors =[];
            var urlRegistros = 'certificados/' + this.certificado_data.id  ;
            this.loading = true;
            axios({
              method: 'put',
              url : urlRegistros,
              data : {
                'ot'                                 : this.otdata,
                'numero'                             : this.numero,
                'fecha'                              : this.fecha,
                'titulo'                             : this.titulo,
                'partes_sel'                         : this.partes_sel,
                'info_pedido_cliente'                : this.info_pedido_cliente,
                'TablaPartesServicios'               : this.TablaPartesServicios,
                'TablaPartesProductosPorPlacas'      : this.TablaPartesProductosPorPlacas,
                'TablaPartesProductosPorCosturas'    : this.TablaPartesProductosPorCosturas,
          }}

        ).then( () => {

          toastr.success('Certificado N°' +  this.numero_code + ' fue actualizado con éxito ');
          window.open('/pdf/certificado/' + this.certificado_data.id + '/final/agrupado','_blank');
          window.location.href ='/certificados/ot/' + this.otdata.id;

        }).catch(error => {

               this.errors = error.response.data.errors;
                console.log(error.response);
               $.each( this.errors, function( key, value ) {
                   toastr.error(value);
                   console.log( key + ": " + value );
               });

               if((typeof(this.errors)=='undefined') && (error)){

                     toastr.error("Ocurrió un error al procesar la solicitud");

                }

            }).finally( () => loading = false)

        }


      }
}
</script>

<style scoped>

.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
     background-color: #eee;
}

input[type='number']::-webkit-inner-spin-button,
input[type='number']::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

</style>
