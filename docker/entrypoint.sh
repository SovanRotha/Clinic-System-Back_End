#!/bin/sh
set -e

if [ ! -f /var/www/html/.env ]; then
  cp /var/www/html/.env.example /var/www/html/.env 2>/dev/null || true
fi

php artisan key:generate --force || true
php artisan optimize:clear || true
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link --force
php artisan migrate --force

mkdir -p /var/www/html/storage/logs /var/www/html/bootstrap/cache
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

envsubst '${PORT}' < /etc/nginx/conf.d/default.conf.template > /etc/nginx/conf.d/default.conf

php-fpm -D
nginx -g 'daemon off;'
