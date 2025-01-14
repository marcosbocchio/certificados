<template>
    <div>
        <loading :active.sync="isLoading" :loader="'bars'" :color="'red'"></loading>

        <div>
            <p>Registros encontrados en la base de datos: {{ totalRegistros }}</p>
            <p>Archivos encontrados en storage: {{ totalEncontrados }}</p>
            <p>Archivos sobrantes en storage: {{ totalSobrantes }}</p>
        </div>

        <button @click="recuperarPaths" class="btn btn-primary">Recuperar Paths</button>
        <button @click="verArchivosEnStorage" class="btn btn-info">Ver Archivos en Storage</button>
        <button @click="compararArchivos" class="btn btn-warning">Comparar Archivos</button>


        <div v-if="archivosEnStorage.length > 0">
            <h4>Archivos en Storage:</h4>
            <ul>
                <li v-for="(archivo, index) in archivosEnStorage" :key="index">{{ archivo }}</li>
            </ul>
        </div>

        <div v-if="sobrantes.length > 0">
            <h4>Archivos sobrantes:</h4>
            <ul>
                <li v-for="(archivo, index) in sobrantes" :key="index">{{ archivo }}</li>
            </ul>
        </div>

        <div v-if="encontrados.length > 0">
            <h4>Archivos encontrados:</h4>
            <ul>
                <li v-for="(archivo, index) in encontrados" :key="index">{{ archivo }}</li>
            </ul>
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
        };
    },
    methods: {
        async recuperarPaths() {
            this.isLoading = true;
            try {
                const response = await axios.get('/api/documentaciones/limpiar/paths');
                const { documentaciones, total_registros } = response.data;

                this.documentaciones = documentaciones;
                this.totalRegistros = total_registros;

                toastrDefault('Paths recuperados correctamente.', 'Información');
            } catch (error) {
                toastrWarning('Ocurrió un error al recuperar los paths.', 'Error');
            } finally {
                this.isLoading = false;
            }
        },

        async verArchivosEnStorage() {
    this.isLoading = true;
    try {
        const response = await axios.get('/api/documentaciones/limpiar/storage');
        const { archivosEnStorage, total_archivos_storage } = response.data;

        this.archivosEnStorage = archivosEnStorage || [];
        this.totalEncontrados = total_archivos_storage || 0;

        toastrDefault('Archivos en storage recuperados correctamente.', 'Información');
    } catch (error) {
        toastrWarning('Ocurrió un error al recuperar los archivos en storage.', 'Error');
        console.error('Error al obtener archivos en storage:', error);
    } finally {
        this.isLoading = false;
    }
}
,

async compararArchivos() {
    this.isLoading = true;
    try {
        // Validar que se hayan recuperado previamente los datos
        if (this.documentaciones.length === 0) {
            toastrWarning('Primero recupera los paths desde la base de datos.', 'Advertencia');
            return;
        }
        if (this.archivosEnStorage.length === 0) {
            toastrWarning('Primero recupera los archivos desde el storage.', 'Advertencia');
            return;
        }

        // Convertir los paths en un conjunto para una búsqueda más rápida
        const pathsSet = new Set(this.documentaciones); // Paths desde la base de datos

        // Filtrar los archivos que están en el storage pero no en la base de datos
        const sobrantes = this.archivosEnStorage.filter(
            (archivo) => !pathsSet.has(archivo) // Archivos sobrantes
        );

        // Actualizar los resultados
        this.sobrantes = sobrantes;
        this.totalSobrantes = sobrantes.length;

        toastrDefault('Comparación realizada correctamente. Archivos sobrantes identificados.', 'Información');
    } catch (error) {
        toastrWarning('Ocurrió un error al realizar la comparación.', 'Error');
        console.error('Error al comparar archivos:', error);
    } finally {
        this.isLoading = false;
    }
},

    },
};
</script>

<style>
.fuenteTitulo {
    font-weight: bold;
}
</style>
