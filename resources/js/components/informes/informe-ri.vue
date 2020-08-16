<template>
    <div class="row">
        <div class="col-md-12">
            <form @submit.prevent="editmode ?  Update() : Store()"  method="post">
                <informe-header :otdata="otdata" :informe_id="informedata.id" :editmode="editmode" @set-obra="setObra($event)"></informe-header>
                <div class="box box-custom-enod">
                   <div class="box-body">

                         <div class="col-md-3">
                             <div class="form-group" >
                                 <label for="formato">Tipo informe RI *</label>
                                 <v-select v-model="formato" :options="['PLANTA', 'DUCTO']" @input="cambiopTipoInforme" ></v-select>
                             </div>
                         </div>
                         <div class="col-md-3">
                             <div class="form-group">
                                  <label for="fecha">Fecha *</label>
                                 <div>
                                     <date-picker v-model="fecha" value-type="YYYY-MM-DD" format="DD-MM-YYYY" placeholder="DD-MM-YYYY" autocomplete="new-password" ></date-picker>
                                 </div>
                             </div>
                         </div>

                         <div class="col-md-6">
                             <div class="row">
                                 <div class="col-md-3">
                                     <div class="form-group" >
                                         <div v-if="isGasoducto">
                                             <label for="pk">PK *</label>
                                         </div>
                                         <div v-else>
                                             <label for="pk">PK</label>
                                         </div>
                                     <input type="number" v-model="pk" class="form-control" id="pk" :disabled="((!isGasoducto) || reparacion_sn== true || reparacion_sn == 1)" min="0">
                                     </div>
                                 </div>

                                 <div class="col-md-3">
                                     <div class="form-group" >
                                         <div v-if="isGasoducto">
                                             <label for="ot_obra_tipo_soldaduras">Tipo Sol *</label>

                                         <input type="checkbox" id="reparacion_sn" v-model="reparacion_sn" :disabled="!ExisteEpsReparacion" @change="cambioReparacion_sn()" style="float:right">
                                         <label for="reparacion_sn" style="float:right;margin-right: 5px;">R</label>

                                             <v-select v-model="ot_tipo_soldadura" label="codigo" :options="ot_obra_tipo_soldaduras_filter_R" id="ot_obra_tipo_soldaduras" @input="cambioOtTipoSoldadura" :disabled="(!isGasoducto || !obra )"></v-select>

                                         </div>
                                         <div v-else>
                                             <label >Tipo Sol</label>

                                             <v-select  :options="[]" :disabled="(!isGasoducto)"></v-select>
                                         </div>
                                     </div>
                                 </div>

                                 <div class="col-md-6">
                                     <div class="form-group" >
                                         <label for="numero_inf">Informe N°</label>
                                         <input type="text" v-model="numero_inf_code" class="form-control" id="numero_inf" disabled>
                                     </div>
                                 </div>
                             </div>
                         </div>

                         <div class="clearfix"></div>

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

                         <div class="col-md-3" >
                             <div class="form-group">
                                 <label for="material2">Material accesorio</label>
                                 <v-select v-model="material2" label="codigo" :options="materiales" id="material2"></v-select>
                             </div>
                         </div>

                         <div class="col-md-3">
                             <div class="form-group" >
                                 <label for="plano_isom">Plano / Isom *</label>
                                 <input type="text" v-model="plano_isom" class="form-control" id="plano_isom" maxlength="10">
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
                                <div v-if="isChapa">
                                     <label for="espesor">Espesor</label>
                                 </div>
                                 <div v-else>
                                      <label for="espesor">Espesor *</label>
                                 </div>
                                 <v-select v-model="espesor" label="espesor" :options="espesores" taggable :disabled="isChapa" @input="cambioEspesor()">
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

                         <div v-if="!reparacion_sn" class="col-md-3">
                             <div class="form-group size-pqr-eps"  >
                                 <label for="procedimientos_soldadura">Proc. Soldadura (EPS)*</label>
                                 <v-select v-model="ot_tipo_soldadura" label="eps" :options="ot_obra_tipo_soldaduras_filter_R" id="procedimientos_soldadura"  :disabled="(isGasoducto)"></v-select>
                             </div>
                         </div>

                         <div v-else  class="col-md-3">
                             <div class="form-group size-pqr-eps" >
                                 <label for="eps_r">Proc. Soldadura (EPS)*</label>
                                  <input type="text" v-model="ot_tipo_soldadura_r.eps" class="form-control" id="eps_r" disabled>
                             </div>
                         </div>

                         <div class="clearfix"></div>

                        <div v-if="!reparacion_sn" class="col-md-3">
                             <div class="form-group size-pqr-eps" >
                                 <label for="pqr">PQR</label>
                                 <v-select v-model="ot_tipo_soldadura" label="pqr" :options="ot_obra_tipo_soldaduras_filter_R" id="pqr"  :disabled="(isGasoducto)"></v-select>
                             </div>
                         </div>

                         <div v-else  class="col-md-3">
                             <div class="form-group size-pqr-eps" >
                                 <label for="pqr_r">PQR</label>
                                  <input type="text" v-model="ot_tipo_soldadura_r.pqr" class="form-control" id="pqr_r" disabled>
                             </div>
                         </div>

                         <div class="col-md-3">
                             <div class="form-group">
                                 <label>Equipo *</label>
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
                                 <label for="fuente">Fuente</label>
                                  <input type="text" v-model="fuente.codigo" class="form-control" id="fuente" disabled>
                             </div>
                         </div>

                         <div v-if="(fuente)" class="col-md-3">
                             <div class="form-group" >
                                 <label for="foco">Foco </label>
                                 <input type="text" v-model="interno_fuente.foco" class="form-control" id="foco" disabled>
                             </div>
                         </div>
                         <div v-else class="col-md-3">
                           <div class="form-group" >
                                 <label for="foco">Foco </label>
                                 <input type="text" v-model="interno_equipo.foco" class="form-control" id="foco" disabled>
                             </div>
                         </div>

                         <div class="col-md-3">
                             <div class="form-group" >
                                 <label for="actividad">Actividad</label>
                                 <input type="text" v-model="actividad" class="form-control" id="actividad" disabled>
                             </div>
                         </div>

                         <div class="col-md-3">
                             <div class="form-group" >
                                 <label for="kv">Kv</label>
                                 <input  type="number" class="form-control" v-model="kv" id="kv" :disabled="interno_equipo.interno_fuente" max="9999" step="0.1">
                             </div>
                         </div>
                         <div class="col-md-3">
                             <div class="form-group" >
                                 <label for="ma">mA</label>
                                 <input  type="number" class="form-control" v-model="ma" id="ma" :disabled="interno_equipo.interno_fuente" max="9999" step="0.1">
                             </div>
                         </div>

                         <div class="col-md-3">
                             <div class="form-group">
                                 <label>Calidad de placas *</label>
                                     <v-select  v-model="tipo_pelicula" :options="tipo_peliculas" label="codigo">
                                         <template slot="option" slot-scope="option">
                                             <span class="upSelect">{{ option.codigo }}</span> <br>
                                             <span class="downSelect"> {{ option.fabricante }} </span>
                                         </template>
                                     </v-select>
                             </div>
                         </div>

                         <div class="clearfix"></div>

                         <div class="col-md-3">
                             <div class="form-group" >
                                 <label for="cm">Medida de Placa*</label>
                                 <v-select type="text" v-model="medida" label="codigo" id="cm" :options="cms" style="display: block" taggable  @input="cambioMedida"></v-select>
                             </div>
                         </div>

                         <div class="col-md-3">
                             <div class="form-group" >
                                 <label for="ici">Ici *</label>
                                 <v-select v-model="ici" label="codigo" :options="icis"></v-select>
                             </div>
                         </div>

                        <div class="col-md-3">
                             <div class="form-group" >
                                 <label for="pantalla">Pantalla</label>
                                 <input type="text" v-model="pantalla" class="form-control" id="pantalla" disabled>
                             </div>
                         </div>

                        <div class="col-md-3">
                             <div class="form-group" >
                                 <label for="pos_ant">Ant *</label>
                                 <input type="number" v-model="pos_ant" class="form-control" id="pos_ant" step=".01">
                             </div>
                        </div>

                        <div class="col-md-3">
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" >
                                        <label for="pos_pos">Pos *</label>
                                        <input type="number" v-model="pos_pos" class="form-control" id="pos_pos" step=".01">
                                    </div>
                                </div>
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="procRadio">Procedimiento RI *</label>
                                        <v-select v-model="procedimiento" label="titulo" :options="procedimientos" id="procRadio" :appendToBody="'false'" :autoscroll="true"></v-select>
                                    </div>
                                </div>
                             </div>
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" >
                                        <label for="exposicion">N° Exposiciones *</label>
                                        <input type="number" v-model="exposicion" class="form-control" id="exposicion">
                                    </div>
                                </div>
                             </div>
                        </div>

                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" >
                                        <label for="pos_pos">lado *</label>
                                        <input type="text" v-model="lado" class="form-control" id="lado">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
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
                           </div>
                           <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" >
                                        <label for="distancia_fuente_pelicula">Dist. Fuente/Film *</label>
                                        <input type="text" v-model="distancia_fuente_pelicula" class="form-control" disabled id="distancia_fuente_pelicula">
                                    </div>
                                </div>
                           </div>
                        </div>

                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Técnica *</label>
                                        <v-select v-model="tecnica" label="codigo" :options="tecnicas" @input="ActualizarDistFuentePelicula()" :disabled="isChapa">
                                            <template slot="option" slot-scope="option">
                                                <span class="upSelect">{{ option.codigo }}</span> <br>
                                                <span class="downSelect"> {{ option.descripcion }} </span>
                                            </template>
                                        </v-select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
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

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" >
                                        <label for="ejecutor_ensayo">Ejecutor Ensayo *</label>
                                        <v-select v-model="ejecutor_ensayo" label="name" :options="ejecutor_ensayos"></v-select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="!isLoading" class="col-md-3">
                             <div class="row">
                                <div class="col-md-12" >
                                    <label>&nbsp;</label>
                                    <div v-if="tecnica.path" class="thumbnail" style="border:solid 1px">
                                        <img :src="tecnica.path" alt="..." >
                                    </div>
                                    <div v-else class="thumbnail" style="border:solid 1px">
                                         <img :src="'/img/tecnicas/imagen_no_disponible.jpg'" alt="..." >
                                    </div>
                               </div>
                           </div>
                        </div>
                   </div>
                </div>


                <div class="box box-custom-enod">
                      <div class="box-header with-border">
                         <h3 class="box-title">ELEMENTOS/POSICIONES</h3>
                         <div class="box-tools pull-right">
                             <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                             </button>
                         </div>
                     </div>
                 <div class="box-body">

                 <div v-if="!reparacion_sn" class="col-md-2">
                     <div class="form-group" >
                         <label for="junta">Elemento</label>
                         <input type="text" v-model="junta" class="form-control" id="junta">
                     </div>
                 </div>
                 <div v-else>
                     <div class="col-md-3">
                         <div class="form-group" >
                             <label for="juntas_reparacion">Elemento a Reparar</label>
                             <v-select v-model="junta_reparacion" label="codigo" :options="juntas_reparacion" id="defecto_sector" ></v-select>
                         </div>
                     </div>
                 </div>

                 <div class="col-md-2">
                     <div class="form-group" >
                         <label for="densidad">Densidad</label>
                         <input type="number" v-model="densidad" class="form-control" id="densidad" step="0.1">
                     </div>
                 </div>

                 <div class="col-md-2">
                     <div class="form-group" >
                     <label for="posicion">Posición</label>
                     <input type="text" v-model="posicion" class="form-control" id="posicion">
                     </div>
                 </div>

                 <div class="col-md-2">
                        <p>&nbsp;</p>
                        <button type="button" @click="AddDetalle()" title="Agregar Junta/Posición"><app-icon img="plus-circle" color="black"></app-icon></button>
                        <button type="button" @click="ClonarPosPlanta()" title="Clonar Posición"><app-icon img="clone" color="black"></app-icon></button>
                        <button type="button" @click="resetDetalle()" title="Limpiar Todo"><app-icon img="trash" color="black"></app-icon></button>
                 </div>

                 <div class="form-group">
                     &nbsp;
                 </div>

                     <div v-if="TablaDetalle.length">
                         <div class="col-md-12">
                             <div class="table-responsive">
                                 <table class="table table-hover table-striped table-bordered table-condensed">
                                     <thead>
                                         <tr>
                                             <th class="col-md-1">Elemento</th>
                                             <th class="col-md-1">Densidad</th>
                                             <th class="col-md-1">Pos.</th>
                                             <th class="col-md-1">Aceptable</th>
                                             <th class="col-md-1">Observación</th>
                                             <th class="col-md-1">&nbsp;</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <tr v-for="(FIlaTabla,k) in (TablaDetalle)" :key="k" :class="{selected: indexDetalle === k}" class="pointer">
                                             <td  @click="selectPosDetalle(k)">{{ FIlaTabla.junta }}</td>
                                             <td  @click="selectPosDetalle(k)">{{ FIlaTabla.densidad }}</td>
                                             <td  @click="selectPosDetalle(k)">{{ FIlaTabla.posicion }} </td>
                                             <td  @click="selectPosDetalle(k)"> <input type="checkbox" id="checkbox" v-model="TablaDetalle[k].aceptable_sn">  </td>
                                             <td  @click="selectPosDetalle(k)">
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
                    </div>


                     <div class="box box-custom-enod">

                         <div class="box-header with-border">
                             <h3 class="box-title">INDICACIONES</h3>
                             <div class="box-tools pull-right">
                                 <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                 </button>
                             </div>
                         </div>

                       <div class="box-body">

                         <div class="col-md-3">
                            <div class="form-group" >
                                 <label>Indicación</label>
                                 <v-select v-model="defectoRiPlanta" :options="defectosRiPlanta" label="codigo" :disabled="(!TablaDetalle.length)">
                                     <template slot="option" slot-scope="option">
                                         <span class="upSelect">{{ option.descripcion }} </span> <br>
                                         <span class="downSelect">{{ option.codigo }} </span>
                                     </template>
                                 </v-select>
                             </div>
                         </div>

                         <div class="col-md-2">
                             <div class="form-group" >
                                 <label for="posicionPlacaGosaducto">Posición Indicación</label>
                                 <input type="text" v-model="posicionPlacaGosaducto" class="form-control" id="posicionPlacaGosaducto" placeholder="XXX-XXX" :disabled="(!TablaDetalle.length)" maxlength="7">
                             </div>
                         </div>

                         <div class="col-md-3">
                             <div class="form-group" >
                                 <label for="defecto_sector">Pasada</label>
                                 <v-select v-model="defecto_sector" label="defecto_sector" :options="['RAIZ','RELLENO','SOBREMONTA']" id="defecto_sector"  :disabled="(!posicionPlacaGosaducto)"></v-select>
                             </div>
                         </div>

                         <div class="col-md-1">
                             <div class="form-group">
                                  <p>&nbsp;</p>
                                 <span>
                                   <button type="button" @click="addDefectos()" title="Agregar Defecto"><app-icon img="plus-circle" color="black"></app-icon></button>
                                 </span>
                             </div>
                         </div>

                          <div class="form-group">
                             &nbsp;
                         </div>

                          <div v-if="TablaDetalle.length && TablaDetalle[indexDetalle].defectos.length">
                             <div class="col-md-12">
                                 <div class="table-responsive">
                                     <table class="table table-hover table-striped table-bordered table-condensed">
                                         <thead>
                                             <tr>
                                                 <th class="col-md-1">Código</th>
                                                 <th class="col-md-3">Descripción</th>
                                                 <th class="col-md-1">Posición</th>
                                                 <th class="col-md-1">Sector</th>
                                                 <th class="col-md-1">&nbsp;</th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             <tr v-for="(defectoPasada,k) in ( (TablaDetalle.length > 0 )  ? TablaDetalle[indexDetalle].defectos : [])"  :key="k">
                                                 <td>{{ defectoPasada.codigo }}</td>
                                                 <td>{{ defectoPasada.descripcion }}</td>
                                                 <td>{{ defectoPasada.posicion }}</td>
                                                 <td>{{ defectoPasada.pasada }}</td>
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
                   </div>


                <div class="box box-custom-enod">
                    <div class="box-header with-border">
                         <h3 class="box-title">PASADAS</h3>
                         <div class="box-tools pull-right">
                             <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                             </button>
                         </div>
                     </div>

                 <div class="box-body">

                     <div class="col-md-2">
                         <div class="form-group" >
                             <label for="elemento_pasadas">Elemento</label>
                             <v-select v-model="elemento_pasada" :options="elemento_pasadas" @input="autocompletarNumeroPasada" id="elemento_pasadas"></v-select>
                         </div>
                     </div>

                     <div class="col-md-2">
                         <div class="form-group" >
                             <label for="Elemento">N° Pasada</label>
                             <input type="number" v-model="pasada" class="form-control" id="pasada" disabled>
                         </div>
                     </div>
                     <div class="col-md-2">

                         <label>Cuño Z</label>
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

                         <label>Cuño P</label>

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
                             <button type="button" @click="AddPasadas()" title="Agregar Pasada"><app-icon img="plus-circle" color="black"></app-icon></button>
                             <button type="button"  @click="ModalClonarSoldadores()" title="Clonar Soldadores"><app-icon img="clone" color="black"></app-icon></button>
                              <button type="button" @click="ModalImportarSoldadores()"  :disabled="(!isGasoducto)" title="Importar Soldadores"><app-icon img="file-excel-o" color="black"></app-icon></button>
                             <button type="button" @click="getSoldadores()" title="Recargar Cuños"><app-icon img="refresh" color="black"></app-icon></button>
                           </span>
                     </div>

                     <div class="form-group">
                         &nbsp;
                     </div>

                     <div v-if="TablaPasadas.length">
                            <div class="col-md-12">
                                 <div class="table-responsive">
                                     <table class="table table-hover table-striped table-bordered table-condensed">
                                         <thead>
                                             <tr>
                                                 <th class="col-md-1">Elemento</th>
                                                 <th class="col-md-1">N° Pasada</th>
                                                 <th class="col-md-2">Cuño Z</th>
                                                 <th class="col-md-2">Cuño L</th>
                                                 <th class="col-md-2">Cuño P</th>
                                                 <th class="col-md-2">&nbsp;</th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             <tr v-for="(Pasada,k) in  (TablaPasadas)" :key="k" @click="selectPosPasadas(k)">
                                                 <td v-if="Pasada.elemento_pasada == elemento_pasada">{{ Pasada.elemento_pasada }}</td>
                                                 <td v-if="Pasada.elemento_pasada == elemento_pasada">{{ Pasada.pasada }}</td>
                                                 <td v-if="Pasada.elemento_pasada == elemento_pasada">
                                                     <div v-if="indexPasada == k ">
                                                         <v-select v-model="TablaPasadas[indexPasada].soldador1" :options="soldadores" label="codigo">
                                                             <template slot="option" slot-scope="option">
                                                                 <span class="upSelect">{{ option.nombre }} </span> <br>
                                                                 <span class="downSelect"> {{ option.codigo }} </span>
                                                             </template>
                                                         </v-select>
                                                     </div>
                                                     <div v-else>
                                                         {{ Pasada.soldador1.codigo }}
                                                     </div>
                                                 </td>
                                                 <td v-if="Pasada.elemento_pasada == elemento_pasada">
                                                     <div v-if="indexPasada == k ">
                                                         <v-select v-model="TablaPasadas[indexPasada].soldador2" :options="soldadores" label="codigo" :disabled="(!isGasoducto || TablaPasadas[indexPasada].pasada!='1' || !TablaDetalle.length)">
                                                             <template slot="option" slot-scope="option">
                                                                 <span class="upSelect">{{ option.nombre }} </span> <br>
                                                                 <span class="downSelect"> {{ option.codigo }} </span>
                                                             </template>
                                                         </v-select>
                                                     </div>
                                                     <div v-else>
                                                        {{ Pasada.soldador2.codigo }}
                                                     </div>
                                                 </td>
                                                 <td v-if="Pasada.elemento_pasada == elemento_pasada">
                                                     <div v-if="indexPasada == k ">
                                                         <v-select v-model="TablaPasadas[indexPasada].soldador3" :options="soldadores" label="codigo">
                                                             <template slot="option" slot-scope="option">
                                                                 <span class="upSelect">{{ option.nombre }} </span> <br>
                                                                 <span class="downSelect"> {{ option.codigo }} </span>
                                                             </template>
                                                         </v-select>
                                                     </div>
                                                     <div v-else>
                                                        {{ Pasada.soldador3.codigo }}
                                                     </div>
                                                 </td>
                                                 <td v-if="Pasada.elemento_pasada == elemento_pasada">
                                                     <a  @click="RemovePasada(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a>
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
                         <div class="form-group">
                             <label>Observaciones</label>
                             <textarea v-model="observaciones" class="form-control noresize" rows="3" placeholder="" maxlength="250"></textarea>
                         </div>
                     </div>
                 </div>

                   <button class="btn btn-primary" type="submit">Guardar</button>
            </form>

         <div class="modal fade " tabindex="-1" role="dialog" id="modal-clonar" data-keyboard="false" data-backdrop="static" >
             <div class="modal-dialog modal-md" role="document">
                 <div class="modal-content">
                     <div class="modal-header">
                       <h4>Clonar Soldadores</h4>
                     </div>
                 <div class="modal-body">
                     <div class="row">
                         <div class="col-md-6 ">
                             <div class="form-group">
                                 <input type="checkbox" id="sel_todos" v-model="sel_todos_clonar" @click="SeleccionarTodosClonar" style="float:left">
                                 <label for="sel_todos" style="float:left;margin-left: 5px;">Seleccionar Todos</label>
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-12 ">
                             <div class="form-group">
                                 <div v-for="(elemento,k) in elemento_pasadas" :key="k" >

                                     <div v-if="elemento !=elemento_pasada" class="col-sm-4 col-xs-12">
                                         <input type="checkbox" :id="elemento" :value="elemento"  v-model="elemento_pasadas_a_clonar" style="float:left">
                                         <label :for="elemento" style="float:left;margin-left: 5px;">{{ elemento }}</label>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                     <button type="button" class="btn btn-primary" @click="ClonarSoldadores">
                         <i v-show="clonando_pasada" class="fa fa-spin fa-refresh"></i> Clonar
                     </button>
                 </div>
                 </div>
             </div>
         </div>


         <div class="modal fade " tabindex="-1" role="dialog" id="modal-Importar-Soldadores" data-keyboard="false" data-backdrop="static" >
             <div class="modal-dialog modal-md" role="document">
                 <div class="modal-content">
                     <div class="modal-header">
                       <h4>Importar Soldadores</h4>
                     </div>
                 <div class="modal-body">
                     <div class="row">

                         <div class="col-md-12" style="margin-top: 15px;">
                             <div class="form-group">
                                 <input style="display: inline;" type="file" multiple="false" id="sheetjs-input" :accept="SheetJSFT"  @change="onchange"/>
                                 <label  v-show="importado_pasadas" class="fa fa-spin fa-refresh" for="sheetjs-input"></label>
                                 <p>Formato soportado : csv</p>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                 </div>
                 </div>
             </div>
         </div>

         <loading
                  :active.sync="isLoading"
                  :loader="'bars'"
                  :color="'red'">
         </loading>

        </div>
    </div>
</template>

 <script>

 import uniq from 'lodash/uniq';
 import DatePicker from 'vue2-datepicker';
 import 'vue2-datepicker/index.css';
 import 'vue2-datepicker/locale/es';import {mapState} from 'vuex';
 import Loading from 'vue-loading-overlay';
 import 'vue-loading-overlay/dist/vue-loading.css';
 import moment from 'moment';
 import { toastrInfo,toastrDefault } from '../toastrConfig';
 import {isInt} from '../../functions/isInt.js';
 import {isFloat} from '../../functions/isFloat.js';

 export default {

     components: {

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
       required : false,
       default : function () { return {}}
       },
       informe_ridata : {
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
       pasada_juntas_data : {
       type : [ Array ],
       required : false
       },
     },
     data() {return {
             errors:[],
             fullPage: false,
             SheetJSFT : [
                 "xlsx", "xlsb", "xlsm", "xls", "xml", "csv", "txt", "ods", "fods", "uos", "sylk", "dif", "dbf", "prn", "qpw", "123", "wb*", "wq*", "html", "htm"
             ].map(function(x) { return "." + x; }).join(","),
            // Formulario encabezado
             reparacion_sn:false,
             obra:'',
             fecha: moment(new Date()).format('YYYY-MM-DD'),
             numero_inf:'',
             numero_inf_generado:'',
             prefijo:'',
             formato :'',
             componente:'',
             plano_isom:'',
             procedimiento:{},
             observaciones:'',
             ot_tipo_soldadura:'',
             ot_tipo_soldadura_r:'',
             tipo_soldadura:'',
             material:'',
             material2:'',
             diametro:'',
             espesor:'',
             espesor_chapa:'',
             interno_equipo:'',
             interno_fuente:'',
             kv:'',
             ma:'',
             fuente:'',
             tipo_pelicula:'',
             pantalla:'Pb',
             pos_ant: 0.10,
             pos_pos:0.10,
             lado:'',
             distancia_fuente_pelicula:'',
             norma_evaluacion:'',
             ici:'',
             norma_ensayo:'',
             tecnica:'',
             exposicion:'',
             actividad:'',
             ejecutor_ensayo:'',
             tecnicas_grafico :'',
             tecnica_distancia:'',
             index_ot_obra_tipo_soldaduras :-1,
            // Fin Formulario encabezado
            // Formulario detalle
             pk:'',
             pasada:0,
             densidad:'',
             junta:'',
             junta_reparacion:'',
             juntas_reparacion:[],
             soldador1:'',
             soldador2:'',
             soldador3:'',
             posicion:'',
             defectoObs:'',
             defectoRiPlanta:'',
             defectoRiGasoducto:'',
             posicionPlacaGosaducto:'',
             defecto_sector:'',
             indexDetalle:0,
             indexPasada:0,
             //Fin Formulario detalle

             isRX:false,
             isChapa:false,
             isGasoducto:false,
             EnableClonarPasadas:false,
             medida:'',
             cms:[],
             equipos:[],
             fuentes:[],
             tipo_peliculas:[],
             icis:[],
             tecnicas:[],
             soldadores:[],
             posiciones:[],
             defectosRiPlanta:[],
             defectosRiGasoducto:[],
             elemento_pasadas:[],
             elemento_pasadas_a_clonar:[],
             elemento_pasada:'',
             TablaDetalle:[],
             TablaPasadas:[],
             junta_posicion_selected : '',
             clonando : false,
             clonando_pasada : false,
             importado_pasadas :  false,
             parseCsv :[],
             TablaImportada :[],
             sel_todos_clonar: false,
         }},
     created : function(){

       this.$store.commit('loading', true);
       this.$store.dispatch('loadProcedimietosOtMetodo',
         { 'ot_id' : this.otdata.id, 'metodo' : this.metodo }).then(response =>{
                 if(this.procedimientos.length == 0  ){
                     toastr.options = toastrInfo;
                     toastr.info('No existe ningún procedimiento para el método de ensayo seleccionado');
                     toastr.options = toastrDefault;
                 }
         });
         this.$store.dispatch('loadMateriales');
         this.$store.dispatch('loadDiametros');
         this.$store.dispatch('loadInternoEquipos',{ 'metodo' : this.metodo, 'activo_sn' : 1, 'tipo_penetrante' : 'null' });
         this.getTipoPeliculas();
         this.$store.dispatch('loadNormaEvaluaciones');
         this.$store.dispatch('loadNormaEnsayos');
         this.getIcis();
         this.getCms();
         this.getTecnicas();
         this.$store.dispatch('loadEjecutorEnsayo', this.otdata.id);
         this.getSoldadores();
         this.getDefectosRiPlanta();
         this.pasada = 1;
         this.formato = 'PLANTA'
         this.setEdit();
     },

     mounted : function() {
          this.getNumeroInforme();
     },
 Update : function(){

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
             this.isGasoducto =  (val == 'DUCTO') ? true : false;
             this.reparacion_sn = (val == 'PLANTA') ? false : this.reparacion_sn;
         },
         pasada : function (val){
             this.soldador2 =  (val == '1') ? this.soldador2 : '';
         },

         posicionPlacaGosaducto : function(val){
             if (val != '' && this.formato =='PLANTA'){
                   this.defecto_sector = 'RAIZ' ;
             }else if(val == '')  {
                   this.defecto_sector = '' ;
             }
         },
         fuentePorInterno: function(val){

               this.fuente = val;

         },
        fecha : function(val) {
               if(this.interno_fuente){

                   this.$store.dispatch('loadCurie',{ 'interno_fuente_id' : this.interno_fuente.id, 'fecha_final': this.fecha_mysql }).then(response => {
                          this.actividad = this.curie;
                    });
               }
         },
     },
     computed :{
         ...mapState(['isLoading','url','ot_obra_tipo_soldaduras','materiales','diametros','espesores','procedimientos','norma_evaluaciones','norma_ensayos','ejecutor_ensayos','interno_equipos','fuentePorInterno','curie']),
            HabilitarClonarPasadas(){
                this.EnableClonarPasadas = (this.isGasoducto && this.pasada=='1' && this.TablaDetalle.length);
            },

            fecha_mysql : function(){
                return moment(this.fecha).format('MMMM Do YYYY, h:mm:ss a');
            },

            numero_inf_code : function()  {
                if(this.numero_inf)
                 return this.metodo + (this.numero_inf <10? '00' : this.numero_inf<100? '0' : '') + this.numero_inf ;
             },
             ot_obra_tipo_soldaduras_filter_R :function(){
                 return this.ot_obra_tipo_soldaduras.filter(item => item.codigo != 'R')
             },
             ExisteEpsReparacion : function(){
                 return (this.index_ot_obra_tipo_soldaduras != -1) ? true :  false;
             }

      },
     methods : {
         setEdit : function(){
             if(this.editmode) {

                this.formato = this.informe_ridata.gasoducto_sn ? 'DUCTO' : 'PLANTA';
                this.obra = this.informedata.obra;
                this.fecha   = this.informedata.fecha;
                this.pk = this.informedata.km;
                this.ot_tipo_soldadura = this.ot_tipo_soldaduradata;
                this.numero_inf = this.informedata.numero;
                this.componente = this.informedata.componente;
                this.material = this.materialdata;
                this.material2 = this.material2data;
                this.plano_isom = this.informedata.plano_isom;
                this.diametro = this.diametrodata;
                this.espesor = this.informedata.espesor_especifico ? {'espesor' : this.informedata.espesor_especifico} : this.diametro_espesordata;
                this.getEspesores();
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
                this.medida = { codigo : this.informe_ridata.medida };
                this.espesor_chapa = this.informedata.espesor_chapa;
                this.pos_ant = this.informe_ridata.pos_ant;
                this.pos_pos = this.informe_ridata.pos_pos;
                this.lado = this.informe_ridata.lado;
                this.exposicion = this.informe_ridata.exposicion;
                this.distancia_fuente_pelicula = this.informe_ridata.distancia_fuente_pelicula;
                this.ejecutor_ensayo = this.ejecutor_ensayodata;
                this.TablaDetalle = this.detalledata,
                this.TablaPasadas = this.pasada_juntas_data;
                this.InicializarElementosPasadas();
                this.observaciones = this.informedata.observaciones
                this.tipo_soldadura = this.ot_tipo_soldadura ? (this.ot_tipo_soldadura.tipo_soldadura.codigo) : '';
                if (this.interno_fuentedata.id != undefined){
                    this.$store.dispatch('loadCurie', { 'interno_fuente_id' : this.interno_fuentedata.id, 'fecha_final': this.informedata.fecha }).then(response => {

                          this.actividad = this.curie;
                    });
                }
                 this.$store.dispatch('loadOtObraTipoSoldaduras',{ 'ot_id' : this.otdata.id, 'obra' : this.informedata.obra }).then(res => {
                     this.reparacion_sn = this.informe_ridata.reparacion_sn == 1 ?  true : false;
                     this.index_ot_obra_tipo_soldaduras = this.ot_obra_tipo_soldaduras.findIndex(elemento => elemento.tipo_soldadura.codigo  == 'R' );
                     if(this.index_ot_obra_tipo_soldaduras != -1){
                         this.ot_tipo_soldadura_r = this.ot_obra_tipo_soldaduras[this.index_ot_obra_tipo_soldaduras];
                     }
                 });
             }else{
                 this.$store.dispatch('loadOtObraTipoSoldaduras',{ 'ot_id' : this.otdata.id, 'obra' : this.obra }).then(res =>{
                     this.index_ot_obra_tipo_soldaduras = this.ot_obra_tipo_soldaduras.findIndex(elemento => elemento.tipo_soldadura.codigo  == 'R' );
                 });
             }
         },

         cambioReparacion_sn : function(){
               if(this.reparacion_sn){

                   if(this.index_ot_obra_tipo_soldaduras != -1){
                       this.ot_tipo_soldadura_r = this.ot_obra_tipo_soldaduras[this.index_ot_obra_tipo_soldaduras];
                       this.getElementosReparacion();
                   }
               }
             this.TablaDetalle = [];
             this.TablaPasadas = [];
             this.TablaImportada= [];

         },
         setObra : function(value){
             this.obra = value;
             this.ot_tipo_soldadura='';
             this.$store.dispatch('loadOtObraTipoSoldaduras',{ 'ot_id' : this.otdata.id, 'obra' : (this.obra ? this.obra : 'xxxxxxxxxxx') }).then(res =>{

                     this.index_ot_obra_tipo_soldaduras = this.ot_obra_tipo_soldaduras.findIndex(elemento => elemento.tipo_soldadura.codigo  == 'R' );
                 });;
         },

         getCms: function(){

             axios.defaults.baseURL = this.url ;
             var urlRegistros = 'medidas/cm/' + '?api_token=' + Laravel.user.api_token;
             axios.get(urlRegistros).then(response =>{
             this.cms = response.data
             });
         },
         cambiopTipoInforme : function(){
             this.pk ='' ;
             this.ot_tipo_soldadura='';
             this.cambioOtTipoSoldadura();
             this.resetDetalle();
         },
         getElementosReparacion : function(){
             axios.defaults.baseURL = this.url ;
                 var urlRegistros = 'informes_ri/elementos_reparacion/ot/' + this.otdata.id + '/km/' + this.pk + '?api_token=' + Laravel.user.api_token;
                 axios.get(urlRegistros).then(response =>{
                 this.juntas_reparacion = response.data

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
             if(!this.isLoading){
                 this.espesor='';
                 this.distancia_fuente_pelicula='';

             }
             if(this.diametro.diametro != 'CHAPA')   {
                 this.espesor_chapa = '';
             }else{
               this.tecnica = this.tecnicas[this.tecnicas.findIndex(elemento =>elemento.codigo == 'CHAPA')];
               if(!this.isLoading){
                     this.ActualizarDistFuentePelicula();
               }
             }
             if(this.diametro){
               this.$store.commit('loading', true);
                this.$store.dispatch('loadEspesores',this.diametro.diametro_code).then(res =>{
                     this.$store.commit('loading', false);
                });
              }
         },

         cambioOtTipoSoldadura(){
             this.tipo_soldadura = this.ot_tipo_soldadura ? (this.ot_tipo_soldadura.tipo_soldadura.codigo) : '';
         },
         getFuente : function(){

             if(this.interno_equipo.interno_fuente){
                this.interno_fuente = this.interno_equipo.interno_fuente;
                this.$store.dispatch('loadFuentePorInterno',this.interno_equipo.interno_fuente.id).then(response => {
                    this.fuente = this.fuentePorInterno;
                    this.ActualizarDistFuentePelicula();
                });
                if(this.fuentePorInterno) {
                     this.$store.dispatch('loadCurie',{ 'interno_fuente_id' : this.interno_equipo.interno_fuente.id, 'fecha_final': this.fecha_mysql }).then(response => {

                         this.actividad = this.curie;

                     });
             }

             }else{
                 this.interno_fuente = '' ;
                 this.fuente ='';
                 this.actividad = '';
                 this.ActualizarDistFuentePelicula();
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
         cambioEspesor : function(){
             if(this.espesor.id != undefined) {
                  this.ActualizarDistFuentePelicula();

             }else{
           //   this.espesor.espesor = parseFloat(this.espesor.espesor);
              var match = this.espesor.espesor.match(/[+-]?([0-9]*[.])?[0-9]+?$/);
              if(!match){
                  this.espesor.espesor = 0;
              }
                 this.ActualizarDistFuentePelicula();
             }
         },
         cambioMedida : function(){

             this.medida.codigo = this.medida.codigo.replace('X','x');
             this.medida.codigo = this.medida.codigo.replace('-','x');
             let existe_alto = this.medida.codigo.includes('x');
             if(!existe_alto){
                 this.medida.codigo = '7x' + this.medida.codigo;
             }
             this.ActualizarDistFuentePelicula();
         },
         ActualizarDistFuentePelicula : function(){

                 axios.defaults.baseURL = this.url ;
                 let foco = (this.interno_fuente) ? this.interno_fuente.foco : this.interno_equipo.foco ;
                     foco = foco ? foco : 0;
                 if(this.tecnica.codigo == 'CHAPA'){
                     if(this.tecnica &&  this.medida){
                          this.$store.commit('loading', true);
                         var urlRegistros = 'tecnica_distancias/tecnica/' + this.tecnica.id + '/medida/'+ this.medida.codigo + '?api_token=' + Laravel.user.api_token;
                         axios.get(urlRegistros).then(response =>{
                             this.tecnica_distancia = response.data
                             this.distancia_fuente_pelicula=this.tecnica_distancia[0].valor;

                         }).finally(res => { this.$store.commit('loading', false); });
                     }
                 }else{
                     if(this.tecnica && this.diametro && this.espesor && foco){
                         this.$store.commit('loading', true);
                         var urlRegistros = 'tecnica_distancias/tecnica/' + this.tecnica.id + '/diametro/'+ this.diametro.diametro_code + '/espesor/' + this.espesor.espesor + '/foco/' + foco + '?api_token=' + Laravel.user.api_token;
                         axios.get(urlRegistros).then(response =>{
                             this.tecnica_distancia = response.data
                             this.distancia_fuente_pelicula=this.tecnica_distancia[0].valor;
                         }).finally(res => { this.$store.commit('loading', false); });
                     }

                 }
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
             this.TablaPasadas = [];
             this.TablaImportada= [];
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
         async getSoldadores(){
                 axios.defaults.baseURL = this.url ;
                 var urlRegistros = 'ot_soldadores/ot/' + this.otdata.id + '?api_token=' + Laravel.user.api_token;
                 await axios.get(urlRegistros).then(response =>{
                 this.soldadores = response.data
                 });

         },
         getDefectosRiPlanta : function(){
                 axios.defaults.baseURL = this.url ;
                 var urlRegistros = 'defectos_ri/planta/' + '?api_token=' + Laravel.user.api_token;
                 axios.get(urlRegistros).then(response =>{
                 this.defectosRiPlanta = response.data
             }).finally(res => { this.$store.commit('loading', false); });

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
         InicializarElementosPasadas : function(){
             this.detalledata.forEach(function(item) {
                 this.addElementosPasadas(item.junta);
             }.bind(this));
         },
         AddDetalle (posicion) {

             if( (this.reparacion_sn && this.junta_reparacion == '') ||(!this.reparacion_sn && this.junta == '') ){
                  toastr.error('Campo Elemento es obligatorio');
                  return;
             }else if(this.posicion == '' && this.clonando == false) {
                  toastr.error('Campo posición es obligatorio');
                   return;
             }else if (this.densidad == ''){
                     toastr.error('Campo densidad es obligatorio');
                                 return;
             }

             let aux_junta = this.reparacion_sn ? this.junta_reparacion.codigo + 'R' :  this.junta;
             this.addElementosPasadas(aux_junta);
             this.TablaDetalle.push({
                 junta: aux_junta,
                 densidad : this.densidad,
                 posicion : (typeof(posicion) !== 'undefined') ? posicion : this.posicion,
                 aceptable_sn : 1 ,
                 observacion : '',
                 defectos : []
             });

         },
         addElementosPasadas : function(aux_junta){
             let index = this.elemento_pasadas.findIndex(elemento => elemento == aux_junta);

             if(index == -1){
                 this.elemento_pasadas.push(aux_junta);
             }
         },
         autocompletarNumeroPasada : function(){
             let cant_pasadas =  this.contarPasadaElemento(this.elemento_pasada);
             this.pasada = cant_pasadas + 1 ;
         },

         contarPasadaElemento: function(elemento){
             let cant = 0;
             this.TablaPasadas.forEach(function(item){
                 if(elemento == item.elemento_pasada){
                     cant++;
                 }
             }.bind(this));
             return cant;
         },
         AddPasadas () {
             if(this.elemento_pasada == ''){

                 toastr.error('Error :El elemento es obligatorio para ingresar la/s pasadas');
                 return;

             }
             let cant_pasadas =  this.contarPasadaElemento(this.elemento_pasada);
             if(this.formato == 'PLANTA'){
                 if(cant_pasadas >= 1) {
                     toastr.error('Error : Formato PLANTA  acepta 1 pasada');
                     return;
                 }
             }
             if(this.formato == 'DUCTO'){
                 if(cant_pasadas >= 6) {
                     toastr.error('Error : Formato DUCTO acepta 6 pasadas');
                      return;
                 }
             }

             if(this.soldador1) {
                 this.TablaPasadas.push({
                     elemento_pasada : this.elemento_pasada,
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

             if(this.posicionPlacaGosaducto !=''){

                let exp_posicion = /^[0-9]{1,3}-[0-9]{1,3}$/ ;
                if(!exp_posicion.test(this.posicionPlacaGosaducto)){
                    toastr.error('El formato ingresado no es válido');
                    return;
                }

                let str_pos_defecto = this.posicionPlacaGosaducto.split("-");
                let pos_inicial_defecto = parseInt(str_pos_defecto[0].trim());
                let pos_final_defecto = parseInt(str_pos_defecto[1].trim());

                if ((pos_final_defecto <  pos_inicial_defecto) && (pos_inicial_defecto > 0 && pos_final_defecto != 0)){
                    toastr.error('Valores en posición indicación incorrectos');
                    return;
                }

                let str_pos_placa = this.TablaDetalle[this.indexDetalle].posicion.split("-");
                let pos_inicial_placa = parseInt(str_pos_placa[0].trim());
                let pos_final_placa = parseInt(str_pos_placa[1].trim());

                let longitud_placa = parseInt(this.TablaDetalle[0].posicion.split("-")[1].trim());

                if(! ( ((pos_inicial_defecto >= pos_inicial_placa && (pos_final_defecto <= (pos_inicial_placa + longitud_placa))) || ((pos_inicial_defecto == pos_inicial_placa) && (pos_final_defecto == pos_final_placa ))))) {
                    toastr.error('Valores en posición indicación incorrectos');
                    return;
                }
             }

             if(this.posicionPlacaGosaducto !='' && !this.defecto_sector){
                     toastr.error('El campo pasada es obligatorio si existe posicion indicación');
                     return;
             }

             this.TablaDetalle[this.indexDetalle].defectos.push({
                 codigo: this.defectoRiPlanta.codigo,
                 pasada: this.defecto_sector,
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
            let junta = this.TablaDetalle[index].junta;
            this.TablaDetalle.splice(index, 1);
            if(this.TablaDetalle.findIndex(elemento => elemento.junta == junta) == -1){

                this.TablaPasadas = this.TablaPasadas.filter(function(item){

                    return  item.elemento_pasada != junta;

                 });
             this.elemento_pasada = '';

             this.elemento_pasadas = this.elemento_pasadas.filter(function(item2){

                 return  item2 != junta;
             });

            }

         },
         RemovePasada(index) {
             this.indexPasada = 0;
             this.TablaPasadas.splice(index, 1);
         },
         RemoveDefectos(index) {

             this.TablaDetalle[this.indexDetalle].defectos.splice(index, 1);
             let aceptable = true;
             this.TablaDetalle[this.indexDetalle].defectos.forEach(function(defecto){
                 if(defecto.posicion !=''){
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
         SeleccionarTodosClonar: function(){
             this.elemento_pasadas_a_clonar = [];
             if(!this.sel_todos_clonar){
                 this.elemento_pasadas.forEach(function(item){

                     if(item != this.elemento_pasada){
                         this.elemento_pasadas_a_clonar.push(item);
                     }

                 }.bind(this));
             }
         },
         ModalClonarSoldadores: function(){

            this.elemento_pasadas_a_clonar = [];
            this.sel_todos_clonar = false;
            if(this.elemento_pasada){
                $('#modal-clonar').modal('show');
            }
         },

         ModalImportarSoldadores : function(){

             document.getElementById("sheetjs-input").value = "";
             $('#modal-Importar-Soldadores').modal('show');
         },
         selectPosPasadas : function(index){
             this.indexPasada = index ;

         },
         ClonarSoldadores : function(){
             this.clonando_pasada = true;
             /* Borro las pasadas de los elementos seleccionados que vamos a clonar*/
             this.elemento_pasadas_a_clonar.forEach(function(item_a_clonar){
                this.TablaPasadas = this.TablaPasadas.filter(function(item_tabla_pasada){
                   return  item_tabla_pasada.elemento_pasada != item_a_clonar;
                 })
             }.bind(this))
             let TablaAClonar = [];
             this.TablaPasadas.forEach(function(item){
                 if(item.elemento_pasada == this.elemento_pasada){
                     TablaAClonar.push(item);
                 }
             }.bind(this))
             console.log(TablaAClonar);
             this.elemento_pasadas_a_clonar.forEach(function(item_a_clonar){
                  TablaAClonar.forEach(function(item){

                     this.TablaPasadas.push({
                         elemento_pasada : item_a_clonar,
                         pasada : item.pasada,
                         soldador1 :  item.soldador1,
                         soldador2 :  item.soldador2,
                         soldador3 :  item.soldador3,

                     });
                 }.bind(this))
             }.bind(this))
            this.clonando_pasada = false;
            $('#modal-clonar').modal('hide');
         },
         onchange: function(evt) {
             this.importado_pasadas = true;
             var file;
             var files = evt.target.files;
             if (!files || files.length == 0) return;
             file = files[0];
             var reader = new FileReader();
             reader.onload = function (e) {

                 var binary = "";
                 var bytes = new Uint8Array(e.target.result);
                 var length = bytes.byteLength;
                 for (var i = 0; i < length; i++) {
                     binary += String.fromCharCode(bytes[i]);
                 }

                 var wb = XLSX.read(binary, {type: 'binary'});
                 var wsname = wb.SheetNames[0];
                 var ws = wb.Sheets[wsname];
                 var ws_f = wb.Sheets[wsname];
                 this.TablaImportada = XLSX.utils.sheet_to_json(ws_f,{header:["1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16"],defval:''});
                 this.TablaPasadas = [];
                 console.log(this.TablaImportada);
                 this.copiarImportacion();

             }.bind(this);
             reader.readAsArrayBuffer(file);

         },

         async  StoreSoldadores(){
             let soldadores_importados = [];
             this.TablaImportada.forEach(function(item,index){
                 if(index > 2){
                     if((item['1'] == this.pk) && (this.elemento_pasadas.findIndex(elemento => elemento == item['2'])!= -1 ) && (item['3']==this.ot_tipo_soldadura.codigo)){
                         soldadores_importados.push(item['4']);
                         soldadores_importados.push(item['5']);
                         soldadores_importados.push(item['6']);
                         soldadores_importados.push(item['7']);
                         soldadores_importados.push(item['8']);
                         soldadores_importados.push(item['9']);
                         soldadores_importados.push(item['10']);
                         soldadores_importados.push(item['11']);
                         soldadores_importados.push(item['12']);
                         soldadores_importados.push(item['13']);
                         soldadores_importados.push(item['14']);
                         soldadores_importados.push(item['15']);
                         soldadores_importados.push(item['16']);

                     }
                 }
             }.bind(this));
             console.log('Soldadores Importados :' ,soldadores_importados);
             axios.defaults.baseURL = this.url ;
             var urlRegistros = 'ot_soldadores/insertar_importados/ot/' + this.otdata.id + '/cliente/' + this.otdata.cliente_id + '?api_token=' + Laravel.user.api_token;

             try{
                 let res = await axios.post(urlRegistros,{

                     'soldadores_importados' : soldadores_importados,

                 });
                 return true;

             } catch (error){
                 toastr.error('Ocurrio un error al importar los soldadores');
                 return false;
             }

         },
         async copiarImportacion(){
           let resul_store_soldadores =  await this.StoreSoldadores();
           if(resul_store_soldadores) {

                 await this.getSoldadores();
                 this.TablaImportada.forEach(function(item,index){

                     if(index > 2){
                             if((item['1'] == this.pk) && (this.elemento_pasadas.findIndex(elemento => elemento == item['2'])!= -1 ) && (item['3']==this.ot_tipo_soldadura.codigo)){
                                 let index_soldador1_p1 = this.soldadores.findIndex(elemento => elemento.codigo == item['4']);
                                 let index_soldador2_p1 = this.soldadores.findIndex(elemento => elemento.codigo == item['5']);
                                 let index_soldador3_p1 = this.soldadores.findIndex(elemento => elemento.codigo == item['6']);
                                 let index_soldador1_p2 = this.soldadores.findIndex(elemento => elemento.codigo == item['7']);
                                 let index_soldador3_p2 = this.soldadores.findIndex(elemento => elemento.codigo == item['8']);
                                 let index_soldador1_p3 = this.soldadores.findIndex(elemento => elemento.codigo == item['9']);
                                 let index_soldador3_p3 = this.soldadores.findIndex(elemento => elemento.codigo == item['10']);
                                 let index_soldador1_p4 = this.soldadores.findIndex(elemento => elemento.codigo == item['11']);
                                 let index_soldador3_p4 = this.soldadores.findIndex(elemento => elemento.codigo == item['12']);
                                 let index_soldador1_p5 = this.soldadores.findIndex(elemento => elemento.codigo == item['13']);
                                 let index_soldador3_p5 = this.soldadores.findIndex(elemento => elemento.codigo == item['14']);
                                 let index_soldador1_p6 = this.soldadores.findIndex(elemento => elemento.codigo == item['15']);
                                 let index_soldador3_p6 = this.soldadores.findIndex(elemento => elemento.codigo == item['16']);
                                 /*Pasada 1 */
                                 if(item['4']!=''){
                                     let aux_soldador1 = (index_soldador1_p1 != -1) ? this.soldadores[index_soldador1_p1] : '';
                                     let aux_soldador2 = (index_soldador2_p1 != -1) ? this.soldadores[index_soldador2_p1] : '';
                                     let aux_soldador3 = (index_soldador3_p1 != -1) ? this.soldadores[index_soldador3_p1] : '';
                                     this.TablaPasadas.push({

                                         elemento_pasada :item['2'],
                                         pasada : 1,
                                         soldador1 :  aux_soldador1,
                                         soldador2 :  aux_soldador2,
                                         soldador3 :  aux_soldador3,

                                     });
                                     /*Pasada 2 */
                                     if(item['7']!=''){
                                             aux_soldador1 = (index_soldador1_p2 != -1) ? this.soldadores[index_soldador1_p2] : '';
                                             aux_soldador3 = (index_soldador3_p2 != -1) ? this.soldadores[index_soldador3_p2] : '';
                                             this.TablaPasadas.push({

                                                 elemento_pasada :item['2'],
                                                 pasada : 2,
                                                 soldador1 :  aux_soldador1,
                                                 soldador2 :  '',
                                                 soldador3 :  aux_soldador3,

                                             });

                                             /*Pasada 3 */
                                             if(item['9']!=''){
                                                     aux_soldador1 = (index_soldador1_p3 != -1) ? this.soldadores[index_soldador1_p3] : '';
                                                     aux_soldador3 = (index_soldador3_p3 != -1) ? this.soldadores[index_soldador3_p3] : '';
                                                     this.TablaPasadas.push({

                                                         elemento_pasada :item['2'],
                                                         pasada : 3,
                                                         soldador1 :  aux_soldador1,
                                                         soldador2 :  '',
                                                         soldador3 :  aux_soldador3,

                                                     });
                                                 }
                                                 /*Pasada 4 */
                                                 if(item['11']!=''){
                                                         aux_soldador1 = (index_soldador1_p4 != -1) ? this.soldadores[index_soldador1_p4] : '';
                                                         aux_soldador3 = (index_soldador3_p4 != -1) ? this.soldadores[index_soldador3_p4] : '';
                                                         this.TablaPasadas.push({

                                                             elemento_pasada :item['2'],
                                                             pasada : 4,
                                                             soldador1 :  aux_soldador1,
                                                             soldador2 :  '',
                                                             soldador3 :  aux_soldador3,

                                                         });
                                                     }
                                                 /*Pasada 5 */
                                                 if(item['13']!=''){
                                                         aux_soldador1 = (index_soldador1_p5 != -1) ? this.soldadores[index_soldador1_p5] : '';
                                                         aux_soldador3 = (index_soldador3_p5 != -1) ? this.soldadores[index_soldador3_p5] : '';
                                                         this.TablaPasadas.push({

                                                             elemento_pasada :item['2'],
                                                             pasada : 5,
                                                             soldador1 :  aux_soldador1,
                                                             soldador2 :  '',
                                                             soldador3 :  aux_soldador3,

                                                         });
                                                     }
                                                     /*Pasada 6 */
                                                     if(item['15']!=''){
                                                             aux_soldador1 = (index_soldador1_p6 != -1) ? this.soldadores[index_soldador1_p6] : '';
                                                             aux_soldador3 = (index_soldador3_p6 != -1) ? this.soldadores[index_soldador3_p6] : '';
                                                             this.TablaPasadas.push({

                                                                 elemento_pasada :item['2'],
                                                                 pasada : 6,
                                                                 soldador1 :  aux_soldador1,
                                                                 soldador2 :  '',
                                                                 soldador3 :  aux_soldador3,

                                                             });
                                                         }
                                         }
                                 }
                             }

                         }
                 }.bind(this))

                 if(this.elemento_pasadas.length > 0){

                     this.elemento_pasada = this.elemento_pasadas[0];
                 }
                 toastr.info('Los soldadores no encontrados fueron agregados al sistema automaticamente.');
                 $('#modal-Importar-Soldadores').modal('hide');
           }
           this.importado_pasadas = false;
         },
         Store : function(){
                     this.errors =[];
                     let gasoducto_sn ;
                     if(this.formato =='DUCTO')
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
                         'obra'            : this.obra,
                         'ejecutor_ensayo' : this.ejecutor_ensayo,
                         'metodo_ensayo'   : this.metodo,
                         'fecha':          this.fecha,
                         'numero_inf':     this.numero_inf,
                         'pk':             this.pk,
                         'ot_tipo_soldadura' : this.ot_tipo_soldadura,
                         'reparacion_sn'     :this.reparacion_sn,
                         'prefijo'        :this.prefijo,
                         'gasoducto_sn' :  gasoducto_sn,
                         'componente' :    this.componente,
                         'plano_isom' :    this.plano_isom,
                         'procedimiento' : this.procedimiento,
                         'observaciones':  this.observaciones,
                         'material':       this.material,
                         'material2':      this.material2,
                         'diametro':       this.diametro,
                         'espesor':        this.espesor,
                         'espesor_chapa' :  this.espesor_chapa,
                         'interno_equipo'   :  this.interno_equipo,
                         'kv'               :this.kv,
                         'ma'               :this.ma,
                         'interno_fuente' :this.interno_fuente,
                         'tipo_pelicula' : this.tipo_pelicula,
                         'medida'        : this.medida,
                         'pantalla':       this.pantalla,
                         'pos_ant':        this.pos_ant,
                         'pos_pos':       this.pos_pos,
                         'lado':          this.lado,
                         'distancia_fuente_pelicula': this.distancia_fuente_pelicula,
                         'norma_evaluacion': this.norma_evaluacion,
                         'ici': this.ici,
                         'norma_ensayo': this.norma_ensayo,
                         'tecnica':this.tecnica,
                         'tecnicas_grafico' : this.tecnica_grafico,
                         'exposicion': this.exposicion,
                         'detalles'  : this.TablaDetalle,
                         'TablaPasadas' : this.TablaPasadas,
                 }}


                 ).then(response => {
                     let informe = response.data;
                     toastr.success('informe N°' + this.numero_inf + ' fue creado con éxito ');
                     window.open(  '/pdf/informe/ri/' + informe.id,'_blank');
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
                     let gasoducto_sn ;
                     if(this.formato =='DUCTO')
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
                         'updated_at'      : this.informedata.updated_at,
                         'obra'            : this.obra,
                         'ejecutor_ensayo' : this.ejecutor_ensayo,
                         'metodo_ensayo'   : this.metodo,
                         'fecha':          this.fecha,
                         'numero_inf':     this.numero_inf,
                         'pk':             this.pk,
                         'ot_tipo_soldadura' : this.ot_tipo_soldadura,
                         'reparacion_sn'     :this.reparacion_sn,
                         'prefijo'        :this.prefijo,
                         'gasoducto_sn' :  gasoducto_sn,
                         'componente' :    this.componente,
                         'plano_isom' :    this.plano_isom,
                         'procedimiento' : this.procedimiento,
                         'observaciones':  this.observaciones,
                         'material':       this.material,
                         'material2':      this.material2,
                         'diametro':       this.diametro,
                         'espesor':        this.espesor,
                         'espesor_chapa'    :this.espesor_chapa,
                         'interno_equipo'   :this.interno_equipo,
                         'kv'               :this.kv,
                         'ma'               :this.ma,
                         'interno_fuente' :this.interno_fuente,
                         'tipo_pelicula' : this.tipo_pelicula,
                         'medida'        : this.medida,
                         'pantalla':       this.pantalla,
                         'pos_ant':        this.pos_ant,
                         'pos_pos':       this.pos_pos,
                         'lado':          this.lado,
                         'distancia_fuente_pelicula': this.distancia_fuente_pelicula,
                         'norma_evaluacion': this.norma_evaluacion,
                         'ici': this.ici,
                         'norma_ensayo': this.norma_ensayo,
                         'tecnica':this.tecnica,
                         'tecnicas_grafico' : this.tecnica_grafico,
                         'exposicion': this.exposicion,
                         'detalles'  : this.TablaDetalle,
                         'TablaPasadas' : this.TablaPasadas,

                 }}


                 ).then( () => {
                     toastr.success('informe N°' + this.numero_inf + ' fue actualizado con éxito ');
                     window.open(  '/pdf/informe/ri/' + this.informedata.id,'_blank');
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
 .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
      background-color: #eee;
 }
 .checkbox-inline {
     margin-left: 0px;
 }
 @media (max-width: 767px) {
     .table-responsive .dropdown-menu {
         position: static !important;
     }
 }
 @media (min-width: 768px) {
     .table-responsive {
         overflow: inherit;
     }
 }


 </style>
