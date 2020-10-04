<script>
import eventAlerta from '../components/event-bus.js'
import code_messages from '../mixins/code_messages.js'

/* tipo : error, success, warning , info  */
/* codigo : son los predifinidos en el archivo code_messages.js */

export default {

methods : {

    /* Muestra alertas predefinidas según parametro*/
    $showMessagePreset(tipo,codigo){

    let messages = [];
    
    if (typeof code_messages[codigo] != 'undefined'){   

        messages.push(code_messages[codigo])

    }else {

        console.log('El código de error '+ "'" + codigo  +"'" +' no está definido');

    }

    this.$show(tipo,messages)

    },

    /* Recibe un array con los mensajes a mostrar*/
    $showMessages(tipo,messages,title){

       this.$show(tipo,messages,title)

    },

    $show(tipo,messages,title = null){

      messages.forEach(function(message) {
        
        if(title){

             toastr[tipo](message,title);

        }else{

            toastr[tipo](message);
        }

       });

    }
}


}
</script>
