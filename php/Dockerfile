FROM ubuntu:20.04

USER root

RUN apt-get update -y; \
    printf "8\n34" | apt-get install -y tzdata; \
    apt-get install -y \
    git \
    wget \
    libonig-dev \
    unzip \
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
    libpq-dev \
    libmemcached-dev \
    libwebp-dev \
    libjpeg-dev \
    libfreetype-dev \
    libmagickwand-dev \
    libmagickcore-dev

RUN mkdir /php && \
    curl https://www.php.net/distributions/php-8.1.13.tar.gz --output /php/php.tar.gz && \
    tar -xf /php/php.tar.gz

#PHP install\configure

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
    --with-zip \
    --with-config-file-path=/usr/local/lib \
    --with-config-file-scan-dir=/usr/local/lib/conf.d \
    --enable-mbstring \
    --enable-intl \
    --enable-pcntl \
    --with-pdo-mysql \
    --enable-gd \
    --with-webp \
    --with-jpeg \
    --with-freetype \
     && \
    make -j4 && \
    make install

COPY ./php/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY ./php/php-fpm.d/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./php/php.ini /usr/local/lib/php.ini

COPY ./backend /www

#PHP extension

#xdebug
RUN curl https://xdebug.org/files/xdebug-3.2.2.tgz --output xdebug.tgz && \
    tar -xvzf xdebug.tgz && \
    cd xdebug-3.2.2 && \
    phpize && \
    ./configure --enable-xdebug && \
    make && \
    make install

#memcached
RUN cd / && \
    wget https://github.com/php-memcached-dev/php-memcached/archive/refs/tags/v3.2.0.zip && \
    unzip v3.2.0.zip && \
    cd php-memcached-3.2.0 && \
    phpize && \
    ./configure && \
    make && \
    make install

#image magic
RUN cd / && \
    wget https://github.com/Imagick/imagick/archive/refs/heads/3.7.0.zip && \
    unzip 3.7.0.zip && \
    cd imagick-3.7.0 && \
    phpize && \
    ./configure && \
    make && \
    make install

#Add system user for php-fpm

ARG UID=1000
ARG GID=1000

RUN groupadd -g "${GID}" user && \
    useradd --create-home --no-log-init -u "${UID}" -g "${GID}" user && \
    mkdir -p user && \
    chown -R user:user user && \
    chmod -R 750 user

USER user

WORKDIR /www

#CMD php-fpm -R -F
CMD php-fpm -F
