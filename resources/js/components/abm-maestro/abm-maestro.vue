<template>
<div>
    <div class="col-sm-10">
        <a href="#" class="btn btn-primary pull-right" data-toggle="modal" data-target="#nuevo">Nuevo</a>
    </div>
    <div class="col-sm-10">
        <component :is= setTablaComponente :registros="registros"  @confirmarDelete="confirmDeleteRegistro"/>               
        <delete-registro :datoDelete="datoDelete" :fillRegistro="fillRegistro" @close-modal="getRegistros" :modelo="modelo"></delete-registro>  
        <component :is= setNuevoComponente @Nuevo="nuevoRegistro"/>      
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
      mounted () {

      //  $('#nuevo-user').modal('show');
      },

      data () { return {
        fillRegistro: {'id':'','name':''},
        errors:[],
        registros: [], 
        datoDelete: '',    
        obj :'',
   
        }
      },     
      computed :{

         setTablaComponente : function(){

             return 'table-' + this.modelo ;
         },
         setNuevoComponente : function(){

             return 'nuevo-' + this.modelo ;
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

            nuevoRegistro: function(newRegistro){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = this.modelo;  
                this.obj = newRegistro;                           
                axios.post(urlRegistros, {
                
                  'descripcion'    :newRegistro.descripcion,
                  'codigo'  :newRegistro.codigo,              

                }).then(response => {
                  this.getRegistros();
                  this.errors=[];
                   console.log(response);
                  $('#nuevo').modal('hide');               
                  toastr.success('Nuevo registro creado con éxito');
                  
                }).catch(error => {
                    toastr.error("No se pudo crear el registo.", "Error:");
                     console.log(response);
                    this.errors = error.response.data
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
