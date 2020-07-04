#!/usr/bin/env bash

while [ true ]
do
    php /var/www/francken/artisan schedule:run --verbose --no-interaction 
    sleep 60
done
