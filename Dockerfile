FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    unzip git curl libzip-dev zip

RUN docker-php-ext-install zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install

WORKDIR /app/public

EXPOSE 10000

CMD sh -c "php artisan config:clear && php artisan route:clear && php artisan view:clear && php -S 0.0.0.0:10000"
