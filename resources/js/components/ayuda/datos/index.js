/* Registro central de datos de la sección de ayuda.
 * Cada entidad expone { hero, acciones, dependencias, bloques, botones, errores, calculos, edicion, impacto, relacionados, demo, ir_a, variantes? }
 */

import ot from './ot.js';
import asignaciones from './asignaciones.js';
import visualizarOt from './visualizar-ot.js';
import visualizarDocOperadores from './visualizar-doc-operadores.js';
import visualizarProcedimientos from './visualizar-procedimientos.js';
import visualizarVehiculos from './visualizar-vehiculos.js';

export default {
    ot,
    asignaciones,
    'visualizar-ot': visualizarOt,
    'visualizar-doc-operadores': visualizarDocOperadores,
    'visualizar-procedimientos': visualizarProcedimientos,
    'visualizar-vehiculos': visualizarVehiculos,
};
