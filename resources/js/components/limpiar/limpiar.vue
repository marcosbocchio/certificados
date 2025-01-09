<template>
    <div>
        <loading :active.sync="isLoading"
            :loader="'bars'"
            :color="'red'">
        </loading>
    </div>
</template>

<script>

import { toastrWarning,toastrDefault } from '../toastrConfig';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import {mapState} from 'vuex';

export default {
    components: {
        Loading
    },
    data() {
        return {
            }
        },
    methods: {
    }
}
</script>
<style>
    .fuenteTitulo{
        font-weight: bold;
    }
</style>
