# Plataforma de Segunda Opinión Oncológica

Plataforma web para la gestión de solicitudes de segunda opinión oncológica.

## Estado del proyecto

En desarrollo

## Tecnologías

- PHP
- JavaScript
- HTML / CSS
- MySQL
- PHPMailer
- API DriCloud

## Estructura

- `index.php` — Landing pública
- `login.php` — Acceso al área privada
- `backend.php` — Panel privado / gestión
- `api.php` — Endpoints de la aplicación
- `DriCloudAdapter.php` — Integración con DriCloud
- `SmsProvider.php` — Servicio de SMS
- `conexion_db.php` — Conexión con base de datos
- `cambiar_pass.php` — Cambio de contraseña
- `main.js` — JavaScript de la aplicación
- `styles.css` — Estilos
- `PHPMailer/` — Librería de correo
- `img/` — Imágenes

## Integraciones

- DriCloud
- Servicio de correo electrónico
- Servicio de SMS

## Base de datos

El proyecto utiliza MySQL.

Los archivos SQL incluidos corresponden al esquema/base de datos del proyecto.

## Seguridad

⚠️ No almacenar en Git:

- Contraseñas
- API keys
- Tokens
- Credenciales de bases de datos
- Datos reales de pacientes
- Documentación clínica
- Logs con información sensible

## Desarrollo

El proyecto se encuentra actualmente en fase de desarrollo.

Antes de realizar cambios importantes:

```bash
git status
git add .
git commit -m "Descripción del cambio"