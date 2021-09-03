<template>
    <div>
      <marcar-documentos v-if="operadores_header.length" :header="operadores_header" :documentos="documentos" tipo="USUARIO" titulo="OPERADORES"></marcar-documentos>
      <marcar-documentos v-if="interno_equipos_header.length" :header="interno_equipos_header" :documentos="documentos" tipo="EQUIPO" titulo="EQUIPOS"></marcar-documentos>
      <marcar-documentos v-if="interno_fuentes_header.length" :header="interno_fuentes_header" :documentos="documentos" tipo="FUENTE" titulo="FUENTES"></marcar-documentos>
      <marcar-documentos v-if="procedimientos_header.length" :header="procedimientos_header" :documentos="documentos" tipo="PROCEDIMIENTO" titulo="PROCEDIMIENTOS"></marcar-documentos>
      <marcar-documentos v-if="vehiculos_header.length" :header="vehiculos_header" :documentos="documentos" tipo="VEHICULO" titulo="VEHÍCULOS"></marcar-documentos>
      <div class="row">
          <div class="col-md-12">
              <button class="btn btn-primary" @click.prevent="GenerarLink">Generar Link</button>
          </div>
      </div>
    </div>
</template>
<script>
import {mapState} from 'vuex'
export default {
  props :{
      ot_id : {
        type : Number,
        required : true
      },
  },
  data() { return {

      operadores_sn: true,
      documentos: [],
      operadores:[],
      interno_equipos: [],
      interno_fuentes: [],
      procedimientos: [],
      vehiculos: [],
      operadores_header: [],
      interno_equipos_header: [],
      interno_fuentes_header: [],
      procedimientos_header: [],
      vehiculos_header: [],
      errors: [],

   }
  },
  computed :{

       ...mapState(['url','isLoading']),
    },

   mounted () {
       this.getDocumentos()
   },
  methods: {

    getDocumentos: async function () {
        axios.defaults.baseURL = this.url ;
        var urlRegistros = 'documentos/ot/' + this.ot_id + '?api_token=' + Laravel.user.api_token;
        let res = await axios.get(urlRegistros);
        this.documentos = await res.data;
        this.documentos.map(e => Object.defineProperty(e, 'check', { value: true, enumerable: true, writable: true }))
        this.operadores = this.documentos.filter(e => e.tipo == 'USUARIO' )
        this.interno_equipos = this.documentos.filter(e => e.tipo == 'EQUIPO' )
        this.interno_fuentes = this.documentos.filter(e => e.tipo == 'FUENTE' )
        this.procedimientos = this.documentos.filter(e => e.tipo == 'PROCEDIMIENTO' )
        this.vehiculos = this.documentos.filter(e => e.tipo == 'VEHICULO' )
        let operadores_unicos = [...new Set(this.operadores.map(item => item.item_id ))];
        let interno_equipos_unicos = [...new Set(this.interno_equipos.map(item => item.item_id ))];
        let interno_fuentes_unicos = [...new Set(this.interno_fuentes.map(item => item.item_id ))];
        let procedimientos_unicos = [...new Set(this.procedimientos.map(item => item.item_id ))];
        let vehiculo_unicos = [...new Set(this.vehiculos.map(item => item.item_id ))];
        let index

        // operadores
        operadores_unicos.forEach(function(item){
            index = this.operadores.findIndex(e2 => e2.item_id == item)
            this.operadores_header.push({
                codigo : this.operadores[index].codigo,
                item_id : this.operadores[index].item_id,
                check:true,
                expandir:false,
            })
        }.bind(this))

        // interno equipos
        interno_equipos_unicos.forEach(function(item){
            index = this.interno_equipos.findIndex(e2 => e2.item_id == item)
            this.interno_equipos_header.push({
                codigo : this.interno_equipos[index].codigo,
                item_id : this.interno_equipos[index].item_id,
                check:true,
                expandir:false,
            })
        }.bind(this))

        // interno fuentes
        interno_fuentes_unicos.forEach(function(item){
            index = this.interno_fuentes.findIndex(e2 => e2.item_id == item)
            this.interno_fuentes_header.push({
                codigo : this.interno_fuentes[index].codigo,
                item_id : this.interno_fuentes[index].item_id,
                check:true,
                expandir:false,
            })
        }.bind(this))

        // vehiculos
        vehiculo_unicos.forEach(function(item){
            index = this.vehiculos.findIndex(e2 => e2.item_id == item)
            this.vehiculos_header.push({
                codigo : this.vehiculos[index].codigo,
                item_id : this.vehiculos[index].item_id,
                check:true,
                expandir:false,
            })
        }.bind(this))

        // vehiculos
        procedimientos_unicos.forEach(function(item){
            index = this.procedimientos.findIndex(e2 => e2.item_id == item)
            this.procedimientos_header.push({
                codigo : this.procedimientos[index].codigo,
                item_id : this.procedimientos[index].item_id,
                check:true,
                expandir:false,
            })
        }.bind(this))
    },

    GenerarLink:function () {

        let documentos_ids = this.documentos.filter(function(e) { return e.check }).map(e => e.id)
        console.log(documentos_ids)

    },

    Store : function(){

        this.errors =[];
        var urlRegistros = 'informes_us' ;
        axios({
        method: 'post',
        url : urlRegistros,
        data : {
            'ot'              : this.otdata,

    }}

    ).then(response => {

        let informe = response.data;
        toastr.success('informe N°' + this.numero_inf + ' fue creado con éxito ');
        window.open(  '/pdf/informe/us/' + informe.id,'_blank');
        window.location.href =  '/informes/ot/' + this.otdata.id;

    }).catch(error => {

        this.errors = error.response.data.errors;
            console.log(error.response);
        $.each( this.errors, function( key, value ) {
            toastr.error(value);
            console.log( key + ": " + value );
        });

        if((typeof(this.errors)=='undefined') && (error)){

                toastr.error("Ocurrió un error al procesar la solicitud");

            }
    });

    },
  }
}
</script>
