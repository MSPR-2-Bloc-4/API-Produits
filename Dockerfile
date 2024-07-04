# Utiliser l'image PHP officielle avec Apache
FROM php:8.2-apache

# Installer les dépendances nécessaires
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir la variable d'environnement pour permettre à Composer de s'exécuter en tant que root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Copier les fichiers de l'application dans le répertoire de travail
COPY . /var/www/html

# Copier la configuration Apache
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Changer le propriétaire des fichiers pour éviter les problèmes de permissions
RUN chown -R www-data:www-data /var/www/html

# Activer le module Apache mod_rewrite
RUN a2enmod rewrite

# Exposer le port 80 pour le serveur web
EXPOSE 80
