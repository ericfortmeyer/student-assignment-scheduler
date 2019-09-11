<?php declare(strict_types=1);

function renderInlineScriptWithNonce(string $nonce_sanitized, string $script_name_sanitized, string $path_to_scripts_sanitized) {
    echo "<script type='text/javascript' nonce='${nonce_sanitized}' src='${path_to_scripts_sanitized}/${script_name_sanitized}.js'></script>";
}
