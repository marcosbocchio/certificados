<template>
  <div class="box box-custom-enod top-buffer">
    <div class="box-body">
      <div class="table-responsive">
        <table class="table table-hover table-striped table-condensed">
          <thead>
            <tr>
              <th>Código</th>
              <th>Descripción</th>
              <th style="text-align: center">Unidad Medida</th>
              <th style="text-align: center">Visible OT</th>
              <th style="text-align: center">Stock</th>
              <th colspan="2">&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="registro in registros.data" :key="registro.id">
              <td>{{ registro.codigo }}</td>
              <td>{{ registro.descripcion }}</td>
              <td style="text-align: center">{{ registro.unidad_medidas.codigo }}</td>     
              <td style="text-align: center">
                <div v-if="registro.visible_ot">
                  SI
                </div>   
                <div v-else>
                  NO   
                </div>             
              </td>
              <td style="text-align: center">{{ registro.stock }}</td>
              <td width="10px">
                <button class="btn btn-warning btn-sm" title="Editar" @click.prevent="updateValue(registro)" :disabled="!$can('M_productos_edita')">
                  <span class="fa fa-edit"></span>
                </button>
              </td>
              <td width="10px">
                <button class="btn btn-danger btn-sm" title="Eliminar" @click.prevent="$emit('confirmarDelete', registro, registro.codigo)" :disabled="!$can('M_productos_edita')">
                  <span class="fa fa-trash"></span>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <nav aria-label="Page navigation">
        <ul class="pagination">
          <li class="page-item" :class="{ disabled: !registros.prev_page_url }">
            <a class="page-link" href="#" @click.prevent="fetchData(registros.prev_page_url)">Previous</a>
          </li>
          <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: registros.current_page === page }">
            <a class="page-link" href="#" @click.prevent="fetchData(page)">{{ page }}</a>
          </li>
          <li class="page-item" :class="{ disabled: !registros.next_page_url }">
            <a class="page-link" href="#" @click.prevent="fetchData(registros.next_page_url)">Next</a>
          </li>
        </ul>
      </nav>
    </div>
    <div v-if="loading" class="overlay">
      <loading-spin></loading-spin>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      registros: {},
      loading: true,
      currentPage: 1,
    };
  },
  props: {
    loading: {
      type: Boolean,
      required: true,
    },
  },
  computed: {
    totalPages() {
      return this.registros.last_page || 1;
    },
  },
  created() {
    this.fetchData(this.currentPage);
  },
  methods: {
    fetchData(page) {
      this.loading = true;
      const url = typeof page === 'string' ? page : `/api/frentesAsignacion/paginate?page=${page}`;
      axios.get(url)
        .then(response => {
          this.registros = response.data;
          this.currentPage = this.registros.current_page;
        })
        .finally(() => {
          this.loading = false;
        });
    },
    updateValue(registro) {
      this.$emit('editar', registro);
    }
  }
};
</script>

<style scoped>
/* Tu CSS aquí */
</style>