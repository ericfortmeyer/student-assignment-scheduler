<?php declare(strict_types=1);
if (!\function_exists('xdebug_set_filter')) {
    return;
}

define('MODULE_DIR', __DIR__ . DIRECTORY_SEPARATOR . 'src/AccountManagement' . DIRECTORY_SEPARATOR);
define('DATA_DIR', MODULE_DIR . 'data' . DIRECTORY_SEPARATOR);
\xdebug_set_filter(
    \XDEBUG_FILTER_CODE_COVERAGE,
    \XDEBUG_PATH_WHITELIST,
    [MODULE_DIR]
);

\xdebug_set_filter(
    \XDEBUG_FILTER_CODE_COVERAGE,
    \XDEBUG_PATH_BLACKLIST,
    [DATA_DIR]
);
