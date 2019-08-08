<template>
   <div class="row">
       <div class="col-md-12">
           <form @submit.prevent="editmode ?  Update() : Store()"  method="post">
               <div class="box box-danger">
                  <div class="box-body"> 
                      <div class="col-md-6">
                            <div class="form-group" >
                                <label for="cliente">Cliente</label>
                                <input type="text" v-model="cliente.nombre_fantasia" class="form-control" id="cliente" disabled>
                            </div>                            
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" >
                                <label for="proyecto">Proyecto</label>
                                <input type="text" v-model="otdata.proyecto" class="form-control" id="proyecto" disabled>
                            </div>                            
                        </div>                        
                        <div class="col-md-6">
                            <div class="form-group" >
                                <label for="obra">Obra N°</label>
                                <input type="number" v-model="otdata.obra" class="form-control" id="obra" disabled>
                            </div>                            
                        </div>
                        <div class="col-md-6">
                                <div class="form-group" >
                                    <label for="ot">Orden de Trabajo N°</label>
                                    <input type="number" v-model="otdata.numero" class="form-control" id="ot" disabled>
                                </div>                            
                            </div>
                  </div>
               </div>
               <div class="box box-danger">
                  <div class="box-body">
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="formato">Tipo informe RI</label>
                                <v-select v-model="formato" :options="['PLANTA', 'GASODUCTO']"></v-select>
                            </div>                            
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                 <label for="fecha">Fecha</label>
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
                                <label for="prefijo">Prefijo</label>
                                <input type="text" v-model="prefijo" class="form-control" id="prefijo">
                            </div>                            
                        </div>
                         <div class="col-md-3">
                            <div class="form-group" >
                                <label for="numero_inf">Informe N°</label>
                                <input type="number" v-model="numero_inf" class="form-control" id="numero_inf">
                            </div>                            
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="componente">Componente</label>
                                <input type="text" v-model="componente" class="form-control" id="componente">
                            </div>                            
                        </div>
                        <div class="col-md-3" >                       
                            <div class="form-group">
                                <label for="materiales">Material</label>
                                <v-select v-model="material" label="codigo" :options="materiales" id="materiales"></v-select>   
                            </div>      
                        </div>                      
                        
                        <div class="col-md-1" style="width: 12.499999995%">
                            <div class="form-group" >
                                <label for="plano_isom">Plano / Isom</label>
                                <input type="text" v-model="plano_isom" class="form-control" id="plano_isom">
                            </div>                            
                        </div>

                        <div class="col-md-3" style="width: 12.499999995%">
                            <div class="form-group" >
                                <label for="Diametro">Diametro</label>
                                <v-select v-model="diametro" label="diametro" :options="diametros" @input="getEspesores()"></v-select>   
                            </div>                            
                        </div>                       
                        
                        <div class="col-md-1" style="width: 12.499999995%">
                            <div class="form-group" >
                                <label>Espesor</label>
                                <v-select v-model="espesor" label="espesor" :options="espesores" :disabled="isChapa"></v-select>   
                            </div>                            
                        </div>
                      
                        <div class="col-md-1" style="width: 12.499999995%">    
                             <div class="form-group" >                         
                                <label for="espesor_chapa">Espesor Chapa</label>
                                <input  type="text" class="form-control" v-model="espesor_chapa"  id="espesor_chapa" :disabled="!isChapa" > 
                             </div>                                      
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="procedimientos_soldadura">Procedimiento Soldadura</label>
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
                            <div class="form-group">
                                <label>Técnica</label>
                                    
                                <v-select v-model="tecnica" label="grafico_id" :options="tecnicas" @input="ActualizarDistFuentePelicula()">  
                                    <template slot="option" slot-scope="option">
                                        <img :src="option.path" width="80" height="73" />  
                                        <span style="margin-left: 5px"> {{option.descripcion}} </span>                                     
                                    </template> 
                                </v-select>
                            </div>      
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-2">
                            <div class="form-group" >
                                <label for="equipos">Equipo</label>
                                <v-select v-model="equipo" label="codigo" :options="equipos" @input="resetInputsEquipos()"></v-select>  
                            </div>                            
                        </div>
                       
                        <div class="col-md-1">
                            <div class="form-group" >                   
                                <label for="kv">Kv</label>
                                <input  type="number" class="form-control" v-model="kv" :disabled="!isRX"  id="kv">     
                            </div>                         
                        </div>
                        <div class="col-md-1">
                            <div class="form-group" >                        
                                <label for="ma">mA</label>
                                <input  type="number" class="form-control" v-model="ma"  :disabled="!isRX" id="ma"> 
                            </div>                             
                        </div>                       
                      
                        <div class="col-md-2">
                            <div class="form-group" >
                                <label for="fuente">Fuente</label>
                                <v-select v-model="fuente" label="codigo" :options="fuentes" :disabled="isRX"></v-select>   
                            </div>                            
                        </div>

                        <div class="col-md-1" style="width: 12.499999995%">
                            <div class="form-group" >
                                <label for="foco">Foco</label>
                                <input type="text" v-model="foco" class="form-control" id="foco">
                            </div>                            
                        </div>

                        <div class="col-md-1" style="width: 12.499999995%">
                            <div class="form-group">
                                <label>Calidad de placas</label>
                                    <v-select  v-model="tipo_pelicula" :options="tipo_peliculas" label="codigo">
                                        <template slot="option" slot-scope="option">
                                            <span class="upSelect">{{ option.codigo }}</span> <br> 
                                            <span class="downSelect"> {{ option.fabricante }} </span>
                                        </template>
                                    </v-select>
                            </div>
                        </div>

                        <div class="col-md-3">                       
                            <div class="form-group">
                                <label for="procRadio">Procedimiento Radiográfico</label>
                                <v-select v-model="procedimiento" label="titulo" :options="procedimientos" id="procRadio"></v-select>   
                            </div>      
                        </div>

                        <div class="clearfix"></div>    

                        <div class="col-md-1">
                            <div class="form-group" >
                                <label for="pantalla">Pantalla</label>
                                <input type="text" v-model="pantalla" class="form-control" id="pantalla" disabled>
                            </div>                            
                        </div>
                        
                            <div class="col-md-1">
                            <div class="form-group" >
                                <label for="pos_ant">Ant</label>
                                <input type="number" v-model="pos_ant" class="form-control" id="pos_ant">
                            </div>                            
                        </div>
                        <div class="col-md-1">
                            <div class="form-group" >
                                <label for="pos_pos">Pos</label>
                                <input type="number" v-model="pos_pos" class="form-control" id="pos_pos">
                            </div>                            
                        </div>

                            <div class="col-md-1">
                            <div class="form-group" >
                                <label for="pos_pos">lado</label>
                                <input type="text" v-model="lado" class="form-control" id="lado">
                            </div>                            
                        </div>
                            
                        <div class="col-md-2">
                            <div class="form-group" >
                                <label for="ici">Ici</label>
                                <v-select v-model="ici" label="codigo" :options="icis"></v-select>   
                            </div>                            
                        </div>                            
                           
                        <div class="col-md-3">                       
                            <div class="form-group">
                                <label>Norma Evaluación</label>
                                <v-select v-model="norma_evaluacion" label="descripcion" :options="norma_evaluaciones"></v-select>   
                            </div>      
                        </div>
                        
                        <div class="col-md-3">                       
                            <div class="form-group">
                                <label>Norma Ensayo</label>
                                <v-select v-model="norma_ensayo" label="descripcion" :options="norma_ensayos"></v-select>   
                            </div>      
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-3">                       
                            <div class="form-group" >
                                <label for="eps">Actividad</label>
                                <input type="text" v-model="actividad" class="form-control" id="actividad">
                            </div>         
                        </div>       
                        <div class="col-md-3">                       
                            <div class="form-group" >
                                <label for="eps">Exposición</label>
                                <input type="number" v-model="exposicion" class="form-control" id="exposicion">
                            </div>         
                        </div>                                            
                    
                        
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="distancia_fuente_pelicula">Dist. Fuente</label>
                                <input type="text" v-model="distancia_fuente_pelicula" class="form-control" :disabled="!isChapa" id="distancia_fuente_pelicula">
                            </div>                            
                        </div>  

                        <div class="col-md-3">                       
                            <div class="form-group" >
                                <label for="ejecutor_ensayo">Ejecutor Ensayo</label>
                                <v-select v-model="ejecutor_ensayo" label="name" :options="ejecutor_ensayos"></v-select>   
                            </div>         
                        </div>                       
                           
                                                                 
                                                               
                  </div>
               </div>

               <!-- Detalle RI Planta -->
               <div class="box box-danger">
                <div class="box-body">
                  
                    <div class="col-md-2">                       
                         
                        
                            <label for="junta">Junta</label>
                            <input type="text" v-model="junta" class="form-control" id="junta">
                      
                    </div>       
                    <div class="col-md-3">
                        
                            <label>Cunio 1</label>           
                            <v-select v-model="soldador1" :options="soldadores" label="nombre">
                                <template slot="option" slot-scope="option">
                                    <span class="upSelect">{{ option.nombre }} </span> <br> 
                                    <span class="downSelect">   {{ option.codigo }} </span>
                                </template>
                            </v-select>                
                      
                    </div> 
                    <div class="col-md-3">
                         
                            <label>Cunio 2</label>           
                            <v-select v-model="soldador2" :options="soldadores" label="nombre">
                                <template slot="option" slot-scope="option">
                                    <span class="upSelect">{{ option.nombre }} </span> <br> 
                                    <span class="downSelect">   {{ option.codigo }} </span>
                                </template>
                            </v-select>                
                      
                    </div>      
                        <div class="col-md-3">                       
                          <div class="form-group" >
                            
                            <label for="posicion">Posición</label>

                            <input type="text" v-model="posicion" class="form-control" id="posicion">
                           
                             </div>     
                        </div>       
                        <div class="col-md-2"> 
                            <div class="form-group" >
                               <button type="button" class="btn btn-primary btn-xs" @click="ClonarPosPlanta()">Clonar Pos</button>
                            </div> 
                        </div>  
                                                             
                    <div class="col-md-1"> 
                                 
                          <span>
                              <i class="fa fa-plus-circle" @click="addJuntaDefectosPlanta()"></i>
                          </span>
                       
                    </div>
                    
                    <div class="col-md-12">

                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>JUNTA</th>
                                        <th>CUNIO 1</th>
                                        <th>CUNIO 2</th>
                                        <th>POS</th>  
                                        <th>ACEPTABLE</th>    
                                        <th>OBS</th>                                                    
                                                                       
                                        <th colspan="2">&nbsp;</th>
                                    </tr>
                                </thead>                         
                                <tbody>
                                    <tr v-for="(inputsJuntaDefectosPlanta,k) in (inputsJuntasDefectosPlanta)" :key="k" @click="selectPosPlanta(k)">
                                        <td>{{ inputsJuntaDefectosPlanta.junta }}</td>
                                        <td>{{ inputsJuntaDefectosPlanta.soldador1.nombre }} </td>
                                        <td>{{ inputsJuntaDefectosPlanta.soldador2.nombre }} </td>   
                                        <td>{{ inputsJuntaDefectosPlanta.posicion }} </td>   
                                        <td> <input type="checkbox" id="checkbox" v-model="inputsJuntasDefectosPlanta[k].aceptable_sn">  </td>                                 
                                        <td><input type="text" v-model="inputsJuntasDefectosPlanta[k].observacion"></td>
                                       
                                        <td> <i class="fa fa-minus-circle" @click="removeJuntaDefectosPlanta(k)" ></i> </td>          

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                       </div>
                    </div>
                   </div>

                    <div class="box box-danger">
                        
                       <div class="box-header with-border">
                        <!--
                           <div v-if="inputsJuntasDefectosPlanta && inputsJuntasDefectosPlanta.length > 0">
                              <h3 class="box-title">DEFECTOS POSICIÓN: Junta  {{ inputsJuntasDefectosPlanta[indexPosPlanta].junta}} / Posición  {{ inputsJuntasDefectosPlanta[indexPosPlanta].posicion}}</h3>  
                           </div>
                        -->
                      <div class="box-body"> 
                                                   
                        <div class="col-md-3">                          
                           <div class="form-group" >
                                <label>Defectos</label>           
                                <v-select v-model="defectoRiPlanta" :options="defectosRiPlanta" label="descripcion">
                                    <template slot="option" slot-scope="option">
                                        <span class="upSelect">{{ option.descripcion }} </span> <br> 
                                        <span class="downSelect">{{ option.codigo }} </span>
                                    </template>
                                </v-select>                
                            </div>   
                        </div>  
                          
                        <div class="col-md-1"> 
                        <div class="form-group">                    
                            <span>
                                <i class="fa fa-plus-circle" @click="addDefectoPosicionPlanta()"></i>
                            </span>
                            </div>
                        </div>                      
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>CÓDIGO</th>                                                                                  
                                            <th>DESCRIPCIÓN</th>                                                                 
                                            <th colspan="2">&nbsp;</th>
                                        </tr>
                                    </thead>                         
                                    <tbody>
                                        <tr v-for="(defectoPosicion,k) in 
                                         (( (inputsJuntasDefectosPlanta.length > 0) && (inputsJuntasDefectosPlanta[indexPosPlanta].defectosPosicion.length > 0 )) ? inputsJuntasDefectosPlanta[indexPosPlanta].defectosPosicion : [])"  :key="k">
                                            <td>{{ defectoPosicion.codigo }}</td>    
                                            <td>{{ defectoPosicion.descripcion }}</td>             
                                        
                                            <td> <i class="fa fa-minus-circle" @click="removeDefectoPosicionPlanta(k)" ></i> </td>          

                                        </tr>
                                    </tbody>
                                 </table>
                                </div>
                           </div>
                       </div>
                      </div>
                    </div>                    
               
                  <button class="btn btn-primary" type="submit">Guardar</button>   
           </form>    
       </div>
   </div>
</template>

<script>

import uniq from 'lodash/uniq';
import Datepicker from 'vuejs-datepicker';
import {mapState} from 'vuex';
import {en, es} from 'vuejs-datepicker/dist/locale'
export default {

    components: {

      Datepicker
      
    },

    props : {

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

           // Formulario encabezado

            fecha:'',
            numero_inf:'',
            prefijo:'',
            formato :'',          
            componente:'',
            plano_isom:'',
            procedimiento:{},           
            observaciones:'',
            material:{},
            diametro:'',
            espesor:'',
            espesor_chapa:'', 
            equipo:'',
            fuente:'',
            foco:'',
            tipo_pelicula:'',
            pantalla:'Pb',
            pos_ant:'',
            pos_pos:'',
            lado:'',
            distancia_fuente_pelicula:'',
            procedimiento_soldadura:'',
            norma_evaluacion:'',
            ici:'',
            norma_ensayo:'',
            tecnica:'',
            eps:'',
            pqr:'',
            exposicion:'',      
            actividad:'',          
            ejecutor_ensayo:'',
            tecnicas_grafico :'',
            kv:'',
            ma:'', 
            tecnica_distancia:'',
           
           // Fin Formulario encabezado

           // Formulario detalle
            junta:'',
            soldador1:'',
            soldador2:'',
            posicion:'',          
            defectoObs:'',
            defectoRiPlanta:'',
            defectoRiGasoducto:'',
            indexPosPlanta:0,

            //Fin Formulario detalle

            cliente :'',
            isRX:false,
            isChapa:false,

             procedimientos:[],
             materiales:[],
             diametros:[],
             espesores:[],
             equipos:[],
             fuentes:[],
             tipo_peliculas:[],
             norma_evaluaciones:[],
             icis:[],
             norma_ensayos:[],
             tecnicas:[],
             ejecutor_ensayos :[],
             tecnicas_graficos :[],

            
             soldadores:[],
             posiciones:[],
             defectosRiPlanta:[],
             defectosRiGasoducto:[],
             inputsJuntasDefectosPlanta:[],           
           
             


    }},

    created : function(){      
        
        this.getCliente();
        this.getProcedimientos();
        this.getMateriales();
        this.getDiametros();
        this.getEquipos();
        this.getFuentes();
        this.getTipoPeliculas();
        this.getNormaEvaluaciones();
        this.getIcis();
        this.getNormaEnsayos();
        this.getTecnicas();
        this.getEjecutorEnsayo();
        this.getSoldadores();
        this.getDefectosRiPlanta();
        this.getDefectosRiGasoducto();
       
    },   
    
    watch : {

        equipo : function(val){

            this.isRX = val.codigo =='RX' ? true : false;
                
        },
        diametro : function(val){

            this.isChapa = val.diametro =='CHAPA' ? true : false;
                
        }
    },

    computed :{

        ...mapState(['url','AppUrl']),
        
       
     },

    methods : {

        getCliente : function(){

            axios.defaults.baseURL = this.url ;
                var urlRegistros = 'clientes/' + this.otdata.cliente_id + '?api_token=' + Laravel.user.api_token;         
                axios.get(urlRegistros).then(response =>{
                this.cliente = response.data
                });
        },

        getProcedimientos : function(){

            axios.defaults.baseURL = this.url ;
                var urlRegistros = 'procedimientos_informes/ot/' + this.otdata.id + '/metodo/' + this.metodo + '?api_token=' + Laravel.user.api_token;         
                axios.get(urlRegistros).then(response =>{
                this.procedimientos = response.data
                });

        },

        getMateriales : function(){

            axios.defaults.baseURL = this.url ;
                var urlRegistros = 'materiales' + '?api_token=' + Laravel.user.api_token;         
                axios.get(urlRegistros).then(response =>{
                this.materiales = response.data
                });

        },

        getDiametros : function(){

            axios.defaults.baseURL = this.url ;
                var urlRegistros = 'diametros' + '?api_token=' + Laravel.user.api_token;         
                axios.get(urlRegistros).then(response =>{
                this.diametros = response.data
               
                });
         
        },

        getEspesores : function(){
            this.espesor=''; 
            this.distancia_fuente_pelicula='';   
            this.tecnica ='';      
            axios.defaults.baseURL = this.url ;
                var urlRegistros = 'espesor/' + this.diametro.diametro_code + '?api_token=' + Laravel.user.api_token;         
                axios.get(urlRegistros).then(response =>{
                this.espesores = response.data
                });
        },

        getEquipos : function(){
           
            axios.defaults.baseURL = this.url ;
                var urlRegistros = 'equipos/metodo/' + this.metodo + '?api_token=' + Laravel.user.api_token;         
                axios.get(urlRegistros).then(response =>{
                this.equipos = response.data   
            
                });

        },

        getFuentes : function(){
          
            axios.defaults.baseURL = this.url ;
                var urlRegistros = 'fuentes' + '?api_token=' + Laravel.user.api_token;         
                axios.get(urlRegistros).then(response =>{
                this.fuentes = response.data
                });

        },

        getTipoPeliculas : function(){

            axios.defaults.baseURL = this.url ;
                var urlRegistros = 'tipo_peliculas' + '?api_token=' + Laravel.user.api_token;         
                axios.get(urlRegistros).then(response =>{
                this.tipo_peliculas = response.data
               
                });
         
        },

        getNormaEvaluaciones: function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'norma_evaluaciones' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.norma_evaluaciones = response.data
                });
              },

        getIcis: function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'icis' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.icis = response.data
                });
              },

        getNormaEnsayos: function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'norma_ensayos' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.norma_ensayos = response.data
                });
              },

        getTecnicas: function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'tecnicas' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.tecnicas = response.data
                });
              },
        ActualizarDistFuentePelicula : function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'tecnica_distancias/'+ this.tecnica.id +'/diametro/'+ this.diametro.diametro_code + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.tecnica_distancia = response.data
                this.distancia_fuente_pelicula=this.tecnica_distancia[0].distancia_fuente_peliculas;
               });

  

        },

        getTecnicasGraficos: function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'tecnicas_graficos/'+ this.tecnica.id + '?api_token=' + Laravel.user.api_token;     
                console.log(urlRegistros);   
                axios.get(urlRegistros).then(response =>{
                this.tecnicas_graficos = response.data
                });
              },

        getEjecutorEnsayo: function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'ot-operarios/ejecutor_ensayo/' + this.otdata.id + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.ejecutor_ensayos = response.data
                });
              },

        resetInputsEquipos : function() {

                this.fuente = '' ;
                this.kv = '',
                this.ma = ''

        },

        //detalle

        getSoldadores : function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'soldadores/cliente/' + this.otdata.cliente_id + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.soldadores = response.data
                });
             
        },

        getDefectosRiPlanta : function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'defectos_ri/planta/' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.defectosRiPlanta = response.data
                });
             
        },
        getDefectosRiGasoducto : function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'defectos_ri/gasoducto/' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.defectosRiGasoducto = response.data
                });
             
        },

        selectPosPlanta :function(index){

            this.indexPosPlanta = index ;
        },

        addJuntaDefectosPlanta (posicion) { 
            
            console.log(posicion);

            this.inputsJuntasDefectosPlanta.push({ 
                junta: this.junta,
                soldador1: this.soldador1,
                soldador2: this.soldador2,     
                posicion : (typeof(posicion) !== 'undefined') ? posicion : this.posicion, 
                aceptable_sn : true ,
                observacion : '',
                defectosPosicion : []           
                 });                  

           
        },

        removeJuntaDefectosPlanta(index) {
          this.indexPosPlanta = 0;
          console.log('indexposplatanta antes de borrar' + this.indexPosPlanta);
          console.log('index antes de borrar' + index);
           
            this.inputsJuntasDefectosPlanta.splice(index, 1);
            console.log('indexposplatanta despues de borrar' + this.indexPosPlanta);
            
            
        },

        addDefectoPosicionPlanta (index) {
         

            this.inputsJuntasDefectosPlanta[this.indexPosPlanta].defectosPosicion.push({ 
                codigo: this.defectoRiPlanta.codigo,
                descripcion: this.defectoRiPlanta.descripcion,
                id : this.defectoRiPlanta.id,                    
                 });                  
           
        },

        removeDefectoPosicionPlanta(index) {
            this.inputsJuntasDefectosPlanta[this.indexPosPlanta].defectosPosicion.splice(index, 1);
            
        },

        insertarClonacion : function (posicion){

           this.addJuntaDefectosPlanta(posicion);
        },

        ClonarPosPlanta : function(){
            console.log("entro en clonar");

            if(this.inputsJuntasDefectosPlanta.length > 0){

                let inputsJuntasDefectosPlantaReverse =  JSON.parse(JSON.stringify(this.inputsJuntasDefectosPlanta));         
                let x = inputsJuntasDefectosPlantaReverse.length-1;
                let juntaAux = inputsJuntasDefectosPlantaReverse[x].junta;
                let posicionJunta =[];

                console.log(juntaAux);
                console.log(inputsJuntasDefectosPlantaReverse.length);
                while (  (x >= 0)  && (juntaAux == inputsJuntasDefectosPlantaReverse[x].junta)) {     

                    posicionJunta.unshift(inputsJuntasDefectosPlantaReverse[x].posicion);                    
                    x = x - 1;
                }

                posicionJunta.forEach(function(pos) {

                    this.addJuntaDefectosPlanta(pos);       
                }.bind(this));
            }
        },

        Store : function(){
         
            this.errors =[];
            let gasoducto_sn = this.formato =='GASODUCTO'  ? true : false ;
            let defectos = this.formato =='PLANTA' ? this.inputsJuntasDefectosPlanta : false
            var urlRegistros = 'informes_ri' ;      
            axios({
              method: 'post',
              url : urlRegistros,    
              data : {
                
                'ot'              : this.otdata,
                'ejecutor_ensayo' : this.ejecutor_ensayo,  
                'metodo_ensayo'   : this.metodo,  
                'fecha':          this.fecha,
                'numero_inf':     this.numero_inf,
                'prefijo'        :this.prefijo,
                'gasoducto_sn' :  gasoducto_sn,               
                'componente' :    this.componente,
                'plano_isom' :    this.plano_isom,
                'procedimiento' : this.procedimiento,           
                'observaciones':  this.observaciones,
                'material':       this.material,
                'diametro':       this.diametro.diametro,
                'espesor':        this.espesor.espesor,
                'espesor_chapa' :  this.espesor_chapa, 
                'equipo'        :  this.equipo,
                'kv'            : this.kv,
                'ma'            : this.ma,
                'fuente'       :  this.fuente ,
                'foco':           this.foco,
                'tipo_pelicula' : this.tipo_pelicula,
                'pantalla':       this.pantalla,
                'pos_ant':        this.pos_ant,
                'pos_pos':       this.pos_pos,
                'lado':          this.lado,
                'distancia_fuente_pelicula': this.distancia_fuente_pelicula,
                'procedimiento_soldadura': this.procedimiento_soldadura,
                'norma_evaluacion': this.norma_evaluacion,
                'ici': this.ici,
                'norma_ensayo': this.norma_ensayo,
                'tecnica':this.tecnica,
                'tecnicas_grafico' : this.tecnica_grafico,
                'eps':this.eps,
                'pqr':this.pqr,
                'actividad' : this.actividad,
                'exposicion': this.exposicion,   
                'detalles'  : defectos,           
          }}
          
      
        ).then(response => {
          this.response = response.data
          toastr.success('informe N°' + this.numero_inf + ' fue creado con éxito ');
          console.log(response);
        }).catch(error => {
               
               this.errors = error.response.data.errors;
                console.log(error.response);
                console.log('hola'); 
               $.each( this.errors, function( key, value ) {
                   toastr.error(value);
                   console.log( key + ": " + value );
               });

           });    

        },
        Update : function() {

            console.log('entro en el edit');

        }



    }


    
}
</script>

<style scoped>
.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
     background-color: #eee;
}
.checkbox-inline {
    margin-left: 0px;
}

</style>
