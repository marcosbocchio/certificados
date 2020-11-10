<template>
    <div class="row">
       <div class="col-sm-8 col-sm-offset-2">

            <div class="box box-custom-enod top-buffer">
                <div class="box-header with-border">
                    <h3 class="box-title">Alarmas de documentaciones</h3>
               </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th class="col-md-5">Tipo</th>
                                    <th class="col-md-3" style="text-align: center;" >Días 1.º aviso </th>
                                    <th class="col-md-3" style="text-align: center;">Días 2.º aviso</th>
                                    <th class="col-md-1" style="text-align: center;">Activo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(alarma,k) in alarmas" :key="k" class="pointer">
                                    <td>{{ alarma.tipo }}</td>
                                    <td style="text-align: center;" @click="selectPosAlarmas(k)">
                                         <div v-if="indexPosAlarmas == k ">
                                            <input type="number" v-model="alarmas[k].aviso1" width="100%" min="0" step="1">
                                         </div>
                                         <div v-else>
                                            {{ alarma.aviso1 }}
                                         </div>
                                    </td>
                                    <td style="text-align: center;" @click="selectPosAlarmas(k)">
                                         <div v-if="indexPosAlarmas == k ">
                                            <input type="number" v-model="alarmas[k].aviso2" width="100%" min="0" step="1">
                                         </div>
                                         <div v-else>
                                            {{ alarma.aviso2 }}
                                         </div>
                                    </td>
                                    <td style="text-align: center;">
                                        <input type="checkbox" id="checkbox" v-model="alarmas[k].activo_sn">
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
                    <div class="form-group">
                        <div class="col-md-12">
                                <input type="checkbox" id="activo_sn_dosimetria" v-model="activo_sn_dosimetria" style="float:right">
                                <label for="activo_sn_dosimetria" style="float:right;margin-right: 5px;" class="pointer">Activo</label>
                        </div>
                    </div>
                         <div class="clearfix"></div>
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
                <button class="btn btn-primary" @click="StoreAlarmas">Actualizar</button>
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
     activo_sn_dosimetria : false,
     errors : [],
     semanas : [

        { 'semana'  : '1 semanas' ,  'dias': '7' },
        { 'semana'  : '2 semanas' ,  'dias': '14' },
        { 'semana'  : '3 semanas' ,  'dias': '21' },
        { 'semana'  : '4 semanas' ,  'dias': '28' },

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

    async getAlarmas(){

       this.loading_table = true ;
       axios.defaults.baseURL = this.url ;
       var urlRegistros = 'alarmas' + '?api_token=' + Laravel.user.api_token;
       await axios.get(urlRegistros).then(response =>{

            this.alarmas = response.data;

       }).finally(()=> {this.indexPosAlarmas=-1; this.loading_table = false;});


    },

    async getAlarmaDosimetria() {
        this.loading_table = true ;
        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'alarmas/dosimetria' + '?api_token=' + Laravel.user.api_token;
        await axios.get(urlRegistros).then(response =>{

            let res = response.data;
            this.aviso1_dosimetria = this.semanas[this.semanas.findIndex(elemento => elemento.dias == res.aviso1)];
            this.aviso2_dosimetria = res.aviso2;
            this.activo_sn_dosimetria = res.activo_sn;

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
            'activo_sn_dosimetria'    : this.activo_sn_dosimetria,
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

         }).finally(()=> { this.getAlarmas();this.getAlarmaDosimetria()});

        },

}

}
</script>
