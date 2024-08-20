FROM php:8.2-apache

RUN apt-get update && \
    apt-get install -y \
    libzip-dev unzip \
    && docker-php-ext-install pdo pdo_mysql zip

# Necessário para gerar o coverage
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN echo "xdebug.coverage_enable" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.mode=coverage" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY --from=composer/composer:latest-bin /composer /usr/bin/composer

RUN a2enmod rewrite \
    && a2enmod actions

CMD bash -c "composer install" && apache2-foreground