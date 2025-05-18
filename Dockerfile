FROM php:8.1-apache

# Instala extensiones necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo pdo_mysql

# Copia los archivos del proyecto (solo la app) a la carpeta pública
COPY src/ /var/www/html/

# Copia el .env por separado si lo necesitas
COPY .env /var/www/html/.env

# Establece permisos
RUN chown -R www-data:www-data /var/www/html/

# Asegura que apache se mantenga en foreground (esto ya lo hace la imagen base)
CMD ["apache2-foreground"]
