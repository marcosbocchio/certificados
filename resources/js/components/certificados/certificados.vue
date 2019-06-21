<template>
<div class="col-md-12">
  <div class="box box-primary">
    <form role="form">
      <div class="box-body">

        <div class="col-md-6">
            <div class="form-group">
              <label for="proyecto">Proyecto</label>
              <input type="text" class="form-control" id="proyecto" placeholder="">
            </div>
            <div class="form-group">
                  <label>Cliente</label>
                  <v-select label="nombre_fantasia" :options="clientes" ></v-select>   
            </div>

          <!-- /.box-body -->
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="fecha">Fecha</label>
              <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker">
              </div>
          </div>
          <div class="bootstrap-timepicker">
                <div class="form-group">
                  <label>Hora</label>

                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" class="form-control timepicker">
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
                  <v-select name="contacto_1" label="nombre" :options="contactos" ></v-select>   
            </div>
        </div>
         <div class="col-md-6">
          <div class="form-group">
                  <label>Contacto 2</label>
                  <v-select name="contacto_2" label="nombre" :options="contactos" ></v-select>   
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
             <input type="number" 
             class="form-control" id="latitud"
             v-model.number.lazy="localidad.lat"
             @change="sync"
             step="0.00001"
             />
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="longitud">Longitud</label>
             <input type="number" 
             class="form-control" id="longitud"
             v-model.number.lazy="localidad.lon"
             @change="sync"
             step="0.00001"
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
      </div>
      </form>
    
    </div>
  </div>

</template>

<script>

import {mapState} from 'vuex'

export default {
    
    data() { return {
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
          clientes:[],
          contactos:[],
          localidades:[],
          localidad: {
            
            lat : -34.603684400000011,
            lon : -58.381559100000004
          },
          provincias:[],
          provincia: ''
          
          }
    },
    created : function(){

        this.getClientes();
        this.getContactos();
        this.getProvincias();
        this.sync();
       

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

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'contactos';    
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
      
      }
      

    }
}
</script>
<style>
.map-container {
    width: 100%;
    height: 500px;
    display: inline-block;
  }
</style>
