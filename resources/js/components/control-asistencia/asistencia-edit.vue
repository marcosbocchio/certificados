<template>
  <div>
    <!-- Box 1: Frente y Fecha -->
    <div class="box box-custom-enod">
      <div class="box-body row">
        <div class="col-md-3">
          <div class="form-group">
            <label for="frente">Frente *</label>
            <v-select v-model="frente_selected" :options="frentes_opciones" label="codigo" id="frente" :disabled="isDisabled"></v-select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="fecha">Fecha *</label>
            <date-picker id="fecha" v-model="fecha" value-type="YYYY-MM-DD" format="DD-MM-YYYY" :disabled="isDisabled"></date-picker>
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
            <label for="contratista">cliente</label>
            <v-select v-model="contratista_selected" :options="contratistas_opciones" label="name" id="contratista"></v-select>
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
              <th class="col-md-2 text-center">Operador</th>
              <th class="col-md-2 text-center">Responsabilidad</th>
              <th class="col-md-2 text-center">Entrada</th>
              <th class="col-md-2 text-center">Salida</th>
              <th class="col-md-2 text-center">cliente</th>
              <th class="col-md-2 text-center">Parte</th>
              <th style="text-align: center;" colspan="2">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(detalle, index) in detalles" :key="index">
              <td>{{ detalle.operador.name }}</td>
              <td>
                <select v-model="detalle.ayudante_sn" class="form-control">
                  <option value="1">Operador</option>
                  <option value="0">Ayudante</option>
                </select>
              </td>
              <td>
                <input type="time" v-model="detalle.entrada"  class="form-control"/>
              </td>
              <td>
                <input type="time" v-model="detalle.salida"  class="form-control"/>
              </td>
              <td>
                <v-select
                  v-model="detalle.contratista"
                  :options="contratistas_opciones"
                  label="name"
                  :reduce="contratista => contratista"
                ></v-select>
              </td>
              <td>
                <input 
                  type="text" 
                  v-model="detalle.parte"
                  class="form-control"
                />
              </td>
              <td style="width: 10px;">
                <i :class="detalle.observaciones ? 'fas fa-comment-alt' : 'far fa-comment-alt'" 
                  @click="abrirObservacionModal(index)"
                  style="cursor: pointer;"></i>
              </td>
              <td>
                <i class="fa fa-minus-circle" @click="eliminarDetalle(index)"></i>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="modal fade" id="observacionModal" tabindex="-1" aria-labelledby="observacionModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content custom-modal">
          <div class="modal-header">
            <h5 class="modal-title" id="observacionModalLabel">Agregar Observación</h5>
          </div>
          <div class="modal-body">
            <textarea v-model="observacionTexto" class="form-control custom-textarea" rows="4" maxlength="200"></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="ocultarModal">Cancelar</button>
            <button type="button" class="btn btn-enod" @click="guardarObservacion">Guardar</button>
          </div>
        </div>
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
    asistenciaId: {
      type: Number,
      required: true
    },
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
    }
  },
  mounted() {
    this.cargarDatos();
  },
  data() {
    return {
      detalles: [],
      fecha: '',
      isDisabled: true, 
      frente_selected: '',
      observacionTexto: '',
      operador_selected: '',
      entrada_selected: moment('08:00', 'HH:mm').toDate(),
      salida_selected: moment('16:00', 'HH:mm').toDate(),
      observacionTexto: '',
      contratista_selected: '',
      parte_selected: '',
      isLoading: false,
    };
  },
  methods: {
    abrirObservacionModal(index) {
      this.observacionIndex = index;
      this.observacionTexto = this.detalles[index].observaciones || ''; // Cargar la observación si existe
      $('#observacionModal').modal('show'); // Mostrar el modal (usando jQuery)
    },
    guardarObservacion() {
      if (this.observacionIndex !== null) {
        this.$set(this.detalles[this.observacionIndex], 'observaciones', this.observacionTexto);
        console.log(this.detalles[this.observacionIndex]);
        $('#observacionModal').modal('hide'); // Ocultar el modal después de guardar
      }
    },
    ocultarModal() {
      $('#observacionModal').modal('hide');
    },
    async verificarParte(parte) {
  try {
    const response = await axios.post('/api/asistencia-comprobar-parte', {
      num: parte
    });
    if (!response.data.exists) {
      return false; // Indica que el parte no existe
    }
    return true; // Indica que el parte existe
  } catch (error) {
    toastr.error('Error al verificar el parte');
    return false; // Indica que ocurrió un error en la verificación
  }
},
  async verificarUser(user_id, fecha) {
  try {
    // Formatea la fecha al estilo "MM-YYYY"
    const date = new Date(fecha);
    const formattedDate = `${('0' + (date.getMonth() + 1)).slice(-2)}-${date.getFullYear()}`;
    
    const response = await axios.get(`/api/asistencia-comprobar-user/${user_id}/${formattedDate}`);
    console.log(response.data);
    return response.data;
  } catch (error) {
    console.log('Error al verificar el usuario:', error.message);
    return false; // Asume que el usuario no existe si hay un error.
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

         // Verificar si la fecha ya está bloqueada para este operador
  const fecha_operador = await this.verificarUser(this.operador_selected.id, this.fecha);
  const fechaSeleccionada = moment(this.fecha);

  // Comprobar si el mes está cerrado
  if (fecha_operador.fecha_pago_mes != null) {
    toastr.error('El operador tiene el mes cerrado');
    return;
  }

  // Definir las semanas del mes
  const inicioMes = fechaSeleccionada.clone().startOf('month');
  const semanas = [
    { inicio: inicioMes.clone(), fin: inicioMes.clone().add(1, 'weeks').subtract(1, 'days') }, // Semana 1
    { inicio: inicioMes.clone().add(1, 'weeks'), fin: inicioMes.clone().add(2, 'weeks').subtract(1, 'days') }, // Semana 2
    { inicio: inicioMes.clone().add(2, 'weeks'), fin: inicioMes.clone().add(3, 'weeks').subtract(1, 'days') }, // Semana 3
    { inicio: inicioMes.clone().add(3, 'weeks'), fin: inicioMes.clone().add(4, 'weeks').subtract(1, 'days') }, // Semana 4
    { inicio: inicioMes.clone().add(4, 'weeks'), fin: inicioMes.clone().endOf('month') } // Semana 5 (si existe)
  ];

  // Verificar cada semana
  if (fecha_operador.fecha_pago_s1 != null && fechaSeleccionada.isBetween(semanas[0].inicio, semanas[0].fin, null, '[]')) {
    toastr.error('El operador tiene la semana 1 cerrada');
    return;
  }
  if (fecha_operador.fecha_pago_s2 != null && fechaSeleccionada.isBetween(semanas[1].inicio, semanas[1].fin, null, '[]')) {
    toastr.error('El operador tiene la semana 2 cerrada');
    return;
  }
  if (fecha_operador.fecha_pago_s3 != null && fechaSeleccionada.isBetween(semanas[2].inicio, semanas[2].fin, null, '[]')) {
    toastr.error('El operador tiene la semana 3 cerrada');
    return;
  }
  if (fecha_operador.fecha_pago_s4 != null && fechaSeleccionada.isBetween(semanas[3].inicio, semanas[3].fin, null, '[]')) {
    toastr.error('El operador tiene la semana 4 cerrada');
    return;
  }
  if (fecha_operador.fecha_pago_s5 != null && fechaSeleccionada.isBetween(semanas[4].inicio, semanas[4].fin, null, '[]')) {
    toastr.error('El operador tiene la semana 5 cerrada');
    return;
  }

  if (this.parte_selected) {
    const parteValido = await this.verificarParte(this.parte_selected);
    if (!parteValido) {
      toastr.error(`Parte "${this.parte_selected}" inexistente`);
      return; // Si el parte no es válido, detenemos la ejecución
    }
  }

    // Calcular los valores para nuevoDetalle
    const nuevoDetalle = {
      operador: this.operador_selected,
      entrada: moment(this.entrada_selected).format('HH:mm'),
      salida: moment(this.salida_selected).format('HH:mm'),
      contratista: this.contratista_selected,
      parte: this.parte_selected,
      ayudante_sn: this.operador_selected.habilitado_arn_sn,
      observacion : this.observaciones ? this.observaciones : '',
    };

    // Agregar nuevoDetalle a la lista de detalles
    this.detalles.push(nuevoDetalle);
    this.operador_selected = '';
    this.entrada_selected = moment('08:00', 'HH:mm').toDate();
    this.salida_selected = moment('16:00', 'HH:mm').toDate();
    this.contratista_selected = '';
    this.parte_selected = '';
    this.observaciones = '';
  },
    cargarDatos() {
    this.isLoading = true; // Inicia el estado de carga
    axios.get(`/api/asistencia/${this.asistenciaId}`)
      .then(response => {
        this.detalles = response.data.detalles.map(detalle => ({
          ...detalle,
          entrada: moment(detalle.entrada, 'HH:mm:ss').format('HH:mm'),
          salida: moment(detalle.salida, 'HH:mm:ss').format('HH:mm')
        }));
        this.fecha = response.data.fecha;
        this.frente_selected = response.data.frente;
        
      })
      .catch(error => {
        console.error('Error cargando los datos de asistencia:', error);
      })
      .finally(() => {
        this.isLoading = false; // Finaliza el estado de carga
      });
},
    eliminarDetalle(index) {
      this.detalles.splice(index, 1);
    },
    filtrarOperarios() {
      if (this.frente_selected && this.frente_selected.id === 2) {
        return this.operarios_opciones.filter(operario => operario.local_neuquen_sn === 1);
      }
      return this.operarios_opciones;
    },
    async confirmar() {
  // Recorremos cada detalle y verificamos el parte
  for (let detalle of this.detalles) {
    if (detalle.contratista !== null) {
      continue; // Si contratista no es null, saltamos a la siguiente iteración
    }

    let parteEsValido = await this.verificarParte(detalle.parte);
    if (!parteEsValido) {
      // Si el parte no es válido, mostramos un error con el nombre del operador
      toastr.error(`Parte inexistente para el operador ${detalle.operador.name}`);
      this.isLoading = false; // Finaliza el estado de carga si estaba activo
      return; // Detenemos la ejecución de la función
    }
  }

  // Si todos los partes son válidos, procedemos con la carga
  this.isLoading = true; // Inicia el estado de carga
  axios.post(`/api/asistencia/${this.asistenciaId}/update`, {
    detalles: this.detalles,
    fecha: this.fecha,
    frente_id: this.frente_selected.id
  }).then(response => {
    this.isLoading = false; // Finaliza el estado de carga
    toastr.success('Detalles actualizados con éxito');
    window.location.href = '/area/enod/asistencia';
  }).catch(error => {
    this.isLoading = false; // Finaliza el estado de carga
    toastr.error('Error al actualizar los detalles');
  });
},
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
.v-select.disabled, .date-picker.disabled {
  background-color: #6c757d; /* Gris claro, ajusta según tu tema */
  cursor: not-allowed;
}
/* Agrega tus propios estilos para mantener la estética de la página */
</style>