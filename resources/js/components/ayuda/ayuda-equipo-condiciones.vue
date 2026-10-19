<template>
    <div class="ayuda_cond">
        <p>El selector Equipo del informe muestra un interno solo si cumple las cuatro condiciones. Con que falle una, no aparece.</p>

        <ul class="ayuda_cond_lista">
            <li v-for="(c, i) in condiciones" :key="i">
                <strong>{{ c.cond }}</strong>
                <span>{{ c.como }}</span>
            </li>
        </ul>

        <ayuda-callout tipo="info" titulo="Informe LP: la regla es distinta">
            En Líquidos Penetrantes el selector no mira el método del equipo. Ofrece lámparas de luz UV si el método de trabajo es
            Fluorescente, o luxómetros de luz blanca si es Visible, según el instrumento de medición cargado en el equipo.
        </ayuda-callout>

        <h4 class="ayuda_cond_sub">Ejemplos para verlo claro</h4>
        <div class="ayuda_cond_wrap">
            <table class="table table-condensed ayuda_cond_tabla">
                <thead>
                    <tr>
                        <th style="width:80px;">Interno</th>
                        <th>Equipo y métodos</th>
                        <th style="width:160px;">Estado</th>
                        <th>Dónde aparece</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(e, i) in ejemplos" :key="i">
                        <td><strong>{{ e.nro }}</strong></td>
                        <td>{{ e.equipo }}<br><ayuda-chip-metodo v-for="m in e.metodos" :key="m" :metodo="m"></ayuda-chip-metodo></td>
                        <td>{{ e.estado }}</td>
                        <td>{{ e.donde }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="ayuda_cond_nota">Datos de ejemplo.</div>
    </div>
</template>

<script>
export default {
    name: 'ayuda-equipo-condiciones',
    data() {
        return {
            condiciones: [
                { cond: 'El interno está activo', como: 'La casilla Activo está marcada en Internos de equipos. Un interno dado de baja no se ofrece.' },
                { cond: 'El equipo tiene el método del informe', como: 'Cualquiera de los métodos del equipo cuenta, no solo el principal. Un informe RD ofrece internos de equipos con RD, aunque el principal sea RI.' },
                { cond: 'El equipo no es un palpador', como: 'Los palpadores se eligen en su propio selector dentro del informe US, no como equipo.' },
                { cond: 'No tiene instrumento de medición cargado', como: 'Los luxómetros y las lámparas UV se ofrecen en los selectores de instrumento de PM y de iluminación de LP, no en el selector de equipo común.' },
            ],
            ejemplos: [
                { nro: '12', equipo: 'DEMO-001', metodos: ['RI', 'RD'], estado: 'Activo', donde: 'Informes RI y RD. No aparece en PM ni en US.' },
                { nro: '17', equipo: 'DEMO-001', metodos: ['RI', 'RD'], estado: 'Inactivo (baja)', donde: 'En ningún informe.' },
                { nro: '31', equipo: 'DEMO-004', metodos: ['US'], estado: 'Activo', donde: 'Informes US. No aparece en RI ni en RD.' },
                { nro: '40', equipo: 'DEMO-005', metodos: ['PM', 'LP'], estado: 'Activo, con lámpara UV', donde: 'En el selector de instrumento de PM y en el de lámparas de LP. No en el selector de equipo común.' },
            ],
        };
    },
};
</script>

<style scoped>
.ayuda_cond { font-family: 'Montserrat', sans-serif; }
.ayuda_cond_lista { list-style: none; padding: 0; margin: 0 0 4px; border: 1px solid #eef0f3; border-radius: 4px; }
.ayuda_cond_lista li {
    display: flex; flex-wrap: wrap; gap: 6px 18px;
    padding: 10px 14px; border-bottom: 1px solid #f3f4f6;
    font-size: 13px; line-height: 1.55;
}
.ayuda_cond_lista li:last-child { border-bottom: 0; }
.ayuda_cond_lista strong { flex: 0 0 250px; color: #1a1a1a; }
.ayuda_cond_lista span { flex: 1 1 320px; min-width: 0; }
.ayuda_cond_sub { margin: 18px 0 8px; font-size: 13px; font-weight: 700; color: #1a1a1a; }
.ayuda_cond_wrap { overflow-x: auto; border: 1px solid #eef0f3; border-radius: 4px; }
.ayuda_cond_tabla { margin: 0; font-size: 13px; }
.ayuda_cond_tabla > thead > tr > th {
    background: #fafbfc;
    border-bottom: 2px solid #FFCC00;
    color: #4c5661;
    font-size: 11.5px;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    font-weight: 700;
}
.ayuda_cond_nota { margin-top: 8px; font-size: 12px; color: #6b7280; font-style: italic; }
</style>
