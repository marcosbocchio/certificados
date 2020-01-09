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
       
            <div class="box box-danger">
                <div class="box-body">
                     <div class="col-md-12">
                        <div class="table-responsive">          
                            <table class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>                                     
                                        <th style="text-align:center;">OPERADOR</th>     
                                        <th style="text-align:center;">DNI</th>
                                        <th style="text-align:center;">FILM</th>  
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
                                                                                           
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item,k) in TablaResumen" :key="k"> 
                                                    
                                        <td bgcolor="#bee5eb"> {{item.operador}} </td>    
                                        <td style="text-align:center;"> {{item.dni}} </td>
                                        <td style="text-align:center;"> {{item.film}} </td>
                                        <td style="text-align:center;" :class="{maxRxMensual : (item.DOM1 > max_rx_mensual)}"> {{item.DOM1}} </td>
                                        <td style="text-align:center;" :class="{maxRxMensual : (item.DRXM1 > max_rx_mensual)}"> {{item.DRXM1}} </td>
                                        <td style="text-align:center;"> {{item.EM1}} </td>
                                        <td style="text-align:center;" :class="{maxRxMensual : (item.DOM2 > max_rx_mensual)}"> {{item.DOM2}} </td>
                                        <td style="text-align:center;" :class="{maxRxMensual : (item.DRXM2 > max_rx_mensual)}"> {{item.DRXM2}} </td>   
                                        <td style="text-align:center;"> {{item.EM2}} </td>    
                                        <td style="text-align:center;" :class="{maxRxMensual : (item.DOM3 > max_rx_mensual)}"> {{item.DOM3}} </td>
                                        <td style="text-align:center;" :class="{maxRxMensual : (item.DRXM3 > max_rx_mensual)}"> {{item.DRXM3}} </td>     
                                        <td style="text-align:center;"> {{item.EM3}} </td>
                                        <td style="text-align:center;" :class="{maxRxMensual : (item.DOM4 > max_rx_mensual)}"> {{item.DOM4}} </td>
                                        <td style="text-align:center;" :class="{maxRxMensual : (item.DRXM4 > max_rx_mensual)}"> {{item.DRXM4}} </td>
                                        <td style="text-align:center;"> {{item.EM4}} </td>                                                                                    
                                        <td style="text-align:center;" :class="{maxRxMensual : (item.DOM5 > max_rx_mensual)}"> {{item.DOM5}} </td>
                                        <td style="text-align:center;" :class="{maxRxMensual : (item.DRXM5 > max_rx_mensual)}"> {{item.DRXM5}} </td>
                                        <td style="text-align:center;"> {{item.EM5}} </td>                                                                                    
                                        <td style="text-align:center;" :class="{maxRxMensual : (item.DOM6 > max_rx_mensual)}"> {{item.DOM6}} </td>
                                        <td style="text-align:center;" :class="{maxRxMensual : (item.DRXM6 > max_rx_mensual)}"> {{item.DRXM6}} </td>     
                                        <td style="text-align:center;"> {{item.EM6}} </td>                                                                               
                                        <td style="text-align:center;" :class="{maxRxMensual : (item.DOM7 > max_rx_mensual)}"> {{item.DOM7}} </td>
                                        <td style="text-align:center;" :class="{maxRxMensual : (item.DRXM7 > max_rx_mensual)}"> {{item.DRXM7}} </td>    
                                        <td style="text-align:center;"> {{item.EM7}} </td>                                                                                
                                        <td style="text-align:center;" :class="{maxRxMensual : (item.DOM8 > max_rx_mensual)}"> {{item.DOM8}} </td>
                                        <td style="text-align:center;" :class="{maxRxMensual : (item.DRXM8 > max_rx_mensual)}"> {{item.DRXM8}} </td>    
                                        <td style="text-align:center;"> {{item.EM8}} </td>                                                                                
                                        <td style="text-align:center;" :class="{maxRxMensual : (item.DOM9 > max_rx_mensual)}"> {{item.DOM9}} </td>
                                        <td style="text-align:center;" :class="{maxRxMensual : (item.DRXM9 > max_rx_mensual)}"> {{item.DRXM9}} </td>   
                                        <td style="text-align:center;"> {{item.EM9}} </td>                                                                                 
                                        <td style="text-align:center;" :class="{maxRxMensual : (item.DOM10 > max_rx_mensual)}"> {{item.DOM10}} </td>
                                        <td style="text-align:center;" :class="{maxRxMensual : (item.DRXM10 > max_rx_mensual)}"> {{item.DRXM10}} </td>                                                                                    
                                        <td style="text-align:center;"> {{item.EM10}} </td>
                                        <td style="text-align:center;" :class="{maxRxMensual : (item.DOM11 > max_rx_mensual)}"> {{item.DOM11}} </td>
                                        <td style="text-align:center;" :class="{maxRxMensual : (item.DRXM11 > max_rx_mensual)}"> {{item.DRXM11}} </td>                                                                                    
                                        <td style="text-align:center;"> {{item.EM11}} </td>
                                        <td style="text-align:center;" :class="{maxRxMensual : (item.DOM12 > max_rx_mensual)}"> {{item.DOM12}} </td>
                                        <td style="text-align:center;" :class="{maxRxMensual : (item.DRXM12 > max_rx_mensual)}"> {{item.DRXM12}} </td>                                                                                    
                                        <td style="text-align:center;"> {{item.EM12}} </td>
                                                                                 
                                    </tr>                       
                                    
                                </tbody>
                            </table>                     
                       </div>
                </div>
             </div>
            <div class="clearfix"></div>    
        </div>
        <a class="btn btn-primary" v-on:click="submit()" >Actualizar</a> 
      </div>
    </div>
</template>

<script>
import {mapState} from 'vuex'

export default {

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
       }

    },
 
 methods : {

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
</style>