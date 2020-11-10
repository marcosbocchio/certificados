<template>
<div class="row">
    <div class="col-sm-6">
        <div class="box box-custom-enod">
            <div class="box-body">
                <div class="col-sm-10">
                    <div class="form-group">
                        <label>Alarmas</label>
                        <v-select v-model="alarma" :options="alarmas" label="tipo" @input="getReceptores"> </v-select>
                    </div>
                </div>
                <div class="col-sm-10">
                    <div class="form-group">
                        <label>Operadores</label>
                        <v-select v-model="operador" :options="operadores_empresa" label="name" :disabled="!alarma"> </v-select>
                    </div>
                </div>

                <div class="col-sm-2">
                     <p>&nbsp;</p>
                      <span>
                          <button type="button" class="form-group" @click="addReceptor()"><span class="fa fa-plus-circle"></span></button>
                      </span>
                </div>

                <div class="clearfix"></div>

                <div class="col-sm-12">
                    <button class="btn btn-primary" @click="Store">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="box box-custom-enod">
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-condensed">
                        <thead>
                            <tr>
                                <th  class="col-sm-12">NOMBRE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(receptor,k) in receptores" :key="k">
                                <td  class="col-sm-12"> {{receptor.name}}</td>
                                <td> <i class="fa fa-minus-circle" @click="removeReceptor(k)" ></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div v-if="loading_table" class="overlay">
                <loading-spin></loading-spin>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import {mapState} from 'vuex'
export default {

data () { return {

    alarmas: [],
    receptores: [],
    operador:'',
    alarma : '',
    indexPosAReceptores :-1,
    loading_table: false,
    }
},

mounted : function(){

    this.getAlarmas();
    this.$store.dispatch('loadOperadoresEmpresa');
},

computed :{

    ...mapState(['url','operadores_empresa'])

    },

methods  : {

    async getAlarmas(){

       axios.defaults.baseURL = this.url ;
       var urlRegistros = 'alarmas/todas' + '?api_token=' + Laravel.user.api_token;
       await axios.get(urlRegistros).then(response =>{

            this.alarmas = response.data;
            this.alarma  = this.alarmas[0];

       });
       this.getReceptores();

    },

    async getReceptores(){

       this.loading_table = true ;
       this.operador ='';
       axios.defaults.baseURL = this.url ;
       var urlRegistros = 'alarma-receptor/alarma/' + (this.alarma ? this.alarma.id : 'null') + '?api_token=' + Laravel.user.api_token;
       await axios.get(urlRegistros).then(response =>{

            this.receptores = response.data;

       }).finally(()=> {this.indexPosAReceptores=-1; this.loading_table = false;});


    },

    addReceptor : function () {

        if(!this.operador)  return;

        let index = this.receptores.findIndex(elemento => elemento.id == this.operador.id)
        if (index != -1){

            this.$showMessagePreset('error','code-repeat');
            return;
        }


        this.receptores.push({
              ...this.operador
            });

        },

    removeReceptor : function(index){

        this.receptores.splice(index, 1);

    },

    Store : function(){

        this.errors =[];

        var urlRegistros = 'alarma-receptor';
        axios({
        method: 'post',
        url : urlRegistros,
        data : {
            'alarma'           : this.alarma,
            'receptores'       : this.receptores,
            }

        }).then(response => {

            this.$showMessagePreset('success','code-200');

        }).catch(error => {

        this.errors = error.response.data.errors;
            console.log(error.response);
        $.each( this.errors, function( key, value ) {
            this.$showMessages('error',[value]);
        });

        if((typeof(this.errors)=='undefined') && (error)){

            this.$showMessagePreset('error','code-500');

            }

         }).finally(()=> {this.getReceptores() });

        },

    }

}
</script>
