FROM php:7.4-apache

# Dependencias del sistema
RUN apt-get update && apt-get install -y \
        libpng-dev libjpeg-dev libfreetype6-dev \
        libzip-dev zip unzip \
        libxml2-dev libonig-dev \
        libssl-dev \
        default-mysql-client \
        git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        pdo_mysql \
        mysqli \
        mbstring \
        xml \
        zip \
        bcmath \
        opcache \
        exif \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Apache: rewrite + apuntar DocumentRoot a /var/www/html/public
RUN a2enmod rewrite headers
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Permitir .htaccess (override)
RUN printf '<Directory "/var/www/html/public">\n\tAllowOverride All\n\tRequire all granted\n</Directory>\n' \
        > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel

# php.ini ajustado para desarrollo
RUN { \
        echo 'memory_limit = 512M'; \
        echo 'upload_max_filesize = 64M'; \
        echo 'post_max_size = 64M'; \
        echo 'max_execution_time = 180'; \
        echo 'date.timezone = America/Argentina/Buenos_Aires'; \
    } > /usr/local/etc/php/conf.d/zz-app.ini

WORKDIR /var/www/html

# Composer (por si hace falta correr algo después)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

EXPOSE 80
