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
                                <v-select v-model="espesor" label="espesor" :options="espesores" :disabled="isChapa"></v-select>   
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
                                <label for="equipos">Equipo (*)</label>
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
                                <label for="eps">Actividad</label>
                                <input type="text" v-model="actividad" class="form-control" id="actividad">
                            </div>         
                        </div>       
                        <div class="col-md-3">                       
                            <div class="form-group" >
                                <label for="eps">N° Exposiciones (*)</label>
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
                                <input type="text" v-model="posicionPlacaGosaducto" class="form-control" id="posicionPlacaGosaducto" :disabled="(!TablaDetalle.length)">                           
                            </div>     
                        </div>    
                          
                        <div class="col-md-1"> 
                            <div class="form-group">  
                                 <p>&nbsp;</p>                  
                                <span>
                                  <a  @click="addDefectos()"> <app-icon img="plus-circle" color="black"></app-icon> </a>                        
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
                        <label>Cunio Z</label>           
                        <v-select v-model="soldador1" :options="soldadores" label="nombre" :disabled="(!TablaDetalle.length)">
                            <template slot="option" slot-scope="option">
                                <span class="upSelect">{{ option.nombre }} </span> <br> 
                                <span class="downSelect">   {{ option.codigo }} </span>
                            </template>
                        </v-select>                  
                    </div> 
                    <div class="col-md-2">                         
                        <label>Cunio L</label>           
                        <v-select v-model="soldador2" :options="soldadores" label="nombre" :disabled="(!isGasoducto || pasada!='1' || !TablaDetalle.length)">
                            <template slot="option" slot-scope="option">
                                <span class="upSelect">{{ option.nombre }} </span> <br> 
                                <span class="downSelect">   {{ option.codigo }} </span>
                            </template>
                        </v-select>                    
                    </div>

                    <div class="col-md-2">                         
                        <label>Cunio P</label>           
                        <v-select v-model="soldador3" :options="soldadores" label="nombre" :disabled="(!TablaDetalle.length)">
                            <template slot="option" slot-scope="option">
                                <span class="upSelect">{{ option.nombre }} </span> <br> 
                                <span class="downSelect">   {{ option.codigo }} </span>
                            </template>
                        </v-select>                    
                    </div>  
                     <div class="col-md-1"> 
                          <p>&nbsp;</p>
                          <span>                             
                             <a  @click="AddPasadas()"> <app-icon img="plus-circle" color="black"></app-icon> </a>
                          </span>
                       
                    </div>
                        <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr>                                  
                                                <th style="width:90px;">N° PASADA</th>                                  
                                                <th style="width:120px;">CUNIO Z</th>
                                                <th style="width:120px;">CUNIO L</th>
                                                <th style="width:120px;">CUNIO P</th>                                                             
                                                <th colspan="1" style="width:30px;">&nbsp;</th>
                                            </tr>
                                        </thead>                         
                                        <tbody>
                                            <tr v-for="(Pasada,k) in  ((TablaDetalle.length > 0) ? TablaDetalle[indexDetalle].pasadas : [])" :key="k" @click="selectPosPasada(k)" :class="{selected: indexPasada === k}">                                         
                                                <td>{{ Pasada.pasada }}</td>                                            
                                                <td>{{ Pasada.soldador1.nombre }} </td>
                                                <td>{{ Pasada.soldador2.nombre }} </td>
                                                <td>{{ Pasada.soldador3.nombre }} </td>                                          
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

      fuentedata : {
      type : [ Object, Array ],  
      required : false
      },

      tecnicadata : {
      type : [ Object ],  
      required : false
      },

      equipodata : {
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

            this.isChapa = (val.diametro =='CHAPA') ? true : false;
                
        },
        formato : function (val){

            this.isGasoducto =  (val == 'GASODUCTO') ? true : false;        
            

        },

        pasada : function (val){

            this.soldador2 =  (val == '1') ? this.soldador2 : '';
        },
    },

    computed :{

        ...mapState(['url','AppUrl']),

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
               this.equipo = this.equipodata;
               this.fuente = this.fuentedata ? this.fuentedata :'';
               this.procedimiento = this.procedimientodata;
               this.ici = this.icidata;
               this.norma_evaluacion = this.norma_evaluaciondata;
               this.norma_ensayo = this.norma_ensayodata;
               this.tipo_pelicula = this.tipo_peliculadata;
               this.espesor_chapa = this.informedata.espesor_chapa;
               this.procedimiento_soldadura = this.informedata.procedimiento_soldadura;
               this.eps = this.informedata.eps;
               this.pqr = this.informedata.pqr;
               this.kv = this.informedata.kv;
               this.ma = this.informedata.ma;
               this.foco = this.informe_ridata.foco;
               this.pos_ant = this.informe_ridata.pos_ant;
               this.pos_pos = this.informe_ridata.pos_pos;
               this.lado = this.informe_ridata.lado;
               this.actividad = this.informe_ridata.actividad;
               this.exposicion = this.informe_ridata.exposicion;
               this.distancia_fuente_pelicula = this.informe_ridata.distancia_fuente_pelicula;
               this.ejecutor_ensayo = this.ejecutor_ensayodata;          
               this.TablaDetalle = this.detalledata,  
               this.observaciones = this.informedata.observaciones 


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
                var urlRegistros = 'tecnicas/metodo/'+ this.metodo + '?api_token=' + Laravel.user.api_token;        
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
                });           
             
        },

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

        selectPosDetalle :function(index){

            this.indexDetalle = index ;
           
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
    
            this.TablaDetalle[this.indexDetalle].defectos.push({ 
                codigo: this.defectoRiPlanta.codigo,
                descripcion: this.defectoRiPlanta.descripcion,
                id : this.defectoRiPlanta.id,    
                posicion : this.posicionPlacaGosaducto,                
                    });                  
            
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
            this.TablaDetalle[this.indexDetalle].defectos.splice(index, 1);            
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
            
            this.$nextTick(function () {
                 this.validarPasadas();
            })
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
                        'diametro':       this.diametro.diametro,
                        'espesor':        this.espesor.espesor,
                        'espesor_chapa' :  this.espesor_chapa, 
                        'equipo'        :  this.equipo,
                        'kv'            : this.kv,
                        'ma'            : this.ma,
                        'fuente'       :  this.fuente ? this.fuente : null,
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
                        'diametro':       this.diametro.diametro,
                        'espesor':        this.espesor.espesor,
                        'espesor_chapa' :  this.espesor_chapa, 
                        'equipo'        :  this.equipo,
                        'kv'            : this.kv,
                        'ma'            : this.ma,
                        'fuente'       :  this.fuente ? this.fuente : null,
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
