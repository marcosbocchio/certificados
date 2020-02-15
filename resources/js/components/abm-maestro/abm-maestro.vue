<template>
<div>     <div class="form-group"> 
    <div class="col-md-1 col-xs-3">
      <button class="btn btn-primary" v-on:click.prevent="openNuevoRegistro()" :disabled="!$can(permiso_create)">Nuevo</button>
    </div>
  
      <div class="col-md-3 col-md-offset-6 col-xs-9">
       
            <div class="input-group">
                <input type="text" v-model="search" class="form-control" @input="aplicarFiltro()"  placeholder="Buscar...">
                <span class="input-group-addon"  style="background-color: #F9CA33;"><i class="fa fa-search"></i></span>
            </div>  
        </div>
      </div>     
   
    <div class="clearfix"></div>    

    <div class="col-md-10">
        <component :is= setTablaComponente :registros="registros.data" @confirmarDelete="confirmDeleteRegistro" @editar="editRegistro" :loading="loading"/>               
        <delete-registro :datoDelete="datoDelete" :fillRegistro="fillRegistro" @close-modal="getResults" :modelo="modelo"></delete-registro>  
        <component :is= setNuevoComponente :modelo ="modelo" @store="getResults"/>
        <component :is= setEditarComponente :selectRegistro="selectRegistro" @update="getResults"/>  
        <pagination 
                  :data="registros" @pagination-change-page="getResults" :limit="3" >
                  <span slot="prev-nav">&lt; Previous</span>
                  <span slot="next-nav">Next &gt;</span> 
        </pagination>          
             
    </div> 
    <div class="clearfix"></div>   
</div> 
</template>

<script>
  import {mapState} from 'vuex'
  import { eventNewRegistro, eventEditRegistro } from '../event-bus';
    export default {
      name: 'abm-maestro',
      props : {         
          modelo : {
            type : String,
            required : true,
            default : ''
          },
          permiso_create : {
           type : String,
           required : true
  
          }
      },

      created : function(){

        this.getResults();
  

      }, 

      data () { return {
        fillRegistro: {},
        errors:[],
        registros: {}, 
        datoDelete: '',    
        obj :'',
        registro_id: '',
        registro: {},       
        selectRegistro: {},  
        loading : false,      
   
        }
      },    
      
      watch : {

        modelo : function(){

            this.getResults();
                
        },

    },
      computed :{

         setTablaComponente : function(){

             return 'table-' + this.modelo.substring(0, (this.modelo.indexOf("/") >-1) ? this.modelo.indexOf("/") : this.modelo.length) ;
         },
         setNuevoComponente : function(){

             return 'nuevo-' + this.modelo.substring(0, (this.modelo.indexOf("/") >-1) ? this.modelo.indexOf("/") : this.modelo.length) ;
         },
         setEditarComponente : function(){

             return 'editar-' + this.modelo.substring(0, (this.modelo.indexOf("/") >-1) ? this.modelo.indexOf("/") : this.modelo.length) ;
         },
         
         ...mapState(['url','permissions'])
     },  

      methods: {

           openNuevoRegistro : function(){

             eventNewRegistro.$emit('open',this.modelo);
           }, 

            getResults : function(page = 1){

                console.log('entro en getResult');
                console.log(this.modelo);
                this.loading = true;
                axios.defaults.baseURL = this.url ;
                var urlRegistros = this.modelo + '/paginate' + '?page='+ page;   
                axios.get(urlRegistros).then(response =>{
                this.registros = response.data                       
                }).finally(() => this.loading = false)
              },
            
            editRegistro : function(item){
                console.log('entro en editar principal');              
                this.selectRegistro = item;    
                console.log(item);           
                eventEditRegistro.$emit('editar',this.selectRegistro);                  
                    
            },     
                 
            confirmDeleteRegistro: function(registro,dato){            
              this.fillRegistro.id = registro.id;
              this.datoDelete = dato;             
             $('#delete-registro').modal('show');
          }
      }
    }
</script>

