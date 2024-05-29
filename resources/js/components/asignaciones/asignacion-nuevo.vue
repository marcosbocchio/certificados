<template>
    <div>
      <!-- Box 1: Operador y Remito -->
      <div class="box box-custom-enod">
        <div class="box-body row">
          <div class="col-md-3">
            <div class="form-group">
              <label for="operador">Operador *</label>
              <v-select v-model="operador_selected" :options="operadores_opciones" label="name" id="operador"></v-select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="remito">Remito *</label>
              <v-select v-model="remito_selected" :options="remitos_opciones" label="formateado" id="remito"></v-select>
            </div>
          </div>
        </div>
      </div>
  
      <!-- Resto del template -->
      <!-- Box 2: Producto y Detalles -->
      <div class="box box-custom-enod">
        <div class="box-body row">
          <div class="col-md-3">
            <div class="form-group">
              <label for="producto">Producto *</label>
              <v-select v-model="producto_selected" :options="productos_opciones" label="codigo" id="producto"></v-select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="cantidad">Cantidad *</label>
              <input id="cantidad" type="number" v-model="cantidad_selected" class="form-control" min="0" placeholder="Cantidad">
            </div>
          </div>
          <div class="col-md-1">
            <div style="display:flex;justify-content: flex-start;align-items: center;">
              <button type="button" @click="agregarDetalle" style="margin-top:25px;"><span class="fa fa-plus-circle"></span></button>
            </div>
          </div>
        </div>
  
        <!-- Tabla de Detalles -->
        <div class="box-body">
          <table class="table table-hover table-striped table-condensed">
            <thead>
              <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th style="text-align: center;">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(detalle, index) in detalles" :key="index">
                <td>{{ detalle.producto.codigo }}</td>
                <td>{{ detalle.cantidad }}</td>
                <td style="text-align:center">
                  <i class="fa fa-minus-circle" @click="eliminarDetalle(index)"></i>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
  
      <!-- Box 3: Observaciones -->
      <div class="box box-custom-enod">
        <div class="box-body">
          <div class="form-group">
            <label for="observaciones">Observaciones</label>
            <textarea id="observaciones" v-model="observaciones" class="form-control" rows="5" placeholder="Observaciones" style="width: 100%;"></textarea>
          </div>
        </div>
      </div>
  
      <!-- Botón de Guardar -->
      <div class="form-actions">
        <div class="col-md-12">
          <button @click="confirmar" class="btn btn-enod">Guardar</button>
        </div>
      </div>
  
      <!-- Loading -->
      <loading :active.sync="isLoading" :loader="'bars'" :color="'red'"></loading>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import vSelect from 'vue-select';
  import 'vue-select/dist/vue-select.css';
  import Loading from 'vue-loading-overlay';
  import 'vue-loading-overlay/dist/vue-loading.css';
  
  export default {
    components: {
      vSelect,
      Loading
    },
    props: {
      productos_opciones: {
        type: Array,
        required: true
      },
      remitos_opciones: {
        type: Array,
        required: true
      },
      operadores_opciones: {
        type: Array,
        required: true
      }
    },
    data() {
      return {
        operador_selected: '',
        remito_selected: '',
        producto_selected: '',
        cantidad_selected: 0,
        detalles: [],
        observaciones: '',
        isLoading: false,
      };
    },
    methods: {
      agregarDetalle() {
        if (!this.producto_selected || this.cantidad_selected <= 0) {
          toastr.error('Producto o cantidad no válidos');
          return;
        }
  
        const nuevoDetalle = {
          producto: this.producto_selected,
          cantidad: this.cantidad_selected,
        };
        this.detalles.push(nuevoDetalle);
        
        this.producto_selected = '';
        this.cantidad_selected = 0;
      },
      eliminarDetalle(index) {
        this.detalles.splice(index, 1);
      },
      confirmar() {
        // Lógica para confirmar (por ejemplo, guardar datos en la base de datos)
      }
    }
  }
  </script>
  
  <style scoped>
  .form-actions {
    display: flex;
    justify-content: flex-end;
    margin-top: 20px;
  }
  
  .btn-enod {
    background-color: rgb(255, 204, 0);
    color: rgb(0, 0, 0);
  }
  
  /* Estilo para el botón de eliminar en la tabla */
  .btn-danger {
    background-color: #dc3545;
    color: #fff;
  }
  
  .btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 0.2rem;
  }
  </style>