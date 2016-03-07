# Score Server

## Required

- PHP 5.5
- composer
- compass
- MySQL


## Setup
Create database and user, then modify db setting in fuel/app/config/db.php(default db/account/pw are all 'score').

``` shell
$ (apt-get install php5-cli mysql-common mysql-server php5-mysql  ) <require package install
$ git clone --recursive https://github.com/CyberSEAGame/score-server.git
$ curl -sS https://getcomposer.org/installer | php
$ mv composer.phar /usr/local/bin/composer
$ composer install
$ php oil r migrate --packages=auth
$ php oil r migrate
$ chmod 777 public/files
```
then use deploy.sql.

## Create Admin User
``` shell
php oil r user:createAdmin username email password
```

## Ranking Calculation
add below to cron.
``` shell
* * * * * /usr/bin/php /***/oil r ranking:calc
```

## Importing Question from Directory
``` shell
php oil r question:import [dir]
```



