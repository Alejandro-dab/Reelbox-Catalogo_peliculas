# Usa la imagen oficial de PHP 8.5 con Apache (Versión estable a abril de 2026)
FROM php:8.5-apache

# Instala las extensiones necesarias para bases de datos
# Se añade 'apt-get clean' para reducir el tamaño de la imagen
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia el código de tu aplicación al directorio raíz de Apache
COPY . /var/www/html/

# Asegura que el usuario de Apache (www-data) tenga permisos sobre los archivos
RUN chown -R www-data:www-data /var/www/html

# Puerto estándar de tráfico web
EXPOSE 80
