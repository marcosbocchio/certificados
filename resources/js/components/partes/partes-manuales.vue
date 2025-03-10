<template>
  <div class="row">
    <div class="col-md-12">
      <form @submit.prevent="storeSection">
        <div class="box box-custom-enod">
          <div class="box-body">
            <div class="form-group col-md-3">
              <label>Fecha *</label>
              <date-picker
                v-model="fecha"
                value-type="YYYY-MM-DD"
                :disabled-date="disabledDate"
                format="DD-MM-YYYY"
                placeholder="DD-MM-YYYY"
              ></date-picker>
            </div>
            <div class="form-group col-md-3">
              <label>Cliente *</label>
              <input type="text" v-model="cliente" class="form-control" disabled />
            </div>
            <div class="form-group col-md-3">
              <label>Proyecto *</label>
              <input type="text" v-model="proyecto" class="form-control" disabled />
            </div>
            <div class="form-group col-md-3">
              <label>Orden de Trabajo N° *</label>
              <input type="text" v-model="ordenTrabajo" class="form-control" disabled />
            </div>
          </div>
        </div>

        <div class="box box-custom-enod">
          <div class="box-header">
            <h3 class="box-title">Detalles de Parte Manual</h3>
          </div>
          <div class="box-body">
            <div class="form-row">
              <!-- Técnica: input único múltiple -->
              <div class="form-group col-md-3">
                <label>Técnica *</label>
                <v-select
                  v-model="detalle.tecnica"
                  :options="opcionesTecnica"
                  multiple
                  :max="2"
                ></v-select>
              </div>
              <!-- Cantidad: dos inputs fijos, se integran en detalle.cantidad -->
              <div class="form-group col-md-3">
                <div class="row">
                  <div class="col-md-6">
                    <label>Cantidad 1*</label>
                    <input
                      type="number"
                      v-model.number="cantidad1"
                      class="form-control"
                      max="9999"
                    />
                  </div>
                  <div class="col-md-6">
                    <label>Cantidad 2</label>
                    <input
                      type="number"
                      v-model.number="cantidad2"
                      class="form-control"
                      max="9999"
                    />
                  </div>
                </div>
              </div>
              <!-- Planta (múltiple con máximo 2) -->
              <div class="form-group col-md-3">
                <label>Planta *</label>
                <v-select
                  v-model="detalle.planta"
                  :options="opcionesPlanta"
                  multiple
                  :max="2"
                ></v-select>
              </div>
              <div class="form-group col-md-3">
                <label for="equipo_linea">Equipo/Linea *</label>
                <input type="text" v-model="detalle.equipo_linea" class="form-control" maxlength="60" />
              </div>

              <div class="clearfix"></div>

              <div class="form-group col-md-3">
                <label for="horario">Horario *</label>
                <v-select
                  v-model="detalle.horario"
                  :options="opcionesHorarios"
                  label="label"
                  :reduce="horario => horario.value"
                ></v-select>
              </div>
              <div class="form-group col-md-3">
                <label for="n_informe">N° Informe *</label>
                <input type="text" v-model="detalle.n_informe" class="form-control" maxlength="18" />
              </div>
              <div class="form-group col-md-3">
                <label>Operadores *</label>
                <v-select
                  v-model="detalle.operadores"
                  :options="opcionesOperadores"
                  multiple
                  :max="2"
                ></v-select>
              </div>
              <div class="form-group col-md-3">
                <label>Inspector *</label>
                <v-select
                  v-model="detalle.inspector_secl"
                  :options="inspectores_op"
                  label="name"
                  multiple
                  :max="2"
                ></v-select>
              </div>
              <div class="clearfix"></div>
              <div class="form-group col-md-3 boton-centrado">
                <label></label>
                <button type="button" @click="agregarDetalle">
                  <span class="fa fa-plus-circle"></span>
                </button>
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
                      <td>{{ detalle.tecnica.join(" / ") }}</td>
                      <td>{{ detalle.cantidad.join(" / ") }}</td>
                      <td>
                        {{ detalle.planta[0]?.label || "" }}
                        {{ detalle.planta[1]?.label ? " / " + detalle.planta[1].label : "" }}
                      </td>
                      <td>{{ detalle.equipo_linea }}</td>
                      <td>{{ detalle.horario }}</td>
                      <td>{{ detalle.n_informe }}</td>
                      <td>
                        {{ detalle.operadores[0]?.label || "" }}
                        {{ detalle.operadores[1]?.label ? " / " + detalle.operadores[1].label : "" }}
                      </td>
                      <td>
                        {{ detalle.inspector_secl[0]?.name || "" }}
                        {{ detalle.inspector_secl[1]?.name ? " / " + detalle.inspector_secl[1].name : "" }}
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
                <tr v-for="(informe, index) in informesSinParte" :key="informe.id">
                  <td>
                    <input
                      type="checkbox"
                      v-model="informe.selected"
                      @click="actualizarNumeroInforme(informe)"
                    />
                  </td>
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
        <button type="submit" class="btn btn-primary" :disabled="isSaving" ref="saveButton">
          Guardar
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import axios from "axios";
import { Toast } from "bootstrap";

export default {
  name: "ParteManualComponent",
  props: [
    "ot_id",
    "cliente",
    "proyecto",
    "ordenTrabajoNumero",
    "plantas",
    "operadores",
    "ot",
    "inspectores_op"
  ],
  components: {
    DatePicker,
    "v-select": vSelect
  },
  data() {
    return {
      editMode: false,
      fecha: "",
      cliente: this.cliente,
      proyecto: this.proyecto,
      ordenTrabajo: this.ordenTrabajoNumero,
      informesSinParte: [],
      detalles: [],
      opcionesHorarios: [
        { value: "A", label: "LUNES A VIERNES 7 - A 16.30 HS" },
        { value: "B", label: "LUNES A VIERNES 7 - A 19HS" },
        { value: "C", label: "SAB. - DOM. - FERIADOS - 7 A 19 HS" },
        { value: "D", label: "LUNES A DOM. - HORARIO NOCTURNO" }
      ],
      opcionesPlanta: this.plantas.map(planta => ({
        label: planta.codigo,
        value: planta.codigo
      })),
      opcionesOperadores: this.operadores.map(operador => ({
        label: operador.nombre,
        value: operador.id
      })),
      inspectores_op: this.inspectores_op.map(inspector => ({
        label: inspector.name,
        value: inspector.id
      })),
      ot: this.ot,
      isSaving: false,
      // Se mantiene detalle.cantidad como array para la lógica existente
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
      opcionesTecnica: [
        "CR",
        "ADM",
        "LP",
        "PM",
        "PMI",
        "RG",
        "US",
        "US-AT",
        "US-N2",
        "US-PHA",
        "DU",
        "RM",
        "TT"
      ]
    };
  },
  computed: {
    cantidad1: {
      get() {
        return this.detalle.cantidad[0] || "";
      },
      set(value) {
        this.$set(this.detalle.cantidad, 0, value);
      }
    },
    cantidad2: {
      get() {
        return this.detalle.cantidad[1] || "";
      },
      set(value) {
        this.$set(this.detalle.cantidad, 1, value);
      }
    }
  },
  mounted() {
    this.editMode = this.ot ? true : false;
    if (this.fecha) {
      this.cargarInformesSinParte();
      console.log(this.informesSinParte);
    }
  },
  watch: {
    fecha(newValue) {
      if (newValue) {
        this.cargarInformesSinParte();
      }
    }
  },
  methods: {
    disabledDate(time) {
      return time.getTime() > Date.now();
    },
    obtenerLabelOperador(operador) {
      return operador ? operador.label : "-";
    },
    formatearNumero(metodo, numero) {
      const numeroFormateado = numero.toString().padStart(4, "0");
      return `${metodo}${numeroFormateado}`;
    },
    saveOrUpdate() {
      if (this.editMode) {
        this.updateSection();
      } else {
        this.storeSection();
      }
    },
    obtenerNombreOperador(id) {
      const operadorEncontrado = this.operadores.find(
        operador => operador.id === id
      );
      return operadorEncontrado
        ? operadorEncontrado.nombre
        : "Operador no encontrado";
    },
    agregarDetalle() {
      if (!this.validarDetalle()) {
        return;
      }
      console.log(this.detalle);
      this.detalles.push({ ...this.detalle });
      this.resetDetalle();
    },
    validarDetalle() {
      const errores = [];
      
      // Validación de técnica
      if (!this.detalle.tecnica || this.detalle.tecnica.length === 0) {
        errores.push("Por favor, selecciona al menos una técnica.");
      } else if (this.detalle.tecnica.length > 2) {
        errores.push("No puedes seleccionar más de dos técnicas.");
      }
      
      // Validación de cantidad 1 (obligatoria)
      if (!this.detalle.cantidad || this.detalle.cantidad.length === 0 || !this.detalle.cantidad[0]) {
        errores.push("Por favor, ingresa la cantidad 1.");
      } else {
        let num = parseFloat(this.detalle.cantidad[0]);
        if (isNaN(num) || num <= 0) {
          errores.push("La cantidad 1 debe ser un número mayor que cero.");
        }
        if (num > 9999) {
          errores.push("La cantidad 1 no puede ser mayor que 9999.");
        }
      }
      
      // Si se ingresó cantidad 2, se valida
      if (this.detalle.cantidad[1]) {
        let num = parseFloat(this.detalle.cantidad[1]);
        if (isNaN(num) || num <= 0) {
          errores.push("La cantidad 2, si se ingresa, debe ser un número mayor que cero.");
        }
        if (num > 9999) {
          errores.push("La cantidad 2 no puede ser mayor que 9999.");
        }
      }
      
      // Nueva condición: si hay más de una técnica, cantidad 2 es obligatoria
      if (this.detalle.tecnica.length > 1 && (!this.detalle.cantidad[1] || this.detalle.cantidad[1] === "")) {
        errores.push("Para más de una técnica, la cantidad 2 es obligatoria.");
      }
      
      // Validación de planta
      if (!this.detalle.planta || this.detalle.planta.length === 0) {
        errores.push("Por favor, selecciona al menos una planta.");
      } else if (this.detalle.planta.length > 2) {
        errores.push("No puedes seleccionar más de dos plantas.");
      }
      
      // Validación de equipo/linea
      if (!this.detalle.equipo_linea)
        errores.push("Por favor, ingresa el equipo o línea.");
      
      // Validación de horario
      if (!this.detalle.horario)
        errores.push("Por favor, selecciona un horario.");
      
      // Validación de número de informe
      if (!this.detalle.n_informe)
        errores.push("Por favor, ingresa el número de informe.");
      
      // Validación de inspectores
      if (!this.detalle.inspector_secl || this.detalle.inspector_secl.length === 0) {
        errores.push("Por favor, selecciona al menos un inspector.");
      } else if (this.detalle.inspector_secl.length > 2) {
        errores.push("No puedes seleccionar más de dos inspectores.");
      }
      
      // Validación de operadores
      if (this.detalle.operadores.length === 0) {
        errores.push("Debes seleccionar al menos un operador.");
      } else if (this.detalle.operadores.length > 2) {
        errores.push("No puedes seleccionar más de dos operadores.");
      }
      
      errores.forEach(error => toastr.error(error));
      return errores.length === 0;
    },
    actualizarNumeroInforme(informe) {
      if (informe.selected) {
        const numeroFormateado = this.formatearNumero(informe.metodo, informe.numero);
        this.detalle.n_informe = this.detalle.n_informe.replace(
          new RegExp(numeroFormateado + "\\s*/?\\s*"),
          ""
        );
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
    quitarDetalle(index) {
      this.detalles.splice(index, 1);
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
    },
    storeSection() {
      if (!this.fecha) {
        toastr.error("Debe ingresar una fecha");
        return;
      }
      const data = {
        fecha: this.fecha,
        ot_id: this.ot_id,
        cliente: this.cliente,
        proyecto: this.proyecto,
        ordenTrabajo: this.ordenTrabajo,
        detalles: this.detalles,
        ot_obra: this.ot.obra ?? "-",
        selectedInformes: this.informesSinParte
          .filter(informe => informe.selected)
          .map(informe => informe.id)
      };

      axios
        .post("/api/partes-manuales", data)
        .then(response => {
          this.isSaving = false;
          window.open("/pdf-partemanual/" + response.data.id, "_blank");
          window.location.href = "/partes/ot/" + this.ot_id;
          this.mostrarToast("Datos guardados exitosamente", "success");
        })
        .catch(error => {
          this.isSaving = false;
          if (error.response && error.response.status === 422) {
            const errors = error.response.data.errors;
            console.error("Errores de validación:", errors);
            Object.keys(errors).forEach(key => {
              errors[key].forEach(message => {
                toastr.error(message, key, { timeOut: 5000 });
              });
            });
          } else {
            console.error("Error inesperado:", error.message);
            toastr.error(error.message, "Error inesperado", { timeOut: 5000 });
          }
        });
    },
    mostrarToast(mensaje, tipo) {
      if (tipo === "success") {
        toastr.success(mensaje);
      } else if (tipo === "error") {
        toastr.error(mensaje);
      } else if (tipo === "warning") {
        toastr.warning(mensaje);
      }
    },
    cargarInformesSinParte() {
      axios
        .get(`/api/informes-sin-parte?ot_id=${this.ot_id}&hasta=${this.fecha}`)
        .then(response => {
          this.informesSinParte = response.data.map(informe => ({
            ...informe,
            selected: false
          }));
          console.log("Datos cargados en informesSinParte:", this.informesSinParte);
        })
        .catch(error => {
          if (error.response && error.response.data && error.response.data.message) {
            this.mostrarToast("Error al cargar los informes sin parte: " + error.response.data.message, "error");
          } else if (error.request) {
            this.mostrarToast("No se recibió respuesta al cargar los informes sin parte", "error");
          } else {
            this.mostrarToast("Error al cargar los informes sin parte: " + error.message, "error");
          }
          console.log(error.config);
        });
    }
  }
};
</script>

<style scoped>
.boton-centrado {
  display: flex;
  align-items: center;
  height: 100%;
}
.ml-2 {
  margin-left: 0.5rem;
}
.d-flex {
  display: flex;
}
.input-group {
  display: flex;
}
.input-group-btn {
  margin-left: 0.5rem;
}
.tag-cantidad {
  display: inline-block;
  padding: 0.25rem 0.5rem;
  margin-right: 0.5rem;
  margin-top: 0.5rem;
  background-color: #f0f0f0;
  border-radius: 4px;
  cursor: pointer;
  user-select: none;
}
.tag-cantidad:hover {
  background-color: #e0e0e0;
}
</style>
