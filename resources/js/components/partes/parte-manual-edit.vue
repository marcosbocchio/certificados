<template>
  <div class="row">
    <div class="col-md-12">
      <form @submit.prevent="storeSection">
        <div class="box box-custom-enod">
          <div class="box-body">
            <div class="form-group col-md-3">
              <label>Fecha *</label>
              <date-picker v-model="fecha" value-type="YYYY-MM-DD" :disabled-date="disabledDate" format="DD-MM-YYYY" placeholder="DD-MM-YYYY"></date-picker>
            </div>
            <div class="form-group col-md-3">
              <label>Cliente *</label>
              <input type="text" v-model="cliente" class="form-control" disabled>
            </div>
            <div class="form-group col-md-3">
              <label>Proyecto *</label>
              <input type="text" v-model="proyecto" class="form-control" disabled>
            </div>
            <div class="form-group col-md-3">
              <label>Orden de Trabajo N° *</label>
              <input type="text" v-model="ordenTrabajo" class="form-control" disabled>
            </div>
          </div>
        </div>

        <div class="box box-custom-enod">
          <div class="box-header">
            <h3 class="box-title">Detalles de Parte Manual</h3>
          </div>
          <div class="box-body">
            <div class="form-row">
              <div class="form-group col-md-3">
                <label for="tecnica">Técnica *</label>
                <v-select v-model="detalle.tecnica" :options="opcionesTecnica"></v-select>
              </div>
              <div class="form-group col-md-3">
                <label for="cantidad">Cantidad *</label>
                <input type="number" v-model="detalle.cantidad" class="form-control" min="0">
              </div>
              <div class="form-group col-md-3">
                <label>Planta *</label>
                <v-select v-model="detalle.planta" :options="opcionesPlanta" multiple :max="2"></v-select>
              </div>
              <div class="form-group col-md-3">
                <label for="equipo_linea">Equipo/Linea *</label>
                <input type="text" v-model="detalle.equipo_linea" class="form-control" maxlength="60">
              </div>

              <div class="clearfix"></div>

              <div class="form-group col-md-3">
                <label for="horario">Horario *</label>
                <v-select v-model="detalle.horario" :options="opcionesHorarios" label="label" :reduce="horario => horario.value"></v-select>
              </div>
              <div class="form-group col-md-3">
                <label for="n_informe">N° Informe *</label>
                <input type="text" v-model="detalle.n_informe" class="form-control" maxlength="18">
              </div>
              <div class="form-group col-md-3">
                <label>Operadores *</label>
                <v-select v-model="detalle.operadores"
                  :options="opcionesOperadores"
                  multiple
                  :max="2">
                </v-select>
              </div>
              <div class="form-group col-md-3">
                <label>Inspector *</label>
                <v-select v-model="detalle.inspector_secl" :options="inspectores_op" label="name" multiple :max="2"></v-select>
              </div>
              <div class="clearfix"></div>
              <div class="form-group col-md-3 boton-centrado">
                <label></label>
                <button type="button" @click="agregarDetalle"><span class="fa fa-plus-circle"></span></button>
              </div>
            </div>
            
            <div class="form-row">
              <div class="col-md-12">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Técnica</th>
                      <th>Cantidad</th>
                      <th>Planta</th>
                      <th>Equipo/Linea</th>
                      <th>Horario</th>
                      <th>N° Informe</th>
                      <th>Operadores</th>
                      <th>Inspector</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(detalle, index) in detalles" :key="index">
                      <td>{{ detalle.tecnica }}</td>
                      <td>{{ detalle.cantidad }}</td>
                      <td>
                        {{ detalle.planta[0]?.value }}{{ detalle.planta[1] ? ' / ' + detalle.planta[1].value : '' }}
                      </td>
                      <td>{{ detalle.equipo_linea }}</td>
                      <td>{{ detalle.horario }}</td>
                      <td>{{ detalle.n_informe }}</td>
                      <td>
                        {{ detalle.operadores[0]?.label }}{{ detalle.operadores[1] ? ' / ' + detalle.operadores[1].label : '' }}
                      </td>
                      <td>
                        {{ detalle.inspector_secl[0]?.name }}{{ detalle.inspector_secl[1] ? ' / ' + detalle.inspector_secl[1].name : '' }}
                      </td>
                      <td>
                        <a @click="quitarDetalle(index)"><app-icon img="minus-circle" color="black"></app-icon></a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="box box-custom-enod">
          <div class="box-header">
            <h3 class="box-title">Informes sin Parte</h3>
          </div>
          <div class="box-body">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Check</th>
                  <th>Tipo</th>
                  <th>Informe</th>
                  <th>Obra</th>
                  <th>Planta</th>
                  <th>Fecha</th>
                  <th>Solicitante</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(informe, index) in informesConParte" :key="informe.id">
                  <td><input type="checkbox" v-model="informe.selected" @click="actualizarNumeroInforme(informe)" /></td>
                  <td>{{ informe.metodo }}</td>
                  <td>{{ formatearNumero(informe.metodo, informe.numero) }}</td>
                  <td>{{ informe.obra }}</td>
                  <td>{{ informe.nombre_planta }}</td>
                  <td>{{ informe.fecha_formateada }}</td>
                  <td>{{ informe.solicitante }}</td>
                </tr>
                <tr v-for="(informe, index) in informesSinParte" :key="informe.id">
                  <td><input type="checkbox" v-model="informe.selected" @click="actualizarNumeroInforme(informe)" /></td>
                  <td>{{ informe.metodo }}</td>
                  <td>{{ formatearNumero(informe.metodo, informe.numero) }}</td>
                  <td>{{ informe.obra }}</td>
                  <td>{{ informe.nombre_planta }}</td>
                  <td>{{ informe.fecha_formateada }}</td>
                  <td>{{ informe.solicitante }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <button type="submit" class="btn btn-primary" :disabled="isSaving" ref="saveButton">Guardar</button>
      </form>
    </div>
  </div>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import axios from 'axios';
import { Toast } from 'bootstrap';

export default {
  name: "ParteManualComponent",
  props: {
  // Objeto parteManual
  parte_manual_data: {
    type: Object,
    required: true
  },
  // Fecha como string
  fecha_data: {
    type: String,
    required: true
  },
  // Objeto ot
  ot_data: {
    type: Object,
    required: true
  },
  // Objeto cliente
  cliente_data: {
    type: Object,
    required: true
  },
  // Nombre del cliente como string
  cliente_nombre_data: {
    type: String,
    required: true
  },
  // Proyecto como string
  proyecto_data: {
    type: String,
    required: true
  },
  // Número de orden de trabajo como string
  orden_de_trabajo_data: {
    type: String,
    required: true
  },
  // Detalles como array de objetos
  detalles_data: {
    type: Array,
    required: true
  },
  // Plantas como array de objetos
  plantas_data: {
    type: Array,
    required: true
  },
  inspectores_op:{
    type: Array,
    required: true
  },
  operadores_data:{
  type: Array,
  required: true
}
},
  components: {
    DatePicker,
    'v-select': vSelect
  },
  data() {
    return {
      editMode: false,
      fecha: '',
      cliente: this.cliente_nombre_data,
      proyecto: this.proyecto_data,
      ordenTrabajo: this.ot_data.numero,
      informesConParte:[],
      informesSinParte: [],
      detalles: [],
      opcionesPlanta: this.plantas_data.map(planta => ({ label: planta.codigo, value: planta.codigo })),
      opcionesOperadores: this.operadores_data.map(operador => ({ label: operador.nombre, value: operador.id})),
      inspectores_op: this.inspectores_op.map(inspector => ({ label: inspector.name, value: inspector.id })),
      ot: this.ot_data,
      opcionesHorarios: [
      { value: 'A', label: 'LUNES A VIERNES 7 - A 16.30 HS' },
      { value: 'B', label: 'LUNES A VIERNES 7 - A 19HS' },
      { value: 'C', label: 'SAB. - DOM. - FERIADOS - 7 A 19 HS' },
      { value: 'D', label: 'LUNES A DOM. - HORARIO NOCTURNO' }
    ],
      isSaving: false,
      detalle: {
        tecnica: '',
        cantidad: 0,
        planta: [],
        equipo_linea: '',
        horario: '',
        n_informe: '',
        inspector_secl:[],
        operadores: []
      },
      opcionesTecnica: ['CR', 'ADM', 'LP', 'PM', 'PMI', 'RG', 'US', 'US-AT', 'US-N2', 'US-PHA', 'DU', 'RM', 'TT'],
    };
  },
  mounted() {
    this.editMode = this.ot ? true : false;
    if (this.fecha) {
      this.cargarInformesSinParte();
    }
    this.cargarInformesConParte();
    this.pushDetalles();
    this.fecha = this.fecha_data;
  },
  watch: {
    fecha(newValue) {
      if (newValue) {
        this.cargarInformesSinParte();
      }
    },
  },
  methods: {
    disabledDate(time) {
      return time.getTime() > Date.now();
    },
    obtenerLabelOperador(operador) {
    return operador ? operador.label : '-';
  },
    buscarNombreOperador(idOperador) {
    const operador = this.opcionesOperadores.find(operador => operador.id === idOperador);
    return operador ? operador.nombre : '';
    },
    formatearNumero(metodo, numero) {
      const numeroFormateado = numero.toString().padStart(4, '0');
      return `${metodo}${numeroFormateado}`;
    },
    saveOrUpdate() {
      if (this.editMode) {
        this.updateSection();
      } else {
        this.storeSection();
      }
    },
    agregarDetalle() {
      if (this.validarDetalle()) {
        this.detalles.push({ ...this.detalle });
        console.log('detalles:', this.detalle);
        this.resetDetalle();
      }
    },
    pushDetalles() {
    // Recorrer el array detalles_data
    this.detalles_data.forEach(detalle => {
    const operador1Id = parseInt(detalle.operador1, 10);
    const operador2Id = parseInt(detalle.operador2, 10);
    
    const operador1 = this.obtenerNombreOperador(operador1Id);
    const operador2 = this.obtenerNombreOperador(operador2Id);
    const inspector1 = this.obtenerNombreInspector(detalle.inspector_id_1);
    const inspector2 = this.obtenerNombreInspector(detalle.inspector_id_2);

  // Crear un nuevo objeto para el detalle con los nombres actualizados
  const nuevoDetalle = {
    tecnica: detalle.tecnica,
    cantidad: detalle.cantidad,
    planta: [{ value: detalle.planta_1 },{ value: detalle.planta_2 }],
    equipo_linea: detalle.equipo,
    horario: detalle.horario,
    n_informe: detalle.informe_nro,
    inspector_secl: [inspector1,inspector2],
    operadores: [operador1, operador2]
  };

  console.log('__',nuevoDetalle,'__');
  this.detalles.push(nuevoDetalle);
});
  },
    actualizarNumeroInforme(informe) {
      if (informe.selected) {
        const numeroFormateado = this.formatearNumero(informe.metodo, informe.numero);
        this.detalle.n_informe = this.detalle.n_informe.replace(new RegExp(numeroFormateado + '\\s*/?\\s*'), '');
      } else {
        const numeroFormateado = this.formatearNumero(informe.metodo, informe.numero);
        if (!this.detalle.n_informe.includes(numeroFormateado)) {
          if (this.detalle.n_informe.length > 0) {
            this.detalle.n_informe += ` / ${numeroFormateado}`;
          } else {
            this.detalle.n_informe = numeroFormateado;
          }
        }
      }
      if (this.detalle.n_informe.length > 200) {
        this.detalle.n_informe = this.detalle.n_informe.substring(0, 200);
      }
    },
    validarDetalle() {
  // Validación para la técnica
  if (!this.detalle.tecnica) {
    this.mostrarToast('Por favor, completa el campo "Técnica".', 'error');
    return false;
  }

  // Validación para la cantidad
  if (this.detalle.cantidad <= 0) {
    this.mostrarToast('La cantidad debe ser mayor que cero.', 'error');
    return false;
  }

  // Validación para las plantas
  if (!this.detalle.planta || this.detalle.planta.length === 0) {
    this.mostrarToast('Por favor, selecciona al menos una planta.', 'error');
    return false;
  } else if (this.detalle.planta.length > 2) {
    this.mostrarToast('No puedes seleccionar más de dos plantas.', 'error');
    return false;
  }

  // Validación para los inspectores
  if (!this.detalle.inspector_secl || this.detalle.inspector_secl.length === 0) {
    this.mostrarToast('Por favor, selecciona al menos un inspector.', 'error');
    return false;
  } else if (this.detalle.inspector_secl.length > 2) {
    this.mostrarToast('No puedes seleccionar más de dos inspectores.', 'error');
    return false;
  }

  // Validación para los operadores
  if (!this.detalle.operadores || this.detalle.operadores.length === 0) {
    this.mostrarToast('Debes seleccionar al menos un operador.', 'error');
    return false;
  } else if (this.detalle.operadores.length > 2) {
    this.mostrarToast('No puedes seleccionar más de dos operadores.', 'error');
    return false;
  }

  return true; // Si no hay errores, retornar true
},
    quitarDetalle(index) {
      this.detalles.splice(index, 1);
    },
    resetDetalle() {
      this.detalle = {
        tecnica: '',
        cantidad: '',
        planta: '',
        equipo_linea: '',
        horario: '',
        n_informe: '',
        operadores: []
      };
    },
    obtenerNombreOperador(id) {
    // Buscar el operador en opcionesOperadores
    const operadorEncontrado = this.opcionesOperadores.find(operador => operador.value === id);
    
    // Verificar si se encontró el operador
    if (operadorEncontrado) {
      // Devolver el nombre del operador
      return operadorEncontrado;
    } else {
      // Devolver un mensaje indicando que el operador no se encontró
      return 'Operador no encontrado';
    }
  },
    obtenerNombreInspector(id) {
    // Buscar el operador en opcionesOperadores
    const inspectorEncontrado = this.inspectores_op.find(inspector => inspector.id === id);
    console.log('inspector:',inspectorEncontrado);
    // Verificar si se encontró el operador
    if (inspectorEncontrado) {
      // Devolver el nombre del operador
      return inspectorEncontrado;
    } else {
      // Devolver un mensaje indicando que el operador no se encontró
      return 'inspector no encontrado';
    }
  },
  storeSection() {
    this.isSaving = true;
    const data = {
        fecha: this.fecha,
        ot: this.ot_data.id,
        cliente: this.cliente,
        proyecto: this.proyecto,
        ordenTrabajo: this.ordenTrabajo,
        detalles: this.detalles,
        ot_obra: this.ot.obra ?? '-',
        selectedInformes: this.informesSinParte.filter(informe => informe.selected).map(informe => informe.id),
        deselectedInformes: this.informesConParte.filter(informe => !informe.selected).map(informe => informe.id)  // Nueva línea
    };

    axios.put(`/api/partes-manuales/${this.parte_manual_data.id}`, data)
        .then(response => {
            console.log('Datos actualizados exitosamente', response);
            window.open('/pdf-partemanual/' + this.parte_manual_data.id, '_blank');
            window.location.href = '/partes/ot/' + this.ot_data.id, '_blank';
        })
        .catch(error => {
            console.error('Error al actualizar los datos:', error);
            this.isSaving = false;
            let errorMessage = 'Error desconocido';
            if (error.response && error.response.data && error.response.data.message) {
                errorMessage = error.response.data.message;
            } else if (error.message) {
                errorMessage = error.message;
            }
            this.mostrarToast('Error al actualizar: ' + errorMessage, 'error');
        });
},
    mostrarToast(mensaje, tipo) {
  if (tipo === 'success') {
    toastr.success(mensaje);
  } else if (tipo === 'error') {
    toastr.error(mensaje);
  } else if (tipo === 'warning') {
    toastr.warning(mensaje);
  }
},
cargarInformesSinParte() {
      axios.get(`/api/informes-sin-parte?ot_id=${this.ot_data.id}&hasta=${this.fecha}`)
        .then(response => {
          this.informesSinParte = response.data.map(informe => ({
            ...informe,
            selected: false
          }));
          console.log('noparte',this.informesSinParte); 
        })
        .catch(error => {
          if (error.response && error.response.data && error.response.data.message) {
            this.mostrarToast('Error al cargar los informes sin parte: ' + error.response.data.message, 'error');
          } else if (error.request) {
            this.mostrarToast('No se recibió respuesta al cargar los informes sin parte', 'error');
          } else {
            this.mostrarToast('Error al cargar los informes sin parte: ' + error.message, 'error');
          }
          console.log(error.config);
        });
    },
    cargarInformesConParte() {
    const url = `/api/informes-con-parte?parte_id=${this.parte_manual_data.id}&ot_id=${this.ot_data.id}`;
    axios.get(url)
        .then(response => {
            this.informesConParte = response.data.map(informe => ({
                ...informe,
                selected: true  // Marcamos todos los informes como seleccionados
            }));
            console.log('Informes con parte:', this.informesConParte);
        })
        .catch(error => {
            console.error('Error al cargar los informes con parte:', error);
            this.mostrarToast('Error al cargar los informes: ' + error.message, 'error');
        });
}
  }
}
</script>

<style>
  .boton-centrado {
    display: flex;
    align-items: center;
    height: 100%;
  }
</style>