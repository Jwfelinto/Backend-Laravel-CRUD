FROM ubuntu:22.04

WORKDIR /var/app/current

RUN apt-get update -y && apt-get upgrade -y \
    && apt-get install -y \
    curl \
    git \
    unzip \
    zip \
    vim \
    nginx \
    mysql-client \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    supervisor \
    software-properties-common \
    && add-apt-repository ppa:ondrej/php \
    && apt-get update -y

RUN apt-get install -y \
    php8.3 \
    php8.3-cli \
    php8.3-fpm \
    php8.3-mysql \
    php8.3-zip \
    php8.3-xml \
    php8.3-mbstring \
    php8.3-curl \
    php8.3-xmlrpc \
    php8.3-gd \
    php8.3-intl \
    php8.3-bcmath \
    php8.3-soap

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer global require "darkaonline/l5-swagger"

COPY . /var/app/current

RUN composer install --no-scripts --no-autoloader --ignore-platform-reqs \
    && composer dump-autoload

RUN chown -R www-data:www-data /var/app/current \
    && chmod -R 755 /var/app/current \
    && chmod -R 777 /var/app/current/storage \
    && chmod -R 777 /var/app/current/bootstrap/cache

EXPOSE 8000

RUN cp .env.example .env || true

RUN php artisan key:generate

CMD php artisan serve --host=0.0.0.0 --port=8000
