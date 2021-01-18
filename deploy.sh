#!/bin/bash
/usr/bin/git pull && \
/usr/local/php72/bin/php /usr/local/bin/composer install --no-dev  && \
/usr/local/php72/bin/php artisan migrate --force && \
/usr/local/php72/bin/php artisan cache:clear && \
/usr/local/php72/bin/php artisan view:clear && \
/usr/local/php72/bin/php artisan auth:clear-resets && \
/usr/local/php72/bin/php artisan route:cache && \
/usr/local/php72/bin/php artisan config:cache && \
/usr/bin/npm install && \
/usr/bin/npm run production
