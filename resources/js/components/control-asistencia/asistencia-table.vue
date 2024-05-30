<template>
  <div>
    <div class="filters row">
      <div class="col-md-3">
        <button class="btn btn-enod" @click="agregarNuevo" :disabled="!$can('A_asistencia_edit')">
          <span class="fa fa-plus-circle"></span> Nuevo
        </button>
      </div>
      <div class="col-md-1">

      </div>
      <div class="col-md-3">
        <date-picker
          v-model="selectedDate"
          type="month"
          format="MM-YYYY"
          @input="fetchData"
          class="date-picker-custom"
          placeholder="Seleccione una fecha"
        ></date-picker>
      </div>
      <div class="col-md-2">

      </div>
      <div class="col-md-3">
        <v-select
          v-model="selectedFrente"
          :options="frentes"
          label="codigo"
          placeholder="Seleccione un frente"
          @input="fetchData"
        ></v-select>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="box box-custom-enod top-buffer">
          <div class="box-body">
            <div class="table-responsive top-buffer">
              <table class="table table-hover table-striped table-condensed">
                <thead>
                  <tr>
                    <th>Frente</th>
                    <th>Fecha</th>
                    <th style="text-align: center;" colspan="2">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in items" :key="item.id">
                    <td>{{ item.frente ? item.frente.codigo : 'No disponible' }}</td>
                    <td>{{ item.fecha }}</td>
                    <td width="10px">
                      <button class="btn btn-warning btn-sm" @click="editar(item)" title="Editar">
                        <i class="fa fa-pencil"></i>
                      </button>
                    </td>
                    <td width="10px">
                      <button class="btn btn-default btn-sm" @click="copiar(item)" title="Copiar">
                        <i class="fa fa-copy"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <pagination
              :data="pagination"
              @pagination-change-page="fetchData">
              <span slot="prev-nav">&lt; Anterior</span>
              <span slot="next-nav">Siguiente &gt;</span>
            </pagination>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import VSelect from 'vue-select';
import DatePicker from 'vue2-datepicker';

export default {
  components: {
    'v-select': VSelect,
    'date-picker': DatePicker
  },
  data() {
    return {
      items: [],
      pagination: {},
      currentPage: 1,
      frentes: [],
      selectedFrente: null,
      selectedDate: null,
    };
  },
  mounted() {
    this.fetchFrentes();
    this.fetchData(this.currentPage);
  },
  methods: {
    fetchFrentes() {
      axios.get('/api/frentes').then(response => {
        this.frentes = response.data;
      }).catch(error => {
        console.error('Error al cargar los frentes:', error);
      });
    },
    agregarNuevo() {
      window.location.href = '/area/enod/asistencia-nuevo';
    },
    editar(item) {
      window.location.href = `/asistencia/edit/${item.id}`;
    },
    copiar(item) {
      window.location.href = `/asistencia/copia/${item.id}`;
    },
    fetchData(page = 1) {
      const params = {
        page,
        frente_id: this.selectedFrente ? this.selectedFrente.id : null,
        date: this.selectedDate ? this.selectedDate.toISOString().slice(0, 7) : null,
        sort_by: 'fecha',
        sort_order: 'desc'
      };
      axios.get('/api/area/enod/asistencia', { params })
        .then(response => {
          this.items = response.data.data;
          this.pagination = response.data;
          this.currentPage = page;
        })
        .catch(error => {
          console.error('Error al cargar los datos:', error);
        });
    }
  }
}
</script>

<style scoped>
.top-buffer {
  margin-top: 20px;
}
.filters {
  margin-bottom: 20px;
}
.date-picker-custom {
  width: 100%;
}
</style>