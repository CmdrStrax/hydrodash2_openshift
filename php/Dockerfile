FROM php:8.3-apache

#
# Install dependencies
#

RUN apt-get update && apt-get install -y \
    curl build-essential libssl-dev zlib1g-dev libpng-dev \
    libjpeg-dev libfreetype6-dev libicu-dev libzip-dev \
    libonig-dev libpq-dev \
    && rm -rf /var/lib/apt/lists/*

#
# Install and config php
#

RUN docker-php-ext-configure intl \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install intl mysqli pdo pdo_mysql zip mbstring gd pgsql pdo_pgsql

#
# Apache config
#

COPY site.conf /etc/apache2/sites-available/000-default.conf

RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf \
    && a2enmod rewrite

#
# Prepare composer
#

COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1

#
# Copy app and set permissions
#

RUN chgrp -R 0 /var/www/html /var/run/apache2 /var/lock/apache2 /var/log/apache2 \
    && chmod -R g=u /var/www/html /var/run/apache2 /var/lock/apache2 /var/log/apache2

COPY app /var/www/html/
WORKDIR /var/www/html/

RUN chgrp -R 0 /var/www/html /var/run/apache2 /var/lock/apache2 /var/log/apache2 \
    && chmod -R g=u /var/www/html /var/run/apache2 /var/lock/apache2 /var/log/apache2

RUN composer install --no-interaction --optimize-autoloader

#
# Expose port 8080 for Openshift
#

EXPOSE 8080

#
# Start Apache (important: no 'service apache2 restart' in Dockerfile!)
#

CMD ["apache2-foreground"]
