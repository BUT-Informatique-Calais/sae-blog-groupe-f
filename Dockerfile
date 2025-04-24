# Utiliser une image de base PHP-FPM
FROM php:8.2-fpm

# Installer les extensions PHP nécessaires
RUN curl -sSLf -o /usr/local/bin/install-php-extensions \
    https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions && \
    chmod +x /usr/local/bin/install-php-extensions

RUN install-php-extensions opcache gd soap pdo_pgsql pdo_mysql intl xdebug apcu zip memcached @composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Donner les permissions à l'utilisateur www-data
RUN chown -R www-data:www-data /var/www/html