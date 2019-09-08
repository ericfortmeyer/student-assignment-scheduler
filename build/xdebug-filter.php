<?php declare(strict_types=1);

if (!\function_exists('xdebug_set_filter')) {
    return;
}

define('APP_ROOT', __DIR__ . DIRECTORY_SEPARATOR . 'src');

\xdebug_set_filter(
    \XDEBUG_FILTER_CODE_COVERAGE,
    \XDEBUG_PATH_WHITELIST,
    [
        APP_ROOT . '/Utils/',
        APP_ROOT . '/Classes/',
        APP_ROOT . '/FileRegistry/',
        APP_ROOT . '/FileNaming/',
        APP_ROOT . '/FileSaving/',
        APP_ROOT . '/Downloading/',
        APP_ROOT . '/Encryption/',
        APP_ROOT . '/InputValidation/',
        APP_ROOT . '/Notification/',
        APP_ROOT . '/Parsing/',
        APP_ROOT . '/Persistence/',
        APP_ROOT . '/Policies/',
        APP_ROOT . '/Querying/',
        APP_ROOT . '/Utils/',
        APP_ROOT . '/Validation/'
    ]
);
