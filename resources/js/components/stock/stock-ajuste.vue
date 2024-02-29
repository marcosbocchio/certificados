<template>
  <div>
    <!-- Box para Datos Generales de la Compra -->
    <div class="box box-custom-enod">
      <div class="box-body">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label for="fecha_remito">Fecha *</label>
              <date-picker v-model="fecha_remito" value-type="YYYY-MM-DD" format="DD-MM-YYYY" placeholder="DD-MM-YYYY" :disabled="true"></date-picker>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="prefijo">Prefijo N° *</label>
              <input type="number" v-model="prefijo" class="form-control" id="prefijo" disabled />
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="numero">Remito N° *</label>
              <input type="number" v-model="numero" class="form-control" id="numero" disabled />
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="proveedor">Proveedor *</label>
              <v-select v-model="proveedorSeleccionado" :options="proveedores" label="razon_social" :disabled="true"></v-select>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label>Observaciones</label>
              <input type="text" v-model="observaciones" class="form-control" id="observaciones" maxlength="200" disabled>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Box para Productos y Cantidades -->
    <div class="box box-custom-enod">
      <div class="box-body">
        <div class="row">
          <div class="col-md-8">
            <div class="form-group">
              <label for="producto">Productos</label>
              <v-select v-model="productoSeleccionado" :options="productos" label="descripcion" :disabled="true"></v-select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Cant.</label>
              <input v-model="cantidad" type="number" class="form-control" id="cantidad" placeholder="" disabled>
            </div>
          </div>
        </div>
        <!-- Sección para agregar productos eliminada -->
        <div v-show="productosAgregados.length">
          <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered table-condensed">
              <thead>
                <tr>
                  <th>Producto</th>
                  <th>Cantidad</th>
                  <!-- Columna de acción eliminada -->
                </tr>
              </thead>
              <tbody>
                <tr v-for="(productoAgregado, index) in productosAgregados" :key="index">
                  <td>{{ productoAgregado.producto }}</td>
                  <td>{{ productoAgregado.cantidad }}</td>
                  <!-- Botón de acción eliminado -->
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- Botón de guardar eliminado -->
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
    },props: {
    productoP: Object,
    compraDetalleP: Array,
    proveedoresP: Array,
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
        fecha_remito: '',
        observaciones: '',
      };
    },
    created() {
      this.getProveedores();
      this.getProductos();
      this.cargarDatosIniciales();
    },
    methods: {
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
      cargarDatosIniciales() {
    this.fecha_remito = this.productoP.fecha_remito; // Ajuste a camelCase si es necesario
    const [prefijo, numero] = this.productoP.numero_remito.split('-');
    this.prefijo = prefijo;
    this.numero = numero;
    this.observaciones = this.productoP.obs;
    this.proveedorSeleccionado = this.proveedoresP.find(p => p.id === this.productoP.proveedor_id); // Ajuste según el objeto real
    this.productosAgregados = this.compraDetalleP.map(detalle => {
    return {
      producto: detalle.producto_id,
      cantidad: detalle.cantidad
    };
  });
},
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
    const url = '/api/stock'; // Asegúrate de que esta sea la URL correcta
    const compra = {
      fecha: this.fecha,
      fecha_remito: this.fecha_remito,
      proveedor_id: this.proveedorSeleccionado ? this.proveedorSeleccionado.id : null,
      numero_remito: `${this.prefijo}-${this.numero}`,
      obs: this.observaciones,
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
        }
      }
    } else {
      console.error('Error al guardar la compra:', error);
      toastr.error('Error interno del servidor');
    }
  });
},
    }
  };
  </script>
  <style scoped>
  .box.box-custom-enod {
    padding: 20px;
  }
  .boton-centrado {
  display: flex;
  justify-content: center;
  align-items: center;}

  </style>