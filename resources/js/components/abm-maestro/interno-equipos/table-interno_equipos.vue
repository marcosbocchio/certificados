<template>
<div class="box box-danger top-buffer">
  <div class="box-body">
    <div class="table-responsive">
      <table class="table table-hover table-striped">
        <thead>
          <tr>
                     
            <th>N° Serie</th>
            <th>N° Int.</th>
            <th>Equipo</th>
            <th>Fuente</th>
            <th>Curie</th>
            <th>N° OT</th>
            <th>Cliente</th>
            <th>Ubicación</th>
            <th style="text-align: center">Activo</th>  
            <th colspan="2">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="registro in registros" :key="registro.id">                        
            <td>{{ registro.nro_serie }}</td>
            <td>{{ registro.nro_interno }}</td>
            <td>{{ registro.equipo.codigo }}</td>  
            <td v-if="registro.interno_fuente" >{{ registro.interno_fuente.nro_serie }} - {{registro.interno_fuente.fuente.codigo}}</td>   
            <td v-else ></td> 
            <td v-if="registro.interno_fuente">{{ registro.interno_fuente.curie }}</td>
            <td v-else></td>
            <td v-if="registro.ot" >{{ registro.ot.numero }}</td>   
            <td v-else ></td> 
            <td v-if="registro.ot" >{{ registro.ot.cliente.nombre_fantasia }}</td>   
            <td v-else ></td> 
            <td v-if="registro.ot">
            <a :href="'https://www.google.com/maps/search/?api=1&query=' + registro.ot.lat  + ',' + registro.ot.lon " target="_blank" title="maps">  
                   <img :src="AppUrl + '/' + 'img/mark-google-maps.jpg' " alt="maps" style="height: 20px;">  
            </a>
                {{registro.ot.localidad.localidad}} / {{registro.ot.localidad.provincia.provincia}}
              </td>
            <td v-else >Enod</td> 
            <td style="text-align: center">
              <div v-if="registro.activo_sn">
                  SI
              </div>   
              <div v-else>
                  NO   
              </div>             
            </td>      
            <td width="10px">
              <a href="#" class="btn btn-warning btn-sm" title="Editar" v-on:click.prevent="updateValue(registro)"><span class="fa fa-edit"></span></a>
            </td>
            <td width="10px">
              <a href="#" class="btn btn-danger btn-sm" title="Eliminar " v-on:click.prevent="$emit('confirmarDelete',registro,registro.nombre_fantasia)"><span class="fa fa-trash"></span></a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
 </div>
</template>

<script>
import {mapState} from 'vuex'
  export default {

    data() {return {  

    }},

    props : {
      registros : {
        type : Array,
        required : true        
      }    
    },

    computed :{

       ...mapState(['url','AppUrl']),

    },

    methods: {
    updateValue: function (registro) {
       this.$emit('editar', registro);
    }
  }
  }
</script>