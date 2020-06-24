<template>  
<div class="box box-custom-enod top-buffer">
  <div class="box-body">
    <div class="table-responsive">
      <table class="table table-hover table-striped table-condensed">
        <thead>
          <tr>
            <th>Descripción</th>  
            <th>Usuario</th>     
            <th>Fecha</th>    
            <th colspan="2">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="registro in registros" :key="registro.id">           
            <td> 
              {{ registro.descripcion }} <a :href="AppUrl + '/' + registro.path" target="_blank" class="btn btn-default btn-xs" title="descargar"><span class="fa fa-download"></span></a>    
            </td>
            <td>
              {{registro.usuario.name}}
            </td>
            <td> 
            {{ fecha_formateada(registro.updated_at) }}
            </td>
            <td width="10px">
              <button class="btn btn-warning btn-sm" title="Editar" v-on:click.prevent="$emit('editRegistroEvent',registro)" :disabled="!$can('T_informes_edita')"><span class="fa fa-edit"></span> </button>             
            </td>
            <td width="10px">
              <button class="btn btn-danger btn-sm" title="Eliminar" v-on:click.prevent="$emit('confirmarDelete',registro,registro.descripcion)" :disabled="!$can('T_informes_edita')"><span class="fa fa-trash"></span></button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>  
   </div>
 </div>
</template>

<script>
import moment from 'moment';
import {mapState} from 'vuex'
  export default {
   
    props : {
      registros : {
        type : Array,
        required : true
      }         
    } ,  
    
    computed :{           
         
         ...mapState(['url','AppUrl']),
     },

     methods : {

         fecha_formateada : function(val) {

         return moment(val).format('DD/MM/YYYY'); 

         }

     }
  }
</script>