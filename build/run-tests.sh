#!/usr/bin/env sh

VENDOR_DIR = $PWD/vendor
PATH=$PATH:$VENDOR_DIR/bin

if [ ! -d $VENDOR_DIR]; then
    composer -q install
fi

phpunit
