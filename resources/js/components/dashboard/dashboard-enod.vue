<template>
  <div>  
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-custom-1">
          <div class="inner">
            <h3>{{ CantOperadores }}</h3>
            <p>Operadores</p>
          </div>
          <div class="icon">
            <i class="fa ion-person-add"></i>
          </div>
            <a v-if="ot_id_selected > 0 && $can('T_operador_acceder')"  :href="AppUrl + '/operadores/ot/' + ot_id_selected" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            <a v-else href="#" class="small-box-footer" >More info <i class="fa fa-arrow-circle-right"></i></a>   
        </div>
      </div>

        <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-custom-2">
          <div class="inner">
            <h3>{{ CantInternoEquipos }}</h3>
            <p>Equipos</p>
          </div>
          <div class="icon">
            <i class="fa fa-wrench"></i>
          </div>
            <a v-if="ot_id_selected > 0 && $can('T_equipos_acceder')"  :href="AppUrl + '/interno_equipos/ot/' + ot_id_selected" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            <a v-else href="#" class="small-box-footer" >More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-custom-3">
          <div class="inner">
            <h3>{{ CantProcedimientos }}</h3>

            <p>Procedimientos</p>
          </div>
          <div class="icon">
            <i class="fas fa-radiation-alt"></i>
          </div>
              <a v-if="ot_id_selected > 0 && $can('T_proc_acceder')"  :href="AppUrl + '/procedimientos/ot/' + ot_id_selected" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              <a v-else href="#" class="small-box-footer" >More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <!-- ./col -->       
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-custom-4">
          <div class="inner">
            <h3>{{ CantDocumentaciones }}</h3>
            <p>Documentaciones</p>
          </div>
          <div class="icon">
              <i class="fa fa-file-pdf-o"></i>
          </div>
            <a v-if="ot_id_selected > 0 && $can('T_doc_acceder')" :href="AppUrl + '/documentaciones/ot/' + ot_id_selected" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            <a v-else href="#" class="small-box-footer" >More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-custom-5">
          <div class="inner">
            <h3>{{ CantRemitos }}</h3>

            <p>Remitos</p>
          </div>
          <div class="icon">
            <i class="fa fa-clipboard"></i>
          </div>
            <a v-if="ot_id_selected > 0 && $can('T_remitos_acceder')" :href="AppUrl + '/remitos/ot/' + ot_id_selected" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            <a v-else href="#" class="small-box-footer" >More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-custom-6">
          <div class="inner">
            <h3>{{ CantInformes }} </h3>

            <p>Informes</p>
          </div>
          <div class="icon">
              <i class="fa fa-list-alt"></i>
          </div>        
            <a v-if="ot_id_selected > 0 && $can('T_informes_acceder')"  :href="AppUrl + '/informes/ot/' + ot_id_selected" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            <a v-else href="#" class="small-box-footer" >More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-custom-7">
          <div class="inner">
            <h3>{{CantPartes}}</h3>

            <p>Partes Diarios</p>
          </div>
          <div class="icon">
            <i class="fa fa-calendar-o"></i>
          </div>
            <a v-if="ot_id_selected > 0 && $can('T_partes_acceder')"  :href="AppUrl + '/partes/ot/' + ot_id_selected" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            <a v-else href="#" class="small-box-footer" >More info <i class="fa fa-arrow-circle-right"></i></a>          
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-custom-8">
          <div class="inner">
            <h3>{{CantCertificados}}</h3>

            <p>Certificados</p>
          </div>
          <div class="icon">
            <i class="fa fa-check-square-o"></i>
          </div>
            <a v-if="ot_id_selected > 0 && $can('T_certif_acceder')"  :href="AppUrl + '/certificados/ot/' + ot_id_selected" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            <a v-else href="#" class="small-box-footer" >More info <i class="fa fa-arrow-circle-right"></i></a>     
        </div>
      </div>      
  </div> 

  <div class="row"> 
    <div class="col-md-3 col-md-offset-9">
      <div class="form-group"> 
          <div class="input-group">
              <input type="text" v-model="search" class="form-control" placeholder="Buscar...">
              <span class="input-group-addon btn" @click="aplicarFiltro()" style="background-color: #F9CA33;"><i class="fa fa-search"></i></span>
          </div>  
      </div>
    </div>
  </div>
  <div v-if="(ots.data && ots.data.length) || loading">
  <div class="row"> 
    <div class="col-md-12">
        <div class="box box-custom-enod">
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
                                <th class="col-lg-1" colspan="4">
                                 <small style="margin-left: 2px;">Editar</small>
                                 <small style="margin-left: 13px;">Usuarios</small>
                                 <small style="margin-left: 16px;">Informe</small>
                                 <small style="margin-left: 13px;">Acción</small>

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(ot,k) in ots.data" :key="k" @click="selectOt(k)" :class="{selected: ot_id_selected === ots.data[k].id}" >
                                <td> {{ot.numero}}</td>     
                                <td> {{ot.cliente.nombre_fantasia}}</td>         
                                <td> {{ot.proyecto}}</td>         
                                <td> {{ot.obra}}</td>         
                                <td> {{ot.fecha_formateada}}</td>         
                                <td> {{ot.estado}}</td>   

                                <td width="10px">                                   
                                  <button class="btn btn-warning btn-sm" title="Editar" @click="openEditarOt(ot.id)" :disabled="!$can('T_edita')">
                                    <span class="fa fa-edit">
                                    </span>
                                  </button>                              
                                </td>

                                <td width="10px">                                  
                                  <button class="btn btn-default btn-sm" title="Soldadores/Usuarios Cliente" @click="openUsuariosOt(ot.id)" :disabled="!$can('T_usuarios')">
                                    <span class="fa fa-user">
                                    </span>
                                  </button>                                 
                                </td>

                                <td width="10px"> <a :href="AppUrl + '/api/pdf/ot/' + ot.id " target="_blank"  class="btn btn-default btn-sm" title="Informe"><span class="fa fa-file-pdf-o"></span></a></td>

                                <td v-if="!ot.firma" width="10px"> 
                                  <button class="btn btn-default btn-sm" title="Firmar" @click="firmar(k)" :disabled="!$can('T_accion')">
                                    <span class="glyphicon glyphicon-pencil"></span> 
                                  </button>                                 
                                </td>   
                                <td v-else> <a class="btn btn-default btn-sm" title="Cerrar"><span class="glyphicon glyphicon-arrow-right"></span></a></td>
                              
                            </tr>
                        </tbody>
                    </table>
                </div>     
              
                <pagination :data="ots" @pagination-change-page="getResults" ><span slot="prev-nav">&lt; Previous</span>
                <span slot="next-nav">Next &gt;</span> </pagination>
            </div> 

            <div v-if="loading" class="overlay">
               <loading-spin></loading-spin>
            </div>
          
        </div> 
      </div> 
    </div>
  </div>
    <div class="clearfix"></div>    
</div>

</template>
<script>

import {mapState} from 'vuex'
export default {  

    data() { return {

        ots :{},       
        ot_id_selected : '',
        search:'',
        loading:false,
        }

    },

    computed :{

        ...mapState(['url','AppUrl','CantInformes','CantInternoEquipos','CantOperadores','CantRemitos','CantProcedimientos','CantPartes','CantDocumentaciones','CantCertificados'])
        
     },
    
     watch: {
 
      ot_id_selected: function (ot_id) {  
        
        this.cambiarTituloHeader(ot_id);
        this.$store.dispatch('loadContarOperadores',ot_id);
        this.$store.dispatch('loadContarInternoEquipos',ot_id);
        this.$store.dispatch('loadContarProcedimientos',ot_id);
        this.$store.dispatch('loadContarDocumentaciones',ot_id);
        this.$store.dispatch('loadContarRemitos',ot_id);
        this.$store.dispatch('loadContarInformes',ot_id);
        this.$store.dispatch('loadContarPartes',ot_id);
        this.$store.dispatch('loadContarCertificados',ot_id);

    }
  },

    mounted : function() {

       this.getResults();
       
    },

    methods : {

        cambiarTituloHeader : function(ot_id){          
          
          let numero='';
          let estado='';
          this.ots.data.forEach(function(item){          
            if(item.id == ot_id){
              numero = item.numero;
              estado = item.estado;
            }
          }.bind(this));
          if(numero && estado){
            document.getElementsByClassName('sub-titulo')[0].innerHTML = '/ OT N°: ' + numero + ' / ESTADO: ' + estado;
          }
        },

        aplicarFiltro : function(){

          console.log(this.search);
          this.getResults(1,this.search);

        },

        getResults : function(page = 1,filtro =''){

            this.loading = true;
            axios.defaults.baseURL = this.url ;                
            var urlRegistros = 'ots?page='+ page + '&search=' + filtro + '&api_token=' + Laravel.user.api_token;      
            console.log(urlRegistros);        
            axios.get(urlRegistros).then(response =>{

              console.log(response.data);  
              this.ots = response.data   
              console.log(this.ots.length);
              if(this.ots.data.length){
                
                this.ot_id_selected = this.ots.data[0].id; 

              }else{
                this.ot_id_selected = -1;

              }              

            }).finally(() => this.loading = false)
           
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

        },
      
      openEditarOt: function(id){

        window.location.href = this.AppUrl + '/area/enod/ots/' + id + '/edit';

      },

      openUsuariosOt: function(id){

        window.location.href = this.AppUrl + '/soldadores/ot/' + id;

      }


    }
}
    

</script>

<style >





</style>