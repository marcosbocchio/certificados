<template>
<div class="box box-custom-enod top-buffer">
  <div class="box-body">
    <div class="table-responsive">
      <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th>ID</th>           
            <th>Código</th>
            <th>Descripción</th>   
            <th colspan="2">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="registro in registros" :key="registro.id">
            <td width="10px">{{ registro.id }}</td>            
            <td>{{ registro.codigo }}</td>
            <td>{{ registro.descripcion }}</td>     
            <td width="10px">
                <button class="btn btn-warning btn-sm" title="Editar" v-on:click.prevent="updateValue(registro)" :disabled="!$can('M_unidades_medida_edita')"><span class="fa fa-edit"></span></button>
            </td>
            <td width="10px">
                <button class="btn btn-danger btn-sm" title="Eliminar" v-on:click.prevent="$emit('confirmarDelete',registro,registro.codigo)" :disabled="!$can('M_unidades_medida_edita')"><span class="fa fa-trash"></span></button>
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