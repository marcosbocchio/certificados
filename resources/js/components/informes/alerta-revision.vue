
<script>
import { toastrInfo,toastrDefault } from '../toastrConfig';
import {eventAlerta} from '../event-bus';

export default {

methods : {

    created: function () {

        eventAlerta.$on('show',function(alerta) {

            this.MostrarAlerta(alerta);

        }.bind(this));

    },

    MostrarAlerta(alerta){

        switch (alerta) {

            case 'revision':

                    toastr.error('El informe está firmado, la modificación generará una nueva revisión');

                break;

            default:
                break;
        }

    },
}


}
</script>
