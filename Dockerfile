FROM php:8.1-fpm

ENV APP_ENV=production \
    APP_DEBUG=false \
    PORT=8080

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y --no-install-recommends \
    build-essential \
    nginx \
    curl \
    git \
    unzip \
    zip \
    gettext-base \
    libicu-dev \
    libonig-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    libxml2-dev \
    libssl-dev \
    ca-certificates \
    gnupg \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql pgsql gd zip bcmath exif \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY . /var/www/html
COPY docker/nginx/default.conf.template /etc/nginx/conf.d/default.conf.template

RUN composer install --no-interaction --no-progress --prefer-dist --optimize-autoloader --no-dev \
    && npm install \
    && npm run build \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan storage:link --force \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod +x /var/www/html/docker/entrypoint.sh

EXPOSE 8080

ENTRYPOINT ["/var/www/html/docker/entrypoint.sh"]
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]
