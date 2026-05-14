<template>
  <div class="row">
    <div class="col-md-3">
      <div class="box box-custom-enod">
        <div class="box-body box-profile">
          <ul class="list-group list-group-unbordered">
            <li class="list-group-item pointer">
              <div v-show="!selCliente" @click="selCliente = !selCliente">
                <span class="titulo-li">Cliente</span>
                <a class="pull-right">
                  <div v-if="cliente">{{ cliente.razon_social }}</div>
                  <div v-else><span class="seleccionar">Seleccionar</span></div>
                </a>
              </div>
              <v-select
                v-show="selCliente"
                v-model="cliente"
                label="razon_social"
                :options="clientes"
                @input="CambioCliente(); BuscarInformes(1);"
                placeholder="Seleccione Cliente"
              ></v-select>
            </li>

            <li class="list-group-item pointer">
              <div v-show="!selOt" @click="selOt = !selOt">
                <span class="titulo-li">OT</span>
                <a class="pull-right">
                  <div v-if="ot">{{ ot.numero }}</div>
                  <div v-else><span class="seleccionar">Seleccionar</span></div>
                </a>
              </div>
              <v-select
                v-show="selOt"
                v-model="ot"
                label="numero"
                :options="ots"
                @input="CambioOt(); BuscarInformes(1);"
                placeholder="Seleccione OT"
              ></v-select>
            </li>

            <li class="list-fecha list-group-item pointer">
              <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-6">
                  <date-picker
                    v-model="fecha_desde"
                    value-type="YYYY-MM-DD"
                    format="DD-MM-YYYY"
                    placeholder="Desde"
                    @change="BuscarInformes(1)"
                  ></date-picker>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6">
                  <date-picker
                    v-model="fecha_hasta"
                    value-type="YYYY-MM-DD"
                    format="DD-MM-YYYY"
                    placeholder="Hasta"
                    @change="BuscarInformes(1)"
                  ></date-picker>
                </div>
              </div>
            </li>
          </ul>
          <button @click="BuscarInformes(1)" class="btn btn-enod btn-block">
            <span class="fas fa-search"></span> Buscar
          </button>
        </div>
      </div>
    </div>

    <div class="col-md-9">
      <div v-if="informes.data && informes.data.length">
        <div class="box box-custom-enod">
          <div class="box-header with-border">
            <h3 class="box-title">Informes Pendientes de Parte Diario</h3>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table table-striped table-condensed">
                <thead>
                  <tr>
                    <th class="col-md-1">Fecha</th>
                    <th class="col-md-2">Informe</th>
                    <th class="col-md-2">N° OT</th>
                    <th class="col-md-4">Cliente</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, k) in informes.data" :key="k">
                    <td>{{ item.fecha_formateada }}</td>
                    <td>
                      <a :href="'/pdf/informe/' + item.id" target="_blank" title="Ver Informe">
                        <span>{{ item.numero_formateado }}</span>
                      </a>
                    </td>
                    <td>{{ item.ot_numero }}</td>
                    <td>{{ item.cliente_nombre_fantasia }}</td>
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
            <h4>No hay informes pendientes de parte diario para mostrar</h4>
          </div>
        </div>
      </div>
      <pagination :data="informes" @pagination-change-page="BuscarInformes" :limit="3">
        <span slot="prev-nav">&lt; Anterior</span>
        <span slot="next-nav">Siguiente &gt;</span>
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
import moment from 'moment';

export default {
  props: {
    ots_data: {
      type: Array,
      default: () => []
    },
    clientes_data: {
      type: Array,
      default: () => []
    }
  },
  components: {
    DatePicker,
    vSelect,
    Loading,
    Pagination
  },
  data() {
    return {
      cliente: null,
      ot: null,
      fecha_desde: null,
      fecha_hasta: null,

      ots: this.ots_data,
      clientes: this.clientes_data,

      informes: {},
      isLoading: false,

      selCliente: false,
      selOt: false,
    };
  },
  mounted() {
    this.BuscarInformes(1);
  },
  methods: {
    async BuscarInformes(page = 1) {
      this.isLoading = true;

      const cliente_id_param = this.cliente ? this.cliente.id : 'null';
      const ot_id_param = this.ot ? this.ot.id : 'null';
      const fecha_desde_param = this.fecha_desde ? moment(this.fecha_desde).format('YYYY-MM-DD') : 'null';
      const fecha_hasta_param = this.fecha_hasta ? moment(this.fecha_hasta).format('YYYY-MM-DD') : 'null';

      const url = `/api/informes/cliente/${cliente_id_param}/ot/${ot_id_param}/fecha_desde/${fecha_desde_param}/fecha_hasta/${fecha_hasta_param}/pendientes_parte_diario?page=${page}&api_token=${Laravel.user.api_token}`;

      try {
        const response = await axios.get(url);
        this.informes = response.data;
        console.log('Informes obtenidos:', this.informes);
      } catch (error) {
        console.error('Error al buscar informes:', error.response || error);
      } finally {
        this.isLoading = false;
      }
    },

    CambioCliente() {
      this.selCliente = false;
    },
    CambioOt() {
      this.selOt = false;
    },
  }
};
</script>

<style scoped>
.text-center {
  text-align: center;
}
</style>
