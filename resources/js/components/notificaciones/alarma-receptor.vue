<template>
<div>
    <div class="col-md-6">
        <div class="box box-custom-enod">
            <div class="box-body">
                <div class="form-group">
                    <label>Alarmas</label>
                    <v-select v-model="alarma" :options="alarmas" label="tipo" @input="getReceptores"> </v-select>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
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
    alarma : {},
    indexPosAReceptores :-1,
    loading_table: false,
    }
},

mounted : function(){

    this.getAlarmas();

},

computed :{

    ...mapState(['url'])

    },

methods  : {

    async getAlarmas(){

       axios.defaults.baseURL = this.url ;
       var urlRegistros = 'alarmas/todas' + '?api_token=' + Laravel.user.api_token;
       await axios.get(urlRegistros).then(response =>{

            this.alarmas = response.data;

       })

    },

    async getReceptores(){

       this.loading_table = true ;
       axios.defaults.baseURL = this.url ;
       var urlRegistros = 'alarma-receptor/alarma/'+ this.alarma.id + '?api_token=' + Laravel.user.api_token;
       alert('Entro en getReceptores con id: ' + urlRegistros )
       await axios.get(urlRegistros).then(response =>{

            this.receptores = response.data;

       }).finally(()=> {this.indexPosAReceptores=-1; this.loading_table = false;});


    },


}

}
</script>
