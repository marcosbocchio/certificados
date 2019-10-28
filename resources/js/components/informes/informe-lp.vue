<template>
    <div class="row">
       <div class="col-md-12">
           <form @submit.prevent="editmode ?  Update() : Store()"  method="post">
               <informe-header :otdata="otdata"></informe-header>
               <div class="box box-danger">
                  <div class="box-body">
                       <div class="col-md-3">
                            <div class="form-group">
                                <label for="fecha">Fecha (*)</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                    </div>
                                        <Datepicker v-model="fecha" :input-class="'form-control pull-right'" :language="es"></Datepicker>   
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
                                <label for="componente">Componente (*)</label>
                                <input type="text" v-model="componente" class="form-control" id="componente">
                            </div>                            
                        </div>
                        <div class="col-md-3" >                       
                            <div class="form-group">
                                <label for="materiales">Material (*)</label>
                                <v-select v-model="material" label="codigo" :options="materiales" id="materiales"></v-select>   
                            </div>      
                        </div>

                        <div class="clearfix"></div>    

                        <div class="col-md-1 size-1-5">
                            <div class="form-group" >
                                <label for="plano_isom">Plano/Isom *</label>
                                <input type="text" v-model="plano_isom" class="form-control" id="plano_isom">
                            </div>                            
                        </div>
                        <div class="col-md-3 size-1-5">
                            <div class="form-group" >
                                <label for="Diametro">Ø *</label>
                                <v-select v-model="diametro" label="diametro" :options="diametros" @input="getEspesores()"></v-select>   
                            </div>                            
                        </div>                       
                        
                        <div class="col-md-1 size-1-5">
                            <div class="form-group" >
                                <label>Espesor</label>
                                <v-select v-model="espesor" label="espesor" :options="espesores" :disabled="isChapa"></v-select>   
                            </div>                            
                        </div>
                      
                        <div class="col-md-1 size-1-5">    
                             <div class="form-group" >                         
                                <label for="espesor_chapa">Esp. Chapa</label>
                                <input  type="text" class="form-control" v-model="espesor_chapa"  id="espesor_chapa" :disabled="!isChapa" > 
                             </div>                                      
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="procedimientos_soldadura">Proc. Soldadura (*)</label>
                                <input type="text" v-model="procedimiento_soldadura" class="form-control" id="procedimientos_soldadura">
                            </div>                            
                        </div>  

                        <div class="col-md-3">                       
                            <div class="form-group" >
                                <label for="eps">EPS</label>
                                <input type="text" v-model="eps" class="form-control" id="eps">
                            </div>         
                        </div>

                        <div class="col-md-3">                       
                            <div class="form-group" >
                                <label for="eps">PQR</label>
                                <input type="text" v-model="pqr" class="form-control" id="pqr">
                            </div>         
                        </div> 

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="equipos">Equipo (*)</label>
                                <v-select v-model="interno_equipo" label="nro_serie" :options="interno_equipos_activos" @input="getFuente()" ></v-select>  
                            </div>                            
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="fuente">Fuente </label>
                                <input type="text" v-model="fuentePorInterno.codigo" class="form-control" id="fuente" disabled>
                            </div>                            
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="voltaje">Voltaje </label>
                                <input type="text" v-model="interno_equipo.voltaje" class="form-control" id="voltaje" disabled>
                            </div>                            
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="amperaje">Amperaje </label>
                                <input type="text" v-model="interno_equipo.amperaje" class="form-control" id="amperaje" disabled>
                            </div>                            
                        </div>
                        
                        <div class="col-md-3">                       
                            <div class="form-group">
                                <label for="procRadio">Procedimiento LP (*)</label>
                                <v-select v-model="procedimiento" label="titulo" :options="procedimientos" id="procRadio"></v-select>   
                            </div>      
                        </div>


                        <div class="col-md-3">                       
                            <div class="form-group">
                                <label>Norma Evaluación (*)</label>
                                <v-select v-model="norma_evaluacion" label="descripcion" :options="norma_evaluaciones"></v-select>   
                            </div>      
                        </div>
                        

                        <div class="col-md-3">                       
                            <div class="form-group">
                                <label>Norma Ensayo (*)</label>
                                <v-select v-model="norma_ensayo" label="descripcion" :options="norma_ensayos"></v-select>   
                            </div>      
                        </div>

                        <div class="clearfix"></div>    

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Metodo Trabajo (*)</label>
                                    <v-select  v-model="metodo_trabajo_lp" :options="metodos_trabajo_lp" label="tipo_metodo">
                                        <template slot="option" slot-scope="option">
                                            <span class="upSelect">{{ option.tipo }}</span> <br> 
                                            <span class="downSelect"> {{ option.metodo }} </span>
                                        </template>
                                    </v-select>
                            </div>
                        </div>

                        <div class="col-md-3">                       
                            <div class="form-group">
                                <label> Tipo Penetrante (*)</label>
                                <v-select v-model="tipo_penetrante" label="codigo" :options="['VISIBLE','FLUORESCENTE']"></v-select>   
                            </div>      
                        </div> 

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Líquido Penetrante (*)</label>
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
                                <label>Líquido Revelador (*)</label>
                                    <v-select  v-model="revelador_tipo_liquido" :options="reveladores_tipo_liquido" label="tipo">
                                        <template slot="option" slot-scope="option">
                                            <span class="upSelect">{{ option.tipo }}</span> <br> 
                                            <span class="downSelect"> {{ option.marca }} </span>
                                        </template>
                                    </v-select>
                            </div>
                        </div>

                        <div class="col-md-3">                       
                            <div class="form-group">
                                <label>Aplicación  Revelador (*)</label>
                                <v-select v-model="revelador_aplicacion" label="codigo" :options="aplicaciones_lp"></v-select>   
                            </div>      
                        </div>


                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Líquido Removedor (*)</label>
                                    <v-select  v-model="removedor_tipo_liquido" :options="removedores_tipo_liquido" label="tipo">
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
                                <label>Aplicación  Removedor (*)</label>
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
                                <label for="iluminaciones">Iluminaciones (*)</label>
                                <v-select v-model="iluminacion" label="codigo" :options="iluminaciones"></v-select>   
                            </div>         
                        </div>

                        <div class="col-md-3">                       
                            <div class="form-group" >
                                <label for="ejecutor_ensayo">Ejecutor Ensayo (*)</label>
                                <v-select v-model="ejecutor_ensayo" label="name" :options="ejecutor_ensayos"></v-select>   
                            </div>         
                        </div> 
                        
                  </div>
               </div>

               <div class="box box-danger">
                    <div class="box-body">

                        <div class="col-md-2">                       
                            <div class="form-group" >                            
                                <label for="pieza">Pieza</label>
                                <input type="text" v-model="pieza" class="form-control" id="pieza">                           
                            </div>     
                        </div>                

            
                        <div class="col-md-2">                       
                            <div class="form-group" >                            
                                <label for="numero_piezas">N°</label>
                                <input type="number" v-model="numero_pieza" class="form-control" id="numero_piezas">                           
                            </div>     
                        </div>  

                         <div class="col-md-1">                             
                            <span>
                                <i class="fa fa-plus-circle" @click="addDetalle()"></i>
                            </span>                            
                         </div>  

                         <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:100px;">PIEZA</th>
                                            <th style="width:50px;">N°</th> 
                                            <th style="width:400px;">DETALLE</th>
                                            <th style="width:80px;">ACEPTABLE </th>    
                                            <th style="width:80px;">REFERENCIA </th>                                                  
                                                                        
                                            <th  style="width:30px;"  colspan="1">&nbsp;</th>
                                        </tr>
                                    </thead>                         
                                    <tbody>
                                        <tr v-for="(inputPiezaFalla,k) in (inputPiezasFalla)" :key="k" @click="selectPosDetalle(k)" :class="{selected: indexPosDetalle === k}" >
                                            <td>{{ inputPiezaFalla.pieza }}</td>                                        
                                            <td>{{ inputPiezaFalla.numero }}</td>
                                            <td>   
                                                <div v-if="indexPosDetalle == k ">       
                                                <input type="text" v-model="inputPiezasFalla[k].detalle" maxlength="50" size="120">        
                                                </div>   
                                                <div v-else>
                                                {{ inputPiezasFalla[k].detalle }}
                                                </div>  
                                            </td>    
                                            <td> 
                                                <input type="checkbox" id="checkbox" v-model="inputPiezasFalla[k].aceptable_sn">  </td>
                                            <td> 
                                                <span :class="{ existe : (inputPiezaFalla.observaciones ||
                                                                            inputPiezaFalla.path1 ||
                                                                            inputPiezaFalla.path2 ||
                                                                            inputPiezaFalla.path3 ||
                                                                            inputPiezaFalla.path4 )                      
                                            }" class="fa fa-file-archive-o" @click="OpenReferencias($event,k,'Informe PM',inputPiezaFalla)" ></span>
                                            </td>                                

                                        
                                            <td><span class="fa fa-minus-circle" @click="removeDetalle(k)"></span></td>          

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                       </div>              
                 
                  </div>    
                </div>

               <div class="box box-danger">
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
    </div>       
</template>

<script>
import uniq from 'lodash/uniq';
import Datepicker from 'vuejs-datepicker';
import {mapState} from 'vuex';
import {en, es} from 'vuejs-datepicker/dist/locale'
import { eventSetReferencia } from '../event-bus';
export default {

components: {

      Datepicker
      
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
    }, 
data() {return {
        
        errors:[],
        en: en,
        es: es,

        fecha:'',
        numero_inf:'',
        numero_inf_generado:'',
        componente:'',
        material:'',
        plano_isom:'',
        diametro:'',
        espesor:'',
        espesor_chapa:'', 
        procedimiento_soldadura:'',
        eps:'',
        pqr:'',
        tecnica:'',
        interno_equipo:'',     
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

        //detalle
        pieza:'',
        numero_pieza:'',
        metodos_trabajo_lp:[],
        aplicaciones_lp:[],
        inputPiezasFalla:[],
        indexPosDetalle:0,

        index_referencias:'',
        tabla:'',
        inputsData:{},
       
      }
    },

    created :  function() {

        this.$store.dispatch('loadMateriales');
        this.$store.dispatch('loadDiametros');
        this.$store.dispatch('loadInternoEquiposActivos',this.metodo);       
        this.$store.dispatch('loadProcedimietosOtMetodo',  { 'ot_id' : this.otdata.id, 'metodo' : this.metodo });  
        this.$store.dispatch('loadNormaEvaluaciones');        
        this.$store.dispatch('loadNormaEnsayos'); 
        this.$store.dispatch('loadTipoLiquidos','penetrante_tipo_liquido');      
        this.$store.dispatch('loadTipoLiquidos','revelador_tipo_liquido');      
        this.$store.dispatch('loadTipoLiquidos','removedor_tipo_liquido');     
        this.$store.dispatch('loadIluminaciones'); 
        this.$store.dispatch('loadEjecutorEnsayo', this.otdata.id); 
        this.getMetodosTrabajoLp();  
        this.getAplicacionesLp();  
    },

    mounted : function() {

         this.getNumeroInforme();
    }, 

     watch : {

    
        diametro : function(val){

            this.isChapa = (val.diametro =='CHAPA') ? true : false;
                
        },     

    },

    computed :{

        ...mapState(['url','AppUrl','materiales','diametros','espesores','procedimientos','norma_evaluaciones','norma_ensayos','interno_equipos_activos','iluminaciones','penetrantes_tipo_liquido','reveladores_tipo_liquido','removedores_tipo_liquido','ejecutor_ensayos','fuentePorInterno']),     

        numero_inf_code : function()  {

               if(this.numero_inf)

                      return this.metodo + (this.numero_inf <10? '00' : this.numero_inf<100? '0' : '') + this.numero_inf ;
        },

       
     },

     methods : {

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
            this.$store.dispatch('loadEspesores',this.diametro.diametro_code);
        },

    getFuente : function(){

        this.$store.dispatch('loadFuentePorInterno',this.interno_equipo.interno_fuente_id);
       

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
            this.aplicaciones_lp = response.data
            });
         },

    addDetalle : function () {     

        this.inputPiezasFalla.push({ 
            pieza : this.pieza,
            numero:this.numero_pieza,
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
        this.inputPiezasFalla.splice(index, 1);
    
    },

    OpenReferencias(event,index,tabla,inputsReferencia){

        this.index_referencias = index ;
        this.tabla = tabla;
        this.inputsData = inputsReferencia ;     
        eventSetReferencia.$emit('open');
    },

    AddReferencia(Ref){      

    
        this.inputPiezasFalla[this.index_referencias].observaciones = Ref.observaciones;
        this.inputPiezasFalla[this.index_referencias].path1 = Ref.path1;
        this.inputPiezasFalla[this.index_referencias].path2 = Ref.path2;
        this.inputPiezasFalla[this.index_referencias].path3 = Ref.path3;
        this.inputPiezasFalla[this.index_referencias].path4 = Ref.path4;
    
    
        $('#nuevo').modal('hide');     
    },

    Store : function(){
         
          this.errors =[];

            var urlRegistros = 'informes_lp' ;      
            axios({
              method: 'post',
              url : urlRegistros,    
              data : {             
                'ot'              : this.otdata,
                'ejecutor_ensayo' : this.ejecutor_ensayo,  
                'metodo_ensayo'   : this.metodo,  
                'fecha':          this.fecha,
                'numero_inf':     this.numero_inf,                            
                'componente' :    this.componente,
                'plano_isom' :    this.plano_isom,
                'procedimiento' : this.procedimiento,           
                'observaciones':  this.observaciones,
                'material':       this.material,
                'diametro':       this.diametro.diametro,
                'espesor':        this.espesor.espesor,
                'espesor_chapa'  :  this.espesor_chapa, 
                'interno_equipo'        :  this.interno_equipo,               
                'procedimiento_soldadura': this.procedimiento_soldadura,
                'norma_evaluacion': this.norma_evaluacion,           
                'norma_ensayo'      : this.norma_ensayo,
                'tecnica'           :this.tecnica,              
                'eps'               :this.eps,
                'pqr'               :this.pqr,  
                'metodo_trabajo_lp'             : this.metodo_trabajo_lp,
                'tipo_penetrante'               : this.tipo_penetrante,
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
                'detalles'                      :this.inputPiezasFalla,     
          }
          
          }).then(response => {
          this.response = response.data
          toastr.success('informe N°' + this.numero_inf + ' fue creado con éxito ');
           console.log(response.data);  
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
                'ejecutor_ensayo' : this.ejecutor_ensayo,  
                'metodo_ensayo'   : this.metodo,  
                'fecha':          this.fecha,
                'numero_inf':     this.numero_inf,                            
                'componente' :    this.componente,
                'plano_isom' :    this.plano_isom,
                'procedimiento' : this.procedimiento,           
                'observaciones':  this.observaciones,
                'material':       this.material,
                'diametro':       this.diametro.diametro,
                'espesor':        this.espesor.espesor,
                'espesor_chapa'  :  this.espesor_chapa, 
                'equipo'        :  this.equipo,               
                'procedimiento_soldadura': this.procedimiento_soldadura,
                'norma_evaluacion': this.norma_evaluacion,           
                'norma_ensayo'      : this.norma_ensayo,
                'tecnica'           :this.tecnica,              
                'eps'               :this.eps,
                'pqr'               :this.pqr,  
                'metodo_trabajo_lp'             : this.metodo_trabajo_lp,
                'tipo_penetrante'               : this.tipo_penetrante,
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
                'detalles'                      :this.inputPiezasFalla,                       
          }}
          
      
        ).then(response => {
          this.response = response.data
          toastr.success('informe N°' + this.numero_inf + ' fue actualizado con éxito ');
       
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

.col-md-1-5 {

    width: 12.499999995%
   
}

@media (min-width: 768px)  { 
    
    .size-1-5 {

        width: 12.499999995%;
    }
}

.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
     background-color: #eee;
}

</style>