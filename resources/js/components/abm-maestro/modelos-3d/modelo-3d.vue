<template>
    <div>
        <model-obj :src="modelo_3d"></model-obj>
    </div>
</template>

<script>
import { ModelObj } from 'vue-3d-model';
export default {
    components: {
      ModelObj
    },

    props : {

    modelo_3d : {
        type : String,
        required : false,
        }

    },
}
</script>
