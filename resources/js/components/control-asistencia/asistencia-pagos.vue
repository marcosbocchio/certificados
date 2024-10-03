<template>
  <div>
    <!-- Box 1: Frente y Mes -->
    <div class="box box-custom-enod">
      <div class="box-body row">
        <div class="col-md-3">
          <div class="form-group">
            <label for="frente">Frente *</label>
            <v-select 
              v-model="frente_selected" 
              :options="frentes" 
              label="codigo" 
              id="frente"  
              @change="fetchAsistencia"
            ></v-select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="fecha">Mes *</label>
            <date-picker 
              id="fecha" 
              v-model="fecha" 
              type="month"  
              value-type="YYYY-MM"  
              format="MM-YYYY"  
            >
            </date-picker>
          </div>
        </div>
      </div>
    </div>

    <!-- Tabla de operadores -->
    <div v-for="operador in operadores" :key="operador.operador.id" class="box box-custom-enod">
      <div class="box-header with-border">
        <div class="row">
          <button class="btn btn-box-tool pull-right col-md-1" @click="operador.collapsed = !operador.collapsed">
              <i v-if="operador.collapsed" class="fas fa-plus"></i>
              <i v-else class="fas fa-minus"></i>
          </button>
        </div>
        <div class="container-fluid">
          <div class="row">
            
              <h3 class="box-title col-md-10" style="cursor: pointer; white-space: nowrap;">
                  <strong>{{ operador.operador.name }}</strong>
              </h3>
              <!-- Checkbox a la derecha -->
              <div class="col-md-2 text-center">
                <input
                    class="form-check-input"
                    type="checkbox" 
                    v-model="operador.selectAll" 
                    @change="toggleSelectAll(operador)" 
                />
              </div>
          </div>
        </div>
      </div>

    <div class="box-body" v-show="!operador.collapsed">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-condensed table-bordered">
                <thead>
                    <tr>
                        <th class="text-center col-md-2">Fecha</th>
                        <th class="text-center col-md-2">Entrada</th>
                        <th class="text-center col-md-2">Salida</th>
                        <th class="text-center col-md-2">Hora Extra</th>
                        <th class="text-center col-md-2">SDF</th>
                        <th class="text-center col-md-2"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="detalle in operador.detalles" :key="detalle.fecha">
                        <td class="text-center">{{ detalle.fecha }}</td>
                        <td class="text-center">{{ detalle.entrada }}</td>
                        <td class="text-center">{{ detalle.salida }}</td>
                        <td class="text-center">{{ detalle.hora_extra_sn }}</td>
                        <td class="text-center">{{ detalle.s_d_f_sn }}</td>
                        <td class="text-center">
                            <input 
                                type="checkbox" 
                                v-model="detalle.selected" 
                            />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>



    <button @click="mostrarPopup = true" class="btn btn-primary">Pagar</button>

    <!-- Pop-up de Selección de Fecha -->
    <div v-if="mostrarPopup" class="modal show" tabindex="-1" role="dialog" style="display: block;">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Seleccionar Fecha de Pago</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="fecha-select">Fecha</label>
              <date-picker
                v-model="fechaSeleccionada"
                value-type="YYYY-MM-DD"
                format="DD-MM-YYYY"
                placeholder="Seleccionar fecha">
              </date-picker>
            </div>
          </div>
          <div class="modal-footer row">
            <div class="col-md-4" style="text-align: left;">
              <button type="button" class="btn btn-secondary" @click="cerrarPopup">Cerrar</button>
            </div>
            <div class="col-md-4">
              <!-- Espacio vacío entre los botones -->
            </div>
            <div class="col-md-4">
              <button type="button" class="btn btn-enod" @click="guardarPagos">Confirmar</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Loader -->
    <loading
      :active.sync="isLoading"
      :loader="'bars'"
      :color="'red'"
    ></loading>
  </div>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import axios from 'axios';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import { toastrInfo,toastrDefault } from '../toastrConfig';

export default {
  components: {
    DatePicker,
    Loading
  },
  props: {
    frentes: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      frente_selected: null,
      fecha: '',
      operadores: [],
      isLoading: false,
      mostrarPopup: false,  // Estado del modal
      fechaSeleccionada: ''  // Fecha seleccionada en el modal
    };
  },
  watch: {
    frente_selected: 'fetchAsistencia',
    fecha: 'fetchAsistencia'
  },
  methods: {
    async fetchAsistencia() {
      if (this.frente_selected) {
        try {
          this.isLoading = true;
          const response = await axios.get('/api/asistencia_pagos', {
            params: {
              frente_id: this.frente_selected.id,
              fecha: this.fecha || null,
            }
          });
          console.log(response.data);
          const asistenciaAgrupada = response.data.reduce((result, item) => {
            item.detalles.forEach(detalle => {
              if (
                (detalle.s_d_f_sn === 1 || detalle.hora_extra_sn === 1) && 
                detalle.pago_e_sdf === null && 
                detalle.no_pagar === null
              ) {
                const operadorId = detalle.operador.id;
                if (!result[operadorId]) {
                  result[operadorId] = {
                    operador: detalle.operador, 
                    detalles: [],
                    selectAll: false,
                    collapsed: false // Inicializar como colapsado
                  };
                }
                result[operadorId].detalles.push({
                  fecha: item.fecha,
                  id: detalle.asistencia_horas_id,
                  entrada: detalle.entrada || '-',
                  salida: detalle.salida || '-',
                  hora_extra_sn: detalle.hora_extra_sn === 1 ? 'S' : 'N',
                  s_d_f_sn: detalle.s_d_f_sn === 1 ? 'S' : 'N',
                  selected: false 
                });
              }
            });
            return result;
          }, {});

          this.operadores = Object.values(asistenciaAgrupada);
        } catch (error) {
          console.error('Error al obtener la asistencia:', error);
        } finally {
          this.isLoading = false;
        }
      }
    },
    guardarPagos() {
    // Log de los datos seleccionados para pagar
    const datosPagos = this.operadores.flatMap(operador =>
        operador.detalles
            .filter(detalle => detalle.selected) // Solo detalles seleccionados
            .map(detalle => ({
                asistencia_horas_id: detalle.id,
                operador_id: operador.operador.id,
                pago_e_sdf: this.fechaSeleccionada
            }))
    );

    // Realiza una llamada a la API para actualizar los pagos
    axios.post('/api/guardar_pagos', { datosPagos })
        .then(response => {
            if (response.data.success) {
                // Muestra un mensaje de éxito
                toastr.success('Pagos guardados exitosamente');
                
                // Llama a fetchAsistencia() para actualizar los datos
                this.fetchAsistencia();
                
                // Cerrar el popup después de guardar
                this.mostrarPopup = false; 
            } else {
                // Muestra un mensaje de error si la respuesta no es exitosa
                toastr.error('Error al guardar los pagos');
            }
        })
        .catch(error => {
            // Muestra un mensaje de error en caso de falla en la llamada a la API
            console.error('Error al guardar los pagos:', error);
            toastr.error('Error al guardar los pagos: ' + error.message);
        });
},
    cerrarPopup() {
      this.mostrarPopup = false; // Cerrar popup sin confirmar
    },
    toggleSelectAll(operador) {
      operador.detalles.forEach(detalle => {
        detalle.selected = operador.selectAll;
      });
    },
  }
};
</script>

<style scoped>
.text-center {
  text-align: center;
}

input[type="checkbox"] {
  margin: auto; /* Para centrar el checkbox en su celda */
}
</style>
