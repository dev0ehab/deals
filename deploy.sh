#!/bin/sh
# activate maintenance mode
# php artisan down


# update source code

chmod 777 deploy.sh
git add .
git commit -m "server update"
git pull origin main
git add .
git commit -m "server update"

# php artisan table:drop contact_us
# php artisan table:drop file_attributes
# php artisan table:drop order_files
# php artisan table:drop order_product_features
# php artisan table:drop order_products
# php artisan table:drop orders
# php artisan table:drop addresses
# php artisan roles:refresh
# php artisan migrate



# composer require phpoffice/phpspreadsheet
# php artisan storage:link

# php artisan migrate:fresh --seed

# update PHP dependencies
#composer install --no-interaction --prefer-dist
# composer install
# --no-interaction Do not ask any interactive question
# --no-dev  Disables installation of require-dev packages.
# --prefer-dist  Forces installation from package dist even for dev versions.

# clear config cache
# composer app:clear

# run autoload
# composer dump-autoload

# update database
# php artisan migrate --force
# --force  Required to run when in production.

# clear cache
# php artisan optimize:clear

# clear config cache
# composer app:clear

# run autoload
# composer dump-autoload

# stop maintenance mode
php artisan up
