<template>
    <div class="ayuda_ib">
        <p>
            La casilla <strong>Activo</strong> decide si el interno se puede usar en informes. La fecha de baja es solo un registro:
            lo que manda siempre es la casilla.
        </p>

        <div class="ayuda_ib_wrap">
            <table class="table table-condensed ayuda_ib_tabla">
                <thead>
                    <tr>
                        <th style="width:220px;">Si hacés esto</th>
                        <th>La fecha de baja</th>
                        <th>En los informes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(s, i) in estados" :key="i">
                        <td><strong>{{ s.accion }}</strong></td>
                        <td>{{ s.fecha }}</td>
                        <td>{{ s.informes }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <ayuda-callout tipo="tip" titulo="Cambiar la fuente no es dar de baja">
            Si reemplazás la fuente de un interno que sigue activo, el interno queda activo y sin fecha de baja.
            El cambio queda anotado en el historial de fuentes de esa fila.
        </ayuda-callout>
    </div>
</template>

<script>
export default {
    name: 'ayuda-interno-baja',
    data() {
        return {
            estados: [
                { accion: 'Desmarcar Activo y guardar',     fecha: 'Se guarda la fecha de hoy.',     informes: 'Deja de ofrecerse. La fila se pinta de rojo.' },
                { accion: 'Guardar de nuevo, ya inactivo',  fecha: 'Se conserva la fecha original.', informes: 'Sigue sin ofrecerse.' },
                { accion: 'Volver a marcar Activo',         fecha: 'Se borra.',                      informes: 'Vuelve a ofrecerse.' },
                { accion: 'Cambiar la fuente, activo',      fecha: 'No se toca.',                    informes: 'Se sigue ofreciendo, con la fuente nueva.' },
            ],
        };
    },
};
</script>

<style scoped>
.ayuda_ib { font-family: 'Montserrat', sans-serif; }
.ayuda_ib_wrap { overflow-x: auto; border: 1px solid #eef0f3; border-radius: 4px; }
.ayuda_ib_tabla { margin: 0; font-size: 13px; }
.ayuda_ib_tabla > thead > tr > th {
    background: #fafbfc;
    border-bottom: 2px solid #FFCC00;
    color: #4c5661;
    font-size: 11.5px;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    font-weight: 700;
}
</style>
