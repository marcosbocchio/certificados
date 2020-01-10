<template>
   
    <div class="modal fade"  id="periodos">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">                   
                    <h4 class="modal-title">Periodos</h4>
                </div>
                <div class="modal-body">    
                
                    <label> Acá va la tabla con las altas y bajas</label>                   
                 
                </div>            
   
            </div>
        </div>
    </div>

</template>

<script>
import {mapState} from 'vuex'
import { eventModal } from '../event-bus';
export default {

created : function(){

    eventModal.$on('open',this.OpenModal);

},

computed :{

    ...mapState(['url','AppUrl'])

},

methods : {

OpenModal(){    

    $('#periodos').modal('show');   
    
}

}
    
}
</script>