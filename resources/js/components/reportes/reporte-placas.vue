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
              ></v-select>
            </li>
            <!-- Datepickers para Fecha Desde/Hasta -->
            <li class="list-group-item">
              <span class="titulo-li">Fecha Desde</span>
              <date-picker
                v-model="fechaDesde"
                value-type="YYYY-MM-DD"
                format="DD-MM-YYYY"
              ></date-picker>
            </li>
            <li class="list-group-item">
              <span class="titulo-li">Fecha Hasta</span>
              <date-picker
                v-model="fechaHasta"
                value-type="YYYY-MM-DD"
                format="DD-MM-YYYY"
              ></date-picker>
            </li>
            <!-- Botón para Cargar Remitos -->
            <button
              @click="CargarRemitos"
              class="btn btn-enod btn-block"
              :disabled="!selectedFrente || !fechaDesde || !fechaHasta"
            >
              <span class="fa fa-refresh"></span> Cargar Remitos
            </button>
            <!-- Select para Remitos -->
            <li class="list-group-item pointer" v-if="remitos.length > 0">
              <span class="titulo-li">Remito</span>
              <v-select
                v-model="selectedRemitos"
                :options="remitos"
                label="formatted"
                multiple
                :disabled="remitos.length === 0"
              ></v-select>
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
            <!-- Añadido filtro de fechas para OTs -->
            <li class="list-group-item">
              <span class="titulo-li">Fecha OT Desde</span>
              <date-picker
                v-model="fechaOtDesde"
                value-type="YYYY-MM-DD"
                format="DD-MM-YYYY"
              ></date-picker>
            </li>
            <li class="list-group-item">
              <span class="titulo-li">Fecha OT Hasta</span>
              <date-picker
                v-model="fechaOtHasta"
                value-type="YYYY-MM-DD"
                format="DD-MM-YYYY"
              ></date-picker>
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
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Cantidad</th>
                  <th>Producto</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="producto in productos" :key="producto.producto_id">
                  <td>{{ producto.cantidad }}</td>
                  <td>{{ producto.descripcion }}</td>
                </tr>
              </tbody>
            </table>
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
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Cantidad</th>
                  <th>Medida Placa</th>
                  <th>Total cm²</th>
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
import vSelect from "vue-select";
import Datepicker from "vuejs-datepicker";
import "vue-select/dist/vue-select.css";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import axios from "axios";

export default {
  components: { vSelect, Loading, "date-picker": Datepicker },
  data() {
    return {
      selectedFrente: null,
      frentes: [],
      selectedRemitos: [],
      remitos: [],
      productos: [],
      fechaDesde: null,
      fechaHasta: null,
      selectedOts: [], // Nuevo estado para OTs seleccionados
      ots: [], // Lista de opciones de OTs
      fechaOtDesde: null, // Nuevo estado para fecha OT desde
      fechaOtHasta: null, // Nuevo estado para fecha OT hasta
      partes: [], // Nueva lista para almacenar los resultados de partes
      detallesPlacas: [], // Nueva lista para almacenar los detalles de placas
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
    async CargarRemitos() {
      if (!this.selectedFrente || !this.fechaDesde || !this.fechaHasta) {
        alert("Por favor, selecciona un frente y las fechas.");
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
        this.remitos = remitosFormatted;
      } catch (error) {
        console.error("Error loading remitos:", error);
      }
    },
    async CargarProductos() {
      this.productos = [];
      if (this.selectedRemitos.length > 0) {
        try {
          const response = await axios.post(
            "/api/reporte-placas/remitos-productos",
            {
              ids_remitos: this.selectedRemitos.map((remito) => remito.id),
              fecha_desde: this.fechaDesde,
              fecha_hasta: this.fechaHasta,
            }
          );
          this.productos = response.data;
        } catch (error) {
          console.error("Error loading productos:", error);
        }
      }
    },
    async loadOts() {
      try {
        const response = await axios.get("/api/reporte-placas/ots");
        this.ots = response.data;
      } catch (error) {
        console.error("Error loading ots:", error);
      }
    },
    async CargarPartes() {
      this.partes = [];
      if (this.selectedOts.length > 0) {
        try {
          const response = await axios.post(
            "/api/reporte-placas/ot-detalle-placas",
            {
              ids_ots: this.selectedOts.map((ot) => ot.id),
              fecha_desde: this.fechaOtDesde,
              fecha_hasta: this.fechaOtHasta,
            }
          );
          this.partes = response.data;
        } catch (error) {
          console.error("Error loading partes:", error);
        }
      }
    },
    Buscar() {
      if (
        this.selectedRemitos.length === 0 ||
        !this.fechaDesde ||
        !this.fechaHasta ||
        this.selectedOts.length === 0 ||
        !this.fechaOtDesde ||
        !this.fechaOtHasta
      ) {
        return;
      }

      this.isLoading = true;

      // Cargar productos y partes en paralelo
      Promise.all([this.CargarProductos(), this.CargarPartes()])
        .then(([productos, partes]) => {
          this.productos = productos;
          this.partes = partes;
          this.detallesPlacas = this.agruparPartes(partes);
        })
        .catch((error) => {
          console.error("Error in search:", error);
        })
        .finally(() => {
          this.isLoading = false;
        });
    },
    agruparPartes(partes) {
      // Agrupar las partes según sea necesario y devolver la estructura de datos agrupada
      return partes.reduce((acc, parte) => {
        const cmAgrupacion = parte.cm_agrupacion;
        const index = acc.findIndex(
          (item) => item.cm_agrupacion === cmAgrupacion
        );
        if (index >= 0) {
          acc[index].placas_total += parte.placas_total;
        } else {
          acc.push({
            cm_agrupacion: cmAgrupacion,
            placas_total: parte.placas_total,
          });
        }
        return acc;
      }, []);
    },
    calculateTotalCm(detalle) {
      // Calcula el total de cm² para un detalle dado
      return parseFloat(detalle.cm_agrupacion) * detalle.placas_total;
    },
  },
  computed: {
    // Calcula el total general de cm² para todas las placas
    calculateGrandTotal() {
      return this.detallesPlacas.reduce(
        (total, detalle) =>
          total + parseFloat(detalle.cm_agrupacion) * detalle.placas_total,
        0
      );
    },
  },
  filters: {
    formatDate(value) {
      if (!value) return "";
      const date = new Date(value);
      return date.toLocaleDateString();
    },
  },
  mounted() {
    this.loadFrentes();
    this.loadOts();
  },
};
</script>

<style scoped>
.upSelect {
  font-weight: bold;
}
.downSelect {
  color: #555;
  font-size: 12px;
}
.pointer {
  cursor: pointer;
}
.v-select {
  width: 100%;
}
</style>