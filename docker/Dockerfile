FROM php:7.4-apache

COPY /docker/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY /src /var/www/src
COPY /public /var/www/public
COPY /vendor /var/www/vendor
RUN chown -R www-data:www-data /var/www && a2enmod rewrite
