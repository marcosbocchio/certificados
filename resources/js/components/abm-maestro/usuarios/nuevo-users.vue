<template>
    <form v-on:submit.prevent="Nuevo" method="post">
    <div class="modal fade" id="nuevo-users">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">crear</h5>
            <button type="button" class="close" data-dismiss="modal" >
                <span>&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" class="form-control" v-model="newkeep" value="" required >
            <span v-for="error in errors" class="text-danger">{{ error }}</span>
            </div>
            <div class="modal-footer">
            <input type="submit" class="btn btn-primary" value="Guardar">
            </div>
        </div>
        </div>
    </div>
    </form>
</template>

<script>
export default {
    
}
</script>

