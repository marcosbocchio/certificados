<template>
  <div>
    <div class="col-md-12">
        <div v-if="$can('T_proc_edita')">
            <div class="box box-custom-enod">
                <div class="box-header with-border">
                <h3 class="box-title">Procedimientos clientes</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" >
                                        <label for="tipo_soldaduras">Tipo Sol.</label>
                                        <v-select v-model="tipo_soldadura" label="codigo" :options="tipo_soldaduras"></v-select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="obra">Obra Nº </label>
                                        <input v-model="obra" type="text" class="form-control" id="obra" placeholder="" maxlength = "15" :disabled="otdata.obra">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group" >
                                        <label for="procedimientos_soldadura">EPS / WPS *</label>
                                        <input type="text" v-model="eps" class="form-control" id="procedimientos_soldadura" maxlength="30">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group" >
                                        <label for="pqr">PQR *</label>
                                        <input type="text" v-model="pqr" class="form-control" id="pqr" maxlength="30">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="proc_reparacion">Proc.Reparación *</label>
                                        <input type="text" v-model="proc_reparacion" class="form-control" id="proc_reparacion" maxlength="30">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <span>
                            <button type="button" @click="addTipoSoldaduras()"><span class="fa fa-plus-circle"></span></button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div v-show="TablaTipoSoldaduras.length">
            <div class="box box-custom-enod">
                <div class="box-header with-border">
                    <div class="table-responsive">
                    <table class="table table-hover table-striped table-condensed">
                        <thead>
                            <tr>
                                <th  class="col-md-1">Tipo Sol.</th>
                                <th class="col-md-2">Obra</th>
                                <th class="col-md-3">EPS</th>
                                <th class="col-md-3">PQR</th>
                                <th class="col-md-3">Proc. Reparación</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item,k) in TablaTipoSoldaduras" :key="k" @click="selectPosTablaTipoSoldaduras(k)">

                                <td>{{ item.tipo_soldadura.codigo}}</td>
                                <td>{{ item.obra}} </td>
                                <td v-if="indexTablaTipoSoldaduras ==  k">
                                    <input type="text" v-model="TablaTipoSoldaduras[k].eps" maxlength="30">
                                </td>
                                    <td v-else>{{ item.eps}} </td>
                                <td v-if="indexTablaTipoSoldaduras ==  k">
                                    <input type="text" v-model="TablaTipoSoldaduras[k].pqr" maxlength="30">
                                </td>
                                <td v-else>{{ item.pqr }}</td>
                                <td v-if="indexTablaTipoSoldaduras ==  k">
                                    <input type="text" v-model="TablaTipoSoldaduras[k].proc_reparacion" maxlength="30">
                                </td >
                                <td v-else>{{ item.proc_reparacion }}</td>
                                <td style="text-align:center"> <i class="fa fa-minus-circle" @click="removeTipoSoldadura(k)" ></i></td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="$can('T_proc_edita')">
            <button class="btn btn-primary" v-on:click.prevent="submit()">Actualizar</button>
        </div>

    </div>
</div>
</template>
<script>
  import {mapState} from 'vuex'
  export default {

    props : {

     otdata : {

        type: Object,
        required: true

       },
    },

    data() {return {

      tipo_soldaduras: [],
      tipo_soldadura : {},
      TablaTipoSoldaduras : [],
      obra:this.otdata.obra,
      eps:'',
      pqr :'',
      id :'',
      proc_reparacion:'',
      indexTablaTipoSoldaduras:-1,
    }

    },

    created : function() {

    this.getTipoSoldaduras();
    this.getOtTipoSoldaduras();


    },

     computed :{

       ...mapState(['url','ot_tipo_soldaduras'])
     },

     methods : {

    getOtTipoSoldaduras : function(){

        this.$store.dispatch('loadOtTipoSoldaduras',this.otdata.id).then(response => {

            this.TablaTipoSoldaduras = this.ot_tipo_soldaduras;

        });

    },

     getTipoSoldaduras : function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'tipo_soldaduras' + '?api_token=' + Laravel.user.api_token;
            axios.get(urlRegistros).then(response =>{

                this.tipo_soldaduras = response.data

            });

        },

    addTipoSoldaduras: function(){

        if(jQuery.isEmptyObject(this.tipo_soldadura) || jQuery.isEmptyObject(this.obra) || !this.eps  || !this.pqr || !this.proc_reparacion ){

            return;
        }

        let Existe = false;
        this.TablaTipoSoldaduras.forEach(function(item){

            if(item.tipo_soldadura.id == this.tipo_soldadura.id && item.obra == this.obra && this.eps == item.eps && this.pqr == item.pqr && this.proc_reparacion == item.proc_reparacion){
                Existe = true;
            }

        }.bind(this))


        if(Existe){

            toastr.error('El tipo soldadura / Obra existe en la ot');
            return;

         }

        this.TablaTipoSoldaduras.push({

            obra:this.obra,
            tipo_soldadura : this.tipo_soldadura,
            eps:this.eps,
            pqr : this.pqr,
            proc_reparacion : this.proc_reparacion,
            id : 0
            });

        this.tipo_soldadura = {};
        this.eps = '';
        this.pqr = '';
        this.proc_reparacion = '';
        this.obra = this.otdata.obra;

    },

    selectPosTablaTipoSoldaduras : function(index){
        this.indexTablaTipoSoldaduras = index;
    },

    removeTipoSoldadura : function(index){

        this.TablaTipoSoldaduras.splice(index, 1);

    },

    submit :function () {

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'ot_tipo_soldaduras';

            axios.post(urlRegistros, {

            ot: this.otdata,
            tipo_soldaduras : this.TablaTipoSoldaduras,

            }).then(response => {
                this.errors=[];
                console.log(response);
                toastr.success('Los tipos soldaduras fueron acualizados con éxito');

            }).catch(error => {

                this.errors = error.response.data.errors;
                $.each( this.errors, function( key, value ) {
                    toastr.error(value,key);
                    console.log( key + ": " + value );
                });

                if(this.errors = [] && error){

                     toastr.error("Ocurrio un error al procesar la solicitud");
                     this.users_ot_operarios = this.ot_operarios_data;
                }

            }).finally(() => this.getOtTipoSoldaduras() );
        }

    },

  }
</script>
