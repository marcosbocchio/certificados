<template>
<div>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Codigo</th>
                    <th>Descripcion</th>
                    <th colspan="2">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="registro in registros">
                    <td width="10px">{{ registro.id }}</td>
                    <td>{{ registro.codigo }}</td>
                    <td>{{ registro.descripcion }}</td>
                    <td><a href="#" class="btn btn-warning btn-sm" title="Editar" v-on:click.prevent="editKeep(registro)"><span class="fa fa-edit"></span></a>
                        <a href="#" class="btn btn-danger btn-sm" title="Eliminar "v-on:click.prevent="$emit('confirmarDelete',registro,registro.descripcion)"><span class="fa fa-trash"></span></a>
                    </td>
                </tr>
                </tbody>
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
