<template>
<div>  
  <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ CantOperadores }}</h3>
              <p>Operadores</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a :href="AppUrl + '/operadores/ot/' + ot_id_selected" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

         <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ CantInternoEquipos }}</h3>
              <p>Equipos</p>
            </div>
            <div class="icon">
              <i class="fa fa-wrench"></i>
            </div>
            <a :href="AppUrl + '/interno_equipos/ot/' + ot_id_selected" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ CantProcedimientos }}</h3>

              <p>Procedimientos</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a :href="AppUrl + '/procedimientos/ot/' + ot_id_selected" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- ./col -->       
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ CantDocumentaciones }}</h3>
              <p>Documentaciones</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a :href="AppUrl + '/documentaciones/ot/' + ot_id_selected" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-gray">
            <div class="inner">
              <h3>{{ CantRemitos }}</h3>

              <p>Remitos</p>
            </div>
            <div class="icon">
              <i class="fa fa-tasks"></i>
            </div>
            <a :href="AppUrl + '/remitos/ot/' + ot_id_selected" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
    
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ CantInformes }} </h3>

              <p>Informes</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
              <a :href="AppUrl + '/informes/ot/' + ot_id_selected" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>{{CantPartes}}</h3>

              <p>Partes Diarios</p>
            </div>
            <div class="icon">
              <i class="fa fa-file-pdf-o"></i>
            </div>
            <a :href="AppUrl + '/partes/ot/' + ot_id_selected" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>0</h3>

              <p>Certificados</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
             
    </div>  
        <div class="col-md-12">
            <div class="box box-primary top-buffer">
               <div class="box-body">
                    <div class="table-responsive">          
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th class="col-lg-1">OT N°</th>
                                    <th class="col-lg-3" >CLIENTE</th>    
                                    <th class="col-lg-3">PROYECTO</th>  
                                    <th class="col-lg-1">OBRA N°</th>     
                                    <th class="col-lg-2">FECHA</th>     
                                    <th class="col-lg-1">ESTADO</th>                        
                                    <th class="col-lg-1" colspan="4">ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(ot,k) in ots.data" :key="k" @click="selectOt(k)" :class="{selected: ot_id_selected === ots.data[k].id}" >
                                    <td> {{ot.numero}}</td>     
                                    <td> {{ot.cliente.nombre_fantasia}}</td>         
                                    <td> {{ot.proyecto}}</td>         
                                    <td> {{ot.obra}}</td>         
                                    <td> {{ot.fecha_hora}}</td>         
                                    <td> {{ot.estado}}</td>                                
                                    <td width="10px"> <a :href="AppUrl + '/area/enod/ots/' + ot.id + '/edit' "   class="btn btn-warning btn-sm" title="Editar"><span class="fa fa-edit"></span></a></td>
                                    <td width="10px"> <a :href="AppUrl + '/soldadores/ot/' + ot_id_selected"   class="btn btn-default btn-sm" title="Soldadores/Usuarios Cliente"><span class="fa fa-user"></span></a></td>
                                    <td width="10px"> <a :href="AppUrl + '/api/pdf/ot/' + ot.id " target="_blank"  class="btn btn-default btn-sm" title="Informe"><span class="fa fa-file-pdf-o"></span></a></td>
                                    <td v-if="!ot.firma" width="10px"> <a  @click="firmar(k)"  class="btn btn-default btn-sm" title="Firmar"><span class="glyphicon glyphicon-pencil"></span> </a></td>   
                                    <td v-else> <a class="btn btn-default btn-sm" title="Cerrar"><span class="glyphicon glyphicon-arrow-right"></span></a></td>
                                  
                                </tr>
                        </tbody>
                        </table>
          
                    </div>     
                  
                   <pagination :data="ots" @pagination-change-page="getResults" ><span slot="prev-nav">&lt; Previous</span>
                   <span slot="next-nav">Next &gt;</span> </pagination>
                </div> 
            </div>       
        </div> 
</div>

</template>
<script>

import {mapState} from 'vuex'
export default {  

    data() { return {

        ots :{},       
        ot_id_selected : ''
        }

    },

    computed :{

        ...mapState(['url','AppUrl','CantInformes','CantInternoEquipos','CantOperadores','CantRemitos','CantProcedimientos','CantPartes','CantDocumentaciones'])
        
     },
    
     watch: {
 
      ot_id_selected: function (ot_id) {  
              
        this.$store.dispatch('loadContarOperadores',ot_id);
        this.$store.dispatch('loadContarInternoEquipos',ot_id);
        this.$store.dispatch('loadContarProcedimientos',ot_id);
        this.$store.dispatch('loadContarDocumentaciones',ot_id);
        this.$store.dispatch('loadContarRemitos',ot_id);
        this.$store.dispatch('loadContarInformes',ot_id);
        this.$store.dispatch('loadContarPartes',ot_id);

    }
  },

    mounted : function() {

       this.getResults();
       
    },

    methods : {

        getResults : function(page = 1){

            console.log('entro en getResults : ' + page);
            axios.defaults.baseURL = this.url ;                
            var urlRegistros = 'ots?page='+ page + '&api_token=' + Laravel.user.api_token;      
            console.log(urlRegistros);        
            axios.get(urlRegistros).then(response =>{
            this.ots = response.data    
            console.log('response en getResults');       
            this.ot_id_selected = this.ots.data[0].id;    
            });

       
        },

         selectOt : function(index){

            this.ot_id_selected = this.ots.data[index].id;

         },

         firmar : function(index){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'ots/' + this.ots.data[index].id + '/firmar';                      
                axios.put(urlRegistros).then(response => {
                  console.log(response.data); 
                  this.ots.data[index].firma = response.data.firma;
                  this.getResults(this.ots.current_page);
                  toastr.success('La OT N° '+ response.data.numero +' fue firmada con éxito');                
                  
                }).catch(error => {                   
                    this.errors = error.response.data.errors;
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

<style >



table .selected{

  background-color: rgb(220, 198, 241)!important;

} 
</style>