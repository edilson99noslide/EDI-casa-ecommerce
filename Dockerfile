FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    curl \
    libzip-dev \
    zip \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip

# Instala Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000
