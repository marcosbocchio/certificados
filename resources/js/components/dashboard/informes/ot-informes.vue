<template>
    <div>
        <div class="col-md-12">
            <!-- small box -->
            <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ot_informes.length}}</h3>

                <p>Informes</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">Detail <i class="fa  fa-arrow-circle-down"></i></a>
            </div>
        </div>  
        <div class="clearfix"></div>
        <div class="col-md-12">
            <div class="box box-danger top-buffer">
                <div class="box-header with-border">
                    <h3 class="box-title">Agregar Informe</h3>
              
                    <div class="box-body">  
                        <div class="form-group">
                            <label>Tipo</label>
                          <v-select v-model="metodo_ensayo" label="metodo" :options="ot_metodos_ensayos_data" ></v-select> 
                        </div> 
                        <div class="form-group">                    
                            <span>
                                <a :href="AppUrl + '/area/enod/ot/' + ot_id_data + '/informe/metodo/' + metodo_ensayo.metodo + '/create' " ><button class="btn btn-primary" :disabled="!metodo_selected">Nuevo</button></a>                              
                            </span>
                        </div>
                    </div>
                 </div>
            </div>
            <div class="box box-info top-buffer">
                <div class="box-header with-border">
                    <h3 class="box-title">Informes Orden de Trabajo</h3>

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
                                    <th>TIPO</th>   
                                    <th>N°</th>
                                    <th>USUARIO ALTA</th> 
                                    <th>FECHA</th>                                                  
                                    <th colspan="2">ACCIÓN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(ot_informe,k) in ot_informes" :key="k">                                 
                                    <td> {{ot_informe.metodo}}</td>
                                    <td>
                                        <div v-if="ot_informe.prefijo != null">
                                             {{ot_informe.prefijo}}-{{ot_informe.numero_formateado}}
                                        </div>
                                        <div v-else>
                                             {{ot_informe.numero_formateado}}       
                                        </div>
                                        
                                    </td>     
                                    <td> {{ot_informe.name}}</td>     
                                    <td> {{ot_informe.fecha}}</td>              
                                    <td width="10px"> <a :href="AppUrl + '/area/enod/ot/' + ot_id_data + '/informe/' + ot_informe.id +'/edit' "   class="btn btn-warning btn-sm" title="Editar"><span class="fa fa-edit"></span></a></td>
                                    <td width="10px"> <a :href="AppUrl + '/api/pdf/informe/' + ot_informe.id " target="_blank"  class="btn btn-default btn-sm" title="pdf"><span class="fa fa-file-pdf-o"></span></a></td>                                    
                                    <td v-if="!ot_informe.firma" width="10px"> <a  @click="firmar(k)"  class="btn btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span> </a></td>   

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

    props :{
    ot_metodos_ensayos_data: {
    type : Array,
    required : false
    },    
    
    ot_informes_data : {
    type : Array,
    required : false
    },

    ot_id_data : '',
    
  },

    data () { return {

      ot_informes :[],
      metodo_ensayo:'',  
      metodo_selected:false
    
    }    
  },

  watch :{

      metodo_ensayo : function(val){

          if (val == null)
            this.metodo_ensayo = '';
          else  
          this.metodo_selected = val == '' ? false : true
      }
  },

  created : function() {

      this.ot_informes =  JSON.parse(JSON.stringify(this.ot_informes_data)); 
  },
  computed :{

       ...mapState(['url','AppUrl'])
     },  

    methods : {

        firmar : function(index){

            axios.defaults.baseURL = this.url ;
                var urlRegistros = 'informes/' + this.ot_informes[index].id + '/firmar';                      
                axios.put(urlRegistros).then(response => {
                  console.log(response.data); 
                  this.ot_informes[index].firma = response.data.firma;    
                  toastr.success('El reporte fue firmado con éxito');                
                  
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
    },
    
}
</script>