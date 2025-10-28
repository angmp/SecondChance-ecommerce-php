FROM php:8.1-apache
COPY . /var/www/html/
WORKDIR /var/www/html
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html
EXPOSE 80
CMD ["apache2-foreground"]

