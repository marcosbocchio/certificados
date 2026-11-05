/* Registro central de datos de la sección de ayuda.
 * Cada entidad expone { hero, acciones, dependencias, bloques, botones, errores, calculos, edicion, impacto, relacionados, demo, ir_a, variantes? }
 */

import ot from './ot.js';
import asignaciones from './asignaciones.js';
import visualizarOt from './visualizar-ot.js';
import visualizarDocOperadores from './visualizar-doc-operadores.js';
import visualizarProcedimientos from './visualizar-procedimientos.js';
import visualizarVehiculos from './visualizar-vehiculos.js';
import equipos from './equipos.js';
import internoEquipos from './interno-equipos.js';
import equipoEnInforme from './equipo-en-informe.js';
import guiaRoles from './guia-roles.js';
import guiaAccesoUsuario from './guia-acceso-usuario.js';
import guiaNoVeo from './guia-no-veo.js';

export default {
    ot,
    asignaciones,
    'visualizar-ot': visualizarOt,
    'visualizar-doc-operadores': visualizarDocOperadores,
    'visualizar-procedimientos': visualizarProcedimientos,
    'visualizar-vehiculos': visualizarVehiculos,
    equipos,
    'interno-equipos': internoEquipos,
    'equipo-en-informe': equipoEnInforme,
    'guia-roles': guiaRoles,
    'guia-acceso-usuario': guiaAccesoUsuario,
    'guia-no-veo': guiaNoVeo,
};
