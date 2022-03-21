<template>
    <div class="row">
       <div class="col-md-12">
           <form @submit.prevent="editmode ?  Update() : Store()"  method="post">
               <informe-header :otdata="otdata" :informe_id="informedata.id" :editmode="editmode" @set-obra="setObra($event)" @set-planta="setPlanta($event)"></informe-header>
               <div class="box box-custom-enod">
                  <div class="box-body">
                       <div class="col-md-3">
                            <div class="form-group">
                                <label for="fecha">Fecha *</label>
                                <div>
                                    <date-picker v-model="fecha" value-type="YYYY-MM-DD" format="DD-MM-YYYY" placeholder="DD-MM-YYYY" ></date-picker>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="numero_inf">Informe N°</label>
                                <input type="text"  v-model="numero_inf_code" class="form-control" id="numero_inf" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="componente">Componente *</label>
                                <input type="text" v-model="componente" class="form-control" id="componente" maxlength="30">
                            </div>
                        </div>

                        <div class="col-md-3" >
                            <div class="form-group">
                                <label for="material">Material *</label>
                                <v-select v-model="material" label="codigo" :options="materiales" id="material"></v-select>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                         <div class="col-md-3" >
                             <div class="form-group">
                                <label for="material2">Material </label>
                                <input type="radio" id="caño" value="Caño" v-model="material2_tipo" style="float:right">
                                <label for="caño" style="float:right;margin-right: 5px;margin-left:5px" title="Caño">Caño</label>
                                <input type="radio" id="accesorio" value="Accesorio" v-model="material2_tipo" style="float:right">
                                <label for="accesorio" style="float:right;margin-right: 5px;margin-left:5px" title="Accesorio">Acces.</label>
                                 <v-select v-model="material2" label="codigo" :options="materiales" id="material2"></v-select>
                             </div>
                         </div>

                         <div class="col-md-3">
                             <div class="form-group" >
                                 <label for="linea">Linea</label>
                                 <input type="text" v-model="linea" class="form-control" id="linea" maxlength="30">
                             </div>
                         </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="plano_isom">Plano / Isom *</label>
                                <input type="text" v-model="plano_isom" class="form-control" id="plano_isom" maxlength="30">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="hoja">Hoja</label>
                                <input type="text" v-model="hoja" class="form-control" id="hoja" maxlength="10">
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-3">
                            <div class="form-group size-pqr-eps">
                                <label for="procedimientos_soldadura">EPS / WPS *</label>
                                <v-select v-model="ot_tipo_soldadura" label="eps" :options="ot_obra_tipo_soldaduras" id="procedimientos_soldadura"></v-select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group size-pqr-eps">
                                <label for="pqr">PQR</label>
                                <v-select v-model="ot_tipo_soldadura" label="pqr" :options="ot_obra_tipo_soldaduras" id="pqr"></v-select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="procRadio">Procedimiento PMI *</label>
                                <v-select v-model="procedimiento" label="titulo" :options="procedimientos" id="procRadio"></v-select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Norma Evaluación *</label>
                                <v-select v-model="norma_evaluacion" label="codigo" :options="norma_evaluaciones">
                                    <template slot="option" slot-scope="option">
                                        <span class="upSelect">{{ option.codigo }}</span> <br>
                                        <span class="downSelect"> {{ option.descripcion }} </span>
                                    </template>
                                </v-select>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Norma Ensayo *</label>
                                <v-select v-model="norma_ensayo" label="codigo" :options="norma_ensayos">
                                    <template slot="option" slot-scope="option">
                                        <span class="upSelect">{{ option.codigo }}</span> <br>
                                        <span class="downSelect"> {{ option.descripcion }} </span>
                                    </template>
                                </v-select>
                            </div>
                        </div>

                         <div class="col-md-3">
                            <div class="form-group">
                                <label>Equipo *</label>

                                    <v-select  v-model="interno_equipo" :options="interno_equipos" label="nro_interno">
                                        <template slot="option" slot-scope="option">
                                            <span class="upSelect">{{ option.nro_interno }}</span> <br>
                                            <span class="downSelect"> {{ option.equipo.codigo }} </span>
                                        </template>
                                    </v-select>

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="ejecutor_ensayo">Estado Superficie*</label>
                                <input type="text" v-model="estado_superficie" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="ejecutor_ensayo">Ejecutor Ensayo *</label>
                                <v-select v-model="ejecutor_ensayo" label="name" :options="ejecutor_ensayos"></v-select>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="ejecutor_ensayo">Solicitante </label>
                                <v-select v-model="solicitado_por" label="name" :options="usuarios_cliente"></v-select>
                            </div>
                        </div>
                            <div class="col-md-6">
                                <div class="form-group" >
                                    <subir-imagen
                                        :ruta="ruta"
                                        :max_size="max_size"
                                        :path_inicial="path"
                                        :tipos_archivo_soportados ="tipos_archivo_soportados"
                                        :mostrar_formatos_soportados="true"
                                        @path="path = $event"
                                        :path_requerido_sn="false"
                                    ></subir-imagen>
                                </div>
                            </div>
                    </div>
               </div>

                <div class="box box-custom-enod">
                    <div class="box-body">

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="modelos_3d">Modelos 3D</label>
                                <v-select v-model="modelo_3d" label="codigo" :options="modelos_3d" id="modelos_3d" ></v-select>
                            </div>
                         </div>

                         <div class="clearfix"></div>

                         <div class="col-md-1">
                            <span>
                            </span>
                            <span>
                              <button type="button" @click="addModelo()"><span class="fa fa-plus-circle"></span></button>
                            </span>
                         </div>

                        <div v-if="TablaModelos3d.length">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                <table class="table table-hover table-striped table-bordered table-condensed">
                                        <thead>
                                            <tr>
                                                <th class="col-md-1">Modelo</th>
                                                <th class="col-md-1">&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item,k) in (TablaModelos3d)" :key="k">

                                                <td>
                                                    {{ item.codigo }}
                                                </td>
                                                <td>
                                                    <a  @click="RemoveModelo(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a>
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

               <div class="box box-custom-enod">
                    <div class="box-body">

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label>N° Muestras *</label>
                                <input type="number" v-model="numero_muestras" class="form-control">
                            </div>
                        </div>
                         <div class="col-md-3">
                             <div class="form-group" >
                                 <label>Primer valor *</label>
                                <input type="number" v-model="primer_valor" class="form-control">
                             </div>
                         </div>
                         <div class="col-md-3">
                             <div class="form-group" >
                                 <label>Primera pieza *</label>
                                <input type="number" v-model="primera_pieza" class="form-control">
                             </div>
                         </div>
                         <div class="col-md-1">
                            <span>
                              <button type="button" @click="GenerarMuestras()"><span class="fa fa-plus-circle"></span></button>
                            </span>
                        </div>

                         <div class="form-group">
                            &nbsp;
                        </div>

                        <div v-if="TablaPmi.length">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped table-bordered table-condensed">
                                        <thead>
                                            <tr>
                                                <th class="col-md-4">Muestra</th>
                                                <th class="col-md-4">Pieza</th>
                                                <th class="col-md-4">Material de referencia</th>
                                                <th class="col-md-1"> &nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item,k) in (TablaPmi)" :key="k" @click="selectPosDetalle(k)" :class="{selected: indexPosDetalle === k}" >
                                                <td>{{ item.muestra }}</td>
                                                <td>{{ item.pieza   }} </td>
                                                <td>
                                                    <div v-if="indexPosDetalle == k ">
                                                    <v-select v-model="TablaPmi[k].material" label="codigo" :options="materiales"></v-select>
                                                    </div>
                                                    <div v-else>
                                                    {{ TablaPmi[k].material.codigo }}
                                                    </div>
                                                </td>
                                                <td style="text-align:center"><span class="fa fa-minus-circle" @click="removeDetalle(k)"></span></td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                        </div>
                    </div>

                  </div>
                </div>

               <div class="box box-custom-enod">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Observaciones</label>
                            <textarea v-model="observaciones" class="form-control noresize" rows="3" placeholder="" maxlength="250"></textarea>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit" :disabled="isLoading">Guardar</button>

           </form>
       </div>
       <create-referencias :index="index_referencias" :tabla="tabla" :inputsData="inputsData" @setReferencia="AddReferencia"></create-referencias>
        <loading :active.sync="isLoading"
            :loader="'bars'"
            :color="'red'">
        </loading>
    </div>
</template>

<script>
import uniq from 'lodash/uniq';
import {mapState} from 'vuex';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/es';
import { eventSetReferencia } from '../event-bus';
import { toastrInfo,toastrDefault } from '../toastrConfig';
import moment from 'moment';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import {sprintf} from '../../functions/sprintf.js'

export default {

components: {

      Loading

    },

props :{

        editmode : {
        type : Boolean,
        required : false,
        default : false
        },

        metodo : {
        type : String,
        required :true
        },

        otdata : {
            type : Object,
            required : true
        },
        informedata : {
            type : Object,
            required : false,
            default : function () { return {}}
            },
        informe_pmidata : {
            type : Object,
            required : false
            },
        interno_equipodata : {
            type : Object,
            required : false
        },
        materialdata : {
            type : Object,
            required : false
            },
        ot_tipo_soldaduradata : {
            type : [ Object, Array ],
            required : false,

            },
        material2data : {
            type : [ Object, Array ],
            required : false,
        },
        procedimientodata : {
            type : [ Object ],
            required : false
            },

        norma_evaluaciondata : {
            type : [ Object ],
            required : false
            },

        norma_ensayodata : {
            type : [ Object ],
            required : false
            },

        ejecutor_ensayodata : {
            type : [ Object ],
            required : false
            },
         detalledata : {
            type : [ Array ],
            required : false
            },

         tablamodelos3d_data : {
            type : [ Array ],
            required : false
            },
         solicitado_pordata : {
            type : [ Object, Array ],
            required : false
            }
    },

data() {return {

        ruta: 'informes_pmi',
        max_size :50000, //KB
        tipos_archivo_soportados:['pdf'],
        path:'',
        errors:[],
        obra:'',
        planta:'',
        interno_equipos:[],
        interno_equipo:'',
        estado_superficie: 'PULIDA',
        fecha: moment(new Date()).format('YYYY-MM-DD'),
        numero_inf:'',
        numero_inf_generado:'',
        componente:'',
        tipo_soldadura:'',
        ot_tipo_soldadura:'',
        modo_aplicacion:'',
        material:'',
        material2:'',
        material2_tipo:'Accesorio',
        liquido:'PROOF CHECK',
        estado_producto:'LIQUIDO',
        linea:'',
        plano_isom:'',
        soldadores:[],
        hoja:'',
        procedimiento:'',
        norma_ensayo:'',
        norma_evaluacion:'',
        ejecutor_ensayo:'',
        isChapa:false,
        formato:'',
        observaciones:'',
        modelo_3d:'',
        TablaModelos3d :[],
        aplicaciones:[],
        //detalle
        arrayMuestras:[],
        numero_muestras:'',
        primer_valor:'',
        primera_pieza:'',
        pieza:'',
        TablaPmi:[],
        indexPosDetalle:0,
        solicitado_por:'',
        usuarios_cliente:[],
        index_referencias:'',
        tabla:'',
        inputsData:{},
        loading : false,

      }
    },

    created :  function() {
        this.$store.commit('loading', true)
        this.$store.dispatch('loadMateriales');
        this.$store.dispatch('loadProcedimietosOtMetodo',
        { 'ot_id' : this.otdata.id, 'metodo' : this.metodo }).then(response =>{
                if(this.procedimientos.length == 0  ){
                    toastr.options = toastrInfo;
                    toastr.info('No existe ningún procedimiento para el método de ensayo seleccionado');
                    toastr.options = toastrDefault;
                }
        });
        this.getSoldadores();
        this.$store.dispatch('loadNormaEvaluaciones');
        this.$store.dispatch('loadNormaEnsayos');
        this.$store.dispatch('loadEjecutorEnsayo', this.otdata.id);
        this.$store.dispatch('loadDiametros');
        this.$store.dispatch('loadModelos3d');
        this.getInternoEquipo();
        this.getUsuariosCliente();
        this.setEdit();
        this.$store.commit('loading', false)
    },

    mounted : function() {

         this.getNumeroInforme();
    },

     watch : {


        diametro : function(val){

           if(val){
                 this.isChapa = (val.diametro =='CHAPA') ? true : false;
            }
        },

    },

    computed :{

        ...mapState(['isLoading','url','diametros','materiales','ot_obra_tipo_soldaduras','procedimientos','norma_evaluaciones','norma_ensayos','ejecutor_ensayos','fuentePorInterno','modelos_3d']),
        numero_inf_code : function()  {
            if(this.numero_inf)
                return this.metodo +  sprintf("%04d",this.numero_inf);
        },

     },

     methods : {

    setEdit : function(){

            if(this.editmode) {
                this.path = this.informe_pmidata.path
               this.fecha   = this.informedata.fecha;
               this.obra = this.informedata.obra;
               this.planta = this.informedata.planta;
               this.numero_inf = this.informedata.numero;
                this.ot_tipo_soldadura = this.ot_tipo_soldaduradata;
               this.componente = this.informedata.componente;
               this.material = this.materialdata;
               this.material2 = this.material2data;
               if(this.informedata.material2_tipo) { this.material2_tipo = this.informedata.material2_tipo };
               this.linea = this.informedata.linea;
               this.plano_isom = this.informedata.plano_isom;
               this.hoja = this.informedata.hoja;
               this.procedimiento = this.procedimientodata;
               this.norma_evaluacion = this.norma_evaluaciondata;
               this.norma_ensayo = this.norma_ensayodata;
               this.ejecutor_ensayo = this.ejecutor_ensayodata;
               this.observaciones = this.informedata.observaciones;
               this.solicitado_por = this.solicitado_pordata ;
               this.interno_equipo = this.interno_equipodata
               this.TablaPmi = this.detalledata;
               this.TablaModelos3d = this.tablamodelos3d_data;
               this.$store.dispatch('loadOtObraTipoSoldaduras',{ 'ot_id' : this.otdata.id, 'obra' : this.informedata.obra });
            }

        },
    async getSoldadores(){
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'ot_soldadores/ot/' + this.otdata.id + '?api_token=' + Laravel.user.api_token;
            await axios.get(urlRegistros).then(response =>{
            this.soldadores = response.data
            });

        },
    getBombas: function(){

        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'bombas' + '?api_token=' + Laravel.user.api_token;
        axios.get(urlRegistros).then(response =>{
        this.bombas = response.data
        });
    },
    getCampanas: function(){

        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'campanas' + '?api_token=' + Laravel.user.api_token;
        axios.get(urlRegistros).then(response =>{
        this.campanas = response.data
        });
    },
    getUsuariosCliente : function(){

        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'users/ot_id/' + this.otdata.id + '?api_token=' + Laravel.user.api_token;
        axios.get(urlRegistros).then(response =>{
        this.usuarios_cliente = response.data
        });

    },
    setObra : function(value){
            this.obra = value;
            this.ot_tipo_soldadura='';
            if(this.obra){
                this.$store.dispatch('loadOtObraTipoSoldaduras',{ 'ot_id' : this.otdata.id, 'obra' : this.obra });
            }
        },

    setPlanta : function(value){
            this.planta = value;
        },

     getNumeroInforme:function(){

            if(!this.editmode) {

                    axios.defaults.baseURL = this.url ;
                    var urlRegistros = 'informes/ot/' + this.otdata.id + '/metodo/' + this.metodo + '/tecnica/0' + '/generar-numero-informe/'  + '?api_token=' + Laravel.user.api_token;
                    axios.get(urlRegistros).then(response =>{

                     this.numero_inf = response.data

                });
             }
        },

    selectPosDetalle :function(index){
            this.indexPosDetalle = index ;
        },
    GenerarMuestras: function(){
        if (!this.numero_muestras){

            toastr.error('El campo numero de muestras es obligatorio');
            return ;
        }
        if (!this.primer_valor){

            toastr.error('El campo primer valor es obligatorio');
            return ;
        }
        if (!this.primera_pieza){

            toastr.error('El campo primera pieza es obligatorio');
            return ;
        }
        if (!this.material){

            toastr.error('El campo material es obligatorio');
            return ;
        }
        this.TablaPmi = []
        this.arrayMuestras = []
        var primeraPieza = parseFloat(this.primera_pieza)
        var resultado = parseFloat(this.primer_valor)
        var i = 0;
        while (i < this.numero_muestras){
            if (i === 0){
                primeraPieza = primeraPieza
                resultado = resultado
                i++
                this.arrayMuestras.push(resultado)
                this.TablaPmi.push({
                    muestra : resultado,
                    pieza : primeraPieza,
                    material : this.material
                });
            }
            i++
            resultado =  resultado + 3
            primeraPieza = primeraPieza + 1
            this.arrayMuestras.push(resultado)
            this.TablaPmi.push({
                muestra : resultado,
                pieza : primeraPieza,
                material : this.material
            });
        }
        return resultado;
    },

    addDetalle : function () {
        this.TablaPmi.push({
            muestra : this.muestra,
            detalle : 'OK',
            aceptable_sn : 1 ,
            observaciones : '',
            path1:null,
            path2:null,
            path3:null,
            path4:null
            });

    },

    resetBomba(){
        this.bomba.caudal = 0;
        this.bomba.voltaje = 0;
    },
    removeDetalle(index) {

        this.indexPosDetalle = 0;
        this.TablaPmi.splice(index, 1);
    },
    getAplicaciones: function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'aplicaciones_lp' + '?api_token=' + Laravel.user.api_token;
            axios.get(urlRegistros).then(response =>{
                this.aplicaciones = response.data;
                this.$store.commit('loading', false);
            });
         },
    OpenReferencias(event,index,tabla,inputsReferencia){

        this.index_referencias = index ;
        this.tabla = tabla;
        this.inputsData = inputsReferencia ;
        eventSetReferencia.$emit('open');
    },


    AddReferencia(Ref){

        this.TablaPmi[this.index_referencias].observaciones = Ref.observaciones;
        this.TablaPmi[this.index_referencias].path1 = Ref.path1;
        this.TablaPmi[this.index_referencias].path2 = Ref.path2;
        this.TablaPmi[this.index_referencias].path3 = Ref.path3;
        this.TablaPmi[this.index_referencias].path4 = Ref.path4;

        $('#nuevo').modal('hide');
    },

    addModelo : function(){

        this.TablaModelos3d.push({

        ...this.modelo_3d,

        });

    },

    RemoveModelo : function(index){

        this.TablaModelos3d.splice(index, 1);
        this.modelo_3d = '';

    },
    getInternoEquipo: function(){
        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'interno_equipos/metodo/PMI/activo_sn/1/tipo_penetrante/null' + '?api_token=' + Laravel.user.api_token;
        axios.get(urlRegistros).then(response =>{
        this.interno_equipos = response.data
        });
    },
    Store : function(){

          this.errors =[];
            this.$store.commit('loading', true);
            var urlRegistros = 'informes_pmi' ;
            axios({
              method: 'post',
              url : urlRegistros,
              data : {
                'ot'              : this.otdata,
                'path'            : this.path,
                'obra'            : this.obra,
                'planta'            : this.planta,
                'ejecutor_ensayo' : this.ejecutor_ensayo,
                'metodo_ensayo'   : this.metodo,
                'fecha':          this.fecha,
                'numero_inf':     this.numero_inf,
                'componente' :    this.componente,
                'linea'      :    this.linea,
                'plano_isom' :    this.plano_isom,
                'hoja'       :    this.hoja,
                'procedimiento' : this.procedimiento,
                'observaciones':  this.observaciones,
                'ot_tipo_soldadura' : this.ot_tipo_soldadura,
                'material':       this.material,
                'material2':      this.material2,
                'material2_tipo'    : this.material2_tipo,
                'norma_evaluacion'  : this.norma_evaluacion,
                'norma_ensayo'      : this.norma_ensayo,
                'interno_equipo'    :   this.interno_equipo,
                'estado_superficie' : this.estado_superficie,
                'detalles'          : this.TablaPmi,
                'solicitado_por'    : this.solicitado_por,
                'TablaModelos3d'    : this.TablaModelos3d,
          }

          }).then(response => {
          let informe = response.data;
          window.open(  '/pdf/informe/pmi/' + informe.id,'_blank');
          toastr.success('informe N°' + this.numero_inf + ' fue creado con éxito ');
          window.location.href =  '/informes/ot/' + this.otdata.id;

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

               }).finally( () => this.$store.commit('loading', false))

        },

        Update : function() {

            this.errors =[];
            this.$store.commit('loading', true);
            var urlRegistros = 'informes_pmi/' + this.informedata.id  ;
            axios({
              method: 'put',
              url : urlRegistros,
              data : {
                'ot'              : this.otdata,
                'path'            : this.path,
                'obra'            : this.obra,
                'planta'            : this.planta,
                'ejecutor_ensayo' : this.ejecutor_ensayo,
                'metodo_ensayo'   : this.metodo,
                'fecha':          this.fecha,
                'numero_inf':     this.numero_inf,
                'componente' :    this.componente,
                'linea'      :    this.linea,
                'plano_isom' :    this.plano_isom,
                'hoja'       :    this.hoja,
                'procedimiento' : this.procedimiento,
                'observaciones':  this.observaciones,
                'ot_tipo_soldadura' : this.ot_tipo_soldadura,
                'material':       this.material,
                'material2':      this.material2,
                'material2_tipo'    : this.material2_tipo,
                'norma_evaluacion'  : this.norma_evaluacion,
                'norma_ensayo'      : this.norma_ensayo,
                'interno_equipo'    :   this.interno_equipo,
                'estado_superficie' : this.estado_superficie,
                'detalles'          : this.TablaPmi,
                'solicitado_por'    : this.solicitado_por,
                'TablaModelos3d'    : this.TablaModelos3d,

          }}

        ).then( response => {
          let informe = response.data;
          window.open(  '/pdf/informe/pmi/' + informe.id,'_blank');
          toastr.success('informe N°' + this.numero_inf + ' fue actualizado con éxito ');
          window.location.href =  '/informes/ot/' + this.otdata.id;

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

            }).finally( () => this.$store.commit('loading', false))

        }
    }
}
</script>
<style scoped>

 .existe {

    color: blue ;

  }

.checkbox-inline {
    margin-left: 0px;
}

input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

.sinpadding [class*="col-"] {
    padding-right: 0;
}


.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
     background-color: #eee;
}

</style>
