<template>
    <div class="row">
       <div class="col-md-12">
           <form @submit.prevent="editmode ? Update() : Store()"  method="post">
               <informe-header :otdata="otdata"></informe-header>
               <div class="box box-danger">
                  <div class="box-body">                      
                      <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha">Fecha (*)</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                                </div>
                                    <Datepicker v-model="fecha" :input-class="'form-control pull-right'" :language="es"></Datepicker>   
                            </div>
                        </div>
                    </div>                    
                    <div class="col-md-3">
                        <div class="form-group" >
                            <label for="numero_inf">Informe N°</label>
                            <input type="text"  v-model="numero_inf_code" class="form-control" id="numero_inf" disabled>
                        </div>                            
                    </div>    
                    <div class="col-md-3">
                        <div class="form-group" >
                            <label for="componente">Componente (*)</label>
                            <input type="text" v-model="componente" class="form-control" id="componente">
                        </div>                            
                    </div>

                    <div class="col-md-3" >                       
                        <div class="form-group">
                            <label for="materiales">Material (*)</label>
                            <v-select v-model="material" label="codigo" :options="materiales" id="materiales"></v-select>   
                        </div>      
                    </div>

                    <div class="clearfix"></div>    

                    <div class="col-md-1 size-1-5">
                        <div class="form-group" >
                            <label for="plano_isom">Plano / Isom (*)</label>
                            <input type="text" v-model="plano_isom" class="form-control" id="plano_isom">
                        </div>                            
                    </div>

                    <div class="col-md-3 size-1-5">
                            <div class="form-group" >
                                <label for="Diametro">Diametro (*)</label>
                                <v-select v-model="diametro" label="diametro" :options="diametros" @input="getEspesores()"></v-select>   
                            </div>                            
                        </div>                       

                    <div v-if="isVarios">
                        <div class="col-md-1 size-1-5">
                            <div class="form-group" >
                                <label>Espesor</label>
                                <input  type="text" class="form-control" id="espesor_varios" value="VARIOS" >   
                            </div>                            
                        </div>
                    </div>  
                    <div v-else>
                        <div class="col-md-1 size-1-5">
                            <div class="form-group" >
                                <label>Espesor</label>
                                <v-select v-model="espesor" label="espesor" :options="espesores" :disabled="isChapa || isVarios"></v-select>   
                            </div>                            
                        </div>
                    </div>  
                    <div class="col-md-1 size-1-5">    
                        <div class="form-group" >                         
                        <label for="espesor_chapa">Espesor Chapa</label>
                        <input  type="text" class="form-control" v-model="espesor_chapa"  id="espesor_chapa" :disabled="!isChapa" > 
                        </div>                                      
                    </div>

                  </div>
               </div>
           </form>
        </div>
    </div>
</template>

<script>
import uniq from 'lodash/uniq';
import Datepicker from 'vuejs-datepicker';
import {mapState} from 'vuex';
import {en, es} from 'vuejs-datepicker/dist/locale'
import { eventSetReferencia } from '../event-bus';
export default {
    
    components: {

      Datepicker
      
    },

    props :{

         otdata : {
            type : Object,
            required : true
            },

        metodo : {
            type : String,
            required :true
            },
    },

    data() {return {

        errors:[],
        en: en,
        es: es, 

        cliente:'',
        fecha:'',
        observaciones:'',
        numero_inf:'',
        numero_inf_generado:'',
        componente:'',
        material:'',
        plano_isom:'',
        diametro:'',
        espesor:'',
        espesor_chapa:'', 
        isVarios:false,
        isChapa:false,
           }
    },

    created : function() {

      this.getCliente();  
      this.$store.dispatch('loadMateriales');
      this.$store.dispatch('loadDiametros');
      this.getTecnicas();
      this.$store.dispatch('loadInternoEquiposActivos',this.metodo);       
      this.$store.dispatch('loadProcedimietosOtMetodo',  { 'ot_id' : this.otdata.id, 'metodo' : this.metodo });
      this.$store.dispatch('loadNormaEvaluaciones');        
      this.$store.dispatch('loadNormaEnsayos');  
      this.$store.dispatch('loadEjecutorEnsayo', this.otdata.id); 
    
    //  this.setEdit();      
    },

    mounted : function() {

         this.getNumeroInforme();
    },

    computed :{

        ...mapState(['url','AppUrl','materiales','diametros','espesores','procedimientos','norma_evaluaciones','norma_ensayos','ejecutor_ensayos','interno_equipos_activos']),     

        numero_inf_code : function()  {

               if(this.numero_inf)

                      return this.metodo + (this.numero_inf <10? '00' : this.numero_inf<100? '0' : '') + this.numero_inf ;
        },
       
     },

      watch : {

    
        diametro : function(val){

            if(val.diametro =='CHAPA'){

                 this.isChapa = true;
                 this.isVarios = false;

            } else if (val.diametro =='VARIOS'){

                this.isChapa = false;
                this.isVarios = true;

            }else{

                this.isChapa = false;
                this.isVarios = false;

            }    

                
        },      

    },

     methods : {

         getCliente : function(){
           
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'clientes/' + this.otdata.cliente_id + '?api_token=' + Laravel.user.api_token;           
            axios.get(urlRegistros).then(response =>{
            this.cliente = response.data
           
            });
        },

         getNumeroInforme:function(){            
           
            if(!this.editmode) {           

                axios.defaults.baseURL = this.url ;
                    var urlRegistros = 'informes/ot/' + this.otdata.id + '/metodo/' + this.metodo + '/generar-numero-informe'  + '?api_token=' + Laravel.user.api_token;         
                    axios.get(urlRegistros).then(response =>{
                    this.numero_inf_generado = response.data 
                    
                
                    if(this.numero_inf_generado.length){

                        this.numero_inf =  this.numero_inf_generado[0].numero_informe
                    }else{

                        this.numero_inf = 1;
                    }
                    
                    
                    });   
             }
        },    

        getTecnicas: function(){
             
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'tecnicas/metodo/'+ this.metodo + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
            this.tecnicas = response.data
            });
         },
    
        getEspesores : function(){
            this.espesor='';          
            this.tecnica ='';      
            this.$store.dispatch('loadEspesores',this.diametro.diametro_code);
        },

     }



}
</script>

<style scoped>
 .existe {

    color: blue ;

  }

.checkbox-inline {
    margin-left: 0px;
}

.col-md-1-5 {

    width: 12.499999995%
   
}

@media (min-width: 768px)  { 
    
    .size-1-5 {

        width: 12.499999995%;
    }
}

.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
     background-color: #eee;
}

</style>