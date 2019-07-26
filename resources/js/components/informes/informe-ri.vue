<template>
   <div class="row">
       <div class="col-md-12">
           <form @submit.prevent="editmode ?  Update() : Store()"  method="post">
               <div class="box box-danger">
                  <div class="box-body"> 
                      <div class="col-md-6">
                            <div class="form-group" >
                                <label for="ot">Orden de Trabajo N°</label>
                                <input type="number" v-model="otdata.numero" class="form-control" id="ot" disabled>
                            </div>                            
                        </div>
                  </div>
               </div>
               <div class="box box-danger">
                  <div class="box-body">
                      <div class="col-md-2">
                            <div class="form-group" >
                                <label for="numero_inf">Informe N°</label>
                                <input type="number" v-model="numero_inf" class="form-control" id="numero_inf">
                            </div>                            
                        </div>
                        <div class="col-md-1">
                            <div class="form-group" >
                                <label for="ext_numero_inf">Ext</label>
                                <input type="text" v-model="ext_numero_inf" class="form-control" id="ext_numero_inf">
                            </div>                            
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="formato">Formato</label>
                                <v-select v-model="formato" :options="['PLANTA', 'GASODUCTO']"></v-select>
                            </div>                            
                        </div>
                        <div class="col-md-3">                       
                            <div class="form-group">
                                <label>Norma Evaluación</label>
                                <v-select v-model="norma_evaluacion" label="descripcion" :options="norma_evaluaciones"></v-select>   
                            </div>      
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                            <label for="fecha">Fecha</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                    </div>
                                        <Datepicker v-model="fecha" :input-class="'form-control pull-right'" :language="es"></Datepicker>   
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">                       
                            <div class="form-group">
                                <label>Procedimiento Radiográfico</label>
                                <v-select v-model="procedimiento" label="codigo" :options="procedimientos"></v-select>   
                            </div>      
                        </div>
                        <div class="col-md-3">                       
                            <div class="form-group">
                                <label>Material</label>
                                <v-select v-model="material" label="codigo" :options="materiales"></v-select>   
                            </div>      
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" >
                                <label for="ieg">Ieg</label>
                                <input  type="text" v-model="ieg" class="form-control" id="ieg">
                            </div>                            
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" >
                                <label for="componente">Componente</label>
                                <input type="text" v-model="componente" class="form-control" id="componente">
                            </div>                            
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" >
                                <label for="plano_isom">Plano / Isom</label>
                                <input type="text" v-model="plano_isom" class="form-control" id="plano_isom">
                            </div>                            
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="Diametro">Diametro</label>
                                <v-select v-model="diametro" label="diametro" :options="diametros" @input="getEspesores()"></v-select>   
                            </div>                            
                        </div>

                        <template v-if="diametro.diametro == 'CHAPA' " >
                            <div class="col-md-3">                             
                                <label for="espesor_chapa">Espesor Chapa</label>
                                <input  type="text" class="form-control" v-model="espesor_chapa"  id="espesor_chapa">                              
                            </div>
                        </template>                       
                        <template v-else>
                            <div class="col-md-3">
                                <div class="form-group" >
                                   <label>Espesor</label>
                                   <v-select v-model="espesor" label="espesor" :options="espesores"></v-select>   
                                </div>                            
                            </div>
                        </template>

                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="equipos">Equipo</label>
                                <v-select v-model="equipo" label="codigo" :options="equipos"></v-select>  
                            </div>                            
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="fuente">Fuente</label>
                                <v-select v-model="fuente" label="codigo" :options="fuentes"></v-select>   
                            </div>                            
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Calidad de placas</label>
                                    <v-select  v-model="tipo_pelicula" :options="tipo_peliculas" label="codigo">
                                    <template slot="option" slot-scope="option">
                                        <span class="upSelect">{{ option.codigo }}</span> <br> 
                                        <span class="downSelect"> {{ option.fabricante }} </span>
                                    </template>
                                      </v-select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" >
                                <label for="foco">Foco</label>
                                <input type="text" v-model="foco" class="form-control" id="foco">
                            </div>                            
                        </div>      
                        <div class="col-md-2">
                            <div class="form-group" >
                                <label for="distancia_fuente_pelicula">Dist. Fuente</label>
                                <input type="text" v-model="distancia_fuente_pelicula" class="form-control" id="distancia_fuente_pelicula">
                            </div>                            
                        </div>  
                        <div class="col-md-2">
                            <div class="form-group" >
                                <label for="pantalla">Pantalla</label>
                                <input type="text" v-model="pantalla" class="form-control" id="pantalla" disabled>
                            </div>                            
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" >
                                <label for="pos_pos">lado</label>
                                <input type="text" v-model="lado" class="form-control" id="lado">
                            </div>                            
                        </div>
                       <div class="col-md-2">
                            <div class="form-group" >
                                <label for="ici">Ici</label>
                                <v-select v-model="ici" label="codigo" :options="icis"></v-select>   
                            </div>                            
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" >
                                <label for="pos_ant">Ant</label>
                                <input type="number" v-model="pos_ant" class="form-control" id="pos_ant">
                            </div>                            
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" >
                                <label for="pos_pos">Pos</label>
                                <input type="number" v-model="pos_pos" class="form-control" id="pos_pos">
                            </div>                            
                        </div>
                        <div class="col-md-6">
                            <div class="form-group" >
                                <label for="procedimientos_soldadura">Procedimiento Soldadura</label>
                                <input type="text" v-model="procedimiento_soldadura" class="form-control" id="procedimientos_soldadura">
                            </div>                            
                        </div>  
                        <div class="col-md-3">                       
                            <div class="form-group">
                                <label>Norma Ensayo</label>
                                <v-select v-model="norma_ensayo" label="descripcion" :options="norma_ensayos"></v-select>   
                            </div>      
                        </div>
                        <div class="col-md-3">                       
                            <div class="form-group">
                                <label>Técnica</label>
                                <v-select v-model="tecnica" label="descripcion" :options="tecnicas"></v-select>   
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
                        <div class="col-md-3">                       
                            <div class="form-group" >
                                <label for="eps">Actividad</label>
                                <input type="text" v-model="actividad" class="form-control" id="actividad">
                            </div>         
                        </div>       
                        <div class="col-md-2">                       
                            <div class="form-group" >
                                <label for="eps">Exposición</label>
                                <input type="number" v-model="exposicion" class="form-control" id="exposicion">
                            </div>         
                        </div>
                        <div class="col-md-3">                       
                            <div class="form-group" >
                                <label for="contratista">Contratista</label>
                                <input type="text" v-model="contratista" class="form-control" id="contratista">
                            </div>         
                        </div>
                        <div class="col-md-3">                       
                            <div class="form-group" >
                                <label for="ejecutor_ensayo">Ejecutor Ensayo</label>
                                 <v-select v-model="ejecutor_ensayo" label="descripcion" :options="ejecutor_ensayos"></v-select>   
                            </div>         
                        </div>                                          
                  </div>
               </div>
                  <button class="btn btn-primary" type="submit">Guardar</button>   
           </form>    
       </div>
   </div>
</template>

<script>

import uniq from 'lodash/uniq';
import Datepicker from 'vuejs-datepicker';
import {mapState} from 'vuex';
import {en, es} from 'vuejs-datepicker/dist/locale'
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

      metodo : {
      type : String,
      required :true
    },
      otdata : {
      type : Object,
      required : true
      },

    },

    data() {return {

        errors:[],
            en: en,
            es: es,          

           // Formulario 

            fecha:'',
            numero_inf:'',
            ext_numero_inf:'',
            formato :'',
            ieg:'',
            componente:'',
            plano_isom:'',
            procedimiento:{},           
            observaciones:'',
            material:{},
            diametro:'',
            espesor:'',
            espesor_chapa:'', 
            equipo:'',
            fuente:'',
            foco:'',
            tipo_pelicula:'',
            pantalla:'Pb',
            pos_ant:'',
            pos_pos:'',
            lado:'',
            distancia_fuente_pelicula:'',
            procedimiento_soldadura:'',
            norma_evaluacion:'',
            ici:'',
            norma_ensayo:'',
            tecnica:'',
            eps:'',
            pqr:'',
            exposicion:'',      
            actividad:'',
            contratista:'',  
            ejecutor_ensayo:'',  

           // fin Formulario 

             procedimientos:[],
             materiales:[],
             diametros:[],
             espesores:[],
             equipos:[],
             fuentes:[],
             tipo_peliculas:[],
             norma_evaluaciones:[],
             icis:[],
             norma_ensayos:[],
             tecnicas:[],
             ejecutor_ensayos :[],


    }},

    created : function(){      

        this.getProcedimientos();
        this.getMateriales();
        this.getDiametros();
        this.getEquipos();
        this.getFuentes();
        this.getTipoPeliculas();
        this.getNormaEvaluaciones();
        this.getIcis();
        this.getNormaEnsayos();
        this.getTecnicas();
        this.getEjecutorEnsayo();     
       
    },   
   

    computed :{

        ...mapState(['url']),
       
     },

    methods : {

        getProcedimientos : function(){

            axios.defaults.baseURL = this.url ;
                var urlRegistros = 'procedimientos_informes/' + this.metodo + '?api_token=' + Laravel.user.api_token;         
                axios.get(urlRegistros).then(response =>{
                this.procedimientos = response.data
                });

        },

        getMateriales : function(){

            axios.defaults.baseURL = this.url ;
                var urlRegistros = 'materiales' + '?api_token=' + Laravel.user.api_token;         
                axios.get(urlRegistros).then(response =>{
                this.materiales = response.data
                });

        },

        getDiametros : function(){

            axios.defaults.baseURL = this.url ;
                var urlRegistros = 'diametros' + '?api_token=' + Laravel.user.api_token;         
                axios.get(urlRegistros).then(response =>{
                this.diametros = response.data
               
                });
         
        },

        getEspesores : function(){
            this.espesor='';
            axios.defaults.baseURL = this.url ;
                var urlRegistros = 'espesor/' + this.diametro.diametro_code + '?api_token=' + Laravel.user.api_token;         
                axios.get(urlRegistros).then(response =>{
                this.espesores = response.data
                });

        },

        getEquipos : function(){
           
            axios.defaults.baseURL = this.url ;
                var urlRegistros = 'equipos/metodo/' + this.metodo + '?api_token=' + Laravel.user.api_token;         
                axios.get(urlRegistros).then(response =>{
                this.equipos = response.data   
            
                });

        },

        getFuentes : function(){
          
            axios.defaults.baseURL = this.url ;
                var urlRegistros = 'fuentes' + '?api_token=' + Laravel.user.api_token;         
                axios.get(urlRegistros).then(response =>{
                this.fuentes = response.data
                });

        },

        getTipoPeliculas : function(){

            axios.defaults.baseURL = this.url ;
                var urlRegistros = 'tipo_peliculas' + '?api_token=' + Laravel.user.api_token;         
                axios.get(urlRegistros).then(response =>{
                this.tipo_peliculas = response.data
               
                });
         
        },

        getNormaEvaluaciones: function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'norma_evaluaciones' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.norma_evaluaciones = response.data
                });
              },

        getIcis: function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'icis' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.icis = response.data
                });
              },

        getNormaEnsayos: function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'norma_ensayos' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.norma_ensayos = response.data
                });
              },

        getTecnicas: function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'tecnicas' + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.tecnicas = response.data
                });
              },
        getEjecutorEnsayo: function(){
             
                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'ot-operarios/ejecutor_ensayo/' + this.otdata.numero + '?api_token=' + Laravel.user.api_token;        
                axios.get(urlRegistros).then(response =>{
                this.ejecutor_ensayos = response.data
                }).catch(error => {
                  
                  console.log(error);
              });
              },

        Store : function(){
         
            this.errors =[];
            let gasoducto_sn = this.formato =='GASODUCTO'  ? true : false ;
         
            var urlRegistros = 'informes_ri' ;      
            axios({
              method: 'post',
              url : urlRegistros,    
              data : {
                
                'ot'            : this.otdata,
                'metodo_ensayo' : this.metodo,  
                'fecha':          this.fecha,
                'numero_inf':     this.numero_inf,
                'ext_numero_inf': this.ext_numero_inf,
                'gasoducto_sn' :  gasoducto_sn,
                'ieg':            this.ieg,
                'componente' :    this.componente,
                'plano_isom' :    this.plano_isom,
                'procedimiento' : this.procedimiento,           
                'observaciones':  this.observaciones,
                'material':       this.material,
                'diametro':       this.diametro.diametro,
                'espesor':        this.espesor.espesor,
                'espesor_chapa':  this.espesor_chapa, 
                'equipo'       :  this.equipo,
                'fuente'       :  this.fuente ,
                'foco':           this.foco,
                'tipo_pelicula' : this.tipo_pelicula,
                'pantalla':       this.pantalla,
                'pos_ant':        this.pos_ant,
                'pos_pos':       this.pos_pos,
                'lado':          this.lado,
                'distancia_fuente_pelicula': this.distancia_fuente_pelicula,
                'procedimiento_soldadura': this.procedimiento_soldadura,
                'norma_evaluacion': this.norma_evaluacion,
                'ici': this.ici,
                'norma_ensayo': this.norma_ensayo,
                'tecnica':this.tecnica,
                'eps':this.eps,
                'pqr':this.pqr,
                'actividad' : this.actividad,
                'exposicion': this.exposicion,
                'contratista' : this.contratista,
          }}
          
      
        ).then(response => {
          this.response = response.data
          toastr.success('informe N°' + this.numero_inf + ' fue creado con éxito ');
          console.log(response);
        }).catch(error => {
               
               this.errors = error.response.data.errors;
                console.log(error.response);
                console.log('hola'); 
               $.each( this.errors, function( key, value ) {
                   toastr.error(value);
                   console.log( key + ": " + value );
               });

           });    

        },
        Update : function() {

            console.log('entro en el edit');

        }



    }


    
}
</script>

