<template>
    <form v-on:submit.prevent="storeRegistro" method="post">
    <div class="modal fade" id="editar">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar</h4>
                </div>
                <div class="modal-body">
                   <div class="row">
                    <div class="modal-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="codigo">Nombre *</label>
                                <input autocomplete="off" v-model="editRegistro.name" type="text" name="codigo" class="form-control" value="" maxlength="20">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Guard *</label>
                                <v-select v-model="editRegistro.guard_name" :options="guards"></v-select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>Permisos</strong>
                                <div v-for="(permiso,k) in permisos" :key="k" >

                                 <div class="col-sm-4 col-xs-12">
                                    <input type="checkbox" :id=" permiso.name " :value="permiso.name" v-model="rol_permisos" style="float:left">
                                    <label for="tipo" style="float:left;margin-left: 5px;">{{ permiso.name }}</label>
                                </div>
                                </div>
                             </div>
                        </div>

                    </div>
                 </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Guardar">
                    <button type="button" class="btn btn-default" name="button" data-dismiss="modal" >Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</template>

<script>
 import {mapState} from 'vuex'
 import { eventEditRegistro } from '../../event-bus';
export default {

    props : {

        selectRegistro : {
            type : Object,
            required : false,
          }

    },
    data() { return {

        editRegistro : {
            'name'  : '',
            'guard_name' : '',
         },
        rol_permisos:[],
        guards:['web','api'],

        errors:{},
         }
    },
 created: function () {

    eventEditRegistro.$on('editar',function() {

        this.openModal();

    }.bind(this));


    },

    computed :{

         ...mapState(['url','permisos'])
    },

    methods: {
           openModal : function(){
               console.log('entro en open modal');
            this.$nextTick(function () {
               this.editRegistro = this.selectRegistro;
               this.setPermisos();

                $('#editar').modal('show');

                this.$forceUpdate();
            })
            },

            setPermisos: function(){
               this.rol_permisos=[];
               this.selectRegistro.permisos.forEach(function(item) {
                    this.rol_permisos.push(item.name);
               }.bind(this));
            },

            storeRegistro: function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'roles/' + this.selectRegistro.id;
                axios.put(urlRegistros, {

                ...this.editRegistro,
                'permisos' : this.rol_permisos,

                }).then(response => {
                  this.$emit('update');
                  this.errors=[];
                  $('#editar').modal('hide');
                  toastr.success('Rol editado con éxito');
                  this.editRegistro={}

                }).catch(error => {
                    this.errors = error.response.data.errors;
                    $.each( this.errors, function( key, value ) {
                        toastr.error(value);
                        console.log( key + ": " + value );
                    });

                     if((typeof(this.errors)=='undefined') && (error)){

                     toastr.error("Ocurrió un error al procesar la solicitud");

                }
                });
              }
}

}
</script>
