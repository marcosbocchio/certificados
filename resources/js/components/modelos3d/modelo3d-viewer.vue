<template>
    <div>

        <div class="row">

            <div class="col-sm-8">
                <div class="titulo-categoria ">
                    <h3 class="panel-title font" style="margin: 0px 0px 5px 22px;">VISUALIZADOR 3D</h3>
                </div>
                <div class="box box-custom-enod" style="margin-top:20px;padding: 5px 15px 5px 5px;">
                    <div class="box-body">
                        <model-obj :src="'/' + modelo_3d.path" class="pointer"></model-obj>
                    </div>
                </div>
            </div>

            <div class="col-sm-4" >

                <div class="cantSub">
                    <h3 class="panel-title font" style="margin: 0px 0px 5px 22px;">{{ modelo_3d.codigo}}</h3>
                </div>

                <div style="margin:20px 0px 0px 5px">
                     <p style="color:gray"><strong>Descripción:</strong> {{ modelo_3d.descripcion}} </p>
                 </div>
            </div>

        </div>


    </div>
</template>

<script>
export default {

    props: {
      modelo_3d : {
      type : [Object] ,
      required : true,
      default : function () { return {}}
      },
    }
}
</script>


