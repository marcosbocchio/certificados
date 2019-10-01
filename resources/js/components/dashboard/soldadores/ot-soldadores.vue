<template>
    <div>
       <div class="col-md-12">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ ot_soldadores.length }} / {{ ot_usuarios_cliente.length}}</h3>
              <p>Soldadores / Usuarios Cliente </p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-body">  
                    <div class="form-group">
                        <label>Soldadores</label>           
                        <v-select v-model="soldador" :options="soldadores" label="codigo">
                            <template slot="option" slot-scope="option">
                                <span class="upSelect">{{ option.nombre }} </span> <br> 
                                <span class="downSelect"> {{ option.codigo }} </span>
                            </template>
                        </v-select>          
                    </div> 
                    <div class="form-group">                    
                        <span>
                            <i class="fa fa-plus-circle" @click="addSoldador(soldador.id)"></i>
                        </span>
                    </div>
                 </div>                
            </div>
            <div class="box box-info top-buffer">
                <div class="box-header with-border">
                <h3 class="box-title">Soldadores Asignados Orden de Trabajo</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>                       
                </div>
                </div>
                <div class="box-body">                        
                    <div class="table-responsive">          
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>CODIGO</th>                                                     
                                    <th>NOMBRE</th>
                                    <th colspan="2">ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(ot_soldador,k) in ot_soldadores" :key="k">                                 
                                    <td> {{ot_soldador.codigo}}</td>     
                                    <td> {{ot_soldador.nombre}}</td>         
                                    <td> <i class="fa fa-minus-circle" @click="removeSoldador(k)" ></i></td>
                                </tr>                       
                                
                            </tbody>
                        </table>                     
                    </div>
                </div> 
            </div> 

             <div class="box box-danger">
                <div class="box-body">  
                    <div class="form-group">
                        <label>Usuarios Cliente</label>           
                        <v-select v-model="usuario_cliente" :options="usuarios_cliente" label="name"></v-select>          
                    </div> 
                    <div class="form-group">                    
                        <span>
                            <i class="fa fa-plus-circle" @click="addUsuarioCliente(usuario_cliente.id)"></i>
                        </span>
                    </div>
                 </div>                
            </div>
            <div class="box box-info top-buffer">
                <div class="box-header with-border">
                <h3 class="box-title">Usurios del Cliente Asignados Orden de Trabajo</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>                       
                </div>
                </div>
                <div class="box-body">                        
                    <div class="table-responsive">          
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>NOMBRE</th>
                                    <th>EMAIL</th>                                                     
                                    <th colspan="2">ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(ot_usuario_cliente,k) in ot_usuarios_cliente" :key="k">                                 
                                    <td> {{ot_usuario_cliente.name}}</td>     
                                    <td> {{ot_usuario_cliente.email}}</td>         
                                    <td> <i class="fa fa-minus-circle" @click="removeUsuarioCliente(k)" ></i></td>
                                </tr>                       
                                
                            </tbody>
                        </table>                     
                    </div>
                </div> 
            </div>
            <a class="btn btn-primary" v-on:click.prevent="submit()" >Actualizar</a>      
        </div>
            
    </div>    
</template>

<script>
import {mapState} from 'vuex'
export default {
    props :{

    soldadores_data : {
    type : Array,
    required : false
     },

    usuarios_cliente_data : {
    type : Array,
    required : false
     }, 
     

    ot_data : {
    type : Object,
    required : false
     },
    
  }, 

data () { return {


      ot_soldadores :[],
      soldadores:[],
      soldador:'',
      ot_usuarios_cliente :[],
      usuarios_cliente:[],
      usuario_cliente:''

    }    
  },
  computed :{

       ...mapState(['url','AppUrl'])
    },

  created : function(){
    
    this.ot_soldadores =  JSON.parse(JSON.stringify(this.soldadores_data));  
    this.ot_usuarios_cliente =  JSON.parse(JSON.stringify(this.usuarios_cliente_data));  
    this.getSoldadores();
    this.getUsuariosCliente();

  },
methods : {

  getSoldadores : function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'soldadores/cliente/' + this.ot_data.cliente_id + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.soldadores = response.data
                });
             
        },

    getUsuariosCliente : function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'users/cliente/' + this.ot_data.cliente_id + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.usuarios_cliente = response.data
                });
             
        },

    addSoldador : function(id){

        console.log('entro en add soldador');
            if (this.existeSoldador(id)){
                    toastr.error('El soldador ya existe en la OT');  
            }else if(this.soldador.codigo){
                console.log('agregando soldador');
                this.ot_soldadores.push({ 
                    ...this.soldador
                });
                this.soldador = '';
            }


  },

  addUsuarioCliente : function(id){

     
        if (this.existeUsuarioCliente(id)){
                toastr.error('El Usuario ya existe en la OT');  
        }else if(this.usuario_cliente.name){
               console.log('agregando soldador');
            this.ot_usuarios_cliente.push({ 
                 ...this.usuario_cliente
            });
            this.usuario_cliente = '';
        }


  },

  removeSoldador: function(index){

         this.ot_soldadores.splice(index, 1);        

    },

  removeUsuarioCliente: function(index){

         this.ot_usuarios_cliente.splice(index, 1);        

    },  
  
  existeSoldador : function(id){

        let existe = false;
        this.ot_soldadores.forEach(function (soldador) {           
            console.log(soldador.id,'==',id);
            if(soldador.id == id){              
                existe = true ;
            }
            
        });

        return existe;
    },

  existeUsuarioCliente : function(id){

        let existe = false;
        this.ot_usuarios_cliente.forEach(function (usuario) {           
            console.log(usuario.id,'==',id);
            if(usuario.id == id){              
                existe = true ;
            }
            
        });

        return existe;
    },

  submit :function () {
       

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'ot_soldadores';  
                        
            axios.post(urlRegistros, {   
                
            soldadores        : this.ot_soldadores,
            usuarios_cliente  : this.ot_usuarios_cliente,
            ot : this.ot_data                

            }).then(response => {            
                this.errors=[];     
                console.log(response);                  
                toastr.success('Soldadores/Usuarios actualizados con éxito');                
                
            }).catch(error => {
               
                this.errors = error.response.data.errors;                 
                $.each( this.errors, function( key, value ) {
                    toastr.error(value,key);
                    console.log( key + ": " + value );
                });
                
                if(this.errors = [] && error){

                     toastr.error("Ocurrio un error al procesar la solicitud");                     
                     this.ot_soldadores = this.soldadores_data;   
                }
  
            });
        }  
}
}
</script>