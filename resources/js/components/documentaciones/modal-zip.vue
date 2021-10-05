<template>
    <div>
    <div class="modal fade" tabindex="-1" role="dialog" id="modalZip" data-keyboard="false" data-backdrop="static" >
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="control-label" style="font-size: 17px;" for="inputSuccess"><i class="fa fa-file-zip-o" style="color: red;"></i>   Documentación OT N° : {{ ot.numero }}</label>
                </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12" style="position: relative;">
                    <button type="button"
                        style="  position: absolute;top: 5px; right: 20px;"
                        class="btn btn-success btn-xs"
                        v-clipboard:copy="mensaje"
                    >Copiar
                    </button>
                     <textarea rows="9" v-model="mensaje" disabled class="form-control" style="width: 100%;height: 100%;box-sizing: border-box; " type="text" ></textarea>
                </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
    </div>
    </div>
</template>
<script>
  import moment from 'moment';
  export default {
      data() { return {
          path: '',
          ot: {},
          fecha_actual: moment(new Date()).format('DD-MM-YYYY'),
      }},
    computed :{
        mensaje : function() {
            return  '\n La documentación de la orden de trabajo ' + this.ot.proyecto + '( N°: ' + this.ot.numero + ') se encuenta disponible en el siguiente link de descarga...' + '\n \n' + this.path + '\n \n \n \n' + '* El link de descarga caducará en 72 horas.'
        }
    },
    methods: {
      setForm (ot,path) {
        this.$nextTick(() => {
            this.path = path;
            this.ot = ot;
            $('#modalZip').modal('show');
        })
      },
    },
  }
</script>

