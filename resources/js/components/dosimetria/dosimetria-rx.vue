<template>
    <div class="row">
        <div class="col-md-12">
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
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha">Período</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                                </div>
                                    <Datepicker v-model="periodo" :minimumView="'month'" :maximumView="'month'" :input-class="'form-control pull-right'" :language="es"></Datepicker>   
                            </div>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="form-group"> 
                            <label>Operador / Film</label>
                            <div class="input-group">
                                <input type="text" v-model="search" class="form-control">
                                <span class="input-group-addon"  style="background-color: #F9CA33;"><i class="fa fa-search"></i></span>
                            </div>  
                        </div>
                     </div>
                </div>
            </div>
            <div v-if="TablaDosimetriaRx.length">
                <div class="box box-custom-enod">
                    <div class="box-body">
                        <div class="col-md-9">
                            <div class="table-responsive">          
                                <table class="table table-hover table-striped table-border">
                                    <thead>
                                        <tr>                                     
                                            <th class="col-md-5">OPERADOR</th>
                                            <th class="col-md-1">FILM</th>
                                            <th style="text-align:center;" class="col-md-1">mSv</th>  
                                            <th style="text-align:center;" class="col-md-1"> PERIODO</th>
                                            <th class="col-md-2">                                          
                                                   
                                                <input type="checkbox" id="checkbox" v-model="sel_checkbox" style="vertical-align:middle"> 
                                                <span title="Setear Períodos" @click="SetearPeriodos()" style="display:inline-block;margin-left:11px;padding-top: 5px;" class="btn btn-xs btn-Primary"><app-icon img="edit" color="black"></app-icon></span>
                                                <span title="Borrar Períodos" @click="DeletePeriodos()" style="display:inline-block;margin-left:5px;padding-top: 5px;" class="btn btn-xs btn-Primary"><app-icon img="trash" color="black"></app-icon></span> 
                                                 
                                            </th>                                                     
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item,k) in TablaDosimetriaRx" :key="k" @click="selectPosTablaDosimetria(k)"> 
                                                        
                                        
                                                <td v-if="(!filtro(k))" bgcolor="#bee5eb">
                                                    {{item.operador}}
                                                </td>    
                                                <td v-if="(!filtro(k))" bgcolor="#bee5eb">
                                                    {{item.film}}
                                                </td>                                             
                                        
                                                <td v-if="(!filtro(k))" style="text-align:center;">
                                                    <div v-if="(indexPosTablaDosimetria == k) && (periodo)">       
                                                        <input type="number" :ref="'refInputMediciones'" v-model="TablaDosimetriaRx[k].milisievert" @keyup.enter="getFocus(k)" @input="setPeriodo(k)" step="0.01">        
                                                    </div>   
                                                    <div v-else>
                                                        {{item.milisievert}} 
                                                    </div>
                                                </td>   
                                                <td v-if="(!filtro(k))" style="text-align:center;">

                                                    {{ periodo_dosimetria(item.periodo) }}
                                                
                                                </td>  
                                                <td v-if="(!filtro(k))" >

                                                    <input type="checkbox" id="checkbox" v-model="TablaDosimetriaRx[k].sel">                     

                                                </td>                                                                                    
                                        </tr>                          
                                    </tbody>
                                </table>                     
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>    
            </div>
        </div>
        <div v-if="TablaDosimetriaRx.length">
            <a class="btn btn-primary" v-on:click="submit()" >Actualizar</a> 
        </div>
      </div>
    </div>
</template>

<script>
import {mapState} from 'vuex'
import Datepicker from 'vuejs-datepicker';
import {en, es} from 'vuejs-datepicker/dist/locale'
export default {

    components: {

      Datepicker
      
    },
   props :{

       operador_data : {
       type : Object,
       required : true 
       }

     },


  data () { return {

      en: en,
      es: es,
      TablaDosimetriaRx:[],
      year: '',
      month:'',
      periodo:'',
      years:[],
      months :[],
      indexPosTablaDosimetria : '-1',
      search:'',
      sel_checkbox:false
     
    }    
  },

  created : function() {
 
        this.$store.dispatch('loadFechaActual').then(response => {
            
            this.setYears();
            this.year = new Date(this.fecha).getFullYear();
            this.month = new Date(this.fecha).getMonth() + 1;
            this.setMonths();
            
       })
  },   

  watch : {

        month : function(val){

              if(val) { 

                this.indexPosTablaDosimetria = '-1';        
                this.$store.dispatch('loadDosimetriaRx',{year : this.year , month : this.month}).then(
                    response => {
                        
                        this.ResetTabla();

                    }
                );   
             }
        },

        sel_checkbox : function(val){

            this.TablaDosimetriaRx.forEach(function(item){
                
                item.sel = val;
            });
        }

  },
  
  computed :{

       ...mapState(['url','AppUrl','dosimetria_rx','fecha']),

       dia_actual : function(){

           return new Date(this.fecha).getDate();
       },

       mes_actual : function(){

           return new Date(this.fecha).getMonth() + 1;
       },

       anio_actual : function(){

           return new Date(this.fecha).getFullYear();
       },

    },
 
 methods : {

     setYears : function(){

         for (let year = 2019; year <= new Date(this.fecha).getFullYear();year++) {
          
             this.years.push(year);       
         }

     },

     periodo_dosimetria : function(fecha){

         if(fecha){

            return (new Date(fecha).getMonth() + 1) + '-' + new Date(fecha).getFullYear();

         }else{

             return null
         }

     },
    DeletePeriodos: function(){

        this.TablaDosimetriaRx.forEach(function(item){

            if(item.sel){

                item.periodo = '';
            }
        }.bind(this))

    },

    SetearPeriodos : function(){

        if(!this.periodo){

          toastr.error('El campo período es obligatorio para esta operación');
          return 

        }

        this.TablaDosimetriaRx.forEach(function(item){

            if(item.sel && item.milisievert){

                item.periodo = this.periodo;
            }
        }.bind(this))
    },

    filtro : function(index){
   
        if(this.search){

            if(this.TablaDosimetriaRx[index].operador.toLowerCase().includes(this.search.toLowerCase())||this.TablaDosimetriaRx[index].film.toString().includes(this.search))
            {
                return false

            }else{
                return true
            }
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

     setPeriodo : function(index){

         this.TablaDosimetriaRx[index].periodo = this.periodo;
     },

     getFocus(index){

            if(index < this.TablaDosimetriaRx.length - 1){

                this.indexPosTablaDosimetria = index + 1;
                
            }else 
            {
                 this.indexPosTablaDosimetria = 0;
            }

            setTimeout(x => {

                    this.$nextTick(() => {                
                        this.$refs['refInputMediciones'][0].focus();
                        });  
            }, 250);
     },

     ResetTabla : function() {

        this.TablaDosimetriaRx = [];
        this.TablaDosimetriaRx = this.dosimetria_rx ;
 
     },

    selectPosTablaDosimetria :function(index){
        
            this.indexPosTablaDosimetria = index ;
           
        },

     submit :function () {
       
        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'dosimetria_rx';  
                    
        axios.post(urlRegistros, {   
        
            year : this.year,
            month : this.month, 
            periodo : this.periodo,
            dosimetria_rx : this.TablaDosimetriaRx,              

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