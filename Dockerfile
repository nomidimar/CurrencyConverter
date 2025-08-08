FROM php:8.2-cli

# Install dependencies
RUN apt-get update && apt-get install -y git unzip

# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . /app

RUN composer install --no-interaction --prefer-dist

EXPOSE 8000

CMD [ "php", "-S", "0.0.0.0:8000", "-t", "public" ]
