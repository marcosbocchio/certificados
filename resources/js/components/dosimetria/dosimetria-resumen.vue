<template>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-body">   
                     <div class="col-md-3">
                        <div class="form-group">
                            <label>Año</label>
                            <v-select v-model="year" label="name" :options="years" ></v-select>
                        </div>   
                    </div>
                </div>
            </div>
            <div v-if="TablaResumen.length">
                <div class="box box-danger">
                    <div class="box-body">
                        <div class="col-md-12">
                           <a :href="url + '/pdf/dosimetria/year/' + year "  target="_blank">Exportar Resumen PDF</a>
                           <p>&nbsp;</p>
                        </div>    
                        <div class="col-md-12">
                            <div class="table-responsive">          
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>                                     
                                            <th style="text-align:center;min-width:250px;" rowspan="2" >OPERADOR</th>     
                                            <th style="text-align:center;" rowspan="2">DNI</th>
                                            <th style="text-align:center;" rowspan="2">FILM</th>  
                                            <th style="text-align:center;" colspan="3">ENERO</th>  
                                            <th style="text-align:center;" colspan="3">FEBRERO</th>                                                     
                                            <th style="text-align:center;" colspan="3">MARZO</th>                                                     
                                            <th style="text-align:center;" colspan="3">ABRIL</th>                                                     
                                            <th style="text-align:center;" colspan="3">MAYO</th>                                                     
                                            <th style="text-align:center;" colspan="3">JUNIO</th>                                                     
                                            <th style="text-align:center;" colspan="3">JULIO</th>                                                     
                                            <th style="text-align:center;" colspan="3">AGOSTO</th>                                                     
                                            <th style="text-align:center;" colspan="3">SEPTIEMBRE</th>                                                     
                                            <th style="text-align:center;" colspan="3">OCTUBRE</th>                                                     
                                            <th style="text-align:center;" colspan="3">NOVIEMBRE</th>                                                     
                                            <th style="text-align:center;" colspan="3">DICIEMBRE</th>  
                                            <th style="text-align:center;" colspan="2">ACUMULADO</th>                                                                                
                                        </tr>
                                        <tr>   
                                            <th style="text-align:center;">OP</th>     
                                            <th style="text-align:center;">RX</th>
                                            <th style="text-align:center;">E</th>   
                                            <th style="text-align:center;">OP</th>     
                                            <th style="text-align:center;">RX</th>
                                            <th style="text-align:center;">E</th>  
                                            <th style="text-align:center;">OP</th>     
                                            <th style="text-align:center;">RX</th>
                                            <th style="text-align:center;">E</th>   
                                            <th style="text-align:center;">OP</th>     
                                            <th style="text-align:center;">RX</th>
                                            <th style="text-align:center;">E</th>
                                            <th style="text-align:center;">OP</th>     
                                            <th style="text-align:center;">RX</th>
                                            <th style="text-align:center;">E</th>   
                                            <th style="text-align:center;">OP</th>     
                                            <th style="text-align:center;">RX</th>
                                            <th style="text-align:center;">E</th> 
                                            <th style="text-align:center;">OP</th>     
                                            <th style="text-align:center;">RX</th>
                                            <th style="text-align:center;">E</th>   
                                            <th style="text-align:center;">OP</th>     
                                            <th style="text-align:center;">RX</th>
                                            <th style="text-align:center;">E</th>
                                            <th style="text-align:center;">OP</th>     
                                            <th style="text-align:center;">RX</th>
                                            <th style="text-align:center;">E</th>   
                                            <th style="text-align:center;">OP</th>     
                                            <th style="text-align:center;">RX</th>
                                            <th style="text-align:center;">E</th>
                                            <th style="text-align:center;">OP</th>     
                                            <th style="text-align:center;">RX</th>
                                            <th style="text-align:center;">E</th>   
                                            <th style="text-align:center;">OP</th>     
                                            <th style="text-align:center;">RX</th>
                                            <th style="text-align:center;">E</th>
                                            <th style="text-align:center;">OP</th>     
                                            <th style="text-align:center;">RX</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item,k) in TablaResumen" :key="k"> 
                                                        
                                            <td bgcolor="#bee5eb"  @click="getPeriodos(item.operador_id)">
                                                <popper trigger="click" :options="{placement: 'top'}">
                                                    <div class="popper">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:100px;max-height: 30px;">Alta</th>
                                                                        <th style="width:100px;">Baja</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="(item,k) in TablaPeriodos" :key="k">
                                                                        <td>{{item.alta}}</td>  
                                                                        <td>{{item.baja}}</td>          
                                                                    </tr>
                                                                </tbody>
                                                            </table> 
                                                
                                                    </div>

                                                    <a href="#" slot="reference" class="top" :class="{habilitadoArn : item.habilitado_arn_sn}">
                                                    {{item.operador}}
                                                    </a>  
                                                </popper>                                              
                                                </td>    
                                            <td style="text-align:center;"> {{item.dni}} </td>
                                            <td style="text-align:center;"> {{item.film}} </td>
                                            <td style="text-align:center;" :class="[{maxRxMensual : (parseFloat(item.DOM1) > max_rx_mensual)},{MaxDifOpRx : (Math.abs(parseFloat(item.DOM1) -parseFloat(item.DRXM1))) > max_dif_op_rx}]">  {{item.DOM1}} </td>
                                            <td style="text-align:center;" :class="[{maxRxMensual : (parseFloat(item.DRXM1) > max_rx_mensual)},{MaxDifOpRx : (Math.abs(parseFloat(item.DOM1) -parseFloat(item.DRXM1))) > max_dif_op_rx}]"> {{item.DRXM1}} </td>
                                            <td style="text-align:center;" :style="{color:item.CM1}" > {{item.EM1}} </td>
                                            <td style="text-align:center;" :class="[{maxRxMensual : (parseFloat(item.DOM2) > max_rx_mensual)},{MaxDifOpRx : (Math.abs(parseFloat(item.DOM2) -parseFloat(item.DRXM2))) > max_dif_op_rx}]">  {{item.DOM2}} </td>
                                            <td style="text-align:center;" :class="[{maxRxMensual : (parseFloat(item.DRXM2) > max_rx_mensual)},{MaxDifOpRx : (Math.abs(parseFloat(item.DOM2) -parseFloat(item.DRXM2))) > max_dif_op_rx}]"> {{item.DRXM2}} </td>   
                                            <td style="text-align:center;" :style="{color:item.CM2}"> {{item.EM2}} </td>    
                                            <td style="text-align:center;" :class="[{maxRxMensual : (parseFloat(item.DOM3) > max_rx_mensual)},{MaxDifOpRx : (Math.abs(parseFloat(item.DOM3) -parseFloat(item.DRXM3))) > max_dif_op_rx}]"> {{item.DOM3}} </td>
                                            <td style="text-align:center;" :class="[{maxRxMensual : (parseFloat(item.DRXM3) > max_rx_mensual)},{MaxDifOpRx : (Math.abs(parseFloat(item.DOM3) -parseFloat(item.DRXM3))) > max_dif_op_rx}]"> {{item.DRXM3}} </td>     
                                            <td style="text-align:center;" :style="{color:item.CM3}"> {{item.EM3}} </td>
                                            <td style="text-align:center;" :class="[{maxRxMensual : (parseFloat(item.DOM4) > max_rx_mensual)},{MaxDifOpRx : (Math.abs(parseFloat(item.DOM4) -parseFloat(item.DRXM4))) > max_dif_op_rx}]"> {{item.DOM4}} </td>
                                            <td style="text-align:center;" :class="[{maxRxMensual : (parseFloat(item.DRXM4) > max_rx_mensual)},{MaxDifOpRx : (Math.abs(parseFloat(item.DOM4) -parseFloat(item.DRXM4))) > max_dif_op_rx}]"> {{item.DRXM4}} </td>
                                            <td style="text-align:center;" :style="{color:item.CM4}"> {{item.EM4}} </td>                                                                                    
                                            <td style="text-align:center;" :class="[{maxRxMensual : (parseFloat(item.DOM5) > max_rx_mensual)},{MaxDifOpRx : (Math.abs(parseFloat(item.DOM5) - parseFloat(item.DRXM5))) > max_dif_op_rx}]">  {{item.DOM5}} </td>
                                            <td style="text-align:center;" :class="[{maxRxMensual : (parseFloat(item.DRXM5) > max_rx_mensual)},{MaxDifOpRx : (Math.abs(parseFloat(item.DOM5) - parseFloat(item.DRXM5))) > max_dif_op_rx}]"> {{item.DRXM5}} </td>
                                            <td style="text-align:center;" :style="{color:item.CM5}"> {{item.EM5}} </td>                                                                                    
                                            <td style="text-align:center;" :class="[{maxRxMensual : (parseFloat(item.DOM6) > max_rx_mensual)},{MaxDifOpRx : (Math.abs(parseFloat(item.DOM6) -parseFloat(item.DRXM6))) > max_dif_op_rx}]">  {{item.DOM6}} </td>
                                            <td style="text-align:center;" :class="[{maxRxMensual : (parseFloat(item.DRXM6) > max_rx_mensual)},{MaxDifOpRx : (Math.abs(parseFloat(item.DOM6) -parseFloat(item.DRXM6))) > max_dif_op_rx}]"> {{item.DRXM6}} </td>     
                                            <td style="text-align:center;" :style="{color:item.CM6}" > {{item.EM6}} </td>                                                                               
                                            <td style="text-align:center;" :class="[{maxRxMensual : (parseFloat(item.DOM7) > max_rx_mensual)},{MaxDifOpRx : (Math.abs(parseFloat(item.DOM7) -parseFloat(item.DRXM7))) > max_dif_op_rx}]"> {{item.DOM7}} </td>
                                            <td style="text-align:center;" :class="[{maxRxMensual : (parseFloat(item.DRXM7) > max_rx_mensual)},{MaxDifOpRx : (Math.abs(parseFloat(item.DOM7) -parseFloat(item.DRXM7))) > max_dif_op_rx}]"> {{item.DRXM7}} </td>    
                                            <td style="text-align:center;" :style="{color:item.CM7}"> {{item.EM7}} </td>                                                                                
                                            <td style="text-align:center;" :class="[{maxRxMensual : (parseFloat(item.DOM8) > max_rx_mensual)},{MaxDifOpRx : (Math.abs(parseFloat(item.DOM8) -parseFloat(item.DRXM8))) > max_dif_op_rx}]"> {{item.DOM8}} </td>
                                            <td style="text-align:center;" :class="[{maxRxMensual : (parseFloat(item.DRXM8) > max_rx_mensual)},{MaxDifOpRx : (Math.abs(parseFloat(item.DOM8) -parseFloat(item.DRXM8))) > max_dif_op_rx}]"> {{item.DRXM8}} </td>    
                                            <td style="text-align:center;" :style="{color:item.CM8}"> {{item.EM8}} </td>                                                                                
                                            <td style="text-align:center;" :class="[{maxRxMensual : (parseFloat(item.DOM9) > max_rx_mensual)},{MaxDifOpRx : (Math.abs(parseFloat(item.DOM9) -parseFloat(item.DRXM9))) > max_dif_op_rx}]"> {{item.DOM9}} </td>
                                            <td style="text-align:center;" :class="[{maxRxMensual : (parseFloat(item.DRXM9) > max_rx_mensual)},{MaxDifOpRx : (Math.abs(parseFloat(item.DOM9) -parseFloat(item.DRXM9))) > max_dif_op_rx}]"> {{item.DRXM9}} </td>   
                                            <td style="text-align:center;" :style="{color:item.CM9}"> {{item.EM9}} </td>                                                                                 
                                            <td style="text-align:center;" :class="[{maxRxMensual : (parseFloat(item.DOM10) > max_rx_mensual)},{MaxDifOpRx : (Math.abs(parseFloat(item.DOM10) -parseFloat(item.DRXM10))) > max_dif_op_rx}]"> {{item.DOM10}} </td>
                                            <td style="text-align:center;" :class="[{maxRxMensual : (parseFloat(item.DRXM10) > max_rx_mensual)},{MaxDifOpRx : (Math.abs(parseFloat(item.DOM10) -parseFloat(item.DRXM10))) > max_dif_op_rx}]"> {{item.DRXM10}} </td>                                                                                    
                                            <td style="text-align:center;" :style="{color:item.CM10}"> {{item.EM10}} </td>
                                            <td style="text-align:center;" :class="[{maxRxMensual : (parseFloat(item.DOM11) > max_rx_mensual)},{MaxDifOpRx : (Math.abs(parseFloat(item.DOM11) -parseFloat(item.DRXM11))) > max_dif_op_rx}]"> {{item.DOM11}} </td>
                                            <td style="text-align:center;" :class="[{maxRxMensual : (parseFloat(item.DRXM11) > max_rx_mensual)},{MaxDifOpRx : (Math.abs(parseFloat(item.DOM11) -parseFloat(item.DRXM11))) > max_dif_op_rx}]"> {{item.DRXM11}} </td>                                                                                    
                                            <td style="text-align:center;" :style="{color:item.CM11}"> {{item.EM11}} </td>
                                            <td style="text-align:center;" :class="[{maxRxMensual : (parseFloat(item.DOM12) > max_rx_mensual)},{MaxDifOpRx : (Math.abs(parseFloat(item.DOM12) -parseFloat(item.DRXM12))) > max_dif_op_rx}]"> {{item.DOM12}} </td>
                                            <td style="text-align:center;" :class="[{maxRxMensual : (parseFloat(item.DRXM12) > max_rx_mensual)},{MaxDifOpRx : (Math.abs(parseFloat(item.DOM12) -parseFloat(item.DRXM12))) > max_dif_op_rx}]"> {{item.DRXM12}} </td>                                                                                    
                                            <td style="text-align:center;" :style="{color:item.CM12}"> {{item.EM12}} </td>
                                            <td style="text-align:center;">{{item.ACUMULADO_OP}}</td>
                                            <td style="text-align:center;">{{item.ACUMULADO_RX}}</td>
                                                                                    
                                        </tr>                       
                                        
                                    </tbody>
                                </table>                   
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>    
            </div>
        </div>      
      </div>
    </div>
</template>

<script>

import {mapState} from 'vuex'
import { eventModal } from '../event-bus';
import Popper from 'vue-popperjs';

export default {

      components: {
        	'popper': Popper
  },

   props :{

       operador_data : {
       type : Object,
       required : true 
       }

     },

  data () { return {

      TablaResumen:[],
      operador : JSON.parse(JSON.stringify(this.operador_data)),
      year: '',    
      years:[], 
      max_rx_mensual:'',
      max_dif_op_rx:'',
      estados:[],
      TablaPeriodos:[],
  
     
    }    
  },

  created : function() {
 
        this.$store.dispatch('loadFechaActual').then(response => {            
        
            this.setYears();
            this.year = new Date(this.fecha).getFullYear();          
            
       })

        this.$store.dispatch('loadParametrosGenerales','Max_Rx_Mensual').then(response => {            
        
          this.max_rx_mensual = this.ParametroGeneral.valor;
            
       })

        this.$store.dispatch('loadParametrosGenerales','Max_dif_op_rx').then(response => {            
        
          this.max_dif_op_rx = this.ParametroGeneral.valor;
            
       })

      
  },   

  watch : {

        year : function(val){
          
            this.TablaResumen = []      
            console.log('el año es:',this.year);
            this.$store.dispatch('loadDosimetriaResumen', val).then(
                response => {
                  this.TablaResumen = [];         
                  this.TablaResumen = this.dosimetria_resumen;

                }
            );          
            

        },

  },
  
  computed :{

       ...mapState(['url','AppUrl','DiasDelMes','fecha','dosimetria_resumen','ParametroGeneral']),

       anio_actual : function(){

           return new Date(this.fecha).getFullYear();
       },

    },
 
 methods : {    

       getPeriodos(operador_id){
            this.TablaPeriodos = [];
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'operador_periodo_rx/periodos/operador/' + operador_id  +'?api_token=' + Laravel.user.api_token;         
            axios.get(urlRegistros).then(response =>{
            this.TablaPeriodos = response.data
            
            });   
     },
    

     setYears : function(){

         for (let year = 2019; year <= new Date(this.fecha).getFullYear();year++) {
          
             this.years.push(year);       
         }

     },

 },
  
}
</script>

<style scoped>

.maxRxMensual {

    color: red;
}

.MaxDifOpRx {

    text-decoration: underline;
}

.top {
  margin: 0 auto;
  display: table;
}

.habilitadoArn { 

    color:#808080;
}


</style>