<template>  
<div class="box box-danger top-buffer">
  <div class="box-body">
    <div class="table-responsive">
      <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th>Tipo</th>
            <th>Título</th>
            <th>Descripción</th>
            <th colspan="2">Acción</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="registro in registros" :key="registro.id">
            <div v-if="registro.tipo == 'USUARIO'">
                <td>USUARIOS</td>
            </div>
            <div v-else-if="registro.tipo == 'PROCEDIMIENTO'">
              <td>PROCEDIMIENTOS</td>
            </div>
            <div v-else>
              <td>INSTITUCIONAL</td>
            </div>
           
            <td>{{ registro.titulo}}</td>
            <td>{{ registro.descripcion }}</td>
            <td width="10px">
              <a href="#" class="btn btn-warning btn-sm" title="Editar" v-on:click.prevent="$emit('editRegistroEvent',registro)"><span class="fa fa-edit"></span></a>  
            </td>
            <td width="10px">
              <a href="#" class="btn btn-danger btn-sm" title="Eliminar" v-on:click.prevent="$emit('confirmarDelete',registro,registro.titulo)"><span class="fa fa-trash"></span></a>
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
   
    props : {
      registros : {
        type : Array,
        required : true
      }         
    }      
  }
</script>