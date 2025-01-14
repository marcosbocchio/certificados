<template>
    <div class="cleaner-container">
        <loading :active.sync="isLoading" :loader="'bars'" :color="'#3498db'"></loading>

        <div class="info-section">
            <p>
                <i class="fa fa-database"></i> Registros encontrados en la base de datos: 
                <span class="highlight">{{ totalRegistros }}</span>
            </p>
            <p>
                <i class="fa fa-folder"></i> Archivos encontrados en storage: 
                <span class="highlight">{{ totalEncontrados }}</span>
            </p>
            <p>
                <i class="fa fa-trash"></i> Archivos sobrantes en storage: 
                <span class="highlight">{{ totalSobrantes }}</span>
            </p>
        </div>

        <div class="buttons-section">
            <button @click="compararArchivosCompletos" class="btn btn-primary">
                <i class="fa fa-broom"></i> Limpiar y Comparar
            </button>
            <button 
                @click="borrarSobrantes" 
                class="btn btn-danger" 
                :disabled="sobrantes.length === 0"
            >
                <i class="fa fa-trash"></i> Borrar Sobrantes
            </button>
        </div>

        <div v-if="sobrantes.length > 0" class="sobrantes-section">
            <h4>
                <i class="fa fa-exclamation-circle"></i> Archivos sobrantes:
            </h4>
            <button @click="toggleSobrantes" class="btn btn-secondary">
                <i class="fa" :class="mostrarSobrantes ? 'fa-eye-slash' : 'fa-eye'"></i>
                {{ mostrarSobrantes ? 'Ocultar' : 'Mostrar' }} Archivos Sobrantes
            </button>

            <div v-show="mostrarSobrantes" class="sobrantes-list">
                <ul>
                    <li v-for="(archivo, index) in sobrantes" :key="index">
                        <span>{{ archivo }}</span>
                        <a
                            :href="`/storage/${archivo}`"
                            target="_blank"
                            class="btn btn-link btn-sm"
                        >
                            <i class="fa fa-eye"></i> Ver
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import { toastrWarning, toastrDefault } from '../toastrConfig';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    components: {
        Loading,
    },
    data() {
        return {
            isLoading: false,
            totalRegistros: 0,
            totalEncontrados: 0,
            totalSobrantes: 0,
            documentaciones: [],
            archivosEnStorage: [],
            sobrantes: [],
            encontrados: [],
            mostrarSobrantes: false,
        };
    },
    methods: {
        toggleSobrantes() {
            this.mostrarSobrantes = !this.mostrarSobrantes;
        },

        async compararArchivosCompletos() {
            this.isLoading = true;
            try {
                const pathsResponse = await axios.get('/api/documentaciones/limpiar/paths');
                const { documentaciones, total_registros } = pathsResponse.data;
                this.documentaciones = documentaciones;
                this.totalRegistros = total_registros;

                const storageResponse = await axios.get('/api/documentaciones/limpiar/storage');
                const { archivosEnStorage, total_archivos_storage } = storageResponse.data;
                this.archivosEnStorage = archivosEnStorage || [];
                this.totalEncontrados = total_archivos_storage || 0;

                const pathsSet = new Set(this.documentaciones);
                const sobrantes = this.archivosEnStorage.filter((archivo) => !pathsSet.has(archivo));

                this.sobrantes = sobrantes;
                this.totalSobrantes = sobrantes.length;

                toastrDefault('Limpieza y comparación completadas. Archivos sobrantes identificados.', 'Información');
            } catch (error) {
                toastrWarning('Ocurrió un error durante la limpieza y comparación.', 'Error');
                console.error('Error en limpieza completa:', error);
            } finally {
                this.isLoading = false;
            }
        },

        async borrarSobrantes() {
            if (this.sobrantes.length === 0) {
                toastr.error('No hay archivos sobrantes para eliminar.');
                return;
            }

            this.isLoading = true;
            try {
                const response = await axios.post('/api/documentaciones/limpiar/eliminar', {
                    sobrantes: this.sobrantes,
                });

                if (response.data.success) {
                    toastr.success('Archivos sobrantes eliminados correctamente.');
                    this.sobrantes = [];
                    this.totalSobrantes = 0;
                } else {
                    toastr.error('Ocurrió un error al intentar eliminar los archivos sobrantes.');
                }
            } catch (error) {
                toastr.error('No se pudo completar la eliminación de archivos.');
                console.error('Error al eliminar archivos sobrantes:', error);
            } finally {
                this.isLoading = false;
            }
        },
    },
};
</script>

<style scoped>
.cleaner-container {
    padding: 30px;
    border-radius: 15px;
    background: #ffffff;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    max-width: 900px;
    margin: 20px auto;
    font-family: 'Roboto', sans-serif;
}

.info-section p {
    font-size: 1.1rem;
    color: #34495e;
    margin-bottom: 8px;
}

.highlight {
    font-weight: bold;
    color: #2ecc71;
}

.buttons-section {
    display: flex;
    gap: 20px;
    justify-content: center;
    margin-top: 20px;
}

.buttons-section button {
    padding: 12px 20px;
    border-radius: 30px;
    font-size: 1rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.buttons-section button:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

.sobrantes-section {
    margin-top: 30px;
    padding: 20px;
    background-color: #f9fafb;
    border: 1px solid #e1e4e8;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
}

.sobrantes-section h4 {
    color: #e74c3c;
    font-weight: 500;
    margin-bottom: 15px;
}

.sobrantes-list ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sobrantes-list li {
    display: flex;
    justify-content: space-between;
    padding: 12px;
    margin-bottom: 10px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
}

.sobrantes-list li:hover {
    background-color: #f1f1f1;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.sobrantes-list a {
    text-decoration: none;
    color: #3498db;
    font-weight: bold;
    transition: color 0.3s ease;
}

.sobrantes-list a:hover {
    color: #2980b9;
}
</style>
