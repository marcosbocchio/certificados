<template>
    <div class="loading-container">
      <i class="fa fas fa-radiation-alt fa-spin" style="color:#F9CA33"></i>
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
  color: #F9CA33;
}
  </style>
  