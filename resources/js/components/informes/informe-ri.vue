<template>
   <div class="row">
       <div class="col-md-12">
           <form @submit.prevent="submit"  method="post">
               <div class="box box-danger">
                  <div class="box-body">
                      <div class="col-md-6">
                            <div class="form-group" >
                                <label for="ot">Orden de Trabajo N°</label>
                                <input lass="form-control" type="number" v-model="otdata.numero" class="form-control" id="ot" disabled>
                            </div>                            
                        </div>
                  </div>
               </div>
               <div class="box box-danger">
                  <div class="box-body">
                      <div class="col-md-4">
                            <div class="form-group" >
                                <label for="numero_inf">Informe N°</label>
                                <input lass="form-control" type="number" v-model="numero_inf" class="form-control" id="numero_inf">
                            </div>                            
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" >
                                <label for="ext_numero_inf">Ext</label>
                                <input lass="form-control" type="text" v-model="ext_numero_inf" class="form-control" id="ext_numero_inf">
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
                                <label>Procedimiento</label>
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
                                <label for="ign">Ign</label>
                                <input lass="form-control" type="text" v-model="ign" class="form-control" id="ign">
                            </div>                            
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" >
                                <label for="componente">Componente</label>
                                <input lass="form-control" type="text" v-model="componente" class="form-control" id="componente">
                            </div>                            
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" >
                                <label for="plano_isom">Plano / Isom</label>
                                <input lass="form-control" type="text" v-model="plano_isom" class="form-control" id="plano_isom">
                            </div>                            
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" >
                                <label for="Diametro">Diametro</label>
                                <v-select v-model="diametro" label="diametro" :options="diametros_espesor"></v-select>   
                            </div>                            
                        </div>
                        <div class="col-md-2">
                            <div class="form-group" >
                                <label for="Espesor">Espesor</label>
                                <v-select v-model="diametro" label="espesor" :options="diametros_espesor"></v-select>   
                            </div>                            
                        </div>
                        
                  </div>
               </div>
           </form>    
       </div>
   </div>
</template>

<script>

import Datepicker from 'vuejs-datepicker';
import {mapState} from 'vuex'
import {en, es} from 'vuejs-datepicker/dist/locale'
export default {

    components: {

      Datepicker
      
    },

    props : {

      acciondata : {
      type : String,
      required :true
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
            ign:'',
            componente:'',
            plano_isom:'',
            procedimiento:{},           
            observaciones:'',
            material:{},
            diametro_espesor:{},
            diametro:'',
            espesor:'',

           // fin Formulario 

             procedimientos:[],
             materiales:[],
             diametros_espesor:[],


    }},

    created : function(){

        this.getProcedimientos();
        this.getMateriales();
        this. getDiametrosEspesor();
    },

    computed :{

        ...mapState(['url'])
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

        getDiametrosEspesor : function(){

            axios.defaults.baseURL = this.url ;
                var urlRegistros = 'diametros_espesor' + '?api_token=' + Laravel.user.api_token;         
                axios.get(urlRegistros).then(response =>{
                this.diametros_espesor = response.data
                });

        }



    }


    
}
</script>

