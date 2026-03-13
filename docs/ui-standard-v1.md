# UI Standard v1 (ENOD)

## Objetivo
Unificar la experiencia visual de la UI operativa ENOD para que acciones equivalentes se vean y se comporten igual.

## Reglas base
- Accion primaria: `btn btn-enod`.
- Accion secundaria: `btn btn-default` (o neutra equivalente).
- Accion de riesgo/destructiva: `btn-enod-danger` (o `btn-danger` donde aun no migre).

## Botones de formularios
- CTA principal de formulario: al final, abajo-derecha.
- Usar contenedor: `enod-form-actions enod-form-actions--end`.
- Si hay mas de una accion en footer/modal:
  - secundaria a la izquierda (`Cancelar`, `Volver`)
  - primaria a la derecha (`Guardar`, `Confirmar`, `Actualizar`)

## Color ENOD
- Color primario unificado: `--enod-color-primary` (amarillo ENOD).
- Evitar hardcode (`#F9CA33`, `#FDCA0B`, etc.) en componentes.
- Usar clases utilitarias (`btn-enod`, `enod-accent-bg`) y variables CSS.

## Estados
- Primaria deshabilitada: conservar estilo ENOD con opacidad y cursor bloqueado.
- Focus visible en botones de accion (accesibilidad minima).

## Checklist rapido por pantalla
1. Guardar/Actualizar/Confirmar usa `btn-enod`.
2. CTA principal al final del formulario, alineada a la derecha.
3. Orden correcto de acciones (secundaria izquierda, primaria derecha).
4. Sin hardcode de color ENOD en inline style.
