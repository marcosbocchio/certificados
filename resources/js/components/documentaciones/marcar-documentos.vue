<template>
  <div class="row">

        <div class="col-xs-12">
            <div class="box box-default box-solid">
                <div class="box-header with-border">
                    <div class="box-tools" style="position: absolute;left:15px;top:5px">
                        <button type="button" class="btn btn-box-tool" @click="expandirTipo = !expandirTipo">
                            <i v-if="expandirTipo" class="fa fa-minus"></i>
                            <i v-if="!expandirTipo" class="fa fa-plus"></i>
                        </button>
                    </div>
                    <h3 class="box-title" style="margin-left: 30px;">{{ titulo }}</h3>
                    <div class="box-tools" style="margin-right:60px;top:8px">
                        <input class="pointer" type="checkbox" id="checkbox" @change="clickTitulo()" v-model="check">
                    </div>
                </div>
                <transition name="fade">
                    <div  v-if="expandirTipo" class="box-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-condensed">
                                <tbody>
                                    <template v-for="(item,k) in header">
                                        <tr :key="k">
                                            <td width="5%">
                                                <button type="button" @click="item.expandir = !item.expandir" class="btn btn-box-tool"><i v-if="!item.expandir" class="fa fa-plus"></i><i v-if="item.expandir" class="fa fa-minus"></i></button>
                                                </td>
                                            <td width="90%"> {{ item.codigo }}</td>
                                            <td width="5%"><input class="pointer" type="checkbox" id="checkbox" @change="clickHeader(item.item_id,k)" v-model="item.check"> </td>
                                        </tr>
                                        <transition name="fade">
                                            <tr v-if="item.expandir">
                                                <td class="col-md-10 col-md-offset-2" colspan="3" >
                                                    <div class="table-responsive">
                                                        <table class="table table-condensed">
                                                            <tbody>
                                                                <tr v-for="(detalle,y) in documentos" :key="y">
                                                                    <td width="95.2%" v-if="tipo.includes(detalle.tipo) && detalle.item_id == item.item_id"> <i><span style="margin-left:90px"> {{ detalle.titulo }} - {{detalle.descripcion}}</span></i></td>
                                                                    <td width="4.8%" v-if="tipo.includes(detalle.tipo)  && detalle.item_id == item.item_id"> <input class="pointer" type="checkbox" id="checkbox" v-model="detalle.check"></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </transition>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </div>
</template>

<script>
import {mapState} from 'vuex'
export default {
  props :{
      tipo: {
          type: Array,
          required: true,
      },
      titulo: {
          type: String,
          required: true,
      },
      header : {
        type : Array,
        required : true
      },
      documentos : {
        type : Array,
        required : true
      },
  },
  data() { return {
      expandirTipo: false,
      check:true,
   }
  },
  watch : {

  },
  computed :{

       ...mapState(['url','isLoading'])
    },
  methods : {
      clickTitulo : function() {

          this.header.forEach(function(item) {
              item.check = this.check;
          }.bind(this))

          this.documentos.forEach(function(item) {
              if(this.tipo.includes(item.tipo)) {
                item.check = this.check;
              }
          }.bind(this))
      },
      clickHeader : function(item_id,k) {
          this.documentos.forEach(function (item) {
              if (this.tipo.includes(item.tipo) && item.item_id === item_id){
                  item.check = this.header[k].check
              }
          }.bind(this));
      }
  }
}
</script>
