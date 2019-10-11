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
                        <div class="col-md-3">
                            <div class="form-group">                            
                                <label for="tipo">Movilidad Propia</label>             
                                <input type="checkbox" id="checkbox" v-model="movilidad_propia_sn"> 
                            </div>        
                        </div>  
                        <div class="clearfix"></div>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="horario">Patente </label>
                                <input type="text" v-model="patente" class="form-control" maxlength="10" id="patente">
                            </div>                            
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="km_inicial">Km Inicial </label>
                                <input type="number" v-model="km_inicial" class="form-control" id="km_inicial" step="0.1">
                            </div>                            
                        </div>  
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="km_final">Km Final </label>
                                <input type="number" v-model="km_final" class="form-control" id="km_final" step="0.1">
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
                                            <td> {{ item.operador.name}}</td>                                                        
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
                                            <th colspan="2">&nbsp;</th>
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
                                            <td> <a  @click="RemoveResponsable(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a></td>
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
                                                    <td v-if="!item.original"> {{ item.numero_formateado}}</td>   
                                                    <td v-if="!item.original">
                                                        <div v-if="indexTablaInformesRi == k ">       
                                                          <input type="number" v-model="TablaInformesRi[k].costuras" maxlength="4">        
                                                        </div>   
                                                        <div v-else>
                                                           {{ item.costuras }}
                                                        </div>                                   
                                                    </td>                                              
                                                                                                        
                                                    <td v-if="!item.original"> {{ item.pulgadas}}</td> 
                                                    <td v-if="!item.original">
                                                        <div v-if="indexTablaInformesRi == k ">       
                                                          <input type="number" v-model="TablaInformesRi[k].placas" maxlength="4" step="0.1">        
                                                        </div>   
                                                        <div v-else>
                                                           {{ item.placas }}
                                                        </div>                                   
                                                    </td>                                                  
                                                    <td  v-if="!item.original" >                                                                                                            
                                                        <v-select type="text" v-model="TablaInformesRi[k].cm" label="codigo" id="cm" :options="cms" style="display: block"></v-select>                            
                                                       
                                                    </td>                                                                                                                  
                                                    <td v-if="!item.original"> <a  @click="RemoveResponsable(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a></td>
                                                    
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

      remitodata : {
        type : Object,
        required : false
      },

       detalledata : {
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
        this.getInformesPendientesParte();
        this.getCms();
        this.setEdit();   

    },

    mounted : function() {

     
    },   

    computed :{

        ...mapState(['url','AppUrl']),

       

                  
       
     },

    methods : {

        setEdit : function(){

            if(this.editmode) {               
            
               this.fecha   = this.remitodata.fecha;   
               this.interno_sn = this.remitodata.interno_sn;         
               this.numero = this.remitodata.numero;   
               this.prefijo = this.remitodata.prefijo;
               this.receptor = this.remitodata.receptor;
               this.destino = this.remitodata.destino;
               this.inputsProductos = this.detalledata;                
               this.formatearPrefijo(this.prefijo,4);
               this.formatearNumero(this.numero,8);

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
                    operador :this.operador,             
                    responsabilidad  : this.responsabilidad,           
                        
                    });
                this.operador='';      
                this.responsabilidad ='';  
            

            },

        RemoveResponsable(index) {
          
           this.TablaResponsables.splice(index, 1);               
            
        },

        getInforme(index){

            if(this.informes[index].informe_sel){

                switch  (this.informes[index].metodo_ensayos.metodo){

                  case 'RI' : this.getInformeRI(this.informes[index].id,index);

                  case 'PM' : this.getInformePM(this.informes[index].id,index);

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
            var urlRegistros = 'parte/informe_ri/' + id + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{

            this.informe_ri_parte = response.data              

                this.TablaInformesRi.push({ 
                numero_formateado  : this.informes[index].numero_formateado,
                costuras: this.informe_ri_parte[0].costuras,
                pulgadas: this.informe_ri_parte[0].pulgadas,
                placas : this.informe_ri_parte[0].placas,    
                cm: '',
                id      : id,
                original : true,
                      
                    });  
                    
                this.TablaInformesRi.push({ 
                    numero_formateado  : this.informes[index].numero_formateado,
                    costuras: this.informe_ri_parte[0].costuras,
                    pulgadas: this.informe_ri_parte[0].pulgadas,
                    placas : this.informe_ri_parte[0].placas,    
                    cm: '',
                    id      : id,
                    original : false,
                      
                    });  
            });
           
        },

        getInformePM(id,index){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'parte/informe_pm/' + id + '?api_token=' + Laravel.user.api_token;        
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

        Store : function(){
         
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

            console.log('entro para actualizar' );
            this.errors =[];        
            var urlRegistros = 'partes/' + this.remitodata.id  ;      
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