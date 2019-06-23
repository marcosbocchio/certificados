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
        
        <div class="col-md-4">
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
        <div class="col-md-2">
          <div class="bootstrap-timepicker">
                <div class="form-group">
                  <label>Hora</label>

                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                    <timeselector v-model="hora" :pickerStyle="form-control"></timeselector>
                  
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->
          </div>
         
        </div>
        
        <div class="col-md-3">
          <div class="form-group">
            <label for="ot">OT Nº</label>
            <input type="text" class="form-control" id="ot" placeholder="">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="fts">FTS Nº</label>
            <input type="text" class="form-control" id="fts" placeholder="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="lugar_ensayo">Lugar de ensayo</label>
            <input type="text" class="form-control" id="lugar_ensayo" placeholder="">
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
        <div class="col-md-12">
          <div class="form-group" v-for="(inputsServicio,k) in inputsServicios" :key="k">
              <label for="servicio">Servicio</label>
              <v-select v-model="inputsServicio.servicios" label="descripcion" :options="servicios" ></v-select>
                <div class="form-group">
                  <label for="metodo_ensayo">Metodo de ensayo</label>
                  <v-select v-model="inputsServicio.metodo_ensayos" label="descripcion" :options="metodo_ensayos"></v-select>
                </div>
                <div class="form-group">
                  <label for="norma_ensayo">Norma ensayo</label>
                  <v-select  v-model="inputsServicio.norma_ensayos" label="descripcion" :options="norma_ensayos"></v-select>
                </div>
                <div class="form-group">
                  <label for="norma_evaluaciones">Norma evaluación</label>
                  <v-select  v-model="inputsServicio.norma_evaluaciones" label="descripcion" :options="norma_evaluaciones"></v-select>
                </div>   
              <span>
                  <i class="fa fa-minus-circle" @click="removeServicio(k)" v-show="k || ( !k && inputsServicios.length > 1)"></i>
                  <i class="fa fa-plus-circle" @click="addServicio(k)" v-show="k == inputsServicios.length-1"></i>
              </span>
          </div>
        </div>
          </div>
      </div>
    
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
    
    data() { return {
         
         en: en,
         es: es,
         markers: [{
            position: {
              lat: '',
              lng: ''
            }}
          ],
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
          hora: null,
          clientes:[],
          cliente:'',
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
          inputsServicios: [
            {
                servicios:[],
                metodo_ensayos :[]
            },
        ],
           metodo_ensayos :[],
           norma_ensayos :[],
           norma_evaluaciones :[],
           response: {},
          
          }
    },
    created : function(){

        this.getClientes();
        this.getProvincias();
        this.getServicios();
        this.getMetodosEnsayos();
        this.getNormaEnsayos();
        this.getNormaEvaluaciones();
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
            this.inputsServicios.push({ servicios :[] });
        },
      removeServicio(index) {
            this.inputsServicios.splice(index, 1);
        },

      submit() {

      this.errors =[];
      var urlRegistros = 'certificados';
      axios.post(urlRegistros,{

         'cliente' : this.cliente.id,
         'proyecto': this.proyecto,
         'fecha'   : this.fecha,
         'hora'    : this.hora,

        

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

</style>
