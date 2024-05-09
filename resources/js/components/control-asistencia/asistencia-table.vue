<template>
  <div>
    <div class="header">
      <button class="btn btn-enod" @click="agregarNuevo" style="background-color: rgb(255, 204, 0); color: rgb(0, 0, 0);" :disabled="!$can('S_compras_edita')">
        <span class="fa fa-plus-circle"></span> Nuevo
      </button>
    </div>
    <div class="box box-custom-enod">
      <!-- Botón Nuevo en la parte superior -->
  
      <!-- Tabla de Items -->
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead>
              <tr>
                  <th>Frente</th>
                  <th>Fecha</th>
                  <th>Acciones</th>
              </tr>
          </thead>
          <tbody>
            <tr v-for="item in items" :key="item.id">
                <td>{{ item.frente ? item.frente.codigo : 'No disponible' }}</td>
                <td>{{ item.fecha }}</td>
                <td>
                    <button class="btn btn-info" @click="editar(item)">Editar</button>
                    <button class="btn btn-secondary" @click="copiar(item)">Copiar</button>
                </td>
            </tr>
          </tbody>
      </table>
      </div>
  
      <!-- Paginación -->
      <div class="pagination">
        <button @click="changePage(currentPage - 1)" :disabled="currentPage <= 1">Anterior</button>
        <button @click="changePage(currentPage + 1)" :disabled="currentPage >= pageCount">Siguiente</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      items: [],
      pagination: {},
      currentPage: 1,
      pageCount: 0, // Inicializando pageCount aquí
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
    window.location.href = `/asistencia/edit/${item.id}`; // Asegúrate de que la URL esté correcta según tu configuración de rutas
  },
    copiar(item) {
      // Lógica para copiar un item
    },
    changePage(page) {
      if (page > 0 && page <= this.pageCount) {
        this.fetchData(page);
      }
    },
    fetchData(page) {
      axios.get(`/api/area/enod/asistencia?page=${page}`)
        .then(response => {
          this.items = response.data.data;
          this.pagination = response.data;
          this.currentPage = page;
          this.pageCount = response.data.last_page; // Asegurarse de actualizar pageCount aquí
        })
        .catch(error => {
          console.error('Error al cargar los datos:', error);
        });
    }
  }
}
</script>
<style scoped>
.box {
  border: 1px solid #ddd;
  padding: 20px;
  margin-top: 20px;
}

.header {
  margin-bottom: 20px;
}

.table-responsive {
  overflow-x: auto;
}

.pagination {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}

.btn-enod {
  background-color: rgb(255, 204, 0);
  color: rgb(0, 0, 0);
}

@media (max-width: 768px) {
  .btn-enod {
    width: 100%;
    margin-bottom: 10px;
  }
}
</style>