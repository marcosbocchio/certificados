<template>
    <div class="row">
       <div class="col-md-12">
           <form @submit.prevent="editmode ? Update() : Store()"  method="post">
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
                            <input type="text" v-model="componente" class="form-control" id="componente">
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
                                <label for="material2">Material accesorio</label>
                            <v-select v-model="material2" label="codigo" :options="materiales" id="material2"></v-select>   
                        </div>      
                    </div>                     

                    <div class="col-md-3">
                        <div class="form-group" >
                            <label for="plano_isom">Plano / Isom *</label>
                            <input type="text" v-model="plano_isom" class="form-control" id="plano_isom">
                        </div>                            
                    </div>

                    <div class="col-md-3">
                            <div class="form-group" >
                                <label for="Diametro">Ø *</label>
                                <v-select v-model="diametro" label="diametro" :options="diametros" @input="getEspesores()"></v-select>   
                            </div>                            
                        </div>                       

                    <div v-if="isVarios">
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label>Espesor</label>
                                <input  type="text" class="form-control" id="espesor_varios" value="VARIOS" >   
                            </div>                            
                        </div>
                    </div>  
                    <div v-else>
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label>Espesor</label>
                                <v-select v-model="espesor" label="espesor" :options="espesores" :disabled="isChapa || isVarios">
                                     <template slot="option" slot-scope="option">
                                        <span class="upSelect">{{ option.espesor }} </span> <br> 
                                        <span class="downSelect"> {{ option.cuadrante }} </span>
                                     </template>    
                                </v-select>   
                            </div>                            
                        </div>
                    </div>  

                    <div class="clearfix"></div>    

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
                        <div class="form-group" >
                            <label for="procedimientos_soldadura">Proc. Soldadura (EPS)</label>
                            <v-select v-model="ot_tipo_soldadura" label="eps" :options="ot_obra_tipo_soldaduras" id="procedimientos_soldadura"></v-select>  
                        </div>                            
                    </div>

                    <div class="col-md-3">                       
                        <div class="form-group" >
                            <label for="pqr">PQR</label>
                            <v-select v-model="ot_tipo_soldadura" label="pqr" :options="ot_obra_tipo_soldaduras" id="pqr"></v-select>  
                        </div>         
                    </div>

                    <div class="col-md-3" >                       
                        <div class="form-group">
                            <label for="tecnicas">Tecnica *</label>
                            <v-select v-model="tecnica" label="descripcion" :options="tecnicas" id="tecnicas" @input="borrarTodasLasCalibraciones"></v-select>   
                        </div>      
                    </div>

                    <div class="clearfix"></div>    

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
                        <div class="form-group">
                            <label for="procRadio">Procedimiento US *</label>
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
                            <label>Estado Superficie *</label>
                            <v-select v-model="estado_superficie" label="codigo" :options="estados_superficies"></v-select>   
                        </div>      
                    </div>

                    <div class="col-md-3">                       
                        <div class="form-group" >
                            <label for="encoder">Encoder *</label>
                            <input type="text" v-model="encoder" class="form-control" id="encoder">
                        </div>         
                    </div>

                    <div class="col-md-3">                       
                        <div class="form-group" >
                            <label for="agente_acoplamiento">Agente Acoplamiento *</label>
                            <input type="text" v-model="agente_acoplamiento" class="form-control" id="agente_acoplamiento">
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
               <div v-show="tecnica">

                   <div class="box box-custom-enod">
                       <div class="box-body">
                            <div class="box-header with-border">
                                <h3 class="box-title">CALIBRACIONES</h3>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>                       
                                </div>
                            </div>
                            <div>&nbsp;</div>
    
                            <div v-show="tecnica.codigo !='ME'" class="col-md-3">                       
                                <div class="form-group" >
                                    <label for="zapata" title="Zapata">Zapata *</label>
                                    <input type="text" v-model="zapata" class="form-control" id="zapata">
                                </div>         
                            </div>
    
                            <div class="col-md-3" >                       
                                <div class="form-group">
                                    <label for="palpador" title="Palpador">Palpador *</label>
                                    <v-select v-model="palpador" label="codigo" :options="palpadores" id="palpador"></v-select>   
                                </div>      
                            </div>  
    
                            <div class="col-md-3">                       
                                <div class="form-group" >
                                    <label for="frecuencia" title="Frecuencia (Mhz)">Frecuencia (Mhz) *</label>
                                    <input type="number" v-model="frecuencia" class="form-control" id="frecuencia">
                                </div>         
                            </div>
    
                            <div class="col-md-3">                       
                                <div class="form-group" >
                                    <label for="angulo_apertura" title="Ángulo Apertura">Angulo Apertura *</label>
                                    <input type="text" v-model="angulo_apertura" class="form-control" id="angulo_apertura">
                                </div>         
                            </div>
    
                            <div class="col-md-3">                       
                                <div class="form-group" >
                                    <label for="rango">Rango *</label>
                                    <input type="text" v-model="rango" class="form-control" id="rango">
                                </div>         
                            </div>
    
                            <div class="col-md-3">                       
                                <div class="form-group" >
                                    <label for="posicion" title="Posición">Posición *</label>
                                    <input type="text" v-model="posicion" class="form-control" id="posicion">
                                </div>         
                            </div>
    
                            <div v-show="tecnica.codigo !='ME'" class="col-md-3">                       
                                <div class="form-group" >
                                    <label for="curva_elevacion" title="Curva Elevación">Curva Elevación *</label>
                                     <v-select v-model="curva_elevacion" :options="['DAC', 'TCG']"></v-select>
                                </div>         
                            </div>
    
                            <div class="col-md-3">                       
                                <div class="form-group" >
                                    <label for="block_calibracion" title="Block Calibración">Block Calibración *</label>
                                     <v-select v-model="block_calibracion" :options="block_calibraciones"></v-select>
                                </div>         
                            </div>

                            <div v-show="tecnica.codigo !='ME'">   
                                <div class="clearfix"></div>  
                             </div> 

                            <div v-show="tecnica.codigo !='ME'" class="col-md-3">                       
                                <div class="form-group" >
                                    <label for="block_sensibilidad" title="Block Sensibilidad">Block Sensibilidad *</label>
                                    <input type="number" v-model="block_sensibilidad" class="form-control" id="block_sensibilidad">
                                </div>         
                            </div>                     
    
                            <div v-show="tecnica.codigo !='ME'" class="col-md-3">                       
                                <div class="form-group" >
                                    <label for="tipo_reflector" title="Tipo Reflector">Tipo Reflector *</label>
                                     <v-select v-model="tipo_reflector" :options="['Ø', 'Ħ']"></v-select>
                                </div>         
                            </div>

                            <div v-show="tecnica.codigo =='ME'">   
                                <div class="clearfix"></div>  
                            </div> 
    
                            <div v-show="tecnica.codigo !='ME'" class="col-md-3">                       
                                <div class="form-group" >
                                    <label for="reflector_referencia" title="Reflector Referencia (mm)">Reflector Referencia (mm) *</label>
                                    <input type="number" v-model="reflector_referencia" class="form-control" id="reflector_referencia" step="0.1">
                                </div>         
                            </div>
    
                            <div v-show="tecnica.codigo !='ME'" class="col-md-3">                       
                                <div class="form-group" >
                                    <label for="ganancia_referencia" title="Ganancia Referencia (dB)">Ganancia Referencia (dB) *</label>
                                    <input type="number" v-model="ganancia_referencia" class="form-control" id="ganancia_referencia">
                                </div>         
                            </div>
    
                            <div v-show="tecnica.codigo !='ME'" class="col-md-3">                       
                                <div class="form-group" >
                                    <label for="nivel_registro" title="Nivel Registro">Nivel Registro *</label>
                                    <input type="number" v-model="nivel_registro" class="form-control" id="nivel_registro">
                                </div>         
                            </div>
    
                            <div v-show="tecnica.codigo !='ME'" class="col-md-3">                       
                                <div class="form-group" >
                                    <label for="correccion_transferencia" title="Corrección Transferencia (dB)">Corrección Transferencia (dB) *</label>
                                    <input type="number" v-model="correccion_transferencia" class="form-control" id="correccion_transferencia">
                                </div>         
                            </div>
    
                            <div v-show="tecnica.codigo !='ME'" class="col-md-3">                       
                                <div class="form-group" >
                                    <label for="adicional_barrido" title="Adicional Barrido (dB)">Adicional Barrido (dB) *</label>
                                    <input type="number" v-model="adicional_barrido" class="form-control" id="adicional_barrido">
                                </div>         
                            </div>
    
                            <div v-show="tecnica.codigo !='ME'" class="col-md-3">                       
                                <div class="form-group" >
                                    <label for="amplificacion_total" title="Amplificación Total (dB)">Amplificación Total (dB) *</label>
                                    <input type="number" v-model="amplificacion_total" class="form-control" id="amplificacion_total">
                                </div>         
                            </div>
                            
                           <div class="clearfix"></div>  
    
                            <div class="col-md-1">                                               
                                <span>
                                  <button type="button" @click="addCalibraciones"><span class="fa fa-plus-circle"></span></button> 
                                </span>                            
                            </div>
                             <div class="form-group">
                                &nbsp;
                            </div>
                            <div v-if="calibraciones.length">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped table-bordered">
                                            <thead>
                                                <tr>                                  
                                                    <th style="min-width:100px;">Zapata</th>                                  
                                                    <th style="min-width:100px;">Palpador</th>
                                                    <th style="min-width:60px;">Frec</th>
                                                    <th style="min-width:60px;">A.P.</th> 
                                                    <th style="min-width:60px;">Rango</th>  
                                                    <th style="min-width:60px;">Pos</th>  
                                                    <th style="min-width:60px;">C.E.</th>  
                                                    <th style="min-width:60px;">B.C.</th>  
                                                    <th style="min-width:60px;">B.S.</th>  
                                                    <th style="min-width:60px;">T.R.</th>  
                                                    <th style="min-width:60px;">R.R.</th>  
                                                    <th style="min-width:60px;">G.R.</th>  
                                                    <th style="min-width:60px;">N.R.</th>  
                                                    <th style="min-width:60px;">C.T.</th>  
                                                    <th style="min-width:60px;">A.B.</th>  
                                                    <th style="min-width:60px;">A.T.</th> 
                                                    <th colspan="1" style="width:30px;">&nbsp;</th>                                            
                                                </tr>
                                            </thead>                         
                                            <tbody>
                                                <tr v-for="(calibracion,k) in  (calibraciones)" :key="k" >                                         
                                                    <td>{{ calibracion.zapata }}</td>                                            
                                                    <td>{{ calibracion.palpador.codigo }} </td>
                                                    <td>{{ calibracion.frecuencia }} </td>
                                                    <td>{{ calibracion.angulo_apertura }} </td>    
                                                    <td>{{ calibracion.rango }}</td>
                                                    <td>{{ calibracion.posicion }}</td>    
                                                    <td>{{ calibracion.curva_elevacion }}</td>
                                                    <td>{{ calibracion.block_calibracion }}</td> 
                                                    <td>{{ calibracion.block_sensibilidad }}</td>
                                                    <td>{{ calibracion.tipo_reflector }}</td> 
                                                    <td>{{ calibracion.reflector_referencia }}</td>
                                                    <td>{{ calibracion.ganancia_referencia }}</td> 
                                                    <td>{{ calibracion.nivel_registro }}</td>
                                                    <td>{{ calibracion.correccion_transferencia }}</td> 
                                                    <td>{{ calibracion.adicional_barrido }}</td>
                                                    <td>{{ calibracion.amplificacion_total }}</td>     
                                                    <td>
                                                        <a  @click="removeCalibraciones(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a>
                                                    </td>          
    
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>                 
                        </div>                   
                   </div>
               </div>
               <div class="box box-custom-enod">
                   <div class="box-body">
                        <div class="box-header with-border">
                            <h3 class="box-title">IMAGENES CALIBRACIONES</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>                       
                            </div>
                        </div>
                         <div>&nbsp;</div>
                         <div class="col-md-3">                       
                            <div class="form-group" >
                                <subir-imagen                                
                                    :ruta="ruta_calibraciones_us"                               
                                    :max_size="max_size"
                                    :path_inicial="path1_calibracion"
                                    :tipos_archivo_soportados ="tipos_archivo_soportados"
                                    :mostrar_formatos_soportados="true"
                                    @path="path1_calibracion = $event"
                                ></subir-imagen> 
                            </div>         
                        </div>
                        <div class="col-md-3">                       
                            <div class="form-group" >
                                <subir-imagen                                
                                    :ruta="ruta_calibraciones_us"                               
                                    :max_size="max_size"
                                    :path_inicial="path2_calibracion"
                                    :tipos_archivo_soportados ="tipos_archivo_soportados"    
                                    :mostrar_formatos_soportados="true"                          
                                    @path="path2_calibracion = $event"
                                ></subir-imagen> 
                            </div>         
                        </div>
                        <div class="col-md-3">                       
                            <div class="form-group" >
                                <subir-imagen                                
                                    :ruta="ruta_calibraciones_us"                               
                                    :max_size="max_size"
                                    :path_inicial="path3_calibracion"
                                    :tipos_archivo_soportados ="tipos_archivo_soportados"      
                                    :mostrar_formatos_soportados="true"                       
                                    @path="path3_calibracion = $event"
                                ></subir-imagen> 
                            </div>         
                        </div>
                        <div class="col-md-3">                       
                            <div class="form-group" >
                                <subir-imagen                                
                                    :ruta="ruta_calibraciones_us"                               
                                    :max_size="max_size"
                                    :path_inicial="path4_calibracion"
                                    :tipos_archivo_soportados ="tipos_archivo_soportados"   
                                    :mostrar_formatos_soportados="true"                           
                                    @path="path4_calibracion = $event"
                                ></subir-imagen> 
                            </div>         
                        </div>
                   </div>
               </div>
                        
              <div v-if="tecnica && (tecnica.codigo == 'US' || tecnica.codigo == 'PA')"> 
                    <div class="box box-custom-enod">                

                        <div class="box-header with-border">
                            <h3 class="box-title">REGISTRO DE MEDICIONES </h3>
                        </div>
                        <div class="box-body">   
                            <div>&nbsp;</div>
                            <div class="col-md-3">                       
                                <div class="form-group" >
                                    <label for="elemento_us_pa" title="Elemento">Elemento *</label>
                                    <input type="text" v-model="elemento_us_pa" class="form-control" id="elemento_us_pa" maxlength="15">
                                </div>         
                            </div>

                            <div class="col-md-3">                       
                                <div class="form-group" >
                                    <label for="diametro_us_pa" title="Diametro">ø</label>
                                    <v-select v-model="diametro_us_pa" label="diametro" :options="diametros" id="diametro_us_pa"></v-select>
                                </div>         
                            </div>

                            <div class="col-md-3">                       
                                <div class="form-group" >
                                    <label for="nro_indicacion_up_pa" title="Número Indicación">N° Indicación *</label>
                                    <input type="number" v-model="nro_indicacion_us_pa" class="form-control" id="nro_indicacion_us_pa">
                                </div>         
                            </div>

                            <div class="col-md-3">                       
                                <div class="form-group" >
                                    <label for="posicion_examen_up_pa" title="Posición Examen">Posición Examen *</label>
                                    <input type="text" v-model="posicion_examen_us_pa" class="form-control" id="posicion_examen_up_pa">
                                </div>         
                            </div>

                            <div class="col-md-3">                       
                                <div class="form-group" >
                                    <label for="angulo_incidencia_us_pa" title="Ángulo Incidencia">Ángulo Incidencia *</label>
                                    <input type="text" v-model="angulo_incidencia_us_pa" class="form-control" id="angulo_incidencia_us_pa">
                                </div>         
                            </div>

                            <div class="col-md-3">                       
                                <div class="form-group" >
                                    <label for="camino_sonico_us_pa" title="Camino sónico">Camino Sónico *</label>
                                    <input type="number" v-model="camino_sonico_us_pa" class="form-control" id="camino_sonico_us_pa">
                                </div>         
                            </div>

                            <div class="col-md-3">                       
                                <div class="form-group" >
                                    <label for="x_us_pa" title="X (cm)">X *</label>
                                    <input type="number" v-model="x_us_pa" class="form-control" id="x_us_pa">
                                </div>         
                            </div>

                            <div class="col-md-3">                       
                                <div class="form-group" >
                                    <label for="y_us_pa" title="Y (mm)">Y *</label>
                                    <input type="number" v-model="y_us_pa" class="form-control" id="y_us_pa">
                                </div>         
                            </div>

                            <div class="col-md-3">                       
                                <div class="form-group" >
                                    <label for="z_us_pa" title="Z (mm)">Z *</label>
                                    <input type="number" v-model="z_us_pa" class="form-control" id="z_us_pa">
                                </div>         
                            </div>

                            <div class="col-md-3">                       
                                <div class="form-group" >
                                    <label for="longitud_us_pa" title="Longitud (mm)">Longitud (mm) *</label>
                                    <input type="number" v-model="longitud_us_pa" class="form-control" id="longitud_us_pa">
                                </div>         
                            </div>

                            <div class="col-md-3">                       
                                <div class="form-group" >
                                    <label for="nivel_registro_us_pa" title="Nivel Registro">Nivel Registro *</label>
                                    <input type="number" v-model="nivel_registro_us_pa" class="form-control" id="nivel_registro_us_pa">
                                </div>         
                            </div>

                           <div class="clearfix"></div>  

                            <div class="col-md-1">                                                       
                                <span>
                                  <button type="button"  @click="addTabla_us_pa()"><span class="fa fa-plus-circle"></span></button>  
                                </span>                            
                           </div>

                            <div class="form-group">
                                &nbsp;
                            </div>

                            <div v-if="Tabla_us_pa.length">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th  class="col-lg-1">Elemento</th>
                                                <th  class="col-lg-1">ø</th> 
                                                <th  class="col-lg-1">N° Ind.</th>
                                                <th  class="col-lg-1">P.E.</th>    
                                                <th  class="col-lg-1">A.I.</th>                                                  
                                                <th  class="col-lg-1">C.S.</th> 
                                                <th  class="col-lg-1">X</th> 
                                                <th  class="col-lg-1">Y</th> 
                                                <th  class="col-lg-1">Z</th> 
                                                <th  class="col-lg-1">Log.</th> 
                                                <th  class="col-lg-1">N.R. </th>  
                                                <th  class="col-lg-1">Aceptable</th>   
                                                <th  class="col-lg-1">Ref</th>                                                       
                                                <th  class="col-lg-1">&nbsp;</th>
                                            </tr>
                                        </thead>                         
                                        <tbody>
                                            <tr v-for="(item,k) in (Tabla_us_pa)" :key="k" @click="selectPosTabla_us_pa(k)" :class="{selected: indexPosTabla_us_pa === k}" >
                                                <td>{{ item.elemento_us_pa }}</td>                                        
                                                <td>{{ item.diametro_us_pa }}</td>
                                                <td>{{ item.nro_indicacion_us_pa}}</td>    
                                                <td>{{ item.posicion_examen_us_pa}}</td>
                                                <td>{{ item.angulo_incidencia_us_pa}}</td>
                                                <td>{{ item.camino_sonico_us_pa}}</td>
                                                <td>{{ item.x_us_pa}}</td>
                                                <td>{{ item.y_us_pa}}</td>
                                                <td>{{ item.z_us_pa}}</td>
                                                <td>{{ item.longitud_us_pa}}</td>
                                                <td>{{ item.nivel_registro_us_pa}}</td>
                                                <td> 
                                                    <input type="checkbox" id="checkbox" v-model="Tabla_us_pa[k].aceptable_sn_us_pa">
                                                </td>
                                                <td> 
                                                    <span :class="{ existe : (item.observaciones ||
                                                                                item.path1 ||
                                                                                item.path2 ||
                                                                                item.path3 ||
                                                                                item.path4 )                      
                                                }" class="fa fa-file-archive-o" @click="OpenReferencias_us_pa($event,k,'Informe US',item)" ></span>
                                                </td>                               

                                            
                                                <td><span class="fa fa-minus-circle" @click="removeTabla_us_pa(k)"></span></td>          

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                              </div> 
                            </div>

                        </div>
                    </div>   
                 </div> 
               <div v-else-if="tecnica && (tecnica.codigo == 'ME' && generatrices.length > 0 )">
                   <div class="box box-custom-enod">
                        <div class="box-body">   
                            <div class="box-header with-border">
                                <h3 class="box-title">REGISTRO DE MEDICIONES</h3>                               
                            </div>
                            <div>&nbsp;</div>

                            <div class="col-lg-5">
                            
                                <div class="col-md-12">                       
                                    <div class="form-group" >
                                        <label for="elemento_me" title="Elemento">Elemento *</label>
                                        <input type="text" v-model="elemento_me" class="form-control" id="elemento_me" maxlength="15">
                                    </div>         
                                </div>

                                <div class="col-md-12">                       
                                    <div class="form-group" >
                                        <label for="umbral" title="Umbral">Espesor Nominal</label>
                                        <input type="number" v-model="umbral_me" class="form-control" id="umbral_me" min="0" step="0.1">
                                    </div>         
                                </div>

                                <div class="col-md-12">                       
                                    <div class="form-group" >
                                        <label for="espesor_minimo_me" title="espesor_minimo_me">Espesor Mínimo</label>
                                        <input type="number" v-model="espesor_minimo_me" class="form-control" id="espesor_minimo_me" min="0" step="0.1">
                                    </div>         
                                </div>

                                <div class="col-md-12">                       
                                    <div class="form-group" >
                                        <label for="diametro_me" title="Diametro">ø</label>
                                        <v-select v-model="diametro_me" label="diametro" :options="diametros" id="diametro_me"></v-select>
                                    </div>         
                                </div>

                                <div class="col-md-12">                       
                                    <div class="form-group" >
                                        <label for="cantidad_posiciones_me" title="Cantidad Posiciones">Posición *</label>
                                        <input type="number" v-model="cantidad_posiciones_me" class="form-control" id="cantidad_posiciones_me">
                                    </div>         
                                </div>

                                <div class="col-md-12">                       
                                    <div class="form-group" >
                                        <label for="cantidad_generatrices_me" title="Cantidad Generatrices">Generatrices *</label>
                                        <input type="number" v-model="cantidad_generatrices_me" class="form-control" id="cantidad_generatrices_me">
                                    </div>         
                                </div>

                                <div class="clearfix"></div>  

                                <div class="col-md-1">        
                                    <div class="form-group" >                                               
                                        <span>
                                        <button type="button"  @click="addTabla_me()"><span class="fa fa-plus-circle"></span></button>  
                                        </span>       
                                    </div>                     
                               </div>

                               <div class="clearfix"></div>  

                                <!-- tabla me -->
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th  class="col-lg-1">Elemento</th>
                                                    <th  class="col-lg-1">Nominal</th>
                                                    <th  class="col-lg-1">Mínimo</th>
                                                    <th  class="col-lg-2">ø</th> 
                                                    <th  class="col-lg-1">Pos.</th>
                                                    <th  class="col-lg-1">Gen.</th>                                                                                               
                                                    <th  class="col-lg-1">&nbsp;</th>
                                                </tr>
                                            </thead>                         
                                            <tbody>
                                                <tr v-for="(item,k) in (Tabla_me)" :key="k" @click="selectPosTabla_me(k)" :class="{selected: indexPosTabla_me === k}" >
                                                    <td>{{ item.elemento_me }}</td>  
                                                    <td>{{ item.umbral_me }}</td>  
                                                    <td>{{ item.espesor_minimo_me }}</td>                                     
                                                    <td>{{ item.diametro_me }}</td>
                                                    <td>{{ item.cantidad_posiciones_me}}</td>    
                                                    <td>{{ item.cantidad_generatrices_me}}</td>                               
                                                    <td><span class="fa fa-minus-circle" @click="removeTabla_me(k)"></span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div> 
                            </div>

                            <div class="col-lg-7"> 

                                <!-- tabla mediciones -->    
                                <div v-if="Tabla_me[indexPosTabla_me]">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered" style="display: block;max-height: 500px;border-bottom: none;border-right: none;">
                                                <thead>
                                                    <tr>    
                                                     <th bgcolor="#bee5eb">&nbsp;</th>                                     
                                                     <th bgcolor="#bee5eb"  v-for="(h) in parseInt(Tabla_me[indexPosTabla_me].cantidad_generatrices_me)" :key="h" >{{ generatrices[h-1].valor}}</th>

                                                    </tr>
                                                </thead>    
                                                <tbody>                                                    
                                                    <tr v-for="(p) in parseInt(Tabla_me[indexPosTabla_me].cantidad_posiciones_me)" :key="p" @click="selectPosPos(p)">
                                                        <td style="min-width:60px;min-height:60px" bgcolor="#bee5eb"><strong> {{ p }} </strong> </td>
                                                        <td style="min-width:60px;min-height:60px" v-for="(g) in parseInt(Tabla_me[indexPosTabla_me].cantidad_generatrices_me)" :key="g" @click="selectPosGeneratriz(g)"  >

                                                            <div v-if="indexPosPos == p && indexPosGeneratriz == g">
                                                                <input style="width:40px;" type="number" v-model="Tabla_me[indexPosTabla_me].mediciones[g-1][p-1]" maxlength="4" :ref="'refInputMediciones'" @keyup.enter="getFocus(g,Tabla_me[indexPosTabla_me].cantidad_generatrices_me,p,Tabla_me[indexPosTabla_me].cantidad_posiciones_me)" step="0.1" max="99.9">    
                                                            </div>
                                                            <div v-else>

                                                                <div v-if="Tabla_me[indexPosTabla_me].mediciones[g-1][p-1] !=''">
                                                                    {{ Tabla_me[indexPosTabla_me].mediciones[g-1][p-1] }}
                                                                </div>
                                                                <div v-else>
                                                                        <span style="font-style: oblique; color: cadetblue;"> {{ p }}-{{generatrices[g-1].valor }} </span>                      
                                                                </div>

                                                            </div>                                                            
                                                            
                                                         </td>                                           
                                                    </tr>
                                                </tbody>                                                         
                                            
                                            </table>
                                        </div>
                                    </div>    
                                </div>
                            </div>


                        </div>
                    </div> 
               </div> 
               <div class="box box-custom-enod">
                   <div class="box-body">
                        <div class="box-header with-border">
                            <h3 class="box-title">IMAGENES INDICACIONES</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>                       
                            </div>
                        </div>
                         <div>&nbsp;</div>
                         <div class="col-md-3">                       
                            <div class="form-group" >
                                <subir-imagen                                
                                    :ruta="ruta_indicaciones_us"                               
                                    :max_size="max_size"
                                    :path_inicial="path1_indicacion"
                                    :tipos_archivo_soportados ="tipos_archivo_soportados"
                                    :mostrar_formatos_soportados="true"
                                    @path="path1_indicacion = $event"
                                ></subir-imagen> 
                            </div>         
                        </div>
                        <div class="col-md-3">                       
                            <div class="form-group" >
                                <subir-imagen                                
                                    :ruta="ruta_indicaciones_us"                               
                                    :max_size="max_size"
                                    :path_inicial="path2_indicacion"
                                    :tipos_archivo_soportados ="tipos_archivo_soportados"    
                                    :mostrar_formatos_soportados="true"                          
                                    @path="path2_indicacion = $event"
                                ></subir-imagen> 
                            </div>         
                        </div>
                        <div class="col-md-3">                       
                            <div class="form-group" >
                                <subir-imagen                                
                                    :ruta="ruta_indicaciones_us"                               
                                    :max_size="max_size"
                                    :path_inicial="path3_indicacion"
                                    :tipos_archivo_soportados ="tipos_archivo_soportados"      
                                    :mostrar_formatos_soportados="true"                       
                                    @path="path3_indicacion = $event"
                                ></subir-imagen> 
                            </div>         
                        </div>
                        <div class="col-md-3">                       
                            <div class="form-group" >
                                <subir-imagen                                
                                    :ruta="ruta_indicaciones_us"                               
                                    :max_size="max_size"
                                    :path_inicial="path4_indicacion"
                                    :tipos_archivo_soportados ="tipos_archivo_soportados"   
                                    :mostrar_formatos_soportados="true"                           
                                    @path="path4_indicacion = $event"
                                ></subir-imagen> 
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
        <create-referencias :index="index_referencias" :tabla="tabla" :inputsData="inputsData" @setReferencia="AddReferencia_us_pa"></create-referencias>
    </div>
</template>

<script>
import uniq from 'lodash/uniq';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/es';import {mapState} from 'vuex';
import { eventSetReferencia } from '../event-bus';
import { toastrInfo,toastrDefault } from '../toastrConfig';
import moment from 'moment';

export default {
    
    components: {

      
    },

    props :{

        editmode : {
            type : Boolean,
            required : false,    
            default : false
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

        informe_usdata : {
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
     

        interno_equipodata : {
            type : [ Object ],  
            required : false
            },

        estado_superficiedata : {
            type : [ Object ],  
            required : false
            },

        metodo : {
            type : String,
            required :true
            },

        tabla_us_pa_data : {
            type : [ Array ],  
            required : false
            },

        tabla_me_data : {
            type : [ Array ],  
            required : false
            },

        calibraciones_data : {
            type : [ Array ],  
            required : false
            },

    },

    data() {return {

        ruta_calibraciones_us: 'calibraciones_us',
        ruta_indicaciones_us:'indicaciones_us',
        max_size :500, //KB
        tipos_archivo_soportados:['jpg','bmp','jpeg','png'],

        errors:[],

        obra:'',
        cliente:'',
        fecha: moment(new Date()).format('YYYY-MM-DD'),
        observaciones:'',
        numero_inf:'',
        numero_inf_generado:'',
        ot_tipo_soldadura:'',
        componente:'',
        material:'',
        material2:'', 
        plano_isom:'',
        diametro:'',
        espesor:'',
        espesor_chapa:'', 
        isVarios:false,
        isChapa:false,
        tecnica:'',
        interno_equipo:'',       
        procedimiento:'',
        norma_ensayo:'',
        norma_evaluacion:'',
        ejecutor_ensayo:'',
        estado_superficie:'',
        encoder:'',
        agente_acoplamiento:'',
        path1_calibracion:'',
        path2_calibracion:'',
        path3_calibracion:'',
        path4_calibracion:'',
        path1_indicacion:'',
        path2_indicacion:'',
        path3_indicacion:'',
        path4_indicacion:'',

        zapata:'',
        palpador:'',
        frecuencia:'',
        angulo_apertura:'',
        rango:'',
        posicion:'',
        curva_elevacion:'',
        block_calibracion:'',
        block_calibraciones:[],
        block_sensibilidad:'',
        tipo_reflector:'',
        reflector_referencia:'',
        ganancia_referencia:'',
        nivel_registro:'',
        correccion_transferencia:'',
        adicional_barrido:'',
        amplificacion_total:'',

        // detalle us/pa

        elemento_us_pa:'',
        diametro_us_pa:{},
        nro_indicacion_us_pa:'',
        posicion_examen_us_pa:'',
        angulo_incidencia_us_pa:'',
        camino_sonico_us_pa:'',
        x_us_pa:'',
        y_us_pa:'',
        z_us_pa:'',
        longitud_us_pa:'',
        nivel_registro_us_pa:'',
        aceptable_sn_us_pa:'',

        //detalle me

        elemento_me:'',
        umbral_me:'',
        espesor_minimo_me:'',
        diametro_me:'',
        cantidad_posiciones_me:'',
        cantidad_generatrices_me:'',

        tecnicas:[],
        palpadores:[],
        estados_superficies:[],

        calibraciones:[],
        Tabla_us_pa:[],
        indexPosTabla_us_pa:0,
        indexPosTabla_me:0,
        indexPosGeneratriz:0,
        indexPosPos:0,
        Tabla_me:[],
        generatrices:[],

        // referencias
        index_referencias:'',
        tabla:'',
        inputsData:{},

      }
    },

    created : function() {
        
      this.getCliente();  
      this.$store.dispatch('loadOtObraTipoSoldaduras',{ 'ot_id' : this.otdata.id, 'obra' : this.obra });
      this.$store.dispatch('loadMateriales');
      this.$store.dispatch('loadDiametros');
      this.getTecnicas();
      this.$store.dispatch('loadInternoEquipos',{ 'metodo' : this.metodo, 'activo_sn' : 1, 'tipo_penetrante' : 'null' });       
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
      this.getEstadosSuperficies();
      this.getPalpadores();
      this.$store.dispatch('loadEjecutorEnsayo', this.otdata.id);     
      this.getGeneratrices();
      this.setEdit();      
    },

    mounted : function() {

         this.getNumeroInforme();
    },

    computed :{

        ...mapState(['url','AppUrl','ot_obra_tipo_soldaduras','materiales','diametros','espesores','procedimientos','norma_evaluaciones','norma_ensayos','ejecutor_ensayos','interno_equipos']),     

        numero_inf_code : function()  {

               if(this.numero_inf)

                     return this.metodo + (this.numero_inf <10? '00' : this.numero_inf<100? '0' : '') + this.numero_inf ;
        },
       
     },

      watch : {

    
        diametro : function(val){
            
            if(val){

                if(val.diametro =='CHAPA'){

                    this.isChapa = true;
                    this.isVarios = false;

                } else if (val.diametro =='VARIOS'){

                    this.isChapa = false;
                    this.isVarios = true;
                    this.espesor_chapa = ''

                }else{

                    this.isChapa = false;
                    this.isVarios = false;
                    this.espesor_chapa = ''

                }    
            }
                
        },      

    },

     methods : {

         setEdit : function(){

            if(this.editmode) {
            
               this.fecha   = this.informedata.fecha;
               this.numero_inf = this.informedata.numero;
               this.componente = this.informedata.componente;
               this.ot_tipo_soldadura = this.ot_tipo_soldaduradata;
               this.plano_isom = this.informedata.plano_isom;
               this.procedimiento_soldadura = this.informedata.procedimiento_soldadura;
               this.path1_calibracion = this.informe_usdata.path1_calibracion;
               this.path2_calibracion = this.informe_usdata.path2_calibracion;
               this.path3_calibracion = this.informe_usdata.path3_calibracion;
               this.path4_calibracion = this.informe_usdata.path4_calibracion
               this.path1_indicacion = this.informe_usdata.path1_indicacion;
               this.path2_indicacion = this.informe_usdata.path2_indicacion;
               this.path3_indicacion = this.informe_usdata.path3_indicacion;
               this.path4_indicacion = this.informe_usdata.path4_indicacion;
               this.pqr = this.informedata.pqr;           
               this.material = this.materialdata;
               this.material2 = this.material2data;
               this.diametro = this.diametrodata;
               this.espesor = this.diametro_espesordata;
               this.espesor_chapa = this.informedata.espesor_chapa;
               this.tecnica = this.tecnicadata;
               this.interno_equipo = this.interno_equipodata;     
               this.procedimiento = this.procedimientodata;            
               this.norma_evaluacion = this.norma_evaluaciondata;
               this.norma_ensayo = this.norma_ensayodata;            
               this.ejecutor_ensayo = this.ejecutor_ensayodata;   
               this.estado_superficie = this.estado_superficiedata;      
               this.encoder = this.informe_usdata.encoder;
               this.agente_acoplamiento = this.informe_usdata.agente_acoplamiento;
               this.observaciones = this.informedata.observaciones            
               this.calibraciones = this.calibraciones_data;
               this.Tabla_us_pa = this.tabla_us_pa_data; 
               this.Tabla_me = this.tabla_me_data; 
               this.SetearBlockCalibraciones();
            }

        },       

        setObra : function(value){

            this.obra = value;
            this.ot_tipo_soldadura='';
            this.$store.dispatch('loadOtObraTipoSoldaduras',{ 'ot_id' : this.otdata.id, 'obra' : this.obra });
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

        getTecnicas: function(){
             
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'tecnicas/metodo/'+ this.metodo + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
            this.tecnicas = response.data
            });
         },

         getEstadosSuperficies: function(){
             
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'estados_superficies' + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
            this.estados_superficies = response.data
            });
         },

         getPalpadores: function(){
             
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'palpadores' + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
            this.palpadores = response.data
            });
         },
    
        getEspesores : function(){
            this.espesor='';
            if(this.diametro != 'CHAPA')   {

                this.espesor_chapa = '';                
            }
            if(this.diametro){                
                this.$store.dispatch('loadEspesores',this.diametro.diametro_code);
            }            
        },

        getGeneratrices : function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'generatrices' + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
            this.generatrices = response.data
            });
        },


        addCalibraciones : function () {   
            
            console.log('entro en add calibraciones');
            
            if (this.tecnica.codigo !='ME' && !this.zapata){

                 toastr.error('El campo zapata es obligatorio'); 
                 return ;            
            }

            if(this.zapata.length  > 20){

                toastr.error('El campo zapata no debe contener más de 20 caracteres'); 
                return ;
             }

            if (!this.palpador){

                 toastr.error('El campo palpador es obligatorio'); 
                 return ;            
            }

            if (!this.frecuencia){

                 toastr.error('El campo frecuencia es obligatorio'); 
                 return ;            
            }

            if(this.frecuencia  > 999 ){

                toastr.error('El campo frecuencia no debe ser mayor a 999'); 
                return ;
             }

            if (!this.angulo_apertura){

                 toastr.error('El campo angulo apertura es obligatorio'); 
                 return ;            
            }

            if(this.angulo_apertura.length  > 10){

                toastr.error('El campo angulo apertura no debe contener más de 10 caracteres'); 
                return ;
             }

            if (!this.rango){

                 toastr.error('El campo rango es obligatorio'); 
                 return ;            
            }

            if(this.rango.length  > 10){

                toastr.error('El campo rango no debe contener más de 10 caracteres'); 
                return ;
             }   

            if (!this.posicion){

                 toastr.error('El campo posicion es obligatorio'); 
                 return ;            
            }

            if(this.posicion.length  > 10){

                toastr.error('El campo posicion no debe contener más de 10 caracteres'); 
                return ;
             }

            if (this.tecnica.codigo !='ME' && !this.curva_elevacion){

                 toastr.error('El campo curva elevacion es obligatorio'); 
                 return ;            
            }

            if(this.tecnica.codigo !='ME' && this.curva_elevacion.length  > 3){

                toastr.error('El campo curva elevacion no debe contener más de 3 caracteres'); 
                return ;
             }    
             
            if (!this.block_calibracion){

                 toastr.error('El campo block calibracion es obligatorio'); 
                 return ;            
            } 

            if (this.tecnica.codigo !='ME' && !this.block_sensibilidad){

                 toastr.error('El campo block sensibilidad es obligatorio'); 
                 return ;            
            }

            if(this.tecnica.codigo !='ME' && this.block_sensibilidad  > 999){

                toastr.error('El campo block sensibilidad no debe ser mayor a 999'); 
                return ;
             }

            if (this.tecnica.codigo !='ME' && !this.tipo_reflector){

                 toastr.error('El campo tipo reflector es obligatorio'); 
                 return ;            
            }

            if(this.tecnica.codigo !='ME' && this.tipo_reflector.length  > 1){

                toastr.error('El campo tipo reflector no debe contener más de 1 caracteres'); 
                return ;
             }
           
            if (this.tecnica.codigo !='ME' && !this.reflector_referencia){

                 toastr.error('El campo reflector referencia es obligatorio'); 
                 return ;            
            }

            if(this.tecnica.codigo !='ME' && this.reflector_referencia  > 99.9){

                toastr.error('El campo reflector referencia no debe ser mayor a 99.9'); 
                return ;
             }

            if (this.tecnica.codigo !='ME' && !this.ganancia_referencia){

                 toastr.error('El campo ganancia referencia es obligatorio'); 
                 return ;            
            }

            if(this.tecnica.codigo !='ME' && this.ganancia_referencia  > 999){

                toastr.error('El campo ganancia referencia no debe ser mayor a 999'); 
                return ;
             }            
            
             if (this.tecnica.codigo !='ME' && !this.nivel_registro){

                 toastr.error('El campo nivel registro es obligatorio'); 
                 return ;            
            }

            if(this.tecnica.codigo !='ME' && this.nivel_registro  > 999){

                toastr.error('El campo nivel registro no debe ser mayor a 999'); 
                return ;
             }          

            if (this.tecnica.codigo !='ME' && !this.correccion_transferencia){

                 toastr.error('El campo correccion transferencia es obligatorio'); 
                 return ;            
            }

            if(this.tecnica.codigo !='ME' && this.correccion_transferencia  > 999){

                toastr.error('El campo correccion_transferencia no debe ser mayor a 999'); 
                return ;
             }   
             
            if (this.tecnica.codigo !='ME' && !this.adicional_barrido){

                 toastr.error('El campo adicional barrido es obligatorio'); 
                 return ;            
            }

            if(this.tecnica.codigo !='ME' && this.adicional_barrido  > 999){

                toastr.error('El campo adicional barrido no debe ser mayor a 999'); 
                return ;
             }     

            if (this.tecnica.codigo !='ME' && !this.amplificacion_total){

                 toastr.error('El campo amplificacion total es obligatorio'); 
                 return ;            
            }

            if(this.tecnica.codigo !='ME' && this.amplificacion_total  > 999){

                toastr.error('El campo amplificacion total no debe ser mayor a 999'); 
                return ;
             }  

            this.calibraciones.push({   

                zapata :this.zapata, 
                palpador:this.palpador,
                frecuencia :this.frecuencia,
                angulo_apertura :this.angulo_apertura,
                rango :this.rango,                
                posicion:this.posicion,
                curva_elevacion:this.curva_elevacion,
                block_calibracion:this.block_calibracion,
                block_sensibilidad:this.block_sensibilidad,
                tipo_reflector:this.tipo_reflector,     
                reflector_referencia :this.reflector_referencia,
                ganancia_referencia :this.ganancia_referencia ,     
                correccion_transferencia :this.correccion_transferencia,     
                nivel_registro :this.nivel_registro ,     
                adicional_barrido :this.adicional_barrido,     
                amplificacion_total :this.amplificacion_total,               
                    
             });          
        },

         addTabla_us_pa : function () {

            if (!this.elemento_us_pa){

                 toastr.error('El campo elemento es obligatorio'); 
                 return ;            
            }

            if(this.elemento_us_pa.length  > 15){

                toastr.error('El campo elemento no debe contener más de 15 caracteres'); 
                return ;
             }       

            if(this.diametro_us_pa && this.diametro_us_pa.length  > 10){

                toastr.error('El campo diametro no debe contener más de 10 caracteres'); 
                return ;
             }

             if (!this.nro_indicacion_us_pa){

                 toastr.error('El campo nivel registro es obligatorio'); 
                 return ;            
            }

            if(this.nivel_nro_indicacion_us_paregistro  > 9999){

                toastr.error('El campo nivel nro indicacion no debe ser mayor a 9999'); 
                return ;
             }   

            if (!this.posicion_examen_us_pa){

                 toastr.error('El campo posicion examen es obligatorio'); 
                 return ;            
            }

            if(this.posicion_examen_us_pa.length  > 5){

                toastr.error('El campo posicion examen no debe contener más de 5 caracteres'); 
                return ;
             }

            if (!this.angulo_incidencia_us_pa){

                 toastr.error('El campo angulo incidencia es obligatorio'); 
                 return ;            
            }

            if(this.angulo_incidencia_us_pa.length  > 10){

                toastr.error('El campo angulo incidencia no debe contener más de 10 caracteres'); 
                return ;
             }

            if (!this.camino_sonico_us_pa){

                 toastr.error('El campo camino sonico es obligatorio'); 
                 return ;            
            }

            if(this.camino_sonico_us_pa.length  > 6){

                toastr.error('El campo camino sonico no debe contener más de 6 caracteres'); 
                return ;
             }

            if (!this.x_us_pa){

                 toastr.error('El campo X es obligatorio'); 
                 return ;            
            }

            if(this.x_us_pa  > 9999){

                toastr.error('El campo X no debe ser mayor a 9999'); 
                return ;
             }

            if (!this.y_us_pa){

                 toastr.error('El campo Y es obligatorio'); 
                 return ;            
            }

            if(this.y_us_pa  > 9999){

                toastr.error('El campo Y no debe ser mayor a 9999'); 
                return ;
             }

            if (!this.z_us_pa){

                 toastr.error('El campo Z es obligatorio'); 
                 return ;            
            }

            if(this.z_us_pa  > 9999){

                toastr.error('El campo Z no debe ser mayor a 9999'); 
                return ;
             }

            if (!this.longitud_us_pa){

                 toastr.error('El campo longitud es obligatorio'); 
                 return ;            
            }

            if(this.longitud_us_pa  > 9999){

                toastr.error('El campo longitud no debe ser mayor a 9999'); 
                return ;
             }

            if (!this.nivel_registro_us_pa){

                 toastr.error('El campo nivel registro es obligatorio'); 
                 return ;            
            }

            if(this.nivel_registro_us_pa.length  > 3){

                toastr.error('El campo nivel registro no debe contener más de 3 caracteres'); 
                return ;
             }               
         

                this.Tabla_us_pa.push({
                    elemento_us_pa: this.elemento_us_pa,
                    diametro_us_pa: this.diametro_us_pa ? this.diametro_us_pa.diametro : '',
                    nro_indicacion_us_pa:this.nro_indicacion_us_pa,
                    posicion_examen_us_pa:this.posicion_examen_us_pa,
                    angulo_incidencia_us_pa:this.angulo_incidencia_us_pa,
                    camino_sonico_us_pa:this.camino_sonico_us_pa,
                    x_us_pa:this.x_us_pa,
                    y_us_pa:this.y_us_pa,
                    z_us_pa:this.z_us_pa,
                    longitud_us_pa:this.longitud_us_pa,
                    nivel_registro_us_pa:this.nivel_registro_us_pa,
                    aceptable_sn_us_pa : false,
                    observaciones : '',                
                    path1:null,
                    path2:null,
                    path3:null,
                    path4:null

                });

        },        

        addTabla_me : function () {

            if (!this.elemento_me){

                 toastr.error('El campo elemento es obligatorio'); 
                 return ;            
            }

            if(this.elemento_me.length  > 15){

                toastr.error('El campo elemento no debe contener más de 15 caracteres'); 
                return ;
             }   

            if(this.umbral_me && this.umbral_me  > 99.9){

                toastr.error('El campo umbral no debe ser mayor a 99,9');    
                return ;
             }

             if(this.espesor_minimo_me && this.espesor_minimo_me  > 99.9){

                toastr.error('El campo espesor mínimo no debe ser mayor a 99,9');    
                return ;
                }

            if (!this.diametro_me){

                 toastr.error('El campo diametro es obligatorio'); 
                 return ;            
            }

            if(this.diametro_me.length  > 10){

                toastr.error('El campo diametro no debe contener más de 10 caracteres'); 
                return ;
             }
             
            if (!this.cantidad_posiciones_me){

                 toastr.error('El campo posiciones es obligatorio'); 
                 return ;            
            }

            if(this.cantidad_posiciones_me  > 100){

                toastr.error('El campo posiciones o debe ser mayor a 100'); 
                return ;
             }   
             
            if (!this.cantidad_generatrices_me){

                 toastr.error('El campo generatrices es obligatorio'); 
                 return ;            
            }


            if (this.cantidad_generatrices_me < 1 || this.cantidad_generatrices_me > this.generatrices.length){

                toastr.error('La cantidad de generatrices ingresadas no debe ser mayor a las registradas (' + this.generatrices.length + ')'); 
                return ;
            }


            let mediciones =  new Array(this.cantidad_generatrices_me);
            for (let g = 0; g < this.cantidad_generatrices_me; g++) {               
              
              mediciones[g] = [];
              for (let p = 0; p < this.cantidad_posiciones_me; p++) {

                   mediciones[g][p] = '';
                  
              }             
              
            }

            this.Tabla_me.push({

                elemento_me:               this.elemento_me,
                umbral_me:                 this.umbral_me,
                espesor_minimo_me:         this.espesor_minimo_me, 
                diametro_me:               this.diametro_me.diametro,
                cantidad_posiciones_me  :  this.cantidad_posiciones_me,
                cantidad_generatrices_me:  this.cantidad_generatrices_me,   
                mediciones :               mediciones,

            });

        },  

        selectPosTabla_us_pa :function(index){

        
            this.indexPosTabla_us_pa = index ;
           
        },

        selectPosTabla_me :function(index){

        
            this.indexPosTabla_me = index ;
           
        },

        getFocus(g,cant_g,p,cant_p){            

            if(g + 1 > cant_g  ){
                if(p + 1 > cant_p ){
                    this.indexPosGeneratriz = 1;
                    this.indexPosPos = 1;
                }else{
                    this.indexPosGeneratriz = 1;
                    this.indexPosPos = p + 1;
                }
            }else{
                     this.indexPosGeneratriz = g + 1;

            }

            setTimeout(x => {

                    this.$nextTick(() => {                
                        this.$refs['refInputMediciones'][0].focus();
                        });  
            }, 250);

        },
        

        selectPosGeneratriz :function(index){      

            this.indexPosGeneratriz = index ;     
         
        },

        selectPosPos :function(index){

            this.indexPosPos = index ;
          
           
        },

        borrarTodasLasCalibraciones(){

            this.calibraciones = [];
            this.SetearBlockCalibraciones();
        },

        SetearBlockCalibraciones(){

            if(this.tecnica.codigo=='ME'){

                this.block_calibraciones = ['Proveta', 'Escalonado'];
            }else{

                this.block_calibraciones = ['V1', 'V2'];
            }
        },

        removeCalibraciones(index) {
        
            this.calibraciones.splice(index, 1);               
            
        },

        removeTabla_us_pa : function(index){

            this.Tabla_us_pa.splice(index, 1);   
        },

        removeTabla_me : function(index){

            this.Tabla_me.splice(index, 1);   
        },


        OpenReferencias_us_pa(event,index,tabla,inputsReferencia){    

          this.index_referencias = index ;
          this.tabla = tabla;
          this.inputsData = inputsReferencia ;     
          eventSetReferencia.$emit('open');
      },

        AddReferencia_us_pa(Ref){      

            
            this.Tabla_us_pa[this.index_referencias].observaciones = Ref.observaciones;
            this.Tabla_us_pa[this.index_referencias].path1 = Ref.path1;
            this.Tabla_us_pa[this.index_referencias].path2 = Ref.path2;
            this.Tabla_us_pa[this.index_referencias].path3 = Ref.path3;
            this.Tabla_us_pa[this.index_referencias].path4 = Ref.path4;
        
            
            $('#nuevo').modal('hide');     
        },

        Store : function(){           
      

            this.errors =[];        
        
           
            var urlRegistros = 'informes_us' ;      
            axios({
            method: 'post',
            url : urlRegistros,    
            data : {
                
                'ot'              : this.otdata,
                'obra'            : this.obra,
                'fecha':          this.fecha,
                'ot_tipo_soldadura' : this.ot_tipo_soldadura,
                'observaciones':  this.observaciones,
                'numero_inf':     this.numero_inf,
                'componente' :    this.componente,
                'material':       this.material,
                'material2':      this.material2,
                'plano_isom' :    this.plano_isom,
                'diametro':       this.diametro,
                'espesor':        this.espesor,
                'espesor_chapa' :  this.espesor_chapa, 
                'procedimiento_soldadura': this.procedimiento_soldadura,
                'pqr':this.pqr,                      
                'tecnica':this.tecnica,
                'interno_equipo'   :  this.interno_equipo,  
                'procedimiento' : this.procedimiento,     
                'ejecutor_ensayo' : this.ejecutor_ensayo,   
                'norma_ensayo': this.norma_ensayo,
                'norma_evaluacion': this.norma_evaluacion,
                'estado_superficie' : this.estado_superficie,
                'encoder'           : this.encoder,
                'agente_acoplamiento' : this.agente_acoplamiento,             
                'metodo_ensayo'   : this.metodo,
                'path1_calibracion' : this.path1_calibracion,
                'path2_calibracion' : this.path2_calibracion,
                'path3_calibracion' : this.path3_calibracion,
                'path4_calibracion' : this.path4_calibracion,
                'path1_indicacion'  : this.path1_indicacion,
                'path2_indicacion' : this.path2_indicacion,
                'path3_indicacion' : this.path3_indicacion,
                'path4_indicacion' : this.path4_indicacion,
                'calibraciones'   :this.calibraciones,
                'tabla_us_pa'     :this.Tabla_us_pa,
                'tabla_me'        :this.Tabla_me,                  
        }}     
    
        ).then(response => {

          let informe = response.data;
          toastr.success('informe N°' + this.numero_inf + ' fue creado con éxito ');
          window.open( this.AppUrl + '/pdf/informe/us/' + informe.id,'_blank');
          window.location.href = this.AppUrl + '/informes/ot/' + this.otdata.id;

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

            var urlRegistros = 'informes_us/' + this.informedata.id  ;      
            axios({
              method: 'put',
              url : urlRegistros,    
              data : {
                
                'ot'              : this.otdata,
                'obra'            : this.obra,
                'fecha':          this.fecha,
                'observaciones':  this.observaciones,
                'numero_inf':     this.numero_inf,
                'ot_tipo_soldadura' : this.ot_tipo_soldadura,
                'componente' :    this.componente,
                'material':       this.material,
                'material2':      this.material2,
                'plano_isom' :    this.plano_isom,
                'diametro':       this.diametro,
                'espesor':        this.espesor,
                'espesor_chapa' :  this.espesor_chapa, 
                'procedimiento_soldadura': this.procedimiento_soldadura,
                'pqr':this.pqr,                      
                'tecnica':this.tecnica,
                'interno_equipo'   :  this.interno_equipo,  
                'procedimiento' : this.procedimiento,     
                'ejecutor_ensayo' : this.ejecutor_ensayo,   
                'norma_ensayo': this.norma_ensayo,
                'norma_evaluacion': this.norma_evaluacion,
                'estado_superficie' : this.estado_superficie,
                'encoder'           : this.encoder,
                'agente_acoplamiento' : this.agente_acoplamiento,             
                'metodo_ensayo'   : this.metodo,     
                'path1_calibracion' : this.path1_calibracion,
                'path2_calibracion' : this.path2_calibracion,
                'path3_calibracion' : this.path3_calibracion,
                'path4_calibracion' : this.path4_calibracion,
                'path1_indicacion'  : this.path1_indicacion,
                'path2_indicacion' : this.path2_indicacion,
                'path3_indicacion' : this.path3_indicacion,
                'path4_indicacion' : this.path4_indicacion,
                'calibraciones'   :this.calibraciones,
                'tabla_us_pa'     :this.Tabla_us_pa,
                'tabla_me'        :this.Tabla_me,                  
          }}
          
      
        ).then(response => {

          toastr.success('informe N°' + this.numero_inf + ' fue actualizado con éxito ');               
          window.open( this.AppUrl + '/pdf/informe/us/' + this.informedata.id,'_blank');
          window.location.href = this.AppUrl + '/informes/ot/' + this.otdata.id;
       
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

table th, table td {

    text-align: center;
}



</style>