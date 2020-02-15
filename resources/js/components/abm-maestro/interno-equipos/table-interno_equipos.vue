<template>
<div class="box box-custom-enod top-buffer">
  <div class="box-body">
    <div class="table-responsive">
      <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th>N° Int.</th>
            <th>Equipo</th>
            <th>Fuente</th>
            <th>Actividad</th>
            <th>N° OT</th>
            <th>Cliente</th>
            <th>Ubicación</th>
            <th colspan="2">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="registro in registros" :key="registro.id">                        
            <td>{{ registro.nro_interno }}</td>
            <td>{{ registro.equipo.codigo }}</td>  
            <td v-if="registro.interno_fuente" >{{ registro.interno_fuente.nro_serie }} - {{registro.interno_fuente.fuente.codigo}}</td>   
            <td v-else ></td> 
            <td v-if="registro.interno_fuente">{{ registro.interno_fuente.curie_actual }}&nbsp; Ci</td>
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
            <td width="10px">
              <button class="btn btn-warning btn-sm" title="Editar" v-on:click.prevent="updateValue(registro)" :disabled="!$can('M_interno_equipos_edita')"><span class="fa fa-edit"></span></button>
            </td>
            <td width="10px">
              <button class="btn btn-danger btn-sm" title="Eliminar" v-on:click.prevent="$emit('confirmarDelete',registro,registro.codigo)" :disabled="!$can('M_interno_equipos_edita')"><span class="fa fa-trash"></span></button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div v-if="loading" class="overlay">
     <loading-spin></loading-spin>
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
        required : true,
        default:[]                
      },    

      loading : {
        type : Boolean,
        required : true
      },    
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