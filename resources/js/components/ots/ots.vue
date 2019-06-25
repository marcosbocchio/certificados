<template>
 <div class="col-md-12">
  <form @submit.prevent="submit"  method="post">
    <div class="box box-primary">
      <div class="box-body">
        <div class="col-md-6">
            <div class="form-group">
              <label for="proyecto">Proyecto</label>
              <input type="text" v-model="proyecto" class="form-control" id="proyecto" placeholder="">
            </div>
            <div class="form-group">
                  <label>Cliente</label>
                  <v-select v-model="cliente" label="nombre_fantasia" :options="clientes" @input="getContactos()"></v-select>   
            </div>

          <!-- /.box-body -->
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
        <div class="col-md-3">
          <div class="form-group">
            <label for="ot">OT Nº</label>
            <input v-model="ot" type="text" class="form-control" id="ot" placeholder="">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="fts">FTS Nº</label>
            <input v-model="fts" type="text" class="form-control" id="fts" placeholder="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="lugar_ensayo">Lugar de ensayo</label>
            <input type="text" class="form-control" id="lugar_ensayo" placeholder="">
          </div>
        </div>
         <div class="col-md-3">
          <div class="form-group">
            <label for="fecha">Fecha estima de ensayo</label>
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
                  <v-select v-model="contacto1" name="contacto_1" label="nombre" :options="contactos" ></v-select>   
            </div>
        </div>
         <div class="col-md-6">
          <div class="form-group">
                  <label>Contacto 2</label>
                  <v-select v-model="contacto2" name="contacto_2" label="nombre" :options="contactos" ></v-select>   
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Provincia</label>
            <v-select v-model="provincia" label="provincia" :options="provincias" @input="getLocalidades()"></v-select>   
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Localidad</label>
            <v-select v-model="localidad" label="localidad" :options="localidades" @input="sync()"></v-select>   
          </div>
        </div>
         <div class="col-md-6">
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
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="latitud">Latitud</label>
              <input type="text" 
              class="form-control" id="latitud"
              v-model.number.lazy="localidad.lat"
              @change="sync"
              />
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="longitud">Longitud</label>
              <input type="text" 
              class="form-control" id="longitud"
              v-model.number.lazy="localidad.lon"
              @change="sync"
            
              />
            </div>
          </div>
          <div class="col-md-12">
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
           

            <div >
             
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
                     <label>Cant. Placas</label>                  
                     <input  v-model="cantidad_placas" type="text" class="form-control" id="cantidad_placas" placeholder="">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group"> 
                     <label>Cant.</label>                 
                     <input v-model="cantidad_servicios" type="text" class="form-control" id="cantidad_servicios" placeholder="">
                  </div>
                </div>   
                 <div class="col-md-1"> 
                   <div class="form-group">                    
                  <span>
                      <i class="fa fa-plus-circle" @click="addServicio()"></i>
                  </span>
                   </div>
                 </div>
                 <div class="col-md-1"> 
                 </div>  
            </div>
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-hover table-striped">
                  <thead>
                    <tr>
                      <th>Servicio</th>
                      <th>Norma Ensayo</th>
                      <th>Norma Evaluacion</th>
                      <th>Cant Placas</th>
                      <th>Cant Serv</th>
                      <th colspan="2">&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(inputsServicio,k) in inputsServicios" :key="k">
                      <td> {{ inputsServicio.servicio}}</td>
                      <td> {{ inputsServicio.norma_ensayo}}</td>
                      <td> {{ inputsServicio.norma_evaluacion}}</td>
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
      <button class="btn btn-primary" type="submit" @click.prevent="submit">Guardar</button>
    </form>
  </div>
</template>

<script>

import {mapState} from 'vuex'
import Datepicker from 'vuejs-datepicker';
import {en, es} from 'vuejs-datepicker/dist/locale'
import Timeselector from 'vue-timeselector';



export default {

  components: {
      Datepicker,
      Timeselector 
  },
   props:
     ['otdata','clientedata','ot_serviciosdata','acciondata']
   
   ,
    
    data() { return {
         
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
          hora: null,
          clientes:[],
          cliente:'',
          ot:'',
          fts:'',
          contactos:[],
          contacto1:'',
          contacto2:'',
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
          inputsServicios: [],

           servicio:'',        
           norma_ensayo :'',
           norma_evaluacion :'',
           response: {},
           cantidad_placas:'',
           cantidad_servicios:'1',
          
          }
    },
    created : function(){
        
        this.getClientes();
        this.getProvincias();
        this.getServicios();
        this.getMetodosEnsayos();
        this.getNormaEnsayos();
        this.getNormaEvaluaciones();
        this.setOt();
        this.sync();
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

    methods :{

      setOt : function(){

              if(this.acciondata == "edit"){               

                this.proyecto        = this.otdata.proyecto,
                this.fecha           = this.otdata.fecha_hora,
                this.cliente         = this.clientedata, 
                this.localidad.lat   = this.otdata.lat,
                this.localidad.lon   = this.otdata.lon,
                this.inputsServicios = this.ot_serviciosdata,
                this.accion          = this.acciondata
          
               }
              },

      getClientes : function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'clientes';    
                axios.get(urlRegistros).then(response =>{
                this.clientes = response.data
                });
              },
      getContactos : function(){
                this.contacto1 = '';
                this.contacto2 = '';
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'contactos/' + this.cliente.id;    
                axios.get(urlRegistros).then(response =>{
                this.contactos = response.data
                });
              },
      getProvincias : function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'provincias';    
                axios.get(urlRegistros).then(response =>{
                this.provincias = response.data
                });
              },
      getLocalidades : function(){
                this.localidades=[];
                this.localidad ='';
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'localidades/' + this.provincia.id;    
                axios.get(urlRegistros).then(response =>{
                this.localidades = response.data
                });
              },
       getServicios : function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'servicios';    
                axios.get(urlRegistros).then(response =>{
                this.servicios = response.data
                });
              },
       getMetodosEnsayos: function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'metodo_ensayos';    
                axios.get(urlRegistros).then(response =>{
                this.metodo_ensayos = response.data
                });
              },
        getNormaEnsayos: function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'norma_ensayos';    
                axios.get(urlRegistros).then(response =>{
                this.norma_ensayos = response.data
                });
              },
        getNormaEvaluaciones: function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'norma_evaluaciones';    
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
      addServicio(index) {
            this.inputsServicios.push({ 
                servicio:this.servicio.descripcion,            
                norma_ensayo : this.norma_ensayo.descripcion,
                norma_evaluacion :this.norma_evaluacion.descripcion,
                cantidad_placas:this.cantidad_placas,
                cantidad_servicios:this.cantidad_servicios,
                 });
            this.servicio='',        
            this.norma_ensayo ='',
            this.norma_evaluacion ='',           
            this.cantidad_placas='',
            this.cantidad_servicios='1'

        },
      removeServicio(index) {
            this.inputsServicios.splice(index, 1);
        },

      submit() {

      this.errors =[];
      var urlRegistros = 'certificados';
      axios.post(urlRegistros,{

         'cliente'       : this.cliente.id,
         'proyecto'      : this.proyecto,
         'fecha'         : this.fecha,
         'hora'          : this.hora,
         'ot'            : this.ot,
         'fts'           : this.fts,
         'contacto1'     : this.contacto1.id,
         'contacto2'     : this.contacto2.id,
         'provincia'     : this.provincia.id,
         'localidad'     : this.localidad.id,
         'fecha_ensayo'  : this.fecha_ensayo,
         'latitud'       : this.localidad.lat,
         'longitud'      : this.localidad.lon,
         'servicios'     : this.inputsServicios

        

      }
      
      ).then(response => {
        this.response = response
        alert('Message sent!');
      }).catch(error => {
        if (error.response.status === 422) {
          this.errors = error.response.data.errors || {};
        }
      });
    },
    }
}
</script>
<style>
.map-container {
    width: 100%;
    height: 500px;
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

</style>
