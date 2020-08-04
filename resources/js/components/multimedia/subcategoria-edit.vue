<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-custom-enod">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="fuenteTitulo">Subcategorias</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 ">
                                <v-select :options="subcategorias" label="title" v-model="subcategoriaSelec" @input="setSelected"></v-select>
                            </div>
                            <div class="col-md-3 col-md-offset-3" >
                                <div class="row">
                                    <div class="pull-right" style="margin: 0 15px 0 0">
                                        <button v-if="subcategoriaSelec" title="Editar" class="btn btn-warning btn-sm" @click="showSubcatModal"><span class="fa fa-edit" aria-hidden="true" ></span></button>
                                        <button v-if="subcategoriaSelec" title="Eliminar " class="btn btn-danger btn-sm" @click="showSubcatDeleteModal"><span class="fa fa-trash" aria-hidden="true"></span></button>
                                        <button class="btn btn-success btn-sm" @click="shownuevaSubcatModal"><span class="fa fa-plus-circle" aria-hidden="true" ></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div v-if="subcategoriaSelec" class="col-md-12">
                                <label style="margin-top: 5px;">Descripción</label>
                                <textarea rows="3" placeholder="" disabled='true' maxlength="450" class="form-control noresize" v-model=subcategoriaSelec.description></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div v-if="subcategoriaSelec">
        <secciones-edit v-bind:categoriaPadreSelect="subcategoriaSelec"></secciones-edit>
    </div>

        <!--MODAL subcategorias-->

        <div class="modal fade " tabindex="-1" role="dialog" id="modal-subcategoria" data-keyboard="false" data-backdrop="static" >
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" data-dismiss="modal" class="close">×</button>
                        <h4>Subcategoria</h4>
                    </div>
                    <div class="modal-body">
                        <form id="subcategoriaForm" @submit.prevent="onSubmitCategoria">
                            <div class="row">
                                <div class="col-md-12" style="margin-top: 15px;">
                                    <div class="form-group">
                                        <label for="tituloSubcategoria"> Título de la subcategoria *</label>
                                        <input  id='AcotadoSubategoria' type="checkbox" v-model="subcategoriaAux.acotado_sn" style="float: right;"/>
                                        <label for="AcotadoSubcategoria" style="float: right; margin-right: 5px;"> Restringido</label>
                                        <input name="tituloSubcategoria"  maxlength="50" class="form-control" type="text" v-model="subcategoriaAux.title" autocomplete="off"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="descSubcategoria" style="margin-top: 5px;">Descripción</label>
                                    <textarea name="descSubcategoria" rows="3" placeholder="" maxlength="450" class="form-control noresize" v-model=subcategoriaAux.description></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" form="subcategoriaForm">Guardar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
                </div>
            </div>
        </div>

        <!--MODAL nueva subcategorias-->

        <div class="modal fade " tabindex="-1" role="dialog" id="modal-subcategoria-nueva" data-keyboard="false" data-backdrop="static" >
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" data-dismiss="modal" class="close">×</button>
                        <h4>Subcategoria</h4>
                    </div>
                    <div class="modal-body">
                        <form id="nuevaSubcategoriaForm" @submit.prevent="onSubmitnuevaSubcat">
                            <div class="row">
                                <div class="col-md-12" style="margin-top: 15px;">
                                    <div class="form-group">
                                        <label for="tituloNuevaSubcategoria"> Título de la nueva subcategoria *</label>
                                        <input  id='AcotadoSubategoria' type="checkbox" v-model="NuevaSubcategoria.acotado_sn" style="float: right;"/>
                                        <label for="AcotadoSubcategoria" style="float: right; margin-right: 5px;"> Restringido</label>
                                        <input name="tituloNuevaSubcategoria"  placeholder="Max 50 caracteres" maxlength="50" class="form-control" type="text" v-model="NuevaSubcategoria.title" autocomplete="off"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="descNuevSubcategoria" style="margin-top: 5px;">Descripción</label>
                                    <textarea name="descNuevSubcategoria" rows="3" placeholder="Max 450 caracteres" maxlength="450" class="form-control noresize" v-model=NuevaSubcategoria.description></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="margin-top: 15px;">
                                    <div class="form-group">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" form="nuevaSubcategoriaForm">Guardar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
                </div>
            </div>
        </div>

        <!-- Eliminar-->
        <div class="modal fade " tabindex="-1" role="dialog" id="modal-subcategoria-delete" data-keyboard="false" data-backdrop="static" >
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" data-dismiss="modal" class="close">×</button>
                        <h4>Eliminar Categoria</h4>
                    </div>
                    <div class="modal-body">
                        <form id="subcategoriaDeleteForm" @submit.prevent="onSubmitSubcategoriaDelete">
                            <div class="row">
                                <div class="col-md-12" style="margin-top: 15px;">
                                    <div class="form-group">
                                        <p>Está seguro de eliminar la subcategoria "{{ this.subcategoriaAux.title }}" ?</p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" form="subcategoriaDeleteForm">Aceptar</button>
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
      this.getSubCategorias();
      }
    },
    data() {
        return {
            subcategorias: [],
            subcategoriaSelec: '',
            subcategoriaAux:{
                title: '',
                description: '',
                acotado_sn: false
                },
            NuevaSubcategoria:{
                title: '',
                description: '',
                acotado_sn: false
                }
            }
        },
        created(){
            this.getSubCategorias();
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
        getSubCategorias: async function(){
                this.$store.commit('loading', true);
                this.subcategorias = [];
                this.subcategoriaSelec = '';
                var url = 'subCategoriasVideos/' + this.categoriaPadreSelect.id;
                await axios.get(url).then(response =>{
                    this.subcategorias = response.data;
                    this.$store.commit('loading', false);
                });
        },
        setSelected: function() {
            if(!this.isEmptyOrNull(this.subcategoriaSelec)){
                this.subcategoriaAux.title = this.subcategoriaSelec.title;
                this.subcategoriaAux.description = this.subcategoriaSelec.description;
                this.subcategoriaAux.acotado_sn = this.subcategoriaSelec.acotado_sn;
            }
            else{
                this.subcategoriaAux.title = '';
                this.subcategoriaAux.description = '';
                this.subcategoriaAux.acotado_sn = false;
            }
        },
        showSubcatModal: function() {
            $('#modal-subcategoria').modal('show');
        },
        shownuevaSubcatModal: function() {
            $('#modal-subcategoria-nueva').modal('show');
        },
        closeSubcatModal() {
            $('#modal-subcategoria').modal('hide');
        },
        closeNuevaSubcatModal() {
            $('#modal-subcategoria-nueva').modal('hide');
        },
        showSubcatDeleteModal: function() {
            $('#modal-subcategoria-delete').modal('show');
        },
        closeSubcatDeleteModal() {
            $('#modal-subcategoria-delete').modal('hide');
        },
        onSubmitCategoria : async function(){
            let urlA = 'category-update';
            await axios({
                     method: 'post',
                     url : urlA,
                     data : {
                        'title' : this.subcategoriaAux.title,
                        'description' : this.subcategoriaAux.description,
                        'id': this.subcategoriaSelec.id,
                        'parent_id': this.categoriaPadreSelect.id,
                        'acotado_sn' :this.subcategoriaAux.acotado_sn
                     }}
                     ).then(response => {
                     toastr.success('La subcategoria se guardo con éxito');
                     this.closeSubcatModal();
                     this.getSubCategorias();
                     this.subcategoriaSelec = response.data;
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
        onSubmitnuevaSubcat : async function(){
            let urlA = 'category-update';
            await axios({
                     method: 'post',
                     url : urlA,
                     data : {
                        'title' : this.NuevaSubcategoria.title,
                        'description' : this.NuevaSubcategoria.description,
                        'parent_id': this.categoriaPadreSelect.id,
                        'acotado_sn' :this.NuevaSubcategoria.acotado_sn
                     }}
                     ).then(response => {
                     toastr.success('La subcategoria se guardo con éxito');
                     this.closeNuevaSubcatModal();
                     this.NuevaSubcategoria.title ='';
                     this.NuevaSubcategoria.description ='';
                     this.getSubCategorias();
                     this.subcategoriaSelec = response.data;
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
        onSubmitSubcategoriaDelete: async function(){
            let URL = 'category-delete';
            await axios.delete(URL, {
                                params: { id: this.subcategoriaSelec.id }
                    }).then(response => {
                     toastr.success('La categoria se elimino con éxito');
                 }).catch(error => {
                         toastr.error(error);
                 });
            this.getSubCategorias();
            this.closeSubcatDeleteModal();
        }
    }
}
</script>
<style>
    .fuenteTitulo{
        font-weight: bold;
    }
</style>
