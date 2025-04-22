FROM php:8.2-apache

# Installer les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install intl pdo_mysql zip

# Activer le module Apache mod_rewrite
RUN a2enmod rewrite

# Copier les fichiers de l'application Symfony
COPY . /var/www/html

# Définir le répertoire de travail
WORKDIR /var/www/html

# Configurer Git pour ignorer les erreurs de propriété
RUN git config --global --add safe.directory /var/www/html

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV APP_ENV=dev
RUN composer install --optimize-autoloader --no-scripts

# Définir les permissions
RUN chown -R www-data:www-data /var/www/html