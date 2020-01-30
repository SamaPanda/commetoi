#!/bin/sh

# Wait for database to be running
wait_for_database() {
  echo "####### start of wait_for_database #######";
  until netcat -z -v -w30 $DB_HOST $DB_PORT
  do
     echo "Waiting for database connection..."
     # wait for 5 seconds before check again
     sleep 5
  done
  echo "####### end of wait_for_database #######";
}


# exec php-fpm
echo "### Launch fpm"
php-fpm -D

wait_for_database

env

cd /var/www/html;
# Migrate database
php bin/console doctrine:migration:migrate --no-interaction --allow-no-migration;
# php bin/console doctrine:fixtures:load --no-interaction;


echo "### Exec CMD"
exec docker-php-entrypoint "$@"
