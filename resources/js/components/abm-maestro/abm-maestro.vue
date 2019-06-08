<template>
    <div>
        <div class="col-sm-12">
            <table class="table table-hover table-striped">
               <component :is= setComponente :registros="registros"  @confirmarDelete="confirmDeleteRegistro"/>             
            </table>
            <delete-registro :datoDelete="datoDelete" :fillRegistro="fillRegistro" @close-modal="getRegistros" :modelo="modelo"></delete-registro>         
        </div>
        <div class="col-sm-8">
		<pre>
			{{ $data }}
		</pre>
        </div>
    </div>
</template>

<script>

    export default {
      name: 'abm-maestro',
      props : {         
          modelo : {
            type : String,
            required : true,
            default : ''
          }
      },

      created : function(){

        this.getRegistros();

      },

      data () { return {
        newregistro:'',
        fillRegistro: {'id':'','name':''},
        errors:[],
        registros: [], 
        datoDelete: '',       
        }
      },     
      computed :{

         setComponente : function(){

             return 'table-' + this.modelo ;
         }
     },

      methods: {

            getRegistros : function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = this.modelo;                 
                axios.get(urlRegistros).then(response =>{
                    this.registros = response.data
                });
              },

            confirmDeleteRegistro: function(registro,dato){            
              this.fillRegistro.id = registro.id;
              this.datoDelete = dato;
             $('#delete-registro').modal('show');
          }
      }


    }
</script>
