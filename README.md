[![CircleCI](https://circleci.com/gh/Alsciende/ashesdb.svg?style=svg)](https://circleci.com/gh/Alsciende/ashesdb)

ashesdb
===========
A deckbuilder for Ashes: Rise of the Phoenixborn

## Prerequisites

php 7.x, mysql, git, composer, node 6.x, npm

Install php DOM extension:

``` bash
sudo apt-get install php-xml
```

Create a database in MySQL:

``` bash
mysql -uroot -p -e "create database ashesdb"
```

## Checkout

Clone the code repository (this repository) to a location, e.g. `/var/www/ashesdb`. Also clone the data repository to e.g. `/home/toto/ashesdb-data`.

## Apache config

``` bash
sudo a2enmod rewrite
sudo cp ashesdb.conf.dist /etc/apache2/sites-available/ashesdb.conf
sudo vim /etc/apache2/sites-available/ashesdb.conf
sudo a2ensite ashesdb.conf
sudo service apache2 reload
```

## Back-end

``` bash
composer install --no-dev
./reset-env prod
```

Then [fix Symfony permissions](http://symfony.com/doc/current/setup/file_permissions.html).

## Images

``` bash
ln -s /path/to/card/images web/bundles/card_images
vim vue/src/services/configService.js 
```

## Front-end

``` bash
cd vue
npm install
npm run build
```

## Tests

``` bash
./reset-env test
bin/phpunit
```

## Dev

``` bash
./reset-env dev
cd vue
npm run dev
```
