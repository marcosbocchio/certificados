<template>
    <div>
        <loading :active.sync="isLoading" :loader="'bars'" :color="'red'"></loading>

        <div>
            <p>Registros encontrados en la base de datos: {{ totalRegistros }}</p>
            <p>Archivos encontrados en storage: {{ totalEncontrados }}</p>
            <p>Archivos sobrantes en storage: {{ totalSobrantes }}</p>
        </div>

        <button @click="prepararParaBorrar" class="btn btn-danger">Preparar para borrar</button>

        <div v-if="sobrantes.length > 0">
            <h4>Archivos sobrantes:</h4>
            <ul>
                <li v-for="(archivo, index) in sobrantes" :key="index">{{ archivo }}</li>
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
            sobrantes: [],
        };
    },
    methods: {
        async prepararParaBorrar() {
            this.isLoading = true;
            try {
                const response = await axios.get('/api/documentaciones');
                const { total_registros, total_encontrados, total_sobrantes, sobrantes } = response.data;

                this.totalRegistros = total_registros;
                this.totalEncontrados = total_encontrados;
                this.totalSobrantes = total_sobrantes;
                this.sobrantes = sobrantes;

                toastrDefault('Archivos listos para borrar.', 'Información');
            } catch (error) {
                toastrWarning('Ocurrió un error al preparar los archivos para borrar.', 'Error');
            } finally {
                this.isLoading = false;
            }
        },
        async borrarArchivos() {
            this.isLoading = true;
            try {
                const response = await axios.post('/api/documentaciones/borrar', {
                    paths: this.sobrantes,
                });

                toastrDefault(response.data.message, 'Éxito');
                this.sobrantes = [];
                this.totalSobrantes = 0;
            } catch (error) {
                toastrWarning('Ocurrió un error al borrar los archivos.', 'Error');
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
