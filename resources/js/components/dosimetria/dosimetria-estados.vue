<template>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger">
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
                            <label>Operador</label>
                            <div class="input-group">
                                <input type="text" v-model="search" class="form-control">
                                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                            </div>  
                        </div>
                     </div>
                </div>
            </div>

            <div v-if="TablaDosimetriaEstados.length">
                <div class="box box-danger">
                    <div class="box-body">
                        <div class="col-md-9">
                            <div class="table-responsive">          
                                <table class="table table-hover table-striped table-border">
                                    <thead>
                                        <tr>                                     
                                            <th class="col-md-5">OPERADOR</th>
                                            <th class="col-md-1">FILM</th>
                                            <th style="text-align:center;" class="col-md-2">ESTADO</th> 
                                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item,k) in TablaDosimetriaEstados" :key="k" @click="selectPosTablaDosimetria(k)"> 
                                                        
                                                <td v-if="(!filtro(k))" bgcolor="#bee5eb">
                                                    {{item.operador}}
                                                </td>    
                                                <td v-if="(!filtro(k))" bgcolor="#bee5eb">
                                                    {{item.film}}
                                                </td>                                             
                                        
                                                <td v-if="(!filtro(k))" style="text-align:center;">
                                                    <div v-if="(indexPosTablaDosimetria == k)">      
                                                        <v-select v-model="TablaDosimetriaEstados[k].estado" :reduce="descripcion => descripcion" label="descripcion" :options="estados" ></v-select> 
                                                    </div>
                                                    <div v-else-if="item.estado">
                                                        {{item.estado.descripcion}}
                                                    </div>
                                                    <div v-else>
                                                        {{item.estado}}
                                                    </div>
                                                </td>                                                                           
                                        </tr>   
                                        <tr v-for="fila in 8" >
                                            <td colspan="3" style="border:none; background: #FFFFFF"> &nbsp;</td>                                                  
                                        </tr>                                                               
                                    </tbody>
                                </table>                     
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>    
                </div>
                <div v-if="TablaDosimetriaEstados.length">        
                    <a class="btn btn-primary" v-on:click="submit()" >Actualizar</a> 
                </div>
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
      TablaDosimetriaEstados:[],
      year: '',
      month:'',
      estados:[],
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
            
       });

     this.getEstados();
  },   

  watch : {

        month : function(val){

              if(val) { 

                this.indexPosTablaDosimetria = '-1';        
                this.$store.dispatch('loadDosimetriaEstados',{year : this.year , month : this.month}).then(
                    response => {
                        
                        this.ResetTabla();

                    }
                );   
             }
        },

        sel_checkbox : function(val){

            this.TablaDosimetriaEstados.forEach(function(item){
                
                item.sel = val;
            });
        }

  },
  
  computed :{

       ...mapState(['url','AppUrl','dosimetria_estados','fecha']),

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

     getEstados : function(){      
             
        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'estados_operador_rx/estados' + '?api_token=' + Laravel.user.api_token;        
        axios.get(urlRegistros).then(response =>{
        this.estados = response.data
        });      

     },

     setYears : function(){

         for (let year = 2019; year <= new Date(this.fecha).getFullYear();year++) {
          
             this.years.push(year);       
         }

     }, 

    filtro : function(index){
   
        if(this.search){

            if(this.TablaDosimetriaEstados[index].operador.toLowerCase().includes(this.search.toLowerCase()))
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

     getFocus(index){

            if(index < this.TablaDosimetriaEstados.length - 1){

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

        this.TablaDosimetriaEstados = [];
        this.TablaDosimetriaEstados = this.dosimetria_estados ;
 
     },

    selectPosTablaDosimetria :function(index){
        
            this.indexPosTablaDosimetria = index ;
           
        },

     submit :function () {
       
        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'dosimetria_estados';  
                    
        axios.post(urlRegistros, {   
        
            year : this.year,
            month : this.month,          
            dosimetria_estados : this.TablaDosimetriaEstados,              

        }).then(response => {            
            this.errors=[];     
            console.log(response);    

            this.$store.dispatch('loadDosimetriaEstados',{year : this.year , month : this.month}).then(
                response => {
                    
                    this.ResetTabla();

                }
            );   
              
            toastr.success('Estados actualizado con éxito');                
            
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