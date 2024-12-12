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
              <date-picker v-model="selectedDate" type="month" format="MM-YYYY" @input="getDatos" class="date-picker-custom" />
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
      <div class="box-header">
        <button @click="exportarTodoPDF()">Exportar PDF</button>
      </div>
      <div class="box-body table-responsive">
        <table class="table table-hover table-striped table-condensed">
    <thead>
        <tr>
            <th>Operador</th>
            <th>Responsabilidad</th> <!-- Nueva columna para Responsabilidad -->
            <th v-for="dia in diasDelMes" :key="dia.dia" 
                :class="{
                  'domingo': dia.domingo_sn,
                  'sabado': dia.sabado_sn,
                  'feriado': dia.feriado_sn,
                  'dia-semana': dia.dia_semana_sn
                }">
              {{ dia.dia }}
            </th>
            <th>SE</th>
        </tr>
    </thead>
    <tbody>
        <!-- Iteramos sobre cada operador -->
        <tr v-for="(detalle, operador) in asistenciaDatos" :key="operador">
            <!-- Columna del operador principal -->
            <td>
                <a href="#" @click.prevent="pdfusuario(detalle.operador.id)">
                    {{ detalle.operador.name }}
                </a>
            </td>

            <!-- Columna de Responsabilidad -->
            <td>
                {{ detalle.ayudante_sn === 0 ? 'Operador' : 'Ayudante' }}
            </td>

            <!-- Iteramos sobre los días -->
            <td v-for="(dia, index) in detalle.dias" :key="index">
                <!-- Parte del operador -->
                <div>
                    {{ dia.asistencia ? (dia.asistencia.parte || '-') : '-' }}
                </div>
            </td>

            <!-- Columna para mostrar la suma de contratistas -->
            <td>
                {{ contarContratistasPorFila(detalle.dias) }}
            </td>
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
    // Verifica si el nuevo valor es válido antes de llamar a getDatos
    if (newVal) {
      this.getDatos(); // Llama a getDatos con el contexto adecuado
    } else {
      this.asistenciaDatos = {}; // Limpiar datos si no hay frente seleccionado
    }
  },
  selectedDate(newVal) {
    // Verifica si el nuevo valor es válido antes de llamar a getDatos
    if (newVal) {
      this.getDatos(); // Llama a getDatos con el contexto adecuado
    } else {
      this.asistenciaDatos = {}; // Limpiar datos si no hay fecha seleccionada
    }
  }
},
methods: {

  //datos nuevos ____________________________________________________
  // Este método busca si hay detalles para el operador en un día específico
  tieneParteODetalle(detalle, dia) {
    return detalle.some(item => item.fechaAsignacion === this.formatearDia(dia));
  },

  // Este método devuelve el valor correspondiente al día
  obtenerValorDetalle(detalle, parametro) {
    // Depuración para ver los datos que llegan al método

    // 1. Verificar si contratista_id tiene valor
    if (detalle.contratista_id !== null && detalle.contratista_id !== undefined) {
        console.log('Mostrando parte:', detalle.parte);
        return detalle.parte; // Mostrar parte si contratista_id no es null
    }

    // 2. Si contratista_id es null, verificar dia_semana_sn
    if (parametro.dia_semana_sn === 1) {
        // Si es día de semana, miramos hora_extra_sn
        if (detalle.hora_extra_sn === 1) {
            console.log('Mostrando horas extra:', '1');
            return '1'; // Mostrar 1 si tiene horas extra
        }
        console.log('Mostrando 0 por día de semana sin horas extra');
        return '0'; // Mostrar '0' si no tiene horas extra
    }

    // 3. Si es fin de semana o feriado, miramos s_d_f_sn
    if (parametro.dia_semana_sn === 0) {
        if (detalle.s_d_f_sn === 1) {
            console.log('Mostrando "sab" (sábado, domingo o feriado)');
            return '1'; // Mostrar el ícono si tiene S/D/F
        }
        console.log('Mostrando "x" por fin de semana sin S/D/F');
        return '0'; // Mostrar 'x' si no tiene S/D/F
    }

    console.log('Mostrando "-" por defecto');
    return '0'; // Por defecto mostramos '-'
},
contarContratistasPorFila(dias) {
    return dias.filter(dia => dia.asistencia?.contratista?.id).length;
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
  
  // Inicializamos el contador de días hábiles
  let diasHabiles = 0;

  // Recorremos todos los días del mes
  const diasDelMes = Array.from({ length: numDias }, (_, i) => {
    const dia = i + 1;
    const fecha = new Date(year, month - 1, dia); // Creamos la fecha completa
    const diaSemana = fecha.getDay(); // 0 = domingo, 1 = lunes, ..., 6 = sábado
    const esFeriado = this.esFeriado(fecha); // Verificamos si es feriado

    // Calculamos si es día hábil
    const diaSemanaSN = esFeriado ? 0 : (diaSemana >= 1 && diaSemana <= 5 ? 1 : 0);

    // Sumamos al contador de días hábiles
    diasHabiles += diaSemanaSN;

    // Creamos el objeto con todas las propiedades solicitadas
    return {
      dia, // El día del mes (1, 2, 3, etc.)
      dia_semana_sn: diaSemanaSN, // 1 si es entre lunes y viernes y no es feriado, 0 si no
      sabado_sn: diaSemana === 6 ? 1 : 0, // 1 si es sábado
      domingo_sn: diaSemana === 0 ? 1 : 0, // 1 si es domingo
      feriado_sn: esFeriado ? 1 : 0 // 1 si es feriado, 0 si no
    };
  });

  // Asignamos el total de días hábiles a this.diasHabiles
  this.diasHabiles = diasHabiles;

  // Log de los datos antes de retornar
  console.log('Datos del mes:', diasDelMes);
  console.log('Total de días hábiles:', this.diasHabiles);
  this.diasDelMes = diasDelMes;
  // Retornamos solo los días del mes como antes
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
    if (!this.frente_selected || !this.selectedDate) {
        console.log("Por favor, seleccione un frente y una fecha antes de continuar.");
        this.asistenciaDatos = [];
        return;
    }

    this.isLoading = true;

    const diasDelMes = await this.getDiasDelMes(this.selectedDate.getFullYear(), this.selectedDate.getMonth() + 1);
    const formattedDate = this.selectedDate.getFullYear() + '-' + ('0' + (this.selectedDate.getMonth() + 1)).slice(-2);

    try {
        const response = await axios.get('/api/asistencia_pagos', {
            params: {
                frente_id: this.frente_selected.id,
                fecha: formattedDate
            }
        });

        console.log("Datos recibidos de la API:", response.data);

        const agrupados = {};

        response.data.forEach(item => {
            const operadorId = item.operador.id;

            // Procesar operador como principal
            if (!agrupados[operadorId]) {
                agrupados[operadorId] = {
                    operador: { id: operadorId, name: item.operador.name },
                    dias: diasDelMes.map(dia => ({ ...dia, asistencia: null })),
                    ayudante_sn: 0 // Marcamos como operador
                };
            }

            const fechaAsistencia = new Date(item.fecha_asistencia);
            const diaMes = fechaAsistencia.getDate();
            const diaCorrespondiente = agrupados[operadorId].dias.find(d => d.dia === diaMes);
            if (diaCorrespondiente) {
                diaCorrespondiente.asistencia = item;
            }

            // Procesar ayudante
            if (item.ayudante) {
                const ayudanteId = `ayudante-${item.ayudante.id}`; // Identificar como ayudante

                if (!agrupados[ayudanteId]) {
                    agrupados[ayudanteId] = {
                        operador: { id: item.ayudante.id, name: item.ayudante.name },
                        dias: diasDelMes.map(dia => ({ ...dia, asistencia: null })),
                        ayudante_sn: 1 // Marcamos como ayudante
                    };
                }

                const diaAyudante = agrupados[ayudanteId].dias.find(d => d.dia === diaMes);
                if (diaAyudante) {
                    diaAyudante.asistencia = item;
                }
            }
        });

        // Convertimos el objeto en un arreglo para la vista
        this.asistenciaDatos = Object.values(agrupados);

        // Ordenar alfabéticamente por nombre
        this.asistenciaDatos.sort((a, b) => a.operador.name.localeCompare(b.operador.name));

        console.log("Resultado final agrupado y ordenado:", this.asistenciaDatos);
    } catch (error) {
        console.error("Error al obtener los datos de la API:", error);
        this.asistenciaDatos = [];
    } finally {
        this.isLoading = false;
    }
}
,

contarParametros(detalle, parametro, tipo) {
    return detalle.reduce((contador, dia) => {
        if (dia && dia.parametros) {
            const parametros = dia.parametros; // Accedemos a dia.parametros

            // Para contar horas extra
            if (tipo === 'sumar' && parametro === 'hora_extra_sn' && dia.detalle[parametro] === 1) {
                return contador + 1; // Sumar solo los casos donde hora_extra_sn es 1
            }

            // Para contar contratistas
            if (tipo === 'conteo' && parametro === 'contratista_id' && dia.detalle[parametro] !== null) {
                return contador + 1; // Contar solo si contratista_id no es null
            }

            // Contar solo sábados
            if (tipo === 'sumar' && parametro === 'sabado') {
                if (parametros.sabado_sn === 1 && dia.detalle.s_d_f_sn === 1 && dia.detalle.contratista_id === null) {
                  console.log(dia.detalle.contratista_id,'aaaaaaaaaaaaaaaaaaaaaaa');
                    return contador + 1; // Contamos como sábado
                }
            }

            // Contar domingos y feriados juntos
            if (tipo === 'sumar' && parametro === 'domingo_feriado') {
                if ((parametros.domingo_sn === 1 || parametros.feriado_sn === 1) && dia.detalle.s_d_f_sn === 1 && dia.detalle.contratista_id === null) {
                  console.log(dia.detalle.contratista_id,'aaaaaaaaaaaaaaaaaaaaaaassssssssssssss');
                    return contador + 1; // Contamos como domingo o feriado
                }
            }
        }
        return contador;
    }, 0);
},
//datos nuevos ____________________________________________________
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
    const modo = 'Servicios';
    const url = `/area/enod/asistencia-pdf?year=${year}&month=${month}&frent_id=${frent_id}&modo=${modo}`;

    // Abre la URL en una nueva ventana
    window.open(url, '_blank');
  },
  pdfusuario(operadorId) {
    console.log(operadorId);
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

.domingo {
    background-color: #FFEB99; /* Color para domingos */
  }

  .sabado {
    background-color: #FFCC99 ; /* Color para sábados */
  }

  .feriado {
    background-color: #FF6666 ; /* Color para feriados */
  }

  .dia-semana {
    background-color: #6BB5D9; /* Color para días de semana */
  }
  
</style>
