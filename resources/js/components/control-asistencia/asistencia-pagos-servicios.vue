<template>
  <div>
    <!-- Box: Frente y Mes -->
    <div class="box box-custom-enod">
      <div class="box-body row">
        <div class="col-md-3">
          <div class="form-group">
            <label for="frente">Frente *</label>
            <v-select 
              v-model="frente_selected" 
              :options="frentes" 
              label="codigo" 
              id="frente" 
              @change="fetchAsistencia"
            ></v-select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="fecha">Mes *</label>
            <date-picker 
              id="fecha" 
              v-model="fecha" 
              type="month"  
              value-type="YYYY-MM"  
              format="MM-YYYY"  
              @change="fetchAsistencia"
            ></date-picker>
          </div>
        </div>
        <div class="col-md-4">

        </div>
        <div class="col-md-2" style="margin-top: 20px;">
          <button class="btn btn-enod" @click="exportExcel">Exportar Excel</button>
        </div>
      </div>
    </div>



    <!-- Loading Overlay -->
    <vue-loading-overlay
      :active="isLoading"
      :is-full-page="true"
      :opacity="0.5"
      :background="'#ffffff'"
      color="#007bff"
      :spinner="true"
      :text="'Cargando...'"
    ></vue-loading-overlay>

    <!-- Tabla de datos -->
    <div class="box box-custom-enod">
      <div class="box-body">




        <div class="table-responsive">
          <table class="table table-hover table-striped table-condensed table-bordered">
            <thead>
              <tr>
                <th class="text-center">Frente</th>
                <th class="text-center">Fecha</th>
                <th class="text-center">Operador</th>
                <th class="text-center">Ayudante</th>
                <th class="text-center">Técnica</th>
                <th class="text-center">Cliente</th>
                <th class="text-center">Parte</th>
                <th class="text-center">
                  Pagar 
                  <input 
                    type="checkbox" 
                    v-model="selectAll" 
                    @change="toggleSelectAll"
                  />
                </th>
                <th class="text-center">No Pagar</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="detalle in asistencia" :key="detalle.id">
                <td class="text-center">{{ detalle.frente?.codigo }}</td>
                <td class="text-center">{{ detalle.fecha_asistencia }}</td>
                <td class="text-center">{{ detalle.operador?.name || '-' }}</td>
                <td class="text-center">{{ detalle.ayudante?.name || '-' }}</td>
                <td class="text-center">{{ detalle.metodoEnsayo?.metodo || '-' }}</td>
                <td class="text-center">{{ detalle.contratista?.nombre_fantasia || '-' }}</td>
                <td class="text-center">{{ detalle.parte }}</td>
                <td class="text-center">
                  <input 
                    type="checkbox" 
                    v-model="detalle.selected"
                    @change="handleSelectionChange(detalle)" 
                  />
                </td>
                <td class="text-center">
                  <input 
                    type="checkbox" 
                    v-model="detalle.no_pagar"
                    @change="handleNoPagarChange(detalle)" 
                  />
                </td>
              </tr>
            </tbody>
          </table>
          <button @click="mostrarPopup = true" class="btn btn-primary">Pagar</button>

          <!-- Pop-up de Selección de Fecha -->
          <div v-if="mostrarPopup" class="modal show" tabindex="-1" role="dialog" style="display: block;">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Seleccionar Fecha de Pago</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="fecha-select">Fecha</label>
                    <date-picker
                      v-model="fechaSeleccionada"
                      value-type="YYYY-MM-DD"
                      format="DD-MM-YYYY"
                      placeholder="Seleccionar fecha">
                    </date-picker>
                  </div>
                </div>
                <div class="modal-footer row">
                  <div class="col-md-4" style="text-align: left;">
                    <button type="button" class="btn btn-secondary" @click="cerrarPopup">Cerrar</button>
                  </div>
                  <div class="col-md-4">
                    <!-- Espacio vacío entre los botones -->
                  </div>
                  <div class="col-md-4">
                    <button type="button" class="btn btn-enod" @click="guardarPagosExtras">Confirmar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Loading Overlay -->
    <loading
      :active.sync="isLoading"
      :loader="'bars'"
      :color="'red'"
    ></loading>
  </div>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import axios from 'axios';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import { toastrInfo, toastrDefault } from '../toastrConfig';
// Se importa la librería XLSX para generar el Excel
import * as XLSX from 'xlsx';

export default {
  components: {
    DatePicker,
    Loading
  },
  props: {
    frentes: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      frente_selected: null,
      fecha: '',
      asistencia: [],
      mostrarPopup: false,  // Estado del modal
      fechaSeleccionada: '',
      selectAll: false,  
      isLoading: false  
    };
  },
  mounted() {
    this.fetchAsistencia();
  },
  watch: {
    fecha(newFecha) {
      const year = new Date(newFecha).getFullYear();
      this.obtenerFeriados(year); // Volver a obtener feriados con el nuevo año
      this.fetchAsistencia(); // Refrescar los datos de asistencia
    },
    frente_selected: 'fetchAsistencia' // Refrescar asistencia si cambia el frente
  },
  methods: {
    async fetchAsistencia() {
      this.isLoading = true; // Activar el loading
      try {
        const response = await axios.get('/api/asistencia_pagos_servicios', {
          params: {
            frente_id: this.frente_selected?.id || null,
            fecha: this.fecha || null
          }
        });

        // Asignar los datos recibidos y asegurarse de que cada 'detalle' tenga 'selected'
        this.asistencia = response.data.map(detalle => ({
          ...detalle,
          selected: false,  // Inicializa 'selected' en false
          no_pagar: false   // Inicializa 'no_pagar' en false
        }));
        console.log(this.asistencia);
        // Ordena los resultados
        this.asistencia.sort((a, b) => {
          const codigoA = a.frente.codigo.toLowerCase();
          const codigoB = b.frente.codigo.toLowerCase();
          if (codigoA < codigoB) return -1;
          if (codigoA > codigoB) return 1;

          const fechaA = new Date(a.fecha_asistencia);
          const fechaB = new Date(b.fecha_asistencia);
          return fechaA - fechaB;  // Ordenar por fecha de más reciente a más antiguo
        });
      } catch (error) {
        console.error('Error al obtener la asistencia:', error);
      } finally {
        this.isLoading = false;
      }
    },
    cerrarPopup() {
      this.mostrarPopup = false; // Cerrar popup sin confirmar
    },
    guardarPagosExtras() {
      // Log para verificar la estructura de los datos
      console.log("asistencia", this.asistencia.filter(operador => operador.selected || operador.no_pagar));

      // Crear los datos de pagos sin utilizar detalles, usando directamente la propiedad 'selected' y 'no_pagar'
      const datosPagos = this.asistencia
        .filter(operador => operador.selected || operador.no_pagar)  // Solo operadores seleccionados o con 'no_pagar'
        .map(operador => ({
          asistencia_horas_id: operador.asistencia_horas_id,  // Usamos 'id_asistencia' directamente del operador
          operador_id: operador.operador.id,  // 'operador' parece tener una propiedad 'id'
          pago_servicio_extra: operador.no_pagar ? null : this.fechaSeleccionada,  // Si no es para pagar, se deja null
          no_pagar: operador.no_pagar ? 1 : 0  // Pasamos el estado de no pagar
        }));

      // Realiza una llamada a la API para guardar los pagos
      axios.post('/api/guardar_pagos_servicios', { datosPagos })
        .then(response => {
          if (response.data.success) {
            // Muestra un mensaje de éxito
            toastr.success('Pagos guardados exitosamente');

            // Llama a fetchAsistencia() para actualizar los datos
            this.fetchAsistencia();

            // Cerrar el popup después de guardar
            this.mostrarPopup = false;
          } else {
            // Muestra un mensaje de error si la respuesta no es exitosa
            toastr.error('Error en los pagos');
          }
        })
        .catch(error => {
          // Muestra un mensaje de error en caso de falla en la llamada a la API
          console.error('Error al guardar los pagos:', error);
          toastr.error('Error al guardar los pagos: ' + error.message);
        });
    },
    // Método para exportar a Excel usando los datos de asistencia
    exportExcel() {
      // Se arma la data del excel: primer fila de cabecera y luego las filas con los datos
      const data = [];
      // Cabecera
      data.push(['Frente', 'Fecha', 'Operador', 'Ayudante', 'Tecnica', 'Clientes', 'Parte']);
      // Recorrer cada registro de asistencia
      this.asistencia.forEach(item => {
        data.push([
          item.frente?.codigo || '',
          item.fecha_asistencia || '',
          item.operador?.name || '',
          item.ayudante?.name || '',
          item.metodoEnsayo?.metodo || '',
          item.contratista?.nombre_fantasia || '',
          item.parte || ''
        ]);
      });
      // Crear la hoja y el libro de Excel
      const worksheet = XLSX.utils.aoa_to_sheet(data);
      const workbook = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(workbook, worksheet, 'Asistencia');
      // Guardar el archivo con el nombre "asistencia.xlsx"
      XLSX.writeFile(workbook, 'asistencia.xlsx');
    },
    // Manejar cambio en el checkbox "Pagar"
    handleSelectionChange(detalle) {
      if (detalle.selected) {
        detalle.no_pagar = false; // Desmarcar "No Pagar" si se selecciona
      }
      this.updateSelectAllStatus();  // Actualiza el estado de "selectAll"
    },

    // Manejar cambio en el checkbox "No Pagar"
    handleNoPagarChange(detalle) {
      if (detalle.no_pagar) {
        detalle.selected = false; // Desmarcar "Seleccionado" si se elige "No Pagar"
      }
      this.updateSelectAllStatus();  // Actualiza el estado de "selectAll"
    },

    // Seleccionar/deseleccionar todos los registros
    toggleSelectAll() {
      this.asistencia.forEach(detalle => {
        detalle.selected = this.selectAll;
      });
    },

    // Actualizar el estado de "selectAll" cuando cambian los checkboxes individuales
    updateSelectAllStatus() {
      this.selectAll = this.asistencia.every(detalle => detalle.selected);
    }
  }
};
</script>

<style scoped>
/* Agregar aquí estilos adicionales si es necesario */
</style>
