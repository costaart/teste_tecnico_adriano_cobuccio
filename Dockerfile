FROM php:8.3-fpm

RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

RUN apt-get update && apt-get install -y \
    curl libpng-dev libjpeg-dev libfreetype6-dev zip unzip git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
EXPOSE 9000
CMD ["php-fpm"]
