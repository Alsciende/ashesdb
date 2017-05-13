[![CircleCI](https://circleci.com/gh/Alsciende/ashesdb.svg?style=svg)](https://circleci.com/gh/Alsciende/ashesdb)

ashesdb
===========
A deckbuilder for Ashes: Rise of the Phoenixborn

## Installation

Prerequisites: php7, mysql, composer, node, npm, git

``` bash
checkout this repo and the data repo 
cd to this repo

# Back-end
composer install
./reset-env prod

# Front-end
cd vue
npm install -g vue-cli
npm install
npm run build
```

## Apache config

- Create a VirtualHost pointing to web/
- Create a folder with all the card images, accessible from this VirtualHost
- Configure vue/src/services/configService.js 

## Usage

Access /index.html in the VirtualHost

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
