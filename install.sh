#! /bin/sh
composer update && npm i
cp .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate:fresh --seed