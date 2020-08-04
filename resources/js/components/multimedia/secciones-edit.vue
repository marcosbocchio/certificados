<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-custom-enod">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="fuenteTitulo">Secciones</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <v-select :options="secciones" label="title" v-model="seccionSelec" @input="setSelected"></v-select>
                            </div>
                            <div class="col-md-3 col-md-offset-3" >
                                <div class="row">
                                    <div class="pull-right" style="margin: 0 15px 0 0">
                                        <button v-if="seccionSelec" title="Editar" class="btn btn-warning btn-sm" @click="showSeccionModal"><span class="fa fa-edit" aria-hidden="true" ></span></button>
                                        <button v-if="seccionSelec" title="Eliminar " class="btn btn-danger btn-sm" @click="showSeccionDeleteModal"><span class="fa fa-trash" aria-hidden="true"></span></button>
                                        <button class="btn btn-success btn-sm" @click="shownuevaSeccionModal"><span class="fa fa-plus-circle" aria-hidden="true" ></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div v-if="seccionSelec">
        <video-edit v-bind:secionPadreSelect="seccionSelec"></video-edit>
    </div>

        <!--MODAL Secciones-->
        <div class="modal fade " tabindex="-1" role="dialog" id="modal-seccion" data-keyboard="false" data-backdrop="static" >
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" data-dismiss="modal" class="close">×</button>
                        <h4>Sección</h4>
                    </div>
                    <div class="modal-body">
                        <form id="seccionForm" @submit.prevent="onSubmitSeccion">
                            <div class="row">
                                <div class="col-md-12" style="margin-top: 15px;">
                                    <div class="form-group">
                                        <label for="tituloSeccion"> Título de la sección *</label>
                                        <input  id='AcotadoSeccion' type="checkbox" v-model="seccionAux.acotado_sn" style="float: right;"/>
                                        <label for="AcotadoSeccion" style="float: right; margin-right: 5px;"> Restringido</label>
                                        <input name="tituloSeccion"  placeholder="Max 50 caracteres" maxlength="50" class="form-control" type="text" v-model="seccionAux.title" autocomplete="off"/>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" form="seccionForm">Guardar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
                </div>
            </div>
        </div>
    <!--MODAL nueva seccion-->
        <div class="modal fade " tabindex="-1" role="dialog" id="modal-seccion-nueva" data-keyboard="false" data-backdrop="static" >
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" data-dismiss="modal" class="close">×</button>
                        <h4>Sección</h4>
                    </div>
                    <div class="modal-body">
                        <form id="nuevaSeccionForm" @submit.prevent="onSubmitNuevaSeccion">
                            <div class="row">
                                <div class="col-md-12" style="margin-top: 15px;">
                                    <div class="form-group">
                                        <label for="tituloNuevaSeccion"> Título de la nueva sección *</label>
                                        <input  id='AcotadoNSeccion' type="checkbox" v-model="nuevaSeccion.acotado_sn" style="float: right;"/>
                                        <label for="AcotadoNSeccion" style="float: right; margin-right: 5px;"> Restringido</label>
                                        <input name="tituloNuevaSeccion" placeholder="Max 50 caracteres" maxlength="50" class="form-control" type="text" v-model="nuevaSeccion.title" autocomplete="off"/>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" form="nuevaSeccionForm">Guardar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
                </div>
            </div>
        </div>
        <!-- Eliminar-->
        <div class="modal fade " tabindex="-1" role="dialog" id="modal-seccion-delete" data-keyboard="false" data-backdrop="static" >
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" data-dismiss="modal" class="close">×</button>
                        <h4>Eliminar sección</h4>
                    </div>
                    <div class="modal-body">
                        <form id="seccionDeleteForm" @submit.prevent="onSubmitSeccionDelete">
                            <div class="row">
                                <div class="col-md-12" style="margin-top: 15px;">
                                    <div class="form-group">
                                         <p>Está seguro de eliminar el la sección "{{ this.seccionAux.title }}" ?</p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" form="seccionDeleteForm">Aceptar</button>
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
        categoriaPadreSelect: ''
    },
    watch: {
    categoriaPadreSelect: function () {
      this.getSecciones();
      }
    },
    data() {
        return {
            secciones: [],
            seccionSelec: '',
            seccionAux:{
                title: '',
                acotado_sn: false
                },
            nuevaSeccion:{
                title: '',
                acotado_sn: false
                }
            }
        },
    mounted() {
        this.getSecciones();
        },
    computed: {
        ...mapState(['isLoading',]),
           isEmpty: function () {
              return this.seccionSelec == null ? true : jQuery.isEmptyObject(this.seccionSelec)

                }
            },
    methods: {
        isEmptyOrNull: function (item) {
              return item == null ? true : jQuery.isEmptyObject(item)
        },
        showSeccionModal: function() {
            $('#modal-seccion').modal('show');
        },
        shownuevaSeccionModal: function() {
            $('#modal-seccion-nueva').modal('show');
        },
        closeSeciconModal() {
            $('#modal-seccion').modal('hide');
        },
        closeNuevaSeciconModal() {
            $('#modal-seccion-nueva').modal('hide');
        },
        showSeccionDeleteModal: function() {
            $('#modal-seccion-delete').modal('show');
        },
        closeSeccionDeleteModal() {
            $('#modal-seccion-delete').modal('hide');
        },
        getSecciones: async function(){
                this.$store.commit('loading', true);
                this.secciones = [];
                this.seccionSelec = '';
                var url = 'subCategoriasVideos/' + this.categoriaPadreSelect.id;
                await axios.get(url).then(response =>{
                    this.secciones = response.data;
                    this.$store.commit('loading', false);
                });
        },
        setSelected: function() {
            if(!this.isEmptyOrNull(this.seccionSelec)){
                this.seccionAux.title = this.seccionSelec.title;
                 this.seccionAux.acotado_sn = this.seccionSelec.acotado_sn;
            }
            else{
                this.seccionAux.title =  '';
                this.seccionAux.acotado_sn = false;
            }
        },
        onSubmitSeccion : async function(){
            let urlA = 'category-update';
            await axios({
                     method: 'post',
                     url : urlA,
                     data : {
                        'title' : this.seccionAux.title,
                        'parent_id': this.seccionSelec.parent_id,
                        'id': this.seccionSelec.id,
                        'acotado_sn': this.seccionAux.acotado_sn
                     }}
                     ).then(response => {
                     toastr.success('La sección se guardo con éxito');
                     this.closeSeciconModal();
                     this.getSecciones();
                     this.seccionSelec = response.data;
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
        onSubmitNuevaSeccion : async function(){
            let urlA = 'category-update';
            await axios({
                     method: 'post',
                     url : urlA,
                     data : {
                        'title' : this.nuevaSeccion.title,
                        'parent_id': this.categoriaPadreSelect.id,
                        'acotado_sn': this.nuevaSeccion.acotado_sn
                     }}
                     ).then(response => {
                     toastr.success('La sección se guardo con éxito');
                     this.closeNuevaSeciconModal();
                     this.nuevaSeccion.title = '';
                     this.nuevaSeccion.acotado_sn = false;
                     this.getSecciones();
                     this.seccionSelec = response.data;
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
        onSubmitSeccionDelete: async function(){
            let URL = 'category-delete';
            await axios.delete(URL, {
                                params: { id: this.seccionSelec.id }
                    }).then(response => {
                     toastr.success('La sección se elimino con éxito');
                 }).catch(error => {
                         toastr.error(error);
                 });
            this.getSecciones();
            this.closeSeccionDeleteModal();
        }

    }
}
</script>
<style>
    .fuenteTitulo{
        font-weight: bold;
    }
</style>
