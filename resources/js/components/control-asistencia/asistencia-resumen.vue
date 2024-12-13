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
            <th>Responsabilidad</th>
            <th v-for="dia in diasDelMes" :key="dia.dia" 
                :class="{
                  'domingo': dia.domingo_sn,
                  'sabado': dia.sabado_sn,
                  'feriado': dia.feriado_sn,
                  'dia-semana': dia.dia_semana_sn
                }">
              {{ dia.dia }}
            </th>
            <th>E</th>
            <th>S</th>
            <th>D/F</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="(detalle, operador) in asistenciaDatos" :key="operador">
            <td>
                <a href="#" @click.prevent="pdfusuario(detalle.operador_id)">
                  {{ operador }} 
                </a>
              </td>
              <td>{{ detalle.ayudante_sn }}</td>
            <!-- Recorremos los días y mostramos el valor correspondiente -->
            <td v-for="(dia, index) in detalle.dias" :key="index">
                <span v-if="dia">
                    {{ obtenerValorDetalle(dia.detalle, diasDelMes[index]) }}
                </span>
                <span v-else>0</span>
            </td>
            <!-- Calcular y mostrar las nuevas columnas -->
            <td>{{ contarHoras(detalle.dias) }}</td> 
            <td>{{ contarParametros(detalle.dias, 'sabado', 'sumar') }}</td>
            <td>{{ contarParametros(detalle.dias, 'domingo_feriado', 'sumar') }}</td>
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
  calcularDiferenciaHoras(dia) {
    // Obtener entrada y salida como cadenas en formato "hh:mm:ss"
    const entrada = dia.detalle.entrada; // Ejemplo: "08:00:00"
    const salida = dia.detalle.salida; // Ejemplo: "17:00:00"

    // Convertimos las horas, minutos y segundos a valores numéricos
    const [entradaHoras, entradaMinutos, entradaSegundos] = entrada.split(':').map(Number);
    const [salidaHoras, salidaMinutos, salidaSegundos] = salida.split(':').map(Number);

    // Convertimos ambos tiempos a minutos
    const minutosEntrada = entradaHoras * 60 + entradaMinutos + entradaSegundos / 60;
    const minutosSalida = salidaHoras * 60 + salidaMinutos + salidaSegundos / 60;

    // Calculamos la diferencia en minutos
    const diferenciaMinutos = minutosSalida - minutosEntrada;

    // Convertimos la diferencia a horas y minutos
    const horasTrabajadas = Math.floor(diferenciaMinutos / 60);
    const minutosTrabajados = Math.floor(diferenciaMinutos % 60);

    // Devolvemos las horas trabajadas en formato "horas:minutos"
    return `${horasTrabajadas}:${minutosTrabajados.toString().padStart(2, '0')}`;
},
contarHoras(dias) {
  let totalHorasExtras = 0;

  console.log(dias); // Log para verificar los datos de entrada

  dias.forEach(dia => {
    // Verificar si el día es válido y si "dia_semana_sn" es igual a 1
    if (dia && dia.parametro && dia.parametro.dia_semana_sn === 1) {
      if (dia.detalle && dia.detalle.entrada && dia.detalle.salida) {
        const entrada = this.convertirHoraADate(dia.detalle.entrada);
        const salida = this.convertirHoraADate(dia.detalle.salida);

        // Calcular la diferencia en horas
        const horasTrabajadas = (salida - entrada) / (1000 * 60 * 60);

        // Calcular las horas extras trabajadas
        const horasLaborables = this.frente_selected.horas_diarias_laborables;
        if (horasTrabajadas > horasLaborables) {
          totalHorasExtras += horasTrabajadas - horasLaborables;
        }
      }
    }
  });

  // Actualizar acumulación global (opcional)
  this.acumulacionHorasExtras = totalHorasExtras;

  // Formatear las horas extras como "HH:MM"
  return this.formatearHorasExtras(totalHorasExtras);
},

    convertirHoraADate(hora) {
      // Convertir una cadena "HH:mm:ss" a un objeto Date
      const [h, m, s] = hora.split(":").map(Number);
      const date = new Date();
      date.setHours(h, m, s || 0, 0);
      return date;
    },

    formatearHorasExtras(horasExtras) {
      // Convertir un número decimal a formato "HH:MM"
      const horas = Math.floor(horasExtras);
      const minutos = Math.round((horasExtras - horas) * 60);
      return `${horas}:${minutos.toString().padStart(2, "0")}`;
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
    // Convertimos las horas de entrada y salida a objetos Date
    const [entradaHoras, entradaMinutos, entradaSegundos] = detalle.entrada.split(':').map(Number);
    const [salidaHoras, salidaMinutos, salidaSegundos] = detalle.salida.split(':').map(Number);

    // Creamos fechas ficticias para calcular la diferencia
    const entrada = new Date(0, 0, 0, entradaHoras, entradaMinutos, entradaSegundos);
    const salida = new Date(0, 0, 0, salidaHoras, salidaMinutos, salidaSegundos);

    // Calculamos la diferencia en milisegundos
    const diferenciaMs = salida - entrada;

    // Convertimos la diferencia a horas y minutos
    const horas = Math.floor(diferenciaMs / (1000 * 60 * 60));
    const minutos = Math.floor((diferenciaMs % (1000 * 60 * 60)) / (1000 * 60));

    const horasTrabajadas = `${horas}:${minutos.toString().padStart(2, '0')}`;

    console.log('Horas trabajadas:', horasTrabajadas);
 
    return horasTrabajadas;
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
    // Verificar que se haya seleccionado un mes antes de continuar
    if (!this.selectedDate) {
        console.log("Por favor, seleccione un mes y año antes de continuar.");
        this.asistenciaDatos = {}; // Limpiar la tabla si no hay mes
        this.isLoading = false; // Finalizar la carga
        return; // Salir si no hay mes seleccionado
    }

    this.isLoading = true; // Indicar que la carga ha comenzado

    console.log("Frente:", this.frente_selected);
    console.log("Fecha:", this.selectedDate);

    const formattedDate = this.selectedDate.getFullYear() + '-' + ('0' + (this.selectedDate.getMonth() + 1)).slice(-2);
    console.log("Fecha formateada:", formattedDate);

    try {
        // Esperar a que getDiasDelMes termine
        const diasDelMes = await this.getDiasDelMes(this.selectedDate.getFullYear(), this.selectedDate.getMonth() + 1);
        console.log("Días del mes:", diasDelMes);

        const response = await axios.get('/api/asistencia-operadores-datos', {
            params: {
                frente_id: this.frente_selected.id,
                fecha: formattedDate
            }
        });

        console.log("Respuesta de la API:", response.data);

        // Comprobar si hay datos en la respuesta
        if (response.data.length === 0) {
            console.log("No se encontraron datos para la consulta");
            this.asistenciaDatos = {}; // Limpiar la tabla
            return; // Salir si no hay datos
        }

        // Inicializar un objeto para almacenar los datos reorganizados
        let asistenciaReorganizada = {};

        // Iterar sobre cada operador en la respuesta
        for (let operador in response.data) {
            // Obtener los datos de ayudante_sn y operador_id (presente en todas las fechas del operador)
            const operadorData = response.data[operador][0]; // Obtener el primer dato para estos valores
            const ayudante_sn = operadorData?.ayudante_sn || null;
            const operador_id = operadorData?.detalle?.operador_id || null;

            // Inicializar una matriz para cada operador que contenga los días del mes
            asistenciaReorganizada[operador] = {
                // Agregar los datos adicionales (ayudante_sn y operador_id)
                ayudante_sn: ayudante_sn,
                operador_id: operador_id,
                dias: diasDelMes.map(dia => {
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
                })
            };
        }

        // Ordenar los operadores alfabéticamente
        const operadoresOrdenados = Object.keys(asistenciaReorganizada).sort();

        // Crear un nuevo objeto con los operadores ordenados
        const asistenciaReorganizadaOrdenada = {};
        operadoresOrdenados.forEach(operador => {
            asistenciaReorganizadaOrdenada[operador] = asistenciaReorganizada[operador];
        });

        console.log("Datos reorganizados por operador (ordenados):", asistenciaReorganizadaOrdenada);

        // Asignar los datos obtenidos
        this.asistenciaDatos = asistenciaReorganizadaOrdenada;
        this.diasDelMes = diasDelMes;

    } catch (error) {
        console.error("Error al llamar a la API:", error);
        this.asistenciaDatos = {}; // Limpiar la tabla en caso de error
    } finally {
        // Finalizar la carga independientemente de si hubo error o no
        this.isLoading = false;
    }
},
contarParametros(detalle, parametro, tipo) {
    return detalle.reduce((contador, dia) => {
        if (dia && dia.parametros) {
            const parametros = dia.parametros; // Accedemos a dia.parametros

            // Para contar horas extra
            if (tipo === 'sumar' && parametro === 'hora_extra_sn' && dia.detalle[parametro] === 1) {
              const diferenciaHoras = this.calcularDiferenciaHoras(dia);
              
                if (diferenciaHoras > 0) {
                    return contador + diferenciaHoras; // Solo sumamos si la diferencia es positiva
                } // Sumar solo los casos donde hora_extra_sn es 1
            }

            // Para contar contratistas
            if (tipo === 'conteo' && parametro === 'contratista_id' && dia.detalle[parametro] !== null) {
                return contador + 1; // Contar solo si contratista_id no es null
            }

            // Contar solo sábados
            if (tipo === 'sumar' && parametro === 'sabado') {
                if (parametros.sabado_sn === 1 && dia.detalle.s_d_f_sn === 1 && dia.detalle.contratista_id === null) {
                  
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
  const modo = 'Horas'; // Nuevo parámetro

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
