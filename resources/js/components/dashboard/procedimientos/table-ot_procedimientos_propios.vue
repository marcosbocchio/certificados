<template>  
<div class="box box-custom-enod top-buffer">
  <div class="box-body">
    <div class="table-responsive">
      <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th>Tipo</th>
            <th>Título</th>
            <th>Descripción</th>
            <th>Metodo</th>  
            <th colspan="3">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="registro in registros" :key="registro.id">           
            <td>PROCEDIMIENTOS</td>     
            <td>{{ registro.titulo}}</td>
            <td>{{ registro.descripcion }}</td>
            <td>{{ registro.metodo_ensayo['metodo']}}</td>    
            <td width="10px"> <a :href="AppUrl + '/' + registro.path " target="_blank" title="Imagen" class="btn btn-default btn-sm"><span class="fa fa-file-pdf-o"></span></a></td>
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
  import {mapState} from 'vuex'
  export default {
   
    props : {
      registros : {
        type : Array,
        required : true
      }         
    },

     computed :{

       ...mapState(['url','AppUrl'])
     },

  }
</script>