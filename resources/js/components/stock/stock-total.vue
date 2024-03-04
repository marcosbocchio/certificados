<template>
  <div v-if="productos.length">
    <button @click="exportarTodoPDF" class="btn btn-enod exportar-todo-pdf" :disabled="!$can('M_stock_edita')">Exportar PDF</button>
    <div class="box box-custom-enod">
      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-hover table-striped table-condensed">
            <thead>
              <tr style="width: 100%;">
                <th style="width: 45%;">Producto</th>
                <th style="width: 45%;">Stock</th>
                <th colspan="2" style="width: 5%;">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="producto in productos" :key="producto.id">
                <td>{{ producto.descripcion }}</td>
                <td>{{ producto.stock }}</td>
                <td width="10px">
                  <button @click="editProducto(producto)" class="btn btn-warning btn-sm" title="Editar" :disabled="!$can('M_stock_edita')">
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
      </div>
    </div>
    <pagination
      :data="pagination"
      @pagination-change-page="getResults">
      <span slot="prev-nav">&lt; Anterior</span>
      <span slot="next-nav">Siguiente &gt;</span>
    </pagination>
  </div>
</template>

<script>
export default {
  data() {
    return {
      productos: [],
      pagination: {},
    };
  },
  mounted() {
    this.loadProductos();
  },
  methods: {
    loadProductos(page = 1) {
      axios.get(`/api/stock/paginatestock?page=${page}`)
        .then(response => {
          // Actualiza productos con la respuesta paginada
          this.productos = response.data.data;
          this.pagination = response.data;
        })
        .catch(error => {
          console.error('API error:', error);
        });
    },
    registroProducto(producto) {
      window.location.href = `/area/enod/stock-registro/${producto.id}`;
    },
    editProducto(producto) {
      window.location.href = `/area/enod/stock-edit/${producto.id}`;
    },
    exportarTodoPDF() {
      window.open('/imprimir-todo-stock', '_blank');
    },
    getResults(page = 1) {
      this.loadProductos(page);
    },
  },
};
</script>

<style scoped>
.exportar-todo-pdf {
  margin-bottom: 20px;
}
</style>