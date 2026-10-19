export default {
    hero: {
        titulo: 'Gestionar equipos',
        descripcion:
            'Maestro general de equipos. Cada equipo se carga una sola vez y puede aceptar uno o varios métodos de ensayo. ' +
            'De él salen los internos (las unidades concretas) que después se eligen al armar un informe.',
    },

    ir_a: {
        label: 'Ir al maestro de Equipos',
        ruta: '/area/enod/equipos',
        icono: 'wrench',
    },

    acciones: [
        { icono: 'search', titulo: 'Ver el listado y buscar', detalle: 'El buscador encuentra por código, descripción, tipo de equipamiento o método. Buscar RD trae todos los equipos que tengan RD entre sus métodos.' },
        { icono: 'plus',   titulo: 'Crear un equipo',          detalle: 'Con Nuevo se abre el formulario de alta. Elegís uno o varios métodos.' },
        { icono: 'pencil', titulo: 'Editar un equipo',         detalle: 'Podés sumar o quitar métodos y cambiar tipo de equipamiento, instrumento o palpador.' },
        { icono: 'trash',  titulo: 'Eliminar un equipo',       detalle: 'No se puede eliminar un equipo que ya tiene internos asociados.' },
    ],

    dependencias: [
        { entidad: 'Métodos de ensayo', descripcion: 'Vienen cargados en el sistema. Son los que aparecen en la lista del formulario.', critico: true },
        { entidad: 'Tipos de equipamiento', descripcion: 'Se cargan en Maestros > Tipos de equipamiento. Se necesitan si el equipo tiene RI.', critico: false },
    ],

    secciones_destacadas: [
        { titulo: 'Un equipo, varios métodos', componente: 'ayuda-equipo-metodos' },
    ],

    bloques: [
        { titulo: 'Identificación', icono: 'tag', descripcion: 'Cómo se reconoce el equipo en el maestro.',
          campos: [
              { nombre: 'Código',      obligatorio: true,  detalle: 'hasta 25 caracteres. No puede repetirse con la misma descripción.' },
              { nombre: 'Descripción', obligatorio: false, detalle: 'hasta 100 caracteres. Ayuda a distinguir equipos parecidos.' },
          ] },
        { titulo: 'Métodos y datos técnicos', icono: 'wrench', descripcion: 'Lo que define dónde se puede usar el equipo.',
          campos: [
              { nombre: 'Método de ensayo',        obligatorio: true,  detalle: 'uno o varios. El primero es el principal.' },
              { nombre: 'Tipo de equipamiento',    obligatorio: false, detalle: 'obligatorio si alguno de los métodos es RI.' },
              { nombre: 'Instrumento de medición', obligatorio: false, detalle: 'solo se habilita con PM o LP.' },
              { nombre: 'Palpador',                obligatorio: false, detalle: 'casilla que aparece si alguno de los métodos es US.' },
          ] },
    ],

    demo: 'ayuda-demo-equipos',

    botones: [
        { label: 'Nuevo',         icono: 'plus-circle', estilo: '',     descripcion: 'Abre el formulario de alta.' },
        { label: 'Editar',        icono: 'edit',        estilo: '',     descripcion: 'Abre el mismo formulario con los datos del equipo, métodos incluidos.' },
        { label: 'Eliminar',      icono: 'trash',       estilo: 'rojo', descripcion: 'Quita el equipo del maestro, si no tiene internos asociados.' },
        { label: 'Buscar',        icono: 'search',      estilo: '',     descripcion: 'Filtra el listado por código, descripción, tipo o método.' },
        { label: 'Quitar método', icono: 'times',       estilo: 'gris', descripcion: 'La × de cada etiqueta saca ese método. Escape cierra primero la lista y recién un segundo Escape cierra el formulario.' },
    ],

    errores: [
        { mensaje: 'El campo método de ensayo es obligatorio.',
          causa: 'No elegiste ningún método.',
          solucion: 'Elegí al menos uno en la lista.' },
        { mensaje: 'El campo tipo equipamiento es obligatorio.',
          causa: 'Alguno de los métodos es RI.',
          solucion: 'Elegí el tipo de equipamiento o sacá RI si no corresponde.' },
        { mensaje: 'Existe un Equipo con ese código y descripción.',
          causa: 'Ya está cargado.',
          solucion: 'Buscalo en el listado y editá ese; si es otro equipo, cambiá la descripción.' },
        { mensaje: 'Se cerró el formulario y perdí lo cargado',
          causa: 'Escape con la lista cerrada cierra el formulario.',
          solucion: 'Con la lista abierta, un Escape solo la cierra. Volvé a abrir con Nuevo o Editar.' },
        { mensaje: 'Cargué el equipo pero no aparece en el informe',
          causa: 'Al informe llegan los internos, no el equipo.',
          solucion: 'Creá un interno activo en Internos de equipos. Ver "Cómo llega un equipo a un informe".' },
    ],

    impacto: [
        { modulo: 'Internos de equipos', efecto: 'El equipo se puede elegir al crear un interno. Los campos del formulario del interno dependen de los métodos del equipo.', reversible: true },
        { modulo: 'Informes',            efecto: 'Los internos activos del equipo se ofrecen en los informes de cada uno de sus métodos.', reversible: true },
        { modulo: 'QR y documentaciones', efecto: 'Las tablas muestran todos los métodos del equipo, una etiqueta por método.', reversible: true },
        { modulo: 'Informes ya generados', efecto: 'No cambian. El PDF usa el interno que se eligió al guardar el informe.', reversible: true },
    ],

    relacionados: [
        { titulo: 'Gestionar internos de equipos',      ruta: '/ayuda_gestion_interno_equipos' },
        { titulo: 'Cómo llega un equipo a un informe',  ruta: '/ayuda_equipo_en_informe' },
        { titulo: 'Gestionar internos de fuente',       ruta: '/ayuda_gestion_interno_fuente' },
    ],
};
