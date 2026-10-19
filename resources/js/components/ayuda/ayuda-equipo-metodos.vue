<template>
    <div class="ayuda_eqm">
        <p>
            El campo <strong>Método de ensayo</strong> acepta más de un método. Sirve para equipos que se usan en distintos ensayos,
            por ejemplo un detector que sirve para radiografía industrial y digital: se carga una vez con los dos métodos y no hace falta duplicarlo.
        </p>

        <div class="ayuda_eqm_cards">
            <div class="ayuda_eqm_card">
                <h4>Cómo se eligen</h4>
                <p>Abrís la lista, tocás cada método y la lista queda abierta para seguir sumando. Cada elegido aparece como una etiqueta. Para sacar uno, usás la <strong>×</strong> de su etiqueta.</p>
            </div>
            <div class="ayuda_eqm_card">
                <h4>El método principal</h4>
                <p>El primero que elegís es el principal y aparece primero en la tabla. Si lo sacás, pasa a ser principal el que sigue. Para los informes todos los métodos valen igual.</p>
            </div>
            <div class="ayuda_eqm_card">
                <h4>Qué se ve en la tabla</h4>
                <p>La columna Método muestra una etiqueta por método. Si falta lugar, las etiquetas bajan de línea y la tabla no se rompe.</p>
            </div>
        </div>

        <h4 class="ayuda_eqm_sub">Qué pide el sistema según cada método</h4>
        <div class="ayuda_eqm_tabla_wrap">
            <table class="table table-condensed ayuda_eqm_tabla">
                <thead>
                    <tr>
                        <th style="width:130px;">Método</th>
                        <th>En el equipo</th>
                        <th>En el interno</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(r, i) in reglas" :key="i">
                        <td><ayuda-chip-metodo v-for="m in r.metodos" :key="m" :metodo="m"></ayuda-chip-metodo></td>
                        <td>{{ r.equipo }}</td>
                        <td>{{ r.interno }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <ayuda-callout tipo="warning" titulo="Equipos que ya estaban repetidos">
            Si hoy tenés el mismo equipo cargado una vez por cada método (mismo código, métodos distintos), siguen siendo equipos separados:
            el sistema no los junta solo. Cada uno conserva sus internos e informes. Antes de unificarlos, consultá con Sistemas.
        </ayuda-callout>
    </div>
</template>

<script>
export default {
    name: 'ayuda-equipo-metodos',
    data() {
        return {
            reglas: [
                { metodos: ['RI'],       equipo: 'Tipo de equipamiento obligatorio.', interno: 'Fuente, foco, voltaje y amperaje.' },
                { metodos: ['RD'],       equipo: 'Sin campos extra.',                  interno: 'Fuente, foco, voltaje y amperaje.' },
                { metodos: ['US'],       equipo: 'Casilla Palpador.',                  interno: 'Sin campos extra.' },
                { metodos: ['PM', 'LP'], equipo: 'Instrumento de medición (luxómetro luz blanca o lámpara luz UV).', interno: 'Sin campos extra.' },
                { metodos: ['DZ'],       equipo: 'Sin campos extra.',                  interno: 'Probeta y dureza de calibración, obligatorias.' },
                { metodos: ['Otros'],    equipo: 'Solo código, descripción y método.', interno: 'Solo serie, N° interno y equipo.' },
            ],
        };
    },
};
</script>

<style scoped>
.ayuda_eqm { font-family: 'Montserrat', sans-serif; }
.ayuda_eqm_cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(min(290px, 100%), 1fr));
    gap: 12px;
    margin: 12px 0 16px;
}
.ayuda_eqm_card {
    background: #fafbfc;
    border: 1px solid #eef0f3;
    border-top: 3px solid #FFCC00;
    border-radius: 4px;
    padding: 12px 14px;
}
.ayuda_eqm_card h4 {
    margin: 0 0 6px;
    font-size: 13px;
    font-weight: 700;
    color: #1a1a1a;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.ayuda_eqm_card p { margin: 0; font-size: 13px; line-height: 1.55; }
.ayuda_eqm_sub { margin: 0 0 8px; font-size: 13px; font-weight: 700; color: #1a1a1a; }
.ayuda_eqm_tabla_wrap { overflow-x: auto; border: 1px solid #eef0f3; border-radius: 4px; }
.ayuda_eqm_tabla { margin: 0; font-size: 13px; }
.ayuda_eqm_tabla > thead > tr > th {
    background: #fafbfc;
    border-bottom: 2px solid #FFCC00;
    color: #4c5661;
    font-size: 11.5px;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    font-weight: 700;
}
</style>
