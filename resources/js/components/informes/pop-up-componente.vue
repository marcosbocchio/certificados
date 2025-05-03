<template>
  <div
    v-if="isOpen"
    id="modalPopup"
  >
    <form @submit.prevent="storeRegistro" method="post">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Encabezado del Modal -->
            <div class="modal-header">
              <button type="button" class="close" @click="closeModal" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title">Agregar Detalles</h4>
            </div>
  
            <!-- Cuerpo del Modal con estilos de tu app -->
            <div class="modal-body">
              <!-- Box 1: Datos Generales -->
              <div class="box box-custom-enod">
                <div class="box-body">
                  <!-- Primera fila de 4 inputs -->
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="planta">Planta *</label>
                        <input type="text" id="planta" v-model="planta" class="form-control" disabled>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="area">Área *</label>
                        <input type="text" id="area" v-model="area" maxlength="20" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="orden">Orden *</label>
                        <input type="text" id="orden" v-model="orden" class="form-control" disabled>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="tipo">Tipo *</label>
                        <v-select id="tipo" :options="tipoOptions" v-model="tipo"></v-select>
                      </div>
                    </div>
                  </div>
                  <!-- Segunda fila de 4 inputs -->
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="nEquipo">N° de Equipo *</label>
                        <input type="text" id="nEquipo" v-model="nEquipo" class="form-control" disabled>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group d-flex">
                        <label>Modelo *</label>
                        <v-select
                          v-model="modelo"
                          label="codigo"
                          :options="modeloOptions"
                          taggable
                        >
                          <template slot="option" slot-scope="option">
                            <span class="upSelect">{{ option.codigo }}</span><br>
                            <span class="downSelect">{{ option.descripcion }}</span>
                          </template>
                        </v-select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="denominacion">Denominación *</label>
                        <input type="text" id="denominacion" v-model="denominacion" maxlength="30" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="anio">Año *</label>
                        <input type="number" id="anio" v-model="anio"  min="0" max="9999" class="form-control">
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-3">
                            <div class="form-group" >
                                <subir-imagen
                                    :ruta="ruta_componente_us"
                                    :max_size="max_size"
                                    :path_inicial="path3_componente"
                                    :tipos_archivo_soportados ="tipos_archivo_soportados"
                                    :mostrar_formatos_soportados="true"
                                    @path="onPath"
                                ></subir-imagen>
                          </div>
                      </div>
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
  
              <hr>
  
              <!-- Box 2: Calibraciones -->
              <div class="box box-custom-enod">
                <div class="box-header with-border">
                  <h3 class="box-title">MATERIAL</h3>
                </div>
                <div class="box-body">
                  <!-- Inputs para detalle -->
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="detalleDescripcion">Descripción</label>
                        <input type="text" id="detalleDescripcion" v-model="detalle.descripcion" maxlength="30" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="detalleMaterial">Material</label>
                        <v-select
                          v-model="detalle.material"
                          :options="materialesOpcion"
                          label="codigo"
                        />
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="detalleGrado">Grado</label>
                        <input type="number" id="detalleGrado" v-model="detalle.grado" min="0" max="9999" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="detalleEspNominal">Esp. Nominal</label>
                        <input type="number" id="detalleEspNominal" v-model="detalle.espNominal" min="0" max="9999"  class="form-control">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="detalleEspMinMedido">Esp. Min Medido</label>
                        <input type="number" id="detalleEspMinMedido" v-model="detalle.espMinMedido" min="0" max="9999" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                      <button type="button" style="margin-top: 25px;" @click="addDetalle">
                        <span class="fa fa-plus-circle"></span>
                      </button>
                    </div>
                  </div>
                  <!-- Tabla de detalles -->
                  <div class="row" v-if="detallesList.length">
                    <div class="col-md-12">
                      <table class="table table-bordered table-hover table-striped table-condensed">
                        <thead>
                          <tr>
                            <th>Descripción</th>
                            <th>Material</th>
                            <th>Grado</th>
                            <th>Esp. Nominal</th>
                            <th>Esp. Min Medido</th>
                            <th>Acción</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(item, index) in detallesList" :key="index">
                            <td>{{ item.descripcion }}</td>
                            <td>{{ item.material.codigo }}</td>
                            <td>{{ item.grado }}</td>
                            <td>{{ item.espNominal }}</td>
                            <td>{{ item.espMinMedido }}</td>
                            <td>
                              <span class="fa fa-minus-circle" @click="removeDetalle(index)"></span> 
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
  
              <hr>
  
              <!-- Box 3: Información Adicional -->
              <div class="box box-custom-enod">
                <div class="box-body">
                  <div class="row">
                    <!-- Sección: Temperatura -->
                    <div class="box-header with-border">
                      <h3 class="box-title">TEMPERATURA</h3>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Diseño Temp</label>
                        <input type="number" v-model="temp.disenio" min="0" max="9999" step="0.01" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Operación Temp</label>
                        <input type="number" v-model="temp.operacion" min="0" max="9999" step="0.01" class="form-control">
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <!-- Sección: Presión -->
                    <div class="box-header with-border">
                      <h3 class="box-title">PRESIÓN</h3>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Diseño Presión</label>
                        <input type="number" v-model="pres.disenio" min="0" max="9999" step="0.01" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Operación Presión</label>
                        <input type="number" v-model="pres.operacion" min="0" max="9999" step="0.01" class="form-control">
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="box-header with-border"></div>
                    <div class="col-md-3">
                      <div class="form-group d-flex">
                        <label>Fluido</label>
                        <v-select
                          v-model="fluido"
                          :options="fluidoOptions"
                          label="codigo"
                          taggable                  
                          >
                            <template slot="option" slot-scope="option">
                                <span class="upSelect">{{ option.codigo }}</span><br>
                                <span class="downSelect">{{ option.descripcion }}</span>
                            </template>
                          </v-select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Sobreespesor</label>
                        <input type="number" v-model="sobreespesor" min="0" max="9999" step="0.01" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Diam. Exterior</label>
                        <input type="number" v-model="diamExterior" min="0" max="99999999" step="0.01" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Longitud Total</label>
                        <input type="number" v-model="longitudTotal" min="0" max="99999999" step="0.01" class="form-control">
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Trat. Termico</label>
                        <v-select :options="siNoOptions" v-model="trat_termico"></v-select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>radiografiado %</label>
                        <input type="number" v-model="radiografiado" min="1" max="100" step="0.01" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Norma Fabricación</label>
                        <v-select :options="normaFabricacionOptions" label="codigo" v-model="normaFabricacion">
                          <template slot="option" slot-scope="option">
                                <span class="upSelect">{{ option.codigo }}</span><br>
                                <span class="downSelect">{{ option.descripcion }}</span>
                            </template>
                        </v-select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Aislación</label>
                        <v-select :options="siNoOptions" v-model="aislacion" placeholder="Seleccione"></v-select>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-3">
                      <div class="form-group d-flex">
                        <label>Tipo</label>
                        <v-select
                          v-model="tipo2"
                          :options="tipo2Options"
                          label="codigo"
                          taggable     
                        >
                        <template slot="option" slot-scope="option">
                                <span class="upSelect">{{ option.codigo }}</span><br>
                                <span class="downSelect">{{ option.descripcion }}</span>
                            </template>
                      </v-select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Material</label>
                        <v-select :options="materialOptions" v-model="material" label="codigo" placeholder="Seleccione">
                          <template slot="option" slot-scope="option">
                                <span class="upSelect">{{ option.codigo }}</span><br>
                                <span class="downSelect">{{ option.descripcion }}</span>
                            </template>
                        </v-select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Espesor</label>
                        <input type="text" v-model="espesor" placeholder="Espesor" step="0.01" class="form-control">
                      </div>
                    </div>
                  </div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.modal-body -->
            
            <!-- Pie del Modal -->
            <div class="modal-footer">
              <input type="submit" class="btn btn-primary" value="Guardar">
              <button type="button" class="btn btn-default" @click="closeModal">Cancelar</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </form>
    </div>
  </template>
  
  <script>
  export default {
    name: 'ModalPopup',
    props: {
      isOpen: {
        type: Boolean,
        default: false
      },
        plantaProp: {
        type: Object,
        default: () => ({})
      },
        otdataProp: {
        type: Object,
        default: () => ({})
      },
        materialesProp: {
          type: Array,
          default: () => []
      },
        nEquipoProp: {
        type: String,
        default: ''
      }
    },
    data() {
      return {
        // Sección 1: Datos Generales
        ruta_componente_us:'componente_us',
        path3_componente:'',
        max_size :5000, //KB
        tipos_archivo_soportados:['jpg','bmp','jpeg','png'],
        planta: '',
        area: '',
        orden: '',
        tipo: null,
        tipoOptions: ['Horizontal', 'Vertical'],
        nEquipo: '',
        modelo: '',
        materialesOpcion:'',
        modeloOptions: [],
        denominacion: '',
        anio: '',
        // Sección 2: Detalle para la tabla
        detalle: {
          descripcion: '',
          material:'',
          grado: '',
          espNominal: '',
          espMinMedido: ''
        },
        detallesList: [],
        // Sección 3: Temperatura / Presión
        temp: {
          disenio: '',
          operacion: ''
        },
        pres: {
          disenio: '',
          operacion: ''
        },
        // Sección 4: Fluido, Sobreespesor, Diam. Exterior y Longitud Total
        fluido: '',
        fluidoOptions: [],
        sobreespesor: '',
        diamExterior: '',
        longitudTotal: null,
        longitudTotalOptions: [],
        // Sección 5: radiografiado, Norma Fabricación, Aislación y Tipo
        radiografiado: null,
        trat_termico: '',
        siNoOptions: ['Si', 'No'],
        normaFabricacion: null,
        normaFabricacionOptions: [],
        aislacion: null,
        tipo2: '',
        tipo2Options: ['FRIO', 'CALOR'],
        // Sección 6: Material y Espesor
        material: null,
        otdata: '',
        materialOptions: [],
        espesor: ''
      }
    },
    watch: {
    // Cada vez que abra el modal, sincronizo los props a mi data interna:
    isOpen(val) {
      if (val) {
        this.planta           = this.plantaProp.codigo
        this.nEquipo          = this.nEquipoProp
        this.materialesOpcion = this.materialesProp
        this.orden            = this.otdataProp.numero
          // Llamadas a la API
        this.fetchModelos();
        this.fetchFluidos();
        this.fetchNormas();
        this.fetchMateriales();
        console.log(this.modeloOptions);
      }
    }
  },
    methods: {
      setForm(item){ 
        console.log('entra la funcion');
        var componente = item;
        console.log(componente);
        this.area = componente.area                           ?? "";
        this.tipo = componente.tipo_us                        ?? "";
        this.modelo = componente.modelo                       ?? "";
        this.denominacion = componente.denominacion           ?? "";
        this.anio = componente.año                            ?? "";
        this.detallesList = componente.materiales             ?? "";
        this.temp.disenio = componente.temp_diseño            ?? "";
        this.temp.operacion = componente.temp_operacion       ?? "";
        this.pres.disenio = componente.presion_diseño         ?? "";
        this.pres.operacion = componente.presion_operacion    ?? "";
        this.sobreespesor = componente.sobreespesor_por_corrocion ?? "";
        this.diamExterior = componente.diam_exterior          ?? "";
        this.longitudTotal = componente.longitud_total        ?? "";
        this.trat_termico = componente.tratamiento_termico    ?? "";
        this.espesor = componente.espesor                     ?? "";
        this.radiografiado = componente.radiografiado         ?? "";
        this.normaFabricacion = componente.norma              ?? "";
        this.aislacion = componente.aislacion                 ?? "";
        this.tipo2 = componente.tipo                          ?? "";
        this.material = componente.material                   ?? "";
        this.fluido = componente.fluido                       ?? "";
        this.path3_componente = componente.path3_componente   ?? "";
        console.log('cargado');
        console.log(this.anio);

        this.detallesList = componente.materiales.map(m => {
          return {
            descripcion: m.descripcion,
            material: { codigo: m.material },
            grado: m.grado,
            espNominal: m.espesor_nominal,
            espMinMedido: m.espesor_minimo_medido
          };
        });
        this.storeRegistro();
      },
      async storeRegistro() {
        // 1) Si modelo no tiene id, lo creamos
        if (!this.modelo.id) {
          const { data: nuevoModelo } = await axios.post(
            `/tgs-save-modelo/${this.modelo.codigo}`
          );
          this.modelo = nuevoModelo;
        }

        // 2) Lo mismo para el fluido
        if (!this.fluido.id) {
          const { data: nuevoFluido } = await axios.post(
            `/tgs-save-fluido/${this.fluido.codigo}`
          );
          this.fluido = nuevoFluido;
        }
        console.log(this.material);
        // 3) Ya con ambos id garantizados, armo el objeto
        const popupData = {
          // Sección 1
          path3_componente: this.path3_componente,
          planta: this.planta,
          area: this.area,
          orden: this.orden,
          tipo: this.tipo,
          nEquipo: this.nEquipo,
          modelo: this.modelo,
          denominacion: this.denominacion,
          anio: this.anio,
          // Sección 2
          detalles: this.detallesList,
          // Sección 3
          temperatura: this.temp,
          presion: this.pres,
          // Sección 4
          fluido: this.fluido,
          sobreespesor: this.sobreespesor,
          diamExterior: this.diamExterior,
          longitudTotal: this.longitudTotal,
          // Sección 5
          trat_termico: this.trat_termico,
          radiografiado: this.radiografiado,
          normaFabricacion: this.normaFabricacion,
          aislacion: this.aislacion,
          tipo2: this.tipo2,
          // Sección 6
          material: this.material,
          espesor: this.espesor
        };

        console.log('Datos listos para enviar:', popupData);
        this.$emit('submit', popupData);
        this.closeModal();
      },

      onPath(path) {
      console.log('⚡ subir-imagen emitió path:', path);
      this.path3_componente = path;
    },
      closeModal() {
        this.$emit('close')
      },
      onNewTagModelo(nuevo) {
        // 1) agrego la nueva etiqueta al listado de opciones
        this.modeloOptions.push(nuevo)
        // 2) lo selecciono automáticamente
        this.modelo = nuevo
      },
      addDetalle() {
  // 1) Compruebo que haya al menos un campo llenado
  if (
    this.detalle.descripcion ||
    this.detalle.grado !== '' ||
    this.detalle.espNominal !== '' ||
    this.detalle.espMinMedido !== ''
  ) {
    // 2) Validaciones de números y longitud
    const camposNum = [
      { key: 'grado', label: 'Grado' },
      { key: 'espNominal', label: 'Espesor Nominal' },
      { key: 'espMinMedido', label: 'Espesor Mínimo Medido' }
    ];

    for (const { key, label } of camposNum) {
      const val = this.detalle[key];

      // Solo validamos si el campo no está vacío
      if (val !== '' && val != null) {
        // 2.1) Debe ser un número
        if (isNaN(val)) {
          toastr.error(`${label} debe ser un número`);
          return;
        }

        // 2.2) La parte entera no puede tener más de 4 dígitos
        const entero = Math.trunc(Math.abs(val));
        if (String(entero).length > 4) {
          toastr.error(`${label} no puede tener más de 4 dígitos`);
          return;
        }
      }
    }

    // 4) Si todo OK, agrego el detalle
    this.detallesList.push({ ...this.detalle });

    // 5) Limpio el formulario
    this.detalle.material = '';
    this.detalle.descripcion    = '';
    this.detalle.grado          = '';
    this.detalle.espNominal     = '';
    this.detalle.espMinMedido   = '';
  }
},
async fetchModelos() {
  try {
    const response = await axios.get('/tgs/modelos-us-me');
    this.modeloOptions = response.data.map(item => item);
    console.log("asdasd", this.modeloOptions);
  } catch (error) {
    console.error('Error al obtener modelos:', error);
  }
},
async fetchFluidos() {
  try {
    const response = await axios.get('/tgs/fluidos-us-me');
    this.fluidoOptions = response.data.map(item => item);
  } catch (error) {
    console.error('Error al obtener fluidos:', error);
  }
},
async fetchNormas() {
  try {
    const response = await axios.get('/tgs/normas-fabricacion-us-me');
    this.normaFabricacionOptions = response.data.map(item => item);
  } catch (error) {
    console.error('Error al obtener normas:', error);
  }
},
async fetchMateriales() {
  try {
    const response = await axios.get('/materiales');
    this.materialOptions = response.data.map(item => item);
  } catch (error) {
    console.error('Error al obtener tipos:', error);
  }
},
      removeDetalle(index) {
        this.detallesList.splice(index, 1)
      },
      addFluido(nuevo) {
        // 1) agrego la nueva etiqueta al listado de opciones
        this.fluidoOptions.push(nuevo)
        // 2) lo selecciono automáticamente
        this.fluido = nuevo
      },
    }
  }
  </script>
  
  <style scoped>
  #modalPopup {
    position: fixed;       /* ocupa toda la pantalla */
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;         /* flex para centrar */
    align-items: center;   /* centrar vertical */
    justify-content: center;/* centrar horizontal */
    background: rgba(0,0,0,0.5); /* overlay oscuro */
    z-index: 9999;         /* por encima de todo */
  }
  /* Opcional: controla el overflow si el modal crece mucho */
  .modal-dialog {
    margin: 0;             /* elimina márgenes por defecto */
  }
  .modal-content {
    max-height: 90vh;
    overflow-y: auto;
  }
  </style>
  