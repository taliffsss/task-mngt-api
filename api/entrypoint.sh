#!/bin/sh

# Start by running composer install
composer install

service cron start

php artisan storage:link

# Start the PHP development server
php artisan serve --host 0.0.0.0 --port 8181
