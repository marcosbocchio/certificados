<template>
  <div>
    <!-- Box para Editar Stock -->
    <div class="box box-custom-enod">
      <div class="box-body">
        <!-- Fila para Fecha, Cantidad de Ajuste y Stock Actual -->
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="fecha_ajuste">Fecha *</label>
              <date-picker v-model="fecha_ajuste" value-type="YYYY-MM-DD" format="DD-MM-YYYY" placeholder="DD-MM-YYYY" disabled></date-picker>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="cantidad_ajuste">Cantidad de Ajuste *</label>
              <input type="number" v-model="cantidad_ajuste" class="form-control" id="cantidad_ajuste">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="stock_actual">Stock Actual *</label>
              <input type="number" :value="stock_actual" class="form-control" id="stock_actual" disabled>
            </div>
          </div>
        </div>

        <!-- Fila para Observaciones -->
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="observaciones_ajuste">Observaciones</label>
              <input type="text" v-model="observaciones_ajuste" class="form-control" id="observaciones_ajuste" maxlength="200">
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Botón Ajustar Stock fuera del box y alineado a la izquierda -->
    <div class="row">
      <div class="col-md-12 text-left">
        <button @click="ajustarStock" class="btn btn-primary" :disabled="ajusteEnProceso">Ajustar Stock</button>
      </div>
    </div>
  </div>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import toastr from 'toastr';
import axios from 'axios';

export default {
  props: {
    producto: {
      type: Object,
      default: () => ({}),
    },
  },
  mounted() {
    if (this.producto) {
      console.log('this.producto', this.producto);
    }
  },
  watch: {
    producto(newValue) {
      if (newValue) {
        this.cantidad_ajuste = 0; // Resetea la cantidad de ajuste cuando cambia el producto
      }
    },
  },
  components: {
    DatePicker,
  },
  data() {
    return {
      fecha_ajuste: new Date().toISOString().slice(0, 10),
      observaciones_ajuste: '',
      cantidad_ajuste: 0,
      tipo_movimiento: 'Ajuste stock',
      ajusteEnProceso: false,
    };
  },
  computed: {
    stock_actual() {
      // Asegúrate de manejar correctamente valores nulos o undefined para producto.stock
      let baseStock = this.producto && this.producto.stock ? this.producto.stock : 0;
      let nuevoStock = parseInt(baseStock) + parseInt(this.cantidad_ajuste);
      return isNaN(nuevoStock) ? 0 : nuevoStock;
    }
  },
  methods: {
    ajustarStock() {

      if (this.stock_actual < 0) {
      toastr.error('El stock no puede ser negativo.');
      return; // Detiene la ejecución adicional del método
      }
      this.ajusteEnProceso = true;
      const url = '/api/stock/edit';
      const ajuste = {
        fecha: this.fecha_ajuste,
        observaciones: this.observaciones_ajuste,
        cantidad: this.cantidad_ajuste,
        producto_id: this.producto.id,
        tipo_movimiento: this.tipo_movimiento,
        stock: this.stock_actual, // Usa directamente el valor computado
      };

      axios.post(url, ajuste)
        .then(response => {
          toastr.success('Ajuste guardado con éxito');
          window.location.href = '/area/enod/stock-total';
        })
        .catch(error => {
          this.ajusteEnProceso = false;
        });
    },
  },
};
</script>
  
  <style scoped>
  /* Tus estilos */
  </style>