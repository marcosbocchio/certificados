<template>
    <div> 
       <form action="">
            <div class="col-lg-6 col-lg-offset-2" >       
                <div class="input-group ">
                    <label for="">SELECCIONE EL CLIENTE :</label>   
                    <v-select class="style-chooser" v-model="cliente" label="nombre_fantasia" :options="clientes"></v-select> 
                    <label for="">&nbsp;</label>   
                        <span class="input-group-btn" style="margin-left:10px;">
                        <a :href="AppUrl + '/area/enod/soldadores/cliente/' + cliente.id"  ><button type="button" class="btn btn-info btn-flat">Ir</button></a>
                        </span>
                </div>   
            </div>
       </form>
    </div>
</template>

<script>
 import {mapState} from 'vuex'
export default {

    data() { return {    
     
        cliente :'', 
        clientes:[]    
         }
    
    },

    created : function () {

        this.getClientes();

    },
    computed :{
    
         ...mapState(['url','AppUrl'])
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
  }

.style-chooser .vs__search {
    height: 24px;
}

</style>