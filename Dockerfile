FROM php:8.2-fpm-alpine

WORKDIR /var/www

# Permissions
ARG UID=1000
ARG GID=1000

RUN apk add --no-cache \
    git \
    curl \
    libpq \
    nodejs \
    libpng-dev \
    jpeg-dev \
    postgresql-dev \
    sqlite-dev \
    libzip-dev \
    oniguruma-dev \
    npm

RUN docker-php-ext-install pdo pdo_mysql opcache bcmath exif pcntl gd zip mbstring

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN addgroup -g ${GID} appgroup && adduser -G appgroup -u ${UID} -D appuser

RUN chown -R appuser:appgroup /var/www

USER appuser

EXPOSE 9000
CMD [ "php-fpm" ]
