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
            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" class="form-control" v-model="newRegistro.codigo" value="" required >
            <label for="name">Nombre</label>
            <input type="text" name="nombre" class="form-control" v-model="newRegistro.name" value="" required >
            <label for="usuario">email</label>
            <input type="text" name="email" class="form-control" v-model="newRegistro.email" value="" required >
            <label for="password">password</label>
            <input type="text" name="password" class="form-control" v-model="newRegistro.password" value="" required >
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
            'name'  : '',
            'email' : '',
            'password' : ''
        } 
    }
    }
    
}
</script>

