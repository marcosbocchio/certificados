<template>
  <div>
    <table style="width: 100%; border-collapse: collapse;" class="table-responsive-mobile">
  <tr>
    <!-- Botón Nuevo -->
    <td class="td-mobile-stack" style="width: 8%;">
      <button class="btn btn-enod" @click="nuevoStock" style="background-color: rgb(255, 204, 0); color: rgb(0, 0, 0);" :disabled="!$can('S_compras')">
        <span class="fa fa-plus-circle"></span> Nuevo 
      </button>
    </td>
    <td class="td-mobile-stack" style="width: 9%;">

    </td>
    <!-- Texto 'Mostrar movimientos desde' -->
    <td class="td-mobile-stack" style="width: 15%; text-align: right; padding-right: 10px; font-size: 12px; color: #6E6A6A; font-family: 'Montserrat', sans-serif;">
      <p>Mostrar desde</p>
    </td>

    <!-- Selector de Fecha Desde -->
    <td class="td-mobile-stack" style="width: 13%;">
      <div class="form-group">
        <date-picker id="fechaDesde" v-model="fechaInicio" value-type="YYYY-MM-DD" format="DD-MM-YYYY" @change="aplicarFiltro" class="flex-grow-1"></date-picker>
      </div>
    </td>

    <!-- Texto 'Hasta' -->
    <td class="td-mobile-stack" style="width: 4%; text-align: right; padding-right: 10px; font-size: 12px; color: #6E6A6A; font-family: 'Montserrat', sans-serif;">
      <p>Hasta</p>
    </td>

    <!-- Selector de Fecha Hasta -->
    <td class="td-mobile-stack" style="width: 13%;">
      <div class="form-group">
        <date-picker id="fechaHasta" v-model="fechaFin" value-type="YYYY-MM-DD" format="DD-MM-YYYY" @change="aplicarFiltro" class="flex-grow-1"></date-picker>
      </div>
    </td>
    <td class="td-mobile-stack" style="width: 17%;">

    </td>
    <!-- Búsqueda -->
    <td class="td-mobile-stack" style="width: 20%;">
      <div class="input-group">
        <input type="text" v-model="search" class="form-control" @keyup.enter="aplicarFiltro" placeholder="Buscar...">
        <span class="input-group-addon btn" @click="aplicarFiltro" style="background-color: rgb(255, 204, 0); cursor: pointer; border: none;">
          <i class="fa fa-search"></i>
        </span>
      </div>
    </td>
  </tr>
</table>
    <div v-if="stockItems.length">
      <div class="box box-custom-enod top-buffer">
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-hover table-striped table-condensed">
              <thead>
                <tr>
                  <th>Fecha</th>
                  <th>Proveedor</th>
                  <th>Número Remito</th>
                  <th style="text-align: center;">anulado</th>
                  <th style="text-align: center; width: 10px;" colspan="2">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in stockItems" :key="item.id">
                  <td>{{ formatearFecha(item.fecha) }}</td>
                  <td>{{ getProveedorRazonSocial(item.proveedor_id) }}</td>
                  <td>{{ item.numero_remito }}</td>
                  <td style="text-align: center;">
                    <app-icon v-if="item.anulado_sn === 1" img="check" color="black"></app-icon>
                  </td>
                  <td width="10px">
                    <button @click="editStock(item)" class="btn btn-default btn-sm" title="Ver Compra" :disabled="!$can('S_compras')">
                      <app-icon img="eye" color="black"></app-icon>
                    </button>
                  </td>
                  <td width="10px" v-if="item.anulado_sn !== 1" style="text-align: center;">
                    <button @click="confirmarAnulacion(item)" class="btn btn-default btn-sm" title="Anular" :disabled="!$can('S_compras_edita')">
                      <app-icon img="remove" color="black"></app-icon>
                    </button>
                  </td>
                  <!-- Botón Desanular si está anulado -->
                  <td v-else width="10px" style="text-align: center;">
                    <button @click="confirmarDesanulacion(item)" class="btn btn-default btn-sm" title="Desanular" :disabled="!$can('S_compras_edita')">
                      <app-icon img="check" color="black"></app-icon>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <pagination
        :data="pagination"
        @pagination-change-page="getResults">
        <span slot="prev-nav">&lt; Previous</span>
        <span slot="next-nav">Next &gt;</span>
      </pagination>
    </div>
    <div class="clearfix"></div>
    <confirmar-modal></confirmar-modal>
  </div>
</template>

<script>
import { eventModal } from '../event-bus';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css'; // Asegúrate de importar el CSS
import toastr from 'toastr';
export default {
  created() {
    eventModal.$on('confirmar_accion', (accion,item) => {
      switch (accion) {
        case 'anular':
          this.anularInforme(item);
          break;
        case 'desanular':
          this.desanularInforme(item);
          break;
        default:
          break;
      }
    });
  },
  props: {
    proveedor: { // Cambia esto para que coincida con lo que pasas desde Blade
      type: Array,
      required: true
    },
  },
  components: {
    DatePicker
  },
  data() {
    return {
      stockItems: [],
      search: '',
      pagination: {},
      fechaInicio: '',
      fechaFin: '',
    };
  },mounted() {
    this.fechaInicio = new Date(new Date().setDate(new Date().getDate() - 30)).toISOString().split('T')[0];
    this.fechaFin = new Date().toISOString().split('T')[0];
    this.loadStockItems();
  },
  methods: {
    confirmarAnulacion(item) {

      eventModal.$emit('abrir_confirmar_accion', 'Está seguro que quiere anular el informe N° ' + item.numero_remito + ' ?', 'anular',item);
    },
    confirmarDesanulacion(item) {

      eventModal.$emit('abrir_confirmar_accion', 'Está seguro que quiere desanular el informe N° ' + item.numero_remito + ' ?', 'desanular',item);
    },
    anularInforme(item) {
      console.log('Anulando informe:', item.id);
      const url = `/api/stock/${item.id}/anular`;
      axios.get(url)
        .then(response => {

          toastr.success(response.data.message);
          this.loadStockItems();
        })
        .catch(error => {

          toastr.error('Error al anular la compra:', error.response.data);

        });
    },
    desanularInforme(item) {
    axios.get(`/api/stock/${item.id}/desanular`)
      .then(response => {

        toastr.success(response.data.message);

        this.loadStockItems();
      })
      .catch(error => {

        toastr.error("Hubo un error al desanular el informe:", error.response);

      });
  },
    aplicarFiltro: function() {
      console.log('Filtro aplicado', this.fechaInicio, this.fechaFin);
      this.loadStockItems();
    },
    
    loadStockItems: function(page = 1) {
      // Incluye 'search' en los parámetros de la petición
      const params = {
        page: page,
        search: this.search,
        fechaInicio: this.fechaInicio, // Fecha de inicio
        fechaFin: this.fechaFin, // Añade la nueva fecha de fin
      };
      
      axios.get('/api/stock/paginate', { params })
      .then(response => {
        this.stockItems = response.data.data;
        this.pagination = response.data;
      })
      .catch(error => {
        console.error('API error:', error);
      });
  },
    getResults: function(page = 1) {
      this.loadStockItems(page);
    },
    editStock(item) {
        window.location.href = '/area/enod/stock-ajuste/' + item.id;
    },nuevoStock() {
      window.location.href = '/area/enod/stock'; // Redirige a la página para crear un nuevo stock
    },
    formatearFecha(fecha) {
      return fecha.split(' ')[0];
    },
    getProveedorRazonSocial(proveedorId) {
      const proveedor = this.proveedor.find(p => p.id === proveedorId); // Asegúrate de que 'id' es la propiedad correcta
      return proveedor ? proveedor.razon_social : 'No encontrado'; // Cambia 'razon_social' si la propiedad tiene otro nombre
    }
  }
}
</script>
<style scoped>
@media (max-width: 768px) {
  .td-mobile-stack {
    display: block;
    width: 100% !important; /* Asegura que esta regla tenga prioridad */
    box-sizing: border-box;
    padding: 5px 0 !important; /* Reduce el espacio entre celdas */
  }
  .table-responsive-mobile {
    border: 0; /* Elimina los bordes de la tabla en vistas móviles si se desea */
  }
}
</style>