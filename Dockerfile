FROM php:8.1-apache

# Copy semua file ke dalam container
COPY . /var/www/html/

# Install ekstensi PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

EXPOSE 80
CMD ["apache2-foreground"]

# Jalankan Apache
CMD ["apache2-foreground"]
