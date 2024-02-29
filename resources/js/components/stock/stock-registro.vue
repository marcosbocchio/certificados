<template>
  <div>
    <div class="row">
      <div class="col-md-1">
        <button @click="exportarPDF(id)" class="btn btn-enod exportar-todo-pdf" title="Exportar PDF">Exportar PDF</button>
      </div>
      <div class="col-md-7">

      </div>
      <div class="col-md-4" style="display: flex;align-items: center; justify-content: flex-end;">
        <div>
          <p style="font-size: 12px; color: #6E6A6A; font-family: 'Montserrat', sans-serif; margin-right: 5px;">Mostar movimientos a partir de</p>
        </div>
        <div class="form-group">
          <date-picker id="fechaDesde" v-model="fechaInicio" value-type="YYYY-MM-DD" format="DD-MM-YYYY" placeholder="Desde" @change="aplicarFiltro" class="flex-grow-1"></date-picker>
        </div>
      </div>
  </div>
  <div v-if="registro.data.length">
  </div>
    <div class="box box-custom-enod">
      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-hover table-striped table-condensed">
            <thead>
              <tr style="width: 100%;">
                <th style="width: 8%;">Fecha</th>
                <th style="width: 35%;">Movimiento</th>
                <th style="width: 37%;">Observaciones</th>
                <th style="text-align: right; width: 10%;">Cantidad</th>
                <th style="text-align: right; width: 10%;">Stock</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in registro.data" :key="item.id">
                <td>{{ formatearFecha(item.fecha) }}</td>
                <td>{{ item.tipo_movimiento }}</td>
                <td>{{ item.obs }}</td>
                <td style="text-align: right;">{{ item.cantidad }}</td>
                <td style="text-align: right;">{{ item.stock }}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <pagination
          :data="registro"
          @pagination-change-page="getRegistro">
          <span slot="prev-nav">&lt; Anterior</span>
          <span slot="next-nav">Siguiente &gt;</span>
        </pagination>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

export default {
  mounted() {
    this.fechaInicio = new Date(new Date().setDate(new Date().getDate() - 30)).toISOString().split('T')[0];
    this.getRegistro();
  },
  props: {
    id: {
      type: Number,
      required: true
    }
  },
  components: {
    DatePicker
  },
  data() {
    return {
      registro: { data: [] },
      fechaInicio: this.calcularFechaInicio(),
    };
  },
  methods: {
    calcularFechaInicio() {
    const hoy = new Date();
    hoy.setMonth(hoy.getMonth() - 1);
    return hoy.toISOString().split('T')[0];
  },
    getRegistro(page = 1) {
      const params = {
        page: page,
        fechaInicio: this.fechaInicio,
      };
      axios.get(`/api/stock/paginateRegistro/${this.id}`, { params })
        .then(response => {
          this.registro = response.data;
        });
    },
    aplicarFiltro() {
      this.getRegistro(); 
    },
    formatearFecha(fecha) {
      return fecha.split(' ')[0];
    },
    exportarPDF(id) {
      const url = `/imprimir-stock/${id}?fechaInicio=${this.fechaInicio}`;
      console.log(url); // Imprime la URL para comprobar
      window.open(url, '_blank');
    },
  },
};
</script>

<style scoped>
.exportar-todo-pdf {
  margin-bottom: 20px;
}
</style>