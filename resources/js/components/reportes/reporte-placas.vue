<template>
    <div class="row">
      <div class="col-md-3">
        <div class="box box-custom-enod">
          <div class="box-body box-profile">
            <ul class="list-group list-group-unbordered">
              <li class="list-group-item pointer">
                <div v-show="!selFrente">
                  <span class="titulo-li">Frente ID</span>
                  <a @click="selFrente = !selFrente" class="pull-right">
                    <div v-if="frenteId">{{ frenteId }}</div>
                    <div v-else><span class="seleccionar">Seleccionar</span></div>
                  </a>
                </div>
                <v-select v-show="selFrente" v-model="frenteId" :options="frentes" @input="CambioFrente"></v-select>
              </li>
            </ul>
            <button @click="Buscar(1)" class="btn btn-enod btn-block">
              <span class="fa fa-search"></span> Buscar
            </button>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div v-if="tablaInformes && tablaInformes.length">
          <div class="box box-custom-enod">
            <div class="box-header with-border">
              <h3 class="box-title">Detalle</h3>
            </div>
            <div class="box-body">
              <div class="table-responsive table-scroll">
                <table class="table table-striped table-condensed">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Parte ID</th>
                      <th>Informe ID</th>
                      <th>Informe Importado ID</th>
                      <th>Costura Original</th>
                      <th>Costura Final</th>
                      <th>Pulgadas Original</th>
                      <th>Pulgadas Final</th>
                      <th>Placas Original</th>
                      <th>Placas Final</th>
                      <th>CM Original</th>
                      <th>CM Final</th>
                      <th>Pieza Original</th>
                      <th>Pieza Final</th>
                      <th>Nro Original</th>
                      <th>Nro Final</th>
                      <th>Observaciones Original</th>
                      <th>Observaciones Final</th>
                      <th>Metros Lineales</th>
                      <th>Created At</th>
                      <th>Updated At</th>
                      <th>Informe Sel</th>
                      <th>Número Formateado</th>
                      <th>Fecha Formateada</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(item, k) in tablaInformes" :key="k">
                      <td>{{ item.id }}</td>
                      <td>{{ item.parte_id }}</td>
                      <td>{{ item.informe_id }}</td>
                      <td>{{ item.informe_importado_id }}</td>
                      <td>{{ item.costura_original }}</td>
                      <td>{{ item.costura_final }}</td>
                      <td>{{ item.pulgadas_original }}</td>
                      <td>{{ item.pulgadas_final }}</td>
                      <td>{{ item.placas_original }}</td>
                      <td>{{ item.placas_final }}</td>
                      <td>{{ item.cm_original }}</td>
                      <td>{{ item.cm_final }}</td>
                      <td>{{ item.pieza_original }}</td>
                      <td>{{ item.pieza_final }}</td>
                      <td>{{ item.nro_original }}</td>
                      <td>{{ item.nro_final }}</td>
                      <td>{{ item.observaciones_original }}</td>
                      <td>{{ item.observaciones_final }}</td>
                      <td>{{ item.metros_lineales }}</td>
                      <td>{{ item.created_at }}</td>
                      <td>{{ item.updated_at }}</td>
                      <td>{{ item.informe_sel }}</td>
                      <td>{{ item.numero_formateado }}</td>
                      <td>{{ item.fecha_formateada }}</td>
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
        <loading :active.sync="isLoading" :loader="'bars'" :color="'red'"></loading>
      </div>
    </div>
  </template>
  
  <script>
  import vSelect from 'vue-select';
  import 'vue-select/dist/vue-select.css';
  import Loading from 'vue-loading-overlay';
  import 'vue-loading-overlay/dist/vue-loading.css';
  
  export default {
    props: ['user'],
    components: { vSelect, Loading },
    data() {
      return {
        frenteId: '11622',
        frentes: [], // Lista de IDs de frentes
        tablaInformes: [],
        isLoading: false,
        selFrente: false,
      };
    },
    methods: {
      async Buscar(page = 1) {
        if (!this.frenteId) return;
        this.isLoading = true;
        try {
          const response = await axios.get(`/api/reporte-placa/${this.frenteId}`);
          this.tablaInformes = response.data;
        } catch (error) {
          console.error(error);
        } finally {
          this.isLoading = false;
        }
      },
      CambioFrente() {
        this.selFrente = false;
      }
    }
  };
  </script>
  
  <style>
  .table-scroll {
    overflow-x: auto;
  }
  </style>