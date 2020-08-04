<template>
        <div class="row">
            <div class="col-md-6">
                <div v-for="(seccion, k) in secciones" :key="k">
                    <div class="row">
                        <div class="btn-group col-xs-12 ">
                            <div class="box collapsed-box box-custom-enod">
                                <div class="box-header with-border">
                                  <h3 class="box-title font">{{seccion.nombreSeccion}}</h3>
                                  <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                    </button>
                                  </div>
                                  <!-- /.box-tools -->
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body" style="display: none;">
                                    <li v-for="(video, j) in seccion.videos" :key="j" style="list-style: none; margin-bottom: 3px">
                                        <div style="vertical-align: middle; display: inline-block;">
                                            <svg width="20" height="20">
                                                <circle cx="10" cy="10" r="8" stroke="black" stroke-width="1" fill="yellow" />
                                                <polygon fill="black" points="8,5 15,10 8,15" />
                                            </svg>
                                        </div>
                                        <a href="#" @click="selectVideo(video)" class="text">
                                            {{video.title}}</a>
                                    </li>
                                </div>
                                <!-- /.box-body -->
                              </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-5 col-xs-12 col-sm-12 " >
                <div class="embed-responsive embed-responsive-16by9 float-none">
                    <iframe class="embed-responsive-item "
                        :src="'https://www.youtube.com/embed/' + videoSelected"
                        allowfullscreen>
                    </iframe>
                </div>
                <div>
                    <label style="margin-top: 15px ;">{{descripcion}}</label>
                </div>
            </div>

        </div>

</template>
<script>

import { toastrWarning,toastrDefault } from '../toastrConfig';

export default {
    props:{
        title: String,
        secciones: Array
    },
    data(){
        return {
            videoSelected : ' ',
            descripcion : ' '
            }
    },
    methods:{
        selectVideo(video){
            this.videoSelected = video.videoId;
            this.descripcion = video.description;
            }
    }
}
</script>
<style>
    .font{
        font-family: 'clearsans', 'montserrat';
        font-size: 24px !important;
        font-weight: bold;
        padding-right: 20px;
        line-height: 70px;
        text-align: end;
    }
    .text{
        font-size: 17px;
        color : black;
        font-family: 'clearsans', 'montserrat';
    }
</style>
