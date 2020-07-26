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
                                    <div>                                                                      
                                        <date-picker v-model="fecha" value-type="YYYY-MM-DD" format="DD-MM-YYYY" placeholder="DD-MM-YYYY" ></date-picker>
                                    </div> 
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group" >
                                    <label for="numero">Certificado N° </label>
                                    <input type="number" v-model="numero_code" class="form-control" id="numero" disabled>
                                </div>                            
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Título</label>
                                    <input v-model="titulo" class="form-control" placeholder="" maxlength="40">
                                </div>
                            </div>  

                            <div class="clearfix"></div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Información adicional</label>
                                    <textarea v-model="info_pedido_cliente" class="form-control noresize" rows="2" placeholder="" maxlength="100"></textarea>
                                </div>
                            </div>                    

                         </div>
                     </div>

                    <div class="box box-custom-enod">
                        <div class="box-header with-border">
                            <h3 class="box-title">Partes sin certificados</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>                       
                            </div>
                        </div>
                         <div class="box-body">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped table-condensed">
                                    <thead>
                                        <tr>
                                            <th class="col-md-1">Sel.</th>                                                                                                  
                                            <th class="col-md-3">Parte N°</th>  
                                            <th class="col-md-3">Obra</th> 
                                            <th class="col-md-3">Fecha</th>                                      
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(parte,k) in partes" :key="k">
                                            <td>
                                                <input type="checkbox" id="informe_sel" v-model="partes[k].parte_sel" @change="getPartes(k)" :disabled="loading">
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

                    <div v-show="TablaPartesServicios.length">
                        <div class="box box-custom-enod">
                            <div class="box-header with-border">
                                <h3 class="box-title">Servicios</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>                       
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped table-bordered table-condensed">
                                        <thead>
                                            <tr>                                                                                                      
                                                <th class="col-md-1">Parte N°</th>  
                                                <th class="col-md-1">Obra</th>     
                                                <th class="col-md-2">Servicio</th> 
                                                <th class="col-md-4">Descripción</th>
                                                <th class="col-md-1">Fecha</th>     
                                                <th class="col-md-1">Combinación</th>  
                                                <th class="col-md-1">&nbsp;</th>                                                      
                                                <th class="col-md-1">Cantidad</th>     
                                            <th class="col-md-1">&nbsp;</th>                                                                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item,k) in TablaPartesServicios" :key="k" @click="selectPosTablaPartesServicios(k)">                                        

                                                <td v-if="item.visible">{{ item.numero_formateado}}</td>
                                                <td v-if="item.visible">{{ item.obra}}</td>
                                                <td v-if="item.visible">{{ item.abreviatura}}</td> 
                                                <td v-if="item.visible">{{ item.servicio_descripcion}}</td>  

                                                <td v-if="item.visible">{{ item.fecha_formateada}}</td>
                                                <td  v-if="item.visible">

                                                    <div class="input-group col-xs-12">                                                      
                                                        <input type="number" id="nro_combinacion" class="form-control form-group-xs text-center"  maxlength="2" v-model="TablaPartesServicios[k].nro_combinacion" disabled >

                                                        <span class="input-group-btn">
                                                            <button type="button"  class="btn btn-md btn-default" @click="borrarCombinacion(TablaPartesServicios[k].nro_combinacion)">X</button>
                                                         
                                                        </span>
                                                        
                                                    </div>                                                     
                                                </td>
                                                <td  v-if="item.visible">
                                                    <span style="display: inline-block;">
                                                        {{ item.combinacion}}   
                                                    </span>

                                                </td>                           
                                                   
                                                   
                                                <td v-if="item.visible" style="text-align: center;">                                                                                                                                                                     
                                                    <div v-if="indexTablaPartesServicios == k ">      
                                                        <input type="number" v-model="TablaPartesServicios[k].cant_final"  maxlength="2" style="width: 50px;">  
                                                    </div>                                             
                                                    <div v-else>
                                                        {{ item.cant_final }}
                                                    </div>  
                                                </td> 
                                                <td style="text-align:center" v-if="item.visible"> 
                                                    <a  @click="RemoveTablaPartesServicios(k)"> <app-icon img="minus-circle" color="black"></app-icon> </a>
                                                </td>
                                        
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>                                                
                            </div>
                        </div>
                    </div>

                    <div v-show="TablaPartesProductosPorCosturas.length && modo_cobro=='COSTURAS'">
                        <div class="box box-custom-enod">
                            <div class="box-header with-border">
                                <h3 class="box-title">Productos</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>                       
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped table-condensed">
                                        <thead>
                                            <tr>   
                                                <th class="col-md-3">Parte N°</th>                                                                                           
                                                <th class="col-md-3">Costuras</th>  
                                                <th class="col-md-3">Pulgadas</th>                                                                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item,k) in TablaPartesProductosPorCosturas" :key="k" @click="selectPosTablaPartesProductosPorCosturas(k)">                                                                                         
                                                <td>{{ item.numero_formateado}}</td>
                                                <td>
                                                   <div v-if="indexTablaPartesProductosPorCosturas == k ">      
                                                        <input type="number" v-model="TablaPartesProductosPorCosturas[k].costuras_final" maxlength="10">  
                                                    </div>                                             
                                                    <div v-else>
                                                        {{ item.costuras_final }}
                                                    </div>                                               
                                                 
                                                </td>
                                                <td>{{ item.pulgadas}}</td>                                                                                                                                                            
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>                                                
                            </div>
                        </div>
                    </div>

                    <div v-show="TablaPartesProductosPorPlacas.length && modo_cobro=='PLACAS'">
                        <div class="box box-custom-enod">
                            <div class="box-header with-border">
                                <h3 class="box-title">Productos</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>                       
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped table-condensed">
                                        <thead>
                                            <tr>       
                                                <th class="col-md-3">Parte N°</th>                                                                                                 
                                                <th class="col-md-3">Placas</th>  
                                                <th class="col-md-3">CM</th>                                                                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item,k) in TablaPartesProductosPorPlacas" :key="k" @click="selectPosTablaPartesProductosPorPlacas(k)">  
                                                <td>{{ item.numero_formateado}}</td>                                                                                       
                                                <td>                                                  
                                                    <div v-if="indexTablaPartesProductosPorPlacas == k ">      
                                                        <input type="number" v-model="TablaPartesProductosPorPlacas[k].placas_final" maxlength="10">  
                                                    </div>                                             
                                                    <div v-else>
                                                        {{ item.placas_final }}
                                                    </div>   
                                                </td>
                                                <td>{{ item.cm}}</td>  
                                                                                                                                                            
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
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
import {mapState} from 'vuex';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/es';
import {sprintf} from '../../functions/sprintf.js'
import moment from 'moment';

export default {

    components: {

            
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
      
      certificado_data : {
     type : Object,
      required : false
      },

      servicios_data : {
      type : [ Array ],  
      required : false
      },

      productos_placas_data : {
      type : [ Array ],  
      required : false
      },

      productos_costura_data : {
      type : [ Array ],  
      required : false
      },
    },

    data () { return{

        errors:[],
        numero:'',      
        titulo :'',
        fecha: moment(new Date()).format('YYYY-MM-DD'),
        info_pedido_cliente:'',
        partes:[],
        modo_cobro:'',
        TablaPartesServicios:[],
        TablaPartesProductosPorPlacas:[],
        TablaPartesProductosPorCosturas:[],
        indexTablaPartesProductosPorPlacas:-1,
        indexTablaPartesProductosPorCosturas:-1,
        indexTablaPartesServicios:-1,
        loading : false,
       }
    },

    created : function() {

        this.CargaDeDatos();  

    },

      mounted : function() {    

        this.getModalidadCobro();
        this.getNumeroCertificado();       

      },         

    computed :{

        ...mapState(['url']),     

        numero_code : function()  {

               if(this.numero){

                   return   sprintf("%08d",this.numero) ;
                  
               }
        },       
     },

      methods : { 

          CargaDeDatos : function(){

             if(this.editmode) {

                this.fecha  = this.certificado_data.fecha;   
                this.numero = this.certificado_data.numero;
                this.titulo = this.certificado_data.titulo;
                this.info_pedido_cliente = this.certificado_data.info_pedido_cliente;

                this.$nextTick(function(){

                   this.setCerficadoServicios(); 
                   this.setCerficadoProductos();
                   this.getPartesPendientesYEditableCertificado(); 

               });      

             }else{      

                  this.getPartesPendientesCertificado();

             }

          },

        getModalidadCobro : function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'certificados/ot/' + this.otdata.id + '/modalidad_cobro' + '?api_token=' + Laravel.user.api_token;  
            axios.get(urlRegistros).then(response =>{                
              
                let reg = response.data;
                this.modo_cobro = reg.length ? 'COSTURAS' : 'PLACAS'              

            });
        },

        async getPartes(index){ 
        
           this.loading = true;    
           if(this.partes[index].parte_sel){               
                     
                this.partes.forEach(function(item){
                    
                    item.parte_sel = false ;

                }.bind(this));
                this.TablaPartesServicios = [];
                this.TablaPartesProductosPorPlacas = [];
                this.TablaPartesProductosPorCosturas = [];                  
                await this.seleccionarAnteriores(index);  
                
            }else{
                    
                    this.deleteServiciosParte(this.partes[index].id)   
                    this.deleteProductosParte(this.partes[index].id)                  
                    
            }
           this.loading = false;
        },

        async  seleccionarAnteriores(index){                    
        
            this.partes[index].parte_sel = false; 
            for ( let x = 0 ; x <= index; x++ ) {                          

                await this.getServiciosParte(this.partes[x].id);
                this.getProductosParte(this.partes[x].id);                
                this.partes[x].parte_sel = true;                                
                
            }                      

            this.completarTitulo(index);
         
        },

        completarTitulo :  function(index){

           this.titulo = this.partes[0].fecha_formateada + ' - ' + this.partes[index].fecha_formateada ;

        },

        setCerficadoServicios : function(){

            this.TablaPartesServicios =  JSON.parse(JSON.stringify(this.servicios_data));  

            this.TablaPartesServicios.forEach(function(item) {

                if(item.cant_final == null){
                    item.visible = false;
                }else{
                     item.visible = true;
                }
            }.bind(this))
        },

        getPartesPendientesYEditableCertificado : function(){

             axios.defaults.baseURL = this.url ;
             var urlRegistros = 'partes/ot/' + this.otdata.id + '/certificado/'+ this.certificado_data.id + '/pendientes_editables_certificado' + '?api_token=' + Laravel.user.api_token;        
             axios.get(urlRegistros).then(response =>{
             this.partes = JSON.parse(JSON.stringify(response.data));   

                 this.servicios_data.forEach(function(item){

                     if(this.partes.map(x => x.id).indexOf(item.parte_id) !== -1){

                         this.partes[this.partes.map(x => x.id).indexOf(item.parte_id)].parte_sel = true;
                     }


                 }.bind(this));

                 this.productos_costura_data.forEach(function(item){

                     if(this.partes.map(x => x.id).indexOf(item.parte_id) !== -1){

                         this.partes[this.partes.map(x => x.id).indexOf(item.parte_id)].parte_sel = true;
                     }


                 }.bind(this));

                 this.productos_placas_data.forEach(function(item){

                     if(this.partes.map(x => x.id).indexOf(item.parte_id) !== -1){

                         this.partes[this.partes.map(x => x.id).indexOf(item.parte_id)].parte_sel = true;
                     }


                 }.bind(this));

            });

        },

        setCerficadoProductos : function(){

            this.TablaPartesProductosPorPlacas =  JSON.parse(JSON.stringify(this.productos_placas_data));  
            this.TablaPartesProductosPorCosturas =  JSON.parse(JSON.stringify(this.productos_costura_data));  

        },

        cargarCombinados : function(){

            let longServicios = this.TablaPartesServicios.length;
            
            if(longServicios > 0 ){

                let index = 0;
                let contador = 1;  
                let fecha_inicial = moment(this.TablaPartesServicios[index].fecha).format('DD/MM/YYYY'); 
                let fecha_final =  moment(this.TablaPartesServicios[longServicios -1].fecha).format('DD/MM/YYYY');          

                this.TablaPartesServicios.forEach(function(item)  {
                    item.nro_combinacion = '';
                });        

                console.log('Fechas iniciales y finales');

                while ((fecha_inicial <= fecha_final)&&(index < longServicios)) {

                    console.log(index);
                    console.log(fecha_inicial);
                    console.log(fecha_final);
                    let abrev = this.getAbrevCombinadas(fecha_inicial);
                    console.log(abrev);
                    while ((index < longServicios) && (moment(this.TablaPartesServicios[index].fecha).format('DD/MM/YYYY') == fecha_inicial)) {
                        
                        if ((abrev.findIndex(elemento => elemento == this.TablaPartesServicios[index].abreviatura) != -1)&&(abrev.length > 2)) {
                            
                            let longAbrev = abrev.length;
                            this.TablaPartesServicios[index].combinacion = abrev[longAbrev - 1];
                            this.TablaPartesServicios[index].nro_combinacion = contador;
                        }
                        index++;
                    }
                    contador++;

                    if(index < longServicios){

                        fecha_inicial =  moment(this.TablaPartesServicios[index].fecha).format('DD/MM/YYYY');

                    }
                }

            }

            this.CompletarNoCombinados();

        },

        getAbrevCombinadas : function(fecha_inicial){

            let index = 0;
            let longServicios = this.TablaPartesServicios.length;
            let abreviaturas = [];
            while(moment(this.TablaPartesServicios[index].fecha).format('DD/MM/YYYY') != fecha_inicial){
                index++;
            }     
            
            while((index < longServicios) && (moment(this.TablaPartesServicios[index].fecha).format('DD/MM/YYYY') == fecha_inicial) ){

            if ((this.TablaPartesServicios[index].combinado_sn) && (abreviaturas.findIndex(elemento => elemento == this.TablaPartesServicios[index].abreviatura) == -1)){

                    abreviaturas.push(this.TablaPartesServicios[index].abreviatura);
                } 
             index++;
            }

           
            abreviaturas.sort(function(a, b){return a.toLowerCase().localeCompare(b.toLowerCase());});  
            let longAbreviaturas = abreviaturas.length;
            let concatenacion = '';
            index = longAbreviaturas - 1;
            while (index > -1 ) {
                
                concatenacion = !concatenacion ? abreviaturas[index] : (concatenacion + " + " + abreviaturas[index]);               
                index = index - 1;
            }                   

            abreviaturas.push(concatenacion);

            return abreviaturas;
        },

       CompletarNoCombinados : function(){

        this.TablaPartesServicios.forEach(function(item){
                if(item.nro_combinacion == ''){
                    item.combinacion = item.abreviatura;
                }
            });  
       },
       borrarCombinacion : function(nro){

           this.TablaPartesServicios.forEach(function(item){

               if(item.nro_combinacion == nro){

                   item.combinacion = '';
                   item.nro_combinacion = '';
               }

           });

           this.CompletarNoCombinados();

       },

        async getServiciosParte(id){
        
        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'certificados/parte/' + id + '/servicios' + '?api_token=' + Laravel.user.api_token;  
        let res = await axios.get(urlRegistros);
        let parte_servicios = await res.data; 
        parte_servicios.forEach(function(item) {          

            let cantidad = (Math.round(item.cantidad * 100) / 100).toFixed(2);
            this.TablaPartesServicios.push({                           
            
                parte_id : item.parte_id,
                numero_formateado : item.numero_formateado,
                unidades_medidas_id : item.unidad_medida_id, 
                unidad_medida_codigo:item.unidad_medida_codigo,  
                servicio_id : item.servicio_id,
                servicio_descripcion : item.servicio_descripcion,
                cant_original: cantidad,                       
                cant_final: cantidad,   
                abreviatura :item.abreviatura,               
                visible : true,
                nro_combinacion : 0,
                combinado_sn :item.combinado_sn,
                combinacion : '',
                obra : item.obra,
                fecha : item.fecha,                
                fecha_formateada : item.fecha_formateada

            });     
        }.bind(this));     
        this.cargarCombinados();      

        },

        getProductosParte : function(id){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'certificados/parte/' + id + '/modo_cobro/'+ this.modo_cobro +'/productos' + '?api_token=' + Laravel.user.api_token;  
            axios.get(urlRegistros).then(response =>{ 

                let parte_productos = response.data    
                
                parte_productos.forEach(function(item) {

                    let cantidad = (Math.round(item.cantidad * 100) / 100).toFixed(2);
                  //  console.log('modalidad de cobro:' , this.modo_cobro);
                    if(this.modo_cobro=='PLACAS'){

                        this.TablaPartesProductosPorPlacas.push({                           
                        
                            parte_id : item.parte_id,
                            numero_formateado : item.numero_formateado,
                            cm : item.cm_final, 
                            placas_original:item.cantidad, 
                            placas_final:item.cantidad,              
                            visible : true
    
                        });   
                    }else if(this.modo_cobro=='COSTURAS'){

                        this.TablaPartesProductosPorCosturas.push({                           
                        
                            parte_id : item.parte_id,
                            numero_formateado : item.numero_formateado,
                            pulgadas : item.pulgadas_final, 
                            costuras_original:item.cantidad,
                            costuras_final:item.cantidad,              
                            visible : true
    
                        });                         

                    }

                }.bind(this));            

            });
            
        },

        deleteServiciosParte : function(id){
            

            this.TablaPartesServicios = this.TablaPartesServicios.filter(function(item) {
                return item.parte_id != id; 
            });                     
        },

        
        deleteProductosParte : function(id){

           this.TablaPartesProductosPorPlacas = this.TablaPartesProductosPorPlacas.filter(function(item) {
                return item.parte_id != id; 
            });

           this.TablaPartesProductosPorCosturas = this.TablaPartesProductosPorCosturas.filter(function(item) {
                return item.parte_id != id; 
            });
            
        },

        getPartesPendientesCertificado: function(){
             
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'partes/ot/' + this.otdata.id + '/pendientes_certificados' + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{
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
          },

       selectPosTablaPartesProductosPorPlacas: function(index){ 

            this.indexTablaPartesProductosPorPlacas = index ;            

       },   

      selectPosTablaPartesProductosPorCosturas: function(index){ 

            this.indexTablaPartesProductosPorCosturas = index ;    

       },   

       selectPosTablaPartesServicios: function(index){ 

            this.indexTablaPartesServicios = index ;    

       },

       RemoveTablaPartesServicios: function(index){ 

           this.TablaPartesServicios[index].visible = false;
           this.TablaPartesServicios[index].cant_final=''; 
           this.cargarCombinados();

       },  

        Store : function(){


            this.errors =[];
          
            var urlRegistros = 'certificados' ;      
            axios({
              method: 'post',
              url : urlRegistros,    
              data : {     
                'ot'                                 : this.otdata, 
                'numero'                             : this.numero,     
                'titulo'                             : this.titulo,             
                'fecha'                              : this.fecha,
                'info_pedido_cliente'                : this.info_pedido_cliente,
                'TablaPartesServicios'               : this.TablaPartesServicios,
                'TablaPartesProductosPorPlacas'      : this.TablaPartesProductosPorPlacas,     
                'TablaPartesProductosPorCosturas'    : this.TablaPartesProductosPorCosturas,

          }
          
          }).then(response => {

          let certificado = response.data;
          toastr.success('Certificado N°' +  this.numero_code + ' fue creado con éxito ');
          window.open('/pdf/certificado/' + certificado.id + '/final','_blank');
          window.location.href ='/certificados/ot/' + this.otdata.id;
         
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
          
            this.errors =[];        
            var urlRegistros = 'certificados/' + this.certificado_data.id  ;      
            axios({
              method: 'put',
              url : urlRegistros,    
              data : {
                'ot'                                 : this.otdata, 
                'numero'                             : this.numero,                  
                'fecha'                              : this.fecha,
                'titulo'                             : this.titulo,
                'info_pedido_cliente'                : this.info_pedido_cliente,
                'TablaPartesServicios'               : this.TablaPartesServicios,
                'TablaPartesProductosPorPlacas'      : this.TablaPartesProductosPorPlacas,     
                'TablaPartesProductosPorCosturas'    : this.TablaPartesProductosPorCosturas,               
          }}
           
        ).then( () => {

          toastr.success('Certificado N°' +  this.numero_code + ' fue actualizado con éxito ');
          window.open('/pdf/certificado/' + this.certificado_data.id + '/final','_blank');
          window.location.href ='/certificados/ot/' + this.otdata.id;

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

input[type='number']::-webkit-inner-spin-button, 
input[type='number']::-webkit-outer-spin-button { 
    -webkit-appearance: none;
    margin: 0;
}

</style>