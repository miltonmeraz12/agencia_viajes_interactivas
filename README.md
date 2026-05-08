# Agencia de Viajes Interactivas

Sistema web en Laravel 13 para administrar una agencia de viajes. Incluye catalogos de destinos, hospedajes, transportes y paquetes, compra de paquetes por clientes, historial de reservaciones, correos automaticos, tickets PDF e importacion/exportacion de usuarios con Excel.

## Funcionalidad principal

- Catalogo de paquetes disponible desde `/paquetes`.
- Registro e inicio de sesion con Laravel Breeze.
- Roles:
  - `admin`: administra destinos, hospedajes, transportes, paquetes, usuarios y todas las reservaciones.
  - `usuario`: consulta catalogos, compra paquetes, cancela reservaciones permitidas y descarga tickets.
- CRUD administrativo de destinos, hospedajes, transportes y paquetes.
- Soft delete para destinos, hospedajes, transportes y paquetes.
- Compra de paquete con folio unico alfanumerico de 8 caracteres.
- Correo de bienvenida, confirmacion de compra y cancelacion.
- Ticket PDF imprimible con Dompdf.
- Importacion de usuarios desde `.xlsx` o `.csv` con columnas `nombre`, `correo`, `telefono`, `fecha_nacimiento`.
- Exportacion de usuarios a Excel.
- Perfil editable con nombre, correo, telefono, fecha de nacimiento, foto y contrasena.

## Estructura del proyecto

```text
app/
  Http/Controllers/        Controladores de autenticacion, catalogos, compras, perfil y usuarios.
  Http/Middleware/         Middleware AdminMiddleware para proteger rutas administrativas.
  Imports/Exports/         Clases de Laravel Excel para usuarios.
  Mail/                    Mails de bienvenida, compra y cancelacion.
  Models/                  Modelos Eloquent y relaciones principales.
database/
  migrations/              Esquema de usuarios, destinos, hospedajes, transportes, viajes y reservaciones.
  seeders/                 Usuarios de prueba y catalogo inicial.
resources/
  views/auth/              Login, registro y recuperacion de cuenta.
  views/destinos/          Listado, formularios y detalle de destinos.
  views/hospedajes/        Listado, formularios y detalle de hospedajes.
  views/transportes/       CRUD administrativo de transportes.
  views/viajes/            Catalogo publico, detalle de paquete y CRUD admin.
  views/reservaciones/     Historial, detalle y ticket PDF.
  views/emails/            Plantillas Markdown Blade de correos.
routes/
  web.php                  Rutas publicas, autenticadas y administrativas.
```

## Requisitos

- PHP 8.3 o superior.
- Composer 2.
- Node.js 20 o superior y npm.
- SQLite para desarrollo rapido o MySQL 8 para entorno similar al documento.
- Extensiones PHP comunes de Laravel: `pdo`, `mbstring`, `openssl`, `fileinfo`, `xml`, `zip`.

## Instalacion rapida

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
npm run build
php artisan storage:link
```

Para desarrollo con Vite:

```bash
php artisan serve
npm run dev
```

Despues abre:

```text
http://127.0.0.1:8000
```

## Configuracion de base de datos

Desarrollo con SQLite:

```env
DB_CONNECTION=sqlite
```

MySQL 8:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=agencia_viajes
DB_USERNAME=root
DB_PASSWORD=
```

Luego ejecuta:

```bash
php artisan migrate:fresh --seed
```

## Correos

Para desarrollo seguro se recomienda dejar:

```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS="reservas@agencia.test"
MAIL_FROM_NAME="${APP_NAME}"
```

Los correos se guardan en `storage/logs/laravel.log`. Para Mailtrap o SMTP real, configura `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD` y `MAIL_ENCRYPTION`.

## Cuentas de prueba

```text
Admin:
admin@agencia.com
password

Usuario:
usuario@agencia.com
password
```

El seeder tambien crea datos demostrativos para revisar el sistema con contenido realista:

```text
8 destinos
14 hospedajes
10 transportes
12 paquetes de viaje
5 usuarios
5 reservaciones iniciales
```

## Flujo de compra

1. El cliente entra a `/paquetes`.
2. Abre el detalle de un paquete.
3. Si no tiene sesion, inicia sesion o se registra.
4. Compra el paquete.
5. El sistema crea una reservacion con folio unico.
6. Se envia correo de confirmacion.
7. El cliente descarga el ticket PDF desde su historial.

## Excel de usuarios

Archivo esperado:

```text
nombre,correo,telefono,fecha_nacimiento
Ana Torres,ana@example.com,4441234567,2000-05-10
```

Si una fila falla validacion, el panel muestra el numero de fila y el error. La contrasena temporal de usuarios importados es `password123`.

## Comandos utiles

```bash
php artisan route:list
php artisan migrate:fresh --seed
php artisan test
php artisan view:clear
php artisan cache:clear
php artisan storage:link
npm run build
```

## Verificacion realizada

- `php artisan route:list --except-vendor`
- `php artisan view:clear && php artisan view:cache`
- `DB_CONNECTION=sqlite DB_DATABASE=/tmp/agencia_interactivas_test.sqlite php artisan migrate:fresh --seed`
- `DB_CONNECTION=sqlite DB_DATABASE=/tmp/agencia_interactivas_test.sqlite php artisan test`
