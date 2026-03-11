<template>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-custom-enod">
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Operador</label>
                            <div class="modulo-style">
                                <v-select multiple v-model="operadores" multiselect label="name" :options="operadores_dosimetria" ></v-select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box box-custom-enod">
                <div class="box-body">
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
            <div v-show="TablaDosimetria.length">
                <div class="box box-custom-enod">
                    <div class="box-body">

                        <div class="col-md-12">
                           <div class="form-group" >
                                <button @click="ExportarPdf">Exportar PDF</button>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;min-width:200px;">OPERADOR</th>
                                            <th style="text-align:center;">DNI</th>
                                            <th style="text-align:center;">FILM</th>
                                            <th style="text-align:center;" v-for="(d) in days_in_month" :key="d" >{{d}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr v-for="(item,k) in TablaDosimetria" :key="k">
                                                <td bgcolor="#000000" style="text-align:center;" :class="[{habilitadoArn : item.habilitado_arn_sn},{ deshabilitadoArn : !item.habilitado_arn_sn}]">{{item.name}}</td>
                                                <td style="text-align:center;">{{item.dni}}</td>
                                                <td style="text-align:center;">{{item.film}}</td>
                                                <td style="text-align:center;" v-for="(d) in days_in_month" :key="d">{{ TablaDosimetria[k][`${d}`] }}</td>
                                            </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      </div>
        <loading :active.sync="isLoading"
            :loader="'bars'"
            :color="'red'">
        </loading>
    </div>
</template>

<script>

import {mapState} from 'vuex'
import moment from 'moment';
import Loading from 'vue-loading-overlay';
export default {

    components: {
        Loading
     },

  data () { return {

      TablaDosimetriaTemp:[],
      year: '',
      month:'',
      days_in_month :0,
      years:[],
      months :[],
      operadoresIds: [],
      operadores:[],
    }
  },

  created : function() {
      this.$store.dispatch('loadOperadoresDisometria');
        this.$store.dispatch('loadFechaActual').then(response => {
            this.setYears();
            this.setMonths();
            this.year = new Date(this.fecha).getFullYear();
            this.month = new Date(this.fecha).getMonth() + 1;
            this.days_in_month = new Date(this.year, this.month, 0).getDate();
            this.$store.commit('loading', true);
            this.$store.dispatch('loadDosimetriaMensualOperadores',{year : this.year , month : this.month}).then(response => {
                this.ResetTabla();
                this.$store.commit('loading', false);

            });

       })
  },

  watch : {
        month : function(val){

              if(val) {
                 this.$store.commit('loading', true);
                    this.$store.dispatch('loadDosimetriaMensualOperadores',{year : this.year , month : this.month}).then(response => {
                        this.ResetTabla();
                         this.$store.commit('loading', false);
                    });
             }
        }
  },

  computed :{

       ...mapState(['url','operadores_dosimetria','DiasDelMes','dosimetria_operadores','fecha','isLoading']),

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

       },

       ids_oper_export: function () {
           return this.operadores.length ? this.operadores.map(item=> item.id).toString() : this.operadoresIds.toString();
       },
       TablaDosimetria : function() {

            if (!this.operadores.length){
                return this.TablaDosimetriaTemp
            }
            else{

             var operadores_temp = this.operadores
             return this.TablaDosimetriaTemp.filter(function(array_el){
                        return operadores_temp.filter(function(anotherOne_el){
                            return anotherOne_el.id == array_el.user_id;
                        }).length != 0
                    });
            }
       }
    },

 methods : {

     setYears : function(){

         for (let year = 2019; year <= new Date(this.fecha).getFullYear();year++) {

             this.years.push(year);
         }

     },

     setMonth :  function (){

         this.month = '';
         this.TablaDosimetriaTemp = [];
         this.setMonths();

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

    ResetTabla : function() {

        this.days_in_month = new Date(this.year, this.month, 0).getDate();
        this.TablaDosimetriaTemp = [];
        this.operadoresIds =[...new Set(this.dosimetria_operadores.map(item=> item.user_id))];

        for (let index = 0; index < this.operadoresIds.length; index++) {

            for (let index2 = 0; index2 < this.dosimetria_operadores.length; index2++) {
                if(this.operadoresIds[index] == this.dosimetria_operadores[index2].user_id){

                this.TablaDosimetriaTemp.push({

                    user_id : this.dosimetria_operadores[index2].user_id,
                    name : this.dosimetria_operadores[index2].name,
                    film : this.dosimetria_operadores[index2].film,
                    dni : this.dosimetria_operadores[index2].dni,
                    habilitado_arn_sn : this.dosimetria_operadores[index2].habilitado_arn_sn,
                });
                break;
            }
            };
        }

        for (let index = 0; index < this.dosimetria_operadores.length; index++) {
            let index_do = this.TablaDosimetriaTemp.findIndex(elem => elem.user_id == this.dosimetria_operadores[index].user_id)
            Object.defineProperty(this.TablaDosimetriaTemp[index_do],moment(this.dosimetria_operadores[index].fecha,'YYYY/MM/DD').date().toString(),{configurable: true, value:this.dosimetria_operadores[index].microsievert});
        }
        console.log(this.TablaDosimetriaTemp);
     },

     ExportarPdf: function () {
        window.open( '/pdf/dosimetria_mensual_operadores/year/' + this.year + '/month/' + this.month + '/operadores_ids/' + this.ids_oper_export,'_blank');
     }
 },

}
</script>

<style scope>

.modulo-style .v-select .vs__selected-options{
    flex-wrap: wrap;
    white-space: wrap;
    overflow: wrap;
}


</style>
