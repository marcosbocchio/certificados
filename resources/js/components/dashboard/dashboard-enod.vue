<template>
<div>  
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>150</h3>

              <p>Operarios</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-gray">
            <div class="inner">
              <h3>53<sup style="font-size: 20px">%</sup></h3>

              <p>Remitos</p>
            </div>
            <div class="icon">
              <i class="fa fa-tasks"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>44</h3>

              <p>Procedimientos</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>65</h3>

              <p>Requerimientos</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>65</h3>

              <p>Informes/Partes</p>
            </div>
            <div class="icon">
              <i class="fa fa-file-pdf-o"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>65</h3>

              <p>Certificados</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
    
  
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
                                <tr v-for="ot in ots" :key="ot.id">
                                    <td> {{ot.numero}}</td>     
                                    <td> {{ot.obra}}</td>         
                                    <td> {{ot.cliente.nombre_fantasia}}</td>         
                                    <td> {{ot.proyecto}}</td>         
                                    <td> {{ot.fecha_hora}}</td>         
                                    <td> {{ot.estado}}</td>                                
                                    <td> <a :href="AppUrl + '/area/enod/ots/' + ot.id + '/edit' "   class="btn btn-warning btn-sm" title="Editar"><span class="fa fa-edit"></span></a></td>
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

        ots :[]

        }

    },

    computed :{

        ...mapState(['url','AppUrl'])
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
            });

        }


    }
}
    

</script>

