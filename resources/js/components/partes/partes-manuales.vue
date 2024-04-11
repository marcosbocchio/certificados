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
                  <input type="number" v-model="detalle.cantidad" class="form-control">
                </div>
                <div class="form-group col-md-3">
                  <label>Planta *</label>
                  <v-select v-model="detalle.planta" :options="opcionesPlantas"></v-select>
                </div>
                <div class="form-group col-md-3">
                  <label for="equipo_linea">Equipo/Linea *</label>
                  <input type="text" v-model="detalle.equipo_linea" class="form-control">
                </div>

                <div class="clearfix"></div>

                <div class="form-group col-md-3">
                  <label for="horario">Horario *</label>
                  <v-select v-model="detalle.horario" :options="['A', 'B', 'C', 'D']"></v-select>
                </div>
                <div class="form-group col-md-3">
                  <label for="n_informe">N° Informe *</label>
                  <input type="text" v-model="detalle.n_informe" class="form-control">
                </div>
                <div class="form-group col-md-3">
                  <label>Operadores *</label>
                  <v-select 
                    v-model="detalle.operadores" 
                    :options="opcionesOperadores" 
                    multiple 
                    :max="2"
                    placeholder="Selecciona hasta 2 operadores">
                  </v-select>
                </div>
                <div class=" form-group col-md-3 boton-centrado">
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
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(detalle, index) in detalles" :key="index">
                        <td>{{ detalle.tecnica }}</td>
                        <td>{{ detalle.cantidad }}</td>
                        <td>{{ detalle.planta.label }}</td>
                        <td>{{ detalle.equipo_linea }}</td>
                        <td>{{ detalle.horario }}</td>
                        <td>{{ detalle.n_informe }}</td>
                        <td>{{ detalle.operadores[0] }} / {{ detalle.operadores[1] }}</td>
                        <td>
                          <a  @click="quitarDetalle(index)"> <app-icon img="minus-circle" color="black"></app-icon> </a>
                          
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
                    <tr v-for="(informe, index) in informesSinParte" :key="informe.id">
                        <td><input type="checkbox" v-model="informe.selected"/></td>
                        <td>{{ informe.metodo }}</td>
                        <td>{{ formatearNumero(informe.metodo, informe.numero) }}</td>
                        <td>{{ informe.obra }}</td>
                        <td>{{ informe.nombre_planta }}</td>
                        <td>{{ informe.fecha }}</td>
                        <td>{{ informe.solicitante }}</td>
                    </tr>
                </tbody>
            </table>
            </div>
          </div>
            <button type="submit" class="btn btn-primary">Guardar Todo</button>
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
import { Toast } from 'bootstrap'; // Asegúrate de tener bootstrap y sus dependencias.

export default {
  name: "ParteManualComponent",
  props: ['ot_id','cliente', 'proyecto', 'ordenTrabajoNumero', 'plantas', 'operadores'],
  components: {
    DatePicker,
    'v-select': vSelect
  },
  computed: {
  opcionesPlantas() {
    return this.plantas.map(planta => ({ label: `${planta.nombre} (${planta.codigo})`, value: planta }));
  },
  opcionesOperadores() {
    return this.operadores.map(operador => ({ label: operador.name, value: operador }));
  }
},
  data() {
    return {
      fecha: '',
      cliente: this.cliente,
      proyecto: this.proyecto,
      ordenTrabajo: this.ordenTrabajoNumero,
      informesSinParte: [],
      detalles: [],
      opcionesOperadores: this.operadores,
      detalle: {
        tecnica: '',
        cantidad: 0,
        planta: this.plantas,
        equipo_linea: '',
        horario: '',
        n_informe: '',
        operadores: []
      },
      opcionesTecnica: ['CR', 'ADM', 'LP', 'PM', 'PMI', 'RG', 'US', 'US-AT', 'US-N2', 'US-PHA', 'DU', 'RM', 'TT'],
    };
  },mounted() {
    if (this.fecha) {
      this.cargarInformesSinParte();
    }
  },watch: {
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
    formatearNumero(metodo, numero) {
    const numeroFormateado = numero.toString().padStart(4, '0');
    return `${metodo}${numeroFormateado}`;
  },
    agregarDetalle() {
      if (this.validarDetalle()) {
        this.detalles.push({ ...this.detalle });
        this.resetDetalle();
        this.mostrarToast('Detalle agregado correctamente.', 'success');
      }
    },
    validarDetalle() {
      if (!this.detalle.tecnica || this.detalle.cantidad <= 0 || !this.detalle.planta) {
        this.mostrarToast('Por favor, completa todos los campos requeridos.', 'error');
        return false;
      }
      if (this.detalle.operadores.length > 2) {
        this.mostrarToast('No puedes seleccionar más de dos operadores.', 'error');
        return false;
      }
      return true;
    },
    quitarDetalle(index) {
      this.detalles.splice(index, 1);
      this.mostrarToast('Detalle eliminado.', 'warning');
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
    storeSection() {
    // Filtrar los IDs de los informes seleccionados
    const selectedInformes = this.informesSinParte.filter(informe => informe.selected).map(informe => informe.id);

    // Datos a enviar
    const data = {
        fecha: this.fecha,
        cliente: this.cliente,
        proyecto: this.proyecto,
        ordenTrabajo: this.ordenTrabajo,
        detalles: this.detalles,
        selectedInformes: selectedInformes // Agregar los IDs seleccionados
    };

    axios.post('/api/partes-manuales', data)
    .then(response => {
        console.log('Datos guardados exitosamente', response);
        this.mostrarToast('Datos guardados exitosamente.', 'success');
    })
    .catch(error => {
        console.error('Error al guardar los datos.', error);
        let errorMessage = 'Error desconocido';
        if (error.response && error.response.data && error.response.data.message) {
            errorMessage = error.response.data.message;
        } else if (error.message) {
            errorMessage = error.message;
        }
        this.mostrarToast('Error al guardar: ' + errorMessage, 'error');
    });
},
    mostrarToast(mensaje, tipo) {
      const toastEl = document.createElement('div');
      toastEl.classList.add('toast', 'show');
      if (tipo === 'success') {
        toastEl.classList.add('bg-success');
      } else if (tipo === 'error') {
        toastEl.classList.add('bg-danger');
      } else if (tipo === 'warning') {
        toastEl.classList.add('bg-warning');
      }
      toastEl.textContent = mensaje;
      document.body.appendChild(toastEl);
      setTimeout(() => toastEl.remove(), 3000);
    },
    cargarInformesSinParte() {
  axios.get(`/api/informes-sin-parte?ot_id=${this.ot_id}&hasta=${this.fecha}`)
  .then(response => {
    // Añadir propiedad 'selected' a cada informe
    this.informesSinParte = response.data.map(informe => ({
        ...informe,
        selected: false // inicialmente no seleccionado
    }));
})
.catch(error => {
    // Revisar si el error es de respuesta y mostrar el mensaje específico del servidor
    if (error.response && error.response.data && error.response.data.message) {
      console.error('Error al cargar los informes sin parte:', error.response.data.message);
      // Aquí también puedes mostrar un mensaje de error en la interfaz de usuario
      // Por ejemplo, usando una alerta o un toast
      this.mostrarToast('Error al cargar los informes sin parte: ' + error.response.data.message, 'error');
    } else if (error.request) {
      // El request fue hecho pero no se recibió respuesta
      console.error('No se recibió respuesta al cargar los informes sin parte');
      this.mostrarToast('No se recibió respuesta al cargar los informes sin parte', 'error');
    } else {
      // Algo más causó el error
      console.error('Error al cargar los informes sin parte', error.message);
      this.mostrarToast('Error al cargar los informes sin parte: ' + error.message, 'error');
    }

    // Loguear el error completo para depuración
    console.log(error.config);
  });
},
  }
}
</script>
<style>
  /* Tus estilos aquí */
  .boton-centrado {
  display: flex;
  align-items: center; /* Centra verticalmente */
  height: 100%; /* Asegúrate de que el contenedor tenga una altura para que el centrado tenga efecto. */
  }
</style>