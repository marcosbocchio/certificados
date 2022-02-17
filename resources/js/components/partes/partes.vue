<template>
 <div class="row">
       <div class="col-md-12">
            <form @submit.prevent="editmode ?  Update() : Store()"  method="post">
                <parte-header :otdata="otdata" @set-obra="setObra($event)" ></parte-header>
                 <div class="box box-custom-enod">
                    <div class="box-body">
                        <div class="col-md-4s col-lg-3">
                            <div class="form-group">
                                <label for="fecha">Fecha *</label>
                                <input type="checkbox" id="checkbox_f" v-model="permitir_anteriores_sn" style="float:right">
                                <label for="tipo" style="float:right;margin-right: 5px;">Permitir Anteriores</label>
                                <div>
                                    <date-picker v-model="fecha" value-type="YYYY-MM-DD" format="DD-MM-YYYY" placeholder="DD-MM-YYYY" ></date-picker>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="tipo_servicio">Tipo Servicio *</label>
                                <v-select type="text" v-model="tipo_servicio"  id="tipo_servicio" :options="['Diurno', 'Nocturno']" ></v-select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="horario">Horario *</label>
                                <input type="text" v-model="horario" class="form-control" maxlength="5" id="horario" v-on:keyup="FormatearHorario" placeholder="HH-HH">
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-3">
                            <div class="form-group" >
                               <label style="display: block;"></label>
                                <input type="checkbox" id="checkbox" v-model="movilidad_propia_sn" >
                                <label for="tipo" style="float: left;;margin-right: 5px;">Movilidad Propia</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="movilidad_propia_sn">
                    <div class="box box-custom-enod">
                        <div class="box-header with-border">
                            <h3 class="box-title">Vehículos</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="col-md-3">
                                <div class="form-group" >
                                    <label for="vehiculos">Vehículos</label>
                                    <v-select  v-model="vehiculo" :options="vehiculos" label="nro_interno">
                                        <template slot="option" slot-scope="option">
                                            <span class="upSelect">{{ option.nro_interno }} </span> <br>
                                            <span class="downSelect"> {{ option.marca }} - {{ option.patente }} </span>
                                        </template>
                                    </v-select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" >
                                    <label for="km_inicial">Km Inicial </label>
                                    <input type="number" v-model="km_inicial" class="form-control" id="km_inicial" min="0" step="0.1" >
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" >
                                    <label for="km_final">Km Final </label>
                                    <input type="number" v-model="km_final" class="form-control" id="km_final" min="0" step="0.1">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <p>&nbsp;</p>
                                    <span>
                                    <button type="button" @click="addVehiculo()"><span class="fa fa-plus-circle"></span></button>
                                    </span>
                                </div>
                            </div>
                            <div v-show="TablaVehiculos.length">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped table-condensed table-condensed">
                                        <thead>
                                            <tr>
                                                <th class="col-md-1">Nº Int</th>
                                                <th class="col-md-2">Marca</th>
                                                <th class="col-md-2">Modelo</th>
                                                <th class="col-md-1">Patente</th>
                                                <th class="col-md-1">Tipo</th>
                                                <th class="col-md-1">Km Inicial</th>
                                                <th class="col-md-1">Km Final</th>
                                                <th class="col-md-1">&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item,k) in TablaVehiculos" :key="k">
                                                <td> {{ item.vehiculo.nro_interno}}</td>
                                                <td> {{ item.vehiculo.marca}}</td>
                                                <td> {{ item.vehiculo.modelo}}</td>
                                                <td> {{ item.vehiculo.patente}}</td>
                                                <td> {{ item.vehiculo.tipo}}</td>
                                                <td> {{ item.km_inicial}}</td>
                                                <td> {{ item.km_final}}</td>
                                                <td style="text-align:center"> <a  @click="RemoveVehiculo(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a></td>
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
                    <div class="box-header with-border">
                        <h3 class="box-title">Responsabilidades</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="km_final">Operador </label>
                                <v-select type="text" v-model="operador" id="responsable" label="name" :options="operadores" @input="setResponsabilidad()"></v-select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="responsabilidad">Responsabilidad </label>
                                <input type="text" v-model="responsabilidad" class="form-control" id="responsabilidad">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                 <p>&nbsp;</p>
                                <span>
                                  <button type="button" @click="addResponsable(operador.id)"><span class="fa fa-plus-circle"></span></button>
                                </span>
                            </div>
                        </div>
                        <div v-show="TablaResponsables.length">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped table-condensed table-condensed">
                                    <thead>
                                        <tr>
                                            <th class="col-md-7">Operador</th>
                                            <th class="col-md-4">Responsabilidad</th>
                                            <th class="col-md-1">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item,k) in TablaResponsables" :key="k">
                                            <td> {{ item.user.name}}</td>
                                            <td> {{ item.responsabilidad}}</td>
                                            <td style="text-align:center"> <a  @click="RemoveResponsable(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a></td>
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
                    <h3 class="box-title">Informes sin parte diario</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-condensed table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Sel.</th>
                                            <th>Tipo</th>
                                            <th>Informe</th>
                                            <th>Obra</th>
                                            <th>Planta</th>
                                            <th>Fecha</th>
                                            <th>Solicitante</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(informe,k) in informes" :key="k">
                                            <td>
                                                <input type="checkbox" id="informe_sel" v-model="informes[k].informe_sel" @click="selectPosTablaInformesSinParteDiario(k)" @change="getInforme(k)" :disabled="deshabilitarInformes(informe.fecha_formateada,informe.obra,informe.informe_sel) || loading">
                                            </td>
                                            <td> {{ informe.metodo}}</td>
                                            <td> {{ informe.numero_formateado}}</td>
                                            <td> {{ informe.obra}}</td>
                                            <td> {{ informe.planta}}</td>
                                            <td> {{ informe.fecha_formateada}}</td>
                                            <td>
                                               <div v-if="informe.solicitado_por">
                                                   {{ informe.solicitado_por.name }}
                                               </div>
                                                <div v-else>
                                                    &nbsp;
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                 <!-- Servicios  -->
                    <div class="box box-custom-enod" >
                        <div class="box-header with-border">
                            <div class="col-md-3">
                                <h3 class="box-title">Servicios </h3>
                            </div>

                            <div class="form-group">
                                <label style="color:gray;display: inline-block;font-weight: lighter;font-style: oblique;text-align:right" class="col-md-3 control-label"><span> Agregar Servicios Manualmente</span></label>
                                <div class="col-md-5">
                                      <v-select v-model="servicio_manual" label="servicio_descripcion" :options="serviciosOt" id="serviciosOt"></v-select>
                                 </div>
                                 <div class="col-md-1">
                                     <button type="button" @click="AddServicioManual()"><span class="fa fa-plus-circle"></span></button>
                                </div>
                              </div>

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
                                                <th class="col-md-1">Método</th>
                                                <th class="col-md-9">Descripción</th>
                                                <th class="col-md-1">Cant.</th>
                                                <th class="col-md-1">&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item,k) in TablaServicios" :key="k"  @click="selectPosTablaServicios(k)">
                                                <td v-if="item.visible"> {{ item.metodo}}</td>
                                                <td v-if="item.visible"> {{ item.servicio_descripcion}}</td>
                                                <td v-if="item.visible">
                                                    <div v-if="indexTablaServicios == k ">
                                                        <input type="number" v-model.number="TablaServicios[k].cant_final" maxlength="3" step="0.01" min="0" @change="validarCantidad(TablaServicios,k,'cant_final')">
                                                    </div>
                                                    <div v-else>
                                                        {{ item.cant_final }}
                                                    </div>
                                                </td>
                                                <td style="text-align:center" v-if="item.visible"> <a  @click="RemoveTablaServicio(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a></td>

                                            </tr>
                                            <tr v-for="fila in 4" >
                                                <td colspan="5" style="background: #FFFFFF"> &nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

                  <!--Informe RI -->
                <div v-show="TablaInformesRi.length">
                    <div class="box box-custom-enod" >
                        <div class="box-header with-border">
                        <h3 class="box-title">Informes RI</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">

                    <div class="col-sm-3">
                        <div class="form-group">
                            <p>&nbsp;</p>
                            <label style="color:gray;display: inline-block;font-weight: lighter;font-style: oblique;text-align:right" class="control-label"><span> Agregar costuras Manualmente</span></label>
                        </div>
                    </div>

                        <div class="col-sm-2">
                            <div class="form-group" >
                                <label for="costura_adicional">Costura *</label>
                                <input type="number" v-model.number="costura_adicional" class="form-control" id="costura_adicional" maxlength="4" min="0">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group" >
                                <label for="pulgada_adicional">Pulgada *</label>
                                <v-select v-model="pulgada_adicional" label="diametro" :options="diametros"></v-select>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group" >
                                <label for="placa_adicional">Placas *</label>
                                <input type="number" v-model.number="placa_adicional" class="form-control" id="placa_adicional" maxlength="4" step="0.1" min="0">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group" >
                                <label for="cm_adicional">CM *</label>
                                <v-select type="text" v-model="cm_adicional" label="codigo" id="cm" :options="medidas_placa" style="display: block" taggable  @input="cambioMedida"></v-select>

                            </div>
                        </div>
                    <div class="col-sm-1">
                            <p>&nbsp;</p>
                            <button type="button" @click="AddCosturaAdicional()" title="Agregar Junta/Posición"><app-icon img="plus-circle" color="black"></app-icon></button>
                    </div>
                            <div class="clearfix"></div>

                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped table-bordered table-condensed">
                                            <thead>
                                                <tr>
                                                    <th class="col-md-2">Informe</th>
                                                    <th class="col-md-3">Costuras</th>
                                                    <th class="col-md-3">Pulgadas</th>
                                                    <th class="col-md-3">Placas</th>
                                                    <th class="col-md-1">CM</th>
                                                    <th>&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item,k) in TablaInformesRi" :key="k"  @click="selectPosTablaInformesRi(k)">
                                                    <td v-if="item.visible"> {{ item.numero_formateado}}</td>

                                                    <td v-if="item.visible">

                                                        <div v-if="indexTablaInformesRi == k ">
                                                          <input type="number" v-model.number="TablaInformesRi[k].costura_final" maxlength="4"  @change="validarCantidad(TablaInformesRi,k,'costura_final')">
                                                        </div>
                                                        <div v-else>
                                                           {{ item.costura_final }}
                                                        </div>
                                                    </td>

                                                    <td v-if="item.visible"> {{ item.pulgadas_final}}</td>
                                                    <td v-if="item.visible">
                                                        <div v-if="indexTablaInformesRi == k ">
                                                          <input type="number" v-model.number="TablaInformesRi[k].placas_final" maxlength="4" step="0.1" @input="RecalcularMetros('RI')"  @change="validarCantidad(TablaInformesRi,k,'placas_final')">
                                                        </div>
                                                        <div v-else>
                                                           {{ item.placas_final }}
                                                        </div>
                                                    </td>
                                                    <td  v-if="item.visible">
                                                         {{ item.cm_final }}
                                                    </td>
                                                    <td style="text-align:center" v-if="item.visible"> <a  @click="RemoveTablaInformeRi(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a></td>

                                                </tr>
                                                <tr v-for="fila in 4" >
                                                    <td colspan="6" style="background: #FFFFFF"> &nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group" >
                                        <label for="placas_repetidas">Placas Repetidas Total *</label>
                                        <input type="number" v-model="placas_repetidas" class="form-control" id="placas_repetidas" min="0">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group" >
                                        <label for="placas_testigos">Placas Testigos Total *</label>
                                        <input type="number" v-model="placas_testigos" class="form-control" id="placas_testigos" min="0">
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
                <!--Informe Pm -->
                <div v-show="TablaInformesPm.length">
                    <div class="box box-custom-enod" >
                        <div class="box-header with-border">
                        <h3 class="box-title">Informes PM</h3>

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
                                                    <th>Informe</th>
                                                    <th>Componente</th>
                                                    <th>Diámetro</th>
                                                    <th colspan="2">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item,k) in TablaInformesPm" :key="k">
                                                    <td> {{ item.numero_formateado}}</td>
                                                    <td>
                                                        <div >
                                                           {{ item.componente }}
                                                        </div>
                                                    </td>
                                                    <td >
                                                        <div >
                                                           {{ item.diametro_especifico ? item.diametro_especifico : item.diametro }}
                                                        </div>
                                                    </td>
                                                    <td style="text-align:center"> <a  @click="RemoveTablaPm(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a></td>
                                                </tr>
                                                <tr v-for="fila in 4" >
                                                    <td colspan="6" style="background: #FFFFFF"> &nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
                <!--Informe Lp -->
                <div v-show="TablaInformesLp.length">
                    <div class="box box-custom-enod" >
                        <div class="box-header with-border">
                        <h3 class="box-title">Informes LP</h3>

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
                                                    <th>Informe</th>
                                                    <th>Componente</th>
                                                    <th>Diámetro</th>
                                                    <th colspan="2">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item,k) in TablaInformesLp" :key="k" >
                                                    <td> {{ item.numero_formateado}}</td>
                                                    <td>
                                                        <div >
                                                           {{ item.componente }}
                                                        </div>
                                                    </td>
                                                    <td >
                                                        <div >
                                                           {{ item.diametro_especifico ? item.diametro_especifico : item.diametro }}
                                                        </div>
                                                    </td>
                                                    <td style="text-align:center"> <a  @click="RemoveTablaLp(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a></td>
                                                </tr>
                                                <tr v-for="fila in 4" >
                                                    <td colspan="6" style="background: #FFFFFF"> &nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
                <!--Informe Us -->
                <div v-show="TablaInformesUs.length">
                    <div class="box box-custom-enod" >
                        <div class="box-header with-border">
                        <h3 class="box-title">Informes US</h3>

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
                                                    <th class="col-md-3">Informe</th>
                                                    <th class="col-md-3">Elemento</th>
                                                    <th class="col-md-3">Diametro</th>
                                                    <th class="col-md-3">CM</th>
                                                    <th>&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item,k) in TablaInformesUs" :key="k"  @click="selectPosTablaInformesUs(k)">

                                                    <td v-if="item.visible"> {{ item.numero_formateado}}</td>

                                                    <td v-if="item.visible">
                                                        <div v-if="(item.tecnica =='ME')">
                                                            <div v-if="indexTablaInformesUs == k ">
                                                                <input type="text" v-model="TablaInformesUs[k].pieza_final" maxlength="10">
                                                            </div>
                                                            <div v-else>
                                                                {{ item.pieza_final }}
                                                            </div>
                                                        </div>
                                                        <div v-else>
                                                             {{ item.pieza_final }}
                                                        </div>

                                                    </td>

                                                    <td v-if="item.visible"> {{ item.pulgadas_final}}</td>

                                                    <td v-if="item.visible">
                                                        <div v-if="indexTablaInformesUs == k ">
                                                          <input type="number" v-model="TablaInformesUs[k].cm_final" maxlength="4" @input="RecalcularMetros('US')">
                                                        </div>
                                                        <div v-else>
                                                           {{ item.cm_final }}
                                                        </div>
                                                    </td>
                                                    <td style="text-align:center" v-if="item.visible"> <a  @click="RemoveTablaInformeUs(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a></td>
                                                </tr>
                                                <tr v-for="fila in 4" >
                                                    <td colspan="6" style="background: #FFFFFF"> &nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
                <!--Informe CV -->
                <div v-show="TablaInformesCv.length">
                    <div class="box box-custom-enod" >
                        <div class="box-header with-border">
                        <h3 class="box-title">Informes CV</h3>

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
                                                    <th>Informe</th>
                                                    <th>Componente</th>
                                                    <th>Diámetro</th>
                                                    <th colspan="2">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item,k) in TablaInformesCv" :key="k">
                                                    <td> {{ item.numero_formateado}}</td>
                                                    <td>
                                                        <div >
                                                           {{ item.componente }}
                                                        </div>
                                                    </td>
                                                    <td > N/A </td>
                                                    <td style="text-align:center"> <a  @click="RemoveTablaCv(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a></td>
                                                </tr>
                                                <tr v-for="fila in 4" >
                                                    <td colspan="6" style="background: #FFFFFF"> &nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
                <!--Informe Dz -->
                <div v-show="TablaInformesDz.length">
                    <div class="box box-custom-enod" >
                        <div class="box-header with-border">
                        <h3 class="box-title">Informes DZ</h3>

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
                                                    <th>Informe</th>
                                                    <th>Componente</th>
                                                    <th>Diámetro</th>
                                                    <th colspan="2">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item,k) in TablaInformesDz" :key="k">
                                                    <td> {{ item.numero_formateado}}</td>
                                                    <td>
                                                        <div>
                                                           {{ item.componente }}
                                                        </div>
                                                    </td>
                                                    <td > N/A </td>
                                                    <td style="text-align:center"> <a  @click="RemoveTablaDz(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a></td>
                                                </tr>
                                                <tr v-for="fila in 4" >
                                                    <td colspan="6" style="background: #FFFFFF"> &nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>

                <!--Informe TT -->
                <div v-show="TablaInformesTt.length">
                    <div class="box box-custom-enod" >
                        <div class="box-header with-border">
                        <h3 class="box-title">Informes TT</h3>

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
                                                    <th>Informe</th>
                                                    <th>Componente</th>
                                                    <th>Diámetro</th>
                                                    <th colspan="2">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item,k) in TablaInformesTt" :key="k">
                                                    <td> {{ item.numero_formateado}}</td>
                                                    <td>
                                                        <div >
                                                           {{ item.componente }}
                                                        </div>
                                                    </td>
                                                    <td > N/A </td>
                                                    <td style="text-align:center"> <a  @click="RemoveTablaTt(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a></td>
                                                </tr>
                                                <tr v-for="fila in 4" >
                                                    <td colspan="6" style="background: #FFFFFF"> &nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>


                <div v-for="(itemMetodo,m) in TablaMetodosImportados" :key="m">
                       <!--Informes IMPORTADOS -->
                        <div class="box box-custom-enod" >
                            <div class="box-header with-border">
                                 <h3 class="box-title">Informes {{itemMetodo}}</h3>

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
                                                    <th class="col-md-1">Informe</th>
                                                    <th class="col-md-10">Observaciones</th>
                                                    <th class="col-md-1">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item,k) in TablaInformesImportados" :key="k"  @click="selectPosTablaInformesImportables(k)">
                                                    <td v-if="item.visible && itemMetodo == item.metodo"> {{ item.numero_formateado}}</td>
                                                    <td v-if="item.visible && itemMetodo == item.metodo">
                                                        <div v-if="indexTablaInformesImportados == k && itemMetodo == item.metodo">
                                                              <input type="text" v-model="TablaInformesImportados[k].observaciones_final" maxlength="10" size="100%">
                                                        </div>
                                                        <div v-else-if="itemMetodo == item.metodo">
                                                               {{ item.observaciones_final }}
                                                        </div>
                                                    </td>

                                                    <td style="text-align:center" v-if="item.visible && itemMetodo == item.metodo"> <a  @click="RemoveTablaInformeiImportable(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a></td>

                                                </tr>
                                                <tr v-for="fila in 4" >
                                                    <td colspan="6" style="background: #FFFFFF"> &nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                </div>
                <!-- / Informes importados -->
                <div class="box box-custom-enod">
                    <div class="box-body">
                        <div class="form-group">
                        <label>Observaciones</label>
                        <textarea v-model="observaciones" class="form-control noresize" rows="3" placeholder="" maxlength="250"></textarea>
                        </div>
                    </div>
                </div>
                 <button class="btn btn-primary" type="submit" :disabled="loading" >Guardar</button>
            </form>

       </div>
 </div>
</template>

<script>
import {eventHeaderParte} from '../event-bus';
import {mapState} from 'vuex';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/es';
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
      parte_data : {
        type : Object,
        required : false
      },

      informes_data : {
        type : [ Array ],
        required : false
      },

      informes_ri_data : {
      type : [ Array ],
      required : false
      },

      informes_ri_adicionales_data : {
      type : [ Array ],
      required : false
      },

      informes_pm_data : {
      type : [ Array ],
      required : false
      },

      informes_lp_data : {
      type : [ Array ],
      required : false
      },

      informes_us_data : {
      type : [ Array ],
      required : false
      },

      informes_cv_data : {
      type : [ Array ],
      required : false
      },

      informes_tt_data : {
      type : [ Array ],
      required : false
      },

      informes_dz_data : {
      type : [ Array ],
      required : false
      },

      informes_importados_data : {
      type : [ Array ],
      required : false
      },

      servicios_data : {
      type : [ Array ],
      required : false
      },

      vehiculos_data : {
      type : [ Array ],
      required : false
      },

      responsables_data : {
      type : [ Array ],
      required : false
      }

    },
    data (){return{

        errors:[],

        obra:'',
        fecha:'',
        permitir_anteriores_sn: false,
        tipo_servicio:'',
        horario:'',
        movilidad_propia_sn:false,
        km_inicial:'',
        km_final:'',
        observaciones:'',
        loading: false,
        placas_repetidas : null,
        placas_testigos : null,

        operador:'',
        operadores:[],

        vehiculo:'',
        TablaVehiculos:[],

        responsabilidad:'',
        TablaResponsables:[],

        informes:[],
        informe_sel:false,
        usuarios_cliente:[],
        TablaInformesRi:[],
        TablaInformesPm:[],
        TablaInformesLp:[],
        TablaInformesUs:[],
        TablaInformesCv:[],
        TablaInformesDz:[],
        TablaInformesTt:[],
        TablaInformesImportados:[],
        TablaMetodosImportados:[],
        TablaServicios:[],
        indexTablaInformesRi:'-1',
        indexTablaInformesSinParteDiario:'-1',
        indexTablaInformesPm:'-1',
        indexTablaInformesLp:'-1',
        indexTablaInformesUs:'-1',
        indexTablaInformesDz:'-1',
        indexTablaInformesCv:'-1',
        indexTablaInformesTt:'-1',
        indexTablaInformesImportados:'-1',
        indexTablaServicios:'-1',
        cms:[],
        servicio_manual : {},

        costura_adicional:'',
        pulgada_adicional:'',
        placa_adicional:'',
        cm_adicional:'',

    }},

    created :async function() {
        this.$store.dispatch('loadVehiculosOt',this.otdata.id);
        this.getOperadoresOt();
        this.getCms();
        this.$store.dispatch('loadServiciosOt',this.otdata.id);
        this.$store.dispatch('loadDiametros');
        this.$store.dispatch('loadMedidasPlaca');
    },
    mounted : function() {
        this.CargaDeDatos();
        this.getUsuariosCliente();
    },
    watch :{
        fecha : function(){
            this.resetInformesSelect();
        },
        TablaResponsables : function(){
            this.RecalcularViaticos();
            this.RecalcularHospedaje();
        },
        obra: {
            handler: function(after, before){
               if (before) {
                  this.resetInformesSelect()
               }
            },
            inmediate: true
        },
    },

    computed :{
        ...mapState(['url','serviciosOt','vehiculos','diametros','medidas_placa']),
        fecha_mysql : function(){
            return this.fecha ? moment(this.fecha).format('DD/MM/YYYY') : null;
        },
     },

    methods : {

        deshabilitarInformes : function(fecha_informe,obra_informe,informe_sel){

            if(informe_sel){

                return false;

            }
            else if(!this.fecha_mysql){

                return true ;

            }else if(this.permitir_anteriores_sn && this.obra == obra_informe){

                return false;

            }else if(this.fecha_mysql != fecha_informe || this.obra != obra_informe){

                return true;

            }else{

                return false;
            }

        },

        CargaDeDatos : function(){

            if(this.editmode) {
               this.TablaVehiculos =  JSON.parse(JSON.stringify(this.vehiculos_data));
               this.TablaResponsables =  JSON.parse(JSON.stringify(this.responsables_data));
               eventHeaderParte.$emit('set-obra-header',this.parte_data.obra);
               this.fecha  = this.parte_data.fecha;
               this.tipo_servicio = this.parte_data.tipo_servicio;
               this.horario = this.parte_data.horario;
               this.movilidad_propia_sn = this.parte_data.movilidad_propia_sn;
               this.placas_repetidas = String(this.parte_data.placas_repetidas);
               this.placas_testigos  = String(this.parte_data.placas_testigos);
               this.observaciones = this.parte_data.observaciones;
               this.$nextTick(function(){

                   this.setServiciosParte();
                   this.getInformesPendientesYEditableParte();

               });

            }else{
                 this.getServiciosGenerales();
                 this.getInformesPendientesParte();

            }
        },

        setObra : function(value){

            this.obra = value;
        },

        resetInformesSelect : function(){

            this.informes.forEach(function(item){

                item.informe_sel = false;

            });

            this.TablaInformesRi=[];
            this.TablaInformesLp=[];
            this.TablaInformesPm=[];
            this.TablaInformesUs=[];
            this.TablaInformesCv=[];
            this.TablaInformesDz=[];
            this.TablaInformesTt=[];
            this.TablaInformesImportados=[];
            this.TablaMetodosImportados=[];
            this.TablaServicios=[];

        },

        setResponsabilidad : function() {

            if(this.operador){

                this.responsabilidad = (this.operador.ayudante_sn == 1) ? 'AYUDANTE' : 'OPERADOR' ;

            }
        },

        getOperadoresOt: function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'ot-operarios/ot/' + this.otdata.id + '?api_token=' + Laravel.user.api_token;
            axios.get(urlRegistros).then(response =>{
            this.operadores = JSON.parse(JSON.stringify(response.data));
            });
        },

        selectPosTablaInformesRi :function(index){

            this.indexTablaInformesRi = index ;

        },
        selectPosTablaInformesSinParteDiario :function(index){

            this.indexTablaInformesSinParteDiario = index ;
        },

       selectPosTablaInformesImportables :function(index){

            this.indexTablaInformesImportados = index ;

        },

        selectPosTablaInformesPm :function(index){

            this.indexTablaInformesPm = index ;

        },

        selectPosTablaInformesTt :function(index){

            this.indexTablaInformesTt = index ;

        },

        selectPosTablaInformesLp :function(index){

            this.indexTablaInformesLp = index ;

        },

        selectPosTablaInformesUs :function(index){

            this.indexTablaInformesUs = index ;

        },

        selectPosTablaServicios : function(index){

            this.indexTablaServicios = index;
        },

        FormatearHorario: function(event){

            if(this.horario.length == 2 && event.keyCode !=8){

               if(!isNaN(this.horario) && parseInt(this.horario)>=0 && parseInt(this.horario)<=24){

                    this.horario += '-';

                }else{

                    this.horario = '';
                }

            }else if(this.horario.length == 5){

                let srtHoraFinal = this.horario.substring(3,5);

                if(isNaN(srtHoraFinal) || parseInt(srtHoraFinal)<0 || parseInt(srtHoraFinal)>24){

                    this.horario = this.horario.slice(0,3)
                }

            }

        },

        getCms: function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'medidas/cm/' + '?api_token=' + Laravel.user.api_token;
            axios.get(urlRegistros).then(response =>{

              this.cms = response.data

            });
        },

        getInformesPendientesParte: function(){
            console.log(this.otdata)
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'informes/ot/' + this.otdata.id + '/pendientes_parte_diario' + '?api_token=' + Laravel.user.api_token;
            axios.get(urlRegistros).then(response =>{
                this.informes = response.data
                console.log(this.informes)
            });

        },

        setServiciosParte : function(){

            this.TablaServicios =  JSON.parse(JSON.stringify(this.servicios_data));

            this.TablaServicios.forEach(function(item) {

                if(item.cant_final == null){
                    item.visible = false;
                }else{
                     item.visible = true;
                }
            }.bind(this))

        },

        getInformesPendientesYEditableParte: function(){

             axios.defaults.baseURL = this.url ;
             var urlRegistros = 'informes/ot/' + this.otdata.id + '/parte/'+ this.parte_data.id + '/pendientes_editables_parte_diario' + '?api_token=' + Laravel.user.api_token;
             axios.get(urlRegistros).then(response =>{
             this.informes = response.data

                // Informes importados

                this.informes_importados_data.forEach(function(item_data){


                    this.informes.forEach(function(item_informe){

                        if((item_data.informe_importado_id == item_informe.id) && (item_informe.importable_sn)){

                                item_informe.informe_sel = true;
                            }
                        });

                    }.bind(this));

                    this.informes_importados_data.forEach(function(item){

                        let visible_sn = true;
                        this.AddMetodoImportados(item.metodo);
                        if( !item.observaciones_final){

                            visible_sn = false

                        }

                        this.TablaInformesImportados.push({

                            id  : item.informe_importado_id,
                            metodo             :item.metodo,
                            numero_formateado  : item.numero_formateado,
                            observaciones_original: item.observaciones_original,
                            observaciones_final: item.observaciones_final,
                            visible : visible_sn,
                            });
                        }.bind(this));

                    // Informe Ri

                    this.informes_ri_data.forEach(function(item_data){


                        this.informes.forEach(function(item_informe){

                            if((item_data.informe_id == item_informe.id) && (!item_informe.importable_sn)){

                                item_informe.informe_sel = true;

                            }

                            }.bind(this));

                    }.bind(this));

                    this.informes_ri_data.forEach(function(item){

                        let visible_sn = true;
                        if( !item.costura_final && !item.pulgadas_final && !item.placas_final){

                            visible_sn = false

                        }

                        this.TablaInformesRi.push({

                            numero_formateado  : item.numero_formateado,
                            costura_original: item.costura_original,
                            pulgadas_original: item.pulgadas_original,
                            placas_original : item.placas_original,
                            id      : item.informe_id,
                            visible : visible_sn,
                            costura_final: item.costura_final,
                            pulgadas_final: item.pulgadas_final,
                            placas_final : item.placas_final,
                            cm_original : item.cm_original,
                            cm_final: item.cm_final,
                            manual_sn : 0,
                            });

                        }.bind(this));

                        //informe ri adicionales

                        this.informes_ri_adicionales_data.forEach(function(item){

                            let visible_sn = true;
                            if( !item.costura_final && !item.pulgadas_final && !item.placas_final){

                                visible_sn = false

                            }

                            this.TablaInformesRi.push({

                                numero_formateado  : 'MANUAL',
                                costura_original: item.costura_original,
                                pulgadas_original: item.pulgadas_original,
                                placas_original : item.placas_original,
                                visible : visible_sn,
                                costura_final: item.costura_final,
                                pulgadas_final: item.pulgadas_final,
                                placas_final : item.placas_final,
                                cm_original : item.cm_original,
                                cm_final: item.cm_final,
                                manual_sn : 1,

                                });

                            }.bind(this));

                        //Informe Pm

                        this.informes_pm_data.forEach(function(item_data){


                            this.informes.forEach(function(item_informe){

                                if((item_data.informe_id == item_informe.id) && (!item_informe.importable_sn)){

                                    item_informe.informe_sel = true;

                                    }
                                });

                        }.bind(this));

                        this.informes_pm_data.forEach(function(item){

                        let visible_sn = true;

                        this.TablaInformesPm.push({

                            numero_formateado  : item.numero_formateado,
                            id      : item.informe_id,
                            visible : visible_sn,
                            componente : item.componente,
                            diametro_especifico : item.diametro_especifico,
                            diametro: item.diametro

                            });
                        }.bind(this));

                        //Informe Lp

                        this.informes_lp_data.forEach(function(item_data){


                            this.informes.forEach(function(item_informe){

                                if((item_data.informe_id == item_informe.id) && (!item_informe.importable_sn)){

                                    item_informe.informe_sel = true;

                                    }
                                });

                        }.bind(this));

                        this.informes_lp_data.forEach(function(item){

                        let visible_sn = true;

                        this.TablaInformesLp.push({

                            numero_formateado  : item.numero_formateado,
                            id      : item.informe_id,
                            visible : visible_sn,
                            componente : item.componente,
                            diametro_especifico : item.diametro_especifico,
                            diametro: item.diametro
                            });
                        }.bind(this));

              //Informe CV

                        this.informes_cv_data.forEach(function(item_data){


                            this.informes.forEach(function(item_informe){

                                if((item_data.informe_id == item_informe.id) && (!item_informe.importable_sn)){

                                    item_informe.informe_sel = true;

                                    }
                                });

                        }.bind(this));

                        this.informes_cv_data.forEach(function(item){

                        let visible_sn = true;

                        this.TablaInformesCv.push({

                            numero_formateado  : item.numero_formateado,
                            id      : item.informe_id,
                            visible : visible_sn,
                            componente : item.componente,
                            });
                        }.bind(this));

                        //Informe DZ

                        this.informes_dz_data.forEach(function(item_data){


                            this.informes.forEach(function(item_informe){

                                if((item_data.informe_id == item_informe.id) && (!item_informe.importable_sn)){

                                    item_informe.informe_sel = true;

                                    }
                                });

                        }.bind(this));

                        this.informes_dz_data.forEach(function(item){

                        let visible_sn = true;

                        this.TablaInformesDz.push({

                            numero_formateado  : item.numero_formateado,
                            id      : item.informe_id,
                            visible : visible_sn,
                            componente : item.componente,
                            });
                        }.bind(this));


                       //Informe Us

                       this.informes_us_data.forEach(function(item_data){

                            this.informes.forEach(function(item_informe){

                                if((item_data.informe_id == item_informe.id) && (!item_informe.importable_sn)){

                                    item_informe.informe_sel = true;
                                 }
                                });

                        }.bind(this));

                        this.informes_us_data.forEach(function(item){

                            let visible_sn = true;


                            if( !item.costura_final  &&  !item.pulgadas_final && !item.pieza_final){

                                visible_sn = false

                            }

                            this.TablaInformesUs.push({

                                numero_formateado  : item.numero_formateado,
                                costura_original: item.costura_original,
                                costura_final: item.costura_final,
                                pieza_original: item.pieza_original,
                                pieza_final: item.pieza_final,
                                pulgadas_final: item.pulgadas_final,
                                pulgadas_original: item.pulgadas_original,
                                tecnica     : item.tecnica,
                                id      : item.informe_id,
                                visible : visible_sn,
                                cm_original : item.cm_original,
                                cm_final: item.cm_final,

                                });

                        }.bind(this));

                        //Informe TT

                        this.informes_tt_data.forEach(function(item_data){


                            this.informes.forEach(function(item_informe){

                                if((item_data.informe_id == item_informe.id) && (!item_informe.importable_sn)){

                                    item_informe.informe_sel = true;

                                    }
                                });

                        }.bind(this));

                        this.informes_tt_data.forEach(function(item){

                        let visible_sn = true;

                        this.TablaInformesTt.push({

                            numero_formateado  : item.numero_formateado,
                            id      : item.informe_id,
                            visible : visible_sn,
                            componente : item.componente,
                            });
                        }.bind(this));
             });

         },

        existeResponsable : function(id){

            let index = this.TablaResponsables.findIndex(elemento => elemento.user.id == id)
            return (index == -1 ? false : true) ;

        },

        addVehiculo(){

            if(!this.vehiculo){
                toastr.error("El campo vehículo es obligatorio");
                 return;
            }

            if(!this.km_inicial){
                toastr.error("El campo km inical es obligatorio");
                 return;
            }

            if(!this.km_final){
                toastr.error("El campo km final es obligatorio");
                 return;
            }

            if(parseFloat(this.km_final) < parseFloat(this.km_inicial)){
                toastr.error("Km final mayor a km inical");
                return;
            }

            if(this.existeVehiculo(this.vehiculo.id)){
                toastr.error('El vehiculo existe en el parte');
                return;
            }

            this.TablaVehiculos.push({

                vehiculo :this.vehiculo,
                km_inicial : this.km_inicial,
                km_final : this.km_final,

                });

            this.vehiculo = '';
            this.km_inicial='';
            this.km_final='';
            this.RecalcularKms();

        },

        existeVehiculo(id){

            let index = this.TablaVehiculos.findIndex(elemento => elemento.vehiculo.id == id)
            return (index == -1 ? false : true) ;

        },

        RemoveVehiculo(index) {

           this.TablaVehiculos.splice(index, 1);
           this.RecalcularKms();
        },

        addResponsable(id) {

            if(!this.operador){
                toastr.error("El campo operador es obligatorio");
                 return;
            }

            if(!this.responsabilidad){
                toastr.error("El campo responsabilidad es obligatorio");
                return;
            }

            if(this.existeResponsable(id)){

                toastr.error('El responsable existe en el parte');
                return;
            }

            this.TablaResponsables.push({
                user :this.operador,
                responsabilidad  : this.responsabilidad,

                });
            this.operador='';
            this.responsabilidad ='';

            },

        RemoveResponsable(index) {

           this.TablaResponsables.splice(index, 1);

        },
        RemoveTablaDz(index) {

           this.TablaInformesDz.splice(index, 1);

        },
        RemoveTablaCv(index) {

           this.TablaInformesCv.splice(index, 1);

        },
        RemoveTablaLp(index) {

           this.TablaInformesLp.splice(index, 1);

        },
        RemoveTablaPm(index) {

           this.TablaInformesPm.splice(index, 1);

        },

        RemoveTablaTt(index) {

           this.TablaInformesTt.splice(index, 1);

        },

        RemoveTablaInformeiImportable(index){

            this.TablaInformesImportados[index].visible = false;
            this.TablaInformesImportados[index].observaciones_final='';

        },

        RemoveTablaInformeRi(index){

            if(this.TablaInformesRi[index].manual_sn){

                this.TablaInformesRi.splice(index, 1);

            }else{

                this.TablaInformesRi[index].visible = false;
                this.TablaInformesRi[index].costura_final='';
                this.TablaInformesRi[index].placas_final='';
                this.TablaInformesRi[index].pulgadas_final=''
                this.TablaInformesRi[index].cm_final=''
            }

        },


        RemoveTablaInformeUs(index){

            this.TablaInformesUs[index].visible = false;
            this.TablaInformesUs[index].pieza_final='';
            this.TablaInformesUs[index].costura_final='';
            this.TablaInformesUs[index].pulgadas_final='';
            this.TablaInformesUs[index].cm_final='';

        },

        RemoveTablaServicio(index){

            this.TablaServicios[index].visible = false;
            this.TablaServicios[index].cant_final='';

        },
        getUsuariosCliente : function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'users/ot_id/' + this.otdata.id + '?api_token=' + Laravel.user.api_token;
            axios.get(urlRegistros).then(response =>{
            this.usuarios_cliente = response.data
            });

        },

       async getInforme(index){
            if(this.informes[index].informe_sel){

                this.loading = true;
                if(this.informes[index].importable_sn){

                  await  this.getInformesImportado(this.informes[index].id,index);
                  await  this.getServiciosInformes(this.informes[index].id,1);

                }else{

                    switch  (this.informes[index].metodo){

                      case 'RI' : await this.getInformeRI(this.informes[index].id,index);break;

                      case 'PM' : await this.getInformePM(this.informes[index].id,index);break;

                      case 'LP' : await this.getInformeLP(this.informes[index].id,index);break;

                      case 'US' : await this.getInformeUS(this.informes[index].id,index);break;

                      case 'CV' : await this.getInformeCV(this.informes[index].id,index);break;

                      case 'DZ' : await this.getInformeDZ(this.informes[index].id,index);break;

                      case 'TT' : await this.getInformeTT(this.informes[index].id,index);break;

                    }

                  await this.getServiciosInformes(this.informes[index].id,0);
                }
            this.loading = false;

            } else{
                if(this.informes[index].importable_sn){

                    let id  = this.informes[index].id ;

                    for( var i = 0; i < this.TablaInformesImportados.length; i++){
                        if (this.TablaInformesImportados[i].id == id) {
                                let metodo = this.TablaInformesImportados[i].metodo;
                                let existeMetodo = false;
                                this.TablaInformesImportados.splice(i, 1);
                                this.TablaInformesImportados.forEach(function(item){
                                  if(item.metodo == metodo){
                                        existeMetodo = true;
                                  }

                                });
                                if(!existeMetodo){

                                    this.TablaMetodosImportados.splice(this.TablaMetodosImportados.indexOf(metodo),1);
                                }

                            i--;
                        }
                    }

                }else{

                    let id  = this.informes[index].id ;

                    for( var i = 0; i < this.TablaInformesRi.length; i++){
                        if (this.TablaInformesRi[i].id == id) {
                                this.TablaInformesRi.splice(i, 1);
                            i--;
                        }
                    }

                    for( var i = 0; i < this.TablaInformesPm.length; i++){
                        if (this.TablaInformesPm[i].id == id) {
                                this.TablaInformesPm.splice(i, 1);
                            i--;
                        }
                    }

                    for( var i = 0; i < this.TablaInformesLp.length; i++){
                        if (this.TablaInformesLp[i].id == id) {
                                this.TablaInformesLp.splice(i, 1);
                            i--;
                        }
                    }

                    for( var i = 0; i < this.TablaInformesUs.length; i++){
                        if (this.TablaInformesUs[i].id == id) {
                                this.TablaInformesUs.splice(i, 1);
                            i--;
                        }
                    }

                    for( var i = 0; i < this.TablaInformesDz.length; i++){
                        if (this.TablaInformesDz[i].id == id) {
                                this.TablaInformesDz.splice(i, 1);
                            i--;
                        }
                    }

                    for( var i = 0; i < this.TablaInformesCv.length; i++){
                        if (this.TablaInformesCv[i].id == id) {
                                this.TablaInformesCv.splice(i, 1);
                            i--;
                        }
                    }

                    for( var i = 0; i < this.TablaInformesTt.length; i++){
                        if (this.TablaInformesTt[i].id == id) {
                                this.TablaInformesTt.splice(i, 1);
                            i--;
                        }
                    }

                }

                //borro los servicios

                let metodo_ensayo_id = this.informes[index].metodo_ensayo_id;

                 this.TablaServicios = this.TablaServicios.filter(function(item) {
                     return item.metodo_ensayo_id != metodo_ensayo_id;
                    });

                this.informes.forEach(function(item){

                    if(item.metodo_ensayo_id == metodo_ensayo_id && item.informe_sel ){

                        this.getServiciosInformes(item.id,item.importable_sn)

                    }
                }.bind(this));

            }

        },

        async getInformesImportado(id,index){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'partes/informe_importado/' + id + '?api_token=' + Laravel.user.api_token;
            let res = await axios.get(urlRegistros);
            let informe_importado_parte = await res.data;

            this.TablaInformesImportados.push({

                id:id,
                numero_formateado : this.informes[index].numero_formateado,
                visible: true,
                metodo:this.informes[index].metodo,
                observaciones_original:informe_importado_parte.observaciones,
                observaciones_final:informe_importado_parte.observaciones

            })

            this.AddMetodoImportados(this.informes[index].metodo);

        },

        getServiciosGenerales: function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'ot_servicios/ot/' + this.otdata.id + '/generales' + '?api_token=' + Laravel.user.api_token;
            axios.get(urlRegistros).then(response =>{

              let informe_servicios = response.data;

              let cantidad = 0;
              informe_servicios.forEach(function(item) {

                   if(item.unidad_medida == 'Visita'){

                        cantidad = 1;

                   }else if(item.unidad_medida =='Km'){

                        cantidad = 0;

                   }else if(item.unidad_medida == 'Dia' && item.servicio_descripcion.includes('VIATICOS')){

                         cantidad = 0;

                   }else if(item.unidad_medida == 'Dia' && item.servicio_descripcion.includes('HOSPEDAJE')){

                         cantidad = 0;

                  }

                    this.TablaServicios.push({

                        metodo_ensayo_id : item.metodo_ensayo_id,
                        servicio_id : item.servicio_id,
                        metodo: item.metodo,
                        servicio_descripcion:item.servicio_descripcion,
                        cant_original : 0,
                        cant_final: cantidad,
                        unidad_medida : item.unidad_medida,
                        visible : true,

                    })

              }.bind(this));

            });
        },

        AddServicioManual : function(){

            if(this.TablaServicios.findIndex(elemento => elemento.servicio_descripcion == this.servicio_manual.servicio_descripcion) != -1){

                if(this.TablaServicios[this.TablaServicios.findIndex(elemento => elemento.servicio_descripcion ==this.servicio_manual.servicio_descripcion)].visible == true){
                    this.TablaServicios[this.TablaServicios.findIndex(elemento => elemento.servicio_descripcion ==this.servicio_manual.servicio_descripcion)].cant_final +=1;
                }else{

                     this.TablaServicios[this.TablaServicios.findIndex(elemento => elemento.servicio_descripcion ==this.servicio_manual.servicio_descripcion)].cant_final = 1;
                     this.TablaServicios[this.TablaServicios.findIndex(elemento => elemento.servicio_descripcion ==this.servicio_manual.servicio_descripcion)].visible = true;
                }
            }
            else{

                this.TablaServicios.push({

                    metodo_ensayo_id : this.servicio_manual.metodo_ensayo_id,
                    servicio_id : this.servicio_manual.servicio_id,
                    metodo: this.servicio_manual.metodo,
                    servicio_descripcion:this.servicio_manual.servicio_descripcion,
                    cant_original : '',
                    cant_final: 1,
                    unidad_medida : this.servicio_manual.unidad_medida,
                    visible : true,

                    })
            }
         this.RecalcularKms();
         this.RecalcularMetros();
         this.RecalcularHospedaje();
         this.RecalcularViaticos();
         this.$forceUpdate();

        },

        async getServiciosInformes(informe_id,importado_sn){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'ot_servicios/informe/' + informe_id + '/importado_sn/' + importado_sn + '?api_token=' + Laravel.user.api_token;
            let res = await axios.get(urlRegistros);
            let informe_servicios = await res.data;

                informe_servicios.forEach(function(item) {

                    if(this.TablaServicios.findIndex(elemento => elemento.servicio_descripcion == item.servicio_descripcion) != -1 && this.TablaServicios[this.TablaServicios.findIndex(elemento => elemento.servicio_descripcion ==item.servicio_descripcion)].visible == false){

                       this.TablaServicios[this.TablaServicios.findIndex(elemento => elemento.servicio_descripcion ==item.servicio_descripcion)].visible=true;

                    }

                   if(this.TablaServicios.findIndex(elemento => elemento.servicio_descripcion == item.servicio_descripcion) != -1 && this.TablaServicios[this.TablaServicios.findIndex(elemento => elemento.servicio_descripcion ==item.servicio_descripcion)].visible){

                       if(item.unidad_medida == 'Dia' || item.unidad_medida == 'Mes'){

                            this.TablaServicios[this.TablaServicios.findIndex(elemento => elemento.servicio_descripcion ==item.servicio_descripcion)].cant_original = 1;
                            this.TablaServicios[this.TablaServicios.findIndex(elemento => elemento.servicio_descripcion ==item.servicio_descripcion)].cant_final = 1;

                       }else if(item.unidad_medida == 'Metro' && item.metodo == 'RI'){

                            let metros = this.CalcularMetrosRI(item);
                            this.TablaServicios[this.TablaServicios.findIndex(elemento => elemento.servicio_descripcion == item.servicio_descripcion)].cant_final = metros;

                       }else if(item.unidad_medida == 'Metro' && item.metodo == 'LP'){

                            let metros = this.CalcularMetrosLP(item);
                            this.TablaServicios[this.TablaServicios.findIndex(elemento => elemento.servicio_descripcion == item.servicio_descripcion)].cant_final = metros;

                       }else if(item.unidad_medida == 'Metro' && item.metodo == 'PM'){

                            let metros = this.CalcularMetrosPM(item);
                            this.TablaServicios[this.TablaServicios.findIndex(elemento => elemento.servicio_descripcion == item.servicio_descripcion)].cant_final = metros;

                       }else if(item.unidad_medida == 'Metro' && item.metodo == 'US'){

                            let metros = this.CalcularMetrosUS(item);
                            this.TablaServicios[this.TablaServicios.findIndex(elemento => elemento.servicio_descripcion == item.servicio_descripcion)].cant_final = metros;

                       }else if(item.unidad_medida == 'Metro' && item.metodo == 'TT'){

                            let metros = this.CalcularMetrosTT(item);
                            this.TablaServicios[this.TablaServicios.findIndex(elemento => elemento.servicio_descripcion == item.servicio_descripcion)].cant_final = metros;

                       }else if(item.unidad_medida == 'Metro' && item.metodo == 'CV'){

                            let metros = this.CalcularMetrosCV(item);
                            this.TablaServicios[this.TablaServicios.findIndex(elemento => elemento.servicio_descripcion == item.servicio_descripcion)].cant_final = metros;

                       }else if(item.unidad_medida == 'Metro' && item.metodo == 'DZ'){
                            let metros = this.CalcularMetrosDZ(item);
                            this.TablaServicios[this.TablaServicios.findIndex(elemento => elemento.servicio_descripcion == item.servicio_descripcion)].cant_final = metros;
                       }

                       else{
                           this.TablaServicios[this.TablaServicios.findIndex(elemento => elemento.servicio_descripcion ==item.servicio_descripcion)].cant_original+=item.cantidad;
                           this.TablaServicios[this.TablaServicios.findIndex(elemento => elemento.servicio_descripcion ==item.servicio_descripcion)].cant_final +=item.cantidad;
                       }


                   }else{


                       let cantidad = item.cantidad;

                       if (item.unidad_medida == 'Hora') {


                           let hora_inicial =  this.horario.substring(0, (this.horario.indexOf("-") >-1) ? this.horario.indexOf("-") : 0) ;

                           let hora_final = this.horario.substring( (this.horario.indexOf("-") >-1) ? this.horario.indexOf("-") + 1: this.horario.length-1, this.horario.length) ;

                           cantidad = hora_final - hora_inicial;


                       }

                       if(item.unidad_medida == 'Metro'){

                           if(item.metodo == 'RI'){
                                cantidad = this.CalcularMetrosRI(item)
                           }else if(item.metodo == 'LP'){
                                cantidad = this.CalcularMetrosLP(item)
                           }else if(item.metodo == 'PM'){
                                cantidad = this.CalcularMetrosPM(item)
                           }else if(item.metodo == 'US'){
                                cantidad = this.CalcularMetrosUS(item)
                           }else if(item.metodo == 'TT'){
                                cantidad = this.CalcularMetrosTT(item)
                            }else if(item.metodo == 'CV'){
                                cantidad = this.CalcularMetrosCV(item)
                            }else if(item.metodo == 'DZ'){
                                cantidad = this.CalcularMetrosDZ(item)
                            }
                       }

                       this.TablaServicios.push({

                           metodo_ensayo_id : item.metodo_ensayo_id,
                           servicio_id : item.servicio_id,
                           metodo: item.metodo,
                           servicio_descripcion:item.servicio_descripcion,
                           cant_original : cantidad,
                           cant_final: cantidad,
                           unidad_medida : item.unidad_medida,
                           visible : true,

                       })
                   }

                }.bind(this));


        },

        RecalcularMetros(metodo){

          if(this.TablaServicios.findIndex(elemento => elemento.unidad_medida == 'Metro' && elemento.metodo == metodo) != -1){

           switch (metodo) {

               case 'RI':
                   this.TablaServicios[this.TablaServicios.findIndex(elemento => elemento.unidad_medida == 'Metro' && elemento.metodo =='RI')].cant_final = this.CalcularMetrosRI();
                   break;

               case 'LP':
                   this.TablaServicios[this.TablaServicios.findIndex(elemento => elemento.unidad_medida == 'Metro' && elemento.metodo =='LP')].cant_final = this.CalcularMetrosLP();
                   break;

               case 'PM':
                   this.TablaServicios[this.TablaServicios.findIndex(elemento => elemento.unidad_medida == 'Metro' && elemento.metodo =='PM')].cant_final = this.CalcularMetrosPM();
                   break;

               case 'US':
                   this.TablaServicios[this.TablaServicios.findIndex(elemento => elemento.unidad_medida == 'Metro' && elemento.metodo =='US')].cant_final = this.CalcularMetrosUS();
                   break;

               case 'TT':
                   this.TablaServicios[this.TablaServicios.findIndex(elemento => elemento.unidad_medida == 'Metro' && elemento.metodo =='TT')].cant_final = this.CalcularMetrosTT();
                   break;

               case 'CV':
                   this.TablaServicios[this.TablaServicios.findIndex(elemento => elemento.unidad_medida == 'Metro' && elemento.metodo =='CV')].cant_final = this.CalcularMetrosCV();
                   break;

               case 'DZ':
                   this.TablaServicios[this.TablaServicios.findIndex(elemento => elemento.unidad_medida == 'Metro' && elemento.metodo =='DZ')].cant_final = this.CalcularMetrosDZ();
                   break;

               default:
                   break;
           }

          }
        },


        RecalcularKms()  {

            let index = this.TablaServicios.findIndex(elemento => (elemento.unidad_medida == 'Km' && elemento.metodo =='GRAL'))
            if(index > -1){
                let kms = 0;

                this.TablaVehiculos.forEach(function(item){

                    kms = parseFloat(kms) +  parseFloat(item.km_final) - parseFloat(item.km_inicial);

                }.bind(this));
                this.TablaServicios[index].cant_final = parseFloat(kms);
            }
        },

        RecalcularViaticos()  {

            let index = this.TablaServicios.findIndex(elemento => (elemento.unidad_medida == 'Dia' && elemento.servicio_descripcion.includes('Viáticos')))
            if(index > -1){

                this.TablaServicios[index].cant_final = this.TablaResponsables.length;
            }
        },

      RecalcularHospedaje()  {

            let index = this.TablaServicios.findIndex(elemento => (elemento.unidad_medida == 'Dia' && elemento.servicio_descripcion.includes('Hospedaje')))

            if(index > -1){

                this.TablaServicios[index].cant_final = this.TablaResponsables.length;
                this.TablaServicios[index].cant_original = this.TablaResponsables.length;
            }
        },

        CalcularMetrosRI : function(){

            let largo = 0 ;
            let placas = 0;
            let metros = 0 ;

            this.TablaInformesRi.forEach(function(item){

                if(item.cm_final){

                    if(item.cm_final.codigo.indexOf("x") > -1){

                        largo = parseFloat(item.cm_final.codigo.substring( (item.cm_final.codigo.indexOf("x") >-1) ? item.cm_final.codigo.indexOf("x") + 1: item.cm_final.codigo.length-1, item.cm_final.codigo.length)) ;

                    }else{

                        largo = parseFloat(item.cm_final.codigo)
                    }

                    placas = parseInt(item.placas_final);
                    metros += parseFloat(largo/100) * parseFloat(placas);
                }

            }.bind(this))

            return parseFloat(metros).toFixed(2);
        },

        CalcularMetrosLP : function(){

           let metros = 0 ;
           let cms = 0;
           this.TablaInformesLp.forEach(function(item){

               if(item.cm_final){

                   cms += parseFloat(item.cm_final);
               }

           }.bind(this))
           metros = parseFloat(cms/100).toFixed(2);
           return metros;
        },

        CalcularMetrosPM : function(){

           let metros = 0 ;
           let cms = 0;
           this.TablaInformesPm.forEach(function(item){

               if(item.cm_final){

                   cms += parseFloat(item.cm_final);
               }

           }.bind(this))
           metros = parseFloat(cms/100).toFixed(2);
           return metros;
        },

        CalcularMetrosTT : function(){

           let metros = 0 ;
           let cms = 0;
           this.TablaInformesTt.forEach(function(item){

               if(item.cm_final){

                   cms += parseFloat(item.cm_final);
               }

           }.bind(this))
           metros = parseFloat(cms/100).toFixed(2);
           return metros;
        },

        CalcularMetrosCV : function(){

           let metros = 0 ;
           let cms = 0;
           this.TablaInformesCv.forEach(function(item){

               if(item.cm_final){

                   cms += parseFloat(item.cm_final);
               }

           }.bind(this))
           metros = parseFloat(cms/100).toFixed(2);
           return metros;
        },

        CalcularMetrosDZ : function(){

           let metros = 0 ;
           let cms = 0;
           this.TablaInformesDz.forEach(function(item){

               if(item.cm_final){

                   cms += parseFloat(item.cm_final);
               }

           }.bind(this))
           metros = parseFloat(cms/100).toFixed(2);
           return metros;
        },

        CalcularMetrosUS : function(){

           let metros = 0 ;
           let cms = 0;
           this.TablaInformesUs.forEach(function(item){

               if(item.cm_final){

                    cms += parseFloat(item.cm_final);
               }

           }.bind(this))
           metros = parseFloat(cms/100).toFixed(2);
           return metros;
        },

        AddMetodoImportados(metodo){

            this.TablaMetodosImportados.indexOf(metodo) === -1 ? this.TablaMetodosImportados.push(metodo) : console.log("This item already exists");

        },

        async getInformeRI(id,index){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'partes/informe_ri/' + id + '?api_token=' + Laravel.user.api_token;
            let res = await axios.get(urlRegistros);
            let informe_ri_parte = await res.data;

            this.TablaInformesRi.push({

                id      : id,
                numero_formateado  : this.informes[index].numero_formateado,
                costura_original: informe_ri_parte[0].costuras,
                pulgadas_original: informe_ri_parte[0].pulgadas,
                placas_original : informe_ri_parte[0].placas,
                visible : true,
                costura_final: informe_ri_parte[0].costuras,
                pulgadas_final: informe_ri_parte[0].pulgadas,
                placas_final : informe_ri_parte[0].placas,
                cm_original: informe_ri_parte[0].medida,
                cm_final:informe_ri_parte[0].medida,
                metodo : informe_ri_parte[0].metodo,
                manual_sn : 0

            });
        },

        async getInformePM(id,index){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'partes/informe_pm/' + id + '?api_token=' + Laravel.user.api_token;
            let res = await axios.get(urlRegistros);
            let informe_pm_parte = await res.data;

            informe_pm_parte.forEach(function(item){

                this.TablaInformesPm.push({
                    id      : id,
                    numero_formateado  : this.informes[index].numero_formateado,
                    visible : true,
                    componente : item.componente,
                    diametro_especifico : item.diametro_especifico,
                    diametro : item.diametro,
                    metodo : item.metodo,
                    });
                }.bind(this));
         },

        async getInformeTT(id,index){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'partes/informe_tt/' + id + '?api_token=' + Laravel.user.api_token;
            let res = await axios.get(urlRegistros);
            let informe_tt_parte = await res.data;

            informe_tt_parte.forEach(function(item){

                this.TablaInformesTt.push({
                    id      : id,
                    numero_formateado  : this.informes[index].numero_formateado,
                    visible : true,
                    componente : item.componente,
                    metodo : item.metodo,
                    });
                }.bind(this));
         },

        async getInformeLP(id,index){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'partes/informe_lp/' + id + '?api_token=' + Laravel.user.api_token;
            let res = await axios.get(urlRegistros);
            let informe_lp_parte = await res.data;
            console.log(informe_lp_parte)

            informe_lp_parte.forEach(function(item){

                this.TablaInformesLp.push({

                    id      : id,
                    numero_formateado  : this.informes[index].numero_formateado,
                    visible : true,
                    componente : item.componente,
                    diametro_especifico : item.diametro_especifico,
                    diametro : item.diametro,
                    metodo : item.metodo,
                    });

                }.bind(this));

        },

        async getInformeCv(id,index){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'partes/informe_cv/' + id + '?api_token=' + Laravel.user.api_token;
            let res = await axios.get(urlRegistros);
            let informe_cv_parte = await res.data;

            informe_cv_parte.forEach(function(item){

                this.TablaInformesCv.push({

                    id      : id,
                    numero_formateado  : this.informes[index].numero_formateado,
                    visible : true,
                    componente : item.componente,
                    metodo : item.metodo,
                    });

                }.bind(this));

        },

        async getInformeDz(id,index){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'partes/informe_dz/' + id + '?api_token=' + Laravel.user.api_token;
            let res = await axios.get(urlRegistros);
            let informe_dz_parte = await res.data;

            informe_dz_parte.forEach(function(item){

                this.TablaInformesDz.push({

                    id      : id,
                    numero_formateado  : this.informes[index].numero_formateado,
                    visible : true,
                    componente : item.componente,
                    metodo : item.metodo,
                    });

                }.bind(this));

        },

        async getInformeUS(id,index){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'partes/informe_us/' + id + '?api_token=' + Laravel.user.api_token;
            let res = await axios.get(urlRegistros);
            let informe_us_parte = await res.data;
            console.log(informe_us_parte);
            informe_us_parte.forEach(function(item){

                if(item.tecnica.codigo =='US' || item.tecnica.codigo =='PA'){

                        this.TablaInformesUs.push({
                           id      : id,
                           numero_formateado  : this.informes[index].numero_formateado,
                           visible : true,
                           metodo : item.metodo,
                           tecnica : item.tecnica.codigo,
                           pulgadas_original: item.pulgadas,
                           pulgadas_final: item.pulgadas,
                           pieza_original : item.costuras,
                           pieza_final : item.costuras,
                           cm_original: '',
                           cm_final:'',
                        });

                }else if(item.tecnica.codigo =='ME'){

                         this.TablaInformesUs.push({

                            id      : id,
                            numero_formateado  : this.informes[index].numero_formateado,
                            visible : true,
                            metodo : item.metodo,
                            tecnica : item.tecnica.codigo,
                            pieza_original : item.pieza,
                            pieza_final : item.pieza,
                            pulgadas_original: item.pulgadas,
                            pulgadas_final: item.pulgadas,
                            cm_original: '',
                            cm_final:'',

                        });
               }

            }.bind(this));


            },

        validarCmsRi: function(){

                let valido = true;

                this.TablaInformesRi.forEach(function(item){

                    if((item.costura_final || item.pulgadas_final || item.placas_final) && !item.cm_final ){

                        valido =  false;
                    }
                })

                return valido;

            },
        validarResponsables: function(){

            let valido = 'true';

            valido = this.TablaResponsables.length ? true :false

            return valido;
        },

        validarCantidad : function (tabla,index,campo){

            if(tabla[index][`${campo}`] ==='' ||  tabla[index][`${campo}`] < 0){
                tabla[index][`${campo}`] = 0;
            }

        },

        cambioMedida : function(){

             this.cm_adicional.codigo = this.cm_adicional.codigo.replace('X','x');
             this.cm_adicional.codigo = this.cm_adicional.codigo.replace('-','x');
             let existe_alto = this.cm_adicional.codigo.includes('x');
             if(!existe_alto){
                 this.cm_adicional.codigo = '7x' + this.cm_adicional.codigo;
             }
         },

        AddCosturaAdicional : function(){

            if(!this.costura_adicional || !this.pulgada_adicional || !this.placa_adicional || !this.cm_adicional){
                return;
            }
            this.TablaInformesRi.push({

                numero_formateado:'MANUAL',
                costura_original : "",
                pulgadas_original :"",
                placas_original :"",
                cm_original :"",
                costura_final : this.costura_adicional,
                pulgadas_final : this.pulgada_adicional.diametro,
                placas_final : this.placa_adicional,
                cm_final : this.cm_adicional.codigo,
                visible: true,
                manual_sn : 1,
            });

        },

        validar : function(){

            let valido = true;

            if(!this.validarCmsRi()){

                  toastr.error('EL campo CM en los informes RI asignados al Parte son obligatorios');
                  valido = false;
            }


            if(!this.validarResponsables()){

                toastr.error('El Parte debe tener al menos 1 responsable');
                valido = false;
            }

            if(this.TablaInformesRi.length) {

                if(this.placas_repetidas && this.placas_testigos)
                    return true;

                if(!this.placas_repetidas){

                    toastr.error('El campo placas repetidas es obligatorio');
                     return false;
                }

                if(!this.placas_testigos){

                    toastr.error('El campo placas testigos es obligatorio');
                     return false;

                }
            }

            return valido;

        },

        Store : function(){

            if(!this.validar()){
                return;
            }

            this.errors =[];

            this.loading = true;
            var urlRegistros = 'partes' ;
            axios({
              method: 'post',
              url : urlRegistros,
              data : {
                'ot'                   : this.otdata,
                'obra'                 : this.obra,
                'fecha'                : this.fecha,
                'tipo_servicio'        : this.tipo_servicio,
                'horario'              : this.horario,
                'movilidad_propia_sn'  : this.movilidad_propia_sn,
                'observaciones'        : this.observaciones,
                'vehiculos'            : this.TablaVehiculos,
                'responsables'         :this.TablaResponsables,
                'informes_ri'          :this.TablaInformesRi,
                'placas_repetidas'     :this.placas_repetidas,
                'placas_testigos'      :this.placas_testigos,
                'informes_pm'          :this.TablaInformesPm,
                'informes_lp'          :this.TablaInformesLp,
                'informes_us'          :this.TablaInformesUs,
                'informes_dz'          :this.TablaInformesDz,
                'informes_cv'          :this.TablaInformesCv,
                'informes_tt'           :this.TablaInformesTt,
                'informes_importados'  :this.TablaInformesImportados,
                'servicios'            :this.TablaServicios,
                'informes'             :this.informes,

          }

          }).then(response => {

          let parte = response.data;
          toastr.success('Parte diario con fecha' +  this.fecha + ' fue creado con éxito ');
          window.open(  '/pdf/parte/' + parte.id + '/final','_blank');
          window.location.href =  '/partes/ot/' + this.otdata.id;

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

            if(!this.validar()){
                return;
            }

            this.loading =true;
            this.errors =[];
            var urlRegistros = 'partes/' + this.parte_data.id  ;
            axios({
              method: 'put',
              url : urlRegistros,
              data : {
                'ot'                   : this.otdata,
                'obra'                 : this.obra,
                'fecha'                : this.fecha,
                'tipo_servicio'        : this.tipo_servicio,
                'horario'              : this.horario,
                'movilidad_propia_sn'  : this.movilidad_propia_sn,
                'observaciones'        : this.observaciones,
                'vehiculos'            : this.TablaVehiculos,
                'responsables'         :this.TablaResponsables,
                'placas_repetidas'     :this.placas_repetidas,
                'placas_testigos'      :this.placas_testigos,
                'informes_ri'          :this.TablaInformesRi,
                'informes_pm'          :this.TablaInformesPm,
                'informes_lp'          :this.TablaInformesLp,
                'informes_us'          :this.TablaInformesUs,
                'informes_dz'          :this.TablaInformesDz,
                'informes_cv'          :this.TablaInformesCv,
                'informes_tt'           :this.TablaInformesTt,
                'informes_importados'  :this.TablaInformesImportados,
                'servicios'            :this.TablaServicios,
                'informes'             :this.informes,
          }}

        ).then( () => {

          toastr.success('Parte diario con fecha' +  this.fecha + ' fue actualizado con éxito ');
          window.open(  '/pdf/parte/' + this.parte_data.id + '/final','_blank');
          window.location.href =  '/partes/ot/' + this.otdata.id;

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
</style>
