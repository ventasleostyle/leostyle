# Imagen base de PHP con Apache
FROM php:8.2-apache

# Copiar el código al contenedor
COPY . /var/www/html/

# Dar permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Habilitar extensiones comunes (mysqli, pdo, etc.)
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Puerto que Render usará
EXPOSE 8080

# Apache escucha en 8080 en Render
RUN sed -i 's/80/8080/' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's/80/8080/' /etc/apache2/ports.conf

CMD ["apache2-foreground"]
