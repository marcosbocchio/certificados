<template>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-custom-enod">
                <div class="box-body">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cliente">Cliente *</label>
                            <v-select v-model="cliente" label="razon_social" :options="clientes" :disabled="user.cliente_id != null"></v-select>           
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="obra">Obra *</label>
                              <input type="number" v-model="obra" class="form-control" id="obra">    
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha">Fecha Desde *</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                                </div>
                                    <Datepicker v-model="fecha_desde" :input-class="'form-control pull-right'" :language="es"></Datepicker>   
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha">Fecha Hasta *</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                                </div>
                                    <Datepicker v-model="fecha_hasta" :input-class="'form-control pull-right'" :language="es"></Datepicker>   
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group" >
                            <button @click="ExportaraPdf">Exportar a PDF</button>                                
                            <p>&nbsp;</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>     
</template>

<script>
import moment from 'moment';
import Datepicker from 'vuejs-datepicker';
import {mapState} from 'vuex';
import {en, es} from 'vuejs-datepicker/dist/locale'
export default {

    components: {

      Datepicker
      
    },
    props: {

      user : {
        type : Object,
        required : true,       
      },

    },
     data() { return {    
        en: en,
        es: es, 
        cliente:{},
        clientes:[],
        obra:'',
        fecha_desde:new Date(),
        fecha_hasta:new Date(),
    
     }
    },
 created: function () {

     this.getClienteOperador();

 },

     computed :{

        ...mapState(['url','AppUrl']),
       
     },

 methods : {

     getClienteOperador(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'clientes/operador/' + this.user.id  +'?api_token=' + Laravel.user.api_token;         
            axios.get(urlRegistros).then(response =>{
                this.clientes = response.data
               if(this.user.cliente_id != null) {
                   this.cliente = response.data;
               }
            });   
     },


    ExportaraPdf2 : function(){
         
          this.errors =[];
          
            var urlRegistros = '/pdf/soldadores/estadisticas-soldaduras/';      
            axios({
              method: 'post',
              url : urlRegistros,    
              data : {             
                'cliente'              : this.cliente,      
                'obra'                 :this.obra,         
                'fecha_desde'          : this.fecha_desde,
                'fecha_hasta'          : this.fecha_hasta,
    
          }}).then(res => {
              
              console.log(res.data);
          }
          
          
          ).catch(error => {
               
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

     ExportaraPdf(){

         console.log('exportar a pdf');
         window.open(this.url + '/pdf/soldadores/estadisticas-soldaduras/cliente/' + this.cliente.id + '/obra/' + this.obra + '/fecha_desde/' + moment(this.fecha_desde).format('DD-MM-YYYY') + '/fecha_hasta/' + moment(this.fecha_hasta).format('DD-MM-YYYY'),'_blank');

     }
 }
}
</script>