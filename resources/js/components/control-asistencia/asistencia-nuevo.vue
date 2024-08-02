<template>
  <div>
    <!-- Box 1: Frente y Fecha -->
    <div class="box box-custom-enod">
      <div class="box-body row">
        <div class="col-md-3">
          <div class="form-group">
            <label for="frente">Frente *</label>
            <v-select v-model="frente_selected" :options="frentes_opciones" label="codigo" id="frente" @input="actualizarFechasBloqueadas"></v-select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="fecha">Fecha *</label>
            <date-picker 
              id="fecha" 
              v-model="fecha" 
              value-type="YYYY-MM-DD" 
              format="DD-MM-YYYY"
              :disabled-date="bloquearFechas">
            </date-picker>
          </div>
        </div>
      </div>
    </div>

    <!-- Box 2: Detalle de los inputs para llenar la tabla -->
    <div class="box box-custom-enod">
      <div class="box-body row">
        <div class="col-md-3">
          <div class="form-group">
            <label for="operador">Operador *</label>
            <v-select v-model="operador_selected" :options="operarios_opciones" label="name" id="operador"></v-select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="entrada">Entrada *</label>
            <div class="bootstrap-timepicker">
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-clock-o"></i>
                </div>
                <timeselector v-model="entrada_selected"></timeselector>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="salida">Salida *</label>
            <div class="bootstrap-timepicker">
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-clock-o"></i>
                </div>
                <timeselector v-model="salida_selected"></timeselector>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="contratista">Contratista</label>
            <v-select v-model="contratista_selected" :options="contratistas_opciones" label="nombre" id="contratista"></v-select>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="parte">Parte</label>
            <input id="parte" type="text" v-model="parte_selected" class="form-control" placeholder="Parte">
          </div>
        </div>
        <div class="col-md-3">
          <div style="display:flex;justify-content: flex-start;align-items: center;">
            <button type="button" @click="agregarDetalle" style="margin-top:25px;"><span class="fa fa-plus-circle"></span></button>
          </div>
        </div>
      </div>
    </div>

    <!-- Tabla de Detalles -->
    <div class="box box-custom-enod">
      <div class="box-body">
        <table class="table table-hover table-striped table-condensed">
          <thead>
            <tr>
              <th>Operador</th>
              <th>Responsabilidad</th>
              <th>Entrada</th>
              <th>Salida</th>
              <th>Contratista</th>
              <th>Parte</th>
              <th style="text-align: center;">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(detalle, index) in detalles" :key="index">
              <td>{{ detalle.operador.name }}</td>
              <td>
                <select v-model="detalle.ayudante_sn">
                  <option value="1">Operador</option>
                  <option value="0">Ayudante</option>
                </select>
              </td>
              <td>{{ detalle.entrada }}</td>
              <td>{{ detalle.salida }}</td>
              <td>{{ detalle.contratista ? detalle.contratista.nombre : '-' }}</td>
              <td>{{ detalle.parte ? detalle.parte : '-'}}</td>
              <td style="text-align:center">
                <i class="fa fa-minus-circle" @click="eliminarDetalle(index)"></i>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Botones de Acción -->
    <div class="form-actions">
      <div class="col-md-12">
        <button @click="confirmar" class="btn btn-enod">Guardar</button>
      </div>
    </div>
          <loading
            :active.sync="isLoading"
            :loader="'bars'"
            :color="'red'">
          </loading>
  </div>
</template>

<script>
import axios from 'axios';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/es';
import vSelect from 'vue-select';
import Timeselector from 'vue-timeselector';
import moment from 'moment';
import Loading from 'vue-loading-overlay';
import { toastrInfo,toastrDefault } from '../toastrConfig';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
  components: {
    DatePicker,
    vSelect,
    Timeselector,
    Loading
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
    fechas_por_frente: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      detalles: [],
      fecha: '',
      frente_selected: '',
      fechas_bloqueadas: [],
      operador_selected: '',
      entrada_selected: moment('08:00', 'HH:mm').toDate(),
      salida_selected: moment('16:00', 'HH:mm').toDate(),
      contratista_selected: '',
      parte_selected: '',
      isLoading: false,
    };
  },
  methods: {
    actualizarFechasBloqueadas() {
      if (this.frente_selected && this.fechas_por_frente[this.frente_selected.id]) {
        this.fechas_bloqueadas = this.fechas_por_frente[this.frente_selected.id];
      } else {
        this.fechas_bloqueadas = [];
      }
    },
    bloquearFechas(date) {
      return this.fechas_bloqueadas.includes(moment(date).format('YYYY-MM-DD'));
    },
    filtrarOperarios() {
      if (this.frente_selected && this.frente_selected.id === 2) {
        return this.operarios_opciones;
      }
      return this.operarios_opciones;
    },
    async verificarParte() {
    try {
      const response = await axios.post('/api/asistencia-comprobar-parte', {
        num: this.parte_selected
      });
      if (!response.data.exists) {
        toastr.error('Parte inexistente');
        return false; // Indica que el parte no existe
      }
      return true; // Indica que el parte existe
    } catch (error) {
      toastr.error('Error al verificar el parte');
      return false; // Indica que ocurrió un error en la verificación
    }
  },
  async agregarDetalle() {
    // Verificar si el operador ya está en la lista de detalles
    const existeOperador = this.detalles.some(detalle => detalle.operador.id === this.operador_selected.id);
    
    // Si el operador ya está en la lista, mostrar un toastr.error
    if (existeOperador) {
      toastr.error('Operador ya seleccionado');
      return;
    }
    if (!this.operador_selected) {
      toastr.error('Debe seleccionar un operador');
      return;
    }
    if (!this.entrada_selected) {
      toastr.error('Debe seleccionar horario de entrada');
      return;
    }
    if (!this.salida_selected) {
      toastr.error('Debe seleccionar horario de salida');
      return;
    }
    if (this.contratista_selected && !this.parte_selected) {
      toastr.error('Parte obligatorio');
      return;
    }

    // Verificar si el parte es válido
    const parteValido = await this.verificarParte();
    if (!parteValido) {
      return;
    }

    // Calcular los valores para nuevoDetalle
    const nuevoDetalle = {
      operador: this.operador_selected,
      entrada: moment(this.entrada_selected).format('HH:mm'),
      salida: moment(this.salida_selected).format('HH:mm'),
      contratista: this.contratista_selected,
      parte: this.parte_selected,
      ayudante_sn: this.operador_selected.habilitado_arn_sn, // Usar el valor predeterminado
    };

    // Agregar nuevoDetalle a la lista de detalles
    this.detalles.push(nuevoDetalle);
    this.operador_selected = '';
    this.entrada_selected = moment('08:00', 'HH:mm').toDate();
    this.salida_selected = moment('16:00', 'HH:mm').toDate();
    this.contratista_selected = '';
    this.parte_selected = '';
  },
    eliminarDetalle(index) {
      this.detalles.splice(index, 1);
    },
    confirmar() {
      // Validaciones por separado con mensajes Toastr
      if (!this.frente_selected) {
        toastr.error('Debe seleccionar un frente');
        return;
      }
      if (!this.fecha) {
        toastr.error('Debe seleccionar una fecha');
        return;
      }
      if (this.detalles.length === 0) {
        toastr.error('Debe agregar al menos un detalle');
        return;
      }
      this.isLoading = true; // Enable loading before the request
      axios.post('/api/guardar_asistencia', {
        frente_id: this.frente_selected.id,
        fecha: this.fecha,
        detalles: this.detalles
      })
      .then(response => {
        toastr.success('Guardado exitosamente:', response);
        window.location.href = '/area/enod/asistencia';
      })
      .catch(error => {
        toastr.error('Error al guardar:', error);
      })
      .finally(() => {
        this.isLoading = false; // Disable loading after the request.finally(() => {
        this.isLoading = false; // Disable loading after the request
      });
    }
  },
  watch: {
    frente_selected: 'actualizarFechasBloqueadas'
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