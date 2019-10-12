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
              <h3>{{ CantSoldadores }} / {{ CantUsuariosCliente }}</h3>
              <p>Soldadores / Usuarios Cliente</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a :href="AppUrl + '/soldadores/ot/' + ot_id_selected" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
                                    <th>OT N°</th>
                                    <th>OBRA N°</th>     
                                    <th>CLIENTE</th>    
                                    <th>PROYECTO</th>  
                                    <th>FECHA</th>     
                                    <th>ESTADO</th>                        
                                    <th colspan="2">ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="ot in ots" :key="ot.id" @click="selectOt(ot.id)" :class="{selected: ot_id_selected === ot.id}" >
                                    <td> {{ot.numero}}</td>     
                                    <td> {{ot.obra}}</td>         
                                    <td> {{ot.cliente.nombre_fantasia}}</td>         
                                    <td> {{ot.proyecto}}</td>         
                                    <td> {{ot.fecha_hora}}</td>         
                                    <td> {{ot.estado}}</td>                                
                                            
                                    <td width="10px"> <a :href="AppUrl + '/area/enod/ots/' + ot.id + '/edit' "   class="btn btn-warning btn-sm" title="Editar"><span class="fa fa-edit"></span></a></td>
                                    <td width="10px"> <a :href="AppUrl + '/api/pdf/ot/' + ot.id " target="_blank"  class="btn btn-default btn-sm" title="pdf"><span class="fa fa-file-pdf-o"></span></a></td>
                                </tr>
                        </tbody>
                        </table>
                    </div>       
                </div> 
            </div>       
        </div> 
    
</div>

</template>
<script>

import {mapState} from 'vuex'
export default {

    data() { return {

        ots :[],
        ot_id_selected : '',
        CantOperadores :'0',
        CantInformes:'0',
        CantRemitos:'0',
        CantPartes:'0',
        CantSoldadores:'0',
        CantDocumentaciones:'0',
        CantProcedimientos:'0',
        CantUsuariosCliente:'0',

        }

    },

    computed :{

        ...mapState(['url','AppUrl'])
        
     },
    
     watch: {
 
      ot_id_selected: function (ContarOperadores) {      
      this.ContarOperadores();
      this.ContarSoldadores();
      this.ContarUsuariosCliente();
      this.ContarProcedimietos();
      this.ContarDocumenaciones();
      this.ContarRemitos();
      this.ContarInformes();
      this.ContarPartes();

    }
  },

    created : function() {

       this.getOts();
       
    },

    methods : {

        getOts : function(){

            axios.defaults.baseURL = this.url ;                
            var urlRegistros = 'ots' + '?api_token=' + Laravel.user.api_token;             
            axios.get(urlRegistros).then(response =>{
            this.ots = response.data
            this.ot_id_selected = this.ots[0].id;    
            });

       
        },

         selectOt : function(id){

            this.ot_id_selected = id;

         },

         ContarOperadores : function (){

            axios.defaults.baseURL = this.url ;                
            var urlRegistros = 'ot_operarios/users/' + this.ot_id_selected +'/total' + '?api_token=' + Laravel.user.api_token;             
            axios.get(urlRegistros).then(response =>{
            this.CantOperadores = response.data
            });

         },

         ContarSoldadores : function (){

            axios.defaults.baseURL = this.url ;                
            var urlRegistros = 'ot_soldadores/ot/' + this.ot_id_selected +'/total' + '?api_token=' + Laravel.user.api_token;             
            axios.get(urlRegistros).then(response =>{
            this.CantSoldadores = response.data
            });

         },

         ContarUsuariosCliente : function (){

            axios.defaults.baseURL = this.url ;                
            var urlRegistros = 'ot_usuarios_clientes/ot/' + this.ot_id_selected +'/total' + '?api_token=' + Laravel.user.api_token;             
            axios.get(urlRegistros).then(response =>{
            this.CantUsuariosCliente = response.data
            });

            },

         ContarProcedimietos : function (){

            axios.defaults.baseURL = this.url ;                
            var urlRegistros = 'ot_procedimientos_propios/ot/' + this.ot_id_selected +'/total' + '?api_token=' + Laravel.user.api_token;             
            axios.get(urlRegistros).then(response =>{
            this.CantProcedimientos = response.data
            });

         },
         ContarInformes : function() {

           axios.defaults.baseURL = this.url ;                
            var urlRegistros = 'informes/ot/' + this.ot_id_selected +'/total' + '?api_token=' + Laravel.user.api_token;             
            axios.get(urlRegistros).then(response =>{
            this.CantInformes = response.data
            });

         },
         ContarRemitos : function (){

            axios.defaults.baseURL = this.url ;                
            var urlRegistros = 'remitos/ot/' + this.ot_id_selected +'/total' + '?api_token=' + Laravel.user.api_token;             
            axios.get(urlRegistros).then(response =>{
            this.CantRemitos = response.data
            });

         },
         
         ContarPartes : function (){

            axios.defaults.baseURL = this.url ;                
            var urlRegistros = 'partes/ot/' + this.ot_id_selected +'/total' + '?api_token=' + Laravel.user.api_token;             
            axios.get(urlRegistros).then(response =>{
            this.CantPartes = response.data
            });

         }, 
         
         ContarDocumenaciones: function(){

            axios.defaults.baseURL = this.url ;                
            var urlRegistros = 'ot-documentaciones/ot/' + this.ot_id_selected +'/total' + '?api_token=' + Laravel.user.api_token;             
            axios.get(urlRegistros).then(response =>{
            this.CantDocumentaciones = response.data
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