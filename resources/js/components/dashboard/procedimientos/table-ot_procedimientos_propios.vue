<template>    
    <div class="box box-custom-enod top-buffer">
        <div class="box-header with-border">
        <h3 class="box-title">Procedimientos Enod</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>                       
            </div>
        </div>
      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-hover table-striped table-condensed">
            <thead>
              <tr>
                <th>Tipo</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Método</th>  
                <th colspan="3">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="registro in registros" :key="registro.id">           
                <td>{{ registro.tipo}}</td>     
                <td>{{ registro.titulo}}</td>
                <td>{{ registro.descripcion }}</td>
                <td>{{ registro.metodo_ensayo['metodo']}}</td>    
                <td width="10px"> <a :href="AppUrl + '/' + registro.path " target="_blank" title="Imagen" class="btn btn-default btn-sm"><span class="fa fa-file-pdf-o"></span></a></td>
                <td width="10px">
                  <button class="btn btn-warning btn-sm" title="Editar" v-on:click.prevent="$emit('editRegistroEvent',registro)" :disabled="!$can('T_proc_edita')"><span class="fa fa-edit"></span> </button>                  
                </td>
                <td width="10px">
                  <button class="btn btn-danger btn-sm" title="Eliminar" v-on:click.prevent="$emit('confirmarDelete',registro,registro.titulo)" :disabled="!$can('T_proc_edita')"><span class="fa fa-trash"></span></button>
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
        required : true,
       default:function () { return [] }    
      },           
    },

     computed :{

       ...mapState(['url','AppUrl'])
     },

  }
</script>