Steps:

git clone --branch master git@github.com:robert-reegan/Task-techup.git

Need to create ".env" and database credentials

composer install

php artisan key:generate

php artisan migrate

php artisan serve
