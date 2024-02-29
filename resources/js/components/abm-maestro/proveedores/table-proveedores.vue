<template>
    <div v-if="registros.length || loading">
      <div class="box box-custom-enod top-buffer">
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-hover table-striped table-condensed">
              <thead>
                <tr>
                  <th>Razón Social</th>
                  <th>CUIT</th>
                  <th>Email</th>
                  <th>Teléfono</th>
                  <th colspan="2">&nbsp;</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="registro in registros" :key="registro.id">
                  <td>{{ registro.razon_social }}</td>
                  <td>{{ registro.cuit }}</td>
                  <td>{{ registro.email }}</td>
                  <td>{{ registro.tel }}</td>
                  <td width="10px">
                    <button class="btn btn-warning btn-sm" title="Editar" v-on:click.prevent="updateValue(registro)" :disabled="!$can('M_proveedores_edita')"><span class="fa fa-edit"></span></button>
                  </td>
                  <td width="10px">
                    <button class="btn btn-danger btn-sm" title="Eliminar" v-on:click.prevent="$emit('confirmarDelete', registro, registro.razon_social)" :disabled="!$can('M_proveedores_edita')"><span class="fa fa-trash"></span></button>
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
    </div>
    </template>
    
    <script>
    import { eventEditRegistro } from '../../event-bus';
    export default {
      props: {
        registros: {
          type: Array,
          required: true,
          default: () => []
        },
        loading: {
          type: Boolean,
          required: true
        },
      },
      methods: {
        updateValue(registro) {
          eventEditRegistro.$emit('editarProveedor', registro);
        }
      }
    }
    </script>