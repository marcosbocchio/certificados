<template>
  <form v-on:submit.prevent="dropRegistro(fillRegistro.id)" method="post">
    <div class="modal fade" id="delete-registro">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Advertencia</h4>
          </div>
          <div class="modal-body">
            <p>Está seguro de eliminar el registro "{{ this.datoDelete }}" ?</p>
          </div>
          <div class="modal-footer">
            <input type="submit" class="btn btn-primary" value="Aceptar">
            <button type="button" class="btn btn-default" name="button" data-dismiss="modal" >Cancelar</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
import {mapState} from 'vuex'
export default {
  props: {
      fillRegistro: {'id':'','registro':''},
      datoDelete : '',
      modelo : {
            type : String,
            required : true,
            default : ''
          }
  },
  computed :{
    
         ...mapState(['url'])
  },
  methods:{
    
  dropRegistro :function(id){

      axios.defaults.baseURL = this.url;     
      var url = this.modelo.substring(0, (this.modelo.indexOf("/") >-1) ? this.modelo.indexOf("/") : this.modelo.length) + '/' + id;
      axios.delete(url).then(response =>{       
        this.$emit('close-modal');
        this.$showMessagePreset('success','code-delete');
        console.log(response);
      }).catch(error => {
        this.errors = error.response.data
        this.$showMessagePreset('error','code-no-delete');
      });
      $('#delete-registro').modal('hide');
    },
  }
}
</script>

<style scoped>

</style>


