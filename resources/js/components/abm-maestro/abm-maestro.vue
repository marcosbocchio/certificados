<template>
<div>
    <div class="col-sm-8">
        <a href="#" class="btn btn-primary pull-right" data-toggle="modal" data-target="#nuevo-users">Nuevo</a>
        <component :is= setTablaComponente :registros="registros"  @confirmarDelete="confirmDeleteRegistro"/>               
        <delete-registro :datoDelete="datoDelete" :fillRegistro="fillRegistro" @close-modal="getRegistros" :modelo="modelo"></delete-registro>  
        <component :is= setModalNuevoComponente />      
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
        newregistro:'',
        fillRegistro: {'id':'','name':''},
        errors:[],
        registros: [], 
        datoDelete: '',       
        }
      },     
      computed :{

         setTablaComponente : function(){

             return 'table-' + this.modelo ;
         },
         setModalNuevoComponente : function(){

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
            Nuevo: function(){
               axios.defaults.baseURL = this.url ;
               var urlRegistros = this.modelo;
              axios.post(urlRegistros, {
                registro: this.newregistro
              }).then(response => {
                this.getRegistros();
                this.newregistro='';
                this.errors=[];
                $('#nuevo-users').modal('hide');
                toastr.success('Nueva tarea creada con éxito');
                }).catch(error => {
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
