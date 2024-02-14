<template>
    <div>
      <div class="box box-custom-enod">
        <div class="box-header">
          <h3 class="box-title">Gestión de Stock</h3>
          <div class="box-tools">
            <a :href="'/area/enod/stock/create'" class="btn btn-primary pull-right">
              <i class="fa fa-plus-circle"></i> Nuevo
            </a>
          </div>
        </div>
        <div class="box-body">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Observaciones</th>
                <th>Cantidad</th>
                <th>Stock Actual</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in stockItems" :key="item.id">
                <td>{{ item.id }}</td>
                <td>{{ item.fecha }}</td>
                <td>{{ item.obs }}</td>
                <td>{{ item.cantidad }}</td>
                <td>{{ item.stock }}</td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        stockItems: []
      };
    },
    created() {
      this.fetchStockItems();
    },
    methods: {
        fetchStockItems() {
  axios.get('/api/stock').then(response => {
    // Asegúrate de acceder a la propiedad 'data' dentro de la respuesta de paginación
    this.stockItems = response.data.data; // Accede a 'data.data' para obtener la lista de elementos
  }).catch(error => {
    console.error(error);
  });
}
    }
  }
  </script>
  
  <style scoped>
  /* Tus estilos aquí */
  </style>