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
                        <input type="number" v-model="obra" class="form-control" id="obra" :disabled="otdata.obra">
                    </div>                            
                </div>
                <div class="col-md-6">
                    <div class="form-group">
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

      informedata: { 

          type :Object,
          required:true
      },
    
     editmode : {
        type : Boolean,
        required : false,    
        default : false
    },
     
     importado_sn : {
        type : Boolean,
        required : false,    
        default : false
     }
     },

    data() {return {

        cliente:'',
        obra:'',

    }},

    created : function() {

      this.getCliente();  
    },

    mounted : function() {

        this.setObra()

    },

    watch :{

      obra : function(val){

          this.$emit('set-obra',val)

      }
    },

    computed :{

        ...mapState(['url','AppUrl','obra_informe']),     
       
     },

    methods : {

        setObra : function(){

       if(this.editmode){
           console.log(this.importado_sn);
           this.$store.dispatch('loadObraInformes',{ informe_id: this.informedata.id , importado_sn: this.importado_sn}).then(response => {

               this.obra = this.obra_informe
               
           })

       }else{

           this.obra =  this.otdata.obra

       }

        },

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