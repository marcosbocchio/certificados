<template>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-custom-enod">
                <div class="box-body">
                     <div class="col-md-6">
                        <div class="form-group">
                            <label>Operadores</label>
                            <v-select v-model="operador" :options="operadores_dosimetria" :getOptionLabel="getLabel" :disabled="!$can('D_operador_Admin')">
                                <template slot="option" slot-scope="option">
                                    <span class="upSelect">{{ option.name }} </span> <br>
                                    <span class="downSelect"> {{ option.film }} </span>
                                </template>
                            </v-select>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="form-group">
                            <label>Año</label>
                            <v-select v-model="year" label="name" :options="years" @input="setMonth()" ></v-select>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="form-group">
                            <label>Mes</label>
                            <v-select v-model="month" label="name" :options="months" ></v-select>
                        </div>
                    </div>
                </div>
            </div>

        <div v-if="show_tabla">

            <div class="box box-custom-enod">
                <div class="box-body">
                     <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th style="text-align: center; min-width: 25px;" class="col-lg-1" >Día</th>
                                        <th style="text-align:center;" class="col-lg-2">μSv</th>
                                        <th style="text-align:center;" class="col-lg-9">Observaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item,k) in TablaDosimetria" :key="k" @click="selectPosTablaDosimetria(k)">

                                        <td style="text-align:center;" bgcolor="#bee5eb"> {{item.day}} </td>
                                        <td style="text-align:center;">
                                            <div v-if="(indexPosTablaDosimetria == k) && ((year < anio_actual) || ( (year == anio_actual) && (month < mes_actual)) || ((k + 1) <= dia_actual))">
                                                <input type="number" :ref="'refInputMediciones'" v-model="TablaDosimetria[k].microsievert" :disabled="deshabilitarInput(item.created_at)" min="0">
                                            </div>
                                            <div v-else>
                                              {{item.microsievert}}
                                            </div>
                                        </td>
                                        <td>
                                            <div v-if="(indexPosTablaDosimetria == k) && ((year < anio_actual) || ( (year == anio_actual) && (month < mes_actual)) || ((k + 1) <= dia_actual))">
                                                <input type="text" v-model="TablaDosimetria[k].observaciones" size="65" maxlength="100" :disabled="deshabilitarInput(item.created_at)">
                                            </div>
                                            <div v-else>
                                              {{item.observaciones}}
                                            </div>
                                        </td>

                                    </tr>

                                </tbody>
                            </table>
                       </div>
                </div>
                <div v-if="isLoading" class="overlay">
                    <loading-spin></loading-spin>
                </div>
             </div>
            <div class="clearfix"></div>
        </div>
        <button type="button" class="btn btn-primary" v-on:click.prevent="submit()" :disabled="isLoading">Actualizar</button>
        </div>

      </div>
    </div>
</template>

<script>
import {mapState} from 'vuex'

export default {

   props :{

       operador_data : {
       type : Object,
       required : true
       }
     },

  data () { return {

      TablaDosimetria:[],
      operador :'',
      year: '',
      month:'',
      day :'',
      years:[],
      months :[],
      indexPosTablaDosimetria : '0',

    }
  },

  created : function() {

        if(this.operador_data.film){
            this.operador = JSON.parse(JSON.stringify(this.operador_data));
        }

        this.$store.dispatch('loadFechaActual').then(response => {
            this.$store.dispatch('loadOperadoresDisometria');
            this.indexPosTablaDosimetria = this.dia_actual-1;
            this.setYears();
            this.year = new Date(this.fecha).getFullYear();
            this.month = new Date(this.fecha).getMonth() + 1;
            this.day = new Date(this.fecha).getDate();
            this.setMonths();

       })
  },

  watch : {

        operador : function(){

            this.year='';
            this.month='';
            this.TablaDosimetria = []

        },

        month : function(val){

              if(val) {

                if((this.year!=new Date(this.fecha).getFullYear()) || (val != new Date(this.fecha).getMonth() + 1)){

                      this.indexPosTablaDosimetria = '0'

                } else{

                     this.indexPosTablaDosimetria = this.dia_actual-1;

                }

               this.$store.dispatch('loadDiasDelMes',{year : this.year , month : this.month}).then(response =>{
                   this.$store.commit('loading', true);
                    this.$store.dispatch('loadDosimetriaOperador',{operador_id : this.operador.id, year : this.year , month : this.month}).then(response => {

                          this.ResetTabla();
                          this.$store.commit('loading', false);
                        }
                    );

                });
             }
        }
  },

  computed :{

       ...mapState(['url','operadores_dosimetria','DiasDelMes','dosimetria_operador','fecha','isLoading']),

       dia_actual : function(){

           return new Date(this.fecha).getDate();
       },

       mes_actual : function(){

           return new Date(this.fecha).getMonth() + 1;
       },

       anio_actual : function(){

           return new Date(this.fecha).getFullYear();
       },

       show_tabla : function(){

        return (!this.operador || !this.year || !this.month) ? false : true;

       }

    },

 methods : {


   getLabel(option) {
      return `${option.name} ${option.film}`
    },

     setYears : function(){

         for (let year = 2019; year <= new Date(this.fecha).getFullYear();year++) {

             this.years.push(year);
         }

     },

     setMonths : function(){

         this.months = [];

         if(this.year < new Date(this.fecha).getFullYear()){

             this.months = ['1','2','3','4','5','6','7','8','9','10','11','12']

         }else{

            for (let month = 1; month <= new Date(this.fecha).getMonth() + 1; month++) {

                this.months.push(month);

            }

         }
     },

     setMonth :  function (){

         this.month = '';
         this.TablaDosimetria = [];
         this.setMonths();

     },


    deshabilitarInput(val){

    let deshabilitar = false;
    let esMismoDia = this.ComprobarMismoDia(val);

    if((this.$can('D_operador_Admin')) || (val=='')){

        console.log('el val es vacio');

            deshabilitar = false;

    }else{

        if(esMismoDia){

            deshabilitar = false;

        }else{

            deshabilitar = true;
        }
    }

    return deshabilitar;

    },

    ComprobarMismoDia : function(val){

         let dateTimeParts= val.split(/[- :]/);
         let val2 = dateTimeParts[0] + '/' + dateTimeParts[1] + '/' + dateTimeParts[2];
         let year_val = new Date(val2).getFullYear();
         let month_val = new Date(val2).getMonth() + 1;
         let day_val = new Date(val2).getDate();

         if(this.year != year_val || this.month !=month_val || this.day!=day_val){

             return false

         }else{
             return true;
         }

     },

    ResetTabla : function() {

        this.TablaDosimetria = [];

        for (let index = 0; index < this.DiasDelMes; index++) {

            this.TablaDosimetria.push({

                day : index + 1,
                microsievert : '',
                observaciones : '',
                created_at : '',
                id :'',

            });
        }

        this.dosimetria_operador.forEach(function(item) {

           this.TablaDosimetria[item.day-1].id = item.id;
           this.TablaDosimetria[item.day-1].microsievert = String(item.microsievert);
           this.TablaDosimetria[item.day-1].observaciones = item.observaciones;
           this.TablaDosimetria[item.day-1].created_at = item.created_at;

        }.bind(this));

        setTimeout(x => {

        this.$nextTick(() => {
            if(this.$refs['refInputMediciones']){

                this.$refs['refInputMediciones'][0].focus();
            }
            });
        },250);

     },

    selectPosTablaDosimetria :function(index){

        this.indexPosTablaDosimetria = index ;

    },

    submit :function () {
        this.$store.commit('loading', true);
        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'dosimetria_operador';

        axios.post(urlRegistros, {

        operador : this.operador,
        year : this.year,
        month : this.month,
        dosimetria_operadores : this.TablaDosimetria,

        }).then(response => {
            this.errors=[];
            console.log(response);
            this.$store.dispatch('loadDosimetriaOperador',{operador_id : this.operador.id, year : this.year , month : this.month}).then(
                    response => {

                        this.ResetTabla();

                    }
                );
            toastr.success('dosimetrīa actualizado con éxito');
            this.$store.commit('loading', false);

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
            this.$store.commit('loading', false);
        }).finally(()=> {   });
    }

 },

}
</script>

<style scoped>


</style>
