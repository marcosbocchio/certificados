<template>
  <div class="row">
    <div class="col-md-3">
      <div class="box box-custom-enod">
        <div class="box-body box-profile">
          <ul class="list-group list-group-unbordered">
            <!-- Select para Frentes -->
            <li class="list-group-item pointer">
              <span class="titulo-li">Frente</span>
              <v-select
                v-model="selectedFrente"
                :options="frentes"
                label="codigo"
                @input="handleFrenteChange"
                class="custom-select"
              ></v-select>
            </li>
            <!-- Datepickers para Fecha Desde/Hasta -->
            <li class="list-fecha list-group-item pointer">
              <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-6">
                  <date-picker
                    v-model="fechaDesde"
                    value-type="YYYY-MM-DD"
                    format="DD-MM-YYYY"
                    placeholder="Desde"
                  ></date-picker>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6">
                  <date-picker
                    v-model="fechaHasta"
                    value-type="YYYY-MM-DD"
                    format="DD-MM-YYYY"
                    placeholder="Hasta"
                  ></date-picker>
                </div>
              </div>
            </li>

            <!-- Select para OTs -->
            <li class="list-group-item pointer">
              <span class="titulo-li">OTs</span>
              <v-select
                v-model="selectedOts"
                :options="ots"
                label="numero"
                multiple
              >
                <template slot="option" slot-scope="option">
                  <span class="upSelect">{{ option.numero }}</span> <br />
                  <span class="downSelect">{{ option.proyecto }}</span>
                </template>
              </v-select>
            </li>
            <!-- Filtro de fechas para OTs -->
            <li class="list-fecha list-group-item pointer">
              <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-6">
                  <date-picker
                    v-model="fechaOtDesde"
                    value-type="YYYY-MM-DD"
                    format="DD-MM-YYYY"
                    placeholder="Desde"
                  ></date-picker>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6">
                  <date-picker
                    v-model="fechaOtHasta"
                    value-type="YYYY-MM-DD"
                    format="DD-MM-YYYY"
                    placeholder="Hasta"
                  ></date-picker>
                </div>
              </div>
            </li>
          </ul>
          <!-- Botón Buscar -->
          <button
            @click="Buscar"
            class="btn btn-enod btn-block"
            :disabled="
              selectedRemitos.length === 0 ||
              !fechaDesde ||
              !fechaHasta ||
              selectedOts.length === 0 ||
              !fechaOtDesde ||
              !fechaOtHasta
            "
          >
            <span class="fa fa-search"></span> Buscar
          </button>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <!-- Tabla de productos -->
      <div v-if="productos.length > 0">
        <div class="box box-custom-enod">
          <div class="box-header with-border">
            <h3 class="box-title">
              Productos enviados entre {{ formatDate(fechaDesde) }} - {{ formatDate(fechaHasta) }}
            </h3>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table table-striped table-condensed">
                <thead>
                  <tr>
                    <th class="col-md-1">Cantidad</th>
                    <th class="col-md-2">Producto</th>
                    <th class="col-md-2">Metros Totales</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="producto in productos" :key="producto.producto_id">
                    <td>{{ producto.cantidad }}</td>
                    <td>{{ producto.descripcion }}</td>
                    <td>{{ producto.cantidad * producto.metros }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div v-else-if="productos.length === 0">
        <div class="box box-custom-enod">
          <div class="box-body">
            <h4>No hay productos relacionados</h4>
          </div>
        </div>
      </div>

      <!-- Tabla de detalles de placas -->
      <div v-if="detallesPlacas.length > 0">
        <div class="box box-custom-enod">
          <div class="box-header with-border">
            <h3 class="box-title">
              Productos usados entre {{ formatDate(fechaOtDesde) }} - {{ formatDate(fechaOtHasta) }}
            </h3>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table table-striped table-condensed">
                <thead>
                  <tr>
                    <th class="col-md-1">Cantidad</th>
                    <th class="col-md-2">Medida Placa</th>
                    <th class="col-md-2">Total M</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="detalle in detallesPlacas" :key="detalle.cm_agrupacion">
                    <td>{{ detalle.placas_total }}</td>
                    <td>{{ detalle.cm_agrupacion }}</td>
                    <td>{{ calculateTotalCm(detalle) }}</td>
                  </tr>
                  <tr>
                    <td colspan="2"><strong>Total:</strong></td>
                    <td><strong>{{ calculateGrandTotal }}</strong></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div v-else-if="detallesPlacas.length === 0">
        <div class="box box-custom-enod">
          <div class="box-body">
            <h4>No hay detalles de placas</h4>
          </div>
        </div>
      </div>

      <!-- Componente de carga -->
      <loading :active.sync="isLoading" :loader="'bars'" :color="'red'"></loading>
    </div>
  </div>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import axios from 'axios';

export default {
  components: {
  DatePicker,
  vSelect,
  Loading
  },
  data() {
    return {
      selectedFrente: null,
      frentes: [],
      selectedRemitos: [],
      remitos: [],
      productos: [],
      fechaDesde: null,
      fechaHasta: null,
      selectedOts: [], // Estado para OTs seleccionados
      ots: [], // Lista de opciones de OTs
      fechaOtDesde: null, // Estado para fecha OT desde
      fechaOtHasta: null, // Estado para fecha OT hasta
      detallesPlacas: [], // Lista para almacenar detalles de placas
      isLoading: false,
    };
  },
  methods: {
    async loadFrentes() {
      try {
        const response = await axios.get("/api/reporte-placas/frentes");
        this.frentes = response.data;
      } catch (error) {
        console.error("Error loading frentes:", error);
      }
    },
    async CargarOts() {
      try {
        const response = await axios.get("/api/reporte-placas/ots");
        this.ots = response.data;
      } catch (error) {
        console.error("Error loading OTs:", error);
      }
    },
    async handleFrenteChange() {
      if (this.fechaDesde && this.fechaHasta) {
        this.CargarRemitos();
      }
    },
    async handleFechaChange() {
      if (this.selectedFrente) {
        this.CargarRemitos();
      }
    },
    async CargarRemitos() {
      if (!this.selectedFrente || !this.fechaDesde || !this.fechaHasta) {
        return;
      }

      this.selectedRemitos = [];
      this.remitos = [];
      this.productos = [];

      try {
        const response = await axios.get("/api/reporte-placas/remitos", {
          params: {
            frente_id: this.selectedFrente.id,
            fecha_desde: this.fechaDesde,
            fecha_hasta: this.fechaHasta,
          },
        });

        const remitosFormatted = response.data.map((remito) => ({
          ...remito,
          formatted: `${remito.prefijo}-${String(remito.numero).padStart(
            8,
            "0"
          )}`,
        }));
        this.selectedRemitos = remitosFormatted;
      } catch (error) {
        console.error("Error loading remitos:", error);
      }
    },
    async CargarProductos() {
      if (this.selectedRemitos.length > 0) {
        try {
          const response = await axios.post(
            "/api/reporte-placas/remitos-productos",
            {
              ids_remitos: this.selectedRemitos.map((remito) => remito.id),
            }
          );
          this.productos = response.data;
        } catch (error) {
          console.error("Error loading productos:", error);
        }
      }
    },
    async Buscar() {
  try {
    this.isLoading = true;

    // Primero obtén las partes
    const responsePartes = await axios.post("/api/reporte-placas/partes-placas", {
      fecha_ot_desde: this.fechaOtDesde,
      fecha_ot_hasta: this.fechaOtHasta,
      ots_ids: this.selectedOts.map((ot) => ot.id),
    });
    this.CargarProductos();
    this.partes = responsePartes.data;

    // Luego, obtén los detalles de las placas usando las partes obtenidas
    const responseDetalles = await axios.post("/api/reporte-placas/partes-detalles-placas", {
      ids_partes: this.partes.map(parte => parte.id),
    });

    this.detallesPlacas = responseDetalles.data;

    this.isLoading = false;
  } catch (error) {
    console.error("Error fetching details:", error);
    this.isLoading = false;
  }
},
    async getRemitosPlacas(partes) {
      try {
        const response = await axios.post(
          "/api/reporte-placas/remitos-productos",
          {
            partes: partes,
          }
        );
        return response.data;
      } catch (error) {
        console.error("Error getting remitos placas:", error);
        return [];
      }
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString('es-AR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
      });
    },
    // Calcular el total cm² de una placa
    calculateTotalCm(detalle) {
  // Extraer dimensiones en centímetros
  const dimensionesCm = this.extractDimensions(detalle.cm_agrupacion);

  // Convertir dimensiones a metros (dividir por 100)
  const dimensionesMetros = dimensionesCm ? dimensionesCm / 100 : 0;

  // Calcular el total en metros
  const totalMetros = detalle.placas_total * dimensionesMetros;

  // Mostrar el total con hasta 2 decimales
  return totalMetros.toFixed(2);
},
    // Extraer dimensiones de una cadena de formato "ancho x alto"
    extractDimensions(dimensionString) {
  const parts = dimensionString.split('x').map(part => part.trim()); // Divide la cadena y elimina espacios
  if (parts.length === 2) {
    const [width, height] = parts.map(Number); // Convierte las partes a números
    return height; // Retorna solo el valor de 'height'
  }
  return null; // Retorna null si no tiene el formato esperado
},
  },
  computed: {
    calculateGrandTotal() {
    const total = this.detallesPlacas.reduce((total, detalle) => {
      // Asegúrate de que el resultado sea un número sumando al total
      return total + parseFloat(this.calculateTotalCm(detalle));
    }, 0);

    // Limitar el resultado a 2 decimales
    return total.toFixed(2);
  }
  },
  watch: {
    fechaDesde() {
      this.handleFechaChange();
    },
    fechaHasta() {
      this.handleFechaChange();
    },
    selectedFrente() {
      if (this.fechaDesde && this.fechaHasta) {
        this.handleFrenteChange();
      }
    },
  },
  created() {
    this.loadFrentes();
    this.CargarOts();
  },
};
</script>

<style scoped>

</style>