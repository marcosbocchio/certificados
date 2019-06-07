<template>
    <div>
        <div class="col-sm-12">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th colspan="2">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="registro in registros">
                    <td width="10px">{{ registro.id }}</td>
                    <td>{{ registro.codigo }}</td>
                    <td>{{ registro.name }}</td>
                    <td>{{ registro.email }}</td>
                    <td><a href="#" class="btn btn-warning btn-sm" title="Editar" v-on:click.prevent="editKeep(registro)"><span class="fa fa-edit"></span></a>
                        <a href="#" class="btn btn-danger btn-sm" title="Eliminar "v-on:click.prevent="confirmDeleteRegistro(registro)"><span class="fa fa-trash"></span></a>
                    </td>
                </tr>
                </tbody>
            </table>
            <delete-registro :fillRegistro="fillRegistro" :url="url" @close-modal="getRegistros"></delete-registro>
            <h4>El registro es : {{ fillRegistro.id}}</h4>
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

      props : {
        url : {
          type : String,
          required : true,
          defaults : 'https://certificados.com.ar'        
        }
      },

      created : function(){

        this.getRegistros();

      },

      data () { return {
        newregistro:'',
        fillRegistro: {'id':'','name':''},
        errors:[],
        registros: []
        }
      },

      methods: {

            getRegistros : function(){

            
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'api/users';
                console.log(axios.defaults.baseURL);
                axios.get(urlRegistros).then(response =>{
                    this.registros = response.data
                });
              },

            confirmDeleteRegistro: function(registro){
              this.fillRegistro.id = registro.id;
              this.fillRegistro.name = registro.name;
             $('#delete-registro').modal('show');
          }
      }


    }
</script>
