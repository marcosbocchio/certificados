<template>
    <div>
       <!-- Primera Fila: Botón Nuevo y Buscador -->
       <div class="row">
           <div class="col-md-3">
               <div v-show="$can('T_remitos_edita')">
                   <a :href="'/area/enod/remitos'" class="btn btn-enod pull-left"><span class="fa fa-plus-circle"></span> Nuevo</a>
               </div>
           </div>
           <div class="col-md-6">
               <!-- Espacio en blanco (puedes eliminar este div si no lo necesitas) -->
           </div>
           <div class="col-md-3">
               <div class="input-group">
                   <input type="text" v-model="search" class="form-control" @keyup.enter="getResults">
                   <span class="input-group-addon btn" @click="getResults" style="background-color: rgb(255, 204, 0); cursor: pointer; border: none;">
                       <i class="fa fa-search"></i>
                   </span>
               </div>
           </div>
       </div>
       
       <!-- Segunda Fila: Tabla de Remitos -->
       <div class="row">
           <div class="col-md-12">
               <div class="box box-custom-enod top-buffer">
                   <div class="box-header with-border">
                       <h3 class="box-title">Remitos</h3>
                       <div class="box-tools pull-right">
                           <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                       </div>
                   </div>
                   
                   <div class="box-body">
                       <div class="table-responsive">
                           <table class="table table-hover table-striped table-condensed">
                               <thead>
                                   <tr>
                                       <th>N°.</th>
                                       <th>Frente origen</th>
                                       <th>Frente destino</th>
                                       <th>Receptor</th>
                                       <th>Destino</th>
                                       <th>Fecha</th>
                                       <th style="text-align: center;">Anulado</th>
                                       <th style="text-align: center;">Borrador</th>
                                       <th colspan="3">&nbsp;</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   <tr v-for="(remito, k) in remitos.data" :key="k">
                                       <td>{{ remito.prefijo_formateado }}-{{ remito.numero_formateado }}</td>
                                       <td>{{ remito.frente_origen.codigo }}</td>
                                       <td>{{ remito.frente_destino.codigo }}</td>
                                       <td>{{ remito.receptor }}</td>
                                       <td>{{ remito.destino }}</td>
                                       <td>{{ remito.fecha }}</td>
                                       <td style="text-align: center;">
                                           <app-icon v-if="remito.aunulado_sn === 1" img="check" color="black"></app-icon>
                                       </td>
                                       <td style="text-align: center;">
                                           <app-icon v-if="remito.borrador_sn === 1" img="check" color="black"></app-icon>
                                       </td>
                                       <td width="10px">
                                            <button @click="editRemito(k)" class="btn btn-warning btn-sm" title="Editar" 
                                            :disabled="!$can('T_remitos_edita') || remito.borrador_sn === 0">
                                                <span class="fa fa-edit"></span>
                                            </button>
                                        </td>
                                        <td width="10px">
                                            <button @click="AsignacionR(k)" class="btn btn-default btn-sm" title="EEP" :disabled="!$can('T_remitos_edita') || remito.borrador_sn === 0">
                                                <span class="fas fa-clipboard"></span>
                                            </button>
                                        </td>
                                       <td v-if="remito.interno_sn" width="10px"> 
                                           <a :href="'/pdf/remito/' + remito.id" target="_blank" class="btn btn-default btn-sm" title="Informe"><span class="fa fa-file-pdf-o"></span></a>
                                       </td>
                                       <td v-else width="10px"> 
                                           <a :href="'/pdf/remito/' + remito.id" target="_blank" class="btn btn-default btn-sm" title="Imprimir"><span class="fa fa-print"></span></a>
                                       </td>
                                       <td width="10px" v-if="remito.aunulado_sn !== 1" style="text-align: center;">
                                            <button @click="confirmarAnulacion(remito)" class="btn btn-default btn-sm" title="Anular" 
                                                :disabled="!$can('T_remitos_edita') || remito.borrador_sn === 1">
                                                <app-icon img="remove" color="black"></app-icon>
                                            </button>
                                        </td>
                                        <td v-else width="10px" style="text-align: center;">
                                            <button @click="confirmarDesanulacion(remito)" class="btn btn-default btn-sm" title="Desanular" 
                                                :disabled="!$can('T_remitos_edita') || remito.borrador_sn === 1">
                                                <app-icon img="check" color="black"></app-icon>
                                            </button>
                                        </td>
                                   </tr>
                               </tbody>
                           </table>
                       </div>
                       <pagination :data="remitos" @pagination-change-page="getResults">
                           <span slot="prev-nav">&lt; Previous</span>
                           <span slot="next-nav">Next &gt;</span>
                       </pagination>
                   </div>
               </div>
           </div>
       </div>
       <confirmar-modal></confirmar-modal>
    </div>
   </template>
<script>
import {mapState} from 'vuex'
import { eventModal } from '../event-bus';
export default {

  data () { return {

      remitos :{},
      search: '',

    }
  },

  created : function() {

    this.getResults();
    eventModal.$on('confirmar_accion', (accion,remito) => {
      switch (accion) {
        case 'anular':
          this.anularRemito(remito);
          break;
        case 'desanular':
          this.desanularRemito(remito);
          break;
        default:
          break;
      }
    });

  },

  computed :{

       ...mapState(['url'])
     },

 methods : {
        confirmarAnulacion(remito) {

        eventModal.$emit('abrir_confirmar_accion', 'Está seguro que quiere anular el remito N° ' + remito.prefijo_formateado +'-'+ remito.numero_formateado + ' ?', 'anular',remito);
        },
        confirmarDesanulacion(remito) {

        eventModal.$emit('abrir_confirmar_accion', 'Está seguro que quiere desanular el remito N° ' + remito.prefijo_formateado +'-'+ remito.numero_formateado + ' ?', 'desanular',remito);
        },
        getResults(page = 1) {
            axios.defaults.baseURL = this.url;
            let urlRegistros = `remitos/paginate?page=${page}&search=${encodeURIComponent(this.search)}`;
            axios.get(urlRegistros).then(response => {
                this.remitos = response.data;
            });
        },

    anularRemito(remito) {
        console.log('Anulando remito:', remito);
        const url = `/remitos/${remito.id}/anular`;
        axios.get(url)
        .then(response => {
            toastr.success(`Anulando remito N°${remito.prefijo_formateado}-${remito.numero_formateado}`);
            this.getResults();
        })
        .catch(error => {
            console.error('Error al anular remito:', error.config);
            toastr.error(message);
        });
        },
    desanularRemito(remito) {
            console.log('desanular Remito :', remito);
            const url = `/remitos/${remito.id}/desanular`;
            axios.get(url)
            .then(response => {

                toastr.success(`Desanulado remito N°${remito.prefijo_formateado}-${remito.numero_formateado}`);

                this.getResults();
            })
            .catch(error => {

                toastr.error("Hubo un error al desanular el informe:", error.response);

            });
        },

    editRemito : function(index){

        window.location.href =  '/area/enod/remito/' + this.remitos.data[index].id +'/edit'

    },
    AsignacionR : function(index){
        
        window.location.href =  '/area/enod/asignacion-remito/' + this.remitos.data[index].id

    }
 }
}
</script>
