<?php declare(strict_types=1);
if (!\function_exists('xdebug_set_filter')) {
    return;
}

define('MODULE_DIR', __DIR__ . DIRECTORY_SEPARATOR . 'src/Persistence' . DIRECTORY_SEPARATOR);
\xdebug_set_filter(
    \XDEBUG_FILTER_CODE_COVERAGE,
    \XDEBUG_PATH_WHITELIST,
    [MODULE_DIR]
);
