#!/bin/bash

# Installing Midnight Commander, Curl, Unzip
apt-get -qy install mc curl unzip

# Installing the Composer
#curl -sS https://getcomposer.org/installer -o composer-setup.php
#php composer-setup.php --install-dir=/usr/local/bin --filename=composer
#composer self-update

# Installing Package Dependencies
cd /home/site/wwwroot
#composer install --no-interaction --prefer-dist

# Installing FrankenPHP (PHP application server) by Laravel Octane
php artisan --no-interaction octane:install --server=frankenphp

# Copying Env File
cp -n azure-laravel-env .env

# Copy the database file but without overwriting an existing file, -n, --no-clobber means do not overwrite an existing file
cp -n /home/site/wwwroot/database/database.sqlite.example /home/site/database.sqlite

php artisan --no-interaction migrate --force
php artisan --no-interaction optimize

# In case of starting FrankenPHP Server by Laravel Octane
service nginx stop
php artisan --no-interaction octane:frankenphp --workers=4 --max-requests=250 --port=8080

# In case of using the Nginx
#cp /home/site/wwwroot/azure-nginx-default /etc/nginx/sites-available/default
#service nginx reload
