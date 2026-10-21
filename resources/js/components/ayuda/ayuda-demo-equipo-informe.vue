<template>
    <div class="ayuda_demo_block">
        <div class="ayuda_dei_fila">
            <div class="ayuda_dei_col">
                <div class="ayuda_demo_label">Informe RD, selector Equipo</div>
                <label class="ayuda_dei_label">Equipo <span class="ayuda_req">*</span></label>
                <div class="ayuda_dei_select">Elegí un interno…</div>
                <div class="ayuda_dei_lista">
                    <div v-for="o in opciones" :key="o.nro" class="ayuda_dei_op">
                        <div class="ayuda_dei_op_nro">{{ o.nro }}</div>
                        <div class="ayuda_dei_op_eq">{{ o.equipo }}</div>
                    </div>
                </div>
                <div class="ayuda_demo_caption">Solo aparecen internos de equipos que tengan RD.</div>
            </div>
            <div class="ayuda_dei_col">
                <div class="ayuda_demo_label">Al elegirlo, se completan solos</div>
                <div v-for="a in autocompleta" :key="a.label" class="form-group">
                    <label class="ayuda_dei_label">{{ a.label }}</label>
                    <input type="text" class="form-control" :value="a.valor" disabled />
                </div>
            </div>
        </div>

        <div class="ayuda_demo_label ayuda_demo_label--gap">Cómo sale en el PDF</div>
        <div class="ayuda_dei_pdf">
            <div class="ayuda_dei_pdf_head">
                <div class="ayuda_dei_pdf_titulo">RADIOGRAFIA DIGITAL</div>
                <div class="ayuda_dei_pdf_nro"><b>INFORME N°</b> RD0005 - Rev.01<br><b>FECHA:</b> 01-10-2026</div>
            </div>
            <div class="ayuda_dei_pdf_datos">
                <div><b>Equipo</b><br>DEMO-001</div>
                <div><b>Fuente</b><br>SE 75 - POLYTEC</div>
                <div><b>Actividad</b><br>38 Ci</div>
            </div>
        </div>
        <div class="ayuda_demo_caption">Recorte ilustrativo del encabezado del informe.</div>

        <ayuda-callout tipo="tip" titulo="Un equipo con dos métodos sale igual en los dos informes">
            El PDF muestra los datos del interno que se eligió al guardar el informe, no la lista de métodos del equipo.
            Sumarle un método a un equipo no cambia los informes que ya están hechos.
        </ayuda-callout>
    </div>
</template>

<script>
export default {
    name: 'ayuda-demo-equipo-informe',
    data() {
        return {
            opciones: [
                { nro: '12', equipo: 'DEMO-001' },
                { nro: '13', equipo: 'DEMO-001' },
                { nro: '52', equipo: 'DEMO-009' },
            ],
            autocompleta: [
                { label: 'Fuente',    valor: 'SE 75 - POLYTEC' },
                { label: 'Actividad', valor: '38 Ci' },
                { label: 'Foco',      valor: '3.4' },
                { label: 'Kv / mA',   valor: 'se cargan a mano en el informe' },
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
.ayuda_demo_label--gap { margin-top: 22px; }
.ayuda_demo_caption { margin-top: 8px; font-size: 12px; color: #6b7280; font-style: italic; }
.ayuda_req { color: #dc3545; font-weight: 700; }

.ayuda_dei_fila { display: flex; flex-wrap: wrap; gap: 20px; align-items: flex-start; }
.ayuda_dei_col { flex: 1 1 300px; min-width: 0; }
.ayuda_dei_label { display: block; font-size: 12px; font-weight: 700; color: #1a1a1a; margin-bottom: 4px; }
.ayuda_dei_select {
    border: 1px solid #3c8dbc; border-radius: 3px; padding: 7px 10px;
    font-size: 13px; color: #6b7280; background: #fff;
}
.ayuda_dei_lista {
    border: 1px solid #d2d6de; border-top: 0; border-radius: 0 0 3px 3px;
    background: #fff; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
}
.ayuda_dei_op { padding: 7px 10px; border-bottom: 1px solid #f3f4f6; }
.ayuda_dei_op:last-child { border-bottom: 0; }
.ayuda_dei_op_nro { font-size: 13px; font-weight: 700; color: #1a1a1a; }
.ayuda_dei_op_eq { font-size: 11.5px; font-style: italic; color: #6b7280; }
.ayuda_dei_col .form-control[disabled] { background: #eee; color: #4c5661; }

.ayuda_dei_pdf {
    border: 1px solid #d6dce3; border-radius: 2px; padding: 16px 18px;
    background: #fff; font-family: 'Times New Roman', serif; color: #000; max-width: 680px;
}
.ayuda_dei_pdf_head {
    display: flex; flex-wrap: wrap; justify-content: space-between; gap: 10px; align-items: center;
    border-bottom: 3px solid #d9a800; padding-bottom: 10px; margin-bottom: 12px;
}
.ayuda_dei_pdf_titulo { font-size: 15px; font-weight: 700; }
.ayuda_dei_pdf_nro { font-size: 11px; line-height: 1.5; }
.ayuda_dei_pdf_datos {
    display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 8px 18px; font-size: 11.5px;
}
</style>
