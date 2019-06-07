<template>
  <form v-on:submit.prevent="dropRegistro(fillRegistro.id)" method="post">
    <div class="modal fade" id="delete-registro">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Advertencia</h5>
            <button type="button" class="close" data-dismiss="modal" >
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Está seguro de eliminar el registro " {{ fillRegistro.name }} " ?</p>
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-primary" value="Aceptar">
            <button type="button" class="btn btn-secondary" name="button" data-dismiss="modal" >Cancelar</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>

<script>



export default {
  props: {
      fillRegistro: {'id':'','registro':''},
      url : {
          type : String,
          required : true,
          defaults : 'https://certificados.com.ar'        
        }
  },
  methods:{
  dropRegistro :function(id){

      axios.defaults.baseURL = this.url;     
      var url = 'api/users/' + id;
      axios.delete(url).then(response =>{
        this.$emit('close-modal');
        $('#delete-registro').modal('hide');
        toastr.success('Eliminado correctamente');
      }).catch(error => {
        this.errors = error.response
      });
    },
  }
}
</script>

<style lang="css" scoped>
</style>
