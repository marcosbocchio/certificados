@ -1,583 +1,593 @@
<template>
 <div class="row">
       <div class="col-md-12">
            <form @submit.prevent="editmode ?  Update() : Store()"  method="post" autocomplete="off">
                 <div class="box box-custom-enod">
                    <div class="box-body">
                        <div class="col-md-8">
                        </div>
                        <div class="col-md-4" style="display: flex;justify-content: flex-end;">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="esBorrador" v-model="esBorrador">
                                <label class="form-check-label" for="esBorrador">Guardar como Borrador</label>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-6" >
                            <div class="form-group">
                                <label for="fecha">Fecha *</label>
                                <div>
                                    <date-picker v-model="fecha" value-type="YYYY-MM-DD" format="DD-MM-YYYY" placeholder="DD-MM-YYYY"></date-picker>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="prefijo">Prefijo N° *</label>
                                <input type="number" v-model="prefijo" class="form-control" id="prefijo" @change="formatearPrefijo(prefijo,4)" min="1" max="9999"/>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="numero">Remito N° *</label>
                                <input type="number" v-model="numero" class="form-control" id="numero"  @change="formatearNumero(numero,8)" min="1" max="99999999"/>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Frente origen *</label>
                                <v-select  v-model="frente_origen" :options="frentes" @input="getInternoEquipos();frente_destino=''; inputsEquipos=[]" :clearable="false" label="codigo" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Frente destino *</label>
                                <v-select  v-model="frente_destino" :options="frentesFilter" label="codigo" :disabled="!frente_origen" />
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6">
                            <div class="form-group" >
                                <label for="receptor">Receptor *</label>
                                <input type="text" v-model="receptor" class="form-control" id="receptor" maxlength="45">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" >
                                <label for="destino">Lugar Destino *</label>
                                <input type="text" v-model="destino" class="form-control" id="destino" maxlength="100">
                            </div>
                        </div>
                    </div>
                 </div>
                 <div class="clearfix"></div>
                 <div class="box box-custom-enod">
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Productos</label>
                                <button type="button" class="btn btn-xs btn-primary" style="float:right" @click="newProducto()">Nuevo</button>
                                <v-select v-model="producto" label="descripcion" :options="productos" id="productos" @input="getMedidasProducto()"></v-select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <label>Medidas</label>

                            <v-select v-model="medida" :options="medidas" label="codigo">
                                <template slot="option" slot-scope="option">
                                    <span class="upSelect">{{ option.descripcion }} </span>
                                    <span class="downSelect">   {{ option.codigo }} </span>
                                </template>
                            </v-select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Cant.</label>
                                <input v-model="cantidad_productos" type="number" class="form-control" id="cantidad_productos" placeholder="">
                            </div>
                        </div>

                       <div class="clearfix"></div>

                        <div class="col-md-1">
                            <span>
                              <button type="button" @click="addProducto()"><span class="fa fa-plus-circle"></span></button>
                            </span>
                        </div>

                         <div class="form-group">
                            &nbsp;
                        </div>

                            <div v-show="inputsProductos.length">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped table-bordered table-condensed">
                                            <thead>
                                                <tr>
                                                    <th class="col-md-7">Productos</th>
                                                    <th class="col-md-2">Medidas</th>
                                                    <th class="col-md-2">cant</th>
                                                    <th class="col-md-1">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(inputsProducto,k) in inputsProductos" :key="k">
                                                    <td> {{ inputsProducto.producto.descripcion}}</td>
                                                    <td> {{ inputsProducto.medida.descripcion}}&nbsp; &nbsp; {{inputsProducto.medida.codigo }}</td>
                                                    <td> {{ inputsProducto.cantidad_productos}}</td>
                                                    <td style="text-align:center"> <i class="fa fa-minus-circle" @click="removeProducto(k)" ></i></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                       </div>
                    </div>

                    <div class="box box-custom-enod">
                        <div class="box-body">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Equipo *</label>
                                    <v-select  v-model="interno_equipo" :options="interno_equipos" label="nro_interno">
                                        <template slot="option" slot-scope="option">
                                            <span class="upSelect">{{ option.nro_interno }}</span> <br>
                                            <span class="downSelect"> {{ option.equipo.codigo }} </span>
                                        </template>
                                    </v-select>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                                <div class="col-md-1">
                                    <span>
                                    <button type="button" @click="addEquipo(interno_equipo.id)"><span class="fa fa-plus-circle"></span></button>
                                    </span>
                                </div>

                                <div class="form-group">
                                    &nbsp;
                                </div>

                                <div v-show="inputsEquipos.length">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped table-condensed">
                                            <thead>
                                                <tr>
                                                    <th class="col-md-2">N° Int.</th>
                                                    <th class="col-md-9">Equipo</th>
                                                    <th class="col-md-1">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(inputsEquipo,k) in inputsEquipos" :key="k">
                                                    <td> {{ inputsEquipo.nro_interno}}</td>
                                                    <td> {{ inputsEquipo.equipo.codigo}}</td>
                                                    <td style="text-align:center"> <i class="fa fa-minus-circle" @click="removeEquipo(k)" ></i></td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box box-custom-enod">
                            <div class="box-body">
                                <!-- Observaciones y Cantidad -->
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="observacionActual">Otros</label>
                                        <input type="text" v-model="observacionActual" maxlength="200" class="form-control" id="observacionActual">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cantidadActual">Cantidad *</label>
                                        <input type="number" v-model="cantidadActual" min="1" class="form-control" id="cantidadActual">
                                    </div>
                                </div>

                                <!-- Botón para agregar observación -->
                                <div class="col-md-12" style="padding-top: 10px;">
                                    <button type="button" @click="agregarObservacion"><span class="fa fa-plus-circle"></span></button>
                                </div>

                                <!-- Tabla de Observaciones -->
                                <div v-show="listaObservaciones.length" class="col-md-12" style="padding-top: 20px;">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped table-bordered table-condensed">
                                            <thead>
                                                <tr style="width: 100%;">
                                                    <th style="width: 75%;">Otro</th>
                                                    <th style="width: 13%;">Cantidad</th>
                                                    <th style="width: 12%;">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(obs, index) in listaObservaciones" :key="index">
                                                    <td>{{ obs.observaciones }}</td>
                                                    <td>{{ obs.cantidad }}</td>
                                                    <td style="text-align: center;"><span class="fa fa-minus-circle" @click="quitarObservacion(index)"></span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                
                            </div>
                        </div>
                        <div class="box box-custom-enod">
                            <div class="box-body">
                                <!-- Otras secciones del formulario -->

                                <!-- Nueva sección de observaciones -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="observaciones_remito">Observaciones</label>
                                        <input type="text" v-model="observaciones_remito" class="form-control" id="observaciones_remito" maxlength="200">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button :disabled="formularioEnviando || this.cargando_stop" class="btn btn-primary" type="submit">Guardar</button>
                </form>
                <nuevo-productos :modelo="'productos'" @store="getProductos"></nuevo-productos>
       </div>
 </div>

</template>

<script>

import { toastrWarning,toastrDefault } from '../toastrConfig';
import {mapState} from 'vuex';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/es';
import moment from 'moment';
import NuevoProductos from '../abm-maestro/productos/nuevo-productos.vue';
import { eventNewRegistro} from '../event-bus';

export default {
    components: {
        DatePicker,
        NuevoProductos
    },

    props :{

      editmode : {
        type : Boolean,
        required : false,
        default : false
      },
      remitodata : {
        type : Object,
        required : false
      },

      detalledata : {
        type : [ Array ],
        required : false
      },

      remito_interno_equipos_data : {
        type : [ Array ],
        required : false
      }

    },
    data (){return{

        errors:[],
        fecha: moment(new Date()).format('YYYY-MM-DD'),
        numero:'',
        prefijo:'',
        receptor:'',
        destino:'',
        producto:'',
        medida:'',
        cantidad_productos:'',
        interno_equipo:'',
        frente_origen:'',
        frente_destino:'',
        interno_equipos:[],
        frentes:[],
        productos:[],
        medidas:[],
        inputsProductos:[],
        inputsEquipos:[],
        numero_formatedo:'',
        prefijo_formateado:'',
        observaciones: '',
        observacionActual: '',
        cantidadActual: 1,
        listaObservaciones: [],
        formularioEnviando: false,
        esBorrador: true,
        cargando_stop:false,
        observaciones_remito: '',
        
    }},

    created : function() {

        this.getFrentes();
        this.getProductos();
        this.setEdit();

    },

    mounted : function() {

    },
    computed :{

        ...mapState(['url']),

        frentesFilter: function() {

            return this.frentes.filter(e => e.id != this.frente_origen.id);

        },
        valorBorradorSN() {
        return this.esBorrador ? '1' : '0';
        },
     },

    methods : {

        setEdit : function(){

            if(this.editmode) {
                this.formularioEnviando = false;
               this.fecha   = this.remitodata.fecha;
               this.numero = this.remitodata.numero;
               this.prefijo = this.remitodata.prefijo;
               this.receptor = this.remitodata.receptor;
               this.destino = this.remitodata.destino;
               this.observaciones_remito = this.remitodata.observacion_remito;
               this.inputsProductos = this.detalledata;
               this.inputsEquipos = this.remito_interno_equipos_data;
               this.frente_origen = this.remitodata.frente_origen;
               this.frente_destino = this.remitodata.frente_destino;
               this.formatearPrefijo(this.prefijo,4);
               this.formatearNumero(this.numero,8);
               this.getInternoEquipos();
               this.cargando_stop = true; // Inicia la carga
                if (this.remitodata && this.remitodata.id) {
                    this.getObservaciones(this.remitodata.id).finally(() => {
                        this.cargando_stop = false; // Finaliza la carga independientemente del resultado
                    });
                } else {
                    this.cargando_stop = false;
                }

            }
        },

        formatearPrefijo : function ( number, width ) {

            width -= number.toString().length;
            if ( width > 0 )
            {
                this.prefijo=  new Array( width + (/\./.test( number ) ? 2 : 1) ).join( '0' ) + number;
            }
        },

        formatearNumero : function ( number, width )    {

            width -= number.toString().length;
            if ( width > 0 )
            {
                this.numero=  new Array( width + (/\./.test( number ) ? 2 : 1) ).join( '0' ) + number;
            }
        },

        getFrentes: function () {

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'frentes' + '?api_token=' + Laravel.user.api_token;
            axios.get(urlRegistros).then(response =>{
                this.frentes = response.data
            });
        },

        agregarObservacion() {
            if(this.observacionActual.trim() !== '') {
                this.listaObservaciones.push({
                    observaciones: this.observacionActual,
                    cantidad: this.cantidadActual,
                });
                this.observacionActual = '';
                this.cantidadActual = 1;
            } else {
                toastr.error('Por favor, ingresa una observación.');
            }
        },

        quitarObservacion(index) {
            this.listaObservaciones.splice(index, 1);
        },

        getProductos : function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'productos/stockeable' + '?api_token=' + Laravel.user.api_token;
            axios.get(urlRegistros).then(response =>{
            this.productos = response.data
            });
        },

        getMedidasProducto : function(){
            this.medida = '';
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'medidas/' + this.producto.unidades_medida_id + '?api_token=' + Laravel.user.api_token;
            axios.get(urlRegistros).then(response =>{
            this.medidas = response.data
            });
        },

        getInternoEquipos: function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'interno_equipos/frente/'+ this.frente_origen.id + '?api_token=' + Laravel.user.api_token;
            axios.get(urlRegistros).then(response =>{
            this.interno_equipos = response.data
            });

        },
        getObservaciones: function(remitoId) {
            return new Promise((resolve, reject) => {
                axios.get(`/remitos/${remitoId}/observaciones`)
                    .then(response => {
                        this.listaObservaciones = response.data;
                        resolve(); // Indica que la carga ha terminado correctamente
                    })
                    .catch(error => {
                        console.error('Error al obtener las observaciones: ', error);
                        reject(error); // Indica que hubo un error en la carga
                    });
            });
        },
        addProducto(index) {

            if(!this.producto){
                toastr.error("El campo producto es obligatorio");
                 return;
            }

            if(!this.medida){
                    toastr.error("El campo medida es obligatorio");
                    return;
            }

            if(!this.cantidad_productos){
                 toastr.error("El campo cantidad de producto es obligatorio");
                 return;
            }
            const productoYaAgregado = this.inputsProductos.some(productoEnLista => productoEnLista.producto.id === this.producto.id);

            if (productoYaAgregado) {
                toastr.error("Este producto ya ha sido agregado");
                return;
            }
                this.inputsProductos.push({
                    producto:this.producto,
                    medida : this.medida,
                    cantidad_productos:this.cantidad_productos,
                    });
                this.producto='',
                this.medida ='',
                this.cantidad_productos='1'
            },

        existeEquipo : function(id){

            let existe = false;
            this.inputsEquipos.forEach(function (item) {

                if(item.id == id){
                    existe = true ;
                }
            });

            return existe;
        },

        addEquipo(id) {

            if (this.existeEquipo(id)){
                    toastr.error('El Equipo existe en el Remito');
            }else if(this.interno_equipo){

                this.inputsEquipos.push({

                    ... this.interno_equipo,

                    });
                this.interno_equipo='';
            }
         },

        removeProducto(index) {
            this.inputsProductos.splice(index, 1);
        },

        removeEquipo(index) {
            this.inputsEquipos.splice(index, 1);
        },

        Store : function(){
            this.formularioEnviando = true;
            this.errors =[];
            var urlRegistros = 'remitos' ;
            axios({
              method: 'post',
              url : urlRegistros,
              data : {
                'fecha'           : this.fecha,
                'prefijo'         : this.prefijo,
                'numero'          : this.numero,
                'frente_origen'   : this.frente_origen,
                'frente_destino'  : this.frente_destino,
                'receptor'        : this.receptor,
                'destino'         : this.destino,
                'detalles'        : this.inputsProductos,
                'interno_equipos' : this.inputsEquipos,
                'observaciones'     : this.listaObservaciones,
                'borrador_sn': this.valorBorradorSN,
                'observaciones_remito': this.observaciones_remito,
          }

        }).then(response => {

        let remito = response.data;
        toastr.success('Remito N° ' +  this.prefijo + '-' + this.numero + ' fue creado con éxito ');
        window.open(  '/pdf/remito/' + remito.id,'_blank');
        window.location.href =  '/area/enod/remitos/listado';

        }).catch(error => {
                this.formularioEnviando = false;
               this.errors = error.response.data.errors;
                console.log(error.response);
               $.each( this.errors, function( key, value ) {
                   toastr.error(value);
                     console.log( key + ": " + value );
               });

               if((typeof(this.errors)=='undefined') && (error)){

                    toastr.error("Ocurrió un error al procesar la solicitud");

                }

           });

        },

        Update : function() {
            this.formularioEnviando = true;
            console.log('entro para actualizar' );
            this.errors =[];
            var borrador_sn = this.esBorrador ? '1' : '0';
            var urlRegistros = 'remitos/' + this.remitodata.id  ;
            axios({
              method: 'put',
              url : urlRegistros,
              data : {
                'fecha'           : this.fecha,
                'prefijo'         : this.prefijo,
                'numero'          : this.numero,
                'frente_origen'   : this.frente_origen,
                'frente_destino'  : this.frente_destino,
                'receptor'        : this.receptor,
                'destino'         : this.destino,
                'detalles'        : this.inputsProductos,
                'interno_equipos' : this.inputsEquipos,
                'observaciones'     : this.listaObservaciones,
                'borrador_sn': this.valorBorradorSN,
                'observaciones_remito':this.observaciones_remito,
                
          }}

        ).then( () => {

          toastr.success('Remito N° ' +  this.prefijo + '-' + this.numero + ' fue actualizado con éxito ');
          window.open(  '/pdf/remito/' + this.remitodata.id,'_blank');
          window.location.href =  '/area/enod/remitos/listado';

        }).catch(error => {
            this.formularioEnviando = false;
               this.errors = error.response.data.errors;
                console.log(error.response);
               $.each( this.errors, function( key, value ) {
                   toastr.error(value);
                   console.log( key + ": " + value );
               });

               if((typeof(this.errors)=='undefined') && (error)){

                     toastr.error("Ocurrió un error al procesar la solicitud");

                }

           });
    },

    newProducto : function() {
        eventNewRegistro.$emit('open','remito');
    }

    }
}
</script>

<style scoped>

.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
     background-color: #eee;
}
</style>
