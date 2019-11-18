FROM php:7.2.6-fpm

COPY init.sh /init.sh

RUN apt-get update && apt-get install -y \
  libmagickwand-dev \
  imagemagick \
  procps \
  vim \
  git \
  cron \
  libzip-dev \
  libpq-dev && \
  pecl install zip && \
  pecl install imagick && \
  docker-php-ext-install pdo pdo_pgsql && \
  docker-php-ext-enable zip && \
  docker-php-ext-enable imagick && \
  curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
  chmod 755 /init.sh

ENTRYPOINT ["/init.sh"]

CMD ["init"]
