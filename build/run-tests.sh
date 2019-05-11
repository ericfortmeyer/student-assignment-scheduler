#!/usr/bin/env sh

VENDOR_DIR=$PWD/vendor
PATH=$PATH:$VENDOR_DIR/bin

MOCK_EMAIL_SERVER=$PWD/tests/mock-extern-service
MOCK_EMAIL_SERVER_VENDOR_DIR=$MOCK_EMAIL_SERVER/vendor

if [ ! -d $VENDOR_DIR ]; then
    composer -q install
fi

if [ ! -d $MOCK_EMAIL_SERVER_VENDOR_DIR ]; then
    cd $PWD/tests/mock-extern-service
    composer -q upgrade
    cd ../../
fi

phpunit --testsuite default
php -d sendmail_path=$VENDOR_DIR/bin/smtp-mock-server.php $VENDOR_DIR/bin/phpunit --testsuite integration
php -d sendmail_path=$MOCK_EMAIL_SERVER/mock-service/smtp-mock-service.php $VENDOR_DIR/bin/phpunit --testsuite end-to-end
