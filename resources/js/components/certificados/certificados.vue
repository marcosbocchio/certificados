<template>
<div class="col-md-6">
  <div class="box box-primary">
      <div class="box-body">
          <div class="form-group">
            <label for="proyecto">Proyecto</label>
            <input type="text" class="form-control" id="proyecto" placeholder="Nombre proyecto">
          </div>
          <div class="form-group">
                <label>Cliente</label>
                 <v-select label="nombre_fantasia" :options="clientes" ></v-select>
               
            </div>
        
        <!-- /.box-body -->

        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
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
