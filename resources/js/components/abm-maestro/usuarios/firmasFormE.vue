<template>
  <div class="modal fade" id="firmas" role="dialog" style="z-index:99999">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Firmas por informes</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <v-select v-model="metodo" label="metodo" :options="metodos_ensayos"></v-select>
                    </div>
                </div>
                <div v-for="(item,k) in firmasUsuarios" :key="k" class="col-md-12">
                    <div v-if="item.metodo_ensayo_id == metodo.id">
                        <subir-imagen
                            :ruta="ruta"
                            :max_size="max_size"
                            :path_inicial="item.path"
                            :tipos_archivo_soportados ="tipos_archivo_soportados"
                            :mostrar_formatos_soportados="true"
                            @path="item.path = $event"
                        ></subir-imagen>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" @click.prevent="cerrar">Cerrar</button>
        </div>
      </div>

    </div>
  </div>
</template>
<script>
import { eventModal } from '../../event-bus';
import {mapState} from 'vuex'
  export default {
      props: {
          metodos_ensayos: {
            type: Array,
            default: [],
          },
      },
    data() {return {

        ruta: 'firma-digital',
        max_size :1024, //KB
        tipos_archivo_soportados:['jpg','bmp','png'],

        mode: '',
        metodo: {},
        firmasUsuarios: [],

      }
    },
  computed :{
      ...mapState(['url'])
     },
  created: function () {
      eventModal.$on('open', this.openModal)
  },

    methods: {

       openModal (mode, item = null) {

           this.mode = mode
           this.metodo = this.metodos_ensayos[0];
           if (this.mode === 'edit') {
               this.firmasUsuarios = item.firmas_usuarios
               this.completarMetodos(item.id);
           } else {
             this.firmasUsuarios = []
             this.completarMetodos();
             }
           $('#firmas').modal('show');
       },

        completarMetodos:function (user_id = '') {

            this.metodos_ensayos.forEach(function (item) {
                let index = this.firmasUsuarios.findIndex(elem => elem.metodo_ensayo_id == item.id);
                if(index == -1){
                    this.firmasUsuarios.push({
                        path:'',
                        user_id: user_id,
                        metodo_ensayo_id : item.id,
                    })
                }
            }.bind(this))
        },

        cerrar:function(){
            if (this.mode =='edit') {
               console.log(this.mode)
               this.$emit('close-firmas2',this.firmasUsuarios);
           }else{
               this.$emit('close-firmas1',this.firmasUsuarios);
           }
           $('#firmas').modal('hide');
        }
    },
  }
</script>
