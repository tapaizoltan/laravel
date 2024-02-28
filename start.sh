#! /bin/bash
clear
echo "Laravel szerver indul..."
cd /var/www/html/laravel/
php artisan serve --host=0.0.0.0
