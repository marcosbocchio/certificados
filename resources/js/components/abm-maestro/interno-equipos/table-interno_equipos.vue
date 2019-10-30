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
            <th style="text-align: center">Voltaje</th> 
            <th style="text-align: center">Amperaje</th> 
            <th style="text-align: center">Activo</th>  
            <th colspan="2">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="registro in registros" :key="registro.id">                        
            <td>{{ registro.nro_serie }}</td>
            <td>{{ registro.nro_interno }}</td>
            <td>{{ registro.equipo.codigo }}</td>  
            <td v-if="registro.interno_fuente" >{{ registro.interno_fuente.nro_serie }}</td>   
            <td v-else ></td>
            <td style="text-align: center">{{ registro.voltaje }}</td>    
            <td style="text-align: center">{{ registro.amperaje }}</td>     
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
  export default {

    data() {return {  

    }},

    props : {
      registros : {
        type : Array,
        required : true        
      }    
    },

    methods: {
    updateValue: function (registro) {
       this.$emit('editar', registro);
    }
  }
  }
</script>