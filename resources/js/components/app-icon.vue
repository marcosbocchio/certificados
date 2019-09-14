<template>
    <div>
        <span :class="cssClasses" aria-hidden="true" :style="cssStyle"></span>
    </div>
</template>
<script>
export default {
    props : ['img','color'],
        
    computed :{

        cssClasses : function () {

            return 'fa fa-lg fa-' + this.img

        },
        cssStyle : function (){

            return 'color:' + this.color
        }
    }
}
</script>