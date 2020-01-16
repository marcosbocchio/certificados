<template>  
<div class="box box-danger top-buffer">
  <div class="box-body">
    <div class="table-responsive">
      <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th>Descripción</th>           
            <th colspan="2">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="registro in registros" :key="registro.id">           
            <td> {{ registro.descripcion }} <a :href="AppUrl + '/' + registro.path" target="_blank" class="btn btn-default btn-xs" title="descargar"><span class="fa fa-download"></span></a>    
           
            </td>
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
    } ,  
    
    computed :{           
         
         ...mapState(['url','AppUrl'])
     },
  }
</script>