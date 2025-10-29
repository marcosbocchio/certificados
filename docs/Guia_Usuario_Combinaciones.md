## Guía de usuario: Combinaciones de servicios en Certificados

Esta guía explica, en lenguaje simple, cómo combinar y descombinar servicios al armar un Certificado, y cómo se reflejan esas combinaciones en el PDF.

---

### 1) ¿Qué es una combinación?
- Cuando en un mismo día y para la misma obra hay dos o más servicios que se pueden combinar (por ejemplo, `RID` y `LPD`), el sistema los agrupa en una sola línea con la etiqueta `RID + LPD`.
- Si las cantidades de los servicios no son iguales, se combinan tantas unidades como el mínimo entre ellas y el resto queda como servicio individual (sobrante) de su abreviatura.

Ejemplo:
- Mismo día y obra: `LPD = 1` y `RID = 20` → En el PDF verás `RID + LPD = 1` y `RID = 19` por separado.

---

### 2) Dónde se gestionan las combinaciones
- Pantalla: creación/edición de Certificados (`certificados.vue`).
- Sección “Servicios”: verás una tabla con columnas Parte, Obra, Servicio, Descripción, Fecha, Combinación y Cantidad.

---

### 3) Cómo combinar automáticamente
1. Marcá los Partes que quieras incluir en el certificado.
2. El sistema propone las combinaciones automáticamente por cada día y obra cuando hay al menos dos servicios combinables.
3. En la columna “Combinación” se muestra:
   - Número de combinación (interno) y etiqueta (por ejemplo `RID + LPD`), o
   - La abreviatura del servicio si no entra en ninguna combinación.

Notas:
- La combinación automática nunca mezcla días distintos ni obras distintas.
- La propuesta puede ajustarse manualmente (ver sección 4).

---

### 4) Acciones manuales sobre una fila de servicio
- Quitar combinación (ícono “X”):
  - Disponible solo si la fila pertenece a una combinación (tiene número).
  - Quita la combinación para ese grupo (mismo día, misma obra y mismo número) y deja cada servicio por separado.

- Volver a combinar (ícono flecha):
  - Si la fila tenía un número de combinación anterior, lo recupera y vuelve a armar la etiqueta del grupo.
  - Si NO tenía número previo (por ejemplo, porque se guardó y se volvió a editar), el sistema crea una nueva combinación usando el número global siguiente (toma el mayor número de todas las combinaciones actuales y le suma 1), siempre y cuando haya otra abreviatura combinable ese mismo día y obra.

- Quitar fila (ícono “-”):
  - Excluye esa fila del certificado.
  - Si la fila pertenecía a una combinación activa, primero se descombina el grupo y luego se oculta la fila.

Importante:
- La “X” no aparece si el servicio no forma parte de una combinación.
- La flecha no crea combinación si no existe otra abreviatura combinable ese mismo día y obra.

---

### 5) Guardar y ver el PDF
- Al guardar, el sistema abre el **PDF agrupado** del certificado.
- Cómo lo verás en el PDF:
  - Las combinaciones aparecen como una fila con la etiqueta (por ejemplo `RID + LPD`) y una cantidad igual al mínimo de las abreviaturas.
  - Los sobrantes se suman en filas individuales con su abreviatura.
  - Las tablas están separadas por obra para facilitar la lectura.

---

### 6) Reglas y límites a recordar
- La combinación solo se arma dentro del mismo día y la misma obra.
- Solo combinan servicios marcados como “combinables” en el sistema.
- La numeración de combinaciones manuales sin número previo es global y consecutiva (1, 2, 3, …), no se reinicia por día ni por obra.

---

### 7) Consejos prácticos
- Si quitaste una combinación y guardaste, al volver a editar podés recombinar con la flecha; el sistema te asignará un nuevo número automáticamente si hay condiciones para combinar.
- Si un servicio no muestra la “X”, es porque no pertenece a ninguna combinación.
- Para depurar un caso, verificá siempre que los servicios pertenezcan al mismo día y obra.

---

### 8) Preguntas frecuentes
- ¿Por qué no puedo combinar? → Revisá que haya al menos dos servicios combinables el mismo día y obra.
- ¿Por qué aparece un sobrante? → Porque las cantidades de las abreviaturas no eran iguales; el combinado toma el mínimo y lo que sobra va a la abreviatura individual.
- ¿Se renumeran todas las combinaciones si toco una fila? → No. Las acciones manuales impactan solo en el grupo de ese día y obra. La numeración nueva se asigna solo al grupo que estás recombinando si no tenía número previo.


