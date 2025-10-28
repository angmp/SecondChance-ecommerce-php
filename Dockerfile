# Gunakan image PHP dengan Apache
FROM php:8.1-apache

# Copy semua file ke dalam container
COPY . /var/www/html/

# Ubah working directory ke folder Website
WORKDIR /var/www/html/Website

# Install ekstensi PHP yang umum
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Expose port 80
EXPOSE 80

# Jalankan Apache
CMD ["apache2-foreground"]
