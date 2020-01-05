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
       
            <div class="box box-danger">
                <div class="box-body">
                     <div class="col-md-9">
                        <div class="table-responsive">          
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>                                     
                                        <th class="col-md-6">OPERADOR</th>
                                        <th style="text-align:center;" class="col-md-1">MILISIEVERT</th>                                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item,k) in TablaDosimetriaRx" :key="k" @click="selectPosTablaDosimetria(k)"> 
                                                    
                                    
                                            <td v-if="(!filtro(k))" bgcolor="#bee5eb">
                                                {{item.operador}}
                                            </td>    
                                     
                                            <td v-if="(!filtro(k))" style="text-align:center;">
                                                <div v-if="(indexPosTablaDosimetria == k)">       
                                                    <input type="number" :ref="'refInputMediciones'" v-model="TablaDosimetriaRx[k].milisievert" @keyup.enter="getFocus(k)" step="0.01">        
                                                </div>   
                                                <div v-else>
                                                    {{item.milisievert}} 
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

      TablaDosimetriaRx:[],
      year: '',
      month:'',
      years:[],
      months :[],
      indexPosTablaDosimetria : '-1',
      search:'',
     
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

       filtro : function(index){
            console.log('el indice es',index);
            if(this.search){

                if(this.TablaDosimetriaRx[index].operador.toLowerCase().includes(this.search.toLowerCase()))
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