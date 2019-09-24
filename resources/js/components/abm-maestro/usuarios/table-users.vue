<template>
<div class="box box-danger top-buffer">
  <div class="box-body">
    <div class="table-responsive">
      <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th>ID</th>           
            <th>Nombre</th>
            <th>Email</th>
            <th>Cliente</th>
            <th colspan="2">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="registro in registros" :key="registro.id">
            <td width="10px">{{ registro.id }}</td>            
            <td>{{ registro.name }}</td>
            <td>{{ registro.email }}</td>
            <td>
              <div v-if="registro.cliente">
              {{ registro.cliente.nombre_fantasia }}
              </div>            
              
            </td>
            <td width="10px">
              <a href="#" class="btn btn-warning btn-sm" title="Editar" v-on:click.prevent="updateValue(registro)"><span class="fa fa-edit"></span></a>
            </td>
            <td width="10px">
              <a href="#" class="btn btn-danger btn-sm" title="Eliminar " v-on:click.prevent="$emit('confirmarDelete',registro,registro.name)"><span class="fa fa-trash"></span></a>
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


