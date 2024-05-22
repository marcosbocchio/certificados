<template>
  <div>
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
              <input type="month" v-model="selectedMonthYear" @input="fetchAsistencia" class="form-control" placeholder=""/>
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

    <!-- Mostrar semanas -->
    <div class="box box-custom-enod top-buffer" v-if="semanas.length">
      <div class="box-body">
        <div v-for="(semana, index) in semanas" :key="index" class="semana">
          <h5>Semana {{ index + 1 }}: {{ semana.inicio }} a {{ semana.fin }}</h5>
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
              <td><input type="checkbox" v-model="operador.pagoS1" /></td>
              <td>{{ operador.serviciosExtrasS2 }}</td>
              <td><input type="checkbox" v-model="operador.pagoS2" /></td>
              <td>{{ operador.serviciosExtrasS3 }}</td>
              <td><input type="checkbox" v-model="operador.pagoS3" /></td>
              <td>{{ operador.serviciosExtrasS4 }}</td>
              <td><input type="checkbox" v-model="operador.pagoS4" /></td>
              <td>{{ operador.serviciosExtrasS5 }}</td>
              <td><input type="checkbox" v-model="operador.pagoS5" /></td>
              <td><input type="checkbox" v-model="operador.pagosExtMensual" /></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div v-if="message" class="alert alert-warning">
      {{ message }}
    </div>

    <button @click="guardarPagos" class="btn btn-primary">Guardar</button>
  </div>
</template>

<script>
import axios from 'axios';

export default {
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
      semanas: []
    };
  },
  methods: {
    async fetchAsistencia() {
      if (!this.selectedMonthYear || !this.frente_selected) {
        this.message = 'Por favor, seleccione una fecha y un frente.';
        return;
      }

      const [year, month] = this.selectedMonthYear.split('-');

      try {
        const response = await axios.get('/api/asistencia-operadores', {
          params: {
            year: year,
            month: month,
            frent_id: this.frente_selected.id
          }
        });

        this.diasHabiles = response.data.diasDelMes.diasHabiles;
        this.semanas = response.data.diasDelMes.semanas;

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
            pagosExtMensual: operador.pagosExtMensual || false
          }));
        } else {
          this.operarios = [];
          console.error('Unexpected data format:', response.data.asistencias);
        }
        this.message = '';
      } catch (error) {
        if (error.response && error.response.status === 404) {
          this.message = error.response.data.message;
          this.operarios = [];
          this.diasHabiles = '';
        } else {
          console.error('Error fetching asistencia:', error);
        }
      }
    },
    async guardarPagos() {
      try {
        const operariosSeleccionados = this.operarios.filter(operador => 
          operador.pagoS1 || operador.pagoS2 || operador.pagoS3 || operador.pagoS4 || operador.pagoS5 || operador.pagosExtMensual
        );

        const response = await axios.post('/api/guardar-pagos', {
          frente_id: this.frente_selected.id,
          selectedMonthYear: this.selectedMonthYear,
          operarios: operariosSeleccionados,
        });

        this.message = 'Pagos guardados con éxito.';
      } catch (error) {
        this.message = 'Error al guardar los pagos.';
        console.error(error);
      }
    }
  }
};
</script>