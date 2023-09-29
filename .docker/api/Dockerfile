FROM php:8.2-fpm
ARG host_uid=1000
ARG host_gid=1000

RUN apt-get update

RUN apt-get install -y \
        unzip

# Install PHP extensions
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions \
    && install-php-extensions \
      sockets \
      xdebug \
    && rm /usr/local/bin/install-php-extensions

RUN usermod --non-unique --uid ${host_uid} www-data \
  && groupmod --non-unique --gid ${host_gid} www-data

USER www-data

COPY --from=composer /usr/bin/composer /usr/bin/composer

ENV COMPOSER_HOME=/home/composer

WORKDIR /var/www

COPY config/php.ini /usr/local/etc/php/conf.d/
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
ENTRYPOINT [ "bash", "/usr/local/bin/entrypoint.sh" ]