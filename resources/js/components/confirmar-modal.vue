<template>
<div>
    <div class="modal fade" tabindex="-1" role="dialog" id="confirm" data-keyboard="false" data-backdrop="static" >
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="control-label" style="font-size: 17px;" for="inputSuccess"><i class="fa fa-exclamation-triangle" style="color: red;"></i>  Alerta</label>
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
     tipo:'',
    }},

  created : function() {

        eventModal.$on('abrir_confirmar_accion',function(value1,value2,tipo) {
            this.mensaje  = value1;
            this.accion = value2;
            this.tipo = tipo;
            $('#confirm').modal('show');

        }.bind(this));
  },

    methods : {

        aplicar: function(confirmar_sn) {
            eventModal.$emit('confirmar_accion', this.accion, this.tipo); // Ahora pasas 'tipo' también
            $('#confirm').modal('hide');
        }


    }
}
</script>
