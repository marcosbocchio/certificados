<template>
    <div>
       <div class="col-lg-12">
          <cuadro-largo-enod
              :titulo = "'SOLDADORES'"
              :titulo_2 = "'USUARIOS CLIENTE'"
              :class_color_titulo = "'color_2'"
              :class_color_sub_titulo = "'color_3'"
              :cantidad_2 ="ot_soldadores.length"
              :cantidad_1 ="ot_usuarios_cliente.length"
              :src_icono ="'/img/tablero/icono-enod-remitos.svg'"
              :class_color_cuadro = "'bg-custom-1'"
              :class_color_cuadro_largo = "'bg-custom-4'"
              :habilitado_sn =" $can('T_remitos_acceder') ?  true : false"
              :class_footer_img ="'footer-doc-remitos'"
          >
          </cuadro-largo-enod>
       </div>
        <div class="clearfix"></div>
        <div class="col-md-12">
            <div class="box box-custom-enod">
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
                            <button type="button" @click="addSoldador(soldador.id)"><span class="fa fa-plus-circle"></span></button>
                        </span>
                    </div>
                 </div>
            </div>
            <div class="box box-custom-enod top-buffer">
                <div class="box-header with-border">
                <h3 class="box-title">Soldadores Asignados Orden de Trabajo</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th>CODIGO</th>
                                    <th>NOMBRE</th>
                                    <th colspan="2">&nbsp;</th>
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

             <div class="box box-custom-enod">
                <div class="box-body">
                    <div class="form-group">
                        <label>Usuarios Cliente</label>
                        <v-select v-model="usuario_cliente" :options="usuarios_cliente" label="name"></v-select>
                    </div>
                    <div class="form-group">
                        <span>
                            <button type="button" @click="addUsuarioCliente(usuario_cliente.id)"><span class="fa fa-plus-circle"></span></button>
                        </span>
                    </div>
                 </div>
            </div>
            <div class="box box-custom-enod top-buffer">
                <div class="box-header with-border">
                <h3 class="box-title">Usuarios del Cliente Asignados Orden de Trabajo</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th>NOMBRE</th>
                                    <th>EMAIL</th>
                                    <th colspan="2">&nbsp;</th>
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
        <div class="clearfix"></div>
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

       ...mapState(['url'])
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
                    toastr.error('El soldador existe en la OT');
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
                toastr.error('El Usuario existe en la OT');
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
