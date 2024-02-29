<template>
  <form v-on:submit.prevent="updateProveedor">
    <div class="modal fade" id="editarProveedor" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Editar Proveedor</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="cuit">CUIT *</label>
              <input autocomplete="off" v-model="proveedorSeleccionado.cuit" type="text" class="form-control" id="cuit" maxlength="20">
            </div>
            <div class="form-group">
              <label for="razon_social">Razón Social *</label>
              <input autocomplete="off" v-model="proveedorSeleccionado.razon_social" type="text" class="form-control" id="razon_social" maxlength="100">
            </div>
            <div class="form-group">
              <label for="email">Email *</label>
              <input autocomplete="off" v-model="proveedorSeleccionado.email" type="email" class="form-control" id="email" maxlength="60">
            </div>
            <div class="form-group">
              <label for="tel">Teléfono *</label>
              <input autocomplete="off" v-model="proveedorSeleccionado.tel" type="text" class="form-control" id="tel" maxlength="20">
            </div>
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-primary" value="Guardar">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
import { eventEditRegistro } from '../../event-bus';
import toastr from 'toastr';

export default {
  props: {
    selectRegistro: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      proveedorSeleccionado: { ...this.selectRegistro }
    };
  },
  created() {
    eventEditRegistro.$on('editarProveedor', this.handleEditar);
  },
  methods: {
    handleEditar(registro) {
      this.proveedorSeleccionado = { ...registro };
      $('#editarProveedor').modal('show');
    },
    updateProveedor() {
      if (this.validateProveedor()) {
        axios.put('proveedores/' + this.proveedorSeleccionado.id, this.proveedorSeleccionado)
          .then(response => {
            this.$emit('proveedorActualizado');
            $('#editarProveedor').modal('hide');
            toastr.success('Proveedor actualizado con éxito');
          })
          .catch(error => {
            toastr.error("Hubo un error al actualizar el proveedor", error);
          });
      }
    },
    validateProveedor() {
      if (!this.proveedorSeleccionado.cuit || this.proveedorSeleccionado.cuit.length > 20) {
        toastr.error('El CUIT debe tener menos de 20 caracteres y es obligatorio.');
        return false;
      }
      if (!this.proveedorSeleccionado.razon_social || this.proveedorSeleccionado.razon_social.length > 100) {
        toastr.error('La Razón Social debe tener menos de 100 caracteres y es obligatoria.');
        return false;
      }
      if (!this.proveedorSeleccionado.email || this.proveedorSeleccionado.email.length > 60) {
        toastr.error('El Email debe tener menos de 60 caracteres y es obligatorio.');
        return false;
      }
      if (!this.proveedorSeleccionado.tel || this.proveedorSeleccionado.tel.length > 20) {
        toastr.error('El Teléfono debe tener menos de 20 caracteres y es obligatorio.');
        return false;
      }
      return true;
    }
  },
  beforeDestroy() {
    eventEditRegistro.$off('editarProveedor', this.handleEditar);
  }
}
</script>