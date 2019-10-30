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
                            <label for="plano_isom">Plano / Isom (*)</label>
                            <input type="text" v-model="plano_isom" class="form-control" id="plano_isom">
                        </div>                            
                    </div>

                       <div class="col-md-3 size-1-5">
                            <div class="form-group" >
                                <label for="Diametro">Diametro (*)</label>
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
                                <label for="espesor_chapa">Espesor Chapa</label>
                                <input  type="text" class="form-control" v-model="espesor_chapa"  id="espesor_chapa" :disabled="!isChapa" > 
                             </div>                                      
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="procedimientos_soldadura">Procedimiento Soldadura (*)</label>
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

                        <div class="col-md-3" >                       
                            <div class="form-group">
                                <label for="tecnicas">Tecnica (*)</label>
                                <v-select v-model="tecnica" label="descripcion" :options="tecnicas" id="tecnicas"></v-select>   
                            </div>      
                         </div>                   

                         <div class="col-md-3">
                            <div class="form-group">
                                <label>Equipo (*)</label>
                                    <v-select  v-model="interno_equipo" :options="interno_equipos_activos" label="nro_interno" @input="getFuente(interno_equipo.interno_fuente_id)">
                                        <template slot="option" slot-scope="option">
                                            <span class="upSelect">{{ option.nro_interno }}</span> <br> 
                                            <span class="downSelect"> {{ option.equipo.codigo }} </span>
                                        </template>
                                    </v-select>
                            </div>
                         </div>                

                        <div class="col-md-3">                       
                            <div class="form-group">
                                <label for="procRadio">Procedimiento PM (*)</label>
                                <v-select v-model="procedimiento" label="titulo" :options="procedimientos" id="procRadio"></v-select>   
                            </div>      
                        </div>

                        <div class="clearfix"></div>    

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

                        <div class="col-md-3">                       
                            <div class="form-group">
                                <label>Método (*)</label>
                                <v-select v-model="metodo_trabajo_pm" label="codigo" :options="metodos_trabajo_pm"></v-select>   
                            </div>      
                        </div>

                         <div class="col-md-3">
                            <div class="form-group" >  
                                <div v-if="requiereVehiculoAditivo">
                                    <label for="vehiculo">Vehículo (*)</label> 
                                </div>
                                <div v-else>
                                     <label for="vehiculo">Vehículo</label> 
                                </div>                           
                                <input  type="text" class="form-control" v-model="vehiculo" :disabled="!requiereVehiculoAditivo" id="vehiculo"> 
                            </div>                             
                        </div> 

                         <div class="col-md-3">
                            <div class="form-group" >
                                <div v-if="requiereVehiculoAditivo">
                                    <label for="aditivo">Aditivo (*)</label> 
                                </div>
                                <div v-else>
                                     <label for="aditivo">Aditivo</label>       
                                </div>                             
                                <input  type="text" class="form-control" v-model="aditivo"  :disabled="!requiereVehiculoAditivo" id="aditivo"> 
                            </div>                             
                        </div>   

                        <div class="col-md-3">
                            <div class="form-group" >                        
                                <label for="concentracion">Concentración (*)</label>
                                <input  type="number" class="form-control" v-model="concentracion" id="concentracion" step=".01"> 
                            </div>                             
                        </div>                        

                        <div class="col-md-3">                       
                            <div class="form-group">
                                <label>Tipo Magnetización (*)</label>
                                <v-select v-model="tipo_magnetizacion" label="codigo" :options="tipos_magnetizacion"></v-select>   
                            </div>      
                        </div>

                         
                        <div class="col-md-1 size-1-5">
                            <div class="form-group" >                        
                                <label for="v">Voltaje (*)</label>
                                <input  type="number" class="form-control" v-model="voltaje" id="v" max="999"> 
                            </div>                             
                        </div> 

                        <div class="col-md-1 size-1-5">
                            <div class="form-group" >                        
                                <label for="am">Am (*)</label>
                                <input  type="number" class="form-control" v-model="am" id="am" max="99"> 
                            </div>                             
                        </div> 

                        <div class="col-md-3">                       
                            <div class="form-group">
                                <label>Magnetización (*)</label>
                                <v-select v-model="magnetizacion" label="codigo" :options="corrientes"></v-select>   
                            </div>      
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >                        
                                <label for="fuerza_portante">Fuerza Portante</label>
                                <input  type="number" class="form-control" v-model="magnetizacion.fuerza_portante" disabled id="fuerza_portante"> 
                            </div>                             
                        </div> 

                        <div class="col-md-3">                       
                            <div class="form-group" >
                                <label for="color_particulas">Color Particulas (*)</label>
                                <v-select v-model="color_partula" label="codigo" :options="color_particulas"></v-select>   
                            </div>         
                        </div>  

                        <div class="col-md-3">                       
                            <div class="form-group" >
                                <label for="iluminaciones">Iluminaciones (*)</label>
                                <v-select v-model="iluminacion" label="codigo" :options="iluminaciones"></v-select>   
                            </div>         
                        </div>  

                        <div class="clearfix"></div>    

                        <div class="col-md-3">                       
                            <div class="form-group">
                                <label>Desmagnetización (*)</label>
                                <v-select v-model="desmagnetizacion" :options="['SI','NO']"></v-select>   
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

     informedata : {
      type : Object,
      required : false
      },
 

     informe_pmdata : {
      type : Object,
      required : false
      },

      materialdata : {
      type : Object,
      required : false
      },

      diametrodata : {
      type : Object,
      required : false
      },

      diametro_espesordata : {
      type : Object,
      required : false
        }, 

      tecnicadata : {
      type : [ Object ],  
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

      metodo_trabajo_pmdata : {
      type : [ Object ],  
      required : false
      },

      tipo_magnetizacion_data : {
      type : [ Object ],  
      required : false
      },

      magnetizacion_data : {
      type : [ Object ],  
      required : false
      },

      desmagnetizacion_sn_data : {
      type : [ Number ],  
      required : false
      },

     color_particula_data : {
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
      }

    },
    data() {return {
        
        errors:[],
        en: en,
        es: es, 

        cliente:'',
        fecha:'',
        observaciones:'',
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
        ejecutor_ensayo:'',
        metodo_trabajo_pm:'',
        vehiculo:'',
        aditivo:'',
        concentracion:'',
        tipo_magnetizacion:'',
        magnetizacion:'',
        desmagnetizacion:'',
        fuerza_portante:'',
        voltaje:'',
        am:'',
        color_partula:'',
        iluminacion:'',       
      
        tecnicas:[],
        equipos:[],

        metodos_trabajo_pm:[],
        tipos_magnetizacion:[],
        corrientes:[],      
        color_particulas:[],     
        isChapa:false,
        requiereVehiculoAditivo:false,

        //detalle
        pieza:'',
        numero_pieza:'',
        inputPiezasFalla:[],
        indexPosDetalle:0,

        index_referencias:'',
        tabla:'',
        inputsData:{},

    }},

    created : function() {

      this.getCliente();  
      this.$store.dispatch('loadMateriales');
      this.$store.dispatch('loadDiametros');
      this.getTecnicas();
      this.$store.dispatch('loadInternoEquiposActivos',this.metodo);       
      this.$store.dispatch('loadProcedimietosOtMetodo',  { 'ot_id' : this.otdata.id, 'metodo' : this.metodo });
      this.$store.dispatch('loadNormaEvaluaciones');        
      this.$store.dispatch('loadNormaEnsayos');
      this.getMetodosTrabajoPm();
      this.$store.dispatch('loadEjecutorEnsayo', this.otdata.id); 
      this.getTiposMagnetizacon();
      this.getCorrientes();
      this.getColorParticulas();
      this.$store.dispatch('loadIluminaciones');
      this.setEdit();      
    },

    mounted : function() {

         this.getNumeroInforme();
    }, 

    computed :{

        ...mapState(['url','AppUrl','materiales','diametros','espesores','procedimientos','norma_evaluaciones','norma_ensayos','iluminaciones','ejecutor_ensayos','interno_equipos_activos']),     

        numero_inf_code : function()  {

               if(this.numero_inf)

                      return this.metodo + (this.numero_inf <10? '00' : this.numero_inf<100? '0' : '') + this.numero_inf ;
        },
       
     },

     watch : {

    
        diametro : function(val){

            this.isChapa = (val.diametro =='CHAPA') ? true : false;
                
        },

        metodo_trabajo_pm : function(val){
            
            this.requiereVehiculoAditivo = val.requiere_vehiculo_aditivo_sn ? true : false;              
            this.vehiculo='';
            this.aditivo='';     

        }

    },

    methods : {

        setEdit : function(){

            if(this.editmode) {               
            

               this.fecha   = this.informedata.fecha;            
               this.numero_inf = this.informedata.numero;
               this.componente = this.informedata.componente;
               this.material = this.materialdata;
               this.plano_isom = this.informedata.plano_isom;
               this.diametro = this.diametrodata;
               this.espesor = this.diametro_espesordata;
               this.tecnica = this.tecnicadata;
               this.interno_equipo = this.interno_equipodata;           
               this.procedimiento = this.procedimientodata;            
               this.norma_evaluacion = this.norma_evaluaciondata;
               this.norma_ensayo = this.norma_ensayodata;            
               this.espesor_chapa = this.informedata.espesor_chapa;
               this.procedimiento_soldadura = this.informedata.procedimiento_soldadura;
               this.eps = this.informedata.eps;
               this.pqr = this.informedata.pqr;           
               this.metodo_trabajo_pm = this.metodo_trabajo_pmdata;               

                this.$nextTick(function(){
                    
                this.vehiculo = this.informe_pmdata.vehiculo;    
                this.aditivo = this.informe_pmdata.aditivo;

                })           


               this.concentracion  = this.informe_pmdata.concentracion;
               this.tipo_magnetizacion = this.tipo_magnetizacion_data;
               this.magnetizacion = this.magnetizacion_data;
               this.desmagnetizacion = this.desmagnetizacion_sn_data ? 'SI' : 'NO';
               this.voltaje = this.informe_pmdata.voltaje;
               this.color_partula = this.color_particula_data;
               this.iluminacion = this.iluminacion_data;
               this.am = this.informe_pmdata.amperaje;              
               this.ejecutor_ensayo = this.ejecutor_ensayodata;          
               this.inputPiezasFalla = this.detalledata,  
               this.observaciones = this.informedata.observaciones 

            }         

        },       

        getCliente : function(){
           
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'clientes/' + this.otdata.cliente_id + '?api_token=' + Laravel.user.api_token;           
            axios.get(urlRegistros).then(response =>{
            this.cliente = response.data
           
            });
        },


        getNumeroInforme:function(){            
           
            if(!this.editmode) {           

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

        getTecnicas: function(){
            
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'tecnicas/metodo/' + this.metodo + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
            this.tecnicas = response.data
            });
            },

        getEquipos : function(){
           
            axios.defaults.baseURL = this.url ;
                var urlRegistros = 'equipos/metodo/' + this.metodo + '?api_token=' + Laravel.user.api_token;         
                axios.get(urlRegistros).then(response =>{
                this.equipos = response.data   
            
                });

        },         

         getEjecutorEnsayo: function(){
             
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'ot-operarios/ot/' + this.otdata.id + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
            this.ejecutor_ensayos = response.data
            });
         },

         getMetodosTrabajoPm: function(){
             
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'metodos_trabajo_pm' + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
            this.metodos_trabajo_pm = response.data
            });
         },

         getTiposMagnetizacon: function(){
             
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'tipos_magnetizacion' + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
            this.tipos_magnetizacion = response.data
            });
         },

         getCorrientes: function(){
             
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'corrientes' + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
            this.corrientes = response.data
            });
         },

         getColorParticulas: function(){
             
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'color_particulas' + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
            this.color_particulas = response.data
            });
         },

         selectPosDetalle :function(index){

        
            this.indexPosDetalle = index ;
           
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
          let desmagnetizacion_sn ;
          if(this.desmagnetizacion =='SI')
            desmagnetizacion_sn = true;
          else if(this.desmagnetizacion =='NO')
            desmagnetizacion_sn = false;
          else
            desmagnetizacion_sn= null;  

            var urlRegistros = 'informes_pm' ;      
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
                'espesor_chapa' :  this.espesor_chapa, 
                'interno_equipo'        :  this.interno_equipo,               
                'procedimiento_soldadura': this.procedimiento_soldadura,
                'norma_evaluacion': this.norma_evaluacion,           
                'norma_ensayo'      : this.norma_ensayo,
                'tecnica'           :this.tecnica,              
                'eps'               :this.eps,
                'pqr'               :this.pqr,  
                'metodo_trabajo_pm' : this.metodo_trabajo_pm,
                'voltaje'           :this.voltaje,
                'am'                :this.am,
                'vehiculo'          :this.vehiculo,
                'aditivo'           :this.aditivo,
                'concentracion'     :this.concentracion,
                'tipo_magnetizacion':this.tipo_magnetizacion,
                'magnetizacion'     :this.magnetizacion,
                'desmagnetizacion_sn'  :desmagnetizacion_sn,
                'fuerza_portante'   :this.fuerza_portante,
                'color_particula'   :this.color_partula,
                'iluminacion'       :this.iluminacion,
                'detalles'  :      this.inputPiezasFalla,        
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
            let desmagnetizacion_sn ;
            if(this.desmagnetizacion =='SI')
                desmagnetizacion_sn = true;
            else if(this.desmagnetizacion =='NO')
                desmagnetizacion_sn = false;
            else
                desmagnetizacion_sn= null;    

            var urlRegistros = 'informes_pm/' + this.informedata.id  ;      
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
                'espesor_chapa' :  this.espesor_chapa, 
                'interno_equipo'        :  this.interno_equipo,          
                'procedimiento_soldadura': this.procedimiento_soldadura,
                'norma_evaluacion': this.norma_evaluacion,           
                'norma_ensayo'      : this.norma_ensayo,
                'tecnica'           :this.tecnica,              
                'eps'               :this.eps,
                'pqr'               :this.pqr,  
                'metodo_trabajo_pm' : this.metodo_trabajo_pm,
                'voltaje'           :this.voltaje,
                'am'                :this.am,
                'vehiculo'          :this.vehiculo,
                'aditivo'           :this.aditivo,
                'concentracion'     :this.concentracion,
                'tipo_magnetizacion':this.tipo_magnetizacion,
                'magnetizacion'     :this.magnetizacion,
                'desmagnetizacion_sn'  :desmagnetizacion_sn,
                'fuerza_portante'   :this.fuerza_portante,
                'color_particula'   :this.color_partula,
                'iluminacion'       :this.iluminacion,
                 'detalles'  :      this.inputPiezasFalla,                      
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