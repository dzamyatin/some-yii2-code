FROM ubuntu:20.04

USER root

RUN apt-get update -y; \
    printf "8\n34" | apt-get install -y tzdata; \
    apt-get install -y \
    libzip-dev \
    pkg-config \
    build-essential \
    autoconf \
    bison \
    re2c \
    libxml2-dev \
    libsqlite3-dev \
    curl \
    libssl-dev \
    zlib1g-dev \
    libcurl4-gnutls-dev \
    libffi-dev \
    libpng-dev \
    libpq-dev

RUN mkdir /php && \
    curl https://www.php.net/distributions/php-8.1.13.tar.gz --output /php/php.tar.gz && \
    tar -xf /php/php.tar.gz

RUN cd php-8.1.13 && \
    ./buildconf && \
    ./configure --enable-sockets \
    --with-pdo-pgsql \
    --enable-gd \
    --enable-ftp \
    --with-ffi \
    --enable-exif \
    --with-curl \
    --with-zlib \
    --with-openssl \
    --enable-fpm \
    --with-fpm-user=root \
    -with-zip \
    --with-config-file-path=/usr/local/lib \
    --with-config-file-scan-dir=/usr/local/lib \
     && \
    make -j4 && \
    make install

COPY ./php/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY ./php/php-fpm.d/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./php/php.ini /usr/local/lib/php.ini

COPY ./backend /www

RUN curl https://xdebug.org/files/xdebug-3.2.2.tgz --output xdebug && \
    tar -xvzf xdebug && \
    cd xdebug-3.2.2 && \
    phpize && \
    ./configure --enable-xdebug && \
    make && \
    make install

ARG UID=1000
ARG GID=1000

RUN groupadd -g "${GID}" user \
  && useradd --create-home --no-log-init -u "${UID}" -g "${GID}" user

RUN mkdir -p user && \
    chown -R user:user user && \
    chmod -R 750 user

USER user

WORKDIR /www

#CMD php-fpm -R -F
CMD php-fpm -F
