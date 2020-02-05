<template>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-custom-enod">
                <div class="box-body">
                     <div class="col-md-6">
                        <div class="form-group">
                            <label>Operadores</label>
                            <v-select v-model="operador" :options="operadores_dosimetria" :getOptionLabel="getLabel" :disabled="!operador_data.can.D_Operador_Admin">
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
       
            <div class="box box-custom-enod">
                <div class="box-body">
                     <div class="col-md-12">
                        <div class="table-responsive">          
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>                                     
                                        <th style="text-align: center; min-width: 25px;" class="col-lg-1" >DÍA</th>     
                                        <th style="text-align:center;" class="col-lg-2">μSv</th>
                                        <th style="text-align:center;" class="col-lg-9">OBSERVACIONES</th>                                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item,k) in TablaDosimetria" :key="k" @click="selectPosTablaDosimetria(k)"> 
                                                    
                                        <td style="text-align:center;" bgcolor="#bee5eb"> {{item.day}} </td>    
                                        <td style="text-align:center;">
                                            <div v-if="(indexPosTablaDosimetria == k) && ((year < anio_actual) || ( (year == anio_actual) && (month < mes_actual)) || ((k + 1) <= dia_actual))">       
                                                <input type="number" :ref="'refInputMediciones'" v-model="TablaDosimetria[k].microsievert" :disabled="deshabilitarInput(item.created_at)">        
                                            </div>   
                                            <div v-else>
                                              {{item.microsievert}} 
                                            </div>
                                        </td>
                                        <td>
                                            <div v-if="(indexPosTablaDosimetria == k) && ((year < anio_actual) || ( (year == anio_actual) && (month < mes_actual)) || ((k + 1) <= dia_actual))">       
                                                <input type="text" v-model="TablaDosimetria[k].observaciones" size="65" maxlength="100">        
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
             </div>
            <div class="clearfix"></div>    
        </div>
        <a class="btn btn-primary" v-on:click="submit()" >Actualizar</a> 
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
      operador : JSON.parse(JSON.stringify(this.operador_data)),
      year: '',
      month:'',
      day :'',
      years:[],
      months :[],
      indexPosTablaDosimetria : '0',
     
    }    
  },

  created : function() {
 
        this.$store.dispatch('loadFechaActual').then(response => {
            
            this.$store.dispatch('loadOperadoresDisometria'); 
            this.indexPosTablaDosimetria = this.dia_actual-1;
            this.setYears();
            this.year = new Date(this.fecha).getFullYear();
            this.month = new Date(this.fecha).getMonth() + 1;
            this.day = new Date(this.fecha).getDate();
            console.log('el dia de hoy es:');
            console.log(this.day);
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

                    this.$store.dispatch('loadDosimetriaOperador',{operador_id : this.operador.id, year : this.year , month : this.month}).then(
                        response => {
                            
                            this.ResetTabla();
    
                        }
                    );  

                }); 
             }
        }
  },
  
  computed :{

       ...mapState(['url','AppUrl','operadores_dosimetria','DiasDelMes','dosimetria_operador','fecha']),

       dia_actual : function(){

           return new Date(this.fecha).getDate();
       },

       mes_actual : function(){

           return new Date(this.fecha).getMonth() + 1;
       },

       anio_actual : function(){

           return new Date(this.fecha).getFullYear();
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

    console.log(val);
     console.log(val);
      console.log(val);
        console.log(val);
         console.log(val);
          console.log(val);

          let $con = ((!this.operador_data.can.D_Operador_Admin) );
          console.log('$con');
          console.log($con);
          console.log($con);
          console.log($con);
          console.log($con);

        if((this.operador_data.can.D_Operador_Admin) || (val=='')){

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

            });
        }

        this.dosimetria_operador.forEach(function(item) {
            
           this.TablaDosimetria[item.day-1].microsievert = item.microsievert;
           this.TablaDosimetria[item.day-1].observaciones = item.observaciones;
            this.TablaDosimetria[item.day-1].created_at = item.created_at;

        }.bind(this));

            setTimeout(x => {

            this.$nextTick(() => {                
                this.$refs['refInputMediciones'][0].focus();
                });  
            },250);

     },

    selectPosTablaDosimetria :function(index){
        
            this.indexPosTablaDosimetria = index ;
           
        },

     submit :function () {
       
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
                toastr.success('dosimetrīa  actualizado con éxito');                
                
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
  
            });
        }

 },
  
}
</script>

<style scoped>

   
</style>