<template>
 <div class="row">
       <div class="col-md-12">
            <form @submit.prevent="editmode ?  Update() : Store()"  method="post">
                <parte-header :otdata="otdata" @set-obra="setObra($event)" ></parte-header>
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
                                <label for="tipo_servicio">Tipo Servicio (*)</label>
                                <v-select type="text" v-model="tipo_servicio"  id="tipo_servicio" :options="['Diurno', 'Nocturno']" ></v-select>
                            </div>                            
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="horario">Horario (*)</label>
                                <input type="text" v-model="horario" class="form-control" maxlength="5" id="horario">
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
                        <div class="clearfix"></div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="horario">Patente </label>
                                <input type="text" v-model="patente" class="form-control" maxlength="10" id="patente" :disabled="!movilidad_propia_sn">
                            </div>                            
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="km_inicial">Km Inicial </label>
                                <input type="number" v-model="km_inicial" class="form-control" id="km_inicial" step="0.1" :disabled="!movilidad_propia_sn">
                            </div>                            
                        </div>  
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="km_final">Km Final </label>
                                <input type="number" v-model="km_final" class="form-control" id="km_final" step="0.1" :disabled="!movilidad_propia_sn">
                            </div>                            
                        </div>  
                    </div>
                </div>   
                <div class="box box-danger">
                    <div class="box-header with-border">
                    <h3 class="box-title">Responsabilidades</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>                       
                        </div>
                    </div>
                    <div class="box-body"> 
                        <div class="col-md-6">
                            <div class="form-group" >
                                <label for="km_final">Operador </label>
                                <v-select type="text" v-model="operador" id="responsable" label="name" :options="operadores"></v-select>
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
                                  <a title="Agregar responsables" @click="addResponsable(operador.id)"> <app-icon img="plus-circle" color="black"></app-icon> </a>                        
                                </span>
                            </div>
                        </div>  
                        <div v-show="TablaResponsables.length">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                        <th>Operador</th>                                         
                                        <th>Responsabilidad</th>                                                 
                                        <th colspan="2">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item,k) in TablaResponsables" :key="k">
                                            <td> {{ item.user.name}}</td>                                                        
                                            <td> {{ item.responsabilidad}}</td>                                                                                                                     
                                            <td> <a  @click="RemoveResponsable(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a></td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                  </div>
                </div>  
                <div class="box box-danger">
                    <div class="box-header with-border">
                    <h3 class="box-title">Informes sin Parte Diario</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>                       
                        </div>
                    </div>
                    <div class="box-body">                         
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>SEL.</th>
                                            <th>TIPO</th>                                         
                                            <th>INFORME</th>  
                                            <th>OBRA</th> 
                                            <th>FECHA</th>                                                 
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(informe,k) in informes" :key="k">
                                            <td>
                                                <input type="checkbox" id="informe_sel" v-model="informes[k].informe_sel" @change="getInforme(k)" :disabled="(fecha_mysql != informe.fecha_formateada) || (obra != informe.obra)" >
                                            </td>
                                            <td> {{ informe.metodo}}</td>                                                        
                                            <td> {{ informe.numero_formateado}}</td>
                                            <td>{{ informe.obra}}</td>  
                                            <td> {{ informe.fecha_formateada}}</td>                                                                                                                      
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>                     
                    </div>
                </div>
                 <!-- Servicios  -->
                <div v-show="TablaServicios.length">
                    <div class="box box-danger" >
                        <div class="box-header with-border">
                        <h3 class="box-title">Servicios</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>                       
                            </div>
                        </div>
                        <div class="box-body"> 
                            
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="col-lg-1">METODO</th>
                                                    <th class="col-lg-8">DESCRIPCIÓN</th>       
                                                    <th class="col-lg-1">CANT</th>                                                                                                                                       
                                                    <th colspan="2">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item,k) in TablaServicios" :key="k"  @click="selectPosTablaServicios(k)">     
                                                    <td v-if="item.visible"> {{ item.metodo}}</td>  
                                                    <td v-if="item.visible"> {{ item.descripcion}}</td>   
                                                    <td v-if="item.visible">
                                                        <div v-if="indexTablaServicios == k ">       
                                                          <input type="number" v-model="TablaServicios[k].cant" maxlength="3">        
                                                        </div>   
                                                        <div v-else>
                                                           {{ item.cant }}
                                                        </div>                                   
                                                    </td>                                                                                                                    
                                                    <td v-if="item.visible"> <a  @click="RemoveTablaServicios(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a></td>
                                                    
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
                </div>
                  <!--Informe RI -->
                <div v-show="TablaInformesRi.length">
                    <div class="box box-danger" >
                        <div class="box-header with-border">
                        <h3 class="box-title">Informes RI</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>                       
                            </div>
                        </div>
                        <div class="box-body"> 
                            
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>INFORME</th>       
                                                    <th>COSTURAS</th>                                         
                                                    <th>PULGADAS</th>
                                                    <th>PLACAS</th> 
                                                    <th style="width:200px;">CM</th>                                                   
                                                    <th colspan="2">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item,k) in TablaInformesRi" :key="k"  @click="selectPosTablaInformesRi(k)">     
                                                    <td v-if="item.visible"> {{ item.numero_formateado}}</td>   
                                                  
                                                    <td v-if="item.visible">    
                                                                                                            
                                                        <div v-if="indexTablaInformesRi == k ">       
                                                          <input type="number" v-model="TablaInformesRi[k].costura_final" maxlength="4">        
                                                        </div>   
                                                        <div v-else>
                                                           {{ item.costura_final }}
                                                        </div>                                   
                                                    </td>                                              
                                                                                                        
                                                    <td v-if="item.visible"> {{ item.pulgadas_final}}</td> 
                                                    <td v-if="item.visible">
                                                        <div v-if="indexTablaInformesRi == k ">       
                                                          <input type="number" v-model="TablaInformesRi[k].placas_final" maxlength="4" step="0.1">        
                                                        </div>   
                                                        <div v-else>
                                                           {{ item.placas_final }}
                                                        </div>                                   
                                                    </td>                                                  
                                                    <td  v-if="item.visible" >                                                                                                            
                                                        <v-select type="text" v-model="TablaInformesRi[k].cm" label="codigo" id="cm" :options="cms" style="display: block"></v-select>                            
                                                       
                                                    </td>                                                                                                                  
                                                    <td v-if="item.visible"> <a  @click="RemoveTablaInformeRi(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a></td>
                                                    
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
                <!--Informe Pm -->
                <div v-show="TablaInformesPm.length">
                    <div class="box box-danger" >
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
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>INFORME</th>       
                                                    <th>PIEZA</th>                                         
                                                    <th>NÚMERO</th>
                                                    <th>METROS LINEALES</th>                                                                                                
                                                    <th colspan="2">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item,k) in TablaInformesPm" :key="k"  @click="selectPosTablaInformesPm(k)">     
                                                    <td v-if="item.visible"> {{ item.numero_formateado}}</td>   
                                                    <td v-if="item.visible">
                                                        <div v-if="indexTablaInformesPm == k ">       
                                                          <input type="text" v-model="TablaInformesPm[k].pieza_final" maxlength="10">        
                                                        </div>   
                                                        <div v-else>
                                                           {{ item.pieza_final }}
                                                        </div>                                   
                                                    </td>           
                                                                                                        
                                                    <td v-if="item.visible">
                                                        <div v-if="indexTablaInformesPm == k ">       
                                                          <input type="number" v-model="TablaInformesPm[k].nro_final" maxlength="11">        
                                                        </div>   
                                                        <div v-else>
                                                           {{ item.nro_final }}
                                                        </div>                                   
                                                    </td>   
                                                    
                                                    <td v-if="item.visible">
                                                        <div v-if="indexTablaInformesPm == k ">       
                                                          <input type="number" v-model="TablaInformesPm[k].metros_lineales" maxlength="4">        
                                                        </div>   
                                                        <div v-else>
                                                           {{ item.metros_lineales }}
                                                        </div>                                   
                                                    </td>
                                                                                                                                                                
                                                    <td v-if="item.visible"> <a  @click="RemoveTablaInformePm(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a></td>
                                                    
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
                    <div class="box box-danger" >
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
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>INFORME</th>       
                                                    <th>PIEZA</th>                                         
                                                    <th>NÚMERO</th>
                                                    <th>METROS LINEALES</th>                                                                                                
                                                    <th colspan="2">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item,k) in TablaInformesLp" :key="k"  @click="selectPosTablaInformesLp(k)">     
                                                    <td v-if="item.visible"> {{ item.numero_formateado}}</td>   
                                                    <td v-if="item.visible">
                                                        <div v-if="indexTablaInformesLp == k ">       
                                                          <input type="text" v-model="TablaInformesLp[k].pieza_final" maxlength="10">        
                                                        </div>   
                                                        <div v-else>
                                                           {{ item.pieza_final }}
                                                        </div>                                   
                                                    </td>           
                                                                                                        
                                                  
                                                    <td v-if="item.visible">
                                                        <div v-if="indexTablaInformesLp == k ">       
                                                          <input type="number" v-model="TablaInformesLp[k].nro_final" maxlength="11">        
                                                        </div>   
                                                        <div v-else>
                                                           {{ item.nro_final }}
                                                        </div>                                   
                                                    </td>   
                                                    
                                                    <td v-if="item.visible">
                                                        <div v-if="indexTablaInformesLp == k ">       
                                                          <input type="number" v-model="TablaInformesLp[k].metros_lineales" maxlength="4">        
                                                        </div>   
                                                        <div v-else>
                                                           {{ item.metros_lineales }}
                                                        </div>                                   
                                                    </td>
                                                                                                                                                                
                                                    <td v-if="item.visible"> <a  @click="RemoveTablaInformeLp(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a></td>
                                                    
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
                    <div class="box box-danger" >
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
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>INFORME</th>       
                                                    <th>COSTURA</th>                                         
                                                    <th>ELEMENTO</th>                                                                                                
                                                    <th>DIAMETRO</th>
                                                    <th colspan="2">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item,k) in TablaInformesUs" :key="k"  @click="selectPosTablaInformesUs(k)">    

                                                    <td v-if="item.visible"> {{ item.numero_formateado}}</td> 
          
                                                    <td v-if="item.visible">
                                                        <div v-if="(item.tecnica =='US' || item.tecnica =='PA')">
                                                            <div v-if="indexTablaInformesUs == k ">       
                                                                <input type="number" v-model="TablaInformesUs[k].costura_final" maxlength="4">   
                                                            </div>   
                                                            <div v-else>
                                                                {{ item.costura_final }}
                                                            </div>  
                                                        </div>   
                                                        <div v-else>
                                                            <td> &nbsp;</td>
                                                        </div>                                      
                                                    </td>                                     
                                                    
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
                                                            <td> &nbsp;</td>
                                                        </div>   
                                    
                                                    </td>
                                                    
                                                    <td v-if="item.visible"> {{ item.pulgadas_final}}</td>                                                                                                           
                                                    <td v-if="item.visible"> <a  @click="RemoveTablaInformeUs(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a></td>
                                                    
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
                        <div class="box box-danger" >
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
                                        <table class="table table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>INFORME</th>       
                                                    <th>OBSERVACIONES</th>                                                                                                                                      
                                                    <th colspan="2">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item,k) in TablaInformesImportados" :key="k"  @click="selectPosTablaInformesImportables(k)">     
                                                    <td v-if="item.visible && itemMetodo == item.metodo"> {{ item.numero_formateado}}</td>   
                                                    <td v-if="item.visible && itemMetodo == item.metodo">
                                                        <div v-if="indexTablaInformesImportados == k && itemMetodo == item.metodo">       
                                                              <input type="text" v-model="TablaInformesImportados[k].observaciones_final" maxlength="10">        
                                                        </div>   
                                                        <div v-else-if="itemMetodo == item.metodo">
                                                               {{ item.observaciones_final }}
                                                        </div>                                   
                                                    </td>          
                                                                                                                                                                
                                                    <td v-if="item.visible && itemMetodo == item.metodo"> <a  @click="RemoveTablaInformeiImportable(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a></td>
                                                    
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
import {eventHeaderParte} from '../event-bus';
import Datepicker from 'vuejs-datepicker';
import {mapState} from 'vuex';
import {en, es} from 'vuejs-datepicker/dist/locale';
import moment from 'moment';

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

      informes_importados_data : {
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
        en: en,
        es: es,
        obra:'',      
        fecha:'',   
        tipo_servicio:'',
        horario:'',
        movilidad_propia_sn:false,
        patente:'',
        km_inicial:'',
        km_final:'',
        observaciones:'',

        operador:'',
        operadores:[],

        responsabilidad:'',
        TablaResponsables:[],

      
        informes:[],
        informe_sel:false,

        informe_ri_parte:'',
        TablaInformesRi:[],
        TablaInformesPm:[],
        TablaInformesLp:[],
        TablaInformesUs:[],
        TablaInformesImportados:[],
        TablaMetodosImportados:[],
        TablaServicios:[],
        indexTablaInformesRi:'-1',
        indexTablaInformesPm:'-1',
        indexTablaInformesLp:'-1',
        indexTablaInformesUs:'-1',
        indexTablaInformesImportados:'-1',
        indexTablaServicios:'-1',
        cms:[],

    }},

    created : function() {

        this.getOperadoresOt();
        this.getCms();
        this.setEdit();   

    },

    mounted : function() {
        
     
    },   

    watch :{

        movilidad_propia_sn : function(val){

            if(!val){
            
                this.patente = '';
                this.km_inicial = '';
                this.km_final = '';            
            
            }
        },

        fecha : function(){

            this.resetInformesSelect();

        },

        
},

    computed :{

        ...mapState(['url','AppUrl']),     
        
        fecha_mysql : function(){

            return moment(this.fecha).format('DD/MM/YYYY');
        },
       
     },

    methods : {

        setEdit : function(){

            if(this.editmode) {
                
            
               this.TablaResponsables =  JSON.parse(JSON.stringify(this.responsables_data));  
               this.fecha   = this.parte_data.fecha;   
               this.tipo_servicio = this.parte_data.tipo_servicio;         
               this.horario = this.parte_data.horario;   
               this.movilidad_propia_sn = this.parte_data.movilidad_propia_sn;
               this.patente = this.parte_data.patente;
               this.km_final = this.parte_data.km_final;
               this.km_inicial = this.parte_data.km_inicial;
               this.observaciones = this.parte_data.observaciones;
               this.getInformesPendientesYEditableParte(); 

            }else{

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
            this.TablaInformesImportados=[];
            this.TablaMetodosImportados=[];

        },
        
        getOperadoresOt: function(){
             
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'ot-operarios/ot/' + this.otdata.id + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
            this.operadores = response.data
            });
        },

        selectPosTablaInformesRi :function(index){

            this.indexTablaInformesRi = index ;            

        },

       selectPosTablaInformesImportables :function(index){

            this.indexTablaInformesImportados = index ;            

        },

        selectPosTablaInformesPm :function(index){

            this.indexTablaInformesPm = index ;            

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
                
        getCms: function(){
             
            console.log('medidas/cm');
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'medidas/cm/' + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
            this.cms = response.data
            });
        }, 

        getInformesPendientesParte: function(){
             
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'informes/ot/' + this.otdata.id + '/pendientes_parte_diario' + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
            console.log(response.data);
            this.informes = response.data
            });
               
        },

        getInformesPendientesYEditableParte: function(){
             
             axios.defaults.baseURL = this.url ;
             var urlRegistros = 'informes/ot/' + this.otdata.id + '/parte/'+ this.parte_data.id + '/pendientes_editables_parte_diario' + '?api_token=' + Laravel.user.api_token;        
             axios.get(urlRegistros).then(response =>{
             this.informes = response.data
             console.log(this.informes_ri_data)   
            
                // Informes importados
                
                this.informes_importados_data.forEach(function(item_data){


                    this.informes.forEach(function(item_informe){                         

                        if((item_data.informe_importado_id == item_informe.id) && (item_informe.importable_sn)){

                                item_informe.informe_sel = true;
                                eventHeaderParte.$emit('set-obra-header',item_informe.obra);
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
                                  eventHeaderParte.$emit('set-obra-header',item_informe.obra);
                                }

                            });                    
                      
                    }.bind(this));

                    this.informes_ri_data.forEach(function(item){

                        let visible_sn = true;
                        if( !item.costura_final  &&  !item.pulgadas_final && !item.placas_final){

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
                            cm: item.cm  

                            }); 
                        }.bind(this));  
                        
                        //Informe Pm

                        this.informes_pm_data.forEach(function(item_data){


                            this.informes.forEach(function(item_informe){                         

                                if((item_data.informe_id == item_informe.id) && (!item_informe.importable_sn)){

                                    item_informe.informe_sel = true;
                                    eventHeaderParte.$emit('set-obra-header',item_informe.obra);

                                    }
                                });                    
                        
                        }.bind(this)); 

                        this.informes_pm_data.forEach(function(item){

                        let visible_sn = true;
                        if( !item.pieza_final  &&  !item.nro_final && !item.metros_lineales){

                            visible_sn = false

                        }

                        this.TablaInformesPm.push({ 

                            numero_formateado  : item.numero_formateado,              
                            pieza_original: item.pieza_original,
                            pieza_final: item.pieza_final,
                            nro_original : item.nro_original,    
                            nro_final : item.nro_final,          
                            id      : item.informe_id,
                            visible : visible_sn,   
                            metros_lineales: item.metros_lineales             

                            }); 
                        }.bind(this));   
                        
                        //Informe Lp

                        this.informes_lp_data.forEach(function(item_data){


                            this.informes.forEach(function(item_informe){                         

                                if((item_data.informe_id == item_informe.id) && (!item_informe.importable_sn)){

                                    item_informe.informe_sel = true;
                                    eventHeaderParte.$emit('set-obra-header',item_informe.obra);

                                    }
                                });                    
                        
                        }.bind(this)); 

                        this.informes_lp_data.forEach(function(item){

                        let visible_sn = true;
                        if( !item.pieza_final  &&  !item.nro_final && !item.metros_lineales){

                            visible_sn = false

                        }

                        this.TablaInformesLp.push({ 

                            numero_formateado  : item.numero_formateado,              
                            pieza_original: item.pieza_original,
                            pieza_final: item.pieza_final,
                            nro_original : item.nro_original,    
                            nro_final : item.nro_final,    
                            pieza_original: item.pieza_original,
                            pieza_final: item.pieza_final,      
                            id      : item.informe_id,
                            visible : visible_sn,   
                            metros_lineales: item.metros_lineales             

                            }); 
                        }.bind(this));

                       //Informe Us 

                       this.informes_us_data.forEach(function(item_data){

                            this.informes.forEach(function(item_informe){                         

                                if((item_data.informe_id == item_informe.id) && (!item_informe.importable_sn)){

                                    item_informe.informe_sel = true;
                                    eventHeaderParte.$emit('set-obra-header',item_informe.obra);
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
                            
                                }); 

                        }.bind(this));
             });
       
         },

        existeResponsable : function(id){

            let existe = false;
            this.TablaResponsables.forEach(function (responsable) {           
               
                if(responsable.user.id == id){              
                    existe = true ;
                }
                
            });

            return existe;
        },


        addResponsable(id) {

            if(!this.operador){
                toastr.error("El campo Operador es obligatorio");         
                 return;            
            }

            if(!this.responsabilidad){
                toastr.error("El campo Responsabilidad es obligatorio");         
                return;            
            }     
            
            if(this.existeResponsable(id)){

                toastr.error('El responsable ya existe en el parte');  
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

        RemoveTablaInformeiImportable(index){
            
            this.TablaInformesImportados[index].visible = false;
            this.TablaInformesImportados[index].observaciones_final=''; 

        },

        RemoveTablaInformeRi(index){
            
            this.TablaInformesRi[index].visible = false;
            this.TablaInformesRi[index].costura_final='';
            this.TablaInformesRi[index].placas_final='';
            this.TablaInformesRi[index].pulgadas_final=''
            this.TablaInformesRi[index].cm=''

        },

        RemoveTablaInformePm(index){
            
            this.TablaInformesPm[index].visible = false;
            this.TablaInformesPm[index].pieza_final='';
            this.TablaInformesPm[index].nro_final='';
            this.TablaInformesPm[index].metros_lineales=''       

        },

        RemoveTablaInformeUs(index){
            
            this.TablaInformesUs[index].visible = false;
            this.TablaInformesUs[index].pieza_final='';
            this.TablaInformesUs[index].costura_final='';    
            this.TablaInformesUs[index].pulgadas_final=''          

        },

        getInforme(index){

            console.log(this.informes[index]);

            if(this.informes[index].informe_sel){
               
                if(this.informes[index].importable_sn){
                    this.getInformesImportado(this.informes[index].id,index);

                }else{
                    
                    switch  (this.informes[index].metodo){
    
                      case 'RI' : this.getInformeRI(this.informes[index].id,index);break;
    
                      case 'PM' : this.getInformePM(this.informes[index].id,index);break;
    
                      case 'LP' : this.getInformeLP(this.informes[index].id,index);break;
    
                      case 'US' : this.getInformeUs(this.informes[index].id,index);break;

                    }
  
                }
               //  this.getOtServicio(this.informes[index].metodo_ensayo_id);

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

                }
                
            }

        },

        getInformesImportado(id,index){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'partes/informe_importado/' + id + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{

                console.log(response.data);
                console.log('entro en informes importados');
                let informe_importado_parte = response.data;
            
                this.TablaInformesImportados.push({
                    
                    id:id,
                    numero_formateado : this.informes[index].numero_formateado,
                    visible: true,
                    metodo:this.informes[index].metodo,
                    observaciones_original:informe_importado_parte.observaciones,
                    observaciones_final:informe_importado_parte.observaciones

                })

               this.AddMetodoImportados(this.informes[index].metodo);

            })

        },

        getOtServicio(metodo_ensayo_id){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'ot_servicios/ot/' + this.otdata.id + '/metodo_ensayo/' + metodo_ensayo_id + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
                
                let ot_servicios = response.data;
                console.log('ot_servicios:' ,ot_servicios);
              

                ot_servicios.forEach(function(item) {

                    console.log(this.TablaServicios.indexOf(item.id));

                   if(this.TablaServicios.findIndex(elemento => elemento.id === item.id) != -1){
                       this.TablaServicios[this.TablaServicios.findIndex(elemento => elemento.id ===item.id)].cant +=1; 
                   }else{
                       console.log(item.id);
                       console.log(item.id);
                       this.TablaServicios.push({

                           id : item.id,
                           metodo: item.metodo,
                           descripcion:item.servicio_descripcion,
                           visible : true,
                           cant: 1,

                       })
                   }
                    
                }.bind(this));
                
            });

        },

        AddMetodoImportados(metodo){

            this.TablaMetodosImportados.indexOf(metodo) === -1 ? this.TablaMetodosImportados.push(metodo) : console.log("This item already exists");

        },

        getInformeRI(id,index){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'partes/informe_ri/' + id + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{

            this.informe_ri_parte = response.data              

                this.TablaInformesRi.push({ 
                id      : id,
                numero_formateado  : this.informes[index].numero_formateado,              
                costura_original: this.informe_ri_parte[0].costuras,
                pulgadas_original: this.informe_ri_parte[0].pulgadas,
                placas_original : this.informe_ri_parte[0].placas,              
                visible : true,   
                costura_final: this.informe_ri_parte[0].costuras,
                pulgadas_final: this.informe_ri_parte[0].pulgadas,
                placas_final : this.informe_ri_parte[0].placas, 
                cm: '', 
                metodo : this.informe_ri_parte[0].metodo

             });  
                    
            });
           
        },

        getInformePM(id,index){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'partes/informe_pm/' + id + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{

            this.informe_pm_parte = response.data   

            this.informe_pm_parte.forEach(function(item){

                this.TablaInformesPm.push({ 
                    id      : id,
                    numero_formateado  : this.informes[index].numero_formateado,               
                    visible : true,
                    pieza_original : item.pieza,
                    pieza_final : item.pieza,
                    nro_original : item.numero,
                    nro_final : item.numero,
                    metros_lineales : '', 
                    metodo : item.metodo
                    
                    });                       

                }.bind(this));
           
            });

            },

        getInformeLP(id,index){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'partes/informe_lp/' + id + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
            console.log(urlRegistros);
            console.log(response.data);
            this.informe_lp_parte = response.data   

            this.informe_lp_parte.forEach(function(item){

                this.TablaInformesLp.push({ 
                    id      : id,
                    numero_formateado  : this.informes[index].numero_formateado,               
                    visible : true,
                    pieza_original : item.pieza,
                    pieza_final : item.pieza,
                    nro_original : item.numero,
                    nro_final : item.numero,
                    metros_lineales : '', 
                    metodo : item.metodo
                    
                    });                       

                }.bind(this));
           
            });
        },

        getInformeUs(id,index){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'partes/informe_us/' + id + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
            this.informe_us_parte = response.data 
            
            this.informe_us_parte.forEach(function(item){                    

                if(item.tecnica.codigo =='US' || item.tecnica.codigo =='PA'){

                        this.TablaInformesUs.push({ 
                           id      : id,
                           numero_formateado  : this.informes[index].numero_formateado,               
                           visible : true,
                           metodo : item.metodo,
                           tecnica : item.tecnica.codigo,
                           costura_original: item.costuras,
                           costura_final: item.costuras,
                           pulgadas_original: item.pulgadas,
                           pulgadas_final: item.pulgadas,
                           pieza_original : '',
                           pieza_final : '',
                        
                        });  

                }else if(item.tecnica.codigo =='ME'){

                         this.TablaInformesUs.push({ 

                            id      : id,
                            numero_formateado  : this.informes[index].numero_formateado,               
                            visible : true,
                            costura_original: '',
                            costura_final:'',
                            metodo : item.metodo,
                            tecnica : item.tecnica.codigo,
                            pieza_original : item.pieza,
                            pieza_final : item.pieza,
                            pulgadas_original: item.pulgadas,
                            pulgadas_final: item.pulgadas,                      
                        
                        });
               }  
                                     
          

            }.bind(this));
           
            });

            },

        validarCmsRi: function(){

                let valido = true;

                this.TablaInformesRi.forEach(function(item){

                    if((item.costura_final || item.pulgadas_final || item.placas_final) && !item.cm ){

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

        Store : function(){
         
            if(!this.validarCmsRi()){
  
                  toastr.error('EL campo CM en los informes RI asignados al Parte son obligatorios');
                  return;
            }

            this.errors =[];

            if(!this.validarResponsables()){
  
                toastr.error('El Parte debe tener al menos 1 responsable');
                return;
                }

            this.errors =[];

          
            var urlRegistros = 'partes' ;      
            axios({
              method: 'post',
              url : urlRegistros,    
              data : {             
                'ot'                   : this.otdata,                  
                'fecha'                : this.fecha,
                'tipo_servicio'        : this.tipo_servicio,
                'horario'              : this.horario,     
                'movilidad_propia_sn'  : this.movilidad_propia_sn,
                'patente'              : this.patente,          
                'km_inicial'           : this.km_inicial,    
                'km_final'             : this.km_final,
                'observaciones'        : this.observaciones, 
                'responsables'         :this.TablaResponsables, 
                'informes_ri'          :this.TablaInformesRi,
                'informes_pm'          :this.TablaInformesPm,
                'informes_lp'          :this.TablaInformesLp,     
                'informes_us'          :this.TablaInformesUs,
                'informes_importados'  :this.TablaInformesImportados       
    
          }
          
          }).then(response => {
          this.response = response.data
          toastr.success('Parte Diario con fecha' +  this.fecha + ' fue creado con éxito ');
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

            if(!this.validarCmsRi()){

                toastr.error('EL campo CM en los informes RI asignados al Parte son obligatorios');
                return;

                }

            if(!this.validarResponsables()){
                
                toastr.error('El Parte debe tener al menos 1 responsable');
                return;
                }

            console.log('entro para actualizar' );
            this.errors =[];        
            var urlRegistros = 'partes/' + this.parte_data.id  ;      
            axios({
              method: 'put',
              url : urlRegistros,    
              data : {
                'ot'                   : this.otdata,                  
                'fecha'                : this.fecha,
                'tipo_servicio'        : this.tipo_servicio,
                'horario'              : this.horario,     
                'movilidad_propia_sn'  : this.movilidad_propia_sn,
                'patente'              : this.patente,          
                'km_inicial'           : this.km_inicial,    
                'km_final'             : this.km_final,
                'observaciones'        : this.observaciones, 
                'responsables'         :this.TablaResponsables,
                'informes_ri'          :this.TablaInformesRi,
                'informes_pm'          :this.TablaInformesPm,        
                'informes_lp'          :this.TablaInformesLp,
                'informes_us'          :this.TablaInformesUs,
                'informes_importados'  :this.TablaInformesImportados                   
          }}
           
        ).then(response => {
          this.response = response.data
          toastr.success('Parte Diario con fecha' +  this.fecha + ' fue actualizado con éxito ');
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

        }
    }
    
}
</script>

<style scoped>

.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
     background-color: #eee;
}
</style>