<template>
    <form v-on:submit.prevent="$emit('Nuevo',newRegistro)" method="post">
        <div class="modal fade" id="nuevo">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Crear</h4>
                </div>
                <div class="modal-body">
                    <label for="codigo">Código</label>
                    <input type="text" name="codigo" class="form-control" v-model="newRegistro.codigo" value="" maxlength="10" required >
                    <label for="name">descripción</label>
                    <input type="text" name="descripcion" class="form-control" v-model="newRegistro.descripcion" maxlength="100" value="" required >               
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Guardar">
                    <button type="button" class="btn btn-default" name="button" data-dismiss="modal" >Cancelar</button>
                </div>
            </div>
            </div>
        </div>
    </form>
</template>

<script>
export default {

    data() { return {
    
        newRegistro : {
            'codigo': '',
            'descripcion'  : ''
        } 
    }
    }
    
}
</script>

