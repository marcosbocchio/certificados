<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-custom-enod">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="fuenteTitulo">Videos</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 ">
                                <v-select :options="videos" label="title" v-model="videoSelec" @input="setSelected"></v-select>
                            </div>
                            <div class="col-md-3 col-md-offset-3" >
                                <div class="row">
                                    <div class="pull-right" style="margin: 0 15px 0 0">
                                        <button v-if="videoSelec" title="Editar" class="btn btn-warning btn-sm" @click="showVideoModal"><span class="fa fa-edit" aria-hidden="true" ></span></button>
                                        <button v-if="videoSelec" title="Eliminar " class="btn btn-danger btn-sm" @click="showVideoDeleteModal"><span class="fa fa-trash" aria-hidden="true"></span></button>
                                        <button class="btn btn-success btn-sm" @click="showNuevoVideoModal"><span class="fa fa-plus-circle" aria-hidden="true" ></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div  v-if="videoSelec" class="col-md-12">
                                <label style="margin-top: 5px;">Descripción</label>
                                <textarea  rows="3" placeholder="" disabled='true' maxlength="450" class="form-control noresize" v-model=videoSelec.description></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--MODAL videos-->

        <div class="modal fade " tabindex="-1" role="dialog" id="modal-video" data-keyboard="false" data-backdrop="static" >
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" data-dismiss="modal" class="close">×</button>
                        <h4>Video</h4>
                    </div>
                    <div class="modal-body">
                        <form id="VideoForm" @submit.prevent="onSubmitVideo">
                            <div class="row">
                                <div class="col-md-12" style="margin-top: 15px;">
                                    <div class="form-group">
                                        <label for="tituloVideo"> Título del video *</label>
                                        <input type="text" placeholder="Max 50 caracteres" maxlength="50" name="tituloVideo" class="form-control" v-model="videoAux.title" autocomplete="off"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="descNuevoVideo" style="margin-top: 5px;">Descripción</label>
                                    <textarea name="descNuevoVideo" rows="3" placeholder="Max 450 caracteres" maxlength="450" class="form-control noresize" v-model=videoAux.description></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="linkVideo" style="margin-top: 5px;">Link del video *</label>
                                    <input name="linkVideo" type="text"  maxlength="350" class="form-control"  v-model="videoAux.videoId" autocomplete="off"/>
                                </div>
                            </div>
                        </form>
                    </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" form="VideoForm">Guardar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
                </div>
            </div>
        </div>

        <!--MODAL Nuevos videos-->

        <div class="modal fade " tabindex="-1" role="dialog" id="modal-video-nuevo" data-keyboard="false" data-backdrop="static" >
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" data-dismiss="modal" class="close">×</button>
                        <h4>Video</h4>
                    </div>
                    <div class="modal-body">
                        <form id="nuevoVideoForm" @submit.prevent="onSubmitNuevoVideos">
                            <div class="row">
                                <div class="col-md-12" style="margin-top: 15px;">
                                    <div class="form-group">
                                        <label for="tituloNuevoVideo"> Título del nuevo video *</label>
                                        <input type="text" placeholder="Max 50 caracteres" maxlength="50" name="tituloNuevoVideo" class="form-control" v-model="nuevoVideo.title" autocomplete="off"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label style="margin-top: 5px;">Descripción</label>
                                    <textarea rows="3" placeholder="Max 450 caracteres" maxlength="450" class="form-control noresize" v-model=nuevoVideo.description></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="linkNuevoVideo" style="margin-top: 5px;">Link del video *</label>
                                    <input  type="text" name="linkNuevoVideo" maxlength="350" class="form-control" v-model="nuevoVideo.videoId" autocomplete="off"/>
                                </div>
                            </div>
                        </form>
                    </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" form="nuevoVideoForm">Guardar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
                </div>
            </div>
        </div>
        <!-- Eliminar-->
        <div class="modal fade " tabindex="-1" role="dialog" id="modal-video-delete" data-keyboard="false" data-backdrop="static" >
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" data-dismiss="modal" class="close">×</button>
                        <h4>Eliminar video</h4>
                    </div>
                    <div class="modal-body">
                        <form id="videoDeleteForm" @submit.prevent="onSubmitVideoDelete">
                            <div class="row">
                                <div class="col-md-12" style="margin-top: 15px;">
                                    <div class="form-group">
                                        <p>Está seguro de eliminar el video "{{ this.videoAux.title }}" ?</p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" form="videoDeleteForm">Aceptar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </div>
                </div>
            </div>
        </div>
        <loading :active.sync="isLoading"
            :loader="'bars'"
            :color="'red'">
        </loading>

    </div>
</template>

<script>

import { toastrWarning,toastrDefault } from '../toastrConfig';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import {mapState} from 'vuex';

export default {
    components: {
        Loading
    },
    props:{
        secionPadreSelect: ''
    },
    watch: {
        secionPadreSelect: function () {
            this.getVideos();
        }
    },
    data() {
        return {
            videos: [],
            videoSelec: '',
            videoAux:{
                title: '',
                description: '',
                videoId: ''
                },
            nuevoVideo:{
                title: '',
                description: '',
                videoId: ''
                }
            }
        },
        created(){
            this.getVideos();
        },
    mounted() {
        },
    computed: {
        ...mapState(['isLoading',]),
           isEmpty: function () {
              return this.subcategoriaSelec == null ? true : jQuery.isEmptyObject(this.subcategoriaSelec)
                }
            },
    methods: {
        isEmptyOrNull: function (item) {
              return item == null ? true : jQuery.isEmptyObject(item)
        },
        getVideos: async function(){
                this.$store.commit('loading', true);
                this.videos = [];
                this.videoSelec = '';
                var url = "get-Videos-categoria/" + this.secionPadreSelect.id;
                await axios.get(url).then(response =>{
                    this.videos = response.data;
                    this.$store.commit('loading', false);
                });
        },
        setSelected: function() {
            if(!this.isEmptyOrNull(this.videoSelec)){
                this.videoAux.title = this.videoSelec.title;
                this.videoAux.description = this.videoSelec.description;
                this.videoAux.videoId = 'https://www.youtube.com/watch?v=' + this.videoSelec.videoId;
            }
            else{
                this.videoAux.title = '';
                this.videoAux.description = '';
                this.videoAux.videoId = '';
            }
        },
        showVideoModal: function() {
            $('#modal-video').modal('show');
        },
        showNuevoVideoModal: function() {
            $('#modal-video-nuevo').modal('show');
        },
        closeVideoModal() {
            $('#modal-video').modal('hide');
        },
        closeNuevoVideoModal() {
            $('#modal-video-nuevo').modal('hide');
        },
        showVideoDeleteModal: function() {
            $('#modal-video-delete').modal('show');
        },
        closeVideoDeleteModal() {
            $('#modal-video-delete').modal('hide');
        },
        onSubmitVideo : async function(){
            let urlA = 'videos-new';
            await axios({
                     method: 'post',
                     url : urlA,
                     data : {
                        'title' : this.videoAux.title,
                        'description' : this.videoAux.description,
                        'videoId' : this.videoAux.videoId,
                        'video_category_id': this.secionPadreSelect.id,
                        'id' : this.videoSelec.id
                     }}
                     ).then(response => {
                        toastr.success('El video se guardo con éxito');
                        this.closeVideoModal();
                        this.getVideos();
                        this.videoSelec = response.data;
                        this.setSelected();
                 }).catch(error => {
                this.errors = error.response.data.errors;
                $.each( this.errors, function( key, value ) {
                    toastr.error(value);
                });

                if((typeof(this.errors)=='undefined') && (error)){
                        toastr.error("Ocurrió un error al procesar la solicitud");
                    }
           });
        },
        onSubmitNuevoVideos : async function(){
            let urlA = 'videos-new';
            await axios({
                     method: 'post',
                     url : urlA,
                     data : {
                        'title' : this.nuevoVideo.title,
                        'description' : this.nuevoVideo.description,
                        'videoId' : this.nuevoVideo.videoId,
                        'video_category_id': this.secionPadreSelect.id,
                        'id' : 0
                     }}
                     ).then(response => {
                     toastr.success('El video se guardo con éxito');
                     this.closeNuevoVideoModal();
                     this.getVideos();
                     this.nuevoVideo.title = '';
                     this.nuevoVideo.description = '';
                     this.nuevoVideo.videoId = '';
                     this.videoSelec= response.data;
                     this.setSelected();

                 }).catch(error => {
                this.errors = error.response.data.errors;
                $.each( this.errors, function( key, value ) {
                    toastr.error(value);
                });

                if((typeof(this.errors)=='undefined') && (error)){
                        toastr.error("Ocurrió un error al procesar la solicitud");
                    }
           });
        },
        onSubmitVideoDelete: async function(){
            let URL = 'video-delete';
            await axios.delete(URL, {
                                params: { id: this.videoSelec.id }
                    }).then(response => {
                     toastr.success('El video se elimino con éxito');
                 }).catch(error => {
                         toastr.error(error);
                 });
            this.getVideos();
            this.closeVideoDeleteModal();
        }
    }
}
</script>

<style>
    .fuenteTitulo{
        font-weight: bold;
    }
</style>
