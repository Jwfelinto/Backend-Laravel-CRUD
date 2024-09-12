FROM php:8.2-fpm

RUN apt-get update && \
    apt-get install -y \
    default-mysql-client \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    git \
    unzip \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

    RUN rm -Rf /var/www/html \
        && ln -s /var/app/current /var/www/html \
        && mkdir /run/php-fpm \
        && chmod -R 777 /run/php-fpm

COPY composer.json composer.lock ./
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-autoloader --no-scripts

COPY . .

RUN composer dump-autoload --optimize
RUN composer install --no-dev --prefer-dist --no-scripts --no-autoloader

WORKDIR /var/app/current

CMD ["php-fpm"]
