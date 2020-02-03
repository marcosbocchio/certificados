<template>
    <div>
         <div class="col-md-12">
          <!-- small box -->
          <div class="small-box bg-custom-1">
            <div class="inner">
              <h3>{{users_ot_operarios.length}}</h3>

              <p>Operadores</p>
            </div>
            <div class="icon">
                 <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">Detail <i class="fa  fa-arrow-circle-down"></i></a>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12">
            <div class="box box-custom-enod">
                <div class="box-body">  
                    <div class="form-group">
                        <label>Operadores</label>
                        <v-select v-model="usuario" label="name" :options="operadores" ></v-select>
                    </div> 
                    <div class="form-group">                    
                        <span>
                            <button type="button" @click="addOperario(usuario.id)"><span class="fa fa-plus-circle"></span></button>                            
                        </span>
                    </div>
                 </div>
            </div>

                <div class="box box-info top-buffer">
                    <div class="box-header with-border">
                    <h3 class="box-title">Operarios Asignados Orden de Trabajo</h3>

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
                                    <tr v-for="(users_ot_operario,k) in users_ot_operarios" :key="k" @click="selectDoc(users_ot_operario.id)">                                 
                                        <td> {{users_ot_operario.name}}</td>     
                                        <td> {{users_ot_operario.email}}</td>         
                                        <td> <i class="fa fa-minus-circle" @click="removeOperarios(k)" ></i></td>
                                    </tr>                       
                                    
                                </tbody>
                            </table>                     
                       </div>
                    </div> 
                </div> 
                <a class="btn btn-primary" v-on:click.prevent="submit()" >Actualizar</a>      
            </div>
            <div class="clearfix"></div>
            <div class="col-md-12 top-buffer" >
                <div class="box box-danger">
                    <div class="box-header with-border">
                    <h3 class="box-title">Documentación</h3>

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
                </div> 
            </div>    
        <div class="clearfix"></div>
    </div>    
</template>

<script>
import {mapState} from 'vuex'
export default {

   props :{

       ot_operarios_data : {
       type : Array,
       required : false
     },
     
     ot_id_data : '',
    
  },

  data () { return {

      users_ot_operarios :[],
      usuarios:[],
      usuario:{},   
      documentaciones : [],    
    
    }    
  },
  created : function() {
      
      this.$store.dispatch('loadOperadores'); 
      this.users_ot_operarios =  JSON.parse(JSON.stringify(this.ot_operarios_data));  
     
  },
  computed :{

       ...mapState(['url','AppUrl','operadores'])
     },
  methods :{
 
    addOperario : function(id){
      

        if (this.existeOperario(id)){
                toastr.error('El operador ya existe en la OT');  
        }else if(this.usuario.name){
               console.log('agregando operario');
            this.users_ot_operarios.push({ 
                 ...this.usuario
            });
            this.usuario = "";
        }
    },

    removeOperarios: function(index){

         this.users_ot_operarios.splice(index, 1);
         this.documentaciones = [];

    },
    
    existeOperario : function(id){

        let existe = false;
        this.users_ot_operarios.forEach(function (operario) {           
            console.log(operario.id,'==',id);
            if(operario.id == id){              
                existe = true ;
            }
            
        });

        return existe;
    },

    selectDoc : function(id){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'documentaciones/ot_operarios/' + this.ot_id_data + '/' + id + '?api_token=' + Laravel.user.api_token;      
            console.log(urlRegistros);
            axios.get(urlRegistros).then(response =>{
                
                    this.documentaciones = response.data              

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
                console.log(response);                  
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

