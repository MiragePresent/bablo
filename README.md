# bablo

** Quick start guide

* Clone this repository into your projects folder `git clone git@github.com:MiragePresent/bablo.git`
* Switch to project directory `cd bablo`
* And switch to `api` branch
* Copy example enviroment file `cp .env.example .env` and fill basic sesstings such as `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
* Run `composer install` command
* Generate applicatin key `php artisan key:generate`
* Create DB with tables and test entries by running `php artisan migrate --seed` (if this command will return you an error then run `composer dump-autoload && php artisan migrate:fresh --seed`). DB seeder show you test user access that was created 
* Configure vhost with `valet` or `nginx`, `apache2` etc.
