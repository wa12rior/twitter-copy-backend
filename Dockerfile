FROM webdevops/php-nginx-dev:8.0

COPY ./.docker/php.webdevops.ini /opt/docker/etc/php/php.webdevops.ini
COPY ./.docker/application.conf /opt/docker/etc/php/fpm/pool.d/application.conf

### General
RUN apt-get update && apt-get install -y \
    lsb-release \
    ca-certificates \
    apt-transport-https \
    software-properties-common \
    build-essential \
    libpcre3-dev \
    librabbitmq-dev \
    libssh-dev

### Set working directory
WORKDIR /app

### Setup default conf and copy existed app
COPY app /app
COPY .docker/default.conf /opt/docker/etc/nginx/vhost.conf

RUN cp .env.dist .env
RUN composer install --no-ansi --no-dev --no-interaction --no-plugins --no-progress --no-scripts --optimize-autoloader

COPY .docker/dev_entrypoint.sh /opt/docker/provision/entrypoint.d/dev_entrypoint.sh
