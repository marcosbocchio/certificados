<template>
    <div>
      <!-- Botón de agregar -->
      <button class="btn btn-primary" @click="agregarNuevo">
        <i class="fa fa-plus"></i> Agregar
      </button>
  
      <!-- Tabla -->
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
            <td>{{ item.frente }}</td>
            <td>{{ item.fecha }}</td>
            <td>
              <!-- Botón de editar -->
              <button class="btn btn-sm btn-info" @click="editar(item)">
                Editar
              </button>
              <!-- Botón de copiar -->
              <button class="btn btn-sm btn-secondary" @click="copiar(item)">
                Copiar
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        items: [
          // Aquí irán los datos de tus items
        ]
      };
    },
    methods: {
      agregarNuevo() {
        // Lógica para agregar un nuevo item
      },
      editar(item) {
        // Lógica para editar un item
      },
      copiar(item) {
        // Lógica para copiar un item
      }
    }
  }
  </script>
  
  <style scoped>
  /* Tus estilos aquí */
  </style>