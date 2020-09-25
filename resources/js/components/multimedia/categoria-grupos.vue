<template>
    <div v-if="tieneElementos" >
        <div  class="row">
            <div class="col-md-10 col-md-10-np">
                <div class="titulo-categoria">
                    <h3 class="panel-title font" style="margin: 0px 0px 5px 22px;">{{title}}</h3>
                </div>
            </div>
            <div class="col-md-2 hidden-sm hidden-xs col-md-2-np">
                <div class="cantSub">
                    <h3 class="panel-title font" style="margin: 0px 0px 5px 22px;">{{subcategorias.length}}</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default contCategorias box-custom-enod2" >
                    <VueSlickCarousel v-bind="settings" :arrows="true" :dots="true" style="margin-left: 40px; margin-right: 40px;">
                        <div v-for="(subcategoria, k) in subcategorias" :key="k" class="subCategorias">
                            <div class="dav">
                                <a :href='url + "/"+ subcategoria.id'>
                                    <h5 class="curso-item">{{subcategoria.title}}</h5>
                                    <p class="text">{{subcategoria.description}}</p>
                                </a>
                            </div>
                        </div>
                    </VueSlickCarousel>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import { toastrWarning,toastrDefault } from '../toastrConfig';
import VueSlickCarousel from 'vue-slick-carousel'
import 'vue-slick-carousel/dist/vue-slick-carousel.css'
  // optional style for arrows & dots
import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'

export default {
    components: { VueSlickCarousel },
    props:{
        title: String,
        url: String,
        subcategorias: Array
    },
    data() {
        return {
            settings :{
                    "dots": true,
                    "infinite": true,
                    "initialSlide": 2,
                    "rows": 1,
                    "speed": 500,
                    "slidesToShow": 2,
                    "slidesToScroll": 1,
                    "swipeToSlide": true,
                    "adaptiveHeight": false
                    }
                }
        },
    computed: {
        tieneElementos: function(){
            if (this.subcategorias.length == 0){
                return false;
            } else{
                return true;
            }
        }
    },
    methods: {
        reiniciar() {
            console.log('our carousel is ready')
                 }
    }
}
</script>
<style>
    @media (min-width: 992px){
        .col-md-10-np{
            padding-right: 0;
        }
        .col-md-2-np{
            padding-left: 0;
        }
    }
    .titulo-categoria{
        background-color: rgb(255, 204, 0);
        color: #535353;
    }
    .cantSub{
        background-color:#535353;
        color: rgb(255, 204, 0);
    }
    .font{
        font-family: 'clearsans', 'montserrat';
        font-size: 23px;
        font-weight: bold;
        padding-right: 20px;
        line-height: 70px;
        text-align: end;
    }
    .box-custom-enod2{
        border-style: solid;
        border-width: 3px 0px 0px 0px;
        border-top-color: rgb(255, 204, 0);
        box-shadow: 0 -2px 0 #000;
    }
    .contCategorias{
        /*width: auto;*/
        margin: 0px auto 30px auto;
        /*max-width: 900px;*/
    }
    .subCategorias{
        margin: 5px;
    }
    .subCategorias:hover .curso-item{
        color: #d8574b;
    }
    .panel-body{
        padding: 5px;
    }
    .curso-item{
        font-size: 18px;
        color : black;
        font-weight: bold;
    }
    .text{
        font-size: 14px;
        color : black;
        font-family: 'clearsans', 'montserrat';
    }

    .dav{
        margin: 7px;
        padding: 5px;
        min-height: 80px;
        border-radius: 5px;
    }
    .col-center-block {
        float: none;
        display: block;
        margin: 0 auto;
        /* margin-left: auto; margin-right: auto; */
    }
    .slick-prev:before, .slick-next:before{
       font-size: 25px;
        color: #444;
    }

</style>
