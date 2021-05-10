<template>
<div>
<div class="box box-custom-enod top-buffer">
  <div class="box-body">
    <div class="table-responsive">
      <table class="table table-hover table-striped table-condensed">
        <thead>
          <tr>
            <th>N° INT.</th>
            <th>Equipo</th>
            <th>Método</th>
            <th>&nbsp;</th>
            <th>Fuente</th>
            <th>Actividad</th>
            <th>Ubicación</th>
            <th colspan="2">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="registro in registros" :key="registro.id">
            <td>{{ registro.nro_interno }}</td>
            <td>{{ registro.equipo.codigo }}</td>
            <td>{{ registro.equipo.metodo_ensayos.metodo }}</td>
            <th>
                <button class="btn btn-xs" title="Historial de fuentes" v-on:click.prevent="TrazabilidadFuente(registro)"><span class="fa fa-table"></span></button>
            </th>
            <td v-if="registro.interno_fuente" >{{ registro.interno_fuente.nro_serie }} - {{registro.interno_fuente.fuente.codigo}}</td>
            <td v-else ></td>
            <td v-if="registro.interno_fuente">{{ registro.interno_fuente.curie_actual }}&nbsp; Ci</td>
            <td v-else></td>
            <td>{{ registro.frente.codigo }}</td>
            <td width="10px">
              <button class="btn btn-warning btn-sm" title="Editar" v-on:click.prevent="updateValue(registro)" :disabled="!$can('M_interno_equipos_edita')"><span class="fa fa-edit"></span></button>
            </td>
            <td width="10px">
              <button class="btn btn-danger btn-sm" title="Eliminar" v-on:click.prevent="$emit('confirmarDelete',registro,registro.codigo)" :disabled="!$can('M_interno_equipos_edita')"><span class="fa fa-trash"></span></button>
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
 <trazabilidad-fuente></trazabilidad-fuente>
</div>
</template>

<script>

import {mapState} from 'vuex';

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

    computed :{

       ...mapState(['url']),

    },

    methods: {

    updateValue: function (registro) {

       this.$emit('editar', registro);

    },

    TrazabilidadFuente : function(registro){

      this.$emit('trazabilidad', registro);

    }
  }
  }
</script>
