#!/usr/bin/env sh

cd /home/$STAGING_USER/staging
PATH=$PATH:$PWD/vendor/bin
phpunit
