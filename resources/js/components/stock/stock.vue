<template>
  <div>
    <!-- Box para Datos Generales de la Compra -->
    <div class="box box-custom-enod">
      <div class="box-body">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label for="fecha_remito">Fecha *</label>
              <date-picker v-model="fecha_remito" value-type="YYYY-MM-DD" format="DD-MM-YYYY" placeholder="DD-MM-YYYY"></date-picker>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="prefijo">Prefijo N° *</label>
              <input type="number" v-model="prefijo" class="form-control" id="prefijo" @change="formatearPrefijo(prefijo, 4)" min="1" max="9999"/>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="numero">Remito N° *</label>
              <input type="number" v-model="numero" class="form-control" id="numero" @change="formatearNumero(numero, 8)" min="1" max="99999999"/>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="proveedor">Proveedor *</label>
              <v-select v-model="proveedorSeleccionado" :options="proveedores" label="razon_social" @input="proveedor = proveedorSeleccionado ? proveedorSeleccionado.id : ''"></v-select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label>Observaciones</label>
              <input type="text" v-model="obs" class="form-control" id="observaciones" maxlength="200">
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Box para Productos y Cantidades -->
    <div class="box box-custom-enod">
      <div class="box-body">
        <div class="row">
          <div class="col-md-9">
            <div class="form-group">
              <label for="producto">Productos</label>
              <v-select v-model="productoSeleccionado" :options="productos" label="descripcion"></v-select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label>Cant.</label>
              <input v-model="cantidad" type="number" class="form-control" id="cantidad" placeholder="" min="1">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <!-- Botón para agregar producto con solo un icono de cruz -->
            <button type="button" @click="addProducto()"><span class="fa fa-plus-circle"></span></button>
          </div>
        </div>
        <div v-show="productosAgregados.length" style="margin-top: 10px;">
          <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered table-condensed">
              <thead>
                <tr style="width: 100%;">
                  <th style="width: 74%;">Producto</th>
                  <th style="width: 12.5%;">Cantidad</th>
                  <th style="width: 12.5%;">Acción</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(productoAgregado, index) in productosAgregados" :key="index">
                  <td>{{ descripcionDelProducto(productoAgregado.producto) }}</td>
                  <td>{{ productoAgregado.cantidad }}</td>
                  <td class="text-center"><i @click="removeProducto(index)" class="fa fa-minus-circle"></i></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 text-right">
        <button @click="guardarCompra" class="btn btn-primary" :disabled="formularioEnviado">Guardar</button>
      </div>
    </div>
  </div>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import moment from 'moment';
import toastr from 'toastr';
import axios from 'axios';

export default {
  components: {
    DatePicker,
    'v-select': vSelect
  },
  data() {
    return {
      fecha: moment().format('YYYY-MM-DD'),
      prefijo: '',
      numero: '',
      proveedorSeleccionado: null,
      receptor: '',
      cantidad: 1,
      proveedores: [],
      productos: [],
      productoSeleccionado: null,
      productosAgregados: [],
      proveedor: '',
      producto: '',
      fecha_remito: new Date().toISOString().slice(0, 10),
      obs: '',
      formularioEnviado: false,
    };
  },
  created() {
    this.getProveedores();
    this.getProductos();
  },
  methods: {
    formatearPrefijo(number, width) {
      width -= number.toString().length;
      if (width > 0) {
        this.prefijo = new Array(width + (/\./.test(number) ? 2 : 1)).join('0') + number;
      }
    },
    formatearNumero(number, width) {
      width -= number.toString().length;
      if (width > 0) {
        this.numero = new Array(width + (/\./.test(number) ? 2 : 1)).join('0') + number;
      }
    },
    getProductos() {
      axios.get('/api/productos/stockeable').then(response => {
        this.productos = response.data;
      });
    },
    getProveedores() {
      axios.get('/api/proveedores').then(response => {
        this.proveedores = response.data;
      });
    },
    addProducto() {
      if (!this.productoSeleccionado) {
        toastr.error('Selecciona un producto.');
        return;
      }
      if (this.productosAgregados.some(p => p.producto === this.productoSeleccionado.id)) {
        toastr.error('El producto ya ha sido agregado.');
        return;
      }
      if (!this.cantidad || this.cantidad <= 0) {
        toastr.error('La cantidad debe ser mayor a cero.');
        return;
      }
      this.productosAgregados.push({
        producto: this.productoSeleccionado.id,
        cantidad: this.cantidad
      });
      this.productoSeleccionado = null;
      this.cantidad = 1;
    },
    removeProducto(index) {
      this.productosAgregados.splice(index, 1);
    },
    guardarCompra() {
      // Asegúrate de que todos los campos requeridos están presentes
      if (this.validarCompra()) {
        this.formularioEnviado = true;
        const url = '/api/stock'; // Asegúrate de que esta sea la URL correcta
        const compra = {
          fecha: this.fecha,
          fecha_remito: this.fecha_remito,
          proveedor_id: this.proveedorSeleccionado ? this.proveedorSeleccionado.id : null,
          numero_remito: `${this.prefijo}-${this.numero}`,
          obs: this.obs,
          tipo_movimiento: `Remito compra  N° ${this.prefijo}-${this.numero}`,
          detalles: this.productosAgregados.map(producto => ({
            producto_id: producto.producto,
            cantidad: producto.cantidad,
          })),
        };

        axios.post(url, compra)
          .then(response => {
            toastr.success('Compra guardada con éxito');
            window.location.href = '/area/enod/stock-table';
          })
          .catch(error => {
            if (error.response && error.response.status === 422) {
              // Aquí puedes obtener el objeto de errores de la respuesta y mostrarlos
              const errors = error.response.data.errors;
              for (const key in errors) {
                if (errors.hasOwnProperty(key)) {
                  // Muestra el primer error de cada campo
                  toastr.error(errors[key][0]);
                  this.formularioEnviado = false
                }
              }
            } else {
              this.formularioEnviado = false;
              console.error('Error al guardar la compra:', error);
              toastr.error('Error interno del servidor');
            }
          });
      }
    },
    validarCompra() {
      if (!this.fecha_remito || !this.proveedor || !this.prefijo || !this.numero) {
        toastr.error('Por favor completa todos los campos requeridos.');
        return false;
      }
      return true;
    },
    descripcionDelProducto(productoId) {
      const producto = this.productos.find(p => p.id === productoId);
      return producto ? producto.descripcion : 'Descripción no disponible'; // Devuelve la descripción si el producto existe
    },
  },
};
</script>

<style scoped>
.box.box-custom-enod {
  padding: 20px;
}
.boton-centrado {
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>