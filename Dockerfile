# Utiliser une image de base PHP avec Apache
FROM php:8.2-apache

# Installer les extensions PHP nécessaires
RUN curl -sSLf -o /usr/local/bin/install-php-extensions \
    https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions && \
    chmod +x /usr/local/bin/install-php-extensions

RUN install-php-extensions opcache gd soap pdo_pgsql pdo_mysql intl xdebug apcu zip memcached @composer

# Copier les fichiers du projet dans le conteneur
COPY . /var/www/html

# Définir le répertoire de travail
WORKDIR /var/www/html

# Activer le module Apache pour Symfony
RUN a2enmod rewrite