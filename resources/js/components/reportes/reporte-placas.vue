<template>
  <div class="row">
    <!-- Col-md-3 parte (filtro) -->
    <div class="col-md-3">
      <div class="box box-custom-enod">
        <div class="box-body box-profile">
          <ul class="list-group list-group-unbordered">
            <!-- Selección de frente -->
            <li class="list-group-item pointer">
              <div v-show="!selFrente">
                <span class="titulo-li">Frente ID</span>
                <a @click="selFrente = !selFrente" class="pull-right">
                  <div v-if="selectedFrente">{{ selectedFrente.numero }} <br> <small>{{ selectedFrente.proyecto }}</small></div>
                  <div v-else><span class="seleccionar">Seleccionar</span></div>
                </a>
              </div>
              <v-select v-show="selFrente" v-model="selectedFrente" :options="frentes" :reduce="ot => ot.id" @input="CambioFrente">
                <template #option="option">
                  <div>
                    <strong>{{ option.numero }}</strong> <br>
                    <small>{{ option.proyecto }}</small>
                  </div>
                </template>
                <template #selected-option="option">
                  <div>
                    <strong>{{ option.numero }}</strong> <br>
                    <small>{{ option.proyecto }}</small>
                  </div>
                </template>
              </v-select>
            </li>
            <!-- Selección de fecha desde -->
            <li class="list-group-item">
              <date-picker v-model="fechaDesde" value-type="YYYY-MM-DD" format="DD-MM-YYYY" :disabled="!selectedFrente"></date-picker>
            </li>
            <!-- Selección de fecha hasta -->
            <li class="list-group-item">
              <date-picker v-model="fechaHasta" value-type="YYYY-MM-DD" format="DD-MM-YYYY" :disabled="!selectedFrente"></date-picker>
            </li>
          </ul>
          <!-- Botón de búsqueda -->
          <button @click="Buscar" class="btn btn-enod btn-block" :disabled="!selectedFrente || !fechaDesde || !fechaHasta">
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
                  <!-- Mostrar una fila con los totales -->
                  <tr v-if="totalCMFinal !== null && totalPlacasFinal !== null">
                    <td>{{ formatParteId(selectedParte) }}</td>
                    <td>{{ totalCMFinal }}</td>
                    <td>{{ totalPlacasFinal }}</td>
                    <td>{{ formatFecha(tablaInformes[0].created_at) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- Si no hay informes para mostrar -->
      <div v-else>
        <div class="box box-custom-enod">
          <div class="box-body">
            <h4>No hay datos para mostrar</h4>
          </div>
        </div>
      </div>
      <!-- Loader mientras se cargan los datos -->
      <loading :active.sync="isLoading" :loader="'bars'" :color="'red'"></loading>
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
      selectedFrente: null,
      frentes: [],
      selectedParte: null,
      fechaDesde: null,
      fechaHasta: null,
      tablaInformes: [],
      isLoading: false,
      totalCMFinal: null,
      totalPlacasFinal: null,
      selFrente: false,
    };
  },
  mounted() {
    this.loadFrentes();
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
          created_at: parte.created_at
        }));
      } catch (error) {
        console.error('Error loading partes:', error);
        return [];
      }
    },
    async Buscar() {
      if (!this.selectedFrente || !this.fechaDesde || !this.fechaHasta) return;

      this.isLoading = true;

      const fechaDesdeFormatted = this.fechaDesde.toISOString().slice(0, 10);
      const fechaHastaFormatted = this.fechaHasta.toISOString().slice(0, 10);

      console.log('Fetching informes with:', this.selectedFrente, fechaDesdeFormatted, fechaHastaFormatted);

      try {
        // Cargar todos los partes del frente seleccionado
        const partes = await this.loadPartes(this.selectedFrente.id);

        // Inicializar informes vacíos
        let informes = [];

        // Iterar sobre cada parte y cargar informes para cada uno
        for (let i = 0; i < partes.length; i++) {
          const parte = partes[i];
          const response = await axios.get(`/api/reporte-placas/informes/${parte.id}/${fechaDesdeFormatted}/${fechaHastaFormatted}`);
          informes = informes.concat(response.data.informes);
        }

        // Inicializamos los totales
        let totalCMFinal = 0;
        let totalPlacasFinal = 0;

        // Recorremos los informes para sumar los valores de cm_final y placas_usadas
        informes.forEach(informe => {
          // Suma de cm_final
          if (informe.cm_final) {
            const [a, b] = informe.cm_final.split('x').map(Number);
            totalCMFinal += a * b;
          }

          // Suma de placas_usadas
          if (informe.placas_final) {
            totalPlacasFinal += Number(informe.placas_final);
          }
        });

        // Guardamos los totales calculados
        this.totalCMFinal = totalCMFinal / 100; // Dividimos por 100 como solicitaste
        this.totalPlacasFinal = totalPlacasFinal;

        console.log('Totals:', {
          totalCMFinal: this.totalCMFinal,
          totalPlacasFinal: this.totalPlacasFinal
        });

        // Asignamos los informes a la tablaInformes del componente
        this.tablaInformes = informes;

        console.log('Informes fetched:', this.tablaInformes);
      } catch (error) {
        console.error('Error fetching informes:', error);
      } finally {
        this.isLoading = false;
      }
    },
    async CambioFrente(frenteId) {
      this.selectedFrente = this.frentes.find(frente => frente.id === frenteId);
    },
    formatParteId(id) {
      return id.toString().padStart(3, '0');
    },
    formatFecha(fecha) {
      if (typeof fecha !== 'string') {
        return fecha;
      }
      const [year, month, day] = fecha.split(' ')[0].split('-');
      return `${day}-${month}-${year}`;
    }
  }
};
</script>

<style scoped>

</style>