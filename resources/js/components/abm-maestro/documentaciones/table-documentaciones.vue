<template>  
<div class="box box-custom-enod top-buffer">
  <div class="box-body">
    <div class="table-responsive">
      <table class="table table-hover table-striped table-condensed">
        <thead>
          <tr>
            <th class="col-md-1">Tipo</th>
            <th class="col-md-2">Título</th>
            <th class="col-md-4">Descripción</th>
            <th class="col-md-1">Método</th>
            <th class="col-md-2">Usuario</th>
            <th class="col-md-1">INT. Nº</th>
            <th >&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="registro in registros" :key="registro.id">

            <td v-if="registro.tipo == 'USUARIO'">USUARIOS</td>          
            <td v-if="registro.tipo == 'OT'" >OT</td>          
            <td v-if="registro.tipo == 'INSTITUCIONAL'">INSTITUCIONAL</td>    
            <td v-if="registro.tipo == 'PROCEDIMIENTO GENERAL'">PROCEDIMIENTO GENERAL</td>    
            <td v-if="registro.tipo == 'EQUIPO'">EQUIPO</td>
            <td v-if="registro.tipo == 'FUENTE'">FUENTE</td>
            <td v-if="registro.tipo == 'VEHICULO'">VEHICULO</td>   
            <td>{{ registro.titulo}}</td>
            <td>{{ registro.descripcion }}</td>
            <td v-if="registro.metodo_ensayo.id">{{ registro.metodo_ensayo['metodo']}}</td>
            <td v-else-if="registro.interno_equipo.length > 0">{{ registro.interno_equipo[0].equipo.metodo_ensayos['metodo']}}</td>
            <td v-else>&nbsp;</td>
            <td v-if="registro.usuario[0]">{{ registro.usuario[0]['name']}}</td>
            <td v-else-if="registro.tipo == 'EQUIPO' && registro.user_interno_equipo[0]">{{registro.user_interno_equipo[0]['name'] }}</td>
            <td  v-else>&nbsp;</td>
            <td v-if="registro.tipo == 'EQUIPO' && registro.interno_equipo[0]">{{ registro.interno_equipo[0]['nro_interno']}}</td>
            <td v-else-if="registro.tipo == 'FUENTE' && registro.interno_fuente[0]">{{ registro.interno_fuente[0]['nro_serie']}}</td>
            <td  v-else-if="registro.tipo == 'VEHICULO' && registro.vehiculo[0]">{{ registro.vehiculo[0]['nro_interno']}}</td>
            <td  v-else>&nbsp;</td>
            <td width="10px">
              <button class="btn btn-warning btn-sm" title="Editar" v-on:click.prevent="$emit('editRegistroEvent',registro)" :disabled="!$can('M_documentaciones_edita')"><span class="fa fa-edit"></span></button>
            </td>
            <td width="10px">
              <button class="btn btn-danger btn-sm" title="Eliminar" v-on:click.prevent="$emit('confirmarDelete',registro,registro.titulo)" :disabled="!$can('M_documentaciones_edita')"><span class="fa fa-trash"></span></button>
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
    }      
  }
</script>