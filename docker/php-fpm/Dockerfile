FROM php:8.2-fpm as base
ARG USER_ID
ARG GROUP_ID

RUN apt-get update && apt-get install -y \
    curl \
    git \
    libzip-dev \
    zip \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev

# Copy Composer from the official Composer image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# set local www-data user to host user
RUN userdel -f www-data &&\
    if getent group www-data ; then groupdel www-data; fi &&\
    groupadd -g ${GROUP_ID} www-data &&\
    useradd -l -u ${USER_ID} -g www-data www-data &&\
    install -d -m 0755 -o www-data -g www-data /home/www-data

WORKDIR  "/app"

############
#   DEV
############
FROM base as dev

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip

RUN docker-php-ext-configure zip \
    && docker-php-ext-install zip

RUN pecl install xdebug-3.2.1 \
    && docker-php-ext-enable xdebug

RUN echo "Image built for dev environment"

USER www-data

############
#   PROD
############
FROM base as prod

USER www-data
RUN echo "Image built for prod environment"
