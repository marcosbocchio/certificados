<template>
<div class="col-md-12">
  <div class="box box-primary">
    <form role="form">
      <div class="box-body">

        <div class="col-md-6">
            <div class="form-group">
              <label for="proyecto">Proyecto</label>
              <input type="text" class="form-control" id="proyecto" placeholder="Nombre">
            </div>
            <div class="form-group">
                  <label>Cliente</label>
                  <v-select label="nombre_fantasia" :options="clientes" ></v-select>
                
              </div>
          
          <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="fecha">Fecha/Hora</label>
              <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker">
              </div>
          </div>
          <div class="form-group">
            <label for="ot">OT Nº</label>
            <input type="text" class="form-control" id="ot" placeholder="Número OT">
          </div>
          
        </div>
      </div>
      </form>
    </div>
  </div>

</template>

<script>
import {mapState} from 'vuex'


export default {
    
    data() { return {

          clientes:[],
          options: [
              'foo',
              'bar',
              'baz'
            ]

          }
    },
    created : function(){

        this.getRegistros();

      },
      computed :{

        ...mapState(['url'])
     },

    methods :{

      getRegistros : function(){

                axios.defaults.baseURL = this.url ;
                var urlRegistros = 'clientes';    
                axios.get(urlRegistros).then(response =>{
                this.clientes = response.data
                });
              },

    }
}
</script>
