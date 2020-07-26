<template>
    <div> 
       
            <div class="col-lg-6 col-lg-offset-2" >       
                <div class="form-group ">
                    <label for="">SELECCIONE EL CLIENTE :</label>   
                    <v-select class="style-chooser" v-model="cliente" label="nombre_fantasia" :options="clientes"></v-select>                  
                </div>   
            </div>
            <div class="clearfix"></div>
            <abm-maestro :modelo="modelo" permiso_create="M_soldadores_edita"></abm-maestro> 
    </div>
</template>

<script>
 import {mapState} from 'vuex'
export default {

    data() { return {    
     
        cliente :'', 
        clientes:[],
        modelo: 'soldadores/cliente/-1',    
         }
    
    },

    created : function () {

        this.getClientes();

    },
    computed :{
    
         ...mapState(['url'])
    },

    watch : {

        cliente : function(val){

            this.modelo = 'soldadores/cliente/' + val.id;
                
        },

    },

    methods : {

        getClientes : function(){

                axios.defaults.baseURL = this.url ;
                
                var urlRegistros = 'clientes' + '?api_token=' + Laravel.user.api_token;             
                axios.get(urlRegistros).then(response =>{
                this.clientes = response.data
                });
              },
    }
}
</script>
<style>

  .style-chooser .vs__search::placeholder,
  .style-chooser .vs__dropdown-toggle,
  .style-chooser .vs__dropdown-menu {  
    
    border-radius: 0px;
     background: #FFFF;
  }

.style-chooser .vs__search {
    height: 24px;
}

</style>