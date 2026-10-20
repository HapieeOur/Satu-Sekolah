#!/bin/bash
set -e

echo "==> Starting WebSekolah container initialization..."

cd /var/www/html

# Ensure storage directories exist and are writable
mkdir -p storage/framework/{sessions,views,cache} storage/logs storage/app/public
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Create storage symlink
php artisan storage:link --force || true

# Run database migration if DB credentials are provided
if [ -n "$DB_HOST" ] && [ "$DB_CONNECTION" != "sqlite" ]; then
    echo "==> Running database migrations..."
    php artisan migrate --force || echo "Warning: Migration failed, continuing startup..."

    if [ "$RUN_SEEDER" = "true" ]; then
        echo "==> Seeding database..."
        php artisan db:seed --force || echo "Warning: Seeding failed, continuing startup..."
    fi
fi

# Cache configuration, routes, and views for production performance
echo "==> Optimizing Laravel cache..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Configure Nginx port dynamically for Railway / Cloud PORT env
TARGET_PORT="${PORT:-80}"
echo "==> Configuring Nginx on port ${TARGET_PORT}..."
sed -i "s/listen 80;/listen ${TARGET_PORT};/g" /etc/nginx/http.d/default.conf || true
sed -i "s/listen \[::\]:80;/listen [::]:${TARGET_PORT};/g" /etc/nginx/http.d/default.conf || true

echo "==> Starting PHP-FPM and Nginx..."
php-fpm -D
exec nginx -g "daemon off;"
