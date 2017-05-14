[![CircleCI](https://circleci.com/gh/Alsciende/ashesdb.svg?style=svg)](https://circleci.com/gh/Alsciende/ashesdb)

ashesdb
===========
A deckbuilder for Ashes: Rise of the Phoenixborn

## Prerequisites

php7, mysql, git, composer, node, npm

``` bash
sudo apt-get install php-xml
```

## Installation

``` bash
checkout this repo and the data repo 
cd to this repo

# Back-end
composer install --no-dev --no-scripts
./reset-env prod

# Front-end
cd vue
npm install -g vue-cli
npm install
npm run build
```

## Apache config

``` bash
sudo a2enmod rewrite
sudo cp ashesdb.conf.dist /etc/apache2/sites-available/ashesdb.conf
sudo vim /etc/apache2/sites-available/ashesdb.conf
sudo a2ensite ashesdb.conf
sudo apache2ctl restart
```

## Images

``` bash
ln -s /path/to/card/images web/bundles/card_images
vim vue/src/services/configService.js 
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
