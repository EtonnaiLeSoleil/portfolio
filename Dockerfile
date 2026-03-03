FROM php:8.2-apache

# Installer les extensions PHP nécessaires (ex: PDO et MySQL)
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Activer le module de réécriture d'URL d'Apache (utile si vous utilisez un htaccess)
RUN a2enmod rewrite

# Configurer le DocumentRoot d'Apache pour pointer directement vers le dossier 'public'
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
