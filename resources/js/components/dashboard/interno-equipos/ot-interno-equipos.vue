<template>
    <div>
       
        <!-- small box -->
        <div class="small-box bg-custom-2">
        <div class="inner">
            <h3>{{ interno_equipos.length }}</h3>
            <p>Equipos </p>
        </div>
        <div class="icon">
            <i class="fa fa-wrench"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
       
        <div class="clearfix"></div>
            <div class="top-buffer" >
                <div class="box box-custom-enod">
                    <div class="box-header with-border">
                    <h3 class="box-title">EQUIPOS</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>                       
                    </div>
                    </div>
                    <div class="box-body">                        
                        <div class="table-responsive">          
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>                                     
                                        <th>N° SERIE</th>     
                                        <th>N° INT.</th> 
                                        <th>EQUIPO</th>                                                      
                                        <th colspan="1">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(interno_equipo,k) in interno_equipos" :key="k"> 
                                                    
                                        <td> {{interno_equipo.nro_serie}}</td>    
                                        <td> {{interno_equipo.nro_interno}}</td> 
                                        <td> {{interno_equipo.equipo.codigo}}</td>
                                        <td> <i class="fa fa-minus-circle" @click="removeInternoEquipos(k)" ></i></td>                                                 
                                    </tr>                       
                                    
                                </tbody>
                            </table>                     
                       </div>
                    </div> 
                </div> 

                <div v-show="$can('T_equipos_actualiza')">    
                    <button class="btn btn-primary" v-on:click.prevent="submit()">Actualizar</button>                
                </div>
            </div>  
        <div class="clearfix"></div>
    </div>
</template>
<script>
import {mapState} from 'vuex'
export default {

 props :{

    ot_id_data : {
    type : Number,
    required : false
     },

    interno_equipos_data : {
    type : Array,
    required : false
     },
 },  

data () { return { 

    interno_equipos:[],


}},

 computed :{

       ...mapState(['url','AppUrl'])
    },

 created : function(){

   this.interno_equipos =  JSON.parse(JSON.stringify(this.interno_equipos_data));  


 },

 methods :{

   removeInternoEquipos: function(index){

         this.interno_equipos.splice(index, 1);
        

    },

    submit :function () {
       

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'interno_equipos/ot/' + this.ot_id_data;  
            console.log( urlRegistros);           
            axios.post(urlRegistros, {      

             interno_equipos : this.interno_equipos,
                      

            }).then(response => {            
                this.errors=[];     
                console.log(response);                  
                toastr.success('Equipos actualizados con éxito');                
                
            }).catch(error => {
               
                this.errors = error.response.data.errors;                 
                $.each( this.errors, function( key, value ) {
                    toastr.error(value,key);
                    console.log( key + ": " + value );
                });
                
                if(this.errors = [] && error){

                     toastr.error("Ocurrio un error al procesar la solicitud");                     
                     this.interno_equipos = this.interno_equipos_data;   
                }
  
            });
        }

 }
}
</script>