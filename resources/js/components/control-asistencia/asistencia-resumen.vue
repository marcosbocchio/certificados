@ -1,417 +1,431 @@
<template>
  <div>
    <loading :active.sync="isLoading" :is-full-page="true" :loader="'bars'" :color="'red'"></loading>
    
    <!-- Filtros de Fecha y Días Hábiles -->
    <div class="box box-custom-enod top-buffer">
      <div class="box-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="frente">Frente:</label>
              <v-select v-model="frente_selected" :options="frentes_opciones" label="codigo" id="frente" clearable></v-select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="month">Mes y Año:</label>
              <date-picker v-model="selectedDate" type="month" format="MM-YYYY" @input="fetchAsistencia" class="date-picker-custom" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="diasHabiles">Días Hábiles del Mes:</label>
              <input type="text" v-model="diasHabiles" disabled class="form-control"/>
            </div>
          </div>
        </div>
      </div>
    </div>
  
    <!-- Tabla de Asistencia -->
    <div class="box box-custom-enod top-buffer">
      <button @click="exportarTodoPDF" class="exportar-todo-pdf" :disabled="!selectedDate">Exportar PDF</button>
      <div class="box-body table-responsive">
        <table class="table table-hover table-striped table-condensed">
          <thead>
            <tr>
              <th style="width: 76px;">Pagos Mensual</th>
              <th style="width: 130px;">Operador</th>
              <th style="width: 100px;">Responsabilidad</th>
              <th style="width: 76px;">Días Hábiles</th>
              <th style="width: 28px;">Sab.</th>
              <th style="width: 28px;">Dom.</th>
              <th style="width: 57px;">Feriados</th>
              <th style="width: 77px;">Horas Extras</th>
              <th style="width: 115px;">Servicios Extras S1</th>
              <th style="width: 48px;">Pago S1</th>
              <th style="width: 115px;">Servicios Extras S2</th>
              <th style="width: 48px;">Pago S2</th>
              <th style="width: 115px;">Servicios Extras S3</th>
              <th style="width: 48px;">Pago S3</th>
              <th style="width: 115px;">Servicios Extras S4</th>
              <th style="width: 48px;">Pago S4</th>
              <th style="width: 115px;">Servicios Extras S5</th>
              <th style="width: 48px;">Pago S5</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="operador in operarios" :key="operador.operador.id">
              <td>
                <div class="checkbox-container">
                  <input type="checkbox" v-model="operador.pagosExtMensual" 
                         @change="openPopup(operador, 'Pago Mes')" 
                         :disabled="operador.precargadoPagosExtMensual" />
                  <div class="date-tooltip" v-if="operador.fecha_pago_mes">
                    {{ operador.fecha_pago_mes }}
                  </div>
                </div>
              </td>
              <td :class="{ 'neuquen-highlight': frente_selected.id === 2 && operador.operador.local_neuquen_sn === 1 }">
                <a @click.prevent="pdfusuario(operador.operador.id)" :style="{ cursor: 'pointer'}">
                  {{ operador.operador.name }}
                </a>
              </td>
              <td>{{ operador.responsabilidad }}</td>
              <td v-if="frente_selected.id === 2">-</td>
              <td v-else>{{ operador.diasHabiles }}</td>
              <td v-if="frente_selected.id === 2 && operador.operador.local_neuquen_sn === 0">-</td>
              <td v-else>{{ operador.sabados }}</td>
              <td v-if="frente_selected.id === 2 && operador.operador.local_neuquen_sn === 0">-</td>
              <td v-else>{{ operador.domingos }}</td>
              <td v-if="frente_selected.id === 2 && operador.operador.local_neuquen_sn === 0">-</td>
              <td v-else>{{ operador.feriados }}</td>
              <td v-if="frente_selected.id === 2">-</td>
              <td v-else>{{ formatToTwoDecimals(operador.horasExtras) }}</td>
              <td>{{ operador.serviciosExtrasS1 }}</td>
              <td>
                <div class="checkbox-container">
                  <input type="checkbox" v-model="operador.pagoS1" @change="openPopup(operador, 'Pago S1')" :disabled="operador.precargadoPagoS1" />
                  <div class="date-tooltip" v-if="operador.fecha_pago_s1">
                    {{ operador.fecha_pago_s1 }}
                  </div>
                </div>
              </td>
              <td>{{ operador.serviciosExtrasS2 }}</td>
              <td>
                <div class="checkbox-container">
                  <input type="checkbox" v-model="operador.pagoS2" @change="openPopup(operador, 'Pago S2')" :disabled="operador.precargadoPagoS2" />
                  <div class="date-tooltip" v-if="operador.fecha_pago_s2">
                    {{ operador.fecha_pago_s2 }}
                  </div>
                </div>
              </td>
              <td>{{ operador.serviciosExtrasS3 }}</td>
              <td>
                <div class="checkbox-container">
                  <input type="checkbox" v-model="operador.pagoS3" @change="openPopup(operador, 'Pago S3')" :disabled="operador.precargadoPagoS3" />
                  <div class="date-tooltip" v-if="operador.fecha_pago_s3">
                    {{ operador.fecha_pago_s3 }}
                  </div>
                </div>
              </td>
              <td>{{ operador.serviciosExtrasS4 }}</td>
              <td>
                <div class="checkbox-container">
                  <input type="checkbox" v-model="operador.pagoS4" @change="openPopup(operador, 'Pago S4')" :disabled="operador.precargadoPagoS4" />
                  <div class="date-tooltip" v-if="operador.fecha_pago_s4">
                    {{ operador.fecha_pago_s4 }}
                  </div>
                </div>
              </td>
              <td>{{ operador.serviciosExtrasS5 }}</td>
              <td>
                <div class="checkbox-container">
                  <input type="checkbox" v-model="operador.pagoS5" @change="openPopup(operador, 'Pago S5')" :disabled="operador.precargadoPagoS5" />
                  <div class="date-tooltip" v-if="operador.fecha_pago_s5">
                    {{ operador.fecha_pago_s5 }}
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pop-up de Selección de Fecha -->
      <div v-if="mostrarPopup" class="modal show" tabindex="-1" role="dialog" style="display: block;">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Seleccionar Fecha de {{ tipoPagoSeleccionado }}</h4>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="fecha-select">Fecha</label>
                <date-picker v-model="fechaSeleccionada" value-type="YYYY-MM-DD" format="DD-MM-YYYY" placeholder="DD-MM-YYYY"></date-picker>
              </div>
            </div>
            <div class="modal-footer row">
              <div class="col-md-4" style="text-align: left;">
                <button type="button" class="btn btn-enod" @click="confirmarFecha">Confirmar</button>
              </div>
              <div class="col-md-4">
                <!-- Espacio vacío entre los botones -->
              </div>
              <div class="col-md-4">
                <button type="button" class="btn btn-secondary" @click="cerrarPopup">Cancelar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Pop-up de Selección de Fecha -->
    </div>
    <button @click="guardarPagos" class="btn btn-primary">Guardar</button>
  </div>
  </template>

<script>
import axios from 'axios';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

export default {
components: {
  Loading,
  DatePicker
},
props: {
  frentes_opciones: {
    type: Array,
    required: true
  },
},
data() {
  return {
      frente_selected: null,
      selectedDate: null,
      diasHabiles: '',
      operarios: [],
      isLoading: false,
      mostrarPopup: false,
      operadorSeleccionado: null,
      fechaSeleccionada: null,
      tipoPagoSeleccionado: null
    };
  },
watch: {
  frente_selected(newVal) {
    if (newVal) {
      this.fetchAsistencia();
    }
  },
  selectedDate(newVal) {
    if (newVal) {
      this.fetchAsistencia();
    }
  }
},
methods: {
  formatToTwoDecimals(value) {
      if (Number.isInteger(value)) {
        return value; // Retorna el valor tal cual si es un entero
      } else {
        return parseFloat(value).toFixed(2); // Formatea a 2 decimales si no es un entero
      }
    },
  async fetchAsistencia() {
    if (!this.selectedDate || !this.frente_selected) return;

  const { year, month } = this.formatDateToMonthYear(this.selectedDate);
  this.isLoading = true;

  try {
    const diasDelMesResponse = await axios.get(`/api/calcular-dias-del-mes/${year}/${month}`);
    this.diasHabiles = diasDelMesResponse.data.diasHabiles;

    const response = await axios.get('/api/asistencia-operadores', {
      params: {
        year,
        month,
        frent_id: this.frente_selected.id
      }
    });
    console.log(response.data.asistencias);
    this.operarios = response.data.asistencias.map(operador => ({
        operador: operador.operador,
        responsabilidad: operador.ayudante_sn,
        diasHabiles: operador.diasHabiles,
        sabados: operador.sabados,
        domingos: operador.domingos,
        feriados: operador.feriados,
        horasExtras: operador.horasExtras,
        serviciosExtrasS1: operador.serviciosExtrasS1,
        serviciosExtrasS2: operador.serviciosExtrasS2,
        serviciosExtrasS3: operador.serviciosExtrasS3,
        serviciosExtrasS4: operador.serviciosExtrasS4,
        serviciosExtrasS5: operador.serviciosExtrasS5,
        fecha_pago_s1: this.formatDate(operador.fecha_pago_s1),
        fecha_pago_s2: this.formatDate(operador.fecha_pago_s2),
        fecha_pago_s3: this.formatDate(operador.fecha_pago_s3),
        fecha_pago_s4: this.formatDate(operador.fecha_pago_s4),
        fecha_pago_s5: this.formatDate(operador.fecha_pago_s5),
        fecha_pago_mes: this.formatDate(operador.fecha_pago_mes),
        pagoS1: operador.pagoS1 || false,
        pagoS2: operador.pagoS2 || false,
        pagoS3: operador.pagoS3 || false,
        pagoS4: operador.pagoS4 || false,
        pagoS5: operador.pagoS5 || false,
        pagosExtMensual: operador.pagosExtMensual || false,
        precargadoPagoS1: operador.pagoS1 || false,
        precargadoPagoS2: operador.pagoS2 || false,
        precargadoPagoS3: operador.pagoS3 || false,
        precargadoPagoS4: operador.pagoS4 || false,
        precargadoPagoS5: operador.pagoS5 || false,
        precargadoPagosExtMensual: operador.pagosExtMensual || false
      }));
  } catch (error) {
    console.error(error);
    this.operarios = {};
  
  } finally {
    this.isLoading = false;
  }
  },
  openPopup(operador, tipoPago) {
      this.operadorSeleccionado = operador;
      this.tipoPagoSeleccionado = tipoPago;
      this.fechaSeleccionada = null;
      this.mostrarPopup = true;
    },

    cerrarPopup() {
      this.mostrarPopup = false;
      this.operadorSeleccionado = null;
      this.tipoPagoSeleccionado = null;
      this.fechaSeleccionada = null;
    },
    formatDate(dateString) {
      if (!dateString) {
      return ''; // O el mensaje que desees, como 'Fecha no disponible'
    }
      // Crear un objeto Date a partir de la cadena de fecha
      const date = new Date(dateString);

      // Obtener el año, mes y día
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, '0'); // Mes es 0-indexado, por lo que se suma 1
      const day = String(date.getDate()).padStart(2, '0');

      // Devolver la fecha formateada
      return `${year}-${month}-${day}`;
    },
    confirmarFecha() {
      if (!this.operadorSeleccionado || !this.tipoPagoSeleccionado || !this.fechaSeleccionada) return;

      switch (this.tipoPagoSeleccionado) {
        case 'Pago Mes':
          this.operadorSeleccionado.fecha_pago_mes = this.fechaSeleccionada;
          break;
        case 'Pago S1':
          this.operadorSeleccionado.fecha_pago_s1 = this.fechaSeleccionada;
          break;
        case 'Pago S2':
          this.operadorSeleccionado.fecha_pago_s2 = this.fechaSeleccionada;
          break;
        case 'Pago S3':
          this.operadorSeleccionado.fecha_pago_s3 = this.fechaSeleccionada;
          break;
        case 'Pago S4':
          this.operadorSeleccionado.fecha_pago_s4 = this.fechaSeleccionada;
          break;
        case 'Pago S5':
          this.operadorSeleccionado.fecha_pago_s5 = this.fechaSeleccionada;
          break;
      }

      this.cerrarPopup();
    },
  async guardarPagos() {
    // Verificar si al menos un checkbox está seleccionado
    const operariosSeleccionados = this.operarios.filter(operador => 
      operador.pagoS1 || operador.pagoS2 || operador.pagoS3 || operador.pagoS4 || operador.pagoS5 || operador.pagosExtMensual
    );

    if (operariosSeleccionados.length === 0) {
      toastr.error('Por favor, seleccione al menos un pago antes de guardar.');
      return;
    }
    
    this.isLoading = true;
    try {
      const fechaFormateada = this.selectedDate.toISOString().substr(0, 7); // Formato YYYY-MM

      await axios.post('/api/guardar-pagos', {
        frente_id: this.frente_selected.id,
        selectedMonthYear: fechaFormateada,
        operarios: operariosSeleccionados,
      });
      
      toastr.success('Pagos guardados con éxito');
    } catch (error) {
      toastr.error('Error al guardar los pagos');
    } finally {
      this.isLoading = false;
    }
  },
  formatDateToMonthYear(date) {
    const year = date.getFullYear();
    const month = date.getMonth() + 1;
    return {
      year: year.toString(),
      month: month < 10 ? '0' + month : month.toString()
    };
  },
  exportarTodoPDF() {
    const { year, month } = this.formatDateToMonthYear(this.selectedDate);
    const frent_id = this.frente_selected.id;

    const url = `/area/enod/asistencia-pdf?year=${year}&month=${month}&frent_id=${frent_id}`;

    // Abre la URL en una nueva ventana
    window.open(url, '_blank');
  },
  pdfusuario(operadorId) {
        // Construir la URL con los parámetros
        const url = `/area/enod/asistencia-pdf-user/${operadorId}/${this.frente_selected.id}/${this.selectedDate}`;

        // Abrir el PDF en una nueva pestaña
        window.open(url, '_blank');
    }
}
};
</script>

<style scoped>
.table-responsive {
  overflow-x: auto;
}

.table thead th,
.table tbody td {
  text-align: center; /* Centrar el texto */
  white-space: nowrap;
}

.table tbody td input[type="checkbox"] {
  margin: 0 auto; /* Centrar los checkboxes */
  display: block;
}

.checkbox-container {
  position: relative;
  display: inline-block;
}

.date-tooltip {
  visibility: hidden;
  width: 120px;
  background-color: #333;
  color: #fff;
  text-align: center;
  border-radius: 5px;
  padding: 5px;
  position: absolute;
  z-index: 1;
  bottom: 125%; /* Sitúa el tooltip arriba del checkbox */
  left: 50%;
  margin-left: -60px; /* Centra el tooltip */
  opacity: 0;
  transition: opacity 0.3s;
}

.checkbox-container:hover .date-tooltip {
  visibility: visible;
  opacity: 1;
}

.box.box-custom-enod {
  padding: 20px;
}

.modal.show {
  display: block;
  z-index: 1050;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 5px;
}
</style>
