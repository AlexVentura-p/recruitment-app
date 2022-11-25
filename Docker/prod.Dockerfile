FROM php:8.0.2-fpm as php-prod
#php libraries
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    vim \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libjpeg62-turbo-dev

#copy files into container
COPY ../ /var/www/
WORKDIR /var/www/

# php extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql gd && docker-php-ext-enable pdo_mysql gd
RUN docker-php-ext-configure gd --enable-gd --with-jpeg

#composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

FROM nginx:1.19-alpine as nginx

#remove default conf
RUN rm /etc/nginx/conf.d/default.conf

#copy nginx.conf file into container
COPY Docker/nginx-files/ /etc/nginx/conf.d/



