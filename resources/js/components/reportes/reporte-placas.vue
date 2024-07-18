<template>
  <div class="row">
    <!-- Col-md-3 parte (filtro) -->
    <div class="col-md-3">
      <div class="box box-custom-enod">
        <div class="box-body box-profile">
          <ul class="list-group list-group-unbordered">
            <li class="list-group-item pointer">
              <div v-show="!selFrente">
                <span class="titulo-li">Frente ID</span>
                <a @click="selFrente = !selFrente" class="pull-right">
                  <div v-if="selectedFrentes.length">
                    <div v-for="frente in selectedFrentes" :key="frente.id">{{ frente.numero }}</div>
                  </div>
                  <div v-else>
                    <span class="seleccionar">Seleccionar</span>
                  </div>
                </a>
              </div>
              <v-select
                multiple
                v-show="selFrente"
                v-model="selectedFrentes"
                :options="frentes"
                label="numero"
                @input="CargarForFrente"
              ></v-select>
            </li>
            <!-- Selección de fecha desde -->
            <li class="list-group-item">
              <date-picker
                v-model="fechaDesde"
                value-type="YYYY-MM-DD"
                format="DD-MM-YYYY"
                :disabled="!selectedFrentes.length"
              ></date-picker>
            </li>
            <!-- Selección de fecha hasta -->
            <li class="list-group-item">
              <date-picker
                v-model="fechaHasta"
                value-type="YYYY-MM-DD"
                format="DD-MM-YYYY"
                :disabled="!selectedFrentes.length"
              ></date-picker>
            </li>
          </ul>
          <!-- Botón de búsqueda -->
          <button
            @click="Buscar"
            class="btn btn-enod btn-block"
            :disabled="selectedFrentes.length === 0 || !fechaDesde || !fechaHasta"
          >
            <span class="fa fa-search"></span> Buscar
          </button>
        </div>
      </div>
    </div>
    <!-- Col-md-9 Resultados -->
    <div class="col-md-9">
      <!-- Si hay informes para mostrar -->
      <div v-if="tablaInformes && tablaInformes.length > 0">
        <div class="box box-custom-enod">
          <div class="box-header with-border">
            <h3 class="box-title">Detalle</h3>
          </div>
          <div class="box-body">
            <div class="table-responsive table-scroll">
              <table class="table table-striped table-condensed">
                <thead>
                  <tr>
                    <th>Parte</th>
                    <th>Total de M Usados</th>
                    <th>Total de Placas</th>
                    <th>Fecha</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="informe in tablaInformes" :key="informe.parte">
                    <td>{{ formatParteId(informe.parte) }}</td>
                    <td>{{ formatMetros(informe.totalCMFinal) }}</td>
                    <td>{{ informe.totalPlacasUsadas }}</td>
                    <td>{{ formatFecha(informe.fecha) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- Si no hay informes para mostrar -->
      <div v-else-if="tablaInformes !== null && tablaInformes.length === 0">
        <div class="box box-custom-enod">
          <div class="box-body">
            <h4>No hay datos para mostrar</h4>
          </div>
        </div>
      </div>
      <!-- Loader mientras se cargan los datos -->
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
  props: ['user'],
  components: { vSelect, Loading, 'date-picker': Datepicker },
  data() {
    return {
      selectedFrentes: [],
      frentes: [],
      fechaDesde: null,
      fechaHasta: null,
      tablaInformes: [],
      parteList: [],
      isLoading: false,
      selFrente: false,
    };
  },
  methods: {
    async loadFrentes() {
      try {
        const response = await axios.get('/api/reporte-placas/ots');
        this.frentes = response.data.map(ot => ({
          id: ot.id,
          numero: ot.numero,
          proyecto: ot.proyecto
        }));
      } catch (error) {
        console.error('Error loading frentes:', error);
      }
    },
    async loadPartes(otId) {
      try {
        const response = await axios.get(`/api/reporte-placas/partes/${otId}`);
        return response.data.map(parte => ({
          id: parte.id,
          created_at: parte.created_at,
          placas_repetidas: parte.placas_repetidas ? parseInt(parte.placas_repetidas, 10) : 0,
          placas_testigos: parte.placas_testigos ? parseInt(parte.placas_testigos, 10) : 0
        }));
      } catch (error) {
        console.error('Error loading partes:', error);
        return [];
      }
    },
    async CargarForFrente() {
      this.parteList = [];
      for (const frente of this.selectedFrentes) {
        const partes = await this.loadPartes(frente.id);
        this.parteList.push(...partes);
      }
      console.log(this.parteList);
    },
    async Buscar() {
      if (this.selectedFrentes.length === 0 || !this.fechaDesde || !this.fechaHasta) {
        return;
      }

      this.isLoading = true;
      this.tablaInformes = [];
      const fechaDesdeFormatted = new Date(this.fechaDesde).toISOString().split('T')[0];
      const fechaHastaFormatted = new Date(this.fechaHasta).toISOString().split('T')[0];

      try {
        for (const parte of this.parteList) {
          const response = await axios.get(`/api/reporte-placas/informes-ri/${parte.id}/${fechaDesdeFormatted}/${fechaHastaFormatted}`);
          if (response.data && response.data.informes && response.data.informes.length > 0) {
            let totalCMFinal = { width: 0, height: 0 };
            let totalPlacasUsadas = 0;

            response.data.informes.forEach(informe => {
              const [width, height] = informe.cm_final.split('x').map(Number);
              totalCMFinal.width += width;
              totalCMFinal.height += height;
              totalPlacasUsadas += parseInt(informe.placas_final, 10);
            });

            totalPlacasUsadas += parte.placas_repetidas + parte.placas_testigos;

            this.tablaInformes.push({
              parte: parte.id,
              fecha: parte.created_at,
              totalCMFinal: `${totalCMFinal.width}x${totalCMFinal.height}`,
              totalPlacasUsadas
            });
          }
        }
      } catch (error) {
        console.error('Error fetching informes:', error);
      } finally {
        this.isLoading = false;
      }
    },
    formatFecha(fecha) {
      return new Date(fecha).toLocaleDateString('es-AR');
    },
    formatParteId(parteId) {
      return parteId.toString().padStart(3, '0');
    },
    formatMetros(totalCMFinal) {
      const [width, height] = totalCMFinal.split('x').map(num => parseFloat(num) / 100);
      return `${width.toFixed(2)}x${height.toFixed(2)} m`;
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