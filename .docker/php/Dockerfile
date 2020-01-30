FROM php:7.2.10-fpm

RUN apt-get update \
    && mkdir -p /usr/share/man/man1 \
    && mkdir -p /usr/share/man/man7 \
    && apt-get install -y --no-install-recommends vim \
    curl \
    debconf \
    git \
    locales \
    acl \
    mailutils \
    wget \
    gnupg \
    gnupg1 \
    gnupg2 \
    zlib1g-dev \
    postgresql \
    postgresql-contrib \
    postgresql-server-dev-all \
    sudo \
    apache2 \
    netcat 



RUN rm -rf /var/lib/apt/lists/*

# Configure apache
RUN a2enmod proxy_fcgi ssl rewrite proxy proxy_balancer proxy_http proxy_ajp
RUN sed -i '/Global configuration/a \
ServerName localhost \
' /etc/apache2/apache2.conf
COPY .docker/config/vhosts/sf4.conf /etc/apache2/sites-enabled
RUN rm /etc/apache2/sites-enabled/000-default.conf

# Install PHP extensions
RUN docker-php-ext-install pdo_pgsql
RUN docker-php-ext-install pdo pdo_mysql zip

# Copy php conf files
COPY .docker/php/php.ini /usr/local/etc/php/php.ini
COPY .docker/php/php-fpm-pool.conf 	/usr/local/etc/php/pool.d/www.conf

# Install composer
RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
	mv composer.phar /usr/local/bin/composer

# Install phpunit
RUN wget --no-check-certificate https://phar.phpunit.de/phpunit-6.5.3.phar && \
    mv phpunit*.phar phpunit.phar && \
    chmod +x phpunit.phar && \
    mv phpunit.phar /usr/local/bin/phpunit

RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen && \
    locale-gen

# Copy source code
COPY . /var/www/html

# Install vendors
RUN composer install

# Copy Entrypoint
COPY .docker/entrypoint.sh /usr/local/bin
RUN chmod +x /usr/local/bin/entrypoint.sh

RUN chmod -R 777 /var/www/html/var

ENTRYPOINT [ "entrypoint.sh" ]
CMD ["apachectl", "-DFOREGROUND", "-e", "info"]
