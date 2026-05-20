FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    unzip \
    git \
    libzip-dev \
    && docker-php-ext-install pdo_sqlite zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

RUN touch database/database.sqlite
RUN chmod 777 database/database.sqlite

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
