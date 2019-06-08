<template>
  <div class="table-responsive">
    <table class="table table-hover table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Codigo</th>
          <th>Descripcion</th>
          <th colspan="2">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="registro in registros" :key="registro.id">
          <td width="10px">{{ registro.id }}</td>
          <td>{{ registro.codigo }}</td>
          <td>{{ registro.descripcion }}</td>
          <td width="10px">
            <a href="#" class="btn btn-warning btn-sm" title="Editar" v-on:click.prevent="editKeep(registro)"><span class="fa fa-edit"></span></a>  
          </td>
          <td width="10px">
            <a href="#" class="btn btn-danger btn-sm" title="Eliminar "v-on:click.prevent="$emit('confirmarDelete',registro,registro.descripcion)"><span class="fa fa-trash"></span></a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
  export default {
   
    props : {
      registros : {
        type : Array,
        required : true
      }         
    }      
  }
</script>

