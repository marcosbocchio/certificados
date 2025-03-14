<template>
  <div>
    <div class="filters row">
      <div class="col-md-3">
        <button class="btn btn-enod" @click="agregarNuevo" :disabled="!$can('ASISTENCIA')">
          <span class="fa fa-plus-circle"></span> Nuevo
        </button>
      </div>
      <div class="col-md-1"></div>
      <div class="col-md-3">
        <div class="input-group">
          <label for="selectedDate" class="input-label">Fecha:</label>
          <date-picker
            v-model="selectedDate"
            type="month"
            format="MM-YYYY"
            @input="fetchData"
            class="v-s"
          ></date-picker>
        </div>
      </div>
      <div class="col-md-2"></div>
      <div class="col-md-3">
        <div class="input-group">
          <label for="selectedFrente" class="input-label">Frente:</label>
          <v-select
            v-model="selectedFrente"
            :options="frentes"  
            label="codigo"
            @input="fetchData"
            class="v-s"
          ></v-select>      
        </div>
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
                      <button 
                        class="btn btn-warning btn-sm" 
                        @click="editar(item)" 
                        title="Editar"
                        :disabled="!puedeEditar(item)"
                      >
                        <i class="fa fa-pencil"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <pagination
              :data="pagination"
              @pagination-change-page="fetchData"
              :limit="4"
            >
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
  props: {
    frentes_data: Array,
    user_frente: Array // Manteniendo como Array
  },
  data() {
    return {
      items: [],
      pagination: {},
      currentPage: 1,
      frentes: [],
      selectedFrente: '‎ ',
      selectedDate: null,
    };
  },
  mounted() {
    this.fetchFrentes();
    this.fetchData(this.currentPage);
    console.log(this.user_frente);
  },
  methods: {
    agregarNuevo() {
      window.location.href = '/area/enod/asistencia-nuevo';
    },
    editar(item) {
      window.location.href = `/asistencia/edit/servicio/${item.id}`;
    },
    copiar(item) {
      window.location.href = `/asistencia/copia/${item.id}`;
    },
    fetchFrentes() {
      this.frentes = this.frentes_data;
    },
    fetchData(page = 1) {
      const params = {
        page,
        frente_id: this.selectedFrente ? this.selectedFrente.id : null,
        date: this.selectedDate ? this.selectedDate.toISOString().slice(0, 7) : null,
        sort_by: 'fecha',
        sort_order: 'desc'
      };
      axios.get('/api/area/enod/asistencia/servicios', { params })
        .then(response => {
          this.items = response.data.data;
          this.pagination = response.data;
          this.currentPage = page;
        })
        .catch(error => {
          console.error('Error al cargar los datos:', error);
        });
    },
    puedeEditar(item) {
      return this.user_frente.some(frente => frente.frente_id === item.frente.id);
    },
    puedeCopiar(item) {
      return this.user_frente.some(frente => frente.frente_id === item.frente.id);
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
.input-group {
  display: flex;
  align-items: center;
}

.input-label {
  margin-right: 10px;
}
.v-s {
  width: 80%;
}
</style>