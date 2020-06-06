<template>
    <div>       
        <div class="col-md-12">
          <!-- small box -->
          <div class="small-box bg-custom-1">
            <div class="inner">
              <h3>{{users_ot_operarios.length}}</h3>
              <p>Operadores / Ayudantes</p>
            </div>
            <div class="icon">
                 <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">Detail <i class="fa  fa-arrow-circle-down"></i></a>
          </div>
       </div> 
       <div class="clearfix"></div>
      <div class="col-md-6">
        <div v-show="$can('T_operador_actualiza')">
            <div class="box box-custom-enod">
                <div class="box-body">  
                    <div class="form-group">
                        <label>Operador</label>
                        <v-select v-model="operador" label="name" :options="operadores" ></v-select>
                    </div> 
                    <div class="form-group">                    
                        <span>
                            <button type="button" @click="addOperario(operador.id,'operador')"><span class="fa fa-plus-circle"></span></button>                            
                        </span>
                    </div>
                 </div>
            </div>
        </div>
      </div>
      <div class="col-md-6">
        <div v-show="$can('T_operador_actualiza')">
            <div class="box box-custom-enod">
                <div class="box-body">  
                    <div class="form-group">
                        <label>Ayudante</label>
                        <v-select v-model="ayudante" label="name" :options="operadores" ></v-select>
                    </div> 
                    <div class="form-group">                    
                        <span>
                            <button type="button" @click="addOperario(ayudante.id,'ayudante')"><span class="fa fa-plus-circle"></span></button>                            
                        </span>
                    </div>
                 </div>
            </div>
        </div>
      </div>

    <div class="col-md-6">
        <div class="box box-custom-enod top-buffer">
            <div class="box-header with-border">
            <h3 class="box-title">OPERADORES ASIGNADOS A LA ORDEN DE TRABAJO</h3>

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
                                <th>NOMBRE</th>
                                <th>EMAIL</th>                                                     
                                <th colspan="2">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(users_ot_operario,k) in users_ot_operarios" :key="k" :class="{selected: index == k}" class="pointer">                                 
                                <td v-if="users_ot_operario.ayudante_sn == 0" @click="selectDoc(k)"> {{users_ot_operario.name}}</td>     
                                <td v-if="users_ot_operario.ayudante_sn == 0" @click="selectDoc(k)"> {{users_ot_operario.email}}</td>         
                                <td v-if="users_ot_operario.ayudante_sn == 0"> <i class="fa fa-minus-circle" @click="removeOperarios(k)" ></i></td>
                            </tr>                       
                            
                        </tbody>
                    </table>                     
                </div>
            </div> 
        </div> 
    </div>
    <div class="col-md-6">
        <div class="box box-custom-enod top-buffer">
            <div class="box-header with-border">
            <h3 class="box-title">AYUDANTES ASIGNADOS A LA ORDEN DE TRABAJO</h3>

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
                                <th>NOMBRE</th>
                                <th>EMAIL</th>                                                     
                                <th colspan="2">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(users_ot_ayudante,k) in users_ot_operarios" :key="k" :class="{selected: index == k}" class="pointer">                                 
                                <td v-if="users_ot_ayudante.ayudante_sn == 1" @click="selectDoc(k)"> {{users_ot_ayudante.name}}</td>     
                                <td v-if="users_ot_ayudante.ayudante_sn == 1" @click="selectDoc(k)"> {{users_ot_ayudante.email}}</td>         
                                <td v-if="users_ot_ayudante.ayudante_sn == 1"> <i class="fa fa-minus-circle" @click="removeOperarios(k)" ></i></td>
                            </tr>                       
                            
                        </tbody>
                    </table>                     
                </div>
            </div> 
        </div> 
    </div>
    <div class="col-md-12">
            <div v-show="$can('T_operador_actualiza')">
                <button class="btn btn-primary" v-on:click.prevent="submit()">Actualizar</button>               
            </div>

    </div>
   <div class="clearfix"></div>
     <div class="col-md-12">
            <div class="top-buffer" >
                <div class="box box-custom-enod">
                    <div class="box-header with-border">
                    <h3 class="box-title">DOCUMENTACIÓN</h3>

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
                                        <th>TÍTULO</th>     
                                        <th>DESCRIPCIÓN</th>                                                       
                                        <th colspan="2">PDF</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(documentacion,k) in documentaciones" :key="k"> 
                                                    
                                        <td> {{documentacion.titulo}}</td>    
                                        <td> {{documentacion.descripcion}}</td> 
                                        <td width="10px"> <a :href="AppUrl + '/documentaciones/operador/' + documentacion.id" target="_blank" class="btn btn-default btn-sm" title="pdf"><span class="fa fa-file-pdf-o"></span></a></td>
                                                 
                                    </tr>                       
                                    
                                </tbody>
                            </table>                     
                       </div>
                    </div> 
                      <div v-if="loading" class="overlay">
                        <loading-spin></loading-spin>
                    </div>
                </div> 
            </div>

     </div>      
        <div class="clearfix"></div>
    </div>    
</template>

<script>
import {mapState} from 'vuex'
import { mapMutations } from 'vuex';

export default {

   props :{

       ot_operarios_data : {
       type : Array,
       required : false
     },
     
     ot_id_data : {
         type : Number,
         required:true
     },
  },

  data () { return {
      
      users_ot_operarios :[],
      usuarios:[],
      operador : '',
      ayudante : '',
      index :'-1',
      documentaciones : []
    
    }    
  },

  created : function() {
      
      this.$store.dispatch('loadOperadores'); 
      this.users_ot_operarios =  JSON.parse(JSON.stringify(this.ot_operarios_data));  
     
  },
  computed :{

       ...mapState(['url','AppUrl','operadores','loading'])
     },
  methods :{
 
    addOperario : function(id,tipo){
      

        if (this.existeOperario(id)){
                toastr.error('El operador / ayudante ya existe en la OT');  
        }else if(this.operador || this.ayudante) {        

            if(tipo == 'ayudante'){

                this.users_ot_operarios.push({ 

                    ...this.ayudante,
                    'ayudante_sn' : 1,

                });
                this.ayudante = "";

            }else {

                this.users_ot_operarios.push({ 

                    ...this.operador,
                    'ayudante_sn' : 0,

                });

                this.operador = '';
            }
        }
    },

    removeOperarios: function(index){

         this.users_ot_operarios.splice(index, 1);
         this.documentaciones = [];
         this.index = -1;

    },
    
    existeOperario : function(id){

        let existe = false;
        this.users_ot_operarios.forEach(function (operario) {   

            if(operario.id == id){              
                existe = true ;
            }
            
        });

        return existe;
    },

    selectDoc : function(k){

        this.index = k ;
        let id = this.users_ot_operarios[k].id ;
        this.$store.commit('loading', true);
        this.user_ot_operario_id = id;    
        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'documentaciones/ot_operarios/' + this.ot_id_data + '/' + id + '?api_token=' + Laravel.user.api_token;      

        axios.get(urlRegistros).then(response =>{
            
                this.documentaciones = response.data              
                this.$store.commit('loading', false);
            });     
    },

    submit :function () {
       

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'ot_operarios';  
                        
            axios.post(urlRegistros, {   
                
            operarios : this.users_ot_operarios,
            ot_id : this.ot_id_data                

            }).then(response => {            
                this.errors=[];     
                toastr.success('Operarios actualizados con éxito');                
                
            }).catch(error => {
               
                this.errors = error.response.data.errors;                 
                $.each( this.errors, function( key, value ) {
                    toastr.error(value,key);
                    console.log( key + ": " + value );
                });
                
                if(this.errors = [] && error){

                     toastr.error("Ocurrio un error al procesar la solicitud");                     
                     this.users_ot_operarios = this.ot_operarios_data;   
                }
  
            });
        }
    }   
}
</script>

