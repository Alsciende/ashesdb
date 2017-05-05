[![CircleCI](https://circleci.com/gh/Alsciende/ashesdb.svg?style=svg)](https://circleci.com/gh/Alsciende/ashesdb)

ashesbdb
===========
A deckbuilder for Ashes: Rise of the Phoenixborn

## Installation

Prerequisites: php7, mysql, composer, node, npm, git

- checkout the repo
- composer install
- ./reset-env dev
- cd web
- npm install -g vue-cli
- npm install
- npm run build
- create a symlink or an Apache alias from /web/bundles/card_images to a folder containing all the images of the cards

