<template>
  <div class="col-md-12">
    <div class="box box-custom-enod">
        <div class="box-header with-border">
        <h3 class="box-title">PROCEDIMIENTOS CLIENTES</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>                       
            </div>
        </div>

        <div class="box-body">
            <div class="col-md-2">                      
                <div class="form-group" >
                    <label for="tipo_soldaduras">Tipo Sol.</label>
                    <v-select v-model="tipo_soldadura" label="codigo" :options="tipo_soldaduras"></v-select>
                </div>
            </div>   
            <div class="col-md-3">
                <div class="form-group" >
                    <label for="procedimientos_soldadura">Proc. Soldadura (EPS)*</label>
                    <input type="text" v-model="eps" class="form-control" id="procedimientos_soldadura" maxlength="30">
                </div>                            
            </div>  

            <div class="col-md-3">                       
                <div class="form-group" >
                    <label for="pqr">PQR</label>
                    <input type="text" v-model="pqr" class="form-control" id="pqr" maxlength="30">
                </div>         
            </div> 
            <div class="col-md-1"> 
                <div class="form-group">  
                        <p>&nbsp;</p>                  
                    <span>
                        <button type="button" @click="addTipoSoldaduras()"><span class="fa fa-plus-circle"></span></button>                        
                    </span>
                </div>
            </div>   
        </div>
    </div>
    <div v-show="TablaTipoSoldaduras.length">      
        <div class="box box-custom-enod">
            <div class="box-header with-border">
                <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                    <tr>
                        <th  class="col-md-2">TIPO SOL.</th>
                        <th class="col-md-5">EPS</th>
                        <th class="col-md-5">PQR</th>                   
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item,k) in TablaTipoSoldaduras" :key="k">           
                        <td>{{ item.tipo_soldadura.codigo}} </td>     
                        <td>{{ item.eps}} </td>
                        <td>{{ item.pqr }}</td>
                        <td style="text-align:center"> <i class="fa fa-minus-circle" @click="removeTipoSoldadura(k)" ></i></td>   
                    </tr>
                    </tbody>
                </table>
                </div>  
            </div>
        </div>    

    <button class="btn btn-primary" v-on:click.prevent="submit()">Actualizar</button>              

    </div>
    

</div>
</template>
<script>
  import {mapState} from 'vuex'
  export default {
   
    props : {

     ot_id_data : {

        type: Number,      
        required: true

       },       
    },

    data() {return {

      tipo_soldaduras: [],
      tipo_soldadura : {},
      TablaTipoSoldaduras : [],
      eps:'',
      pqr :'',
    }
    
    },

    created : function() {

    this.getTipoSoldaduras();
    this.$store.dispatch('loadOtTipoSoldaduras',this.ot_id_data).then(response => {

        this.TablaTipoSoldaduras = this.ot_tipo_soldaduras;

    });

    },

     computed :{

       ...mapState(['url','AppUrl','ot_tipo_soldaduras'])
     },

     methods : {  

     getTipoSoldaduras : function(){

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'tipo_soldaduras' + '?api_token=' + Laravel.user.api_token;        
            axios.get(urlRegistros).then(response =>{

                this.tipo_soldaduras = response.data

            });           
             
        },

    addTipoSoldaduras: function(){

        if(jQuery.isEmptyObject(this.tipo_soldadura)){

            return;
        }

        let index = this.TablaTipoSoldaduras.findIndex(elemento => elemento.tipo_soldadura.id == this.tipo_soldadura.id);

        if(index != -1){

            toastr.error('El tipo soldadura ya existe en la ot'); 
            return;
         }

        this.TablaTipoSoldaduras.push({ 

            tipo_soldadura : this.tipo_soldadura,
            eps:this.eps,
            pqr : this.pqr,
        
            });
        
        this.tipo_soldadura={};
        this.eps = '';
        this.pqr = '';

    },

    removeTipoSoldadura : function(index){

        this.TablaTipoSoldaduras.splice(index, 1);    

    },

    submit :function () {
       

            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'ot_tipo_soldaduras';  
                        
            axios.post(urlRegistros, {   
                
            ot_id: this.ot_id_data,
            tipo_soldaduras : this.TablaTipoSoldaduras,

            }).then(response => {            
                this.errors=[];     
                console.log(response);                  
                toastr.success('Los tipos soldaduras fueron acualizados con éxito');                
                
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

    },

  }
</script>