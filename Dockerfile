FROM dunglas/frankenphp

RUN install-php-extensions \
    curl \
    fileinfo \
    #ftp \
    #gd \
    #imap \
    #ldap \
    mbstring \
    #opcache \
    openssl \
    #pdo_mysql \
    #pdo_oci \
    #pdo_pgsql \
    pdo_sqlite

COPY . /app

ENTRYPOINT ["php", "artisan", "octane:frankenphp"]
