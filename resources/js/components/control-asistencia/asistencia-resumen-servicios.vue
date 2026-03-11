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
              <date-picker v-model="selectedDate" type="month" format="MM-YYYY" @input="getDatos" class="date-picker-custom" />
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
      <div class="box-header">
        <button @click="exportarTodoPDF()">Exportar PDF</button>
      </div>
      <div class="box-body table-responsive">
        <table class="table table-hover table-striped table-condensed">
          <thead>
            <tr>
              <th style="text-align: left;">Operador</th>
              <th style="text-align: left;">Responsabilidad</th>
              <th v-for="dia in diasDelMes" :key="dia.dia" 
                  :class="{
                    'domingo': dia.domingo_sn,
                    'sabado': dia.sabado_sn,
                    'feriado': dia.feriado_sn,
                    'dia-semana': dia.dia_semana_sn
                  }">
                {{ dia.dia }}
              </th>
              <th>SE</th>
            </tr>
          </thead>
          <tbody>
            <!-- Se itera sobre cada operador. 'operador' es la clave del objeto y 'detalle' sus datos -->
            <tr v-for="(detalle, operador) in asistenciaDatos" :key="operador">
              <!-- Columna del operador -->
              <td style="text-align: left;">
                <a href="#" @click.prevent="pdfusuario(detalle.operador_id)">
                  {{ detalle.name }}
                </a>
              </td>
              <!-- Columna de Responsabilidad -->
              <td style="text-align: left;">
                <span>
                  {{ detalle.ayudante_sn === 1 ? 'Operador' : 'Ayudante' }}
                </span>
              </td>
              <!-- Para cada día se muestra el/los detalles -->
              <td v-for="(dia, index) in detalle.dias" :key="index">
                <div v-if="dia && dia.detalles && dia.detalles.length">
                  {{ getDistinctParts(dia.detalles) }}
                </div>
                <div v-else>
                  -
                </div>
              </td>
              <!-- Columna para el conteo de detalles por fila (día) -->
              <td>
                {{ contarContratistasPorFila(detalle.dias) }}
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
      tipoPagoSeleccionado: null,
      diasDelMes: [],
      asistenciaDatos: {},
      feriados: []
    };
  },
  watch: {
    frente_selected(newVal) {
      if (newVal) {
        this.getDatos();
      } else {
        this.asistenciaDatos = {};
      }
    },
    selectedDate(newVal) {
      if (newVal) {
        this.getDatos();
      } else {
        this.asistenciaDatos = {};
      }
    }
  },
  methods: {
    // Método para formatear el día como fecha (YYYY-MM-DD)
    formatearDia(dia) {
      const year = new Date().getFullYear();
      const month = new Date().getMonth() + 1;
      return `${year}-${String(month).padStart(2, '0')}-${String(dia).padStart(2, '0')}`;
    },
    async getDiasDelMes(year, month) {
      await this.obtenerFeriados();
      const numDias = new Date(year, month, 0).getDate();
      let diasHabiles = 0;
      const diasDelMes = Array.from({ length: numDias }, (_, i) => {
        const dia = i + 1;
        const fecha = new Date(year, month - 1, dia);
        const diaSemana = fecha.getDay(); // 0 = domingo, ... 6 = sábado
        const esFeriado = this.esFeriado(fecha);
        const diaSemanaSN = esFeriado ? 0 : (diaSemana >= 1 && diaSemana <= 5 ? 1 : 0);
        diasHabiles += diaSemanaSN;
        return {
          dia, // Número del día
          dia_semana_sn: diaSemanaSN,
          sabado_sn: diaSemana === 6 ? 1 : 0,
          domingo_sn: diaSemana === 0 ? 1 : 0,
          feriado_sn: esFeriado ? 1 : 0
        };
      });
      this.diasHabiles = diasHabiles;
      console.log('Datos del mes:', diasDelMes);
      console.log('Total de días hábiles:', this.diasHabiles);
      this.diasDelMes = diasDelMes;
      return diasDelMes;
    },
    esFeriado(fecha) {
      const dia = fecha.getDate();
      const mes = fecha.getMonth() + 1;
      const anio = fecha.getFullYear();
      const fechaFormateada = `${anio}-${('0' + mes).slice(-2)}-${('0' + dia).slice(-2)}`;
      return this.feriados.includes(fechaFormateada);
    },
    async obtenerFeriados() {
      const year = new Date(this.selectedDate).getFullYear();
      try {
        const response = await axios.get(`/api/asistencia/getferiados/${year}`);
        this.feriados = response.data;
      } catch (error) {
        console.error("Error al obtener los feriados:", error);
        this.feriados = [];
      }
    },
    async getDatos() {
      if (!this.selectedDate) {
        console.log("Por favor, seleccione un mes y año antes de continuar.");
        this.asistenciaDatos = {};
        this.isLoading = false;
        return;
      }
      this.isLoading = true;
      const formattedDate = this.selectedDate.getFullYear() + '-' + ('0' + (this.selectedDate.getMonth() + 1)).slice(-2);
      try {
        const diasDelMes = await this.getDiasDelMes(this.selectedDate.getFullYear(), this.selectedDate.getMonth() + 1);
        console.log("Días del mes:", diasDelMes);
        const response = await axios.get('/api/asistencia-operadores-datos-servicios', {
          params: {
            frente_id: this.frente_selected.id,
            fecha: formattedDate
          }
        });
        console.log("Respuesta de la API:", response.data);
        let asistenciaReorganizada = {};
        // Para cada operador en la respuesta:
        for (let operador in response.data) {
          // Convertir el objeto con claves numéricas en un array y filtrar posibles objetos vacíos
          let detallesOperador = Object.values(response.data[operador]).filter(item => Object.keys(item).length > 0);
          if (detallesOperador.length === 0) continue;
          const operadorData = detallesOperador[0];
          const ayudante_sn = operadorData.ayudante_sn || null;
          const operador_id = operadorData.ot_id || null;
          const name = operadorData.name || null;
          // Para cada día del mes, se agrupan los detalles cuyo 'fechaAsignacion' coincida
          let diasArray = diasDelMes.map(dia => {
            let fechaDelDia = `${formattedDate}-${('0' + dia.dia).slice(-2)}`;
            let detallesDelDia = detallesOperador.filter(item => item.fechaAsignacion === fechaDelDia);
            if (detallesDelDia.length > 0) {
              // Se mantiene la lógica de conteo y agrupado
              let uniquePartes = [...new Set(detallesDelDia.map(item => item.detalle.parte))];
              let detallesToDisplay = (uniquePartes.length === 1) ? [detallesDelDia[0]] : detallesDelDia;
              return {
                detalles: detallesToDisplay,
                count: detallesDelDia.length, // Cantidad total de detalles en ese día
                parametros: {
                  dia_semana_sn: dia.dia_semana_sn,
                  sabado_sn: dia.sabado_sn,
                  domingo_sn: dia.domingo_sn,
                  feriado_sn: dia.feriado_sn
                }
              };
            } else {
              return null;
            }
          });
          asistenciaReorganizada[operador] = {
            ayudante_sn: ayudante_sn,
            operador_id: operador_id,
            name: name,
            dias: diasArray
          };
        }
        // Ordenar los operadores alfabéticamente (según las claves del objeto)
        const operadoresOrdenados = Object.keys(asistenciaReorganizada).sort();
        let asistenciaReorganizadaOrdenada = {};
        operadoresOrdenados.forEach(op => {
          asistenciaReorganizadaOrdenada[op] = asistenciaReorganizada[op];
        });
        console.log("Datos reorganizados por operador (ordenados):", asistenciaReorganizadaOrdenada);
        this.asistenciaDatos = asistenciaReorganizadaOrdenada;
        this.diasDelMes = diasDelMes;
      } catch (error) {
        console.error("Error al llamar a la API:", error);
        this.asistenciaDatos = {};
      } finally {
        this.isLoading = false;
      }
    },
    // Se suma el total de detalles en cada día, usando la propiedad 'count'
    contarContratistasPorFila(dias) {
      return dias.reduce((total, dia) => {
        return total + (dia ? dia.count : 0);
      }, 0);
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
      const modo = 'Servicios';
      const url = `/area/enod/asistencia-pdf?year=${year}&month=${month}&frent_id=${frent_id}&modo=${modo}`;
      window.open(url, '_blank');
    },
    pdfusuario(operadorId) {
      console.log(operadorId);
      const url = `/area/enod/asistencia-pdf-user/${operadorId}/${this.frente_selected.id}/${this.selectedDate}`;
      window.open(url, '_blank');
    },
    // Método para obtener las partes únicas y unirlas con " | "
    getDistinctParts(detalles) {
      const partsSet = new Set();
      detalles.forEach(item => {
        const parte = item.detalle.parte;
        if (parte) {
          partsSet.add(parte);
        }
      });
      const partsArray = Array.from(partsSet);
      return partsArray.length ? partsArray.join(' | ') : '-';
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
.neuquen-highlight {
  background-color: #000000;
}
.neuquen-highlight a{
  color: rgb(255, 204, 0);
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

.domingo {
  background-color: #FFEB99; /* Color para domingos */
}

.sabado {
  background-color: #FFCC99; /* Color para sábados */
}

.feriado {
  background-color: #FF6666; /* Color para feriados */
}

.dia-semana {
  background-color: #6BB5D9; /* Color para días de semana */
}
</style>
