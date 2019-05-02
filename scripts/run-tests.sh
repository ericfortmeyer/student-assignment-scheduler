#!/usr/bin/env sh

cd /home/red-rock/staging
PATH=$PATH:$PWD/vendor/bin
phpunit
