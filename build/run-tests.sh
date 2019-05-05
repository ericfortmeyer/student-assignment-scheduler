#!/usr/bin/env sh

VENDOR_DIR=$PWD/vendor
PATH=$PATH:$VENDOR_DIR/bin

if [ ! -d $VENDOR_DIR ]; then
    composer -q install
fi

phpunit --testsuite default
php -d sendmail_path=$VENDOR_DIR/bin/smtp-mock-server.php $VENDOR_DIR/bin/phpunit --testsuite integration
phpunit --testsuite end-to-end
