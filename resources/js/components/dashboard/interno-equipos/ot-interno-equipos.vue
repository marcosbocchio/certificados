<template>
    <div class="row">
       <back-dashboard></back-dashboard>
       <div class="col-lg-12">
          <cuadro-largo-enod
              :tablero_sn ="false"
              :titulo = "'EQUIPOS'"
              :class_color_titulo = "'color_3'"
              :class_color_sub_titulo = "'color_2'"
              :cantidad_1 ="ot_interno_equipos.length"
              :src_icono ="'/img/tablero/icono-enod-equipos.svg'"
              :class_color_cuadro = "'bg-custom-2'"
              :class_color_cuadro_largo = "'bg-custom-5'"
              :habilitado_sn ="true"
          >
          </cuadro-largo-enod>
       </div>
        <div class="clearfix"></div>

        <div class="col-md-12">
            <div v-show="$can('T_equipos_actualiza')">
                <div class="top-buffer" >
                    <div class="box box-custom-enod">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="equipo">Equipo *</label>
                                <v-select  v-model="interno_equipo" :options="interno_equipos" label="nro_interno">
                                    <template slot="option" slot-scope="option">
                                        <span class="upSelect">{{ option.nro_interno }}</span> <br>
                                        <span class="downSelect"> {{ option.equipo.codigo }} </span>
                                    </template>
                                </v-select>
                            </div>
                            <div class="form-group">
                                <span>
                                    <button type="button" @click="addEquipo(interno_equipo.id)"><span class="fa fa-plus-circle"></span></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="top-buffer" >
                <div class="box box-custom-enod">
                    <div class="box-header with-border">
                    <h3 class="box-title">Equipos Asignados Orden de Trabajo</h3>

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
                                        <th class="col-md-2">N° Serie</th>
                                        <th class="col-md-2">N° INT.</th>
                                        <th class="col-md-3">Equipo</th>
                                        <!--
                                            <th class="col-md-4">FUENTE</th>
                                        -->
                                        <th class="col-md-1">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(interno_equipo,k) in ot_interno_equipos" :key="k" class="pointer" :class="{selected: index_equipo == k}">

                                        <td @click="selectEquipo(k)" > {{interno_equipo.nro_serie}}</td>
                                        <td @click="selectEquipo(k)"> {{interno_equipo.nro_interno}}</td>
                                        <td @click="selectEquipo(k)"> {{interno_equipo.equipo.codigo}}</td>
                                            <!--
                                            <td v-if="interno_equipo.interno_fuente"> {{interno_equipo.interno_fuente.nro_serie}} / {{interno_equipo.interno_fuente.fuente.codigo}}</td>
                                            <td v-else>&nbsp;</td>
                                        -->
                                        <td> <i class="fa fa-minus-circle" @click="removeInternoEquipos(k)" ></i></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div v-show="$can('T_equipos_actualiza')">
                    <button class="btn btn-primary" v-on:click.prevent="submit()">Actualizar</button>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="col-md-12">

            <div class="box box-custom-enod top-buffer">
                <div class="box-header with-border">
                <h3 class="box-title">Documentaciones del equipo</h3>

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
                                    <th class="col-md-2">Título</th>
                                    <th class="col-md-9">Descripción</th>
                                     <th class="col-md-1">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item,k) in TablaInternoEquipoDoc" :key="k">
                                    <td> {{item.titulo}}</td>
                                    <td> {{item.descripcion}}</td>
                                    <td width="10px"> <a :href="'/' + item.path " target="_blank" title="Imagen"><span class="fa fa-file-image-o"></span></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div v-if="isLoadingIED" class="overlay">
                    <loading-spin></loading-spin>
                </div>
            </div>
        </div>

        <div class="col-md-12">

            <div class="box box-custom-enod top-buffer">
                <div class="box-header with-border">
                <h3 class="box-title">Documentaciones de la fuente</h3>

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
                                    <th class="col-md-1">N° Serie</th>
                                    <th class="col-md-2">Fuente</th>
                                    <th class="col-md-2">Título</th>
                                    <th class="col-md-6">Descripción</th>
                                    <th class="col-md-1">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item,k) in TablaInternoFuenteDoc" :key="k">
                                    <td> {{item.nro_serie}} </td>
                                    <td> {{item.codigo}} </td>
                                    <td> {{item.titulo}} </td>
                                    <td> {{item.descripcion}}  </td>
                                    <td width="10px"> <a :href="'/' + item.path " target="_blank" title="Imagen"><span class="fa fa-file-image-o"></span></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <div v-if="isLoadingIFD" class="overlay">
                <loading-spin></loading-spin>
            </div>
            </div>
        </div>

    </div>
</template>
<script>
import {mapState} from 'vuex';
export default {

 props :{

    ot_id_data : {
    type : Number,
    required : false
     },

    ot_interno_equipos_data : {
    type : Array,
    required : false
     },
 },

data () { return {

    ot_interno_equipos:[],
    interno_equipo: '',
    documentaciones_equipos : [],
    TablaInternoEquipoDoc : [],
    TablaInternoFuenteDoc: [],
    index_equipo : '-1' ,
    isLoadingIED : false ,
    isLoadingIFD : false ,
}},

 computed :{

       ...mapState(['url','interno_equipos'])
    },

 created : function(){

   this.ot_interno_equipos =  JSON.parse(JSON.stringify(this.ot_interno_equipos_data));
   this.$store.dispatch('loadInternoEquipos',{ 'metodo' : 'null', 'activo_sn' : 'null','tipo_penetrante' : 'null' });

 },

 methods :{

    selectEquipo: function(k){

        this.index_equipo = k;
        this.getInternoEquipoDoc(k);
        this.getInternoFuentesDoc(k);

    },


    getInternoEquipoDoc :  function(k){

        this.isLoadingIED  = true;
        let id = this.ot_interno_equipos[k].id;
        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'documentaciones/interno_equipo/' + id + '?api_token=' + Laravel.user.api_token;
        axios.get(urlRegistros).then(response =>{

            this.TablaInternoEquipoDoc = response.data

        }).catch(() =>

           toastr.error("Ocurrio un error al procesar la solicitud")

        ).finally(() =>

            this.isLoadingIED = false,

        );

    },

    getInternoFuentesDoc : function(k){

        this.isLoadingIFD  = true;
        let id = this.ot_interno_equipos[k].id;
        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'documentaciones/ot/' + this.ot_id_data + '/interno_equipo/' + id + '/fuentes_documentaciones' + '?api_token=' + Laravel.user.api_token;
        axios.get(urlRegistros).then(response =>{

                this.TablaInternoFuenteDoc = response.data

        }).catch(() =>

                toastr.error("Ocurrio un error al procesar la solicitud")

        ).finally(() =>

        this.isLoadingIFD = false,

    );
    },

    removeInternoEquipos: function(index){
        this.ot_interno_equipos.splice(index, 1);
    },

    existeEquipo : function(id){

        let existe = false;
        this.ot_interno_equipos.forEach(function (equipo) {
            if(equipo.id == id){
                existe = true ;
            }
        });

        return existe;
    },

    addEquipo : function(id) {

        if (this.existeEquipo(id)){
                toastr.error('El equipo existe en la OT');
        }else if(this.interno_equipo){
            this.ot_interno_equipos.push({
                ...this.interno_equipo
            });
            this.interno_equipo = '';
        }
    },

    submit :function () {

        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'ot_interno_equipos/ot/' + this.ot_id_data;
        console.log( urlRegistros);
        axios.put(urlRegistros, {

           interno_equipos : this.ot_interno_equipos,


        }).then(response => {
            this.errors=[];
            console.log(response);
            toastr.success('Equipos actualizados con éxito');

        }).catch(error => {

            this.errors = error.response.data.errors;
            $.each( this.errors, function( key, value ) {
                toastr.error(value,key);
                console.log( key + ": " + value );
            });

            if(this.errors = [] && error){

                toastr.error("Ocurrio un error al procesar la solicitud");
                this.ot_interno_equipos = this.ot_interno_equipos_data;
            }

        });
    }
 }

}

</script>
