#!/bin/bash

apt-get -qy install mc
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
