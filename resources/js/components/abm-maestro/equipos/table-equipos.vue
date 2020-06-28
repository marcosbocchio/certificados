<template>
<div class="box box-custom-enod top-buffer">
  <div class="box-body">
    <div class="table-responsive">
      <table class="table table-hover table-striped table-condensed">
        <thead>
          <tr>                     
            <th>código</th>
            <th>Descripción</th>
            <th>Método</th>
            <th>Inst. Medición</th>      
            <th colspan="2">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="registro in registros" :key="registro.id">                        
            <td>{{ registro.codigo }}</td>
            <td>{{ registro.descripcion }}</td>
            <td>{{ registro.metodo_ensayos.metodo }}</td>  
            <td>{{ registro.instrumento_medicion }}</td>   
            
            <td width="10px">
              <button class="btn btn-warning btn-sm" title="Editar" v-on:click.prevent="updateValue(registro)" :disabled="!$can('M_equipos_edita')"><span class="fa fa-edit"></span></button>
            </td>
            <td width="10px">
              <button class="btn btn-danger btn-sm" title="Eliminar" v-on:click.prevent="$emit('confirmarDelete',registro,registro.codigo)" :disabled="!$can('M_equipos_edita')"><span class="fa fa-trash"></span></button>
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
  export default {

    data() {return {  

    }},

    props : {
      registros : {
        type : Array,
        required : true,
        default:function () { return [] }  
      },    

      loading : {
        type : Boolean,
        required : true
      },    
    },

    methods: {
    updateValue: function (registro) {
       this.$emit('editar', registro);
    }
  }
  }
</script>