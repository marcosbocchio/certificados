<template>
  <div>
    <loading :active.sync="isLoading" :is-full-page="true" :loader="'bars'" :color="'red'"></loading>
    
    <!-- Filtros de Fecha y Días Hábiles -->
    <div class="box box-custom-enod top-buffer">
      <div class="box-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="frente">Frente:</label>
              <v-select v-model="frente_selected" :options="frentes_opciones" label="codigo" id="frente" clearable></v-select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="month">Mes y Año:</label>
              <date-picker v-model="selectedDate" type="month" format="MM-YYYY" @input="fetchAsistencia" class="date-picker-custom" />
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="diasHabiles">Días Hábiles del Mes:</label>
              <input type="text" v-model="diasHabiles" disabled class="form-control"/>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Tabla de Asistencia -->
    <div class="box box-custom-enod top-buffer">
      <button @click="getDatos" class="exportar-todo-pdf">Cargar Datos</button>
      <div class="box-body table-responsive">
        <table class="table table-hover table-striped table-condensed">
          <thead>
            <tr>
              <th>Operador</th>
              <th v-for="dia in diasDelMes" :key="dia.dia">{{ dia.dia }}</th>
              <th>Hs. Ex</th>
              <th>Sv. Ex</th>
              <th>S/D/F</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(detalle, operador) in asistenciaDatos" :key="operador">
              <td>{{ operador }} {{ operador.ayudante_sn }}</td>
              <!-- Recorremos los días y mostramos el valor correspondiente -->
              <td v-for="(dia, index) in diasDelMes" :key="index">
                <span v-if="detalle[index]">
                  <!-- Aplicamos la función para determinar qué mostrar -->
                  {{ obtenerValorDetalle(detalle[index], dia) }}
                </span>
                <span v-else>-</span>
              </td>
              <!-- Calcular y mostrar las nuevas columnas -->
              <td>{{ contarParametros(detalle, 'hora_extra_sn', 'sumar') }}</td>
              <td>{{ contarParametros(detalle, 'contratista_id', 'conteo') }}</td>
              <td>{{ contarParametros(detalle, 's_d_f_sn', 'sumar') }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  </template>

<script>
import axios from 'axios';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

export default {
components: {
  Loading,
  DatePicker
},
props: {
  frentes_opciones: {
    type: Array,
    required: true
  },
},
data() {
  return {
      frente_selected: null,
      selectedDate: null,
      diasHabiles: '',
      operarios: [],
      isLoading: false,
      mostrarPopup: false,
      operadorSeleccionado: null,
      fechaSeleccionada: null,
      tipoPagoSeleccionado: null,
      diasDelMes: [], // Aquí se guardan los días del mes
      asistenciaDatos: {}, // Aquí se guarda la respuesta reorganizada de la API
    };
  },
watch: {
  frente_selected(newVal) {
    if (newVal) {
      console.log('a')
      //this.getDatos();
    }
  },
  selectedDate(newVal) {
    if (newVal) {
      console.log(this.selectedDate)
      console.log('a')
      //this.getDatos();
    }
  }
},
methods: {
  formatToTwoDecimals(value) {
      if (Number.isInteger(value)) {
        return value; // Retorna el valor tal cual si es un entero
      } else {
        return parseFloat(value).toFixed(2); // Formatea a 2 decimales si no es un entero
      }
    },
  async fetchAsistencia() {
    if (!this.selectedDate || !this.frente_selected) return;

  const { year, month } = this.formatDateToMonthYear(this.selectedDate);
  this.isLoading = true;

  try {
    const diasDelMesResponse = await axios.get(`/api/calcular-dias-del-mes/${year}/${month}`);
    this.diasHabiles = diasDelMesResponse.data.diasHabiles;

    const response = await axios.get('/api/asistencia-operadores', {
      params: {
        year,
        month,
        frent_id: this.frente_selected.id
      }
    });
    console.log(response.data.asistencias);
    this.operarios = response.data.asistencias.map(operador => ({
        operador: operador.operador,
        responsabilidad: operador.ayudante_sn,
        diasHabiles: operador.diasHabiles,
        sabados: operador.sabados,
        domingos: operador.domingos,
        feriados: operador.feriados,
        horasExtras: operador.horasExtras,
        serviciosExtrasS1: operador.serviciosExtrasS1,
        serviciosExtrasS2: operador.serviciosExtrasS2,
        serviciosExtrasS3: operador.serviciosExtrasS3,
        serviciosExtrasS4: operador.serviciosExtrasS4,
        serviciosExtrasS5: operador.serviciosExtrasS5,
        fecha_pago_s1: this.formatDate(operador.fecha_pago_s1),
        fecha_pago_s2: this.formatDate(operador.fecha_pago_s2),
        fecha_pago_s3: this.formatDate(operador.fecha_pago_s3),
        fecha_pago_s4: this.formatDate(operador.fecha_pago_s4),
        fecha_pago_s5: this.formatDate(operador.fecha_pago_s5),
        fecha_pago_mes: this.formatDate(operador.fecha_pago_mes),
        pagoS1: operador.pagoS1 || false,
        pagoS2: operador.pagoS2 || false,
        pagoS3: operador.pagoS3 || false,
        pagoS4: operador.pagoS4 || false,
        pagoS5: operador.pagoS5 || false,
        pagosExtMensual: operador.pagosExtMensual || false,
        precargadoPagoS1: operador.pagoS1 || false,
        precargadoPagoS2: operador.pagoS2 || false,
        precargadoPagoS3: operador.pagoS3 || false,
        precargadoPagoS4: operador.pagoS4 || false,
        precargadoPagoS5: operador.pagoS5 || false,
        precargadoPagosExtMensual: operador.pagosExtMensual || false
      }));
  } catch (error) {
    console.error(error);
    this.operarios = {};
  
  } finally {
    this.isLoading = false;
  }
  },
  //datos nuevos ____________________________________________________
  // Este método busca si hay detalles para el operador en un día específico
  tieneParteODetalle(detalle, dia) {
    return detalle.some(item => item.fechaAsignacion === this.formatearDia(dia));
  },

  // Este método devuelve el valor correspondiente al día
  obtenerValorDetalle(detalle, parametro) {
    // 1. Verificar si contratista_id tiene valor
    if (detalle.contratista_id !== null) {
      return detalle.parte; // Mostrar parte si contratista_id no es null
    }

    // 2. Si contratista_id es null, verificar dia_semana_sn
    if (parametro.dia_semana_sn === 1) {
      // Si es día de semana, miramos hora_extra_sn
      if (detalle.hora_extra_sn === 1) {
        return '1'; // Mostrar 1 si tiene horas extra
      }
      return '0'; // Mostrar '-' si no tiene horas extra
    }

    // 3. Si es fin de semana o feriado, miramos s_d_f_sn
    if (parametro.dia_semana_sn === 0) {
      if (detalle.s_d_f_sn === 1) {
        return 'sab'; // Mostrar el ícono si tiene S/D/F
      }
      return 'x'; // Mostrar '-' si no tiene S/D/F
    }
    
    return '-'; // Por defecto mostramos '-'
  },

  // Método para formatear el día como una fecha correcta
  formatearDia(dia) {
    const year = new Date().getFullYear(); // Asumimos el año actual
    const month = new Date().getMonth() + 1; // Asumimos el mes actual
    return `${year}-${String(month).padStart(2, '0')}-${String(dia).padStart(2, '0')}`;
  },
  
  // Lógica para obtener los días del mes
  async getDiasDelMes(year, month) {
  // Llamamos a la función para obtener los feriados antes de calcular los días
  await this.obtenerFeriados();

  // Obtenemos el número de días del mes
  const numDias = new Date(year, month, 0).getDate();
  
  // Recorremos todos los días del mes
  const diasDelMes = Array.from({ length: numDias }, (_, i) => {
    const dia = i + 1;
    const fecha = new Date(year, month - 1, dia); // Creamos la fecha completa
    const diaSemana = fecha.getDay(); // 0 = domingo, 1 = lunes, ..., 6 = sábado
    const esFeriado = this.esFeriado(fecha); // Verificamos si es feriado

    // Creamos el objeto con todas las propiedades solicitadas
    return {
      dia, // El día del mes (1, 2, 3, etc.)
      dia_semana_sn: diaSemana >= 1 && diaSemana <= 5 ? 1 : 0, // 1 si es entre lunes y viernes, 0 si no
      sabado_sn: diaSemana === 6 ? 1 : 0, // 1 si es sábado
      domingo_sn: diaSemana === 0 ? 1 : 0, // 1 si es domingo
      feriado_sn: esFeriado ? 1 : 0 // 1 si es feriado, 0 si no
    };
  });

  // Log de los datos antes de retornar
  console.log('Datos del mes:', diasDelMes);

  // Retornamos los datos
  return diasDelMes;
},
esFeriado(fecha) {
  const dia = fecha.getDate();
  const mes = fecha.getMonth() + 1; // Los meses en JavaScript son 0-indexados
  const anio = fecha.getFullYear();

  // Formateamos la fecha como "YYYY-MM-DD"
  const fechaFormateada = `${anio}-${('0' + mes).slice(-2)}-${('0' + dia).slice(-2)}`;

  // Comparamos si la fecha formateada está en la lista de feriados
  return this.feriados.includes(fechaFormateada);
},async obtenerFeriados() {
  const year = new Date(this.selectedDate).getFullYear(); // Obtenemos el año de la fecha seleccionada
  try {
    const response = await axios.get(`/api/asistencia/getferiados/${year}`);
    this.feriados = response.data; // Guardamos la lista de feriados
  } catch (error) {
    console.error("Error al obtener los feriados:", error);
    this.feriados = []; // Si hay error, dejamos la lista vacía
  }
},

async getDatos() {
    console.log("Frente:", this.frente_selected);
    console.log("Fecha:", this.selectedDate);
    
    const formattedDate = this.selectedDate.getFullYear() + '-' + ('0' + (this.selectedDate.getMonth() + 1)).slice(-2);
    console.log("Fecha formateada:", formattedDate);
    
    // Asegúrate de esperar a que getDiasDelMes termine usando await
    const diasDelMes = await this.getDiasDelMes(this.selectedDate.getFullYear(), this.selectedDate.getMonth() + 1); 
    console.log("Días del mes:", diasDelMes);

    try {
      const response = await axios.get('/api/asistencia-operadores-datos', {
        params: {
          frente_id: this.frente_selected.id,
          fecha: formattedDate
        }
      });

      console.log("Respuesta de la API:", response.data);

      // Inicializar un objeto para almacenar los datos reorganizados
      let asistenciaReorganizada = {};

      // Iterar sobre cada operador
      for (let operador in response.data) {
        // Inicializar una matriz para cada operador que contenga los días del mes
        asistenciaReorganizada[operador] = diasDelMes.map(dia => {
          // Convertir el día en el formato de fecha
          let fechaDelDia = `${formattedDate}-${('0' + dia.dia).slice(-2)}`; // Usa dia.dia ya que el objeto tiene varias propiedades
          
          // Buscar si hay una entrada con la fecha que coincide con ese día
          let detalleDelDia = response.data[operador].find(asistencia => asistencia.fechaAsignacion === fechaDelDia);
          
          // Si existe un detalle para ese día, lo guardamos junto con los parámetros; de lo contrario, devolvemos null
          return detalleDelDia
            ? {
                detalle: detalleDelDia.detalle,
                parametros: {
                  dia_semana_sn: dia.dia_semana_sn,
                  sabado_sn: dia.sabado_sn,
                  domingo_sn: dia.domingo_sn,
                  feriado_sn: dia.feriado_sn
                }
              }
            : null; // Si no hay coincidencia, devolvemos null
        });
      }

      console.log("Datos reorganizados por operador y día:", asistenciaReorganizada);
      
      // Puedes usar 'asistenciaReorganizada' para lo que necesites en tu tabla posteriormente
      this.asistenciaDatos = asistenciaReorganizada;
      this.diasDelMes = diasDelMes;

    } catch (error) {
      console.error("Error al llamar a la API:", error);
    }
},
    contarParametros(detalle, parametro, tipo) {
    return detalle.reduce((contador, dia) => {
      if (dia && dia.parametros) {
        // Para sumas de horas extra (Hs. Ex)
        if (tipo === 'sumar' && parametro === 'hora_extra_sn' && dia.parametros[parametro] === 1) {
          return contador + 1; // Sumar solo los casos donde hora_extra_sn es 1
        }
        // Para conteo de contratistas (Sv. Ex)
        if (tipo === 'conteo' && parametro === 'contratista_id' && dia.parametros[parametro] !== null) {
          return contador + 1; // Contar solo si contratista_id no es null
        }
        // Para conteo de S/D/F
        if (tipo === 'sumar' && parametro === 's_d_f_sn' && dia.parametros[parametro] === 1) {
          return contador + 1; // Contar solo los casos donde s_d_f_sn es 1
        }
      }
      return contador;
    }, 0);
  },
//datos nuevos ____________________________________________________

  openPopup(operador, tipoPago) {
      this.operadorSeleccionado = operador;
      this.tipoPagoSeleccionado = tipoPago;
      this.fechaSeleccionada = null;
      this.mostrarPopup = true;
    },

    cerrarPopup() {
      this.mostrarPopup = false;
      this.operadorSeleccionado = null;
      this.tipoPagoSeleccionado = null;
      this.fechaSeleccionada = null;
    },
    formatDate(dateString) {
      if (!dateString) {
      return ''; // O el mensaje que desees, como 'Fecha no disponible'
    }
      // Crear un objeto Date a partir de la cadena de fecha
      const date = new Date(dateString);

      // Obtener el año, mes y día
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, '0'); // Mes es 0-indexado, por lo que se suma 1
      const day = String(date.getDate()).padStart(2, '0');

      // Devolver la fecha formateada
      return `${year}-${month}-${day}`;
    },
    confirmarFecha() {
      if (!this.operadorSeleccionado || !this.tipoPagoSeleccionado || !this.fechaSeleccionada) return;

      switch (this.tipoPagoSeleccionado) {
        case 'Pago Mes':
          this.operadorSeleccionado.fecha_pago_mes = this.fechaSeleccionada;
          break;
        case 'Pago S1':
          this.operadorSeleccionado.fecha_pago_s1 = this.fechaSeleccionada;
          break;
        case 'Pago S2':
          this.operadorSeleccionado.fecha_pago_s2 = this.fechaSeleccionada;
          break;
        case 'Pago S3':
          this.operadorSeleccionado.fecha_pago_s3 = this.fechaSeleccionada;
          break;
        case 'Pago S4':
          this.operadorSeleccionado.fecha_pago_s4 = this.fechaSeleccionada;
          break;
        case 'Pago S5':
          this.operadorSeleccionado.fecha_pago_s5 = this.fechaSeleccionada;
          break;
      }

      this.cerrarPopup();
    },
  async guardarPagos() {
    // Verificar si al menos un checkbox está seleccionado
    const operariosSeleccionados = this.operarios.filter(operador => 
      operador.pagoS1 || operador.pagoS2 || operador.pagoS3 || operador.pagoS4 || operador.pagoS5 || operador.pagosExtMensual
    );

    if (operariosSeleccionados.length === 0) {
      toastr.error('Por favor, seleccione al menos un pago antes de guardar.');
      return;
    }
    
    this.isLoading = true;
    try {
      const fechaFormateada = this.selectedDate.toISOString().substr(0, 7); // Formato YYYY-MM

      await axios.post('/api/guardar-pagos', {
        frente_id: this.frente_selected.id,
        selectedMonthYear: fechaFormateada,
        operarios: operariosSeleccionados,
      });
      
      toastr.success('Pagos guardados con éxito');
    } catch (error) {
      toastr.error('Error al guardar los pagos');
    } finally {
      this.isLoading = false;
    }
  },
  formatDateToMonthYear(date) {
    const year = date.getFullYear();
    const month = date.getMonth() + 1;
    return {
      year: year.toString(),
      month: month < 10 ? '0' + month : month.toString()
    };
  },
  exportarTodoPDF() {
    const { year, month } = this.formatDateToMonthYear(this.selectedDate);
    const frent_id = this.frente_selected.id;

    const url = `/area/enod/asistencia-pdf?year=${year}&month=${month}&frent_id=${frent_id}`;

    // Abre la URL en una nueva ventana
    window.open(url, '_blank');
  },
  pdfusuario(operadorId) {
        // Construir la URL con los parámetros
        const url = `/area/enod/asistencia-pdf-user/${operadorId}/${this.frente_selected.id}/${this.selectedDate}`;

        // Abrir el PDF en una nueva pestaña
        window.open(url, '_blank');
    }
}
};
</script>

<style scoped>
.table-responsive {
  overflow-x: auto;
}

.table thead th,
.table tbody td {
  text-align: center; /* Centrar el texto */
  white-space: nowrap;
}
.neuquen-highlight {
  background-color: #000000;
}
.neuquen-highlight a{
  color: rgb(255, 204, 0);
}
.table tbody td input[type="checkbox"] {
  margin: 0 auto; /* Centrar los checkboxes */
  display: block;
}

.checkbox-container {
  position: relative;
  display: inline-block;
}

.date-tooltip {
  visibility: hidden;
  width: 120px;
  background-color: #333;
  color: #fff;
  text-align: center;
  border-radius: 5px;
  padding: 5px;
  position: absolute;
  z-index: 1;
  bottom: 125%; /* Sitúa el tooltip arriba del checkbox */
  left: 50%;
  margin-left: -60px; /* Centra el tooltip */
  opacity: 0;
  transition: opacity 0.3s;
}

.checkbox-container:hover .date-tooltip {
  visibility: visible;
  opacity: 1;
}

.box.box-custom-enod {
  padding: 20px;
}

.modal.show {
  display: block;
  z-index: 1050;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 5px;
}
</style>
