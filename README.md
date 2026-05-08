# IQMAXIMO Hostinger deploy

Repositorio preparado desde una copia limpia de `public_html` para despliegue Git en Hostinger.

## Configuracion en Hostinger

1. Crear base de datos MySQL en Hostinger.
2. Importar manualmente el dump local:
   `G:\IQMAXIMO\iqservidor\iqmaximo_local_test\iqmaximo_respaldo_20260505_235133\databases\iqmaximo_db.sql`
3. Copiar `require/config.local.example.php` como `require/config.local.php` en el hosting.
4. Completar en `require/config.local.php` los datos nuevos de MySQL, Mailjet y reCAPTCHA.
5. En hPanel, conectar este repo GitHub a la carpeta `public_html`.

No subas el dump SQL ni credenciales al repositorio.
