<template>
  <div>
    <!-- Modal para crear un nuevo proveedor -->
    <div class="modal fade" id="nuevoProveedor" tabindex="-1" role="dialog" aria-labelledby="nuevoProveedorLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="nuevoProveedorLabel">Nuevo Proveedor</h4>
          </div>
          <form @submit.prevent="storeProveedor">
            <div class="modal-body">
              <div class="form-group">
                <label for="cuit">CUIT *</label>
                <input v-model="nuevoProveedor.cuit" type="text" class="form-control" id="cuit" required maxlength="45">
              </div>
              <div class="form-group">
                <label for="razon_social">Razón Social *</label>
                <input v-model="nuevoProveedor.razon_social" type="text" class="form-control" id="razon_social" required maxlength="100">
              </div>
              <div class="form-group">
                <label for="email">Email *</label>
                <input v-model="nuevoProveedor.email" type="email" class="form-control" id="email" required maxlength="60">
              </div>
              <div class="form-group">
                <label for="tel">Teléfono *</label>
                <input v-model="nuevoProveedor.tel" type="text" class="form-control" id="tel" required maxlength="40">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { eventNewRegistro } from '../../event-bus';

export default {
  data() {
    return {
      nuevoProveedor: {
        cuit: '',
        razon_social: '',
        email: '',
        tel: ''
      },
      errors: []
    };
  },
  created() {
    // Escuchar el evento para abrir el modal
    eventNewRegistro.$on('open', (modelo) => {
      if (modelo === 'proveedores') {
        $('#nuevoProveedor').modal('show');
      }
    });
  },
  beforeDestroy() {
    eventNewRegistro.$off('open');
  },
  methods: {
    storeProveedor() {
      if (this.validateProveedor()) {
        var urlRegistros = 'proveedores';
        axios.post(urlRegistros, this.nuevoProveedor)
          .then(response => {
            this.$emit('store');
            this.resetForm();
            $('#nuevoProveedor').modal('hide');
            toastr.success('Nuevo proveedor creado con éxito');
          }).catch(error => {
            this.errors = error.response.data.errors;
            $.each(this.errors, function(key, value) {
              toastr.error(value);
              console.log(key + ": " + value);
            });
            if ((typeof(this.errors) === 'undefined') && error) {
              toastr.error("Ocurrió un error al procesar la solicitud");
            }
          });
      }
    },
    validateProveedor() {
      if (!this.nuevoProveedor.cuit || this.nuevoProveedor.cuit.length > 45) {
        toastr.error('El CUIT debe tener menos de 45 caracteres y es obligatorio.');
        return false;
      }
      if (!this.nuevoProveedor.razon_social || this.nuevoProveedor.razon_social.length > 100) {
        toastr.error('La Razón Social debe tener menos de 100 caracteres y es obligatoria.');
        return false;
      }
      if (!this.nuevoProveedor.email || this.nuevoProveedor.email.length > 60) {
        toastr.error('El Email debe tener menos de 60 caracteres y es obligatorio.');
        return false;
      }
      if (!this.nuevoProveedor.tel || this.nuevoProveedor.tel.length > 40) {
        toastr.error('El Teléfono debe tener menos de 40 caracteres y es obligatorio.');
        return false;
      }
      return true;
    },
    resetForm() {
      this.nuevoProveedor = {
        cuit: '',
        razon_social: '',
        email: '',
        tel: ''
      };
    }
  }
}
</script>