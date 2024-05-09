<template>
  <div>
    <!-- Box 1: Frente y Fecha -->
    <div class="box box-custom-enod">
      <div class="box-body row">
        <div class="col-md-3">
          <div class="form-group">
            <label for="frente">Frente *</label>
            <v-select v-model="frente_selected" :options="frentes_opciones" label="codigo" id="frente"></v-select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="fecha">Fecha *</label>
            <date-picker id="fecha" v-model="fecha" value-type="YYYY-MM-DD" format="DD-MM-YYYY"></date-picker>
          </div>
        </div>
      </div>
    </div>

    <!-- Box 2: Detalle de los inputs para llenar la tabla -->
    <div class="box box-custom-enod">
      <div class="box-body row">
        <div class="col-md-2">
          <div class="form-group">
            <label for="frente">Operador *</label>
            <v-select v-model="operador_selected" :options="operarios_opciones" label="name" id="operador"></v-select>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label for="entrada">Entrada *</label>
            <!-- Utilizamos input de tipo time -->
            <input id="entrada" type="time" v-model="entrada_selected" class="form-control" placeholder="Entrada">
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label for="salida">Salida *</label>
            <!-- Utilizamos input de tipo time -->
            <input id="salida" type="time" v-model="salida_selected" class="form-control" placeholder="Salida">
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label for="frente">Contratista *</label>
            <v-select v-model="contratista_selected" :options="contratistas_opciones" label="nombre" id="contratista"></v-select>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-group">
            <label for="parte">Parte *</label>
            <input id="parte" type="text" v-model="parte_selected" class="form-control" placeholder="Parte">
          </div>
        </div>
        <div class="col-md-3">
          <button type="button" @click="agregarDetalle"><span class="fa fa-plus-circle"></span></button>
        </div>
      </div>
    </div>

    <!-- Tabla de Detalles -->
    <div class="box box-custom-enod">
      <div class="box-body">
        <table class="table">
          <thead>
            <tr>
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
              <td>{{ detalle.operador.name }}</td>
              <td>{{ detalle.entrada }}</td>
              <td>{{ detalle.salida }}</td>
              <td>{{ detalle.contratista.nombre }}</td>
              <td>{{ detalle.parte }}</td>
              <td>
                <button @click="eliminarDetalle(index)" class="text-center">
                  <i class="fa fa-minus-circle"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Botones de Acción -->
    <div class="form-actions">
      <div class="col-md-12">
        <button @click="cancelar" class="btn btn-secondary">Cancelar</button>
        <button @click="confirmar" class="btn btn-success">OK</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import vSelect from 'vue-select';

export default {
  components: {
    DatePicker,
    vSelect
  },
  props: {
    frentes_opciones: {
      type: Array,
      required: true
    },
    operarios_opciones: {
      type: Array,
      required: true
    },
    contratistas_opciones: {
      type: Array,
      required: true
    },
  },
  data() {
    return {
      detalles: [],
      fecha: '',
      frente_selected: '',
      operador_selected: '',
      entrada_selected: '',
      salida_selected: '',
      contratista_selected: '',
      parte_selected: '',
      nuevoDetalle: { operador: '', entrada: '', salida: '', contratista: '', parte: '' }
    };
  },
  methods: {
    agregarDetalle() {
      this.nuevoDetalle = {
        operador: this.operador_selected,
        entrada: this.entrada_selected,
        salida: this.salida_selected,
        contratista: this.contratista_selected,
        parte: this.parte_selected
      };
      this.detalles.push(this.nuevoDetalle);
      this.operador_selected = '';
      this.entrada_selected = '';
      this.salida_selected = '';
      this.contratista_selected = '';
      this.parte_selected = '';
    },
    eliminarDetalle(index) {
      this.detalles.splice(index, 1);
    },
    cancelar() {
      // Implementar lógica para cancelar
    },
    confirmar() {
      axios.post('/api/guardar_asistencia', {
        frente_id: this.frente_selected.id,
        fecha: this.fecha,
        detalles: this.detalles
      })
      .then(response => {
        // Manejar la respuesta exitosa
        console.log('Guardado exitosamente:', response);
      })
      .catch(error => {
        // Manejar errores
        console.error('Error al guardar:', error);
      });
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