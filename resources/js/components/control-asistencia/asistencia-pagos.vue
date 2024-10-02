<template>
    <div>
      <!-- Tabla de Operadores -->
      <div class="box box-custom-enod">
        <div class="box-body">
          <table class="table table-hover table-striped table-condensed">
            <thead>
              <tr>
                <th class="col-md-4 text-center">Operador</th>
                <th class="col-md-4 text-center">Día</th>
                <th class="col-md-4 text-center">Horas Trabajadas</th>
                <th class="col-md-4 text-center">Seleccionar</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(operador, operadorIndex) in operadores" :key="operadorIndex">
                <!-- Operador con checkbox para seleccionar todos sus días -->
                <td :rowspan="operador.dias.length + 1">
                  <input type="checkbox" v-model="operador.seleccionarTodos" @change="toggleSeleccionarTodos(operador)">
                  {{ operador.name }}
                </td>
                <td colspan="3"></td>
              </tr>
              <!-- Lista de días trabajados por cada operador -->
              <tr v-for="(dia, diaIndex) in operador.dias" :key="diaIndex">
                <td>{{ dia.fecha }}</td>
                <td>{{ dia.horas_trabajadas }}</td>
                <td class="text-center">
                  <input type="checkbox" v-model="dia.seleccionado">
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
  
      <!-- Botón de Pagar -->
      <div class="form-actions">
        <div class="col-md-12">
          <button @click="confirmarPago" class="btn btn-enod">Pagar</button>
        </div>
      </div>
  
      <!-- Loader -->
      <loading :active.sync="isLoading" :loader="'bars'" :color="'red'"></loading>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      frentes: {
        type: Array,
        required: true
      }
    },
    data() {
      return {
        frente_selected: null,
        frentes_opciones: [],
        mes: null,
        operadores: [
          {
            name: 'Operador 1',
            seleccionarTodos: false,
            dias: [
              { fecha: '01-10-2024', horas_trabajadas: 8, seleccionado: false },
              { fecha: '02-10-2024', horas_trabajadas: 6, seleccionado: false },
            ]
          },
          {
            name: 'Operador 2',
            seleccionarTodos: false,
            dias: [
              { fecha: '01-10-2024', horas_trabajadas: 8, seleccionado: false },
              { fecha: '03-10-2024', horas_trabajadas: 5, seleccionado: false },
            ]
          }
        ],
        isLoading: false
      };
    },
    methods: {
      toggleSeleccionarTodos(operador) {
        // Al cambiar el checkbox de "Seleccionar todos", actualizamos todos los días
        operador.dias.forEach(dia => {
          dia.seleccionado = operador.seleccionarTodos;
        });
      },
      confirmarPago() {
        // Filtrar los operadores y días seleccionados para confirmar el pago
        let seleccionados = this.operadores.map(operador => {
          return {
            operador: operador.name,
            dias: operador.dias.filter(dia => dia.seleccionado)
          };
        }).filter(operador => operador.dias.length > 0);
  
        console.log('Confirmar pago para:', seleccionados);
      }
    }
  };
  </script>