<template>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-body">
                     <div class="col-md-6">
                        <div class="form-group">
                            <label>Operadores</label>
                            <v-select v-model="operador" label="name" :options="operadores_dosimetria" ></v-select>
                        </div>   
                    </div>      
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha">Fecha Alta</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                                </div>
                                    <Datepicker v-model="fecha_alta" :minimumView="'month'" :maximumView="'month'" :input-class="'form-control pull-right'" :language="es"></Datepicker>   
                            </div>
                        </div>
                    </div>
                     <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button class="btn btn-primary" style="display: block;" @click="submit()" :disabled="!permitir_alta">ALTA</button>                         
                        </div>   
                    </div>   
                    
                </div>
            </div>   
            <div class="box box-danger">
                <div class="box-body">
                     <div class="col-md-4">
                        <div class="table-responsive">          
                            <table class="table table-hover table-striped table-border table-bordered">
                                <thead>
                                    <tr>                                     
                                        <th class="col-md-2">ALTA</th>
                                        <th class="col-md-2">BAJA</th>                                    
                                                    
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item,k) in TablaPeriodos" :key="k" @click="selectPosTablaDosimetria(k)"> 
                                                    
                                            <td>
                                                {{item.alta}}
                                            </td>    
                                             <td>
                                                {{item.baja}}
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
      operador : '',
      fecha_alta:'',
      TablaPeriodos:[],
     }
  },

  created : function() {
 
        this.$store.dispatch('loadFechaActual').then(response => {
            
            this.$store.dispatch('loadOperadoresDisometria');         
            
       })
  },  
  
  watch : {

        operador : function(val){

            this.getPeriodos(val.id);

        },
  },

 
  
  computed :{

       ...mapState(['url','AppUrl','operadores_dosimetria','fecha']),

       permitir_alta : function() {

           if(this.TablaPeriodos.length > 0 && this.TablaPeriodos[this.TablaPeriodos.length-1].baja && this.fecha_alta){

               return true;

           }else if(this.TablaPeriodos.length == 0 && this.fecha_alta) {

               return true;

           }else{
               return false;
           }
       },

    },
 
 methods : {

     getPeriodos(operador_id){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'operador_periodo_rx/periodos/operador/' + operador_id  +'?api_token=' + Laravel.user.api_token;         
            axios.get(urlRegistros).then(response =>{
            this.TablaPeriodos = response.data
            
            });   
     },

     submit :function () {
       
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'operador_periodo_rx';  
                        
            axios.post(urlRegistros, {   
                
                operador : this.operador,  
                fecha : this.fecha_alta                       

            }).then(response => {            
                this.errors=[];     
                console.log(response);  
                 this.getPeriodos(this.operador.id);                
                toastr.success('El Alta fue dado con éxito');                
                
            }).catch(error => {
               
                this.errors = error.response.data.errors;                 
                $.each( this.errors, function( key, value ) {
                    toastr.error(value,key);
                    console.log( key + ": " + value );
                });
                
                if(this.errors = [] && error){

                     toastr.error("Ocurrio un error al procesar la solicitud");                     
                    
                }
  
            });
        }

 },
  
}
</script>

<style scoped>

   
</style>