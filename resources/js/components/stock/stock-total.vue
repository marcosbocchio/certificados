<template>
  <div>
    <div class="row">
      <div class="col-md-3">
        <button @click="exportarTodoPDF" class="btn btn-enod exportar-todo-pdf">Exportar PDF</button>
      </div>
      <div class="col-md-3">
      </div>
      <div class="col-md-3">
        <div class="form-check form-check-inline mr-2">
            <v-select
                    v-model="selectedFilters"
                    :options="filterOptions"
                    label="text"
                    :reduce="option => option.value"
                    multiple
                    placeholder="Filtros"
                    @input="getResults"
                ></v-select>
        </div>
      </div>
      <div class="col-md-3">
        <div class="input-group" style="width: 17vw;">
          <input type="text" v-model="searchTerm" class="form-control" @keyup.enter="applySearch" placeholder="Buscar...">
          <span class="input-group-addon btn" @click="applySearch" style="background-color: rgb(255, 204, 0); cursor: pointer; border: none;">
            <i class="fa fa-search"></i>
          </span>
        </div>
      </div>
    </div>

    <div>
      <div class="box box-custom-enod">
        <div class="box-body">
          <div v-if="isLoading" class="text-center">

          </div>
          <div v-else-if="productos.length" class="table-responsive">
            <table class="table table-hover table-striped table-condensed">
              <thead>
                <tr style="width: 100%;">
                  <th style="width: 25%;">Codigo</th>
                  <th style="width: 45%;">Descripción</th>
                  <th style="width: 25%;">Stock</th>
                  <th colspan="2" style="width: 5%;">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="producto in productos" :key="producto.id">
                  <td>{{ producto.codigo }}</td>
                  <td>{{ producto.descripcion }}</td>
                  <td>{{ producto.stock }}</td>
                  <td width="10px">
                    <button @click="editProducto(producto)" class="btn btn-warning btn-sm" title="Editar" :disabled="!$can('S_stock_edita')">
                      <span class="fa fa-edit"></span>
                    </button>
                  </td>
                  <td width="10px">
                    <button class="btn btn-warning btn-sm" title="Ver Detalles" @click.prevent="registroProducto(producto)">
                      <span class="fa fa-list"></span>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div v-else class="text-center">
            <p></p>
          </div>
        </div>
      </div>
      <pagination :data="pagination" @pagination-change-page="getResults" :limit="4">
        <span slot="prev-nav">&lt; Previous</span>
        <span slot="next-nav">Next &gt;</span>
      </pagination>
      <loading
              :active.sync="isLoading"
              :loader="'bars'"
              :color="'red'">
      </loading>
    </div>
</div>
</template>

<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
export default {
  components: {
    Loading
  },
  data() {
    return {
      productos: [],
      pagination: {},
      searchTerm: '',
      relacionadoAPlacas: false,
      placa_sn: false,
      isLoading: false,
      selectedFilters: [],
        filterOptions: [
                { text: 'Cuenta como Placa', value: 'relacionado_placas' },
                { text: 'Es Placa', value: 'placa_sn' }
            ],
    filterActivos: false,
        }
  },
  mounted() {
    this.loadProductos();
  },
  watch: {
    relacionadoAPlacas() {
      this.loadProductos();
    }
  },
  methods: {
    loadProductos(page = 1) {
        this.isLoading = true;
        const params = {
            page: page,
            search: this.searchTerm,
            // CORRECCIÓN: Usamos el array 'selectedFilters' para ver qué filtros están activos
            placas: this.selectedFilters.includes('relacionado_placas') ? 1 : 0,
            placas_sn: this.selectedFilters.includes('placa_sn') ? 1 : 0
        };

        axios.get(`/api/stock/paginatestock`, { params })
        .then(response => {
            this.productos = response.data.data;
            this.pagination = response.data;
        })
        .catch(error => {
            console.error('API error:', error);
        })
        .finally(() => {
            this.isLoading = false;
        });
    },
    registroProducto(producto) {
      window.location.href = `/area/enod/stock-registro/${producto.id}`;
    },
    editProducto(producto) {
      window.location.href = `/area/enod/stock-edit/${producto.id}`;
    },
    exportarTodoPDF() {
        // Usamos la misma lógica que en loadProductos para construir los parámetros
        const params = new URLSearchParams({
            search: this.searchTerm,
            placas: this.selectedFilters.includes('relacionado_placas') ? '1' : '0',
            placas_sn: this.selectedFilters.includes('placa_sn') ? '1' : '0'
        });

        const url = `/imprimir-todo-stock?${params.toString()}`;
        window.open(url, '_blank');
    },
    getResults(page = 1) {
      this.loadProductos(page);
    },
    applySearch() {
      this.loadProductos();
    },
  },
};
</script>

<style scoped>
.exportar-todo-pdf {
  margin-bottom: 20px;
}
</style>
