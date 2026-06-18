# Sistema de correo IQMaximo con Resend

## Objetivo

Montar un panel simple para que un admin pueda:

- ver buzones disponibles
- listar correos recibidos y enviados
- enviar correos desde el dominio
- importar historial viejo de Resend
- ver el detalle completo de un correo seleccionado

La idea actual es no depender de Outlook ni de un cliente externo mientras se valida el flujo.

## Variables usadas

Estas son las variables que el modulo usa ahora.

### Variables generales del sistema

- `IQMAXIMO_URL`
  - URL base del sitio.
- `IQMAXIMO_DB_HOST`
  - host de la base de datos.
- `IQMAXIMO_DB_NAME`
  - nombre de la base de datos.
- `IQMAXIMO_DB_USER`
  - usuario de la base de datos.
- `IQMAXIMO_DB_PASSWORD`
  - clave de la base de datos.

### Variables de correo base

- `IQMAXIMO_MAIL_INFO`
  - correo principal de info.
- `IQMAXIMO_MAIL_WEBMASTER`
  - correo usado como correo base del panel y remitente por defecto en varias vistas.

### Variables de Resend

- `IQMAXIMO_RESEND_API_KEY`
  - clave API de Resend.
- `IQMAXIMO_RESEND_FROM_EMAIL`
  - correo remitente para envio.
- `IQMAXIMO_RESEND_FROM_NAME`
  - nombre visible del remitente.
- `IQMAXIMO_CORREO_WEBHOOK_SECRET`
  - secreto opcional para autorizar `correo/webhook.php` usando `?secret=` o encabezado `X-IQMaximo-Correo-Secret`.

### Variables del panel de correo

- `IQMAXIMO_CORREO_ADMIN_USER`
  - usuario del admin inicial.
- `IQMAXIMO_CORREO_ADMIN_PASS`
  - contraseña del admin inicial.
- `IQMAXIMO_CORREO_MAILBOXES_JSON`
  - lista JSON de buzones visibles en el panel.
- `IQMAXIMO_CORREO_DEFAULT_MAILBOX`
  - buzon activo por defecto.
- `IQMAXIMO_CORREO_STORAGE_DIR`
  - carpeta opcional para almacenamiento local.

## Ejemplo de configuracion usada

```php
"IQMAXIMO_CORREO_MAILBOXES_JSON" => "[{\"username\":\"info\",\"email\":\"info@iqmaximo.com\",\"assigned_email\":\"info@iqmaximo.com\",\"active\":true},{\"username\":\"fparedes\",\"email\":\"fparedes@iqmaximo.com\",\"assigned_email\":\"fparedes@iqmaximo.com\",\"active\":true}]",
"IQMAXIMO_CORREO_DEFAULT_MAILBOX" => "fparedes@iqmaximo.com",
```

## Que intenta hacer el sistema

### 1. Login admin

El panel usa un usuario admin inicial creado desde:

- `IQMAXIMO_CORREO_ADMIN_USER`
- `IQMAXIMO_CORREO_ADMIN_PASS`

Con eso se entra al panel y se administra todo desde una sola cuenta.

### 2. Ver buzones

El admin no crea usuarios de correo dinamicamente en esta version.
El panel solo muestra buzones predefinidos desde `IQMAXIMO_CORREO_MAILBOXES_JSON`.

### 3. Leer historial local

El panel no consulta Resend en cada click.
La idea es:

- guardar mensajes en la base local
- listar desde la base local
- abrir detalle desde la base local

### 4. Importar historial viejo

El flujo que se intento implementar es:

1. llamar `List Received Emails` de Resend
2. usar `after` y `limit` para paginar
3. para cada correo recibido, llamar `Retrieve Received Email`
4. guardar `html`, `text`, `raw` y metadatos en la base
5. volver a listar desde la base local

### 5. Correo nuevo

Para correos nuevos la idea es usar webhook:

- Resend manda el evento `email.received`
- el webhook lo guarda en la base
- el panel luego solo lee localmente

## Problema tecnico actual

El sistema esta cerca del objetivo, pero hay dos riesgos:

### A. Rate limit de Resend

Si se importan varios correos seguidos, Resend puede responder:

- `Too many requests`

Eso pasa porque cada correo recibido requiere varias llamadas:

- una para listar
- otra para obtener el detalle

### B. Datos viejos incompletos

Si un mensaje quedo guardado solo con metadatos y sin cuerpo, el detalle puede mostrar:

- `Sin contenido`

Eso significa que ese registro no tiene `html` ni `text` utiles en la base local.

## Flujo tecnico resumido

```text
Resend webhook / receiving list
    -> guardar mensaje local
    -> panel lista desde DB
    -> click en mensaje
    -> detalle desde DB
```

## Lo que se intento corregir

- fallback de buzones para que aparezca `fparedes@iqmaximo.com`
- lectura de cuerpo desde `payload_json` cuando `html/text` estan vacios
- importacion por paginas con `after`
- reduccion de llamadas por importacion
- pausa corta entre llamadas de detalle

## Recomendacion tecnica

Para que esto sea estable:

- dejar Resend solo como fuente de ingreso y envio
- guardar todo en la base local
- importar historico de forma incremental
- usar webhook para nuevos correos
- no hacer importaciones masivas en un solo click

## Estado actual

El panel ya intenta:

- listar buzones
- mostrar inbox/sent local
- importar recibidos de Resend
- leer detalle del mensaje seleccionado
- preparar respuesta desde un correo recibido

Pero todavia depende de que:

- el despliegue en Coolify tenga la ultima version
- Resend tenga disponible el historico que se quiere recuperar
- la base local ya haya guardado el cuerpo completo del correo
