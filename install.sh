#! /bin/sh
composer update && npm i
php artisan migrate:fresh --seed
copy .env.example .env
php artisan key:generate
php artisan storage:link