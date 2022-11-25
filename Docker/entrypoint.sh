#!/bin/bash
composer install
php artisan storage:link
chown -R www-data:www-data storage
php artisan migrate

#Once containers are up you execute following commands at first start
#composer install
#php artisan migrate --force
#php artisan storage:link
#chown -R www-data:www-data storage
