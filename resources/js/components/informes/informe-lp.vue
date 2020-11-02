<template>
    <div class="row">
       <div class="col-md-12">
           <form @submit.prevent="editmode ?  Update() : Store()"  method="post">
               <informe-header :otdata="otdata" :informe_id="informedata.id" :editmode="editmode" @set-obra="setObra($event)"></informe-header>
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
                                <input type="text" v-model="componente" class="form-control" id="componente" maxlength="20">
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
                                <label for="plano_isom">Plano/Isom *</label>
                                <input type="text" v-model="plano_isom" class="form-control" id="plano_isom" maxlength="30">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="hoja">hoja</label>
                                <input type="text" v-model="hoja" class="form-control" id="hoja" maxlength="10">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="Diametro">Ø *</label>
                                <v-select v-model="diametro" label="diametro" :options="diametros" @input="getEspesores()"></v-select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label>Espesor</label>
                                <v-select v-model="espesor" label="espesor" :options="espesores" taggable :disabled="isChapa">
                                    <template slot="option" slot-scope="option">
                                        <span class="upSelect">{{ option.espesor }} </span> <br>
                                        <span class="downSelect"> {{ option.cuadrante }} </span>
                                    </template>
                                </v-select>
                            </div>
                        </div>

                        <div class="col-md-3">
                             <div class="form-group" >
                                <div v-if="isChapa">
                                    <label for="espesor_chapa">Espesor Chapa *</label>
                                </div>
                                <div v-else>
                                     <label for="espesor_chapa">Espesor Chapa </label>
                                </div>
                                <input  type="number" class="form-control" v-model="espesor_chapa"  id="espesor_chapa" :disabled="!isChapa" step="0.1" >
                             </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group size-pqr-eps">
                                <label for="procedimientos_soldadura">Proc. Soldadura (EPS) *</label>
                                <v-select v-model="ot_tipo_soldadura" label="eps" :options="ot_obra_tipo_soldaduras" id="procedimientos_soldadura"></v-select>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-3">
                            <div class="form-group size-pqr-eps">
                                <label for="pqr">PQR</label>
                                <v-select v-model="ot_tipo_soldadura" label="pqr" :options="ot_obra_tipo_soldaduras" id="pqr"></v-select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="procRadio">Procedimiento LP *</label>
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
                                <label>Metodo Trabajo *</label>
                                    <v-select  v-model="metodo_trabajo_lp" :options="metodos_trabajo_lp" label="tipo_metodo"  @input="getInstrumentoMediciones()">
                                        <template slot="option" slot-scope="option">
                                            <span class="upSelect">{{ option.tipo }}</span> <br>
                                            <span class="downSelect"> {{ option.metodo }} </span>
                                        </template>
                                    </v-select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label> Tipo Penetrante *</label>
                                <input type="text" v-model="tipo_penetrante" class="form-control" id="tipo_penetrante" disabled>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Inst. Medición *</label>

                                    <v-select  v-model="interno_equipo" :options="interno_equipos" label="nro_interno" @input="getFuente()">
                                        <template slot="option" slot-scope="option">
                                            <span class="upSelect">{{ option.nro_interno }}</span> <br>
                                            <span class="downSelect"> {{ option.equipo.codigo }} </span>
                                        </template>
                                    </v-select>

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="instrumento_medicion">Tipo</label>
                                <div v-if="interno_equipo">
                                    <input type="text" v-model="interno_equipo.equipo.instrumento_medicion" class="form-control" id="instrumento_medicion" disabled>
                                </div>
                                 <div v-else>
                                    <input type="text" class="form-control" id="instrumento_medicion" disabled>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Líquido Penetrante *</label>
                                    <v-select  v-model="penetrante_tipo_liquido" :options="penetrantes_tipo_liquido" label="tipo">
                                        <template slot="option" slot-scope="option">
                                            <span class="upSelect">{{ option.tipo }}</span> <br>
                                            <span class="downSelect"> {{ option.marca }} </span>
                                        </template>
                                    </v-select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Aplicación  Penetrante</label>
                                <v-select v-model="penetrante_aplicacion" label="codigo" :options="aplicaciones_lp"></v-select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="tiempo_penetracion">Tiempo Penetración</label>
                                <input type="number" v-model="tiempo_penetracion" class="form-control" id="tiempo_penetracion">
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Líquido Revelador *</label>
                                    <v-select  v-model="revelador_tipo_liquido" :options="reveladores_tipo_liquido" label="tipo">
                                        <template slot="option" slot-scope="option">
                                            <span class="upSelect">{{ option.tipo }}</span> <br>
                                            <span class="downSelect"> {{ option.marca }} </span>
                                        </template>
                                    </v-select>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Aplicación  Revelador *</label>
                                <v-select v-model="revelador_aplicacion" label="codigo" :options="aplicaciones_lp"></v-select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Líquido Removedor *</label>
                                    <v-select  v-model="removedor_tipo_liquido" :options="removedores_tipo_liquido" label="tipo">
                                        <template slot="option" slot-scope="option">
                                            <span class="upSelect">{{ option.tipo }}</span> <br>
                                            <span class="downSelect"> {{ option.marca }} </span>
                                        </template>
                                    </v-select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Aplicación  Removedor *</label>
                                <v-select v-model="removedor_aplicacion" label="codigo" :options="aplicaciones_lp"></v-select>
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="limpieza_previa">Limpieza Previa</label>
                                <input type="text" v-model="limpieza_previa" class="form-control" id="limpieza_previa">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="limpieza_intermedia">Limpieza Intermedia</label>
                                <input type="text" v-model="limpieza_intermedia" class="form-control" id="limpieza_intermedia">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="limpieza_final">Limpieza final</label>
                                <input type="text" v-model="limpieza_final" class="form-control" id="limpieza_final">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="iluminaciones">Iluminaciones *</label>
                                <v-select v-model="iluminacion" label="codigo" :options="iluminaciones" disabled ></v-select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="ejecutor_ensayo">Ejecutor Ensayo *</label>
                                <v-select v-model="ejecutor_ensayo" label="name" :options="ejecutor_ensayos"></v-select>
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
                                <label for="pieza">ELEMENTO</label>
                                <input type="text" v-model="pieza" class="form-control" id="pieza">
                            </div>
                        </div>


                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="cm">CM</label>
                                <input type="number" v-model="cm" class="form-control" id="cm">
                            </div>
                        </div>

                       <div class="clearfix"></div>

                        <div class="col-md-1">
                            <span>
                              <button type="button" @click="addDetalle()"><span class="fa fa-plus-circle"></span></button>
                            </span>
                        </div>

                         <div class="form-group">
                            &nbsp;
                        </div>

                        <div v-if="TablaLp.length">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped table-bordered table-condensed">
                                        <thead>
                                            <tr>
                                                <th class="col-md-2">Elemento</th>
                                                <th class="col-md-1">CM</th>
                                                <th class="col-md-5">Detalle</th>
                                                <th class="col-md-1">Aceptable</th>
                                                <th class="col-md-1">Referencia</th>
                                                <th class="col-md-2">&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item,k) in (TablaLp)" :key="k" @click="selectPosDetalle(k)" :class="{selected: indexPosDetalle === k}" >
                                                <td>{{ item.pieza }}</td>
                                                <td>{{ item.cm }}</td>
                                                <td>
                                                    <div v-if="indexPosDetalle == k ">
                                                    <input type="text" v-model="TablaLp[k].detalle" maxlength="50" size="100%">
                                                    </div>
                                                    <div v-else>
                                                    {{ TablaLp[k].detalle }}
                                                    </div>
                                                </td>
                                                <td style="text-align:center">
                                                    <input type="checkbox" id="checkbox" v-model="TablaLp[k].aceptable_sn">  </td>
                                                <td style="text-align:center">
                                                    <span :class="{ existe : (item.observaciones ||
                                                                                item.path1 ||
                                                                                item.path2 ||
                                                                                item.path3 ||
                                                                                item.path4 )
                                                }" class="fa fa-file-archive-o" @click="OpenReferencias($event,k,'Informe PM',item)" ></span>
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

                <button class="btn btn-primary" type="submit">Guardar</button>

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

        informe_lpdata : {
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

        diametrodata : {
            type : Object,
            required : false
            },

        diametro_espesordata : {
            type : Object,
            required : false
                },

        interno_equipodata : {
            type : [ Object ],
            required : false
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

         metodo_trabajo_lpdata : {
            type : [ Object ],
            required : false
            },

        penetrante_tipo_liquido_data : {
            type : [ Object ],
            required : false
            },

        revelador_tipo_liquido_data : {
            type : [ Object ],
            required : false
            },

        removedor_tipo_liquido_data : {
            type : [ Object ],
            required : false
            },

        penetrante_aplicacion_data : {
            type : [ Object ],
            required : false
            },

        revelador_aplicacion_data : {
            type : [ Object ],
            required : false
            },

        removedor_aplicacion_data : {
            type : [ Object ],
            required : false
            },

        iluminacion_data : {
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
            }
    },

data() {return {

        errors:[],
        obra:'',
        fecha: moment(new Date()).format('YYYY-MM-DD'),
        numero_inf:'',
        numero_inf_generado:'',
        componente:'',
        tipo_soldadura:'',
        ot_tipo_soldadura:'',
        material:'',
        material2:'',
        material2_tipo:'Accesorio',
        linea:'',
        plano_isom:'',
        hoja:'',
        diametro:'',
        espesor:'',
        espesor_chapa:'',
        tecnica:'',
        interno_equipo:{ equipo:'' },
        procedimiento:'',
        norma_ensayo:'',
        norma_evaluacion:'',
        metodo_trabajo_lp:'',
        tipo_penetrante:'',
        penetrante_tipo_liquido:'',
        tiempo_penetracion:'',
        revelador_tipo_liquido:'',
        removedor_tipo_liquido:'',
        penetrante_aplicacion:'',
        revelador_aplicacion:'',
        removedor_aplicacion:'',
        limpieza_previa:'',
        limpieza_intermedia:'',
        limpieza_final:'',
        ejecutor_ensayo:'',
        iluminacion:'',
        isChapa:false,
        observaciones:'',
        modelo_3d:'',
        TablaModelos3d :[],
        //detalle
        pieza:'',
        cm:'',
        metodos_trabajo_lp:[],
        aplicaciones_lp:[],
        TablaLp:[],
        indexPosDetalle:0,

        index_referencias:'',
        tabla:'',
        inputsData:{},
        loading : false,

      }
    },

    created :  function() {
        this.$store.commit('loading', true)
        this.$store.dispatch('loadMateriales');
        this.$store.dispatch('loadDiametros');
        this.$store.dispatch('loadProcedimietosOtMetodo',
        { 'ot_id' : this.otdata.id, 'metodo' : this.metodo }).then(response =>{
                if(this.procedimientos.length == 0  ){
                    toastr.options = toastrInfo;
                    toastr.info('No existe ningún procedimiento para el método de ensayo seleccionado');
                    toastr.options = toastrDefault;
                }
        });
        this.$store.dispatch('loadNormaEvaluaciones');
        this.$store.dispatch('loadNormaEnsayos');
        this.$store.dispatch('loadIluminaciones');
        this.$store.dispatch('loadEjecutorEnsayo', this.otdata.id);
        this.$store.dispatch('loadModelos3d');
        this.getMetodosTrabajoLp();
        this.getAplicacionesLp();
        this.setEdit();
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

        ...mapState(['isLoading','url','materiales','ot_obra_tipo_soldaduras','diametros','espesores','procedimientos','norma_evaluaciones','norma_ensayos','interno_equipos','iluminaciones','penetrantes_tipo_liquido','reveladores_tipo_liquido','removedores_tipo_liquido','ejecutor_ensayos','fuentePorInterno','modelos_3d']),

        numero_inf_code : function()  {

               if(this.numero_inf)

                      return this.metodo + (this.numero_inf <10? '00' : this.numero_inf<100? '0' : '') + this.numero_inf ;
        },

     },

     methods : {

    setEdit : function(){

            if(this.editmode) {

               this.fecha   = this.informedata.fecha;
               this.obra = this.informedata.obra;
               this.numero_inf = this.informedata.numero;
               this.componente = this.informedata.componente;
               this.ot_tipo_soldadura = this.ot_tipo_soldaduradata;
               this.material = this.materialdata;
               this.material2 = this.material2data;
               if(this.informedata.material2_tipo) { this.material2_tipo = this.informedata.material2_tipo };
               this.linea = this.informedata.linea;
               this.plano_isom = this.informedata.plano_isom;
               this.hoja = this.informedata.hoja;
               this.diametro = this.diametrodata;
               this.espesor = this.informedata.espesor_especifico ? {'espesor' : this.informedata.espesor_especifico} : this.diametro_espesordata;
               this.tecnica = this.tecnicadata;
               this.interno_equipo = this.interno_equipodata;
               this.procedimiento = this.procedimientodata;
               this.norma_evaluacion = this.norma_evaluaciondata;
               this.norma_ensayo = this.norma_ensayodata;
               this.espesor_chapa = this.informedata.espesor_chapa;
               this.metodo_trabajo_lp = this.metodo_trabajo_lpdata;
               this.tipo_penetrante = (this.metodo_trabajo_lp.tipo == 'TIPO I') ? 'Fluorescente' : 'Visible';
               this.ejecutor_ensayo = this.ejecutor_ensayodata;
               this.observaciones = this.informedata.observaciones;
               this.penetrante_tipo_liquido = this.penetrante_tipo_liquido_data;
               this.revelador_tipo_liquido  = this.revelador_tipo_liquido_data;
               this.removedor_tipo_liquido  = this.removedor_tipo_liquido_data;
               this.penetrante_aplicacion   = this.penetrante_aplicacion_data;
               this.tiempo_penetracion      = this.informe_lpdata.tiempo_penetracion;
               this.revelador_aplicacion    = this.revelador_aplicacion_data;
               this.removedor_aplicacion    = this.removedor_aplicacion_data;
               this.limpieza_previa         = this.informe_lpdata.limpieza_previa;
               this.limpieza_intermedia     = this.informe_lpdata.limpieza_intermedia;
               this.limpieza_final          = this.informe_lpdata.limpieza_final;
               this.iluminacion = this.iluminacion_data;
               this.TablaLp = this.detalledata;
               this.TablaModelos3d = this.tablamodelos3d_data;
               this.getTipoLiquidos();
               this.$store.dispatch('loadInternoEquipos',{ 'metodo' : this.metodo, 'activo_sn' : 1, 'tipo_penetrante' : this.tipo_penetrante });
               this.setearTipoPenetrante();
               this.$store.dispatch('loadOtObraTipoSoldaduras',{ 'ot_id' : this.otdata.id, 'obra' : this.informedata.obra });
            }

        },

    setObra : function(value){

            console.log('entro en el setobra del ri',this.obra);

            this.obra = value;

           console.log('entro en el setobra del ri',this.obra);
            this.ot_tipo_soldadura='';
            this.$store.dispatch('loadOtObraTipoSoldaduras',{ 'ot_id' : this.otdata.id, 'obra' : this.obra });
        },

     getNumeroInforme:function(){

            if(!this.editmode) {

                    console.log('entro en getnumeroinforme');
                    axios.defaults.baseURL = this.url ;
                    var urlRegistros = 'informes/ot/' + this.otdata.id + '/metodo/' + this.metodo + '/generar-numero-informe'  + '?api_token=' + Laravel.user.api_token;
                    axios.get(urlRegistros).then(response =>{

                    this.numero_inf_generado = response.data

                    if(this.numero_inf_generado.length){

                        this.numero_inf =  this.numero_inf_generado[0].numero_informe
                    }else{

                        this.numero_inf = 1;
                    }

                });
             }
        },

    getEspesores : function(){
            this.espesor='';
            this.tecnica ='';
            if(this.diametro != 'CHAPA')   {

                this.espesor_chapa = '';
            }
            if(this.diametro){
                this.$store.dispatch('loadEspesores',this.diametro.diametro_code);
            }
        },

    getFuente : function(){

        this.$store.dispatch('loadFuentePorInterno',this.interno_equipo.interno_fuente_id);

      },

     getInstrumentoMediciones(){

        this.tipo_penetrante = (this.metodo_trabajo_lp.tipo == 'TIPO I') ? 'Fluorescente' : 'Visible';

        if(this.metodo_trabajo_lp.tipo == 'TIPO I'){

            this.iluminacion = this.iluminaciones[this.iluminaciones.findIndex(elemento => elemento.codigo == '1076 Lux')];

        }else if(this.metodo_trabajo_lp.tipo == 'TIPO II'){

            this.iluminacion = this.iluminaciones[this.iluminaciones.findIndex(elemento => elemento.codigo == '1000 µv/cm2')];

        }

        this.getInternoEquipos();

        this.setearTipoPenetrante();
        this.penetrante_tipo_liquido = '';
        this.removedor_tipo_liquido = '';
        this.removedor_tipo_liquido = '';

        this.getTipoLiquidos();
    },

    getTipoLiquidos : function(){

        this.$store.dispatch('loadTipoLiquidos', { 'penetrante_sn' : 1,'revelador_sn' : 0,'removedor_sn' : 0, 'metodo_trabajo_lp_id' : this.metodo_trabajo_lp.id });
        this.$store.dispatch('loadTipoLiquidos', { 'penetrante_sn' : 0,'revelador_sn' : 1,'removedor_sn' : 0, 'metodo_trabajo_lp_id' : this.metodo_trabajo_lp.id });
        this.$store.dispatch('loadTipoLiquidos', { 'penetrante_sn' : 0,'revelador_sn' : 0,'removedor_sn' : 1, 'metodo_trabajo_lp_id' : this.metodo_trabajo_lp.id });

    },

    getInternoEquipos : function(){

        this.$store.dispatch('loadInternoEquipos',{ 'metodo' : this.metodo, 'activo_sn' : 1, 'tipo_penetrante' : this.tipo_penetrante }).then(response =>{

            this.interno_equipo = '';

        });

    },

    setearTipoPenetrante : function(){

        switch (this.metodo_trabajo_lp.metodo) {

            case 'METODO A':

                this.tipo_penetrante +=' - Lavable con agua';
                break;

            case 'METODO B':

                this.tipo_penetrante +=' - Emusificante Lipofilico';
                break;

            case 'METODO C':

                this.tipo_penetrante +=' - Lavable con Solvente';
                break;

            case 'METODO D':

                this.tipo_penetrante +=' - Emusificante hidrofilico';
                break;

        }
    },

    selectPosDetalle :function(index){

            this.indexPosDetalle = index ;

        },

    getMetodosTrabajoLp: function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'metodos_trabajo_lp' + '?api_token=' + Laravel.user.api_token;
            axios.get(urlRegistros).then(response =>{
            this.metodos_trabajo_lp = response.data
            });
         },

    getAplicacionesLp: function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'aplicaciones_lp' + '?api_token=' + Laravel.user.api_token;
            axios.get(urlRegistros).then(response =>{
                this.aplicaciones_lp = response.data;
                this.$store.commit('loading', false);
            });
         },

    addDetalle : function () {

            if (!this.pieza){

                 toastr.error('El campo elemento es obligatorio');
                 return ;
            }

            if (!this.cm){

                 toastr.error('El campo cm es obligatorio');
                 return ;
            }

        this.TablaLp.push({
            pieza : this.pieza,
            cm:this.cm,
            detalle : '',
            aceptable_sn : 1 ,
            observaciones : '',
            path1:null,
            path2:null,
            path3:null,
            path4:null
            });

        },

    removeDetalle(index) {

        this.indexPosDetalle = 0;
        this.TablaLp.splice(index, 1);
    },

    OpenReferencias(event,index,tabla,inputsReferencia){

        this.index_referencias = index ;
        this.tabla = tabla;
        this.inputsData = inputsReferencia ;
        eventSetReferencia.$emit('open');
    },

    AddReferencia(Ref){

        this.TablaLp[this.index_referencias].observaciones = Ref.observaciones;
        this.TablaLp[this.index_referencias].path1 = Ref.path1;
        this.TablaLp[this.index_referencias].path2 = Ref.path2;
        this.TablaLp[this.index_referencias].path3 = Ref.path3;
        this.TablaLp[this.index_referencias].path4 = Ref.path4;

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

    Store : function(){

          this.errors =[];

            var urlRegistros = 'informes_lp' ;
            axios({
              method: 'post',
              url : urlRegistros,
              data : {
                'ot'              : this.otdata,
                'obra'            : this.obra,
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
                'material2_tipo': this.material2_tipo,
                'diametro':       this.diametro,
                'espesor':        this.espesor,
                'espesor_chapa'  :  this.espesor_chapa,
                'interno_equipo'        :  this.interno_equipo,
                'norma_evaluacion': this.norma_evaluacion,
                'norma_ensayo'      : this.norma_ensayo,
                'tecnica'           :this.tecnica,
                'metodo_trabajo_lp'             : this.metodo_trabajo_lp,
                'penetrante_tipo_liquido'       :this.penetrante_tipo_liquido,
                'penetrante_aplicacion'         :this.penetrante_aplicacion,
                'tiempo_penetracion'            :this.tiempo_penetracion,
                'iluminacion'                   :this.iluminacion,
                'revelador_tipo_liquido'        :this.revelador_tipo_liquido,
                'revelador_aplicacion'          :this.revelador_aplicacion,
                'removedor_tipo_liquido'        :this.removedor_tipo_liquido,
                'removedor_aplicacion'          :this.removedor_aplicacion,
                'limpieza_previa'               :this.limpieza_previa,
                'limpieza_intermedia'           :this.limpieza_intermedia,
                'limpieza_final'                :this.limpieza_final,
                'detalles'                      :this.TablaLp,
                'TablaModelos3d' :this.TablaModelos3d,

          }

          }).then(response => {

          let informe = response.data;
          toastr.success('informe N°' + this.numero_inf + ' fue creado con éxito ');
          window.open(  '/pdf/informe/lp/' + informe.id,'_blank');
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

           });

        },

        Update : function() {

            console.log('entro para actualizar' );
            this.errors =[];

            var urlRegistros = 'informes_lp/' + this.informedata.id  ;
            axios({
              method: 'put',
              url : urlRegistros,
              data : {
                'ot'              : this.otdata,
                'obra'            : this.obra,
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
                'tipo_soldadura' :this.ot_tipo_soldadura.tipo_soldadura,
                'ot_tipo_soldadura' : this.ot_tipo_soldadura,
                'material':       this.material,
                'material2':      this.material2,
                'material2_tipo': this.material2_tipo,
                'diametro':       this.diametro,
                'espesor':        this.espesor,
                'espesor_chapa'  :  this.espesor_chapa,
                'interno_equipo'     :  this.interno_equipo,
                'norma_evaluacion'  : this.norma_evaluacion,
                'norma_ensayo'      : this.norma_ensayo,
                'tecnica'           :this.tecnica,
                'metodo_trabajo_lp'             : this.metodo_trabajo_lp,
                'penetrante_tipo_liquido'       :this.penetrante_tipo_liquido,
                'penetrante_aplicacion'         :this.penetrante_aplicacion,
                'tiempo_penetracion'            :this.tiempo_penetracion,
                'iluminacion'                   :this.iluminacion,
                'revelador_tipo_liquido'        :this.revelador_tipo_liquido,
                'revelador_aplicacion'          :this.revelador_aplicacion,
                'removedor_tipo_liquido'        :this.removedor_tipo_liquido,
                'removedor_aplicacion'          :this.removedor_aplicacion,
                'limpieza_previa'               :this.limpieza_previa,
                'limpieza_intermedia'           :this.limpieza_intermedia,
                'limpieza_final'                :this.limpieza_final,
                'detalles'                      :this.TablaLp,
                'TablaModelos3d' :this.TablaModelos3d,

          }}


        ).then( response => {

          let informe = response.data;
          toastr.success('informe N°' + this.numero_inf + ' fue actualizado con éxito ');
          window.open(  '/pdf/informe/lp/' + informe.id,'_blank');
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

        });

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


.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
     background-color: #eee;
}

</style>
