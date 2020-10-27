<template>
<div>
    <div class="modal fade" tabindex="-1" role="dialog" id="confirm" data-keyboard="false" data-backdrop="static" >
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h4>Alerta</h4>
                </div>
            <div class="modal-body">
            <p> {{ mensaje }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"  @click="aplicar(true)">Continuar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>

import { eventModal} from '../components/event-bus';
export default {

      data (){return{

     mensaje :'',
     accion:'',
    }},

  created : function() {

        eventModal.$on('abrir_confirmar_accion',function(value1,value2) {
            this.mensaje  = value1;
            this.accion = value2
            $('#confirm').modal('show');

        }.bind(this));
  },

    methods : {

        aplicar: function(confirmar_sn){

              eventModal.$emit('confirmar_accion',this.accion);
             $('#confirm').modal('hide');
        }


    }
}
</script>
