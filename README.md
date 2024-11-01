lib:
- docker exec symplay-phpfpm --rm composer install

project:
- docker exec symplay-phpfpm --rm composer install
- docker exec symplay-phpfpm --rm npm install 


@todo
- install composer in phpfpm
- check atal: detected dubious ownership in repository at '/var/www/application'
        git config --global --add safe.directory /var/www/application
- lib/php/extensions/no-debug
- Environment variable not found: "DEV_SQLITE_URL
- export APP_ENV=dev
- desactivate grumphp on host (no php)