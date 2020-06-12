<template>
<div class="box box-custom-enod top-buffer">
  <div class="box-body">
    <div class="table-responsive">
      <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th class="col-md-1">CÓDIGO.</th>
            <th class="col-md-5">DESCRIPCIÓN</th>
            <th class="col-md-2" style="text-align: center" >UNIDAD MEDIDA</th>
            <th class="col-md-2" style="text-align: center">MÉTODO ENSAYO</th>
            <th class="col-md-1" colspan="2">&nbsp; </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="registro in registros" :key="registro.id">
            <td>{{ registro.abreviatura }}</td>            
            <td>{{ registro.descripcion }}</td>
            <td style="text-align: center">{{ registro.unidad_medidas.codigo }}</td>     
            <td style="text-align: center">{{ registro.metodo_ensayos.metodo }}</td>    
            <td width="10px">
              <button class="btn btn-warning btn-sm" title="Editar" v-on:click.prevent="updateValue(registro)" :disabled="!$can('M_servicios_edita')"><span class="fa fa-edit"></span></button>
            </td>
            <td width="10px">
              <button class="btn btn-danger btn-sm" title="Eliminar" v-on:click.prevent="$emit('confirmarDelete',registro,registro.codigo)" :disabled="!$can('M_servicios_edita')"><span class="fa fa-trash"></span></button>
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