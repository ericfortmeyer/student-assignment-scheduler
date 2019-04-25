<?php declare(strict_types=1);
if (!\function_exists('xdebug_set_filter')) {
    return;
}

\xdebug_set_filter(
    \XDEBUG_FILTER_CODE_COVERAGE,
    \XDEBUG_PATH_WHITELIST,
    [
        '/Users/Eric/Documents/Theocratic/LAMM/TalkSlipSender/Functions/',
        '/Users/Eric/Documents/Theocratic/LAMM/TalkSlipSender/Classes/',
        '/Users/Eric/Documents/Theocratic/LAMM/TalkSlipSender/Persistence/',
        '/Users/Eric/Documents/Theocratic/LAMM/TalkSlipSender/Rules/',
        '/Users/Eric/Documents/Theocratic/LAMM/TalkSlipSender/FileRegistry/',
        '/Users/Eric/Documents/Theocratic/LAMM/TalkSlipSender/Validation/',
        '/Users/Eric/Documents/Theocratic/LAMM/TalkSlipSender/Utils/'
    ]
);
