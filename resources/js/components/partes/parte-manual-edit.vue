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
                <label>Técnica *</label>
                <v-select
                  v-model="detalle.tecnica"
                  :options="opcionesTecnica"
                  multiple
                  :max="2"
                ></v-select>
              </div>
              <div class="form-group col-md-3">
                <label>Cantidad *</label>
                <div class="input-group">
                  <input
                    type="number"
                    v-model.number="tempCantidad"
                    class="form-control"
                    max="9999"
                    :disabled="detalle.cantidad.length >= 2"
                  />
                    <button
                      type="button"
                      class=" btn"
                      @click="agregarCantidad"
                      :disabled="!tempCantidad || detalle.cantidad.length >= 2"
                    >
                      <span class="fa fa-plus-circle" aria-hidden="true"></span>
                    </button>
                </div>
                <div v-if="detalle.cantidad.length" class="mt-2">
                  <small v-for="(c, index) in detalle.cantidad"
                      :key="index"
                      class="tag-cantidad"
                      @click="removerCantidad(index)"
                      title="Haga clic para eliminar">
                      {{ c }}
                  </small>
                </div>
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
                  <td>
                    {{ detalle?.tecnica1 }}{{ detalle.tecnica2 ? ' / ' + detalle.tecnica2 : '' }}
                  </td>
                  <td>
                    {{ detalle?.cantidad1 }}{{ detalle.cantidad2 ? ' / ' + detalle.cantidad2 : '' }}
                  </td>
                  <td>
                    {{ detalle.planta[0]?.value }}{{ detalle.planta[1] ? ' / ' + detalle.planta[1].value : '' }}
                  </td>
                  <td>{{ detalle.equipo_linea }}</td>
                  <td>{{ detalle.horario }}</td>
                  <td>{{ detalle.n_informe }}</td>
                  <td>
                    {{ detalle.operadores[0]?.label }}{{ detalle.operadores[1] ? ' / ' + detalle.operadores[1]?.label : '' }}
                  </td>
                  <td>
                    {{ detalle.inspector_secl[0]?.name }}{{ detalle.inspector_secl[1] ? ' / ' + detalle.inspector_secl[1]?.name : '' }}
                  </td>
                  <td>
                    <a @click="quitarDetalle(index)">
                      <app-icon img="minus-circle" color="black"></app-icon>
                    </a>
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
      tempCantidad: null,
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
        tecnica: [],
        cantidad: [],
        planta: [],
        equipo_linea: "",
        horario: "",
        n_informe: "",
        operadores: [],
        inspector_secl: []
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
  agregarCantidad() {
    if (this.tempCantidad && this.tempCantidad > 0 && this.tempCantidad <= 9999 && this.detalle.cantidad.length < 2) {
        this.detalle.cantidad.push(this.tempCantidad);
        this.tempCantidad = null;
    } else if (this.tempCantidad && this.tempCantidad > 9999) {
        // Mostrar un mensaje de error si la cantidad supera los 4 dígitos
        toastr.error('No se pueden agregar números de más de 4 dígitos.');
        this.tempCantidad = null;  // Limpiar el campo de entrada
    }
},
    removerCantidad(index) {
      this.detalle.cantidad.splice(index, 1);
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
  if (!this.validarDetalle()) {
    return;
  }
  // Convertir los arrays en propiedades individuales que usa la tabla
  const nuevoDetalle = {
    tecnica1: this.detalle.tecnica[0] || '',
    tecnica2: this.detalle.tecnica[1] || '',
    cantidad1: this.detalle.cantidad[0] || '',
    cantidad2: this.detalle.cantidad[1] || '',
    planta: this.detalle.planta,
    equipo_linea: this.detalle.equipo_linea,
    horario: this.detalle.horario,
    n_informe: this.detalle.n_informe,
    operadores: this.detalle.operadores,
    inspector_secl: this.detalle.inspector_secl
  };

  this.detalles.push(nuevoDetalle);
  this.resetDetalle();
},
resetDetalle() {
  this.detalle = {
    tecnica: [],
    cantidad: [],
    planta: [],
    equipo_linea: "",
    horario: "",
    n_informe: "",
    operadores: [],
    inspector_secl: []
  };
  this.tempCantidad = null;
}
,
    pushDetalles() {
  this.detalles_data.forEach(detalle => {
    const operador1Id = parseInt(detalle.operador1, 10);
    const operador2Id = parseInt(detalle.operador2, 10);

    const operador1 = this.obtenerNombreOperador(operador1Id);
    const operador2 = this.obtenerNombreOperador(operador2Id);
    const inspector1 = this.obtenerNombreInspector(detalle.inspector_id_1);
    const inspector2 = detalle.inspector_id_2 ? this.obtenerNombreInspector(detalle.inspector_id_2) : null;

    const nuevoDetalle = {
      tecnica1: detalle.tecnica_1 || '',
      tecnica2: detalle.tecnica_2 || '',
      cantidad1: detalle.cantidad_1 || '',
      cantidad2: detalle.cantidad_2 || '',
      planta: [
        { value: detalle.planta_1 },
        ...(detalle.planta_2 ? [{ value: detalle.planta_2 }] : [])
      ],
      equipo_linea: detalle.equipo,
    horario: detalle.horario,
    n_informe: detalle.informe_nro,
    inspector_secl: [inspector1,inspector2],
    operadores: [operador1, operador2]
    };

    console.log('__', nuevoDetalle, '__');
    this.detalles.push(nuevoDetalle);
  });
}
,
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
      const errores = [];
      if (!this.detalle.tecnica || this.detalle.tecnica.length === 0) {
        errores.push("Por favor, selecciona al menos una técnica.");
      } else if (this.detalle.tecnica.length > 2) {
        errores.push("No puedes seleccionar más de dos técnicas.");
      }
      if (!this.detalle.cantidad || this.detalle.cantidad.length === 0) {
        errores.push("Por favor, ingresa al menos una cantidad.");
      } else if (this.detalle.cantidad.length > 2) {
        errores.push("No puedes ingresar más de dos cantidades.");
      } else {
        this.detalle.cantidad.forEach(c => {
          let num = parseFloat(c);
          if (isNaN(num) || num <= 0) {
            errores.push("Cada cantidad debe ser un número mayor que cero.");
          }
        });
      }
      if (!this.detalle.planta || this.detalle.planta.length === 0) {
        errores.push("Por favor, selecciona al menos una planta.");
      } else if (this.detalle.planta.length > 2) {
        errores.push("No puedes seleccionar más de dos plantas.");
      }
      if (!this.detalle.equipo_linea)
        errores.push("Por favor, ingresa el equipo o línea.");
      if (!this.detalle.horario)
        errores.push("Por favor, selecciona un horario.");
      if (!this.detalle.n_informe)
        errores.push("Por favor, ingresa el número de informe.");
      if (
        !this.detalle.inspector_secl ||
        this.detalle.inspector_secl.length === 0
      ) {
        errores.push("Por favor, selecciona al menos un inspector.");
      } else if (this.detalle.inspector_secl.length > 2) {
        errores.push("No puedes seleccionar más de dos inspectores.");
      }
      if (this.detalle.operadores.length === 0) {
        errores.push("Debes seleccionar al menos un operador.");
      } else if (this.detalle.operadores.length > 2) {
        errores.push("No puedes seleccionar más de dos operadores.");
      }
      errores.forEach(error => toastr.error(error));
      return errores.length === 0;
    },
    quitarDetalle(index) {
      this.detalles.splice(index, 1);
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
      return null;
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
      return null;
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
    console.log(this.detalles);
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