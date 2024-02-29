<template>
  <div>
    <div class="row">
      <div class="col-md-1">
        <button @click="exportarPDF(id)" class="btn btn-enod exportar-todo-pdf" title="Exportar PDF">Exportar PDF</button>
      </div>
      <div class="col-md-2">
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
              <tr>
                <th>Fecha</th>
                <th>Movimiento</th>
                <th>Observaciones</th>
                <th>Cantidad</th>
                <th>Stock</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in registro.data" :key="item.id">
                <td>{{ formatearFecha(item.fecha) }}</td>
                <td>{{ item.tipo_movimiento }}</td>
                <td>{{ item.obs }}</td>
                <td>{{ item.cantidad }}</td>
                <td>{{ item.stock }}</td>
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