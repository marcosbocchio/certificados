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
              <div class="col-md-1 text-center">
                <input
                    class="form-check-input"
                    type="checkbox" 
                    v-model="operador.selectAll" 
                    @change="toggleSelectAll(operador)" 
                />
              </div>
              <div class="col-md-1">
                
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
                        <th class="text-center col-md-2">Responsabilidad</th>
                        <th class="text-center col-md-1">Entrada</th>
                        <th class="text-center col-md-1">Salida</th>
                        <th class="text-center col-md-2">Hora Extra</th>
                        <th class="text-center col-md-2">SDF</th>
                        <th class="text-center col-md-1">Pagar</th>
                        <td class="text-center col-md-1"><b>No Pagar</b></td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="detalle in operador.detalles" :key="detalle.fecha">
                        <td class="text-center">{{ detalle.fecha }}</td>
                        <td class="text-center">{{ detalle.ayudante_sn }}</td>
                        <td class="text-center">{{ detalle.entrada }}</td>
                        <td class="text-center">{{ detalle.salida }}</td>
                        <td class="text-center">{{ detalle.hora_extra_sn }}</td>
                        <td class="text-center">{{ detalle.s_d_f_sn }}</td>
                        <td class="text-center">
                            <input 
                                type="checkbox" 
                                v-model="detalle.selected"
                                @change="handleSelectionChange(detalle, operador)" 
                            />
                        </td>
                        <td class="text-center">
                            <input 
                                type="checkbox" 
                                v-model="detalle.no_pagar"
                                @change="handleNoPagarChange(detalle, operador)" 
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
      fechaSeleccionada: '',
      feriados: [] // Lista de feriados cargada  // Fecha seleccionada en el modal
    };
  },
  mounted() {
    // Obtener feriados al montar el componente con el año actual
    const yearActual = new Date().getFullYear();
    this.obtenerFeriados(yearActual);
  },
  watch: {
    // Escuchar los cambios en la selección de fecha y actualizar feriados si cambia el año
    fecha(newFecha) {
      const year = new Date(newFecha).getFullYear();
      this.obtenerFeriados(year); // Volver a obtener feriados con el nuevo año
      this.fetchAsistencia(); // Refrescar los datos de asistencia
    },
    frente_selected: 'fetchAsistencia' // Refrescar asistencia si cambia el frente
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
                                collapsed: false
                            };
                        }
                        result[operadorId].detalles.push({
                          fecha: item.fecha,
                          ayudante_sn: detalle.ayudante_sn === 0 ? 'Ayudante' : 'Operador',
                          id: detalle.asistencia_horas_id,
                          tipo_dia: this.determinarTipoDeDia(item.fecha), // Determinar tipo de día
                          entrada: detalle.entrada || '-',
                          salida: detalle.salida || '-',
                          hora_extra_sn: detalle.hora_extra_sn === 1 ? 'Pagar' : 'No Pagar',

                          // Comprobación simplificada para 'Domingo o Feriado'
                          s_d_f_sn: detalle.s_d_f_sn === 1 
                                              ? (this.determinarTipoDeDia(item.fecha) === 'Sábado' 
                                                  ? 'Pagar Sábado' 
                                                  : (this.determinarTipoDeDia(item.fecha) === 'Domingo o Feriado' 
                                                      ? 'Pagar D/F' 
                                                      : 'No Pagar')) 
                                              : 'No Pagar',
                          selected: false,
                          no_pagar:false,
                        });
                        console.log('------', result);
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
async obtenerFeriados(year) {
      try {
        const response = await axios.get(`/api/asistencia/getferiados/${year}`);
        this.feriados = response.data;
      } catch (error) {
        console.error('Error al obtener los feriados:', error);
      }
    },
  
    esFeriado(fecha) {
      const fechaSeleccionada = new Date(fecha + 'T00:00:00'); // Establecer la hora a medianoche
      const dia = fechaSeleccionada.getDate();
      const mes = fechaSeleccionada.getMonth() + 1;
      const anio = fechaSeleccionada.getFullYear();
      const fechaFormateada = `${anio}-${('0' + mes).slice(-2)}-${('0' + dia).slice(-2)}`;

      return this.feriados.includes(fechaFormateada); // Verificar si es feriado
    },

    esFinDeSemana(fecha) {
      const diaSemana = new Date(fecha).getDay(); // 6 = domingo, 5 = sábado
      return diaSemana === 5 || diaSemana === 6; // Retorna true si es sábado o domingo
    },

    determinarTipoDeDia(fecha) {
      const diaSemana = new Date(fecha).getDay(); // 6 = domingo, 5 = sábado

      if (this.esFeriado(fecha) || diaSemana === 6) {
        return 'Domingo o Feriado'; // Agrupamos domingo y feriado
      } else if (diaSemana === 5) {
        return 'Sábado'; // Mantener sábado separado
      } else {
        return 'Día laboral'; // Día de semana
      }
    },
guardarPagos() {
    // Log de los datos seleccionados para pagar
    const datosPagos = this.operadores.flatMap(operador =>
        operador.detalles
        .filter(detalle => detalle.selected || detalle.no_pagar) // Solo detalles seleccionados
            .map(detalle => ({
                asistencia_horas_id: detalle.id,
                operador_id: operador.operador.id,
                // Agregar la lógica para pagar o no pagar
                pago_e_sdf: detalle.no_pagar ? null : this.fechaSeleccionada, // Si no es para pagar, se deja null
                no_pagar: detalle.no_pagar ? 1 : 0 // Pasar el estado de no pagar
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
        // Aplicar el valor de selectAll a cada detalle
        operador.detalles.forEach(detalle => {
            detalle.selected = operador.selectAll;
        });
    },

    toggleSelectAll(operador) {
        operador.detalles.forEach(detalle => {
            detalle.selected = operador.selectAll;
            detalle.no_pagar = false; // Desmarcar "No Pagar" si se seleccionan todos
        });
    },
    handleSelectionChange(detalle, operador) {
        if (detalle.selected) {
            detalle.no_pagar = false; // Desmarcar "No Pagar" si se selecciona
            operador.selectAll = false; // Desmarcar "Pagar Todos"
        }
    },
    handleNoPagarChange(detalle, operador) {
        if (detalle.no_pagar) {
            detalle.selected = false; // Desmarcar seleccionado si se elige "No Pagar"
            operador.selectAll = false; // Desmarcar "Pagar Todos"
        }
    },
    checkIfAllSelected(operador) {
        operador.selectAll = operador.detalles.every(detalle => detalle.selected);
    }
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
