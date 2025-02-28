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
            <label for="operador">ayudante</label>
            <v-select v-model="operador_ayudante" :options="operarios_opciones" label="name" id="ayudante"></v-select>
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
            <label for="contratista">cliente *</label>
            <v-select v-model="contratista_selected" :options="contratistas_opciones" label="nombre_fantasia" id="contratista"></v-select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="parte">Parte *</label>
            <input id="parte" type="text" v-model="parte_selected" class="form-control">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="metodoEnsayos">Técnica</label>
            <v-select v-model="metodoEnsayo_selected" :options="metodo_ensayos" label="metodo">
              <!-- Custom slot para mostrar metodo y descripcion -->
              <template slot="option" slot-scope="option">
                <span class="upSelect">{{ option.metodo }}</span> <br>
                <span class="downSelect">{{ option.descripcion }}</span>
              </template>
            </v-select>
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
              <th class="col-md-1 text-center">Ayudante</th>
              <th class="col-md-1 text-center">Entrada</th>
              <th class="col-md-1 text-center">Salida</th>
              <th class="col-md-2 text-center">cliente</th>
              <th class="col-md-2 text-center">Parte</th>
              <th class="col-md-1 text-center" v-if="detalles.some(detalle => detalle.contratista)">Técnica</th>
              <th class="col-md-1 text-center" colspan="1">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(detalle, index) in detalles" :key="index">
              <td class="text-center">{{ detalle.operador.name }}</td>
              <td class="text-center" v-if="detalle.ayudante && detalle.ayudante.name">{{ detalle.ayudante.name }}</td>
              <td class="text-center" v-else>-</td>
              <td>
                <input type="time" v-model="detalle.entrada" class="form-control" @change="calcularHorasExtrasDetall(detalle, index)" />
              </td>
              <td>
                <input type="time" v-model="detalle.salida" class="form-control" @change="calcularHorasExtrasDetall(detalle, index)" />
              </td>
              <td>
                <v-select
                  v-model="detalle.contratista"
                  :options="contratistas_opciones"
                  label="nombre_fantasia"
                  :reduce="contratista => contratista"
                ></v-select>
              </td>
              <td>
                <input 
                  type="text"
                  v-model="detalle.parte"
                  class="form-control text-center"
                />
              </td>
              <td class="text-center">
                <v-select
                  v-model="detalle.metodo_ensayo"
                  :options="metodo_ensayos"
                  label="metodo"
                  :reduce="option => option"
                >
                  <!-- Template para customizar la opción en el dropdown -->
                  <template #option="option">
                    <span class="upSelect">{{ option.metodo }}</span><br>
                    <span class="downSelect">{{ option.descripcion }}</span>
                  </template>
                </v-select>
              </td>
              <td class="col-md-1 text-center" style="width: 10px;margin-right: 10px">
                <i :class="detalle.observaciones ? 'fa fa-comment' : 'fa fa-comment-o'" 
                  @click="abrirObservacionModal(index)"
                  style="cursor: pointer;width: 10px;margin-right: 10px"></i>
                <i style="cursor: pointer;width: 10px;margin-right: 10px" class="fa fa-minus-circle" @click="eliminarDetalle(index)"></i>
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
    },
    metodo_ensayos:{
      type: Array,
      required: true
    },
  },
  data() {
    return {
      detalles: [],
      fecha: '',
      observacionTexto: '',
      frente_selected: '',
      fechas_bloqueadas: [],
      operador_selected: '',
      operador_ayudante: '',
      entrada_selected: moment('08:00', 'HH:mm').toDate(),
      salida_selected: moment('16:00', 'HH:mm').toDate(),
      contratista_selected: null,
      parte_selected: '',
      isLoading: false,
      hora_extra_sn: false,
      sdf_sn:false,
      horas_calculadas:'',
      metodoEnsayo_selected: '',
      feriados: [],
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

        $('#observacionModal').modal('hide'); // Ocultar el modal después de guardar
      }
    },
    ocultarModal() {
      $('#observacionModal').modal('hide');
    },
    actualizarFechasBloqueadas() {
      if (this.frente_selected && this.fechas_por_frente[this.frente_selected.id]) {
        this.fechas_bloqueadas = this.fechas_por_frente[this.frente_selected.id];
        this.fecha = '';
        this.sdf_sn = false;
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
    async verificarParte(parte) {
    try {
      // Verificar que el formato sea válido (solo números y guiones)
      const regex = /^[0-9]+(-[0-9]+)?$/;
      if (!regex.test(parte)) {
        toastr.error('Formato de parte inválido. Use solo números o "-" para separar.');
        return false; // Formato inválido
      }

      // Separar los números si hay un guion
      const partes = parte.split('-');
      
      // Verificar cada parte por separado
      for (let i = 0; i < partes.length; i++) {
        const response = await axios.post('/api/asistencia-comprobar-parte', {
          num: partes[i]
        });
        if (!response.data.exists) {
          toastr.error(`El parte ${partes[i]} no existe.`);
          return false; // Indica que uno de los partes no existe
        }
      }

      return true; // Todos los partes son válidos
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

    return response.data;
  } catch (error) {
    console.log('Error al verificar el usuario:', error.message);
    return false; // Asume que el usuario no existe si hay un error.
  }
},
async agregarDetalle() {
    // Verificar si ya existe el operador con el mismo cliente y la misma técnica
    const existeMismoClienteMismaTecnica = this.detalles.some(detalle => 
        detalle.operador.id === this.operador_selected.id &&
        detalle.contratista.id === this.contratista_selected.id &&
        detalle.metodo_ensayo === this.metodoEnsayo_selected
    );

    // Si el operador ya está con el mismo cliente y técnica, no permitir agregar
    if (existeMismoClienteMismaTecnica) {
        toastr.error('El operador ya está registrado con el mismo cliente y técnica');
        return;
    }

    // Verificaciones previas
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
    if (!this.contratista_selected) {
        toastr.error('Debe seleccionar un cliente');
        return;
    }
    if (this.contratista_selected && !this.parte_selected) {
        toastr.error('Debe ingresar un parte');
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
            console.error(`Parte "${this.parte_selected}" inexistente`);
            return;
        }
    }

    // Calcular los valores para nuevoDetalle
    const nuevoDetalle = {
        operador: this.operador_selected,
        ayudante: this.operador_ayudante,
        entrada: moment(this.entrada_selected).format('HH:mm'),
        salida: moment(this.salida_selected).format('HH:mm'),
        contratista: this.contratista_selected,
        parte: this.parte_selected,
        ayudante_sn: 1,
        hora_extra_sn: this.hora_extra_sn ? 1 : 0, // Convertir true/false a 1/0
        s_d_f_sn: this.sdf_sn ? 1 : 0,
        metodo_ensayo: this.metodoEnsayo_selected,
        observacion: this.observaciones || '',
    };

    // Agregar nuevoDetalle a la lista de detalles
    this.detalles.push(nuevoDetalle);
    this.operador_selected = '';
    this.operador_ayudante = '';
    this.entrada_selected = moment('08:00', 'HH:mm').toDate();
    this.salida_selected = moment('16:00', 'HH:mm').toDate();
    this.contratista_selected = null;
    this.metodoEnsayo_selected = '';
    this.parte_selected = '';
    this.observaciones = '';

    console.log(this.detalles);
}

,
    eliminarDetalle(index) {
      this.detalles.splice(index, 1);
    },
    async confirmar() {
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
      // Recorremos cada detalle y verificamos el parte
      for (let detalle of this.detalles) {
      // Verificación si hay contratista y el parte es requerido
      if (detalle.contratista && (!detalle.parte || detalle.parte.length < 1)) {
        toastr.error(`Parte requerido para el operador ${detalle.operador.name}`);
        this.isLoading = false;
        return;
      }

      // Verificación del 'parte' solo si tiene más de un carácter
      if (detalle.parte && detalle.parte.length > 1) {
        let parteEsValido = await this.verificarParte(detalle.parte);
        if (!parteEsValido) {
          // Si el parte no es válido, mostramos un error con el nombre del operador
          toastr.error(`Parte inexistente para el operador ${detalle.operador.name}`);
          this.isLoading = false; // Finaliza el estado de carga si estaba activo
          return; // Detenemos la ejecución de la función
        }
      }
    }

      // Si todos los partes son válidos, procedemos con la carga
      this.isLoading = true; 
      axios.post('/api/guardar_asistencia', {
        frente_id: this.frente_selected.id,
        fecha: this.fecha,
        detalles: this.detalles
      })
      .then(response => {
        toastr.success('Guardado exitosamente:', response);
        window.location.href = '/area/enod/asistencia/servicios';
      })
      .catch(error => {
        toastr.error('Error al guardar:', error);
      })
      .finally(() => {
        this.isLoading = false; // Disable loading after the request.finally(() => {
        this.isLoading = false; // Disable loading after the request
      });
    },
    convertirATiempo(horaDate) {
  // Asegurarse de que sea un objeto Date válido
  if (horaDate instanceof Date && !isNaN(horaDate)) {
    return {
      hours: horaDate.getHours(),      // Extrae horas
      minutes: horaDate.getMinutes(),  // Extrae minutos
      seconds: horaDate.getSeconds()   // Extrae segundos (si lo necesitas)
    };
  } else {
    console.error('El valor proporcionado no es un objeto Date válido.');
    return null;
  }
},

  },
  watch: {
    frente_selected: 'actualizarFechasBloqueadas',
    
    fecha(newFecha, oldFecha) {
      if (newFecha !== oldFecha) {
        this.detalles = []; 
      }
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

.btn-enod {
  background-color: rgb(255, 204, 0);
  color: rgb(0, 0, 0);
}

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

.custom-modal {
  border-radius: 0.5rem;
  background-color: #f8f9fa;
  border: 1px solid #dee2e6;
}

.custom-textarea {
  border-radius: 0.5rem;
  border: 1px solid #ced4da;
  resize: none;
  padding: 0.5rem;
}

.modal-header {
  border-bottom: 1px solid #dee2e6;
  padding: 1rem;
}

.modal-title {
  font-size: 1.25rem;
  font-weight: 500;
}

.modal-footer {
  border-top: 1px solid #dee2e6;
  padding: 1rem;
  display: flex;
  justify-content: flex-end;
}

.modal-content {
  border-radius: 0.5rem;
}
.hidden {
  display: none;
}
.modal-body {
  padding: 1rem;
}

.modal-footer .btn {
  margin-left: 0.5rem;
}

</style>