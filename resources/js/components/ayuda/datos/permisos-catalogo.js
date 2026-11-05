/* Catálogo de permisos explicado para quien arma roles.
 * Cada entrada: [nombre, qué permite, para tener en cuenta (opcional)].
 * Se redacta desde lo que ve la persona en la app, sin detalles internos.
 */

const maestros = [
    ['M_usuarios', 'Usuarios', 'M_usuarios_edita'],
    ['M_frentes', 'Frentes', ''],
    ['M_clientes', 'Clientes', 'M_clientes_edita'],
    ['M_proveedores', 'Proveedores', 'M_proveedores_edita'],
    ['M_contratistas', 'Comitentes', 'M_contratistas_edita'],
    ['M_materiales', 'Materiales', 'M_materiales_edita'],
    ['M_normas_ensayo', 'Normas de ensayo', 'M_normas_ensayo_edita'],
    ['M_normas_fabricacion', 'Normas de fabricación', 'M_normas_fabricacion_edita'],
    ['M_normas_eval', 'Normas de evaluación', 'M_normas_eval_edita'],
    ['M_documentaciones', 'Documentaciones', 'M_documentaciones_edita'],
    ['M_unidades_medida', 'Unidades de medida', 'M_unidades_medida_edita'],
    ['M_medidas', 'Medidas', 'M_medidas_edita'],
    ['M_productos', 'Productos', 'M_productos_edita'],
    ['M_servicios', 'Servicios', 'M_servicios_edita'],
    ['M_soldadores', 'Soldadores', 'M_soldadores_edita'],
    ['M_plantas', 'Plantas', ''],
    ['M_campanas', 'Campañas', ''],
    ['M_bombas', 'Bombas', ''],
    ['M_equipos', 'Equipos', 'M_equipos_edita'],
    ['M_interno_equipos', 'Internos de equipos', 'M_interno_equipos_edita'],
    ['M_fuentes', 'Fuentes', 'M_fuentes_edita'],
    ['M_interno_fuentes', 'Internos de fuente', 'M_interno_fuentes_edita'],
    ['M_agente_ac', 'Agentes de acoplamiento', 'M_agente_ac_edita'],
    ['M_vehiculos', 'Vehículos', 'M_vehiculos_edita'],
    ['M_modelos_3d', 'Modelos 3D', 'M_modelos_3d_edita'],
    ['M_roles', 'Roles', 'M_roles_edita'],
    ['M_permisos', 'Permisos', 'M_permisos_edita'],
];

const notasMaestros = {
    M_interno_equipos: 'Es el que muestra también la entrada Tipos de equipamiento en el menú.',
    M_plantas: 'Se edita con M_soldadores_edita.',
    M_campanas: 'Se edita con M_fuentes_edita.',
    M_bombas: 'Se edita con M_fuentes_edita.',
    M_soldadores_edita: 'Sirve también para editar Plantas.',
    M_fuentes_edita: 'Sirve también para editar Bombas y Campañas.',
};

const filasMaestros = [];
maestros.forEach(([base, etiqueta, edita]) => {
    filasMaestros.push([base, 'Abre la pantalla de ' + etiqueta + ' en Maestros.', notasMaestros[base] || '']);
    if (edita) {
        filasMaestros.push([edita, 'Permite agregar, editar y borrar en ' + etiqueta + '. Sin él la pantalla se ve pero los botones quedan deshabilitados.', notasMaestros[edita] || '']);
    }
});
filasMaestros.push(
    ['M_tipos_equipamiento', 'Abre la pantalla de Tipos de equipamiento.', 'Para ver la entrada en el menú también hace falta M_interno_equipos.'],
    ['M_tipos_equipamiento_edita', 'Permite agregar, editar y borrar tipos de equipamiento.', ''],
    ['MAESTROS', 'Muestra el menú Maestros. Sin él no se ve ninguna pantalla de Maestros, aunque tenga los permisos M_.', '']
);

export default [
    {
        id: 'ot',
        titulo: 'Órdenes de trabajo',
        detalle: 'Los que empiezan con T_ vienen de a pares: "acceder" permite ver y "edita" o "actualiza" permite modificar. Para trabajar en una OT, además, la persona tiene que estar asignada a ella o tener el rol Ve-todas-las-OT.',
        filas: [
            ['O_alta', 'Crear órdenes de trabajo y abrir la pantalla de edición. Muestra el botón Nueva OT.', 'Para modificar una OT existente se necesita también T_edita.'],
            ['O_todas_las_ots', 'Ver todas las OTs, no solo las asignadas.', 'Se da a través del rol Ve-todas-las-OT. No lo sumes a roles generales: todas las personas con ese rol pasarían a ver todas las OTs.'],
            ['T_edita', 'Habilita el botón Editar de cada OT en el tablero.', 'Va junto con O_alta.'],
            ['T_accion', 'Habilita Firmar (pasa a Activa) y Cerrar (pasa a Cerrada) la OT.', ''],
            ['T_exportar_documentacion', 'Generar el enlace de documentación de una OT para compartir.', ''],
            ['T_operador_acceder', 'Ver los operadores asignados a la OT.', ''],
            ['T_operador_actualiza', 'Agregar y quitar operadores y ayudantes de la OT.', 'Quien tiene este permiso decide quién ve la OT. Entregalo con criterio.'],
            ['T_equipos_acceder', 'Ver los equipos internos de la OT.', ''],
            ['T_equipos_actualiza', 'Agregar y quitar equipos internos de la OT.', ''],
            ['T_proc_acceder', 'Ver los procedimientos propios de la OT.', ''],
            ['T_proc_edita', 'Agregar y borrar procedimientos propios de la OT.', ''],
            ['T_doc_acceder', 'Ver la documentación de la OT.', ''],
            ['T_doc_actualiza', 'Cargar y modificar la documentación de la OT.', ''],
            ['T_soldadores_acceder', 'Habilita la tarjeta de soldadores en el tablero.', ''],
            ['T_soldadores_actualiza', 'Muestra los botones para editar soldadores dentro de la OT.', ''],
            ['T_informes_acceder', 'Ver el listado de informes de la OT.', ''],
            ['T_informes_edita', 'Crear y editar informes de todos los métodos, placas y documentos escaneados.', ''],
            ['T_partes_acceder', 'Ver los partes de la OT, incluidos los manuales.', ''],
            ['T_partes_edita', 'Crear y editar partes y generar el PDF de partes.', ''],
            ['T_certif_acceder', 'Ver los certificados de la OT.', ''],
            ['T_certif_edita', 'Crear y editar certificados.', ''],
            ['T_remitos_acceder', 'Ver el listado de remitos.', ''],
            ['T_remitos_edita', 'Crear y editar remitos.', ''],
            ['ver_no_visible', 'Ver los documentos marcados como no visibles en la documentación y en los procedimientos de la OT.', 'Sin este permiso esos documentos no aparecen, aunque la persona pueda ver la sección.'],
        ],
    },
    {
        id: 'mae',
        titulo: 'Maestros',
        detalle: 'El permiso base abre la pantalla. El que termina en _edita permite agregar, editar y borrar. Para ver el menú hace falta además MAESTROS.',
        filas: filasMaestros,
    },
    {
        id: 'rep',
        titulo: 'Reportes',
        detalle: 'Cada reporte se habilita por separado. REPORTES muestra el menú padre.',
        filas: [
            ['REPORTES', 'Muestra el menú Reportes.', ''],
            ['R_estadisticas_soldaduras', 'Abre Estadísticas de soldaduras.', 'Cada pestaña tiene su propio permiso, abajo.'],
            ['R_indices_de_rechazos', 'Pestaña Índices de rechazos de Estadísticas de soldaduras.', ''],
            ['R_defectologia', 'Pestaña Defectología de Estadísticas de soldaduras.', ''],
            ['R_defectologia_produccion', 'Pestaña Defectología/Producción de Estadísticas de soldaduras.', ''],
            ['R_indicaciones', 'Pestaña Indicaciones de Estadísticas de soldaduras.', ''],
            ['R_interno_equipos', 'Reporte de Internos de equipos.', ''],
            ['R_costuras', 'Reporte de Costuras.', ''],
            ['R_elementos', 'Reporte de Elementos.', ''],
            ['R_placas', 'Reporte de Placas.', 'También abre la pantalla Resumen certificado.'],
            ['R_resumen_certificado', 'Muestra la entrada Resumen certificado en el menú.', 'Para abrir la pantalla también hace falta R_placas.'],
            ['R_certificados_partes', 'Reportes de Certificados y de Partes.', ''],
            ['R_resumen_epp', 'Reportes de Entrega EPP y de placas entregadas.', ''],
            ['R_infomre_sin_parte', 'Reporte de informes sin parte.', 'El nombre se escribe así, con "infomre", tal como figura en la lista de permisos.'],
        ],
    },
    {
        id: 'dos',
        titulo: 'Dosimetría',
        detalle: 'Los que terminan en _Admin amplían lo que ve la persona dentro de cada pantalla.',
        filas: [
            ['DOSIMETRIA', 'Muestra el menú Dosimetría.', ''],
            ['D_activa_operador', 'Activar operadores por período.', ''],
            ['D_activa_operador_Admin', 'Versión de administrador de la pantalla de períodos del operador.', ''],
            ['D_operador', 'Abre la pantalla de Operador de dosimetría.', ''],
            ['D_operador_Admin', 'Permite elegir cualquier operador. Sin él, cada persona ve solo lo suyo.', ''],
            ['D_rx', 'Abre la pantalla RX.', ''],
            ['D_estados', 'Abre la pantalla de Estados.', ''],
            ['D_resumen', 'Abre el historial de operadores.', ''],
            ['D_resumen_Admin', 'En el resumen muestra a todos los operadores, sin filtrar por persona.', ''],
            ['D_reporte_alta_baja', 'Genera el reporte PDF de altas y bajas de períodos.', ''],
        ],
    },
    {
        id: 'not',
        titulo: 'Notificaciones y alarmas',
        detalle: '',
        filas: [
            ['NOTIFICACIONES', 'Muestra el menú Notificaciones y la pantalla Ver notificaciones.', ''],
            ['N_alarmas', 'Abre la pantalla de Alarmas.', ''],
            ['N_asignar_alarma', 'Asignar alarmas a receptores.', ''],
        ],
    },
    {
        id: 'asi',
        titulo: 'Asistencia',
        detalle: '',
        filas: [
            ['ASISTENCIA', 'Muestra el menú Asistencia y habilita el botón Nuevo en horas y servicios extras.', ''],
            ['A_asistencia_acceder', 'Cargar y pagar horas y servicios extras, y ver la asistencia.', ''],
            ['A_resumen_view', 'Ver el resumen de horas y servicios extras.', ''],
        ],
    },
    {
        id: 'sto',
        titulo: 'Stock y remitos',
        detalle: '',
        filas: [
            ['STOCK', 'Muestra el menú Stock y la entrada Compras.', 'Para abrir Stock total y Compras hacen falta S_stock_acceder y S_compras_acceder.'],
            ['S_stock_acceder', 'Abre la pantalla de stock total.', ''],
            ['S_stock_edita', 'Permite modificar el stock total.', ''],
            ['S_compras_acceder', 'Abre la pantalla de compras.', ''],
            ['S_compras_edita', 'Crear, anular y volver a activar compras.', ''],
            ['REMITOS', 'Muestra el menú Remisiones y su listado.', 'Para ver el listado hace falta T_remitos_acceder.'],
        ],
    },
    {
        id: 'qr',
        titulo: 'QR',
        detalle: '',
        filas: [
            ['QR', 'Muestra el menú QR.', ''],
            ['QR_interno_equipos', 'Generar QR de internos de equipos y de vehículos.', ''],
        ],
    },
    {
        id: 'cur',
        titulo: 'Cursos y multimedia',
        detalle: '',
        filas: [
            ['CURSOS', 'Muestra el menú Cursos.', ''],
            ['C_edita', 'Gestionar contenido: subir y editar videos.', ''],
            ['C_visualiza_cursos', 'Ver el contenido multimedia.', ''],
            ['C_visualiza_total', 'Ver todas las categorías, incluidas las de acceso acotado.', ''],
            ['C_visualiza_acotado', 'Ver solo las categorías que no son de acceso acotado.', ''],
        ],
    },
    {
        id: 'otr',
        titulo: 'Otros permisos y roles especiales',
        detalle: '',
        filas: [
            ['enod', 'Habilita las guías de ayuda para el personal: crear OT, asignar operadores e informes.', ''],
            ['Rol Sistemas', 'Pasa todos los controles y ve todas las OTs. No necesita asignación ni permisos sueltos.', 'Dalo a muy pocas personas.'],
            ['Rol Cliente', 'Es el perfil de las personas de una empresa cliente. Ven solo las OTs donde se las asignó como usuarios del cliente.', 'Tener el rol no alcanza: el usuario tiene que estar cargado como usuario de un cliente.'],
            ['Rol Ve-todas-las-OT', 'Permite ver todas las OTs del personal.', 'Se combina con otro rol que habilite las secciones, como Visualiza OT.'],
        ],
    },
];
