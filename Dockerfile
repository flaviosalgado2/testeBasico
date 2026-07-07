FROM php:8.5.8-cli

RUN docker-php-ext-install pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

EXPOSE 8000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "/var/www"]