<template>
    <div>
      <loading :active.sync="isLoading" :is-full-page="true" :loader="'bars'" :color="'red'"></loading>
      
      <!-- Input Operador y Botón de Agregar -->
      <div class="box box-custom-enod top-buffer">
        <div class="box-body row">
          <div class="col-md-4">
            <!-- Espacio en blanco -->
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="operador">Operador:</label>
              <input type="text" v-model="operador" class="form-control" id="operador" />
            </div>
          </div>
          <div class="col-md-4">
            <!-- Espacio en blanco -->
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <button @click="redireccionAsignacion()"><span class="fa fa-plus-circle"></span></button>
          </div>
        </div>
      </div>
    
      <!-- Tabla de Operadores -->
      <div class="box box-custom-enod top-buffer">
        <div class="box-body table-responsive">
          <table class="table table-hover table-striped table-condensed">
            <thead>
              <tr>
                <th>Fecha</th>
                <th>Remito</th>
                <th>Asigno</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in items" :key="index">
                <td>{{ item.fecha }}</td>
                <td>{{ item.remito }}</td>
                <td>{{ item.asigno }}</td>
                <td>
                  <button @click="editarItem(index)" class="btn btn-warning btn-sm">Edit</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import Loading from 'vue-loading-overlay';
  import 'vue-loading-overlay/dist/vue-loading.css';
  import toastr from 'toastr';
  import 'toastr/build/toastr.min.css';
  
  export default {
    components: {
      Loading
    },
    props: {
    operador_data: {
      type: Object,
      required: true
    },
  },
    data() {
      return {
        operador: this.operador_data.name,
        items: [],
        isLoading: false,
        remito_selected: ''
      };
    },
    methods: {
      redireccionAsignacion() {
        window.location.href = `/area/enod/asignacion-nuevo/${this.operador_data.id}/remito/`},
      editarItem(index) {
        // Aquí puedes agregar la lógica para editar un item
        const newItem = prompt('Edita el item:', this.items[index]);
        if (newItem !== null) {
          this.items.splice(index, 1, newItem);
        }
      }
    }
  };
  </script>
  
  <style scoped>
  .box.box-custom-enod {
    padding: 20px;
  }
  </style>