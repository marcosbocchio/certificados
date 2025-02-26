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
            <input id="parte" type="text" v-model="parte_selected" class="form-control" placeholder="Parte">
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
              <th class="col-md-1 text-center">Técnica</th>
              <th class="col-md-1 text-center" colspan="2">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(detalle, index) in detalles" :key="index">
              <td class="text-center" >{{ detalle.operador.name }}</td>
              <td class="text-center"  v-if="detalle.ayudante && detalle.ayudante.name">{{ detalle.ayudante.name }}</td>
              <td class="text-center"  v-else>-</td>
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
                  class="form-control"
                />
              </td>
              <td class="text-center">
                <!-- Si detalle.metodo_ensayo existe, muestra el v-select -->
                <v-select
                  v-if="detalle.metodo_ensayo"
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

                <!-- Si detalle.metodo_ensayo no existe, muestra un input vacío -->
                <v-select
                v-else
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
              <td class="col-md-1 text-center">
                <i  :class="detalle.observaciones ? 'fa fa-comment' : 'fa fa-comment-o'" 
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
    },
    metodo_ensayos:{
      type: Array,
      required: true
    },
  },
  mounted() {
    this.cargarDatos();
    this.mostrarSDFCheckbox;
  },
  data() {
    return {
      detalles: [],
      fecha: '',
      isDisabled: true, 
      frente_selected: '',
      observacionTexto: '',
      operador_selected: '',
      operador_ayudante: '',
      entrada_selected: moment('08:00', 'HH:mm').toDate(),
      salida_selected: moment('16:00', 'HH:mm').toDate(),
      observacionTexto: '',
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
    
    async guardarObservacion() {
    if (this.observacionIndex === null) {
        toastr.error('No se ha seleccionado ningún detalle para guardar la observación.');
        return;
    }

    // Validación de existencia del detalle seleccionado
    const detalleSeleccionado = this.detalles[this.observacionIndex];
    if (!detalleSeleccionado) {
        toastr.error('El detalle seleccionado no es válido.');
        return;
    }

    try {
        // Actualiza localmente la observación
        this.$set(detalleSeleccionado, 'observaciones', this.observacionTexto);

        // Prepara los datos para enviar
        const detalleData = {
            operador_id: detalleSeleccionado.operador?.id || null,
            ayudante_id: detalleSeleccionado.ayudante?.id || null,
            metodo_ensayo: detalleSeleccionado.metodo_ensayo?.id || null,
            ayudante_sn: !!detalleSeleccionado.ayudante_sn, // Convierte a boolean
            entrada: detalleSeleccionado.entrada || '',
            salida: detalleSeleccionado.salida || '',
            contratista_id: detalleSeleccionado.contratista?.id || null,
            parte: detalleSeleccionado.parte || null,
            observaciones: this.observacionTexto || '',
            hora_extra_sn: detalleSeleccionado.hora_extra_sn ? 1 : 0,
            s_d_f_sn: detalleSeleccionado.s_d_f_sn ? 1 : 0
        };

        console.log('Datos a guardar:', detalleData);

        // Realiza la solicitud PATCH
        const asistenciaId = this.asistenciaId; // Se asume que ya está definido en el componente
        if (!asistenciaId) {
            toastr.error('ID de asistencia no definido.');
            return;
        }

        await axios.patch(`/api/asistencia-detalle/${asistenciaId}/guardar-observacion`, detalleData);

        // Mensaje de éxito
        toastr.success('Observación actualizada con éxito!');
        
        // Cierra el modal
        $('#observacionModal').modal('hide');
    } catch (error) {
        // Manejo de errores
        console.error('Error al guardar la observación:', error);
        toastr.error('Error al guardar la observación.');
    }
},
    ocultarModal() {
      $('#observacionModal').modal('hide');
    },
    async verificarParte(parte) {
      const regex = /^[0-9]+(-[0-9]+)?$/;
      if (!regex.test(parte)) {
        toastr.error('Formato de parte inválido. Use solo números o "-" para separar.');
        return false; // Formato inválido
      }

      const partes = parte.split('-');
      for (let i = 0; i < partes.length; i++) {
        try {
          const response = await axios.post('/api/asistencia-comprobar-parte', {
            num: partes[i]
          });
          if (!response.data.exists) {
            toastr.error(`El parte ${partes[i]} no existe.`);
            return false; // Parte no existe
          }
        } catch (error) {
          toastr.error('Error al verificar el parte');
          return false; // Error en la verificación
        }
      }
      return true; // Todos los partes son válidos
    },

    async verificarTodosLosPartes() {
  for (let detalle of this.detalles) {
    // Verificar si falta el contratista
    if (!detalle.contratista) {
      toastr.error(`Cliente requerido para el operador "${detalle.operador.name}"`);
      return false; // Detener si no tiene cliente
    }

    // Verificar si tiene parte y contratista
    if (detalle.contratista && detalle.parte) {
      const parteValido = await this.verificarParte(detalle.parte);
      if (!parteValido) {
        toastr.error(`Parte "${detalle.parte}" del operador "${detalle.operador.name}" es inválido`);
        return false; // Detener si algún parte no es válido
      }
    }

    // Verificar si tiene contratista pero falta parte
    if (detalle.contratista && !detalle.parte) {
      toastr.error(`Parte requerido para el operador "${detalle.operador.name}"`);
      return false; // Detener si falta algún parte
    }
  }
  return true; // Todos los partes y clientes son válidos
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
    if (!this.operador_selected) return toastr.error('Debe seleccionar un operador');
    if (!this.contratista_selected) return toastr.error('Debe seleccionar un cliente');
    if (!this.entrada_selected) return toastr.error('Debe seleccionar horario de entrada');
    if (!this.salida_selected) return toastr.error('Debe seleccionar horario de salida');
    if (this.contratista_selected && !this.parte_selected) return toastr.error('Parte obligatorio');
    
    const existeOperador = this.detalles.some(detalle => detalle.operador.id === this.operador_selected.id);
    const existeAyudante = this.detalles.some(detalle => detalle.operador.id === this.operador_ayudante?.id);
    if (existeOperador) return toastr.error('Operador ya seleccionado');
    if (existeAyudante) return toastr.error('Ayudante seleccionado como operador');
    if (this.operador_selected?.id === this.operador_ayudante?.id) return toastr.error('Ayudante seleccionado como operador');
    
    const fecha_operador = await this.verificarUser(this.operador_selected.id, this.fecha);
    if (fecha_operador.fecha_pago_mes) return toastr.error('El operador tiene el mes cerrado');
    
    const fechaSeleccionada = moment(this.fecha);
    const inicioMes = fechaSeleccionada.clone().startOf('month');
    const semanas = Array.from({ length: 5 }, (_, i) => ({
        inicio: inicioMes.clone().add(i, 'weeks'),
        fin: inicioMes.clone().add(i + 1, 'weeks').subtract(1, 'days')
    }));
    semanas[4].fin = inicioMes.clone().endOf('month');

    for (let i = 0; i < semanas.length; i++) {
        if (fecha_operador[`fecha_pago_s${i + 1}`] && fechaSeleccionada.isBetween(semanas[i].inicio, semanas[i].fin, null, '[]')) {
            return toastr.error(`El operador tiene la semana ${i + 1} cerrada`);
        }
    }

    if (this.parte_selected && !(await this.verificarParte(this.parte_selected))) return;
    if (!this.mostrarSDFCheckboxCol) this.sdf_sn = false;
    
    this.detalles.push({
        operador: this.operador_selected,
        ayudante: this.operador_ayudante,
        entrada: moment(this.entrada_selected).format('HH:mm'),
        salida: moment(this.salida_selected).format('HH:mm'),
        contratista: this.contratista_selected,
        parte: this.parte_selected,
        ayudante_sn: 1,
        hora_extra_sn: this.hora_extra_sn ? 1 : 0,
        s_d_f_sn: this.sdf_sn ? 1 : 0,
        metodo_ensayo: this.metodoEnsayo_selected,
        observacion: this.observaciones || ''
    });
    
    Object.assign(this, {
        operador_selected: '',
        operador_ayudante: '',
        entrada_selected: moment('08:00', 'HH:mm').toDate(),
        salida_selected: moment('16:00', 'HH:mm').toDate(),
        contratista_selected: null,
        metodoEnsayo_selected: '',
        parte_selected: '',
        observaciones: ''
    });
}
,
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
        console.log(this.detalles);
        this.obtenerFeriados();
      })
      .catch(error => {
        console.error('Error cargando los datos de asistencia:', error);
      })
      .finally(() => {
        console.log(this.detalles);
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
      // Verificar todos los partes antes de guardar
      const todosValidos = await this.verificarTodosLosPartes();
      if (!todosValidos) {
        this.isLoading = false;
        return; // Si hay partes no válidos, detenemos la ejecución
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
    window.location.href = '/area/enod/asistencia/servicios';
  }).catch(error => {
    this.isLoading = false; // Finaliza el estado de carga
    toastr.error('Error al actualizar los detalles');
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

calcularDiferencia(horaInicio, horaFin) {
  const inicio = this.convertirATiempo(horaInicio); // { hours, minutes, seconds }
  const fin = this.convertirATiempo(horaFin); // { hours, minutes, seconds }

  if (!inicio || !fin) {
    console.error('No se pudieron obtener las horas correctamente.');
    return null;
  }

  // Convertir ambas horas a segundos totales para mayor precisión
  const segundosInicio = inicio.hours * 3600 + inicio.minutes * 60 + inicio.seconds;
  const segundosFin = fin.hours * 3600 + fin.minutes * 60 + fin.seconds;

  // Calcular diferencia en segundos
  let diferenciaSegundos = segundosFin - segundosInicio;

  // Si la diferencia es negativa (fin es antes que inicio), ajustamos para el siguiente día
  if (diferenciaSegundos < 0) {
    diferenciaSegundos += 24 * 3600; // Añadir un día en segundos
  }

  // Convertir de nuevo a horas, minutos y segundos
  const horasDiferencia = Math.floor(diferenciaSegundos / 3600);
  const minutosDiferencia = Math.floor((diferenciaSegundos % 3600) / 60);
  const segundosDiferencia = diferenciaSegundos % 60;

  // Convertir los minutos a decimales y sumarlos a las horas
  const horasConDecimales = horasDiferencia + (minutosDiferencia / 60);

  // Redondear los segundos para evitar errores en la representación
  const horasTotales = Math.round(horasConDecimales * 100) / 100;

  this.horas_calculadas = horasTotales;

  return { horas: horasTotales, minutos: minutosDiferencia, segundos: segundosDiferencia };
},
async obtenerFeriados() {
    const year = new Date(this.fecha).getFullYear(); // Obtenemos el año de la fecha seleccionada
    try {
      const response = await axios.get(`/api/asistencia/getferiados/${year}`);
      this.feriados = response.data;
      console.log(this.feriados);
    } catch (error) {
      console.error("Error al obtener los feriados:", error);
    }
  },
  esFeriado() {
  const fechaSeleccionada = new Date(this.fecha + 'T00:00:00'); // Establecer la hora a medianoche
  console.log('Fecha seleccionada:', fechaSeleccionada);

  const dia = fechaSeleccionada.getDate();
  const mes = fechaSeleccionada.getMonth() + 1;
  const anio = fechaSeleccionada.getFullYear();

  const fechaFormateada = `${anio}-${('0' + mes).slice(-2)}-${('0' + dia).slice(-2)}`;
  const feriado = this.feriados.includes(fechaFormateada);

  console.log('Fecha formateada:', fechaFormateada, 'Es feriado:', feriado);
  return feriado;
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
.hidden {
  display: none;
}
/* Agrega tus propios estilos para mantener la estética de la página */
</style>