<template>
  <div class="row">
    <div class="col-md-3">
      <div class="box box-custom-enod">
        <div class="box-body box-profile">
          <ul class="list-group list-group-unbordered">
            <li class="list-group-item pointer">
              <div v-show="!selOperador">
                <span class="titulo-li">Operador</span>
                <a @click="selOperador = !selOperador" class="pull-right">
                  <div v-if="operador">{{ operador.name }}</div>
                  <div v-else><span class="seleccionar">Seleccionar</span></div>
                </a>
              </div>
              <v-select v-show="selOperador" v-model="operador" label="name" :options="operadores" @input="CambioOperador"></v-select>
            </li>
            <li class="list-fecha list-group-item pointer">
              <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-6">
                  <date-picker v-model="fecha_desde" value-type="YYYY-MM-DD" format="DD-MM-YYYY" placeholder="Desde"></date-picker>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6">
                  <date-picker v-model="fecha_hasta" value-type="YYYY-MM-DD" format="DD-MM-YYYY" placeholder="Hasta"></date-picker>
                </div>
              </div>
            </li>
          </ul>
          <button @click="Buscar(1)" class="btn btn-enod btn-block">
            <span class="fa fa-search"></span> Buscar
          </button>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div v-if="tablaAsignaciones.data && tablaAsignaciones.data.length">
        <div class="box box-custom-enod">
          <div class="box-header with-border">
            <h3 class="box-title">Detalle</h3>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table table-striped table-condensed">
                <thead>
                  <tr>
                    <th class="col-md-1">Fecha</th>
                    <th class="col-md-2">Remito</th>
                    <th class="col-md-2">Operador</th>
                    <th class="col-md-4">EPP</th>
                    <th class="col-md-1">Cantidad</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, k) in tablaAsignaciones.data" :key="k">
                    <td>{{ item.fecha }}</td>
                    <td>{{ item.remito }}</td>
                    <td>{{ item.op }}</td>
                    <td>{{ item.epp }}</td>
                    <td>{{ item.cant }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div v-else>
        <div class="box box-custom-enod">
          <div class="box-body">
            <h4>No hay datos para mostrar</h4>
          </div>
        </div>
      </div>
      <pagination :data="tablaAsignaciones" @pagination-change-page="Buscar" :limit="10">
        <span slot="prev-nav">&lt; Previous</span>
        <span slot="next-nav">Next &gt;</span>
      </pagination>
    </div>
    <loading :active.sync="isLoading" :loader="'bars'" :color="'red'"></loading>
  </div>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import Pagination from 'laravel-vue-pagination';
import axios from 'axios';

export default {
  props: ['user', 'operadores_data'],
  components: { DatePicker, vSelect, Loading, Pagination },
  data() {
    return {
      operador: null,
      fecha_desde: null,
      fecha_hasta: null,
      operadores: this.operadores_data,
      tablaAsignaciones: {},
      isLoading: false,
      selOperador: false,
    };
  },
  methods: {
    async Buscar(page = 1) {
      this.isLoading = true;
      try {
        const response = await axios.post('/api/buscar-asignaciones-epp', {
          start_date: this.fecha_desde || '2001-01-01',
          end_date: this.fecha_hasta || '2100-12-30',
          user_id: this.operador ? this.operador.id : null,
          page: page,
          per_page: 10
        });
        this.tablaAsignaciones = response.data;
      } catch (error) {
        console.error(error);
      } finally {
        this.isLoading = false;
      }
    },
    CambioOperador() {
      this.selOperador = false;
    }
  }
};
</script>