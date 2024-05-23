<template>
  <div>
    <div class="row">
      <div class="col-md-12">
        <div class="box box-custom-enod top-buffer">
          <div class="box-header with-border">
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          
          <div class="box-body">
            <button class="btn btn-enod" @click="agregarNuevo" :disabled="!$can('A_asistencia_edit')">
              <span class="fa fa-plus-circle"></span> Nuevo
            </button>
            <div class="table-responsive top-buffer">
              <table class="table table-hover table-striped table-condensed">
                <thead>
                  <tr>
                    <th>Frente</th>
                    <th>Fecha</th>
                    <th style="text-align: center;" colspan="2">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in items" :key="item.id">
                    <td>{{ item.frente ? item.frente.codigo : 'No disponible' }}</td>
                    <td>{{ item.fecha }}</td>
                    <td width="10px">
                      <button class="btn btn-warning btn-sm" @click="editar(item)" title="Editar">
                        <i class="fa fa-pencil"></i>
                      </button>
                    </td>
                    <td width="10px">
                      <button class="btn btn-default btn-sm" @click="copiar(item)" title="Copiar">
                        <i class="fa fa-copy"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <pagination
              :data="pagination"
              @pagination-change-page="fetchData">
              <span slot="prev-nav">&lt; Anterior</span>
              <span slot="next-nav">Siguiente &gt;</span>
            </pagination>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      items: [],
      pagination: {},
      currentPage: 1,
    };
  },
  mounted() {
    this.fetchData(this.currentPage);
  },
  methods: {
    agregarNuevo() {
      window.location.href = '/area/enod/asistencia-nuevo';
    },
    editar(item) {
      window.location.href = `/asistencia/edit/${item.id}`;
    },
    copiar(item) {
      window.location.href = `/asistencia/copia/${item.id}`;
    },
    fetchData(page = 1) {
      const params = { page };
      axios.get('/api/area/enod/asistencia', { params })
        .then(response => {
          this.items = response.data.data;
          this.pagination = response.data;
          this.currentPage = page;
        })
        .catch(error => {
          console.error('Error al cargar los datos:', error);
        });
    }
  }
}
</script>

<style scoped>
.top-buffer {
  margin-top: 20px;
}
</style>