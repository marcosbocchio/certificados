<template>
    <div class="row">
         <div class="col-md-12">
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
        </div>

        <div class="clearfix"></div>

        <div class="col-md-12">
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
                                        <th class="col-md-2">N° SERIE</th>     
                                        <th class="col-md-2">N° INT.</th> 
                                        <th class="col-md-3">EQUIPO</th>    
                                        <!--
                                            <th class="col-md-4">FUENTE</th>                                                  
                                        -->
                                        <th class="col-md-1">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(interno_equipo,k) in interno_equipos" :key="k" class="pointer" :class="{selected: index_equipo == k}"> 
                                                    
                                        <td @click="selectEquipo(k)" > {{interno_equipo.nro_serie}}</td>    
                                        <td @click="selectEquipo(k)"> {{interno_equipo.nro_interno}}</td> 
                                        <td @click="selectEquipo(k)"> {{interno_equipo.equipo.codigo}}</td>
                                            <!--
                                            <td v-if="interno_equipo.interno_fuente"> {{interno_equipo.interno_fuente.nro_serie}} / {{interno_equipo.interno_fuente.fuente.codigo}}</td>
                                            <td v-else>&nbsp;</td>
                                        -->
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
        </div> 

        <div class="clearfix"></div>

        <div class="col-md-12">
 
            <div class="box box-custom-enod top-buffer">
                <div class="box-header with-border">
                <h3 class="box-title">DOCUMENTACIONES DEL EQUIPO</h3>

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
                                    <th class="col-md-2">TÍTULO</th>                                                     
                                    <th class="col-md-9">DESCRIPCIÓN</th>
                                     <th class="col-md-1">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item,k) in TablaInternoEquipoDoc" :key="k">                                 
                                    <td> {{item.titulo}}</td>     
                                    <td> {{item.descripcion}}</td>     
                                    <td width="10px"> <a :href="AppUrl + '/' + item.path " target="_blank" title="Imagen"><span class="fa fa-file-image-o"></span></a></td>
                                </tr>                                     
                            </tbody>
                        </table>                     
                    </div>
                </div> 
                <div v-if="isLoadingIED" class="overlay">
                    <loading-spin></loading-spin>
                </div>
            </div> 
        </div>   

        <div class="col-md-12">
 
            <div class="box box-custom-enod top-buffer">
                <div class="box-header with-border">
                <h3 class="box-title">DOCUMENTACIONES DE LA FUENTE </h3>

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
                                    <th class="col-md-1">N° SERIE</th>   
                                    <th class="col-md-2">FUENTE</th> 
                                    <th class="col-md-2">TÍTULO</th>                                                     
                                    <th class="col-md-6">DESCRIPCIÓN</th>
                                    <th class="col-md-1">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item,k) in TablaInternoFuenteDoc" :key="k">   
                                    <td> {{item.nro_serie}} </td>     
                                    <td> {{item.codigo}} </td>                                   
                                    <td> {{item.titulo}} </td>     
                                    <td> {{item.descripcion}}  </td>     
                                    <td width="10px"> <a :href="AppUrl + '/' + item.path " target="_blank" title="Imagen"><span class="fa fa-file-image-o"></span></a></td>
                                </tr>                                     
                            </tbody>
                        </table>                     
                    </div>
                </div> 
            <div v-if="isLoadingIFD" class="overlay">
                <loading-spin></loading-spin>
            </div>
            </div> 
        </div>   

    </div>
</template>
<script>
import {mapState} from 'vuex';
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
    documentaciones_equipos : [],
    TablaInternoEquipoDoc : [],
    TablaInternoFuenteDoc: [],
    index_equipo : '-1' ,
    isLoadingIED : false ,
    isLoadingIFD : false ,
}},

 computed :{

       ...mapState(['url','AppUrl'])
    },

 created : function(){

   this.interno_equipos =  JSON.parse(JSON.stringify(this.interno_equipos_data));  


 },

 methods :{

    selectEquipo: function(k){

        this.index_equipo = k;
        this.getInternoEquipoDoc(k);
        this.getInternoFuentesDoc(k);

    },


    getInternoEquipoDoc :  function(k){

        this.isLoadingIED  = true;
        let id = this.interno_equipos[k].id;
        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'documentaciones/interno_equipo/' + id + '?api_token=' + Laravel.user.api_token;      
        axios.get(urlRegistros).then(response =>{

            this.TablaInternoEquipoDoc = response.data   

        }).catch(() => 

           toastr.error("Ocurrio un error al procesar la solicitud") 

        ).finally(() => 
            
            this.isLoadingIED = false,   

        );  

    },

    getInternoFuentesDoc : function(k){

        this.isLoadingIFD  = true;
        let id = this.interno_equipos[k].id;
        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'documentaciones/ot/' + this.ot_id_data + '/interno_equipo/' + id + '/fuentes_documentaciones' + '?api_token=' + Laravel.user.api_token;      
        axios.get(urlRegistros).then(response =>{

                this.TablaInternoFuenteDoc = response.data     

        }).catch(() => 

                toastr.error("Ocurrio un error al procesar la solicitud") 

        ).finally(() => 
        
        this.isLoadingIFD = false,   
                        
    );
    },

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