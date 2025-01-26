#!/bin/sh
service cron start

while ! mysqladmin ping -h"$DB_HOST" --silent; do
    sleep 1
done
echo "gonna run migrations"

php artisan migrate 

exec php artisan serve --host=0.0.0.0 --port=8000
# usually port is passed from helm chart values file but let's hardcode it to 8000 here