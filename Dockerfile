FROM php:7.1.7-apache

RUN sed -i 's#DocumentRoot /var/www/html#DocumentRoot /var/www/html/public#' /etc/apache2/sites-enabled/000-default.conf && \
    a2enmod rewrite

COPY . /var/www/html

WORKDIR /var/www/html

EXPOSE 80
