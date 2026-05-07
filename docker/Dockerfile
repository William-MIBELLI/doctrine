# /docker/php/Dockerfile
FROM php:8.5.5RC1-fpm

# Installation des dépendances système pour les extensions PHP
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip

# Installation de Composer (l'équivalent de npm)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html