<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_demo_label">Formulario de remito</div>
        <div class="box box-custom-enod ayuda_real_box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-truck"></i>&nbsp; Nuevo remito · <span class="ayuda_numero">{{ prefijo }}-{{ numero }}</span>
                    <span class="label" :class="esBorrador ? 'label-warning' : 'label-success'" style="margin-left:8px;">
                        {{ esBorrador ? 'Borrador' : 'Definitivo' }}
                    </span>
                </h3>
            </div>
            <div class="box-body">
                <!-- Cabecera -->
                <div class="row">
                    <div class="col-sm-2 col-xs-4">
                        <div class="form-group">
                            <label>Prefijo</label>
                            <input type="text" class="form-control" v-model="prefijo" disabled />
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-4">
                        <div class="form-group">
                            <label>Número</label>
                            <input type="text" class="form-control" v-model="numero" disabled />
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-4">
                        <div class="form-group">
                            <label>Fecha</label>
                            <input type="text" class="form-control" value="25/06/2026" disabled />
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label>Receptor</label>
                            <input type="text" class="form-control" value="Diego Salas (DNI 30.554.221)" disabled />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Frente origen <span class="ayuda_req">*</span></label>
                            <select class="form-control" disabled><option>Centro de distribución - Neuquén</option></select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Frente destino <span class="ayuda_req">*</span></label>
                            <select class="form-control" disabled><option>Obra Gasoducto NEA - Tramo 12</option></select>
                        </div>
                    </div>
                </div>

                <!-- Tabs Productos / Internos -->
                <ul class="nav nav-tabs ayuda_tabs">
                    <li :class="{ active: tab === 'productos' }">
                        <a href="#" @click.prevent="tab = 'productos'">
                            <i class="fa fa-cubes"></i>&nbsp; Productos
                            <span class="badge ayuda_tab_badge">{{ productos.length }}</span>
                        </a>
                    </li>
                    <li :class="{ active: tab === 'internos' }">
                        <a href="#" @click.prevent="tab = 'internos'">
                            <i class="fa fa-wrench"></i>&nbsp; Internos de equipos
                            <span class="badge ayuda_tab_badge">{{ internos.length }}</span>
                        </a>
                    </li>
                </ul>

                <div class="ayuda_tab_panel">
                    <table v-if="tab === 'productos'" class="table table-condensed ayuda_real_table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Medida</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-center" style="width:40px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(p, i) in productos" :key="i">
                                <td>{{ p.producto }}</td>
                                <td>{{ p.medida }}</td>
                                <td class="text-center"><strong>{{ p.cantidad }}</strong></td>
                                <td class="text-center">
                                    <button class="btn btn-enod-danger btn-xs"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table v-else class="table table-condensed ayuda_real_table">
                        <thead>
                            <tr>
                                <th>Equipo</th>
                                <th>N° interno</th>
                                <th>Marca / modelo</th>
                                <th class="text-center" style="width:40px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(i, idx) in internos" :key="idx">
                                <td>{{ i.equipo }}</td>
                                <td><strong>{{ i.interno }}</strong></td>
                                <td>{{ i.marca }}</td>
                                <td class="text-center">
                                    <button class="btn btn-enod-danger btn-xs"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button class="btn btn-default btn-sm" style="margin-top:6px;">
                        <i class="fa fa-plus"></i>&nbsp;
                        Agregar {{ tab === 'productos' ? 'producto' : 'interno' }}
                    </button>
                </div>

                <div class="form-group" style="margin-top:14px;">
                    <label>Observaciones</label>
                    <textarea class="form-control noresize" rows="2" disabled>Traslado de stock para inicio de campaña RI.</textarea>
                </div>

                <div class="ayuda_remito_toggle">
                    <label>
                        <input type="checkbox" v-model="esBorrador" /> Guardar como borrador (no impacta stock)
                    </label>
                </div>

                <div class="enod-form-actions enod-form-actions--end">
                    <button class="btn btn-default" disabled>Cancelar</button>
                    <button class="btn btn-enod" disabled>
                        <i :class="esBorrador ? 'fa fa-floppy-o' : 'fa fa-check'"></i>&nbsp;
                        {{ esBorrador ? 'Guardar borrador' : 'Guardar definitivo' }}
                    </button>
                </div>
            </div>
        </div>
        <div class="ayuda_demo_caption">
            Probá tildar / destildar <strong>Borrador</strong> — el botón final cambia. Un remito definitivo desde un centro
            de distribución <strong>descuenta stock real</strong> y, si lleva internos, actualiza el frente del equipo.
        </div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-form-remito',
    data() {
        return {
            tab: 'productos',
            esBorrador: false,
            prefijo: '0001',
            numero: '00012543',
            productos: [
                { producto: 'Film radiográfico Kodak AA400', medida: '14×17"',    cantidad: 12 },
                { producto: 'Revelador SKD-S2 aerosol',       medida: '400 cm³',   cantidad: 8  },
                { producto: 'Líquido penetrante SKL-SP',       medida: '400 cm³',   cantidad: 6  },
            ],
            internos: [
                { equipo: 'RX SPELLMAN 200 kV',     interno: 'EQ-0042', marca: 'Spellman SP-200' },
                { equipo: 'Yugo electromagnético',   interno: 'EQ-0118', marca: 'Magnaflux Y-7' },
            ],
        };
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
.ayuda_real_box .box-header { border-bottom: 1px solid #eef0f3; padding: 10px 14px; }
.ayuda_real_box .box-title { font-size: 14px; font-weight: 700; color: #1a1a1a; display: flex; align-items: center; }
.ayuda_real_box .box-title i { color: #FFCC00; }
.ayuda_real_box .box-body { padding: 14px; }
.ayuda_real_box .form-control[disabled],
.ayuda_real_box textarea[disabled] { background: #fafbfc; cursor: not-allowed; color: #4c5661; }
.ayuda_real_box label { font-size: 12px; color: #4c5661; margin-bottom: 4px; }
.ayuda_req { color: #dc3545; font-weight: 700; }
.ayuda_numero { color: #d4a800; font-family: 'Courier New', monospace; font-size: 13px; }

.ayuda_tabs { margin-top: 8px; border-bottom: 1px solid #eef0f3; }
.ayuda_tabs > li > a {
    color: #6b7280;
    font-size: 13px;
    font-weight: 600;
    padding: 8px 14px;
    border-radius: 0;
}
.ayuda_tabs > li.active > a,
.ayuda_tabs > li.active > a:hover,
.ayuda_tabs > li.active > a:focus {
    color: #1a1a1a;
    background: #fff;
    border-bottom: 3px solid #FFCC00;
    margin-bottom: -1px;
}
.ayuda_tabs > li > a:hover { background: #fafbfc; color: #1a1a1a; }
.ayuda_tab_badge { background: #FFCC00; color: #1a1a1a; font-size: 10px; margin-left: 4px; }
.ayuda_tab_panel {
    background: #fafbfc;
    border: 1px solid #eef0f3;
    border-top: 0;
    padding: 12px 14px;
    margin-bottom: 0;
    border-radius: 0 0 4px 4px;
}

.ayuda_real_table { background: #fff; margin-bottom: 0; }
.ayuda_real_table > thead > tr > th {
    background: #fafbfc;
    border-bottom: 2px solid #FFCC00;
    color: #4c5661;
    font-size: 11.5px;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    font-weight: 700;
}
.ayuda_real_table > tbody > tr > td { font-size: 13px; vertical-align: middle; }

.ayuda_remito_toggle {
    background: #fffdf5;
    border: 1px solid #f0df9a;
    border-left: 3px solid #FFCC00;
    padding: 8px 12px;
    border-radius: 0 4px 4px 0;
    margin-top: 8px;
}
.ayuda_remito_toggle label { font-size: 13px; color: #5c4a00; font-weight: 600; cursor: pointer; margin: 0; }
.ayuda_remito_toggle input { margin-right: 6px; }

.enod-form-actions { border-top: 1px solid #eef0f3; padding-top: 12px; margin-top: 12px; }

.ayuda_demo_caption {
    margin-top: 8px;
    font-size: 12px;
    color: #6b7280;
    font-style: italic;
}
</style>
