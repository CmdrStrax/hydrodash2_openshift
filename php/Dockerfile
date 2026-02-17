FROM php:8.3-apache

# 1. System-Abhängigkeiten bündeln und Cache bereinigen

RUN apt-get update && apt-get install -y \
    curl build-essential libssl-dev zlib1g-dev libpng-dev \
    libjpeg-dev libfreetype6-dev libicu-dev libzip-dev \
    libonig-dev libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# 2. PHP Extensions konfigurieren und installieren

RUN docker-php-ext-configure intl \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install intl mysqli pdo pdo_mysql zip mbstring gd pgsql pdo_pgsql

# 3. Apache Konfiguration (Port 8080 statt 80)

COPY site.conf /etc/apache2/sites-available/000-default.conf

RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf \
    && a2enmod rewrite

# 4. Composer vorbereiten

COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1

# 5. App kopieren und Berechtigungen setzen

COPY app /var/www/html/
WORKDIR /var/www/html/

# WICHTIG: OpenShift benötigt Schreibrechte für die Root-Gruppe in diesen Verzeichnissen
RUN chgrp -R 0 /var/www/app /var/run/apache2 /var/lock/apache2 /var/log/apache2 \
    && chmod -R g=u /var/www/app /var/run/apache2 /var/lock/apache2 /var/log/apache2

# Composer-Befehle (Migrate sollte idealerweise im Entrypoint oder Deployment-Hook laufen, nicht im Build)
RUN composer install --no-interaction --optimize-autoloader

# Port 8080 für OpenShift signalisieren
EXPOSE 8080

# Apache im Vordergrund starten (KEIN 'service apache2 restart' im Dockerfile!)
CMD ["apache2-foreground"]
