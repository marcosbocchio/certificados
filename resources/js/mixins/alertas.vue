<script>
import eventAlerta from '../components/event-bus.js'
export default {

methods : {

    /* Muestra alertas predefinidas según parametro*/
    $showAlert(codigo){

        switch (codigo) {

            case 'error-500':

                    toastr.error('Ocurrió un error al procesar la solicitud');

                break;

            default:
                break;
        }

    },

    /* Recibe un array con los mensajes a mostrar*/
    $show(messages){

        messages.forEach(function(message) {

            toastr.error(message);
       });

    },
}


}
</script>
