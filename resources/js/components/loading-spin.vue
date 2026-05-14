<template>
    <div class="loading-container">
      <i class="fas fa-spinner fa-spin" style="color:#4F8CFF"></i>
    </div>
  </template>
  
  <style scoped>
  .loading-container {
    display: flex;
    align-items: flex-start; /* Alinea verticalmente al inicio */
    justify-content: center; /* Centra horizontalmente (opcional) */
    margin-top: 12vh;
    width: 100%;
    height: 100%; /* Asegúrate de que el contenedor ocupe el espacio deseado */
  }
  .loading-container i {
  font-size: 5vh; /* Ajusta el tamaño a lo que requieras */
  color: #4F8CFF;
}
  </style>
  