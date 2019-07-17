<template>
 <div class="col-md-12">
  <form @submit.prevent="submit"  method="post">
    <div class="box box-danger">
      <div class="box-body">
        <div class="col-md-6">
          <div class="form-group">
            <label for="proyecto">Proyecto</label>
            <input type="text" v-model="proyecto" class="form-control" id="proyecto" placeholder="">
          </div>
        </div>
      </div>
    </div>    
    <div class="box box-danger">
      <div class="box-body">
        <div class="col-md-3">
          <div class="form-group">
            <label for="ot">OT Nº</label>
            <input v-model="ot" type="number" class="form-control" id="ot" placeholder="">
          </div>
        </div>
      <div class="col-md-3">
        <div class="form-group">
          <label for="fts">FTS Nº</label>
          <input v-model="fts" type="number" class="form-control" id="fts" placeholder="">
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
        <div class="bootstrap-timepicker">
              <div class="form-group">
                <label>Hora</label>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                  </div>
                  <timeselector v-model="hora"></timeselector>
                </div>
              </div>
          </div>
        </div> 
        <div class="col-md-6">                       
          <div class="form-group">
              <label>Cliente</label>
              <v-select v-model="cliente" label="nombre_fantasia" :options="clientes" @input="getContactos()"></v-select>   
          </div>      
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="fts">Obra Nº</label>
            <input v-model="obra" type="number" class="form-control" id="obra" placeholder="">
          </div>
        </div>        
        <div class="col-md-3">
          <div class="form-group">
            <label for="fecha">Fecha estimada de ensayo</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <Datepicker v-model="fecha_ensayo" :input-class="'form-control pull-right'" :language="es"></Datepicker>   
              </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
              <label>Contacto 1</label>
              <v-select v-model="contacto1" name="contacto_1" label="nombre" :options="contactos"></v-select>   
            </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
              <label>Contacto 2</label>
              <v-select v-model="contacto2" name="contacto_2" label="nombre" :options="contactos"></v-select>   
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
              <label>Contacto 3</label>
              <v-select v-model="contacto3" name="contacto_3" label="nombre" :options="contactos"></v-select>   
          </div>
        </div>
      </div>
    </div>
    <div class="box box-danger">
      <div class="box-body">
        <div class="col-md-6">
          <div class="form-group">
            <label for="lugar_ensayo">Lugar de ensayo</label>
            <input v-model="lugar_ensayo" type="text" class="form-control" id="lugar_ensayo" placeholder="">
          </div>        
          <div class="form-group">
            <label>Provincia</label>
            <v-select v-model="provincia" label="provincia" :options="provincias" @input="getLocalidades()"></v-select>   
          </div>
          <div class="form-group">
            <label>Localidad</label>
            <v-select v-model="localidad" label="localidad" :options="localidades" @input="sync()"></v-select>   
          </div>
          <div class="form-group">
            <label for="search">Buscar Ubicación</label>
            <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-search"></i>
                </div>
                <gmap-autocomplete class="form-control"
                @place_changed="setPlace"
                :select-first-on-enter="true">
                  >
              </gmap-autocomplete>
            </div>
          </div>
          <div class="form-group">
            <label for="latitud">Latitud</label>
            <input type="text" 
            class="form-control" id="latitud"
            v-model.number.lazy="localidad.lat"
            @change="sync"
            />
          </div>
       
        
          <div class="form-group">
            <label for="longitud">Longitud</label>
            <input type="text" 
            class="form-control" id="longitud"
            v-model.number.lazy="localidad.lon"
            @change="sync"            
            />
          </div>
        </div>         
       
        <div class="col-md-6">
          <gmap-map :center="mapCenter" :zoom="12"
              ref="map"
              @center_changed="updateCenter"
              @idle="sync"
              class="map-container">
              <GmapMarker
                :key="index"
                v-for="(m, index) in markers"
                :position="m.position"
                :clickable="true"
                :draggable="true"
                @click="center=m.position"
                @drag="updateCenter($event.latLng)"
              />
          </gmap-map>
        </div>
      </div>
    </div>
    <div class="box box-danger">
      <div class="box-body">       
             
        <div class="col-md-6">
          <div class="form-group">
              <label>Servicios</label>
              <v-select v-model="servicio" label="descripcion" :options="servicios" id="servicios"></v-select>
          </div>  
        </div>  
        <div class="col-md-6">
          <div class="form-group">  
              <label>Norma Ensayos</label>               
            <v-select v-model="norma_ensayo" label="descripcion" :options="norma_ensayos"></v-select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group"> 
             <label>Norma Evaluación</label>                   
            <v-select v-model="norma_evaluacion" label="descripcion" :options="norma_evaluaciones"></v-select>
          </div>   
        </div> 
        <div class="col-md-3">
          <div class="form-group">
              <label>Max N° Placas</label>                  
              <input  v-model="cantidad_placas" type="number" class="form-control" id="cantidad_placas" placeholder="">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group"> 
              <label>Cant.</label>                 
              <input v-model="cantidad_servicios" type="number" class="form-control" id="cantidad_servicios" placeholder="">
          </div>
        </div>   
        <div class="col-md-1"> 
            <div class="form-group">                    
          <span>
              <i class="fa fa-plus-circle" @click="addServicio()"></i>
          </span>
            </div>
        </div>
        <div v-show="inputsServicios.length">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-hover table-striped">
                <thead>
                  <tr>
                    <th style="width: 500px" >Servicio</th>
                    <th>Ref</th>
                    <th>Norma Ensayo</th>
                    <th>Norma Evaluacion</th>
                    <th>Proc.</th>
                    <th>Cant Placas</th>
                    <th>Cant Serv</th>
                    <th colspan="2">&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(inputsServicio,k) in inputsServicios" :key="k">
                    <td> {{ inputsServicio.servicio}}</td>
                    <td> <span :class="{existe : (inputsServicio.observaciones || 
                    inputsServicio.path1 || 
                    inputsServicio.path2 || 
                    inputsServicio.path3 || 
                    inputsServicio.path4)  }" class="fa fa-file-archive-o" @click="OpenReferencias($event,k,'servicios',inputsServicio)" ></span></td>      
                    <td> {{ inputsServicio.norma_ensayo}}</td>
                    <td> {{ inputsServicio.norma_evaluacion}}</td>
                    <td>  
                      <input type="checkbox" id="checkbox" v-model="inputsServicios[k].procedimiento_sn">                     
                    </td>
                    <td> {{ inputsServicio.cantidad_placas}}</td>
                    <td> {{ inputsServicio.cantidad_servicios}}</td>
                    <td> <i class="fa fa-minus-circle" @click="removeServicio(k)" ></i></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>   
      </div>
    </div>
    <div v-show ="Ri">
      <div class="box box-danger">
        <div class="box-body">
          <div class="col-md-6">
            <div class="form-group">
              <label>Calidad de placas</label> 

              <v-select multiple v-model="peliculas_selected" :options="tipo_peliculas" label="codigo">
              <template slot="option" slot-scope="option">
                 <span class="upSelect">{{ option.codigo }}</span> <br> 
                  <span class="downSelect"> {{ option.fabricante }} </span>
              </template>

            </v-select>
            </div>    
          </div>
        </div>
      </div>
    </div>

    <div class="box box-danger">
      <div class="box-body">
        <div class="col-md-6">
          <div class="form-group">
              <label>Productos</label>
              <v-select v-model="producto" label="descripcion" :options="productos" id="productos" @input="getMedidasProducto()"></v-select>
            </div>  
          </div>  
          <div class="col-md-3">
            <div class="form-group">  
              <label>Medidas</label>           

              <v-select v-model="medida" :options="medidas" label="descripcion">
              <template slot="option" slot-scope="option">
                 <span class="upSelect">{{ option.descripcion }} </span> 
                  <span class="downSelect">   {{ option.codigo }} </span>
              </template>
              </v-select>

            </div>
          </div> 
          <div class="col-md-3">
            <div class="form-group"> 
                <label>Cant.</label>                 
                <input v-model="cantidad_productos" type="number" class="form-control" id="cantidad_productos" placeholder="">
            </div>
          </div>  
          <div class="col-md-1"> 
            <div class="form-group">                    
              <span>
                  <i class="fa fa-plus-circle" @click="addProducto()"></i>
              </span>
            </div>
          </div> 
          <div v-show="inputsProductos.length">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-hover table-striped">
                  <thead>
                    <tr>
                      <th style="width: 500px">Productos</th>
                      <th>Ref</th>
                      <th>Medidas</th>                     
                      <th>cant</th>                    
                      <th colspan="2">&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(inputsProducto,k) in inputsProductos" :key="k">
                      <td> {{ inputsProducto.producto}}</td>
                      <td> <span :class="{ existe : (inputsProducto.observaciones ||
                                          inputsProducto.path1 ||
                                          inputsProducto.path2 ||
                                          inputsProducto.path3 ||
                                          inputsProducto.path4 )                      
                      }" class="fa fa-file-archive-o" @click="OpenReferencias($event,k,'productos',inputsProducto)" ></span></td>                       
                      <td> {{ inputsProducto.medida}}&nbsp; &nbsp; {{inputsProducto.unidad_medida_codigo }}</td>  
                      <td> {{ inputsProducto.cantidad_productos}}</td>                                  
                      <td> <i class="fa fa-minus-circle" @click="removeProducto(k)" ></i></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>            
      </div>
    </div>
    <div class="box box-danger">
      <div class="box-body">
        <div class="col-md-6">
          <div class="form-group">
            <label>Elementos de seguridad</label>
            <v-select v-model="epp" label="descripcion" :options="epps" id="epps"></v-select>
          </div> 
         
            <div class="form-group">                    
              <span>
                  <i class="fa fa-plus-circle" @click="addEpp()"></i>
              </span>
            </div>
          <div v-show="inputsEpps.length">           
              <div class="table-responsive">
                <table class="table table-hover table-striped">
                  <thead>
                    <tr>
                      <th>EPPS</th>                                   
                      <th colspan="2">&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(inputsEpp,k) in inputsEpps" :key="k">
                      <td> {{ inputsEpp.descripcion}}</td>                                  
                      <td> <i class="fa fa-minus-circle" @click="removeEpp(k)" ></i></td>
                    </tr>
                  </tbody>
                </table>
              </div>            
          </div> 
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Riesgos</label>
            <v-select v-model="riesgo" label="descripcion" :options="riesgos" id="riesgos"></v-select>
          </div> 
         
            <div class="form-group">                    
              <span>
                  <i class="fa fa-plus-circle" @click="addRiesgo()"></i>
              </span>
            </div>
          <div v-show="inputsRiesgos.length">           
              <div class="table-responsive">
                <table class="table table-hover table-striped">
                  <thead>
                    <tr>
                      <th>Riesgos</th>                                   
                      <th colspan="2">&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(inputsRiesgo,k) in inputsRiesgos" :key="k">
                      <td> {{ inputsRiesgo.descripcion}}</td>                                  
                      <td> <i class="fa fa-minus-circle" @click="removeRiesgo(k)" ></i></td>
                    </tr>
                  </tbody>
                </table>
              </div>            
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
      <create-referencias :index="index_referencias" :tabla="tabla" :inputsData="inputs" @setReferencia="AddReferencia"></create-referencias>
    </div>

    <!--  <h1 v-if="Laravel.user.can['clientes.edit']">You have permission to manage users</h1> -->
         <button class="btn btn-primary" type="submit" @click.prevent="submit">Guardar</button>   
    </form>
  </div>  

</template>

<script>

import {mapState} from 'vuex'
import Datepicker from 'vuejs-datepicker';
import {en, es} from 'vuejs-datepicker/dist/locale'
import Timeselector from 'vue-timeselector';
import { eventSetReferencia } from '../event-bus';


export default {

  components: {
      Datepicker,
      Timeselector
  },
   props: {
     otdata : {
       type : Object,
       required : false
     },
     clientedata : {
       type : Object,
       required : false
     },
     ot_serviciosdata : {
       type : Array,
       required : false
     },
     ot_productosdata : {
       type : Array,
       required : false
     },
     ot_eppsdata : {
       type : Array,
       required : false
     },
     ot_calidad_placasdata : {
       type : Array,
       required : false
     },
     
     ot_riesgosdata : {
       type : Array,
       required : false
     },
     otcontacto1data : {
       type : Object,
       required : false
     },
     otcontacto2data : {
       type : [ Object, Array ],
       required : false,
      
     },
     ot_provinciasdata : {
       type : [ Object, Array ],
       required : false,
      
     },
     ot_localidaddata : {
       type : [ Object, Array ],
       required : false,
      
     },
      otcontacto3data : {
       type : [ Object, Array ],
       required : false,
      
     },
    
     acciondata : {
       type : String,
       required :true
     }
   
   },
     
    
    data() { return {
         
        errors:[],
         en: en,
         es: es,
         markers: [{
            position: {
              lat: '',
              lng: ''
            }}
          ],
          accion:'',
          mapCenter: {
            lat: '',
            lng: ''
          },
          pov: {
            pitch: 0,
            heading: 0,
          },        
          proyecto:'',
          fecha:'',        
          fecha_ensayo:'',
          hora: '',
          clientes:[],
          cliente: {
            id: null
          },
          ot:'',
          fts:'',
          lugar_ensayo:'',
          obra:'',
          contactos:[],
          contacto1:[] ,
          contacto2:[] ,
          contacto3:[] ,
          observaciones:'',
          localidades:[],
          localidad: {
            
            lat : -34.603684400000011,
            lon : -58.381559100000004
          },
          provincias:[],
          provincia: '',

          servicios:[],
          norma_ensayos :[],
          norma_evaluaciones :[],
          servicio:'',        
          norma_ensayo :'',
          norma_evaluacion :'',
          inputsServicios: [],

          peliculas_selected:[],
          tipo_peliculas:[],
          Ri : false, 
          ri_id :'',

          productos :[],
          producto :'',
          medidas:[],
          medida:'',
          cantidad_productos:'1',
          inputsProductos: [],

          metodo_ensayos:[],
          var_metodo:'',

          epps:[],
          epp:'',
          inputsEpps:[],

          riesgos:[],
          riesgo:'',
          inputsRiesgos:[],
         
          response: {},
          cantidad_placas:'',
          cantidad_servicios:'1',

          index_referencias:'',
          tabla:'',
          inputs:{},

          t:'',
          d:'' 
          }
    },
    created : function(){
        
        this.getClientes();
        console.log(process.env.MIX_API_URL_DEV);
        this.getProvincias();
        this.getServicios();
        this.getTipoPeliculas();
        this.getProductos();
        this.getEpps();
        this.getRiesgos();
        this.getMetodosEnsayos();        
        this.getNormaEnsayos();
        this.getNormaEvaluaciones();
        this.setOt();        
        this.sync();
        this.accion = this.acciondata;
      },
    mounted : function(){
      

       $('#datepicker').datepicker({
           autoclose: true
        }),

       $('.timepicker').timepicker({
          showInputs: false
    })
    },
    computed :{

        ...mapState(['url'])
     },

     watch : {

       metodo_ensayos: function(metodo_ensayo) {
        
         metodo_ensayo.forEach(function(metodo){
              if(metodo.metodo == 'RI'){               
                 this.ri_id = metodo.id
              }
            }.bind(this));  
       },

       inputsServicios : {
         
         handler : function(servicios,oldservicios) {
        
          console.log('-----');
          let existeRi = false;
          servicios.forEach(function(servicio) {
              console.log(servicio.metodo);         
              
              if(servicio.metodo == 'RI'){                 
                  existeRi = true; 
              } 
          }.bind(this));           
           this.Ri = existeRi;
           if(this.Ri == false){
              this.peliculas_selected=[]
           }     
         },
         deep:true
       }
     },
   
    methods :{

      setOt : function(){


              if(this.acciondata == "edit"){ 

                this.id              = this.otdata.id,
                this.proyecto        = this.otdata.proyecto;
                this.fecha           = this.otdata.fecha_hora;
                this.t = this.otdata.fecha_hora.split(/[- :]/);
                this.d = new Date(Date.UTC(this.t[0], this.t[1]-1, this.t[2], this.t[3], this.t[4], this.t[5]));
                this.hora            = this.d;
                this.cliente         = this.clientedata;
                this.getContactos();
                this.ot              = this.otdata.numero;
                this.fts             = this.otdata.presupuesto;
                this.provincia       = this.ot_provinciasdata; 
                this.localidad       = this.ot_localidaddata; 
                this.obra            = this.otdata.obra;
                this.observaciones   = this.otdata.observaciones;
                this.fecha_ensayo    = this.otdata.fecha_estimada_ensayo;               
                this.contacto1       = this.otcontacto1data;
                if(this.otcontacto2data != null)
                     this.contacto2       = this.otcontacto2data;
                if(this.otcontacto3data != null)
                     this.contacto3       = this.otcontacto3data;

                this.lugar_ensayo    = this.otdata.lugar;
                this.localidad.lat   = this.otdata.lat;
                this.localidad.lon   = this.otdata.lon;
                this.inputsServicios = this.ot_serviciosdata;
                this.peliculas_selected = this.ot_calidad_placasdata;
                this.inputsProductos = this.ot_productosdata;
                this.inputsRiesgos   = this.ot_riesgosdata;
                this.inputsEpps      = this.ot_eppsdata;                
          
               }
              console.log(this.ot_productosdata);

              },      

      getClientes : function(){

                axios.defaults.baseURL = this.url ;
                
                var urlRegistros = 'clientes' + '?api_token=' + Laravel.user.api_token;             
                axios.get(urlRegistros).then(response =>{
                this.clientes = response.data
                });
              },
      getContactos : function(){
                this.contacto1 = '';
                this.contacto2 = '';
                this.contacto3 = '';
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'contactos/' + this.cliente.id + '?api_token=' + Laravel.user.api_token;    
                axios.get(urlRegistros).then(response =>{
                this.contactos = response.data
                });
              },
      getMedidasProducto : function(){
                this.medida = '';               
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'medidas/' + this.producto.unidades_medida_id + '?api_token=' + Laravel.user.api_token;         
                axios.get(urlRegistros).then(response =>{
                this.medidas = response.data
                });
              },
      getProvincias : function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'provincias' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.provincias = response.data
                });
              },
      getLocalidades : function(){
                this.localidades=[];
                this.localidad ='';
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'localidades/' + this.provincia.id + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.localidades = response.data
                });
              },
       getServicios : function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'servicios' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.servicios = response.data
                });
              },
        getTipoPeliculas : function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'tipo_peliculas' + '?api_token=' + Laravel.user.api_token;          
                axios.get(urlRegistros).then(response =>{
                this.tipo_peliculas = response.data
                });
              },
        getProductos : function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'productos' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.productos = response.data
                });
              },
        getEpps : function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'epps' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.epps = response.data
                });
              },
        getRiesgos : function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'riesgos' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.riesgos = response.data
                });
              },
       getMetodosEnsayos: function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'metodo_ensayos' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.metodo_ensayos = response.data
                });
              },
        getNormaEnsayos: function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'norma_ensayos' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.norma_ensayos = response.data
                });
              },
        getNormaEvaluaciones: function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'norma_evaluaciones' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.norma_evaluaciones = response.data
                });
              },
              

      updateCenter(latLng) {

                this.localidad.lat = latLng.lat() ;
                this.localidad.lon = latLng.lng() ;
                
              },
      sync () {

             
              
                this.mapCenter.lat = parseFloat(this.localidad.lat);
                this.mapCenter.lng = parseFloat(this.localidad.lon);
                this.markers[0].position.lat =parseFloat(this.localidad.lat);
                this.markers[0].position.lng = parseFloat(this.localidad.lon);
              
            
              },
              
      setPlace(place) {
       
                            
                this.localidad.lat = place.geometry.location.lat();
                this.localidad.lon = place.geometry.location.lng();
                this.sync();
      
             },
      getMetodo : function($id){

            this.metodo_ensayos.forEach( function(metodo) {
                  console.log(metodo.id + ' ' + $id + ' '+ metodo.metodo );                 
                
                 if(metodo.id == $id){
                    this.var_metodo = metodo.metodo;
                 }
            }.bind(this));
      },
      addServicio(index) {            

            this.getMetodo(this.servicio.metodo_ensayo_id);        
           
            this.inputsServicios.push({ 
                id:this.servicio.id,
                servicio:this.servicio.descripcion,            
                norma_ensayo :(this.norma_ensayo ? this.norma_ensayo.descripcion : null),
                norma_ensayo_id : (this.norma_ensayo ? this.norma_ensayo.id : null),
                norma_evaluacion :(this.norma_evaluacion ? this.norma_evaluacion.descripcion : null),
                norma_evaluacion_id :(this.norma_evaluacion ? this.norma_evaluacion.id : null),
                cantidad_placas:this.cantidad_placas,
                cantidad_servicios:this.cantidad_servicios,
                metodo : this.var_metodo,
                procedimiento_sn : false ,
                observaciones : '',                
                path1:null,
                path2:null,
                path3:null,
                path4:null
                 });
            this.servicio='',        
            this.norma_ensayo ='',
            this.norma_evaluacion ='',           
            this.cantidad_placas='',
            this.cantidad_servicios='1'

        },     

      addProducto(index) {
            this.inputsProductos.push({ 
                id:this.producto.id,
                producto:this.producto.descripcion,            
                medida : this.medida.descripcion,  
                medida_id :this.medida.id,
                unidad_medida_id :this.producto.unidades_medida_id,            
                cantidad_productos:this.cantidad_productos,
                unidad_medida_codigo : this.medida.codigo,
                observaciones : '',                
                path1:null,
                path2:null,
                path3:null,
                path4:null
                 });
            this.producto='',        
            this.medida ='',       
            this.cantidad_productos='1'

        },
      addEpp(index) {
            this.inputsEpps.push({ 
                descripcion:this.epp.descripcion,
                id:this.epp.id        
                 });
            this.epp=''          

        },
      addRiesgo(index) {
            this.inputsRiesgos.push({ 
                 descripcion:this.riesgo.descripcion,
                 id:this.riesgo.id        
                 });
            this.riesgo=''          

        },

      
      removeServicio(index) {
            this.inputsServicios.splice(index, 1);
        },
      removeProducto(index) {
            this.inputsProductos.splice(index, 1);
        },
      removeEpp(index) {
            this.inputsEpps.splice(index, 1);
        },
      removeRiesgo(index) {
            this.inputsRiesgos.splice(index, 1);
        },
      OpenReferencias(event,index,tabla,inputsReferencia){

          this.index_referencias = index ;
          this.tabla = tabla;
          this.inputs = inputsReferencia ;
          console.log(inputsReferencia);
          eventSetReferencia.$emit('open');
      },

      AddReferencia(Ref){      

          if (Ref.tabla =='servicios'){
           this.inputsServicios[this.index_referencias].observaciones = Ref.observaciones;
           this.inputsServicios[this.index_referencias].path1 = Ref.path1;
           this.inputsServicios[this.index_referencias].path2 = Ref.path2;
           this.inputsServicios[this.index_referencias].path3 = Ref.path3;
           this.inputsServicios[this.index_referencias].path4 = Ref.path4;
          }
          if (Ref.tabla =='productos'){
           this.inputsProductos[this.index_referencias].observaciones = Ref.observaciones;
           this.inputsProductos[this.index_referencias].path1 = Ref.path1;
           this.inputsProductos[this.index_referencias].path2 = Ref.path2;
           this.inputsProductos[this.index_referencias].path3 = Ref.path3;
           this.inputsProductos[this.index_referencias].path4 = Ref.path4;
          }          
      
        
           $('#nuevo').modal('hide');     
      },


      submit()
       {        
         

        if(this.accion == 'create'){
            this.errors =[];
         
            var urlRegistros = 'ots' ;      
            axios({
              method: 'post',
              url : urlRegistros,    
              data : {
            
              'cliente'       : this.cliente.id,
              'proyecto'      : this.proyecto,
              'fecha'         : this.fecha,
              'hora'          : this.hora,
              'ot'            : this.ot,
              'fts'           : this.fts,
              'obra'          : this.obra,
              'contacto1'     : this.contacto1.id,
              'contacto2'     : this.contacto2.id,
              'contacto3'     : this.contacto3.id,
              'provincia'     : this.provincia.id,
              'localidad'     : this.localidad.id,
              'fecha_ensayo'  : this.fecha_ensayo,
              'lugar_ensayo'  : this.lugar_ensayo,
              'tipo_peliculas': this.peliculas_selected,
              'lat'           : this.localidad.lat,
              'lon'           : this.localidad.lon,
              'observaciones' : this.observaciones,
              'servicios'     : this.inputsServicios,
              'productos'     : this.inputsProductos,
              'epps'          : this.inputsEpps,
              'riesgos'       : this.inputsRiesgos
          }}
          
      
        ).then(response => {
          this.response = response.data
          toastr.success('OT N° ' + this.ot + ' fue creada con éxito ');
          console.log(response.data);
        }).catch(error => {
               
               this.errors = error.response.data.errors;
                console.log(error.response);
                console.log('hola'); 
               $.each( this.errors, function( key, value ) {
                   toastr.error(value);
                   console.log( key + ": " + value );
               });

           });
      }
      else if (this.accion =='edit')
      { 

        
        this.errors =[];
        var urlRegistros = 'ots/' + this.otdata.id;        
        axios({
              method: 'put',
              url : urlRegistros , 
              data : {

              'id'            : this.otdata.id,
              'cliente'       : this.cliente.id,
              'proyecto'      : this.proyecto,
              'fecha'         : this.fecha,
              'hora'          : this.hora,
              'ot'            : this.ot,
              'fts'           : this.fts,
              'obra'          : this.obra,
              'contacto1'     : (this.contacto1 ? this.contacto1.id : null ),
              'contacto2'     : (this.contacto2 ? this.contacto2.id : null ),
              'contacto3'     : (this.contacto3 ? this.contacto3.id : null ),
              'provincia'     : (this.provincia ? this.provincia.id : null),
              'localidad'     : (this.localidad ? this.localidad.id : null),
              'fecha_ensayo'  : this.fecha_ensayo,
              'lugar_ensayo'  : this.lugar_ensayo,
              'tipo_peliculas': this.peliculas_selected,
              'lat'           : this.localidad.lat,
              'lon'           : this.localidad.lon,
              'observaciones' : this.observaciones,
              'servicios'     : this.inputsServicios,
              'productos'     : this.inputsProductos,
              'epps'          : this.inputsEpps,
              'riesgos'       : this.inputsRiesgos
            }
          }         
          ).then(response => {
          this.response = response
         toastr.success('OT N° ' + this.ot + ' fue editada con éxito ');
        }).catch(error => {         
           this.errors = error.response.data.errors;
               
               $.each( this.errors, function( key, value ) {
                   toastr.error(value);
                   console.log( key + ": " + value );
               });

           });

          
      }
      
    },
    }
}
</script>
<style>
.map-container {
    width: 100%;
    height: 425px;
    display: inline-block;
  }

 .vtimeselector__input {
    width: 100%;
    box-sizing: border-box;
    padding: 6px 12px;
    height: 34px;
    font-size: 14px;
    background-color: #fff;
    border: 1px solid #ccc;
  }

 .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {

    background-color: #fff;
   
  }

  .existe {

    color: blue ;

  }

.downSelect {
 font-style: oblique;
 font-size: 12px;
  }

.upSelect {
  font-weight: bold;
  font-size: 14;
}

</style>
