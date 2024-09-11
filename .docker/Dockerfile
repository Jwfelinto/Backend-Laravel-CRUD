FROM php:8.3-cli

WORKDIR /var/app/current

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libzip-dev \
    zip \
    unzip

RUN docker-php-ext-install pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


COPY . /var/app/current

RUN chown -R www-data:www-data //var/app/current

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
