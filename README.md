# Repositorio Repotriara

## 📌 Descripción del Proyecto
Repositorio Repotriara es una plataforma diseñada para la gestión y almacenamiento de archivos dentro de un entorno seguro y estructurado. Permite a los usuarios cargar, descargar, administrar y compartir documentos de manera eficiente, manteniendo un control estricto sobre los accesos y permisos.

## 🎯 Objetivos del Proyecto
- Proveer un sistema seguro y accesible para la gestión de archivos.
- Implementar permisos de usuario para restringir accesos según niveles.
- Ofrecer notificaciones por correo electrónico sobre acciones importantes.
- Registrar logs de actividad en el sistema.
- Facilitar la interacción mediante una interfaz intuitiva y moderna.

## 🛠️ Tecnologías Utilizadas
- **Backend:** Laravel 11
- **Frontend:** Blade Templates + Bootstrap
- **Base de Datos:** MySQL
- **Autenticación:** Laravel Breeze
- **Manejo de Archivos:** Almacenamiento Local en Laravel
- **Notificaciones:** Envío de correos mediante SMTP

## 👥 Roles y Niveles de Acceso
El sistema maneja diferentes niveles de usuario con permisos específicos:

| Nivel | Rol                          | Accesos Principales |
|-------|------------------------------|---------------------|
| 10    | Administrador de accesos      | Gestión total de usuarios y archivos |
| 8     | Administrador del sistema     | No tiene acceso a usuarios del sistema ni categorías |
| 0     | Cliente                       | Solo puede acceder a sus archivos asignados |

## 📂 Funcionalidades Principales
### 🔹 Gestión de Archivos
- Subida de archivos con un límite de **2GB** por usuario.
- Administración de archivos con opciones de búsqueda y filtrado.
- Descargas públicas mediante enlaces con `id` y `public_token`.

### 🔹 Seguridad y Permisos
- Manejo de accesos basado en el campo `level` de la base de datos.
- Restricción de rutas y vistas según nivel de usuario.
- Eliminación automática de archivos temporales al llegar la fecha de expiración.

### 🔹 Notificaciones y Logs
- Envío de credenciales por correo al crear un usuario.
- Notificación al cliente cuando se le asignan archivos.
- Registro de actividad en el sistema (descargas, subidas, modificaciones, etc.).

## ⚙️ Instalación y Configuración
### 1️⃣ Clonar el Repositorio
```sh
 git clone https://github.com/RepoTriara/RepoTriara
 cd repositorio-repotriara
```

### 2️⃣ Instalar Dependencias
```sh
composer install
npm install
```

### 3️⃣ Configurar Variables de Entorno
Renombrar el archivo `.env.example` a `.env` y configurar la base de datos:
```sh
cp .env.example .env
```

### 4️⃣ Generar Claves y Migraciones
```sh
php artisan key:generate
php artisan migrate --seed
```

### 5️⃣ Iniciar el Servidor
```sh
php artisan serve
```

