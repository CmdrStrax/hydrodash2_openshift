FROM php:8.3-apache

RUN apt-get update && \
    apt-get install -y
RUN apt-get install -y curl
RUN apt-get install -y build-essential libssl-dev zlib1g-dev libpng-dev libjpeg-dev libfreetype6-dev
RUN apt-get install -y libicu-dev
RUN apt-get install -y libzip-dev libonig-dev
RUN apt-get install -y libpq-dev

COPY site.conf /etc/apache2/sites-available/000-default.conf

RUN apt-get update
RUN docker-php-ext-install intl
RUN docker-php-ext-configure intl
RUN docker-php-ext-install mysqli pdo pdo_mysql zip mbstring
RUN a2enmod rewrite
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install gd
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pgsql pdo_pgsql
    
RUN 

# INSTALL AND UPDATE COMPOSER
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer self-update
ENV COMPOSER_ALLOW_SUPERUSER 1

COPY app /var/www/app/
WORKDIR /var/www/app/
RUN composer require codeigniter4/framework
RUN composer require codeigniter4/shield
RUN composer install
RUN php spark migrate --all

RUN service apache2 restart

RUN chgrp -R 0 /var/run/apache2 && chmod -R g=u /var/run/apache2
RUN chgrp -R 0 /run/apache2 && chmod -R g=u /run/apache2
RUN chgrp -R 0 /run/apache2/apache2.pid && chmod -R g=u /run/apache2/apache2.pid

