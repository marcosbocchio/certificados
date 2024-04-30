<template>
    <div>
      <!-- Box 1: Frente y Fecha -->
      <div class="box box-custom-enod">
        <div class="box-body">
          <div class="form-group">
            <label for="frente">Frente *</label>
            <input id="frente" type="text" v-model="nuevoDetalle.frente" class="form-control" placeholder="Frente">
          </div>
          <div class="form-group">
            <label for="fecha">Fecha *</label>
            <date-picker id="fecha" v-model="nuevoDetalle.fecha" value-type="YYYY-MM-DD" format="DD-MM-YYYY" placeholder="Seleccione fecha"></date-picker>
          </div>
        </div>
      </div>
  
      <!-- Box 2: Detalle de los inputs para llenar la tabla -->
      <div class="box box-custom-enod">
        <div class="box-body">
          <div class="form-group">
            <label for="operador">Operador *</label>
            <input id="operador" type="text" v-model="nuevoDetalle.operador" class="form-control" placeholder="Operador">
          </div>
          <div class="form-group">
            <label for="entrada">Entrada *</label>
            <input id="entrada" type="text" v-model="nuevoDetalle.entrada" class="form-control" placeholder="Entrada">
          </div>
          <div class="form-group">
            <label for="salida">Salida *</label>
            <input id="salida" type="text" v-model="nuevoDetalle.salida" class="form-control" placeholder="Salida">
          </div>
          <div class="form-group">
            <label for="contratista">Contratista *</label>
            <input id="contratista" type="text" v-model="nuevoDetalle.contratista" class="form-control" placeholder="Contratista">
          </div>
          <div class="form-group">
            <label for="parte">Parte *</label>
            <input id="parte" type="text" v-model="nuevoDetalle.parte" class="form-control" placeholder="Parte">
          </div>
          <button type="button" @click="agregarDetalle" class="btn btn-primary">Agregar Detalle</button>
        </div>
      </div>
  
      <!-- Tabla de Detalles -->
      <div class="box box-custom-enod">
        <div class="box-body">
          <table class="table">
            <thead>
              <tr>
                <th>Frente</th>
                <th>Fecha</th>
                <th>Operador</th>
                <th>Entrada</th>
                <th>Salida</th>
                <th>Contratista</th>
                <th>Parte</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(detalle, index) in detalles" :key="index">
                <td>{{ detalle.frente }}</td>
                <td>{{ detalle.fecha }}</td>
                <td>{{ detalle.operador }}</td>
                <td>{{ detalle.entrada }}</td>
                <td>{{ detalle.salida }}</td>
                <td>{{ detalle.contratista }}</td>
                <td>{{ detalle.parte }}</td>
                <td>
                  <button @click="eliminarDetalle(index)" class="btn btn-danger">
                    <i class="fa fa-trash"></i> Borrar
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
  
      <!-- Botones de Acción -->
      <div class="form-actions">
        <button @click="cancelar" class="btn btn-secondary">Cancelar</button>
        <button @click="confirmar" class="btn btn-success">OK</button>
      </div>
    </div>
  </template>
  
  <script>
  import DatePicker from 'vue2-datepicker';
  import 'vue2-datepicker/index.css';
  
  export default {
    components: {
      DatePicker
    },
    data() {
      return {
        detalles: [],
        nuevoDetalle: {
          frente: '',
          fecha: '',
          operador: '',
          entrada: '',
          salida: '',
          contratista: '',
          parte: ''
        }
      };
    },
    methods: {
      agregarDetalle() {
        this.detalles.push({...this.nuevoDetalle});
        this.nuevoDetalle = { frente: '', fecha: '', operador: '', entrada: '', salida: '', contratista: '', parte: '' };
      },
      eliminarDetalle(index) {
        this.detalles.splice(index, 1);
      },
      cancelar() {
        // Aquí debes definir qué sucederá cuando se presione "Cancelar"
      },
      confirmar() {
        // Aquí debes definir qué sucederá cuando se presione "OK"
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
  
  .btn-primary {
    margin-top: 15px;
  }
  
  /* Agrega tus propios estilos para mantener la estética de la página */
  </style>