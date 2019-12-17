<template>
   <div class="row">
       <div class="col-md-12">
           <form @submit.prevent="editmode ?  Update() : Store()"  method="post">
               <informe-header :otdata="otdata"></informe-header>
               <div class="box box-danger">
                  <div class="box-body">
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="formato">Tipo informe RI (*)</label>
                                <v-select v-model="formato" :options="['PLANTA', 'GASODUCTO']"></v-select>
                            </div>                            
                        </div>
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
                                <div v-if="isGasoducto">
                                    <label for="prefijo">Prefijo (*)</label> 
                                </div>
                                <div v-else>
                                     <label for="prefijo">Prefijo</label> 
                                </div>
                                <input type="text" v-model="prefijo" class="form-control" id="prefijo" :disabled="!isGasoducto">
                            </div>                            
                        </div>
                         <div class="col-md-3">
                            <div class="form-group" >
                                <label for="numero_inf">Informe N°</label>
                                <input type="text" v-model="numero_inf_code" class="form-control" id="numero_inf" disabled>
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
                               <div v-if="isChapa">
                                    <label for="espesor">Espesor</label> 
                                </div>
                                <div v-else>
                                     <label for="espesor">Espesor (*)</label> 
                                </div>                             
                                <v-select v-model="espesor" label="espesor" :options="espesores" :disabled="isChapa">
                                    <template slot="option" slot-scope="option">
                                        <span class="upSelect">{{ option.espesor }} </span> <br> 
                                        <span class="downSelect"> {{ option.cuadrante }} </span>
                                    </template>
                                </v-select>   
                            </div>                            
                        </div>
                      
                        <div class="col-md-1 size-1-5">    
                             <div class="form-group" >   
                                <div v-if="isChapa">
                                    <label for="espesor_chapa">Espesor Chapa (*)</label> 
                                </div>
                                <div v-else>
                                     <label for="espesor_chapa">Espesor Chapa (*)</label> 
                                </div>                        
                            
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

                        <div class="col-md-3">                       
                            <div class="form-group">
                                <label>Técnica (*)</label>
                                    
                                <v-select v-model="tecnica" label="codigo_grafico_id" :options="tecnicas" @input="ActualizarDistFuentePelicula()">  
                                    <template slot="option" slot-scope="option">
                                        <img :src="option.path" width="80" height="73" />  
                                        <span style="margin-left: 5px"> {{option.descripcion}} </span>                                     
                                    </template> 
                                </v-select>
                            </div>      
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Equipo (*)</label>
                                    <v-select  v-model="interno_equipo" :options="interno_equipos_activos" label="nro_interno" @input="getFuente()">
                                        <template slot="option" slot-scope="option">
                                            <span class="upSelect">{{ option.nro_interno }}</span> <br> 
                                            <span class="downSelect"> {{ option.equipo.codigo }} </span>
                                        </template>
                                    </v-select>
                            </div>
                        </div>
                       
                        <div class="col-md-1">
                            <div class="form-group" >                   
                                <label for="kv">Kv</label>
                                <input  type="text" class="form-control" v-model="kv" id="kv">     
                            </div>                         
                        </div>
                        <div class="col-md-1">
                            <div class="form-group" >                        
                                <label for="ma">mA</label>
                                <input  type="text" class="form-control" v-model="ma" id="ma"> 
                            </div>                             
                        </div>                       
                      
                        <div class="col-md-2">
                            <div class="form-group" >
                                <label for="fuente">Fuente</label>
                                 <input type="text" v-model="fuente.codigo" class="form-control" id="fuente" disabled>
                            </div>                            
                        </div>

                        <div class="col-md-1 size-1-5">
                            <div class="form-group" >
                                <label for="foco">Foco (*)</label>
                                <input type="text" v-model="foco" class="form-control" id="foco">
                            </div>                            
                        </div>

                        <div class="col-md-1 size-1-5">
                            <div class="form-group">
                                <label>Calidad de placas (*)</label>
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
                                <label for="procRadio">Procedimiento RI (*)</label>
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
                                <label for="pos_ant">Ant (*)</label>
                                <input type="number" v-model="pos_ant" class="form-control" id="pos_ant" step=".01">
                            </div>                            
                        </div>
                        <div class="col-md-1">
                            <div class="form-group" >
                                <label for="pos_pos">Pos (*)</label>
                                <input type="number" v-model="pos_pos" class="form-control" id="pos_pos" step=".01">
                            </div>                            
                        </div>

                        <div class="col-md-2">
                            <div class="form-group" >
                                <label for="ici">Ici (*)</label>
                                <v-select v-model="ici" label="codigo" :options="icis"></v-select>   
                            </div>                            
                        </div>    

                        <div class="col-md-1">
                            <div class="form-group" >
                                <label for="pos_pos">lado (*)</label>
                                <input type="text" v-model="lado" class="form-control" id="lado">
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
                            <div class="form-group" >
                                <label for="actividad">Actividad</label>
                                <input type="text" v-model="actividad" class="form-control" id="actividad" disabled>
                            </div>         
                        </div>       
                        <div class="col-md-3">                       
                            <div class="form-group" >
                                <label for="exposicion">N° Exposiciones (*)</label>
                                <input type="number" v-model="exposicion" class="form-control" id="exposicion">
                            </div>         
                        </div>                                            
                    
                        
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="distancia_fuente_pelicula">Dist. Fuente (*)</label>
                                <input type="text" v-model="distancia_fuente_pelicula" class="form-control" :disabled="!isChapa" id="distancia_fuente_pelicula">
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

               <!-- Detalle RI -->
               <div class="box box-danger">
                     <div class="box-header with-border">
                        <h3 class="box-title">JUNTAS/POSICIONES</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>                       
                        </div>
                    </div>
                <div class="box-body">

                    <div class="col-md-1">                       
                        <div class="form-group" >                            
                            <label for="pk">Pk</label>
                            <input type="number" v-model="pk" class="form-control" id="pk" :disabled="(!isGasoducto)">                           
                        </div>     
                    </div>   

                    <div class="col-md-1">                      
                        <div class="form-group" >
                           <label>Tipo Sol.</label>
                           <v-select v-model="tipo_soldadura" label="codigo" :options="tipo_soldaduras" :disabled="(!isGasoducto)"></v-select>
                        </div>
                    </div>                   
                  
                    <div class="col-md-2">                      
                        <div class="form-group" >
                            <label for="junta">Junta</label>
                            <input type="text" v-model="junta" class="form-control" id="junta">
                        </div>
                    </div>     
                  


                    <div class="col-md-1">                       
                        <div class="form-group" >                            
                        <label for="posicion">Posición</label>
                        <input type="text" v-model="posicion" class="form-control" id="posicion">                           
                        </div>     
                    </div>   

                    <div class="col-md-2">                       
                             <p>&nbsp;</p>                                        
                             <i title="Agregar Junta/Posición" @click="AddDetalle()" style="display:inline-block;margin-left:15px;"> <app-icon img="plus-circle" color="black"></app-icon> </i>                
                         
                             <i title="Clonar Posición" @click="ClonarPosPlanta()" style="display:inline-block;margin-left:15px;"> <app-icon img="clone" color="black"></app-icon> </i>                      
                          
                             <i title="Limpiar Todo" @click="resetDetalle()" style="display:inline-block;margin-left:15px;"> <app-icon img="trash" color="black"></app-icon> </i>                                             
                   
                    </div>         
                    
                    <div class="col-md-12">

                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th style="width:30px;">Pk</th>
                                        <th style="width:80px;">TIPO SOL.</th>                                     
                                        <th style="width:90px;">JUNTA</th>                                       
                                        <th style="width:90px;">POS</th>  
                                        <th style="width:80px;">ACEPTABLE</th>    
                                        <th style="width:300px;">OBSERVACIÓN</th>        
                                                                       
                                        <th colspan="1" style="width:30px;">&nbsp;</th>
                                    </tr>
                                </thead>                         
                                <tbody>
                                    <tr v-for="(FIlaTabla,k) in (TablaDetalle)" :key="k" @click="selectPosDetalle(k)" :class="{selected: indexDetalle === k}">
                                        <td>{{ FIlaTabla.pk }}</td>
                                        <td>{{ FIlaTabla.tipo_soldadura.codigo }}</td>                                 
                                        <td>{{ FIlaTabla.junta }}</td>                                      
                                        <td>{{ FIlaTabla.posicion }} </td>   
                                        <td> <input type="checkbox" id="checkbox" v-model="TablaDetalle[k].aceptable_sn">  </td>                                 
                                        <td>
                                            <div v-if="indexDetalle == k ">       
                                              <input type="text" v-model="TablaDetalle[k].observacion" maxlength="50" size="60">        
                                            </div>   
                                            <div v-else>
                                               {{ TablaDetalle[k].observacion }}
                                            </div>                                   
                                        </td>

                                      
                                        <td> <a  @click="RemoveDetalle(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a> 
                                        </td>          

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                       </div>
                    </div>
                   </div>

                   <!-- DEFECTOS RI -->

                    <div class="box box-danger">
                        
                        <div class="box-header with-border">
                            <h5 class="box-title">DEFECTOS</h5>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>                       
                            </div>
                        </div>
                       
                      <div class="box-body"> 
                                                   
                        <div class="col-md-3">                          
                           <div class="form-group" >
                                <label>Defectos</label>           
                                <v-select v-model="defectoRiPlanta" :options="defectosRiPlanta" label="descripcion" :disabled="(!TablaDetalle.length)">
                                    <template slot="option" slot-scope="option">
                                        <span class="upSelect">{{ option.descripcion }} </span> <br> 
                                        <span class="downSelect">{{ option.codigo }} </span>
                                    </template>
                                </v-select>                
                            </div>   
                        </div> 
                        <div class="col-md-2">                       
                            <div class="form-group" >                            
                                <label for="posicionPlaca">Posición Defecto</label>
                                <input type="text" v-model="posicionPlacaGosaducto" class="form-control" id="posicionPlacaGosaducto" :disabled="(!TablaDetalle.length)" maxlength="10">                           
                            </div>     
                        </div>    
                          
                        <div class="col-md-1"> 
                            <div class="form-group">  
                                 <p>&nbsp;</p>                  
                                <span>
                                  <a title="Agregar Defecto" @click="addDefectos()"> <app-icon img="plus-circle" color="black"></app-icon> </a>                        
                                </span>
                            </div>
                        </div>  
                                          
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:90px;">CÓDIGO</th>                                                                                  
                                            <th style="width:250px;">DESCRIPCIÓN</th>
                                            <th style="width:90px;">POSICIÓN</th>                                                                 
                                            <th style="width:30px;" colspan="2">&nbsp;</th>
                                        </tr>
                                    </thead>                         
                                    <tbody>
                                        <tr v-for="(defectoPasada,k) in 
                                         ( (TablaDetalle.length > 0 )  ? TablaDetalle[indexDetalle].defectos : [])"  :key="k">
                                            <td>{{ defectoPasada.codigo }}</td>    
                                            <td>{{ defectoPasada.descripcion }}</td>   
                                            <td>{{ defectoPasada.posicion }}</td>              
                                        
                                            <td>
                                                <a  @click="RemoveDefectos(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a> 
                                            </td> 
                                        </tr>
                                    </tbody>
                                 </table>
                                </div>
                           </div>                                

                       </div> 
                      </div>
                      

                <!-- PASADAS RI -->
               <div class="box box-danger">
                   <div class="box-header with-border">
                        <h5 class="box-title">PASADAS</h5>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>                       
                        </div>
                    </div>
                <div class="box-body">
                    <div class="col-md-1">
                        <div class="form-group" >                            
                            <label for="pasada">N° Pasada</label>
                            <input type="number" v-model="pasada" class="form-control" id="pasada" :disabled="(!isGasoducto || !TablaDetalle.length)">                           
                        </div>     
                    </div>
                    <div class="col-md-2">    
                        <div v-if="!isGasoducto">   
                            <label>Cuño 1</label>  
                        </div>  
                        <div v-else>                   
                             <label>Cuño Z</label> 
                        </div>          
                        <v-select v-model="soldador1" :options="soldadores" label="codigo" :disabled="(!TablaDetalle.length)">
                            <template slot="option" slot-scope="option">
                                <span class="upSelect">{{ option.nombre }} </span> <br> 
                                <span class="downSelect"> {{ option.codigo }} </span>
                            </template>
                        </v-select>                  
                    </div> 
                    <div v-if="isGasoducto">   
                        <div class="col-md-2">                         
                            <label>Cuño L</label>           
                            <v-select v-model="soldador2" :options="soldadores" label="codigo" :disabled="(!isGasoducto || pasada!='1' || !TablaDetalle.length)">
                                <template slot="option" slot-scope="option">
                                    <span class="upSelect">{{ option.nombre }} </span> <br> 
                                    <span class="downSelect"> {{ option.codigo }} </span>
                                </template>
                            </v-select>                    
                        </div>
                    </div>

                    <div class="col-md-2">  
                        <div v-if="!isGasoducto">   
                            <label>Cuño 2</label>  
                        </div>  
                        <div v-else>                   
                             <label>Cuño P</label> 
                        </div>                         
                               
                        <v-select v-model="soldador3" :options="soldadores" label="codigo" :disabled="(!TablaDetalle.length)">
                            <template slot="option" slot-scope="option">
                                <span class="upSelect">{{ option.nombre }} </span> <br> 
                                <span class="downSelect"> {{ option.codigo }} </span>
                            </template>
                        </v-select>                    
                    </div>  
                    
                     <div class="col-md-2"> 
                          <p>&nbsp;</p>
                          <span>                             
                             <i title="Recargar Cuños" @click="getSoldadores()" style="display:inline-block;margin-left:15px;"> <app-icon img="refresh" color="black"></app-icon> </i>
                             <i title="Agregar Pasada" @click="AddPasadas()" style="display:inline-block;margin-left:15px;"> <app-icon img="plus-circle" color="black"></app-icon> </i>
                          </span>
                    </div>
                        <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>                                  
                                                <th style="width:90px;">N° PASADA</th>                                  
                                                <th style="width:120px;">CUÑO Z</th>
                                                <th style="width:120px;">CUÑO L</th>
                                                <th style="width:120px;">CUÑO P</th>                                                             
                                                <th colspan="1" style="width:30px;">&nbsp;</th>
                                            </tr>
                                        </thead>                         
                                        <tbody>
                                            <tr v-for="(Pasada,k) in  ((TablaDetalle.length > 0) ? TablaDetalle[indexDetalle].pasadas : [])" :key="k" @click="selectPosPasada(k)" :class="{selected: indexPasada === k}">                                         
                                                <td>{{ Pasada.pasada }}</td>                                            
                                                <td>{{ Pasada.soldador1.codigo }} </td>
                                                <td>{{ Pasada.soldador2.codigo }} </td>
                                                <td>{{ Pasada.soldador3.codigo }} </td>                                          
                                                <td> 
                                                    <a  @click="RemovePasada(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a>
                                                </td>          

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
         
                <loading :active.sync="isLoading"           
                        :is-full-page="fullPage">
                </loading>  
          
       </div>
   </div>
</template>

<script>

import uniq from 'lodash/uniq';
import Datepicker from 'vuejs-datepicker';
import {mapState} from 'vuex';
import {en, es} from 'vuejs-datepicker/dist/locale'
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import moment from 'moment'

export default {

    components: {

      Datepicker,
      Loading
      
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

      informedata : {
      type : Object,
      required : false
      },

      informe_ridata : {
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

      interno_fuentedata : {
      type : [ Object, Array ],  
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

      tipo_peliculadata : {
      type : [ Object ],  
      required : false
      },

      icidata : {
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


    },

    data() {return {

        errors:[],
            en: en,
            es: es, 
            isLoading: false,
            fullPage: false,         

           // Formulario encabezado

            fecha:'',
            numero_inf:'',
            numero_inf_generado:'',
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
            interno_equipo:'',   
            interno_fuente:'',   
            kv:'',
            ma:'',
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
            tecnica_distancia:'',
           
           // Fin Formulario encabezado

           // Formulario detalle
            pk:'',
            tipo_soldadura:'',
            pasada:'',
            junta:'',
            soldador1:'',
            soldador2:'',
            soldador3:'',
            posicion:'',                      
            defectoObs:'',
            defectoRiPlanta:'',
            defectoRiGasoducto:'',
            posicionPlacaGosaducto:'',
            indexDetalle:0,
            indexPasada:0,

            //Fin Formulario detalle
           
            isRX:false,
            isChapa:false,
            isGasoducto:false,
            EnableClonarPasadas:false,
           
             equipos:[],
             fuentes:[],
             tipo_peliculas:[],
             
             icis:[],
             tecnicas:[],            
             tecnicas_graficos :[],             

             
             tipo_soldaduras:[],
             soldadores:[],
             posiciones:[],
             defectosRiPlanta:[],
             defectosRiGasoducto:[],
             TablaDetalle:[],   
             TablaPasadas:[],        
             
             junta_posicion_selected : '',
             clonando : false,
             validoPasadas : true,
             


    }},

    created : function(){       
        
        this.isLoading =  true;
        this.$store.dispatch('loadProcedimietosOtMetodo',  { 'ot_id' : this.otdata.id, 'metodo' : this.metodo });
        this.$store.dispatch('loadMateriales');
        this.$store.dispatch('loadDiametros');
        this.$store.dispatch('loadInternoEquiposActivos',this.metodo);      
        this.getTipoPeliculas();
        this.$store.dispatch('loadNormaEvaluaciones');        
        this.$store.dispatch('loadNormaEnsayos');       
        this.getIcis();
        this.getTecnicas();
        this.$store.dispatch('loadEjecutorEnsayo', this.otdata.id); 
        this.getSoldadores();
        this.getDefectosRiPlanta();
        this.getDefectosRiGasoducto();
        this.getTipoSoldaduras();     
        this.pasada = 1;  
        this.formato = 'PLANTA'
        this.setEdit();        

    },
    
    mounted : function() {

         this.getNumeroInforme();
    }, 
    
    watch : {

        equipo : function(val){

            this.isRX = (val.codigo =='RX') ? true : false;
                
        },
        
        diametro : function(val){
            if(val){

                  this.isChapa = (val.diametro =='CHAPA') ? true : false;

            }   
        },
        formato : function (val){

            this.isGasoducto =  (val == 'GASODUCTO') ? true : false;        
            

        },

        pasada : function (val){

            this.soldador2 =  (val == '1') ? this.soldador2 : '';
        },      

        fuentePorInterno: function(val){            
      
              this.fuente = val;
        
        },

       fecha : function(val) {

              if(this.interno_fuente){
                  let fecha_mysql = moment(this.fecha).format('MMMM Do YYYY, h:mm:ss a');
                  this.$store.dispatch('loadCurie',{ 'interno_fuente_id' : this.interno_fuente.id, 'fecha_final': fecha_mysql }).then(response => {

                         this.actividad = this.curie;

                   });
              }

        }
       
    },

    computed :{

        ...mapState(['url','AppUrl','materiales','diametros','espesores','procedimientos','norma_evaluaciones','norma_ensayos','ejecutor_ensayos','interno_equipos_activos','fuentePorInterno','curie']),

           HabilitarClonarPasadas(){
                this.EnableClonarPasadas = (this.isGasoducto && this.pasada=='1' && this.TablaDetalle.length);
           },   
           
           numero_inf_code : function()  {

               if(this.numero_inf)

                      return this.metodo + (this.numero_inf <10? '00' : this.numero_inf<100? '0' : '') + this.numero_inf ;
        }
       
     },

    methods : {

        setEdit : function(){

            if(this.editmode) {
               
               this.formato = this.informe_ridata.gasoducto_sn ? 'GASODUCTO' : 'PLANTA';
               this.fecha   = this.informedata.fecha;
               this.prefijo = this.informedata.prefijo;
               this.numero_inf = this.informedata.numero;
               this.componente = this.informedata.componente;
               this.material = this.materialdata;
               this.plano_isom = this.informedata.plano_isom;
               this.diametro = this.diametrodata;
               this.espesor = this.diametro_espesordata;
               this.tecnica = this.tecnicadata;
               this.interno_equipo = this.interno_equipodata;
               this.interno_fuente = this.interno_fuentedata ;                 
               this.kv = this.informe_ridata.kv;
               this.ma = this.informe_ridata.ma;
               this.fuente = this.interno_fuentedata.fuente ? this.interno_fuentedata.fuente : '' ;                    
               this.procedimiento = this.procedimientodata;
               this.ici = this.icidata;
               this.norma_evaluacion = this.norma_evaluaciondata;
               this.norma_ensayo = this.norma_ensayodata;
               this.tipo_pelicula = this.tipo_peliculadata;
               this.espesor_chapa = this.informedata.espesor_chapa;
               this.procedimiento_soldadura = this.informedata.procedimiento_soldadura;
               this.eps = this.informedata.eps;
               this.pqr = this.informedata.pqr;        
               this.foco = this.informe_ridata.foco;
               this.pos_ant = this.informe_ridata.pos_ant;
               this.pos_pos = this.informe_ridata.pos_pos;
               this.lado = this.informe_ridata.lado;            
               this.exposicion = this.informe_ridata.exposicion;
               this.distancia_fuente_pelicula = this.informe_ridata.distancia_fuente_pelicula;
               this.ejecutor_ensayo = this.ejecutor_ensayodata;          
               this.TablaDetalle = this.detalledata,  
               this.observaciones = this.informedata.observaciones 

               console.log('este es el interno fuente:' + this.interno_fuentedata + 'este es el final');
               if (this.interno_fuentedata.id != undefined){

                   this.$store.dispatch('loadCurie', { 'interno_fuente_id' : this.interno_fuentedata.id, 'fecha_final': this.informedata.fecha }).then(response => {
    
                         this.actividad = this.curie;
    
                   }); 
               }        

            }

        },       

        getNumeroInforme:function(){            
           
            if(!this.editmode) {
           

                    axios.defaults.baseURL = this.url ;
                        var urlRegistros = 'informes/ot/' + this.otdata.id + '/metodo/' + this.metodo + '/generar-numero-informe'  + '?api_token=' + Laravel.user.api_token;         
                        axios.get(urlRegistros).then(response =>{
                        this.numero_inf_generado = response.data 
                        
                        console.log(this.numero_inf_generado.length);
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
            this.distancia_fuente_pelicula='';   
            this.tecnica ='';      
            if(this.diametro){    
               this.$store.dispatch('loadEspesores',this.diametro.diametro_code);
             }
        },
        

        getFuente : function(){
            
            if(this.interno_equipo.interno_fuente){

               this.interno_fuente = this.interno_equipo.interno_fuente;

               this.$store.dispatch('loadFuentePorInterno',this.interno_equipo.interno_fuente.id).then(response => {

                   this.fuente = this.fuentePorInterno;
                
               });      

                if(this.fuentePorInterno) {
                    this.$store.dispatch('loadCurie',{ 'interno_fuente_id' : this.interno_equipo.interno_fuente.id, 'fecha_final': this.informedata.fecha }).then(response => {
        
                        this.actividad = this.curie;
                    
                    });
                }

               
            }else{

                this.interno_fuente = {} ;
                this.actividad = '';
            }


            this.resetInputsEquipos();

        },   
        
        resetInputsEquipos : function() {
               
                this.kv = this.interno_equipo.voltaje;
                this.ma = this.interno_equipo.amperaje;

        },

        getTipoPeliculas : function(){

            axios.defaults.baseURL = this.url ;
                var urlRegistros = 'tipo_peliculas' + '?api_token=' + Laravel.user.api_token;         
                axios.get(urlRegistros).then(response =>{
                this.tipo_peliculas = response.data
               
                });         
        },       

        getIcis: function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'icis' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.icis = response.data
                });
              },       

        getTecnicas: function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'tecnicas/metodo/'+ this.metodo + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.tecnicas = response.data
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

        ActualizarDistFuentePelicula : function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'tecnica_distancias/'+ this.tecnica.id +'/diametro/'+ this.diametro.diametro_code + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.tecnica_distancia = response.data
                this.distancia_fuente_pelicula=this.tecnica_distancia[0].distancia_fuente_peliculas;
               });  

        },


        getEjecutorEnsayo: function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'ot-operarios/ot/' + this.otdata.id + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.ejecutor_ensayos = response.data
                });
              },

        

        resetDetalle : function(){

            this.TablaDetalle = [];
            this.pk = '';
            this.tipo_soldadura='';
            this.pasada='';
            this.junta='';
            this.soldador1='',
            this.soldador2='',
            this.soldador3='',
            this.posicion='',    
            this.posicionPlacaGosaducto=''

        },

        //detalle
        getTipoSoldaduras : function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'tipo_soldaduras' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.tipo_soldaduras = response.data
                this.isLoading =  false;

                });           
             
        },

        getSoldadores : function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'ot_soldadores/ot/' + this.otdata.id + '?api_token=' + Laravel.user.api_token;        
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

        selectPosDetalle :function(index){

            this.indexDetalle = index ;
            this.pasada =1 ;
           
        },

        selectPosPasada :function(index){

            this.indexPasada = index ;
           
        },

        AddDetalle (posicion) { 
            
            if(this.junta == '' ){

                 toastr.error('Campo junta es obligatorio'); 
                 return;
            }else if(this.posicion == '' && this.clonando == false) {

                 toastr.error('Campo posición es obligatorio'); 
                  return;
            }          

            this.TablaDetalle.push({ 
                pk : this.pk,
                tipo_soldadura:this.tipo_soldadura,             
                junta: this.junta,           
                posicion : (typeof(posicion) !== 'undefined') ? posicion : this.posicion, 
                aceptable_sn : 1 ,
                observacion : '',
                pasadas : [],
                defectos : []  
            });   

           
        },

        AddPasadas () {   
            
            if(this.formato == 'PLANTA'){

                if(this.TablaDetalle[this.indexDetalle].pasadas.length == 1) {
                    toastr.error('Error : Formato PLANTA  acepta 1 pasada');       
                    return;
                }


            }

            if(this.formato == 'GASODUCTO'){

                if(this.TablaDetalle[this.indexDetalle].pasadas.length == 6) {
                    toastr.error('Error : Formato GASODUCTO acepta 6 pasadas');       
                     return;
                }


            }
            
            if(this.soldador1) {

                    this.TablaDetalle[this.indexDetalle].pasadas.push({ 
                        pasada : this.pasada,
                        soldador1: this.soldador1,
                        soldador2: this.soldador2,     
                        soldador3: this.soldador3,                

                    });  
                    
                    if (this.isGasoducto){
                        if (this.pasada < 6)
                            this.pasada++;
                        else if(this.pasada == 6)
                        this.pasada = 1;
                    }

            }
            else{

                toastr.error('Campo Cunio Z es obligatorio'); 

            } 
        },

        addDefectos () {      
            
            if(this.defectoRiPlanta == '' ){

                 toastr.error('Campo defecto es obligatorio'); 
                 return;
            }
    
            this.TablaDetalle[this.indexDetalle].defectos.push({ 
                codigo: this.defectoRiPlanta.codigo,
                descripcion: this.defectoRiPlanta.descripcion,
                id : this.defectoRiPlanta.id,    
                posicion : this.posicionPlacaGosaducto,                
                    });   
                    
            if(this.posicionPlacaGosaducto != ''){

                console.log('el defecto tiene posicion placa');
                this.TablaDetalle[this.indexDetalle].aceptable_sn = false;
            }
            
            },
        RemoveDetalle(index) {
           this.indexDetalle = 0;   
           this.TablaDetalle.splice(index, 1);               
            
        },

        RemovePasada(index) {
            this.indexPasada = 0;   
            this.TablaDetalle[this.indexDetalle].pasadas.splice(index, 1);     
            
        },

        RemoveDefectos(index) {            
            
            console.log('----entro en removeDefectos----');
            this.TablaDetalle[this.indexDetalle].defectos.splice(index, 1);   

            let aceptable = true;

            this.TablaDetalle[this.indexDetalle].defectos.forEach(function(defecto){

                if(defecto.posicion !=''){
                    console.log('defecto:' + defecto.descripcion + '  posicion:' + defecto.posicion );
                    aceptable = false;
                   
                }

            })

            this.TablaDetalle[this.indexDetalle].aceptable_sn = aceptable;
                
        },

        insertarClonacion : function (posicion){

           this.AddDetalle(posicion);
        },

        ClonarPosPlanta : function(){

            this.clonando = true;

            if(this.TablaDetalle.length > 0){

                let TablaDetalleReverse =  JSON.parse(JSON.stringify(this.TablaDetalle));         
                let x = TablaDetalleReverse.length-1;
                let juntaAux = TablaDetalleReverse[x].junta;
                let posicionJunta =[];          
                while (  (x >= 0)  && (juntaAux == TablaDetalleReverse[x].junta)) {     

                    posicionJunta.unshift(TablaDetalleReverse[x].posicion);                    
                    x = x - 1;
                }

                posicionJunta.forEach(function(pos) {

                this.AddDetalle(pos);       

                }.bind(this));
            }

            this.clonando = false;
        },

        validarPasadas : function() {

            this.TablaDetalle.forEach(function(item){

                if(item['pasadas'].length == 0){

                    this.validoPasadas = false;
                    return;
                }

            }.bind(this))
        },

        Store : function(){
            
          
            this.validarPasadas();         
            if (this.validoPasadas){

                    this.errors =[];
                    let gasoducto_sn ;

                    if(this.formato =='GASODUCTO')
                        gasoducto_sn = true;
                    else if(this.formato =='PLANTA')
                        gasoducto_sn = false;
                    else
                        gasoducto_sn= null;
                
                    let defectos = this.formato =='PLANTA' ? this.TablaDetalle : false
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
                        'diametro':       this.diametro,
                        'espesor':        this.espesor,
                        'espesor_chapa' :  this.espesor_chapa, 
                        'interno_equipo'   :  this.interno_equipo,  
                        'kv'               :this.kv,
                        'ma'               :this.ma,   
                        'interno_fuente' :this.interno_fuente,                           
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
                        'exposicion': this.exposicion,   
                        'detalles'  : this.TablaDetalle,           
                }}
                
            
                ).then(response => {
                this.response = response.data
                toastr.success('informe N°' + this.numero_inf + ' fue creado con éxito ');
                console.log(response);
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
           }else {

                toastr.error("Error: Pasadas sin completar");    
                this.validoPasadas = true;
           }
        },
        Update : function() {    

            this.validarPasadas();
            if (this.validoPasadas){

                    console.log('entro para actualizar' );
                    this.errors =[];
                    let gasoducto_sn ;
                    if(this.formato =='GASODUCTO')
                        gasoducto_sn = true;
                    else if(this.formato =='PLANTA')
                        gasoducto_sn = false;
                    else
                        gasoducto_sn= null;
                    let defectos = this.formato =='PLANTA' ? this.TablaDetalle : false
                    var urlRegistros = 'informes_ri/' + this.informedata.id  ;      
                    axios({
                    method: 'put',
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
                        'diametro':       this.diametro,
                        'espesor':        this.espesor,
                        'espesor_chapa'    :this.espesor_chapa, 
                        'interno_equipo'   :this.interno_equipo,   
                        'kv'               :this.kv,
                        'ma'               :this.ma,   
                        'interno_fuente' :this.interno_fuente,            
                        'foco'              :this.foco,
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
                        'exposicion': this.exposicion,   
                        'detalles'  : this.TablaDetalle,           
                }}
                
            
                ).then(response => {
                this.response = response.data
                toastr.success('informe N°' + this.numero_inf + ' fue actualizado con éxito ');
                console.log(response);
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
        } else {

                toastr.error("Error: Pasadas sin completar");    
                this.validoPasadas = true;

           }
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
.col-md-1-5 {

    width: 12.499999995%
   
}

table .selected{

  background-color: rgb(243, 200, 126)!important;

} 

@media (min-width: 768px)  { 
    
.size-1-5 {

    width: 12.499999995%;
}

.box-title {

    font-size: 15px;
    font-style: italic;
    font-weight: bold;
    color : #6E6A6A;
}

}
</style>
