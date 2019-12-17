<template>
    <form v-on:submit.prevent="editmode ? updateRegistro() : storeRegistro()">
        <div class="modal fade" id="nuevo">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Crear</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="fecha">Fecha *</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                        </div>
                                            <Datepicker v-model="Registro.fecha" :input-class="'form-control pull-right'" :language="es"></Datepicker>   
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" >
                                    <label for="prefijo">Prefijo</label> 
                                    <input type="text" v-model="Registro.prefijo" class="form-control" id="prefijo" >
                                </div>                            
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" >
                                    <label for="numero_inf">Informe N° *</label>
                                    <input type="text" v-model="numero_inf_code" class="form-control" id="numero_inf">
                                </div>                            
                            </div>
                            <div class="col-md-12">                       
                                <div class="form-group" >
                                    <label for="ejecutor_ensayo">Ejecutor Ensayo *</label>
                                    <v-select v-model="Registro.ejecutor_ensayo" label="name" :options="ejecutor_ensayos"></v-select>   
                                </div>         
                            </div> 
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Observaciones</label>
                                    <textarea v-model="Registro.observaciones" class="form-control noresize" rows="3" placeholder="" maxlength="250"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group" >
                                    <subir-imagen                                
                                        :ruta="ruta"                               
                                        :max_size="max_size"
                                        :path_inicial="Registro.path"
                                        :tipos_archivo_soportados ="tipos_archivo_soportados"    
                                        :mostrar_formatos_soportados="true"                          
                                        @path="Registro.path = $event"
                                    ></subir-imagen> 
                                </div>   
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="Guardar">
                        <button type="button" class="btn btn-default" name="button" data-dismiss="modal" >Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>

import {mapState} from 'vuex'
import { eventNewRegistro, eventEditRegistro, eventDeleteFile} from '../../event-bus';
import Datepicker from 'vuejs-datepicker';
import {en, es} from 'vuejs-datepicker/dist/locale'
export default {


components: {

      Datepicker
      
    },

    props :{
        metodo_ensayo: {
        type : Object,
        required : false
        },   

        ot_id : '',
    
  },

    data() { return {

        en: en,
        es: es,

        ruta: 'informes_importados',
        max_size :50000, //KB
        tipos_archivo_soportados:['pdf'],
    
         Registro : {
            'ot_id':'',
            'numero_inf': '',
            'prefijo'  : '',
            'observaciones':'',
            'path':'',
            'metodo_ensayo' : {},     
            'ejecutor_ensayo' :{}
         },

        errors: {}
      
        }
    },

   created: function () {

    eventNewRegistro.$on('open', this.nuevoRegistro);
    eventEditRegistro.$on('edit', this.EditRegistro);
    
    this.$store.dispatch('loadEjecutorEnsayo', this.ot_id); 


    },



    computed :{
    
        ...mapState(['url','AppUrl','ejecutor_ensayos']),   
        
        numero_inf_code : function()  {

            if(this.Registro.numero_inf)

                    return this.metodo_ensayo.metodo + (this.Registro.numero_inf <10? '00' : this.Registro.numero_inf<100? '0' : '') + this.Registro.numero_inf ;
    },
    },
 
    methods: {

       nuevoRegistro : function(){      
            
           this.editmode = false; 
           this.uploadPercentage = 0;   
           this.Registro = {
            'ot_id' : this.ot_id,
            'numero_inf': '',
            'prefijo'  : '',
            'observaciones':'',
            'path':'',
            'metodo_ensayo' : this.metodo_ensayo,
            'ejecutor_ensayo' :{}
         }
         this.getNumeroInforme();
         eventDeleteFile.$emit('delete');
         $('#nuevo').modal('show');
        },

        getNumeroInforme:function(){            
           
            if(!this.editmode) {
           
                    axios.defaults.baseURL = this.url ;
                        var urlRegistros = 'informes/ot/' + this.ot_id + '/metodo/' + this.metodo_ensayo.metodo + '/generar-numero-informe'  + '?api_token=' + Laravel.user.api_token;         
                        axios.get(urlRegistros).then(response =>{
                        this.numero_inf_generado = response.data 
                        
                        if(this.numero_inf_generado.length){

                            this.Registro.numero_inf =  this.numero_inf_generado[0].numero_informe
                        }else{

                            this.Registro.numero_inf = 1;
                        }
                        
                        
                        });   
             }
        },   


        storeRegistro: function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'informes_importados';  
            console.log('entro en el store de informes importados');        
            axios.post(urlRegistros, {   
                
                ...this.Registro
                

            }).then(response => {
                this.$emit('store');
                this.errors=[];
                $('#nuevo').modal('hide');               
                toastr.success('El informe fue importado con éxito');
                      
            }).catch(error => {
               
                this.errors = error.response.data.errors;

                $.each( this.errors, function( key, value ) {
                    toastr.error(value,key);
                    console.log( key + ": " + value );
                });

            });

        }
    }
}
</script>