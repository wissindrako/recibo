# Guía de despliegue — Sistema Recibo

## Requisitos generales

| Componente | Versión mínima |
|---|---|
| PHP | 8.1 |
| Composer | 2.x |
| Node.js | 16+ |
| MySQL | 5.7 / 8.x |
| Nginx o Apache | cualquier versión reciente |

---

## Opción A — Docker (desarrollo y producción con contenedores)

### Requisitos previos
- Docker Engine 20+
- Docker Compose v2

### Primera instalación

```bash
# 1. Clonar el repositorio
git clone <url-del-repo> recibo
cd recibo

# 2. Copiar y ajustar variables de entorno
cp .env.example .env
```

Editar `.env` con los valores correctos:

```env
APP_NAME="Sistema Recibo"
APP_ENV=production        # local | production
APP_KEY=                  # se genera en el paso 5
APP_DEBUG=false
APP_URL=http://tu-dominio.com:8010   # o el dominio/puerto real

DB_CONNECTION=mysql
DB_HOST=db                # nombre del servicio en docker-compose
DB_PORT=3306
DB_DATABASE=db_recibo
DB_USERNAME=usr_db
DB_PASSWORD=tu_password_seguro
```

```bash
# 3. Construir e iniciar los contenedores
docker compose up -d --build

# 4. Instalar dependencias PHP
docker exec recibo-app composer install --no-dev --optimize-autoloader

# 5. Generar clave de la aplicación
docker exec recibo-app php artisan key:generate

# 6. Instalar dependencias Node y compilar assets
docker exec recibo-app bash -c "npm install && npm run build"

# 7. Ejecutar migraciones y seeders
docker exec recibo-app php artisan migrate --force
docker exec recibo-app php artisan db:seed --force

# 8. Crear enlace de almacenamiento público
docker exec recibo-app php artisan storage:link

# 9. Optimizar para producción
docker exec recibo-app php artisan optimize
```

La aplicación queda disponible en `http://localhost:8010`.  
phpMyAdmin en `http://localhost:9001`.

---

### Actualizar el proyecto (Docker)

```bash
# 1. Obtener últimos cambios
git pull origin main

# 2. Actualizar dependencias PHP (solo si cambió composer.lock)
docker exec recibo-app composer install --no-dev --optimize-autoloader

# 3. Compilar assets (solo si cambiaron JS/CSS)
docker exec recibo-app bash -c "npm install && npm run build"

# 4. Ejecutar migraciones nuevas
docker exec recibo-app php artisan migrate --force

# 5. Limpiar y regenerar cachés
docker exec recibo-app php artisan optimize:clear
docker exec recibo-app php artisan optimize
```

---

### Comandos útiles Docker

```bash
# Ver logs en tiempo real
docker compose logs -f app

# Reiniciar solo el contenedor de la app
docker compose restart app

# Acceder a la shell del contenedor
docker exec -it recibo-app bash

# Apagar todos los contenedores
docker compose down

# Apagar y eliminar volúmenes (¡borra la BD!)
docker compose down -v
```

---

## Opción B — Servidor Linux sin Docker

### Requisitos previos

```bash
# Ubuntu / Debian
sudo apt update
sudo apt install -y nginx mysql-server php8.1-fpm \
  php8.1-cli php8.1-mysql php8.1-mbstring php8.1-xml \
  php8.1-bcmath php8.1-gd php8.1-curl php8.1-zip \
  php8.1-intl unzip git curl

# Instalar Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Instalar Node.js 18 (via nvm o nodesource)
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs
```

---

### Primera instalación

```bash
# 1. Clonar el repositorio en la raíz web
cd /var/www
sudo git clone <url-del-repo> recibo
sudo chown -R www-data:www-data recibo
cd recibo

# 2. Variables de entorno
cp .env.example .env
nano .env
```

Valores clave en `.env`:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_recibo
DB_USERNAME=usr_recibo
DB_PASSWORD=tu_password_seguro
```

```bash
# 3. Crear base de datos y usuario MySQL
sudo mysql -u root -p <<'SQL'
CREATE DATABASE db_recibo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'usr_recibo'@'localhost' IDENTIFIED BY 'tu_password_seguro';
GRANT ALL PRIVILEGES ON db_recibo.* TO 'usr_recibo'@'localhost';
FLUSH PRIVILEGES;
SQL

# 4. Instalar dependencias PHP
composer install --no-dev --optimize-autoloader

# 5. Generar clave
php artisan key:generate

# 6. Compilar assets frontend
npm install
npm run build

# 7. Migraciones y seeders
php artisan migrate --force
php artisan db:seed --force

# 8. Enlace de almacenamiento
php artisan storage:link

# 9. Permisos de carpetas de escritura
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# 10. Optimizar
php artisan optimize
```

---

### Configuración de Nginx

Crear `/etc/nginx/sites-available/recibo`:

```nginx
server {
    listen 80;
    server_name tu-dominio.com;

    root /var/www/recibo/public;
    index index.php;

    # Redirigir todo al front controller de Laravel
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }

    # Subida de archivos: hasta 50 MB
    client_max_body_size 50M;
}
```

```bash
# Activar el sitio
sudo ln -s /etc/nginx/sites-available/recibo /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

> Para HTTPS instala Certbot: `sudo certbot --nginx -d tu-dominio.com`

---

### Actualizar el proyecto (Linux sin Docker)

```bash
cd /var/www/recibo

# 1. Activar modo mantenimiento (opcional pero recomendado)
php artisan down

# 2. Obtener cambios
git pull origin main

# 3. Dependencias PHP (solo si cambió composer.lock)
composer install --no-dev --optimize-autoloader

# 4. Assets frontend (solo si cambiaron JS/CSS/Blade con clases Tailwind)
npm install
npm run build

# 5. Migraciones
php artisan migrate --force

# 6. Limpiar y regenerar cachés
php artisan optimize:clear
php artisan optimize

# 7. Corregir permisos por si git cambió archivos
sudo chown -R www-data:www-data storage bootstrap/cache

# 8. Desactivar mantenimiento
php artisan up
```

---

## Usuario administrador por defecto

Creado por el seeder (`php artisan db:seed`):

| Campo | Valor |
|---|---|
| Email | william@gmail.com |
| Contraseña | definida en `DatabaseSeeder.php` |

Cambiar la contraseña en el primer acceso desde el panel de administración.

---

## Notas importantes

- **Assets CSS/JS**: Vite genera un hash en el nombre del archivo (`app.xxxxxx.css`). Siempre ejecutar `npm run build` después de cualquier cambio en `resources/css/`, `resources/js/` o cuando Tailwind deba escanear nuevas clases en vistas Blade.
- **SSR**: El build genera también `bootstrap/ssr/ssr.js` para Laravel Splade. Si el servidor SSR no está activo, Splade funciona igual en modo cliente (no requiere proceso Node separado).
- **Almacenamiento**: Los archivos subidos (contratos adjuntos) se guardan en `storage/app/public/contratos/`. Hacer backup de esta carpeta junto con la base de datos.
- **Backup de BD**:
  ```bash
  # Docker
  docker exec recibo-db mysqldump -u usr_db -p db_recibo > backup_$(date +%F).sql

  # Linux directo
  mysqldump -u usr_recibo -p db_recibo > backup_$(date +%F).sql
  ```
