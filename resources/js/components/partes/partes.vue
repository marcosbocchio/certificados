<template>
 <div class="row">
       <div class="col-md-12">
            <form @submit.prevent="editmode ?  Update() : Store()"  method="post">
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
                                <label for="tipo_servicio">Tipo Servicio (*)</label>
                                <v-select type="text" v-model="tipo_servicio"  id="tipo_servicio" :options="['Diurno', 'Nocturno']" ></v-select>
                            </div>                            
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="horario">Horario (*)</label>
                                <input type="text" v-model="horario" class="form-control" maxlength="5" id="horario">
                            </div>                            
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-3">
                            <div class="form-group" >               
                                <input type="checkbox" id="checkbox" v-model="movilidad_propia_sn" style="float:right"> 
                                <label for="tipo" style="float: left;;margin-right: 5px;">Movilidad Propia</label>             
                            </div>    
                        </div>  
                        <div class="clearfix"></div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="horario">Patente </label>
                                <input type="text" v-model="patente" class="form-control" maxlength="10" id="patente" :disabled="!movilidad_propia_sn">
                            </div>                            
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="km_inicial">Km Inicial </label>
                                <input type="number" v-model="km_inicial" class="form-control" id="km_inicial" step="0.1" :disabled="!movilidad_propia_sn">
                            </div>                            
                        </div>  
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="km_final">Km Final </label>
                                <input type="number" v-model="km_final" class="form-control" id="km_final" step="0.1" :disabled="!movilidad_propia_sn">
                            </div>                            
                        </div>  
                    </div>
                </div>   
                <div class="box box-danger">
                    <div class="box-header with-border">
                    <h3 class="box-title">Responsabilidades</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>                       
                        </div>
                    </div>
                    <div class="box-body"> 
                        <div class="col-md-6">
                            <div class="form-group" >
                                <label for="km_final">Operador </label>
                                <v-select type="text" v-model="operador" id="responsable" label="name" :options="operadores"></v-select>
                            </div>                            
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="responsabilidad">Responsabilidad </label>
                                <input type="text" v-model="responsabilidad" class="form-control" id="responsabilidad">
                            </div>                            
                        </div>
                        <div class="col-md-1"> 
                            <div class="form-group">  
                                 <p>&nbsp;</p>                  
                                <span>
                                  <a title="Agregar responsables" @click="addResponsable()"> <app-icon img="plus-circle" color="black"></app-icon> </a>                        
                                </span>
                            </div>
                        </div>  
                        <div v-show="TablaResponsables.length">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                        <th>Operador</th>                                         
                                        <th>Responsabilidad</th>                                                 
                                        <th colspan="2">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item,k) in TablaResponsables" :key="k">
                                            <td> {{ item.user.name}}</td>                                                        
                                            <td> {{ item.responsabilidad}}</td>                                                                                                                     
                                            <td> <a  @click="RemoveResponsable(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a></td>
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                  </div>
                </div>  
                <div class="box box-danger">
                    <div class="box-header with-border">
                    <h3 class="box-title">Informes sin Parte Diario</h3>

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
                                            <th>SEL.</th>
                                            <th>TIPO</th>                                         
                                            <th>INFORME</th>   
                                            <th>FECHA</th>                                                 
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(informe,k) in informes" :key="k">
                                            <td>
                                                <input type="checkbox" id="informe_sel" v-model="informes[k].informe_sel" @change="getInforme(k)" >
                                            </td>
                                            <td> {{ informe.metodo_ensayos.metodo}}</td>                                                        
                                            <td> {{ informe.numero_formateado}}</td>     
                                            <td> {{ informe.fecha_formateada}}</td>                                                                                                                      
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>                     
                    </div>
                </div>
                
                <div v-show="TablaInformesRi.length">
                    <div class="box box-danger" >
                        <div class="box-header with-border">
                        <h3 class="box-title">Informes RI</h3>

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
                                                    <th>INFORME</th>       
                                                    <th>COSTURAS</th>                                         
                                                    <th>PULGADAS</th>
                                                    <th>PLACAS</th> 
                                                    <th style="width:200px;">CM</th>                                                   
                                                    <th colspan="2">&nbsp;</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item,k) in TablaInformesRi" :key="k"  @click="selectPosTablaInformesRi(k)">     
                                                    <td v-if="item.visible"> {{ item.numero_formateado}}</td>   
                                                    <td v-if="item.visible">
                                                        <div v-if="indexTablaInformesRi == k ">       
                                                          <input type="number" v-model="TablaInformesRi[k].costura_final" maxlength="4">        
                                                        </div>   
                                                        <div v-else>
                                                           {{ item.costura_final }}
                                                        </div>                                   
                                                    </td>                                              
                                                                                                        
                                                    <td v-if="item.visible"> {{ item.pulgadas_final}}</td> 
                                                    <td v-if="item.visible">
                                                        <div v-if="indexTablaInformesRi == k ">       
                                                          <input type="number" v-model="TablaInformesRi[k].placas_final" maxlength="4" step="0.1">        
                                                        </div>   
                                                        <div v-else>
                                                           {{ item.placas_final }}
                                                        </div>                                   
                                                    </td>                                                  
                                                    <td  v-if="item.visible" >                                                                                                            
                                                        <v-select type="text" v-model="TablaInformesRi[k].cm" label="codigo" id="cm" :options="cms" style="display: block"></v-select>                            
                                                       
                                                    </td>                                                                                                                  
                                                    <td v-if="item.visible"> <a  @click="RemoveTablaInformeRi(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a></td>
                                                    
                                                </tr>   
                                                <tr v-for="fila in 4" >
                                                    <td colspan="6" style="background: #FFFFFF"> &nbsp;</td>                                                  
                                                </tr>                                             
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                        
                        </div>
                    </div>
                </div>
                <div class="box box-danger">
                    <div class="box-body">
                        <div class="form-group">
                        <label>Observaciones</label>
                        <textarea v-model="observaciones" class="form-control noresize" rows="3" placeholder="" maxlength="250"></textarea>
                        </div>
                    </div>
                </div>      
                 <button class="btn btn-primary" type="submit">Guardar</button>   
            </form>    
       </div>
 </div>            
</template>

<script>
import Datepicker from 'vuejs-datepicker';
import {mapState} from 'vuex';
import {en, es} from 'vuejs-datepicker/dist/locale'
export default {
    components: {

      Datepicker
      
    },

    props :{

      editmode : {
        type : Boolean,
        required : false,    
        default : false
      },  

      otdata : {
        type : Object,
        required : true
      },     

      parte_data : {
        type : Object,
        required : false
      },
      

      informes_data : {
        type : [ Array ],  
        required : false
      },

      informes_ri_data : {
      type : [ Array ],  
      required : false
      },

      responsables_data : {
      type : [ Array ],  
      required : false
      }

    },
    data (){return{  

        errors:[],
        en: en,
        es: es,      
        fecha:'',     
        tipo_servicio:'',
        horario:'',
        movilidad_propia_sn:false,
        patente:'',
        km_inicial:'',
        km_final:'',
        observaciones:'',

        operador:'',
        operadores:[],

        responsabilidad:'',
        TablaResponsables:[],

      
        informes:[],
        informe_sel:false,

        filasBlanco:'5',
        informe_ri_parte:'',
        TablaInformesRi:[],
        indexTablaInformesRi:'0',
        cms:[],

    }},

    created : function() {

        this.getOperadoresOt();
      
        this.getCms();
        this.setEdit();   

    },

    mounted : function() {

     
    },   

    watch :{

        movilidad_propia_sn : function(val){

            if(!val){
            
                this.patente = '';
                this.km_inicial = '';
                this.km_final = '';            
            
            }
        }
},

    computed :{

        ...mapState(['url','AppUrl']),                  
       
     },

    methods : {

        setEdit : function(){

            if(this.editmode) {
                
            
               this.TablaResponsables =  JSON.parse(JSON.stringify(this.responsables_data));  
               this.fecha   = this.parte_data.fecha;   
               this.tipo_servicio = this.parte_data.tipo_servicio;         
               this.horario = this.parte_data.horario;   
               this.movilidad_propia_sn = this.parte_data.movilidad_propia_sn;
               this.patente = this.parte_data.patente;
               this.km_final = this.parte_data.km_final;
               this.km_inicial = this.parte_data.km_inicial;
               this.observaciones = this.parte_data.observaciones;
               this.getInformesPendientesYEditableParte(); 

            }else{

                this.getInformesPendientesParte(); 
            }      

        },
        
        getOperadoresOt: function(){
             
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'ot-operarios/ot/' + this.otdata.id + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
            this.operadores = response.data
            });
        },

        selectPosTablaInformesRi :function(index){

            this.indexTablaInformesRi = index ;            

        },
                
        getCms: function(){
             
             console.log('medidas/cm');
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'medidas/cm/' + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
            this.cms = response.data
            });
        }, 

        getInformesPendientesParte: function(){
             
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'informes/ot/' + this.otdata.id + '/pendientes_parte_diario' + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
            this.informes = response.data
            console.log('trajo los informes pendiente partes');
            });
               

        },

        getInformesPendientesYEditableParte: function(){
             
             axios.defaults.baseURL = this.url ;
             var urlRegistros = 'informes/ot/' + this.otdata.id + '/parte/'+ this.parte_data.id + '/pendientes_editables_parte_diario' + '?api_token=' + Laravel.user.api_token;        
             axios.get(urlRegistros).then(response =>{
             this.informes = response.data
             console.log(this.informes_ri_data)   

                    this.informes_ri_data.forEach(function(item_data){


                        this.informes.forEach(function(item_informe){                         

                            if(item_data.informe_id == item_informe.id)

                                  item_informe.informe_sel = true;

                            });
                      
                    }.bind(this));

                    this.informes_ri_data.forEach(function(item){

                        let visible_sn = true;
                        if( !item.costura_final  &&  !item.pulgadas_final && !item.placas_final){

                            visible_sn = false

                        }

                        this.TablaInformesRi.push({ 

                            numero_formateado  : item.numero_formateado,              
                            costura_original: item.costura_original,
                            pulgadas_original: item.pulgadas_original,
                            placas_original : item.placas_original,              
                            id      : item.informe_id,
                            visible : visible_sn,   
                            costura_final: item.costura_final,
                            pulgadas_final: item.pulgadas_final,
                            placas_final : item.placas_final, 
                            cm: item.cm,  

                            }); 
                        }.bind(this));     
             });
                
 
         },

        addResponsable(index) {

            
            if(!this.operador){
                toastr.error("El campo Operador es obligatorio");         
                 return;            
            }

            if(!this.responsabilidad){
                    toastr.error("El campo Responsabilidad es obligatorio");         
                    return;            
            }        

                this.TablaResponsables.push({ 
                    user :this.operador,             
                    responsabilidad  : this.responsabilidad,           
                        
                    });
                this.operador='';      
                this.responsabilidad ='';  
            

            },

        RemoveResponsable(index) {
          
           this.TablaResponsables.splice(index, 1);               
            
        },

        RemoveTablaInformeRi(index){
            
            this.TablaInformesRi[index].visible = false;
            this.TablaInformesRi[index].costura_final='';
            this.TablaInformesRi[index].placas_final='';
            this.TablaInformesRi[index].pulgadas_final=''
            this.TablaInformesRi[index].cm=''

        },

        getInforme(index){

            if(this.informes[index].informe_sel){

                switch  (this.informes[index].metodo_ensayos.metodo){

                  case 'RI' : this.getInformeRI(this.informes[index].id,index);break;

                  case 'PM' : this.getInformePM(this.informes[index].id,index);break;

                }

            }  else{
                
                let id  = this.informes[index].id ;   

                for( var i = 0; i < this.TablaInformesRi.length; i++){ 
                    if (this.TablaInformesRi[i].id == id) {
                         this.TablaInformesRi.splice(i, 1); 
                        i--;
                    }
                }                             
            }

        },

        getInformeRI(id,index){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'partes/informe_ri/' + id + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{

            this.informe_ri_parte = response.data              

                this.TablaInformesRi.push({ 
                numero_formateado  : this.informes[index].numero_formateado,              
                costura_original: this.informe_ri_parte[0].costuras,
                pulgadas_original: this.informe_ri_parte[0].pulgadas,
                placas_original : this.informe_ri_parte[0].placas,              
                id      : id,
                visible : true,   
                costura_final: this.informe_ri_parte[0].costuras,
                pulgadas_final: this.informe_ri_parte[0].pulgadas,
                placas_final : this.informe_ri_parte[0].placas, 
                cm: '', 

             });  
                    
             
            });
           
        },

        getInformePM(id,index){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'partes/informe_pm/' + id + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{

            this.informe_ri_parte = response.data              

                this.TablaInformesRi.push({ 
                numero_formateado  : this.informes[index].numero_formateado,               
                id      : id,
                original : true,
                    
                    });   
                    
                this.TablaInformesRi.push({ 
                    numero_formateado  : this.informes[index].numero_formateado,              
                    id      : id,
                    original : false,
                    
                    });  
            });

            },

        validarCmsRi: function(){

                let valido = true;

                this.TablaInformesRi.forEach(function(item){

                    if((item.costura_final!='' || item.pulgadas_final!='' || item.placas_final!='') && item.cm ){

                        valido =  false;
                    }
                })
                console.log('valido cms');
                return valido;

            },

        Store : function(){
         
            if(!this.validarCmsRi()){
  
                  toastr.error('EL campo CM en los informes RI asignados al Parte son obligatorios');
                  return;
            }

            this.errors =[];


          
            var urlRegistros = 'partes' ;      
            axios({
              method: 'post',
              url : urlRegistros,    
              data : {             
                'ot'                   : this.otdata,                  
                'fecha'                : this.fecha,
                'tipo_servicio'        : this.tipo_servicio,
                'horario'              : this.horario,     
                'movilidad_propia_sn'  : this.movilidad_propia_sn,
                'patente'              : this.patente,          
                'km_inicial'           : this.km_inicial,    
                'km_final'             : this.km_final,
                'observaciones'        : this.observaciones, 
                'responsables'         :this.TablaResponsables, 
                'informes_ri'          :this.TablaInformesRi 
          }
          
          }).then(response => {
          this.response = response.data
          toastr.success('Parte Diario con fecha' +  this.fecha + ' fue creado con éxito ');
           console.log(response.data);  
        }).catch(error => {
               
               this.errors = error.response.data.errors;
                console.log(error.response);
               $.each( this.errors, function( key, value ) {
                   toastr.error(value);
                     console.log( key + ": " + value );
               });

               if((typeof(this.errors)=='undefined') && (error)){

                     toastr.error("Ocurrió un error al procesar la solicitud");                     
                  
                }

           });    

        },

        Update : function() {

            if(!this.validarCmsRi()){

                toastr.error('EL campo CM en los informes RI asignados al Parte son obligatorios');
                return;

                }

            console.log('entro para actualizar' );
            this.errors =[];        
            var urlRegistros = 'partes/' + this.parte_data.id  ;      
            axios({
              method: 'put',
              url : urlRegistros,    
              data : {
                'ot'                   : this.otdata,                  
                'fecha'                : this.fecha,
                'tipo_servicio'        : this.tipo_servicio,
                'horario'              : this.horario,     
                'movilidad_propia_sn'  : this.movilidad_propia_sn,
                'patente'              : this.patente,          
                'km_inicial'           : this.km_inicial,    
                'km_final'             : this.km_final,
                'observaciones'        : this.observaciones, 
                'responsables'         :this.TablaResponsables, 
                'informes_ri'          :this.TablaInformesRi                   
          }}
          
      
        ).then(response => {
          this.response = response.data
          toastr.success('Parte Diario con fecha' +  this.fecha + ' fue actualizado con éxito ');
       console.log(response.data);  
        }).catch(error => {
               
               this.errors = error.response.data.errors;
                console.log(error.response);
               $.each( this.errors, function( key, value ) {
                   toastr.error(value);
                   console.log( key + ": " + value );
               });

               if((typeof(this.errors)=='undefined') && (error)){

                     toastr.error("Ocurrió un error al procesar la solicitud");                     
                  
                }

           }); 

        }
    }
    
}
</script>

<style scoped>

.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
     background-color: #eee;
}
</style>