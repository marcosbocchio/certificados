<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-custom-enod">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="fuenteTitulo">Categoria</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 ">
                                <v-select :options="categorias" label="title" v-model="categoriaSelec" @input="setSelected"></v-select>
                            </div>
                            <div class="col-md-3 col-md-offset-3" >
                                <div class="row">
                                    <div class="pull-right" style="margin: 0 15px 0 0">
                                        <button v-if="categoriaSelec" title="Editar" class="btn btn-warning btn-sm" @click="showCatModal"><span class="fa fa-edit" aria-hidden="true" ></span></button>
                                        <button v-if="categoriaSelec" title="Eliminar " class="btn btn-danger btn-sm" @click="showCatDeleteModal"><span class="fa fa-trash" aria-hidden="true"></span></button>
                                        <button class="btn btn-success btn-sm" @click="showCatNuevaModal"><span class="fa fa-plus-circle" aria-hidden="true" ></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div v-if="categoriaSelec">
        <subcategoria-edit v-bind:categoriaPadreSelect="categoriaSelec"></subcategoria-edit>
    </div>

        <!--MODAL categorias-->
        <div class="modal fade " tabindex="-1" role="dialog" id="modal-categoria" data-keyboard="false" data-backdrop="static" >
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" data-dismiss="modal" class="close">×</button>
                        <h4>Categoria</h4>
                    </div>
                    <div class="modal-body">
                        <form id="categoriaForm" @submit.prevent="onSubmitCategoria">
                            <div class="row">
                                <div class="col-md-12" style="margin-top: 15px;">
                                    <div class="form-group">
                                        <label for="tituloCategoria"> Título de la categoria *</label>
                                        <input  id='AcotadoCategoria' type="checkbox" v-model="categoriaAux.acotado_sn" style="float: right;"/>
                                        <label for="AcotadoCategoria" style="float: right; margin-right: 5px;"> Restringido</label>
                                        <input name="tituloCategoria" class="form-control" id='title' maxlength="50" type="text" v-model="categoriaAux.title" autocomplete="off"/>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" form="categoriaForm">Guardar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
                </div>
            </div>
        </div>
       <!--MODAL categorias nueva-->
        <div class="modal fade " tabindex="-1" role="dialog" id="modal-categoria-nueva" data-keyboard="false" data-backdrop="static" >
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" data-dismiss="modal" class="close">×</button>
                        <h4>Categoria</h4>
                    </div>
                    <div class="modal-body">
                        <form id="nuevaCategoriaForm" @submit.prevent="crearNuevo">
                            <div class="row">
                                <div class="col-md-12" style="margin-top: 15px;">
                                    <div class="form-group">
                                        <label for="tituloNuevaCategoria"> Título de la nueva categoria *</label>
                                        <input  name='AcotadoNCategoria' type="checkbox" v-model="nuevaCategoria.acotado_sn" style="float: right;"/>
                                        <label for="AcotadoNCategoria" style="float: right; margin-right: 5px;"> Restringido</label>
                                        <input name="tituloNuevaCategoria" class="form-control" type="text" maxlength="50" placeholder="Max 50 caracteres" v-model="nuevaCategoria.title" autocomplete="off"/>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" form="nuevaCategoriaForm">Guardar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Eliminar-->
        <div class="modal fade " tabindex="-1" role="dialog" id="modal-categoria-delete" data-keyboard="false" data-backdrop="static" >
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" data-dismiss="modal" class="close">×</button>
                        <h4>Eliminar Categoria</h4>
                    </div>
                    <div class="modal-body">
                        <form id="categoriaDeleteForm" @submit.prevent="onSubmitCategoriaDelete">
                            <div class="row">
                                <div class="col-md-12" style="margin-top: 15px;">
                                    <div class="form-group">
                                        <p>Está seguro de eliminar el la categoria "{{ this.categoriaAux.title }}" ?</p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" form="categoriaDeleteForm">Aceptar</button>
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
        title: String

    },
    data() {
        return {
            categorias: [],
            categoriaSelec: '',
            categoriaAux:{
                title: '',
                acotado_sn: false
                },
            nuevaCategoria:{
                title: '',
                acotado_sn: false
                }
            }
        },
    mounted() {
        this.getCategorias();
        },
    computed: {
            ...mapState(['isLoading',]),
           isEmpty: function () {
              return this.categoriaSelec == null ? true : jQuery.isEmptyObject(this.categoriaSelec)
                }
            },
    methods: {
        isEmptyOrNull: function (item) {
              return item == null ? true : jQuery.isEmptyObject(item)
        },
        showCatModal: function() {
            $('#modal-categoria').modal('show');
        },
        showCatNuevaModal: function() {
            $('#modal-categoria-nueva').modal('show');
        },
        closeCatModal() {
            $('#modal-categoria').modal('hide');
        },
        closeNuevaCatModal() {
            $('#modal-categoria-nueva').modal('hide');
        },
        showCatDeleteModal: function() {
            $('#modal-categoria-delete').modal('show');
        },
        closeCatDeleteModal() {
            $('#modal-categoria-delete').modal('hide');
        },
        getCategorias: async function(){
                this.$store.commit('loading', true);
                this.categorias= [];
                this.categoriaSelec= '';
                var url = 'categoriasVideos';
                await axios.get(url).then(response =>{
                    this.categorias = response.data;
                    this.$store.commit('loading', false);
                });
        },
        setSelected: function() {
            if(!this.isEmptyOrNull(this.categoriaSelec)){
                this.categoriaAux.title = this.categoriaSelec.title;
                this.categoriaAux.acotado_sn = this.categoriaSelec.acotado_sn;
            }
            else{
                this.categoriaAux.title = '';
                this.categoriaAux.acotado_sn = false;
            }
        },
        onSubmitCategoria : async function(){
            let urlA = 'category-update';
            await axios({
                     method: 'post',
                     url : urlA,
                     data : {
                        'title' : this.categoriaAux.title,
                        'id': this.categoriaSelec.id,
                        'acotado_sn' : this.categoriaAux.acotado_sn
                     }}
                     ).then(response => {
                        toastr.success('La categoria se guardo con éxito');
                        this.closeCatModal();
                        this.getCategorias();
                        this.categoriaSelec = response.data;
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
        crearNuevo : async function(){
            let urlA = 'category-update';
            await axios({
                     method: 'post',
                     url : urlA,
                     data : {
                        'title' : this.nuevaCategoria.title,
                        'id': 0,
                        'acotado_sn' : this.nuevaCategoria.acotado_sn
                     }}
                     ).then(response => {
                        toastr.success('La categoria se agrego con éxito');
                        this.closeNuevaCatModal();
                        this.nuevaCategoria.title = '';
                        this.nuevaCategoria.acotado_sn = false;
                        this.getCategorias();
                        this.categoriaSelec = response.data;
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
        onSubmitCategoriaDelete: async function(){
            let URL = 'category-delete';
            await axios.delete(URL, {
                                params: { id: this.categoriaSelec.id }
                    }).then(response => {
                     toastr.success('La categoria se elimino con éxito');
                 }).catch(error => {
                         toastr.error(error);
                 });
            this.getCategorias();
            this.closeCatDeleteModal();
        }
    }
}
</script>
<style>
    .fuenteTitulo{
        font-weight: bold;
    }
</style>
