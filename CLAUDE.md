# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Stack

- **Backend**: Laravel 5.8 (PHP 7.1.3+), MySQL (`sigo_ENOD`)
- **Frontend**: Vue 2 + Vuex, compilado con Laravel Mix (Webpack)
- **UI**: Admin LTE + Bootstrap 4
- **PDF**: DomPDF (server-side), jsPDF + html2canvas (client-side)
- **Permisos**: Spatie Laravel Permission (roles y permisos)

## Comandos frecuentes

```bash
# Assets
npm run dev          # build de desarrollo
npm run watch        # watch + rebuild
npm run prod         # build de producción (minificado)

# Laravel
php artisan migrate
php artisan cache:clear
php artisan config:cache
php artisan VencimientosDocumentaciones   # verificar expiración de documentos
```

## Arquitectura

### Flujo principal
`OT (Orden de Trabajo)` → `Informes (por método NDT)` → `Certificados`

Las OTs pertenecen a clientes, contienen servicios, operarios, productos, EPPs y riesgos. Cada OT puede generar informes de múltiples métodos de ensayo.

### Métodos de ensayo soportados
RI (Radiografía Industrial), RD, PM (Partículas Magnéticas), LP (Líquidos Penetrantes), US (Ultrasonido), TT, CV, RG, PMI, DZ — cada uno con su propio controlador, modelo y componente Vue.

### Patrón Repository
- `BaseRepository` / `RepositoryInterface` en `app/Repositories/`
- Los controladores reciben el repositorio por constructor
- `OtsRepository` maneja transacciones complejas (DB::beginTransaction)
- Lógica de negocio compleja va en el repositorio, no en el controlador

### API
- Autenticación por `api_token` en query string
- Rutas definidas en `routes/api.php` (~41KB)
- Respuestas paginadas (10 ítems por defecto)
- Las rutas web están en `routes/web.php`, protegidas con middleware de rol/permiso

### Frontend (Vue 2)
- `resources/js/app.js` — punto de entrada, registra 150+ componentes
- `resources/js/store/` — Vuex para estado compartido
- `resources/js/mixins/permissions.js` — mixin para verificar permisos de Spatie en templates
- `resources/js/mixins/alertas.js` — helper para notificaciones Toastr
- Componentes `abm-maestro/` son la base para tablas CRUD de datos maestros

### Permisos
Middleware en rutas: `role_or_permission:Sistemas|O_alta`. Los permisos se definen con Spatie y se verifican tanto en el backend como en el frontend (mixin de permisos).

### Comandos programados
- `VencimientosDocumentaciones` — notifica por email los documentos próximos a vencer
- `DemoraCargaDosimetria` — alerta sobre carga tardía de dosimetría
- `generarZip` — comprime archivos generados

## Reglas de trabajo (ahorro de tokens)

- Responde en 1-3 oraciones. Sin preámbulos ni resumen final.
- No repitas lo que el usuario dijo. No narres el plan antes de ejecutar.
- Usa `Edit` (reemplazo parcial) para archivos existentes. `Write` solo si el cambio es >80% del archivo.
- No releas archivos ya leídos en la misma conversación salvo que hayan cambiado.
- Si necesitas leer múltiples archivos independientes, léelos en paralelo en un solo mensaje.
- No copies en la respuesta código que ya editaste — el usuario ve el diff.
- Usa `Grep`/`Glob`/`Read` directo cuando sea suficiente. `Agent` solo para búsquedas amplias o tareas complejas.
- Después de un cambio, verifica que funciona antes de declararlo listo.
- Implementa lo mínimo que resuelve el problema. Sin abstracciones ni features no pedidos.

## Convenciones del proyecto

- Los nombres de clases, rutas y variables siguen convenciones en **español** (ej. `OtsController`, `Clientes`, `Documentaciones`)
- La mayoría de los modelos tienen `$fillable` explícito y algunos usan soft deletes
- Los informes PDF se generan con vistas Blade en `resources/views/informes/` + DomPDF
- El driver de colas es `sync` — no hay worker de colas en ejecución
- Session y cache usan driver `file`
