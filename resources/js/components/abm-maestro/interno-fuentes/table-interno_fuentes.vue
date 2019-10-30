<template>
<div class="box box-danger top-buffer">
  <div class="box-body">
    <div class="table-responsive">
      <table class="table table-hover table-striped">
        <thead>
          <tr>
                     
            <th>N° Serie</th>
            <th>Fuente</th>
            <th>curie</th> 
            <th style="text-align: center">Activo</th>  
            <th colspan="2">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="registro in registros" :key="registro.id">                        
            <td>{{ registro.nro_serie }}</td>
            <td>{{ registro.fuente.codigo }}</td>     
            <td>{{ registro.curie }}</td>         
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