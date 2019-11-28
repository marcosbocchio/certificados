<template>
    <div class="row">
       <div class="col-md-12">
           <form @submit.prevent="editmode ? Update() : Store()"  method="post">
               <informe-header :otdata="otdata"></informe-header>
               <div class="box box-danger">
                  <div class="box-body">                      
                      <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha">Fecha *</label>
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
                            <label for="componente">Componente *</label>
                            <input type="text" v-model="componente" class="form-control" id="componente">
                        </div>                            
                    </div>

                    <div class="col-md-3" >                       
                        <div class="form-group">
                            <label for="materiales">Material *</label>
                            <v-select v-model="material" label="codigo" :options="materiales" id="materiales"></v-select>   
                        </div>      
                    </div>

                    <div class="clearfix"></div>    

                    <div class="col-md-1 size-1-5">
                        <div class="form-group" >
                            <label for="plano_isom">Plano / Isom *</label>
                            <input type="text" v-model="plano_isom" class="form-control" id="plano_isom">
                        </div>                            
                    </div>

                    <div class="col-md-3 size-1-5">
                            <div class="form-group" >
                                <label for="Diametro">Diametro *</label>
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

                    <div class="col-md-3">                       
                        <div class="form-group" >
                            <label for="eps">EPS</label>
                            <input type="text" v-model="eps" class="form-control" id="eps">
                        </div>         
                    </div>

                    <div class="col-md-3">                       
                        <div class="form-group" >
                            <label for="eps">PQR</label>
                            <input type="text" v-model="pqr" class="form-control" id="pqr">
                        </div>         
                    </div>

                    <div class="col-md-3" >                       
                        <div class="form-group">
                            <label for="tecnicas">Tecnica *</label>
                            <v-select v-model="tecnica" label="descripcion" :options="tecnicas" id="tecnicas"></v-select>   
                        </div>      
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Equipo *</label>
                            <v-select  v-model="interno_equipo" :options="interno_equipos_activos" label="nro_interno">
                                <template slot="option" slot-scope="option">
                                    <span class="upSelect">{{ option.nro_interno }}</span> <br> 
                                    <span class="downSelect"> {{ option.equipo.codigo }} </span>
                                </template>
                            </v-select>
                        </div>
                    </div>

                    <div class="col-md-3">                       
                        <div class="form-group">
                            <label for="procRadio">Procedimiento US *</label>
                            <v-select v-model="procedimiento" label="titulo" :options="procedimientos" id="procRadio"></v-select>   
                        </div>      
                    </div>

                    <div class="col-md-3">                       
                        <div class="form-group">
                            <label>Norma Evaluación *</label>
                            <v-select v-model="norma_evaluacion" label="descripcion" :options="norma_evaluaciones"></v-select>   
                        </div>      
                    </div>

                    <div class="clearfix"></div>    
                    
                    <div class="col-md-3">                       
                        <div class="form-group">
                            <label>Norma Ensayo *</label>
                            <v-select v-model="norma_ensayo" label="descripcion" :options="norma_ensayos"></v-select>   
                        </div>      
                    </div>

                    <div class="col-md-3">                       
                        <div class="form-group">
                            <label>Estado Superf. *</label>
                            <v-select v-model="estado_superficie" label="codigo" :options="estados_superficies"></v-select>   
                        </div>      
                    </div>

                    <div class="col-md-3">                       
                        <div class="form-group" >
                            <label for="encoder">Encoder</label>
                            <input type="text" v-model="encoder" class="form-control" id="encoder">
                        </div>         
                    </div>

                    <div class="col-md-3">                       
                        <div class="form-group" >
                            <label for="agente_acoplamiento">Agente Acopla.</label>
                            <input type="text" v-model="agente_acoplamiento" class="form-control" id="agente_acoplamiento">
                        </div>         
                    </div>

                  </div>
               </div>

               <div class="box box-danger">
                   <div class="box-body">

                        <div class="col-md-2">                       
                            <div class="form-group" >
                                <label for="zapata" title="Zapata">Zapata*</label>
                                <input type="text" v-model="zapata" class="form-control" id="zapata">
                            </div>         
                        </div>

                        <div class="col-md-2" >                       
                            <div class="form-group">
                                <label for="palpador" title="Palpador">Palpador*</label>
                                <v-select v-model="palpador" label="codigo" :options="palpadores" id="palpador"></v-select>   
                            </div>      
                        </div>  

                        <div class="col-md-2">                       
                            <div class="form-group" >
                                <label for="frecuencia" title="Frecuencia">Frec.*</label>
                                <input type="text" v-model="frecuencia" class="form-control" id="frecuencia">
                            </div>         
                        </div>

                        <div class="col-md-1">                       
                            <div class="form-group" >
                                <label for="angulo_apertura" title="Ángulo Apertura">Ang. Ap. *</label>
                                <input type="text" v-model="angulo_apertura" class="form-control" id="angulo_apertura">
                            </div>         
                        </div>

                        <div class="col-md-1">                       
                            <div class="form-group" >
                                <label for="rango">Rango *</label>
                                <input type="text" v-model="rango" class="form-control" id="rango">
                            </div>         
                        </div>

                        <div class="col-md-1">                       
                            <div class="form-group" >
                                <label for="posicion" title="Posición">Pos.*</label>
                                <input type="text" v-model="posicion" class="form-control" id="posicion">
                            </div>         
                        </div>

                        <div class="col-md-1">                       
                            <div class="form-group" >
                                <label for="curva_elevacion" title="Curva Elevación">Curva. Elav.*</label>
                                <input type="text" v-model="curva_elevacion" class="form-control" id="curva_elevacion">
                            </div>         
                        </div>

                        <div class="col-md-1">                       
                            <div class="form-group" >
                                <label for="block_calibracion" title="Block Calibración">Block. cal.*</label>
                                <input type="text" v-model="block_calibracion" class="form-control" id="block_calibracion">
                            </div>         
                        </div>

                        <div class="col-md-2">                       
                            <div class="form-group" >
                                <label for="block_sensibilidad" title="Block Sensibilidad">Block. Sen.*</label>
                                <input type="number" v-model="block_sensibilidad" class="form-control" id="block_sensibilidad">
                            </div>         
                        </div>

                        <div class="col-md-1">                       
                            <div class="form-group" >
                                <label for="tipo_reflector" title="Tipo Reflector">Tipo Re.*</label>
                                <input type="text" v-model="tipo_reflector" class="form-control" id="tipo_reflector">
                            </div>         
                        </div>

                        <div class="col-md-1">                       
                            <div class="form-group" >
                                <label for="refector_referencia" title="Reflector Referencia">Re. Ref.*</label>
                                <input type="text" v-model="refector_referencia" class="form-control" id="refector_referencia">
                            </div>         
                        </div>

                        <div class="col-md-1">                       
                            <div class="form-group" >
                                <label for="ganancia_referencia" title="Ganancia Referencia">Gan. Ref.*</label>
                                <input type="text" v-model="ganancia_referencia" class="form-control" id="ganancia_referencia">
                            </div>         
                        </div>

                        <div class="col-md-2">                       
                            <div class="form-group" >
                                <label for="nivel_registro" title="Nivel Registro">Nivel. Reg.*</label>
                                <input type="text" v-model="nivel_registro" class="form-control" id="nivel_registro">
                            </div>         
                        </div>

                        <div class="col-md-2">                       
                            <div class="form-group" >
                                <label for="correccion_transferencia" title="Corrección Transferencia">Correc. Trans*</label>
                                <input type="text" v-model="correccion_transferencia" class="form-control" id="correccion_transferencia">
                            </div>         
                        </div>

                        <div class="col-md-2">                       
                            <div class="form-group" >
                                <label for="adicional_barrido" title="Adicional Baarrido">Adic. Barrido*</label>
                                <input type="text" v-model="adicional_barrido" class="form-control" id="adicional_barrido">
                            </div>         
                        </div>

                        <div class="col-md-2">                       
                            <div class="form-group" >
                                <label for="amplificacion_total" title="Zapata">Ampli. Total*</label>
                                <input type="text" v-model="amplificacion_total" class="form-control" id="amplificacion_total">
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
        eps:'',
        pqr:'',
        tecnica:'',
        interno_equipo:'',       
        procedimiento:'',
        norma_ensayo:'',
        norma_evaluacion:'',
        ejecutor_ensayo:'',
        estado_superficie:'',
        encoder:'',
        agente_acoplamiento:'',

        zapata:'',
        palpador:'',
        frecuencia:'',
        angulo_apertura:'',
        rango:'',
        posicion:'',
        curva_elevacion:'',
        block_calibracion:'',
        block_sensibilidad:'',
        tipo_reflector:'',
        refector_referencia:'',
        ganancia_referencia:'',
        nivel_registro:'',
        correccion_transferencia:'',
        adicional_barrido:'',
        amplificacion_total:'',

        tecnicas:[],
        palpadores:[],
        estados_superficies:[],

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
      this.getEstadosSuperficies();
      this.getPalpadores();
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

         getEstadosSuperficies: function(){
             
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'estados_superficies' + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
            this.estados_superficies = response.data
            });
         },

         getPalpadores: function(){
             
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'palpadores' + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
            this.palpadores = response.data
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