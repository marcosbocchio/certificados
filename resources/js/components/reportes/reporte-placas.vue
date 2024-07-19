<template>
  <div class="row">
    <div class="col-md-3">
      <div class="box box-custom-enod">
        <div class="box-body box-profile">
          <ul class="list-group list-group-unbordered">
            <li class="list-group-item pointer">
              <span class="titulo-li">Frente</span>
              <v-select
                multiple
                v-model="selectedFrentes"
                :options="frentes"
                label="codigo"
                @input="CargarRemitos"
              ></v-select>
            </li>
            <li class="list-group-item">
              <date-picker
                v-model="fechaDesde"
                value-type="YYYY-MM-DD"
                format="DD-MM-YYYY"
              ></date-picker>
            </li>
            <li class="list-group-item">
              <date-picker
                v-model="fechaHasta"
                value-type="YYYY-MM-DD"
              ></date-picker>
            </li>
            <li class="list-group-item pointer">
              <span class="titulo-li">Remito</span>
              <v-select
                multiple
                v-model="selectedRemitos"
                :options="remitos"
                label="formatted"
                :disabled="!selectedFrentes.length || !fechaDesde || !fechaHasta"
              ></v-select>
            </li>
          </ul>
          <button
            @click="Buscar"
            class="btn btn-enod btn-block"
            :disabled="selectedRemitos.length === 0 || !fechaDesde || !fechaHasta"
          >
            <span class="fa fa-search"></span> Buscar
          </button>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div v-if="productos.length > 0">
        <div class="box box-custom-enod">
          <div class="box-header with-border">
            <h3 class="box-title">Productos Relacionados</h3>
          </div>
          <div class="box-body">
            <ul>
              <li v-for="producto in productos" :key="producto.producto_id">
                {{ producto.descripcion }} - {{ producto.cantidad }}
              </li>
            </ul>
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
      <loading
        :active.sync="isLoading"
        :loader="'bars'"
        :color="'red'"
      ></loading>
    </div>
  </div>
</template>

<script>
import vSelect from 'vue-select';
import Datepicker from 'vuejs-datepicker';
import 'vue-select/dist/vue-select.css';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import axios from 'axios';

export default {
  components: { vSelect, Loading, 'date-picker': Datepicker },
  data() {
    return {
      selectedFrentes: [],
      frentes: [],
      selectedRemitos: [],
      remitos: [],
      productos: [],
      fechaDesde: null,
      fechaHasta: null,
      isLoading: false,
    };
  },
  methods: {
    async loadFrentes() {
      try {
        const response = await axios.get('/api/reporte-placas/frentes');
        this.frentes = response.data;
      } catch (error) {
        console.error('Error loading frentes:', error);
      }
    },
    async CargarRemitos() {
      this.selectedRemitos = [];
      this.productos = [];
      if (this.selectedFrentes.length > 0 && this.fechaDesde && this.fechaHasta) {
        try {
          const response = await axios.get('/api/reporte-placas/remitos', {
            params: {
              frentes_selected: this.selectedFrentes.map(frente => frente.id),
              fecha_desde: this.fechaDesde,
              fecha_hasta: this.fechaHasta
            }
          });
          this.remitos = response.data.map(remito => ({
            ...remito,
            formatted: `${remito.prefijo}-${remito.numero.padStart(8, '0')}`
          }));
        } catch (error) {
          console.error('Error loading remitos:', error);
        }
      }
    },
    async CargarProductos() {
      this.productos = [];
      if (this.selectedRemitos.length > 0) {
        try {
          const response = await axios.post('/api/reporte-placas/remitos-productos', {
            ids_remitos: this.selectedRemitos.map(remito => remito.id)
          });
          const productos = response.data;
          const resumenResponse = await axios.post('/api/reporte-placas/resumen-productos', {
            lista_productos: productos
          });
          this.productos = resumenResponse.data;
        } catch (error) {
          console.error('Error loading productos:', error);
        }
      }
    },
    Buscar() {
      this.CargarProductos();
    }
  },
  mounted() {
    this.loadFrentes();
  }
};
</script>

<style scoped>
/* Estilos específicos del componente */
</style>