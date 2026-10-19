<template>
    <div class="ayuda_evi">
        <div class="ayuda_evi_cards">
            <div class="ayuda_evi_card">
                <h4>Equipo (maestro de equipos)</h4>
                <p>Es la definición: código, descripción, tipo y los métodos con los que se puede usar. Se carga una vez.</p>
                <div class="ayuda_evi_ej">
                    <strong>DEMO-001</strong>
                    <ayuda-chip-metodo metodo="RI"></ayuda-chip-metodo>
                    <ayuda-chip-metodo metodo="RD"></ayuda-chip-metodo>
                </div>
            </div>
            <div class="ayuda_evi_card">
                <h4>Interno (esta pantalla)</h4>
                <p>Es cada unidad física de ese equipo. Un mismo equipo puede tener varios internos, cada uno con su serie, fuente y estado.</p>
                <div class="ayuda_evi_ej ayuda_evi_ej--lista">
                    <div><strong>N° 12</strong> · serie A-100 · activo</div>
                    <div><strong>N° 13</strong> · serie A-101 · activo</div>
                    <div><strong>N° 17</strong> · serie A-087 · baja</div>
                </div>
            </div>
        </div>

        <ayuda-callout tipo="info" titulo="Los métodos se heredan del equipo">
            El interno no tiene métodos propios: muestra los del equipo que elegiste. Si el equipo tiene RI y RD,
            el interno aparece en los informes RI y en los RD.
        </ayuda-callout>
    </div>
</template>

<script>
export default { name: 'ayuda-equipo-vs-interno' };
</script>

<style scoped>
.ayuda_evi { font-family: 'Montserrat', sans-serif; }
.ayuda_evi_cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(min(300px, 100%), 1fr));
    gap: 12px;
}
.ayuda_evi_card {
    background: #fafbfc;
    border: 1px solid #eef0f3;
    border-top: 3px solid #FFCC00;
    border-radius: 4px;
    padding: 12px 14px;
}
.ayuda_evi_card h4 {
    margin: 0 0 6px;
    font-size: 13px;
    font-weight: 700;
    color: #1a1a1a;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.ayuda_evi_card p { margin: 0 0 10px; font-size: 13px; line-height: 1.55; }
.ayuda_evi_ej { font-size: 12.5px; color: #1a1a1a; }
.ayuda_evi_ej--lista { line-height: 1.7; }
</style>
