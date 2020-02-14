<template>
    <div class="row">
        <div class="col-md-12">
            <form @submit.prevent="editmode ?  Update() : Store()"  method="post">
                <parte-header :otdata="otdata" :certificado_sn="true"></parte-header>

                    <div class="box box-custom-enod">
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
                                    <label for="numero">Certificado N° </label>
                                    <input type="number" v-model="numero_code" class="form-control" id="numero" disabled>
                                </div>                            
                            </div>

                        </div>
                    </div>

                    <div class="box box-custom-enod">
                        <div class="box-header with-border">
                            <h3 class="box-title">Partes sin Certificados</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>                       
                            </div>
                        </div>
                         <div class="box-body">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th class="col-md-2">SEL.</th>                                                                
                                            <th class="col-md-3">PARTE N°</th>  
                                            <th class="col-md-3">OBRA</th> 
                                            <th class="col-md-4">FECHA</th>                                      
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(parte,k) in partes" :key="k">
                                            <td>
                                                <input type="checkbox" id="informe_sel" v-model="partes[k].parte_sel">
                                            </td>                                                                                          
                                            <td>{{ parte.numero_formateado}}</td>
                                            <td>{{ parte.obra}}</td>  
                                            <td>{{ parte.fecha_formateada}}</td>                                                                                                                      
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                            </div>                                                
                        </div>
                    </div>
            </form>
        </div>
    </div>    
</template>

<script>
import {mapState} from 'vuex';
import {en, es} from 'vuejs-datepicker/dist/locale';
import Datepicker from 'vuejs-datepicker';
import {sprintf} from '../../functions/sprintf.js'

export default {

    components: {

      Datepicker
      
    },

    props : {

      editmode : {
        type : Boolean,
        required : false,    
        default : false
      },  

      otdata : {
        type : Object,
        required : true
      },   
    },

    data () { return{

        errors:[],
        en: en,
        es: es,
        numero:'',      
        fecha:'',   
        partes:[],
       }
    },

    created : function() {

        this.CargaDeDatos();  

    },

      mounted : function() {    

        this.getNumeroCertificado();

      }, 

      
    computed :{

        ...mapState(['url','AppUrl']),     

        numero_code : function()  {

               if(this.numero){

                   return   sprintf("%08d",this.numero) ;
                  
               }
        },

       
     },

      methods : { 

          CargaDeDatos : function(){

             if(this.editmode) {



             }else{      

                  this.getPartesPendientesCertificado();

             }

          },

        getPartesPendientesCertificado: function(){
             
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'partes/ot/' + this.otdata.id + '/pendientes_certificados' + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
            console.log('los partes pendientes son');
            console.log(urlRegistros);
            console.log(response.data);
            this.partes = response.data;
            });
               
        },

          getNumeroCertificado: function(){ 

              if(!this.editmode) { 

                    axios.defaults.baseURL = this.url ;
                    var urlRegistros = 'certificados/generar-numero-certificado'  + '?api_token=' + Laravel.user.api_token;         
                    axios.get(urlRegistros).then(response =>{

                    this.numero_inf_generado = response.data                      
                
                    if(this.numero_inf_generado.length){

                        this.numero =  this.numero_inf_generado[0].numero_certificado
                    }else{

                        this.numero = 1;
                    }                   
                    
                    });   
              }
          }

      }
}
</script>