<template>
  <div>
    <form v-on:submit.prevent="createKeep" method="post">
      <div class="modal fade" id="create_task">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">crear</h5>
              <button type="button" class="close" data-dismiss="modal" >
                <span>&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <label for="keep">Nueva Tarea</label>
              <input type="text" name="kepp" class="form-control" value="" required >

            </div>
            <div class="modal-footer">
              <input type="submit" class="btn btn-primary" value="Guardar">
            </div>
          </div>
        </div>
      </div>
    </form>

  </div>

</template>

<script>
export default {
}
</script>

<style lang="css" scoped>
</style>
