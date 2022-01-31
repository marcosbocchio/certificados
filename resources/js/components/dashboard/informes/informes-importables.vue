<template>
    <form v-on:submit.prevent="editmode ? updateRegistro() : storeRegistro()">
        <div class="modal fade" id="nuevo">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Importar Informe</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                         <informe-header :otdata="otdata" :informe_id="informe_id" :editmode="editmode" :importado_sn="true" @set-obra="setObra($event)" @set-planta="setPlanta($event)"></informe-header>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="fecha">Fecha *</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                              <i class="fa fa-calendar"></i>
                                        </div>
                                            <Datepicker v-model="Registro.fecha" :input-class="'form-control pull-right'" :language="es" ></Datepicker>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" >
                                    <label for="prefijo">Prefijo</label>
                                    <input type="text" v-model="Registro.prefijo" class="form-control" id="prefijo" >
                                </div>
                            </div>
                            <div class="col-md-6">
                               <div class="form-group" >
                                    <label for="numero">Informe N° *</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" style=" background-color: #eee;">{{Registro.metodo_ensayos.metodo}}</span>
                                        <input type="text" v-model="Registro.numero" class="form-control" id="numero" @change="formatearNumero(Registro.numero,3)" min="1" max="999">
                                    </div>
                               </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" >
                                    <label for="ejecutor_ensayo">Ejecutor Ensayo *</label>
                                    <v-select v-model="Registro.ejecutor_ensayo" label="name" :options="ejecutor_ensayos"></v-select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" >
                                    <label for="ejecutor_ensayo">Solicitante </label>
                                    <v-select v-model="Registro.solicitado_por" label="name" :options="usuarios_cliente"></v-select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Observaciones *</label>
                                    <textarea v-model="Registro.observaciones" class="form-control noresize" rows="3" placeholder="" maxlength="250"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" >
                                    <subir-imagen
                                        :ruta="ruta"
                                        :max_size="max_size"
                                        :path_inicial="Registro.path"
                                        :tipos_archivo_soportados ="tipos_archivo_soportados"
                                        :mostrar_formatos_soportados="true"
                                        @path="Registro.path = $event"
                                        :path_requerido_sn="true"
                                    ></subir-imagen>
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
import { eventNewRegistro, eventEditRegistro, eventDeleteFile} from '../../event-bus';
import Datepicker from 'vuejs-datepicker';
import {en, es} from 'vuejs-datepicker/dist/locale'
export default {


components: {

      Datepicker

    },

    props :{

        metodo_ensayo: {
        type : Object,
        required : false
        },

        otdata : {
            type : Object,
            required : true
        },


  },

    data() { return {

        en: en,
        es: es,
        editmode : false,
        ruta: 'informes_importados',
        max_size :50000, //KB
        usuarios_cliente: [],
        tipos_archivo_soportados:['pdf'],

         informe_id : 0,
         Registro : {
            'ot_id':'',
            'fecha':new Date(),
            'numero': '',
            'obra' : '',
            'planta' : '',
            'prefijo'  : '',
            'observaciones':'',
            'solicitado_por':{},
            'path':'',
            'metodo_ensayos' : {},
            'ejecutor_ensayo' :{}
         },
         numero_generado:'',

        errors: {}

        }
    },

   created: function () {

    eventNewRegistro.$on('open', this.nuevoRegistro);
    eventEditRegistro.$on('edit', this.EditRegistro);
    this.$store.dispatch('loadEjecutorEnsayo', this.otdata.id);
    this.getUsuariosCliente();
    },


    computed :{

        ...mapState(['url','ejecutor_ensayos']),

    },

    methods: {

       nuevoRegistro : function(){

           this.editmode = false;
           this.uploadPercentage = 0;
           this.Registro = {
                'ot_id' : this.otdata.id,
                'fecha':new Date(),
                'numero': '',
                'obra' : this.Registro.obra,
                'planta': this.Registro.planta,
                'prefijo'  : '',
                'observaciones':'',
                'solicitado_por':{},
                'path':'',
                'metodo_ensayos' : this.metodo_ensayo,
                'ejecutor_ensayo' :{}
            }

         this.getNumeroInforme();
         eventDeleteFile.$emit('delete');

          this.$nextTick(function(){

              this.$forceUpdate();
              eventEditRegistro.$emit('refreshObra');

           });
         $('#nuevo').modal('show');

        },
    getUsuariosCliente : function(){

        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'users/ot_id/' + this.otdata.id + '?api_token=' + Laravel.user.api_token;
        axios.get(urlRegistros).then(response =>{
        this.usuarios_cliente = response.data
        });

    },
        EditRegistro : function(informe_id){
            this.informe_id = informe_id;
            console.log('estoy dentro del modal edit:' + informe_id);
            this.editmode = true;
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'informes_importados/'+ informe_id + '/edit'  + '?api_token=' + Laravel.user.api_token;
            $('#nuevo').modal('show');
            axios.get(urlRegistros).then(response =>{
                console.log(response.data.solicitante );
                this.Registro = response.data;
                this.Registro.solicitado_por = response.data.solicitante
                this.formatearNumero(this.Registro.numero,3);
                this.$forceUpdate();
                eventEditRegistro.$emit('refreshObra');
            });
        },

        getNumeroInforme:function(){

            if(!this.editmode) {

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'informes/ot/' + this.otdata.id + '/metodo/' + this.metodo_ensayo.metodo + '/generar-numero-informe'  + '?api_token=' + Laravel.user.api_token;
                axios.get(urlRegistros).then(response =>{

                    this.Registro.numero = response.data;
                    this.formatearNumero(this.Registro.numero,3);

                    });
             }
        },

        formatearNumero : function ( number, width )
            {
                width -= number.toString().length;
                if ( width > 0 )
                {
                    this.Registro.numero=  new Array( width + (/\./.test( number ) ? 2 : 1) ).join( '0' ) + number;
                }
            },

        storeRegistro: function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'informes_importados';
            console.log('entro en el store de informes importados');
            axios.post(urlRegistros, {

                ...this.Registro

            }).then(response => {
                this.$emit('store');
                this.errors=[];
                $('#nuevo').modal('hide');
                toastr.success('El informe fue importado con éxito');

            }).catch(error => {

                this.errors = error.response.data.errors;

                $.each( this.errors, function( key, value ) {
                    toastr.error(value,key);
                    console.log( key + ": " + value );
                });

            });

        },

        setObra : function(value){

            this.Registro.obra = value;
        },
        setPlanta : function(value){

            console.log('el value es',value)
            this.Registro.planta = value;
        },

        updateRegistro: function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'informes_importados/' + this.Registro.id ;
            console.log('entro en el store de informes importados');
            axios.put(urlRegistros, {

                ...this.Registro

            }).then(response => {
                this.$emit('store');
                this.errors=[];
                $('#nuevo').modal('hide');
                toastr.success('El informe fue editado con éxito');

            }).catch(error => {

                this.errors = error.response.data.errors;

                $.each( this.errors, function( key, value ) {
                    toastr.error(value,key);
                    console.log( key + ": " + value );
                });

            });
        }
    }
}
</script>

<style scoped>

.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
     background-color: #eee;
}

</style>
