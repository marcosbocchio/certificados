<template>
    <div>
       <div class="col-md-6 col-md-offset-3">

            <div class="box box-custom-enod top-buffer">
                <div class="box-header with-border">
                    <h3 class="box-title">Alarmas de documentaciones</h3>
               </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th class="col-md-6">Tipo</th>
                                    <th class="col-md-3" style="text-align: center;" >Días 1.º aviso </th>
                                    <th class="col-md-3" style="text-align: center;">Días 2.º aviso</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(alarma,k) in alarmas" :key="k" @click="selectPosAlarmas(k)">
                                    <td>{{ alarma.tipo }}</td>
                                    <td style="text-align: center;">
                                         <div v-if="indexPosAlarmas == k ">
                                            <input type="number" v-model="alarmas[k].aviso1" width="100%" min="0" step="1">
                                         </div>
                                         <div v-else>
                                            {{ alarma.aviso1 }}
                                         </div>
                                    </td>
                                    <td style="text-align: center;">
                                         <div v-if="indexPosAlarmas == k ">
                                            <input type="number" v-model="alarmas[k].aviso2" width="100%" min="0" step="1">
                                         </div>
                                         <div v-else>
                                            {{ alarma.aviso2 }}
                                         </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div v-if="loading_table" class="overlay">
                    <loading-spin></loading-spin>
                </div>
            </div>



            <div class="box box-custom-enod top-buffer">
                <div class="box-header with-border">
                    <h3 class="box-title">Alarmas de dosimetría</h3>
                </div>
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="aviso1_dosimetria">Período notificación * </label>
                            <v-select v-model.number="aviso1_dosimetria" label="semana"  :options="semanas" id="aviso1_dosimetria" required></v-select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                             <label for="aviso2_dosimetria">Días para el aviso *</label>
                             <input type="number" v-model="aviso2_dosimetria" class="form-control" min="0" step="1"  id="aviso2_dosimetria" required>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div v-show="$can('M_alarmas')">
                    <button class="btn btn-primary" @click="StoreAlarmas">Actualizar</button>
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
     indexPosAlarmas :-1,
     loading_table: false,
     aviso1_dosimetria : '',
     aviso2_dosimetria : '',
     errors : [],
     semanas : [

        { 'semana'  : '1 Semanas' ,  'dias': '7' },
        { 'semana'  : '2 Semanas' ,  'dias': '14' },
        { 'semana'  : '3 Semanas' ,  'dias': '21' },
        { 'semana'  : '4 Semanas' ,  'dias': '28' },

        ]
     }
    },

mounted : function(){

    this.getAlarmas();
    this.getAlarmaDosimetria();

},

  computed :{

       ...mapState(['url'])
     },

methods : {

    selectPosAlarmas :function(index){

        this.indexPosAlarmas = index ;

    },

    getAlarmas :  function(){
        this.loading_table = true ;
        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'alarmas' + '?api_token=' + Laravel.user.api_token;
        axios.get(urlRegistros).then(response =>{

            this.alarmas = response.data

       }).finally(()=> { this.loading_table = false;});

    },

    getAlarmaDosimetria :  function(){
        this.loading_table = true ;
        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'alarmas/dosimetria' + '?api_token=' + Laravel.user.api_token;
        axios.get(urlRegistros).then(response =>{

            this.aviso2_dosimetria = response.data

       }).finally(()=> { this.loading_table = false;});

    },


   StoreAlarmas : function(){


        this.errors =[];

        var urlRegistros = 'alarmas' ;
        axios({
        method: 'post',
        url : urlRegistros,
        data : {
            'alarmas'                 : this.alarmas,
            'aviso1_dosimetria'       : this.aviso1_dosimetria,
            'aviso2_dosimetria'       : this.aviso2_dosimetria,
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

        });

        },

}

}
</script>
