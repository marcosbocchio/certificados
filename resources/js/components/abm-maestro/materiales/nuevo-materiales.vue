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
                    <label for="name">descripción</label>
                    <input type="text" name="descripcion" class="form-control" v-model="newRegistro.descripcion" value="">               
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
            'descripcion'  : '',
         },
        errors:{}
      
         }
    
    },

    methods: {

        storeRegistro: function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'materiales';  
                        
            axios.post(urlRegistros, {   
                
            'codigo'    : this.newRegistro.codigo,
            'descripcion'  : this.newRegistro.descripcion
                

            }).then(response => {
                this.$emit('store');
                this.errors=[];
                $('#nuevo').modal('hide');               
                toastr.success('Nuevo registro creado con éxito');
                
                
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


