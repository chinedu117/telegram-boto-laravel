#!/usr/bin/env bash

set -e
set -x



docker exec -it laravel_app composer install && docker exec -it laravel_app php artisan migrate

echo "Run your commands here"
docker exec -it laravel_app bash