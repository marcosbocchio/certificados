<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Barra de filtros del listado</div>
        <div class="box box-custom-enod ayuda_real_box">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <label>Cliente</label>
                            <select class="form-control input-sm" v-model="filtros.cliente">
                                <option value="">Todos</option>
                                <option>YPF S.A.</option>
                                <option>Techint Ingeniería</option>
                                <option>Pampa Energía</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-6">
                        <div class="form-group">
                            <label>Estado</label>
                            <select class="form-control input-sm" v-model="filtros.estado">
                                <option value="">Todos</option>
                                <option>Editando</option>
                                <option>Activa</option>
                                <option>Cerrada</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-6">
                        <div class="form-group">
                            <label>Desde</label>
                            <input type="text" class="form-control input-sm" v-model="filtros.desde" placeholder="dd/mm/aaaa" />
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-6">
                        <div class="form-group">
                            <label>Hasta</label>
                            <input type="text" class="form-control input-sm" v-model="filtros.hasta" placeholder="dd/mm/aaaa" />
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label>Buscar</label>
                            <input type="text" class="form-control input-sm" v-model="filtros.texto" placeholder="N° OT, proyecto, obra..." />
                        </div>
                    </div>
                </div>
                <div class="enod-form-actions enod-form-actions--end">
                    <button class="btn btn-default btn-sm" @click="reset"><i class="fa fa-eraser"></i>&nbsp; Limpiar</button>
                    <button class="btn btn-enod btn-sm"><i class="fa fa-filter"></i>&nbsp; Filtrar</button>
                </div>
            </div>
        </div>
        <div class="ayuda_demo_caption">
            Los filtros se combinan: si elegís un cliente y un estado, la tabla queda restringida a OT que cumplan ambos.
            Un cliente externo ve solo sus propias OT.
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-filtros-ot',
    data() {
        return {
            filtros: { cliente: '', estado: 'Activa', desde: '', hasta: '', texto: '' },
        };
    },
    methods: {
        reset() { this.filtros = { cliente: '', estado: '', desde: '', hasta: '', texto: '' }; },
    },
};
</script>

<style scoped>
.ayuda_demo_block { margin: 16px 0 20px; font-family: 'Montserrat', sans-serif; }
.ayuda_demo_label {
    font-size: 11px; color: #6b7280;
    text-transform: uppercase; letter-spacing: 0.06em;
    margin-bottom: 8px; font-weight: 700;
}
.ayuda_real_box {
    border: 1px solid #eef0f3;
    border-top: 3px solid #FFCC00;
    border-radius: 4px;
    box-shadow: none;
}
.ayuda_real_box label { font-size: 11px; color: #4c5661; text-transform: uppercase; letter-spacing: 0.03em; margin-bottom: 4px; font-weight: 700; }
.ayuda_real_box .form-group { margin-bottom: 8px; }
.enod-form-actions { border-top: 1px solid #eef0f3; padding-top: 10px; margin-top: 8px; }
.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
</style>
