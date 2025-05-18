# Usa la imagen oficial de PHP 8.1 con Apache
FROM php:8.1-apache

# Instala las extensiones necesarias para PDO y MySQLi
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo pdo_mysql

# Copia todo el proyecto al directorio público de Apache
COPY . /var/www/html/

# Copia explícitamente el archivo .env
COPY .env /var/www/html/.env

# Ajusta permisos (opcional pero recomendable)
RUN chown -R www-data:www-data /var/www/html/

# Expone el puerto 80 (Railway lo mapeará automáticamente)
EXPOSE 80

# Comando por defecto (ya gestionado por la imagen base):
#   Apache arranca automáticamente.
