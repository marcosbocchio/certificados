<template>
    <form v-on:submit.prevent="storeRegistro" method="post">
    <div class="modal fade" id="nuevo">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Crear</h4>
            </div>
            <div class="modal-body">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" class="form-control" v-model="newRegistro.codigo" value="">
                <label for="name">Nombre</label>
                <input type="text" name="nombre" class="form-control" v-model="newRegistro.name" value="">
                <label for="usuario">email</label>
                <input type="text" name="email" class="form-control" v-model="newRegistro.email" value="">
                <label for="password">password</label>
                <input type="text" name="password" class="form-control" v-model="newRegistro.password" value="">
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
         },
        errors:{},
        request : [] 
      
         }
    
    },
methods: {
    storeRegistro: function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'users';  
                         
                axios.post(urlRegistros, {   
                    
                'name'      : this.newRegistro.name,
                'codigo'    : this.newRegistro.codigo,
                'email'     : this.newRegistro.email,
                'password'  : this.newRegistro.password
                  

                }).then(response => {
                  this.$emit('store');
                  this.errors=[];
                  $('#nuevo').modal('hide');               
                  toastr.success('Nuevo registro creado con éxito');
                  this.newRegistro={}
                  
                }).catch(error => {
                    toastr.error("No se pudo crear el registo.", "Error:");
                    this.errors = error.response.data.errors;
                    $.each( this.errors, function( key, value ) {
                        toastr.error(value,key);
                        console.log( key + ": " + value );
                    });

                });

              }
}
    
}
</script>

