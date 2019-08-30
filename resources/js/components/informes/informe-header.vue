<template>
    <div>
        <div class="box box-danger">
            <div class="box-body"> 
                <div class="col-md-6">
                    <div class="form-group" >
                        <label for="cliente">Cliente</label>
                        <input type="text" v-model="cliente.nombre_fantasia" class="form-control" id="cliente" disabled>
                    </div>                            
                </div>
                <div class="col-md-6">
                    <div class="form-group" >
                        <label for="proyecto">Proyecto</label>
                        <input type="text" v-model="otdata.proyecto" class="form-control" id="proyecto" disabled>
                    </div>                            
                </div>                        
                <div class="col-md-6">
                    <div class="form-group" >
                        <label for="obra">Obra N°</label>
                        <input type="number" v-model="otdata.obra" class="form-control" id="obra" disabled>
                    </div>                            
                </div>
                <div class="col-md-6">
                    <div class="form-group" >
                        <label for="ot">Orden de Trabajo N°</label>
                        <input type="number" v-model="otdata.numero" class="form-control" id="ot" disabled>
                    </div>                            
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapState} from 'vuex';
export default {
    
    props :{
      otdata : {
      type : Object,
      required : true
      },
    },

    data() {return {

        cliente:''

    }},

    created : function() {

      this.getCliente();  
    },

    computed :{

        ...mapState(['url','AppUrl']),     
       
     },

    methods : {

        getCliente : function(){
           
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'clientes/' + this.otdata.cliente_id + '?api_token=' + Laravel.user.api_token;     
             console.log(urlRegistros);    
            axios.get(urlRegistros).then(response =>{
            this.cliente = response.data

           
            });
        },

    }
}
</script>

<style scoped>

.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
     background-color: #eee;
}

</style>