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
            <v-select v-model="contratista_selected" :options="contratistas_opciones" label="nombre_fantasia" id="contratista"></v-select>
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
        <!-- Hora Extra Checkbox -->
        <div class="col-md-3">
          <div class="form-group" style="margin-top: 30px;">
            <label v-if="mostrarHoraExtra">
              <input type="checkbox" v-model="hora_extra_sn"> Pagar Hora Extra
            </label>
            <label v-if="mostrarSDFCheckbox">
              <input type="checkbox" v-model="sdf_sn"> Pagar Sab. / Dom. / Feriado
            </label>
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
              <th class="col-md-1 text-center">Responsabilidad</th>
              <th class="col-md-1 text-center">Entrada</th>
              <th class="col-md-1 text-center">Salida</th>
              <th class="col-md-2 text-center">cliente</th>
              <th class="col-md-2 text-center">Parte</th>
              <th class="col-md-1 text-center" v-if="detalles.some(detalle => detalle.contratista)">Técnica</th>
              <th class="col-md-2 text-center">
                <!-- Mostrar el texto y columna de acuerdo a los estados -->
                <span v-if="mostrarSDFCheckboxCol">Sab. Dom. Fer.</span>
                <span v-else-if="mostrarHoraExtraCol">Horas Extras</span>
              </th>
              <th class="col-md-1 text-center" colspan="2">Acciones</th>
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
              <td :class="{ 'hidden': !detalles.some(detalle => detalle.contratista) }">
                <input 
                  type="text" 
                  v-if="detalle.metodo_ensayo" 
                  v-model="detalle.metodo_ensayo.metodo"
                  class="form-control text-center"
                  disabled
                />
                <input 
                  type="text" 
                  v-else  
                  class="form-control text-center"
                  disabled
                />
              </td>
              <td class="text-center">
                <!-- Mostrar solo una opción dependiendo del estado -->
                <label v-if="mostrarSDFCheckboxCol">
                  <input type="checkbox" v-model="detalle.s_d_f_sn">
                </label>
                <label v-else-if="mostrarHoraExtraCol">
                  <input type="checkbox" v-model="detalle.hora_extra_sn">
                </label>
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
      entrada_selected: moment('08:00', 'HH:mm').toDate(),
      salida_selected: moment('16:00', 'HH:mm').toDate(),
      observacionTexto: '',
      contratista_selected: '',
      parte_selected: '',
      isLoading: false,
      hora_extra_sn: false,
      sdf_sn:false,
      horas_calculadas:'',
      metodoEnsayo_selected: '',
      feriados: [],
    };
  },
  computed: {
    mostrarHoraExtra() {
        const fechaSeleccionada = new Date(this.fecha);
        const diaSemana = fechaSeleccionada.getDay();

        // Verificamos si el checkbox SDF debería mostrarse
        if (this.mostrarSDFCheckboxCol) {
            return false; // Si el checkbox SDF se muestra, no mostrar el checkbox de hora extra
        }

        // Verificamos si es día de semana (Lunes a Viernes, es decir, 1 a 5)
        const esDiaDeSemana = diaSemana >= 1 && diaSemana <= 5;

        // Si las horas calculadas son mayores que las horas diarias laborables y es día de semana
        if (this.horas_calculadas > this.frente_selected.horas_diarias_laborables && esDiaDeSemana) {
            this.hora_extra_sn = true; // Marca el checkbox como true
            return true; // Mostrar el checkbox de hora extra
        } else {
            this.hora_extra_sn = false;
            return false; // No mostrar el checkbox de hora extra
        }
    },
    
    mostrarHoraExtraCol() {
        const fechaSeleccionada = new Date(this.fecha);
        const diaSemana = fechaSeleccionada.getDay();

        // Verificamos si el checkbox SDF debería mostrarse
        if (this.mostrarSDFCheckboxCol) {
            return false; // Si el checkbox SDF se muestra, no mostrar el checkbox de hora extra
        }

        const esDiaDeSemana = diaSemana >= 1 && diaSemana <= 5;

        if (esDiaDeSemana) {
            return true; // Mostrar el checkbox
        } else {
            return false; // No mostrar el checkbox
        }
    },
    
    mostrarSDFCheckbox() {
        const fechaSeleccionada = new Date(this.fecha);
        const diaSemana = fechaSeleccionada.getDay();

        const esSabadoODomingo = diaSemana === 5 || diaSemana === 6;

        if (esSabadoODomingo || this.esFeriado()) {
            this.sdf_sn = true;
            return true;
        } else {
            this.sdf_sn = false;
            return false;
        }
    },

    mostrarSDFCheckboxCol() {
        const fechaSeleccionada = new Date(this.fecha);
        const diaSemana = fechaSeleccionada.getDay();

        const esSabadoODomingo = diaSemana === 5 || diaSemana === 6;

        if (esSabadoODomingo || this.esFeriado()) {
            return true; // Mostrar el checkbox
        } else {
            return false; // No mostrar el checkbox
        }
    },
},
watch: {
  entrada_selected(newVal) {

if (this.salida_selected) {
  // Si ya hay una salida seleccionada, calcular la diferencia
  this.calcularDiferencia(this.entrada_selected, this.salida_selected);
}
},
salida_selected(newVal) {

if (this.entrada_selected) {
  // Si ya hay una entrada seleccionada, calcular la diferencia
  this.calcularDiferencia(this.entrada_selected, this.salida_selected);
}
},
mostrarHoraExtra(newVal) {
if (!newVal) {
  this.hora_extra_sn = false; 
}
},
mostrarSDFCheckbox(newVal) {
if (!newVal) {
  this.sdf_sn = false; 
}
},
},
  methods: {
    abrirObservacionModal(index) {
      this.observacionIndex = index;
      this.observacionTexto = this.detalles[index].observaciones || ''; // Cargar la observación si existe
      $('#observacionModal').modal('show'); // Mostrar el modal (usando jQuery)
    },
    calcularHorasExtrasDetall(detalle, index) {
  const entrada = detalle.entrada;
  const salida = detalle.salida;
  const horasLaborales = this.frente_selected.horas_diarias_laborables; // Dará valores como 8.0

  console.log('entro en calcularHorasExtrasDetall');

  if (entrada && salida) {
    // Convertimos entrada y salida a arrays de horas y minutos
    const [entradaHoras, entradaMinutos] = entrada.split(':').map(Number);
    const [salidaHoras, salidaMinutos] = salida.split(':').map(Number);

    // Creamos objetos Date para entrada y salida
    const entradaDate = new Date();
    entradaDate.setHours(entradaHoras, entradaMinutos, 0, 0);

    const salidaDate = new Date();
    salidaDate.setHours(salidaHoras, salidaMinutos, 0, 0);

    // Calculamos la diferencia total en minutos entre entrada y salida
    const diferenciaMinutos = (salidaDate - entradaDate) / (1000 * 60); // Diferencia en minutos totales

    // Calculamos las horas y minutos trabajados
    const horasTrabajadas = Math.floor(diferenciaMinutos / 60); // Horas completas trabajadas
    const minutosTrabajados = diferenciaMinutos % 60; // Minutos restantes

    // Convertimos las horas laborales estándar a minutos
    const minutosLaboralesTotales = horasLaborales * 60; // Por ejemplo, 8.0 horas * 60 = 480 minutos

    // Calculamos los minutos trabajados totales
    const minutosTrabajadosTotales = (horasTrabajadas * 60) + minutosTrabajados;

    console.log(minutosTrabajadosTotales, minutosLaboralesTotales);

    // Comparamos los minutos trabajados con los minutos laborales
    if (minutosTrabajadosTotales > minutosLaboralesTotales) {
      detalle.hora_extra_sn = true; // Marca el checkbox de horas extras
    } else {
      detalle.hora_extra_sn = false; // Desmarca el checkbox
    }

  } else {
    // Si faltan datos de entrada o salida, desmarcamos las horas extras
    detalle.hora_extra_sn = false;
  }
},
async guardarObservacion() {
    if (this.observacionIndex !== null) {
        // Actualiza el estado local
        this.$set(this.detalles[this.observacionIndex], 'observaciones', this.observacionTexto);

        // Obtenemos el ID de la asistencia y el ID del operador
        const asistenciaId = this.asistenciaId;  // Este debe ser pasado o definido previamente en el componente
        const operadorId = this.detalles[this.observacionIndex].operador.id;

        console.log(asistenciaId);
        console.log(operadorId);
        // Crear un objeto con los datos necesarios
        const detalleData = {
    operador_id: operadorId,
    ayudante_sn: this.detalles[this.observacionIndex].ayudante_sn,  // Se asume que ya es un valor adecuado (true/false o 1/0)
    entrada: this.detalles[this.observacionIndex].entrada || '',   // Si `entrada` es null o undefined, se asigna un string vacío
    salida: this.detalles[this.observacionIndex].salida || '',     // Si `salida` es null o undefined, se asigna un string vacío
    contratista_id: this.detalles[this.observacionIndex].contratista ? this.detalles[this.observacionIndex].contratista.id : null,  // Asigna null si contratista es null
    parte: this.detalles[this.observacionIndex].parte || null,     // Asigna null si `parte` es null o undefined
    observaciones: this.observacionTexto,                          // Observación que se va a guardar
    hora_extra_sn: this.detalles[this.observacionIndex].hora_extra_sn ? 1 : 0,  // Si `hora_extra_sn` es true, asigna 1, si no, 0
    s_d_f_sn: this.detalles[this.observacionIndex].s_d_f_sn ? 1 : 0  // Si `s_d_f_sn` es true, asigna 1, si no, 0
};

        try {
            // Hacer la solicitud PATCH para buscar o crear el detalle
            await axios.patch(`/api/asistencia-detalle/${asistenciaId}/guardar-observacion`, detalleData);

            // Mostrar un mensaje de éxito
            toastr.success('Observación actualizada con éxito!');

        } catch (error) {
            // Manejo de errores
            toastr.error('Error al guardar la observación');
        }

        // Ocultar el modal después de guardar
        $('#observacionModal').modal('hide');
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
        if (detalle.contratista && detalle.parte) {
          const parteValido = await this.verificarParte(detalle.parte);
          if (!parteValido) {
            toastr.error(`Parte "${detalle.parte}" del operador "${detalle.operador.name}" es inválido`);
            return false; // Detener si algún parte no es válido
          }
        } else if (detalle.contratista && !detalle.parte) {
          toastr.error(`Parte requerido para el operador "${detalle.operador.name}"`);
          return false; // Detener si falta algún parte
        }
      }
      return true; // Todos los partes son válidos
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
      console.error(`Parte "${this.parte_selected}" inexistente`);
      return; // Si el parte no es válido, detenemos la ejecución
    }
  }
  if(!this.mostrarSDFCheckboxCol){
      this.sdf_sn = false;
    }

    // Calcular los valores para nuevoDetalle
    const nuevoDetalle = {
      operador: this.operador_selected,
      entrada: moment(this.entrada_selected).format('HH:mm'),
      salida: moment(this.salida_selected).format('HH:mm'),
      contratista: this.contratista_selected,
      parte: this.parte_selected,
      ayudante_sn: this.operador_selected.habilitado_arn_sn,
      hora_extra_sn: this.hora_extra_sn ? 1 : 0, // Convertir true/false a 1/0
      s_d_f_sn: this.sdf_sn ? 1 : 0, // Convertir true/false a 1/0
      observacion : this.observaciones || '',
      metodo_ensayo: this.metodoEnsayo_selected,
    };

    // Agregar nuevoDetalle a la lista de detalles
    this.detalles.push(nuevoDetalle);
    this.operador_selected = '';
    this.entrada_selected = moment('08:00', 'HH:mm').toDate();
    this.salida_selected = moment('16:00', 'HH:mm').toDate();
    this.contratista_selected = '';
    this.parte_selected = '';
    this.metodoEnsayo_selected = '',
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
    window.location.href = '/area/enod/asistencia';
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