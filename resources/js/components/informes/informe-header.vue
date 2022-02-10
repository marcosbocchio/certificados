<template>
    <div>
        <div class="box box-custom-enod">
            <div class="box-body">
                <div class="col-md-6">
                    <div class="form-group" >
                        <label for="cliente">Cliente</label>
                        <input type="text" v-model="cliente.nombre_fantasia" class="form-control" id="cliente" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" >
                        <label for="proyecto">Proyecto</label>
                        <input type="text" v-model="otdata.proyecto" class="form-control" id="proyecto" disabled>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group" >
                        <label for="obra">Obra N°</label>
                        <div v-if="otdata.obra">
                            <input type="text" v-model="obra" class="form-control" id="obra" min="0" maxlength="15" @input="inputObra" :disabled="otdata.obra">
                        </div>
                        <div v-else>
                            <v-select v-model="obra" label="obra" :options="obras" :reduce="obras => obras.obra" @input="inputObra" id="obra"></v-select>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="planta" >Planta</label>
                        <div>
                            <v-select :disabled="deshabilitarPlanta_sn" v-model="planta" label="codigo" @input="inputPlanta" :options="plantas" id="planta" ></v-select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ot">Orden de Trabajo N°</label>
                        <input type="number" v-model="otdata.numero" class="form-control" id="ot" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {eventEditRegistro} from '../event-bus';
import {mapState} from 'vuex';
export default {
    props :{
        otdata : {
            type : Object,
            required : true
        },
        informe_id: {
            type :Number,
            required:false,
            default:0,
        },
        editmode : {
            type : Boolean,
            required : false,
            default : false
        },
        deshabilitarPlanta_sn : {
            type : Boolean,
            required : false,
            default : false
        },
        importado_sn : {
            type : Boolean,
            required : false,
            default : false
        }
    },
    data() {return {
        cliente:'',
        obra:'',
        planta:'',
        obras:[],
        plantas:[],
    }},
    created : function() {
      this.getCliente();
      this.getObras();
      eventEditRegistro.$on('refreshObra', this.setDatos);
    },
    mounted : function() {
        this.setDatos()
    },
    computed :{
        ...mapState(['url','obra_informe','planta_informe']),
     },
    methods : {
        inputObra :  function(){
            this.$emit('set-obra',this.obra)
        },
        inputPlanta :  function(){
            this.$emit('set-planta',this.planta)
        },
        resetPlanta : function(){
            this.planta = ''
        },
        setDatos : function(){
           this.$forceUpdate();
           this.obra = '';
           this.planta = '';
           if(this.editmode){

                this.$store.dispatch('loadObraInformes',{ informe_id: this.informe_id , importado_sn: this.importado_sn}).then(response => {
                    console.log(this.obra_informe)
                    this.obra = this.obra_informe

                })

                this.$store.dispatch('loadPlantaInformes',{ informe_id: this.informe_id , importado_sn: this.importado_sn}).then(response => {
                    console.log('planta : ',this.planta_informe)
                    this.planta = this.planta_informe
                })
            }else{
                this.obra =  this.otdata.obra
                this.inputPlanta()
                this.inputObra();
            }
        },
        getCliente : function(){
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'clientes/' + this.otdata.cliente_id + '?api_token=' + Laravel.user.api_token;
            axios.get(urlRegistros).then(response =>{
            this.cliente = response.data
            this.getPlantas();
            });
        },
        getObras : function(){
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'ots/' + this.otdata.id + '/obras_por_tipo_soldaduras' + '?api_token=' + Laravel.user.api_token;
            axios.get(urlRegistros).then(response =>{
            this.obras = response.data
            });
        },
        getPlantas : function(){
            axios.defaults.baseURL = this.url ;
            var urlRegistros = 'plantas/cliente/' + this.cliente.id + '?api_token=' + Laravel.user.api_token;
            axios.get(urlRegistros).then(response =>{
            this.plantas = response.data
            });
        }

    }
}
</script>

<style scoped>

.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
     background-color: #eee;
}

</style>
