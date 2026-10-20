FROM node:22-alpine AS node_builder
WORKDIR /app
COPY package*.json ./
RUN npm install -g npm@latest && npm install --ignore-scripts
COPY . .
RUN npm run build

FROM composer:2 AS composer_builder
WORKDIR /app
COPY composer.json composer.lock* ./
RUN composer config platform-check false && \
    composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts --ignore-platform-reqs
COPY . .
RUN composer dump-autoload --optimize --no-dev --ignore-platform-reqs

FROM php:8.4-fpm-alpine AS runner

# Install system dependencies & PHP extensions
RUN apk add --no-cache \
    nginx \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    postgresql-dev \
    oniguruma-dev \
    bash \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_pgsql \
        pdo_mysql \
        gd \
        zip \
        opcache \
        bcmath \
        mbstring

# Configure Nginx & PHP for <= 512MB RAM environment
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini
COPY docker/php-fpm.conf /usr/local/etc/php-fpm.d/zz-docker.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

WORKDIR /var/www/html

# Copy application source & built assets
COPY . .
COPY --from=node_builder /app/public/build ./public/build
COPY --from=composer_builder /app/vendor ./vendor

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
