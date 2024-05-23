<template>
  <div>
    <loading :active.sync="isLoading" :is-full-page="true" :loader="'bars'" :color="'red'"></loading>
    
    <!-- Filtros de Fecha y Días Hábiles -->
    <div class="box box-custom-enod top-buffer">
      <div class="box-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="frente">Frente *</label>
              <v-select v-model="frente_selected" :options="frentes_opciones" label="codigo" id="frente"></v-select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="month">Mes y Año:</label>
              <input type="month" v-model="selectedMonthYear" @input="fetchAsistencia" class="form-control" placeholder="Seleccione mes y año" />
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
      <div class="box-body">
        <table class="table table-hover table-striped table-condensed">
          <thead>
            <tr>
              <th>Operador</th>
              <th>Días Hábiles</th>
              <th>Sab.</th>
              <th>Dom.</th>
              <th>Feriados</th>
              <th>Horas Extras</th>
              <th>Servicios Extras S1</th>
              <th>Pago S1</th>
              <th>Servicios Extras S2</th>
              <th>Pago S2</th>
              <th>Servicios Extras S3</th>
              <th>Pago S3</th>
              <th>Servicios Extras S4</th>
              <th>Pago S4</th>
              <th>Servicios Extras S5</th>
              <th>Pago S5</th>
              <th>Pagos Ext. Mensual</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="operador in operarios" :key="operador.operador.id">
              <td>{{ operador.operador.name }}</td>
              <td>{{ operador.diasHabiles }}</td>
              <td>{{ operador.sabados }}</td>
              <td>{{ operador.domingos }}</td>
              <td>{{ operador.feriados }}</td>
              <td>{{ operador.horasExtras }}</td>
              <td>{{ operador.serviciosExtrasS1 }}</td>
              <td><input type="checkbox" v-model="operador.pagoS1" :disabled="operador.precargadoPagoS1" /></td>
              <td>{{ operador.serviciosExtrasS2 }}</td>
              <td><input type="checkbox" v-model="operador.pagoS2" :disabled="operador.precargadoPagoS2" /></td>
              <td>{{ operador.serviciosExtrasS3 }}</td>
              <td><input type="checkbox" v-model="operador.pagoS3" :disabled="operador.precargadoPagoS3" /></td>
              <td>{{ operador.serviciosExtrasS4 }}</td>
              <td><input type="checkbox" v-model="operador.pagoS4" :disabled="operador.precargadoPagoS4" /></td>
              <td>{{ operador.serviciosExtrasS5 }}</td>
              <td><input type="checkbox" v-model="operador.pagoS5" :disabled="operador.precargadoPagoS5" /></td>
              <td><input type="checkbox" v-model="operador.pagosExtMensual" :disabled="operador.precargadoPagosExtMensual" /></td>
            </tr>
          </tbody>
        </table>
      </div>
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

export default {
  components: {
    Loading
  },
  props: {
    frentes_opciones: {
      type: Array,
      required: true
    },
  },
  data() {
    return {
      frente_selected: '',
      selectedMonthYear: '',
      diasHabiles: '',
      operarios: [],
      message: '',
      isLoading: false
    };
  },
  methods: {
    async fetchAsistencia() {
      if (!this.selectedMonthYear || !this.frente_selected) {
        toastr.error('Por favor, seleccione una fecha y un frente');
        return;
      }

      const [year, month] = this.selectedMonthYear.split('-');
      this.isLoading = true;

      try {
        const response = await axios.get('/api/asistencia-operadores', {
          params: {
            year: year,
            month: month,
            frent_id: this.frente_selected.id
          }
        });

        this.diasHabiles = response.data.diasDelMes.diasHabiles;

        if (Array.isArray(response.data.asistencias)) {
          this.operarios = response.data.asistencias.map(operador => ({
            operador: operador.operador,
            id: operador.operador.id,
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
        } else {
          this.operarios = [];
          console.error('Unexpected data format:', response.data.asistencias);
        }
        this.message = '';
      } catch (error) {
        if (error.response && error.response.status === 404) {
          toastr.error(error.response.data.message);
          this.operarios = [];
          this.diasHabiles = '';
        } else {
          console.error('Error fetching asistencia:', error);
          toastr.error('Error al cargar los datos');
        }
      } finally {
        this.isLoading = false;
      }
    },
    async guardarPagos() {
      this.isLoading = true;
      try {
        const operariosSeleccionados = this.operarios.filter(operador => 
          operador.pagoS1 || operador.pagoS2 || operador.pagoS3 || operador.pagoS4 || operador.pagoS5 || operador.pagosExtMensual
        );

        const response = await axios.post('/api/guardar-pagos', {
          frente_id: this.frente_selected.id,
          selectedMonthYear: this.selectedMonthYear,
          operarios: operariosSeleccionados,
        });        
        toastr.success('Pagos guardados con éxito');
      } catch (error) {
        console.error(error);
        toastr.error('Error al guardar los pagos');
      } finally {
        this.isLoading = false;
      }
    }
  }
};
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