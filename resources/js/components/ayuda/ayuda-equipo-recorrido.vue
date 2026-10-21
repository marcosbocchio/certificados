<template>
    <div class="ayuda_rec">
        <div class="ayuda_rec_scroll">
            <div class="ayuda_rec_host">
                <svg v-for="a in flechas" :key="a.id" class="ayuda_rec_flecha" aria-hidden="true"
                     width="65" height="8" viewBox="0 0 65 8" preserveAspectRatio="none"
                     :style="{ left: a.left + 'px' }">
                    <defs>
                        <marker :id="'ayuda-rec-head-' + a.id" orient="auto" markerWidth="5" markerHeight="5" refX="2" refY="2" overflow="visible">
                            <path d="M0 0 L4 2 L0 4 Z" fill="#6b7280" stroke="none"></path>
                        </marker>
                    </defs>
                    <path d="M 0 4 L 61 4" :marker-end="'url(#ayuda-rec-head-' + a.id + ')'"></path>
                </svg>

                <div v-for="(c, i) in cajas" :key="i" class="ayuda_rec_caja" :class="{ 'is-destacada': c.destacada }" :style="{ left: c.left + 'px' }">
                    <span><b>{{ c.titulo }}</b><br>{{ c.texto }}</span>
                </div>
                <div v-for="(c, i) in cajas" :key="'l' + i" class="ayuda_rec_pie" :style="{ left: c.left + 'px' }">{{ c.pie }}</div>
            </div>
        </div>

        <ol class="ayuda_rec_pasos">
            <li v-for="p in pasos" :key="p.n">
                <span class="ayuda_rec_num">{{ p.n }}</span>
                <div><strong>{{ p.titulo }}</strong> <span>— {{ p.texto }}</span></div>
            </li>
        </ol>
    </div>
</template>

<script>
export default {
    name: 'ayuda-equipo-recorrido',
    data() {
        return {
            flechas: [
                { id: 1, left: 200 },
                { id: 2, left: 466 },
                { id: 3, left: 732 },
            ],
            cajas: [
                { left: 0,   titulo: '1. Equipo',  texto: 'Se carga una vez, con uno o varios métodos', pie: 'Ayuda: Gestionar equipos' },
                { left: 266, titulo: '2. Interno', texto: 'Cada unidad física, con su fuente y su estado', pie: 'Ayuda: Gestionar internos' },
                { left: 532, titulo: '3. Informe', texto: 'El selector ofrece los internos que cumplen', pie: 'Generar informes', destacada: true },
                { left: 798, titulo: '4. PDF',     texto: 'Imprime el interno que se eligió', pie: 'Visualizar informes' },
            ],
            pasos: [
                { n: '1', titulo: 'Se carga el equipo', texto: 'En Maestros > Equipos, con todos los métodos con los que se puede usar.' },
                { n: '2', titulo: 'Se crea el interno', texto: 'En Maestros > Internos de equipos, con su serie, su fuente y la casilla Activo marcada.' },
                { n: '3', titulo: 'Se arma el informe', texto: 'En la OT, el selector Equipo ofrece los internos que cumplen las condiciones de abajo. Al elegir uno se completan fuente, foco y actividad.' },
                { n: '4', titulo: 'Se guarda y se imprime', texto: 'El informe queda ligado a ese interno y el PDF lo muestra.' },
            ],
        };
    },
};
</script>

<style scoped>
.ayuda_rec { font-family: 'Montserrat', sans-serif; }
.ayuda_rec_scroll { overflow-x: auto; padding: 4px 0 8px; }
.ayuda_rec_host { position: relative; width: 1000px; height: 150px; }
.ayuda_rec_flecha {
    position: absolute; top: 44px; width: 65px; height: 8px;
    overflow: visible; fill: none; stroke: #6b7280; stroke-width: 2;
    stroke-linecap: round; stroke-linejoin: round;
}
.ayuda_rec_caja {
    position: absolute; top: 0; width: 200px; height: 96px; box-sizing: border-box;
    padding: 10px; display: flex; align-items: center; justify-content: center;
    text-align: center; background: #fff; border: 1px solid #d6dce3; border-radius: 6px;
    font-size: 13px; line-height: 1.45; color: #4c5661;
}
.ayuda_rec_caja b { color: #1a1a1a; }
.ayuda_rec_caja.is-destacada { background: #fffdf5; border: 2px solid #FFCC00; }
.ayuda_rec_pie {
    position: absolute; top: 108px; width: 200px; text-align: center;
    font-size: 12.5px; line-height: 16px; color: #6b7280;
}
.ayuda_rec_pasos { list-style: none; padding: 0; margin: 8px 0 0; }
.ayuda_rec_pasos li {
    display: flex; gap: 12px; align-items: flex-start;
    padding: 10px 14px; background: #fafbfc; border: 1px solid #eef0f3;
    border-radius: 4px; margin-bottom: 6px; font-size: 13.5px; line-height: 1.55;
}
.ayuda_rec_pasos strong { color: #1a1a1a; }
.ayuda_rec_num {
    display: inline-flex; align-items: center; justify-content: center;
    width: 22px; height: 22px; border-radius: 50%;
    background: #FFCC00; color: #1a1a1a; font-size: 12px; font-weight: 700; flex-shrink: 0;
}
</style>
