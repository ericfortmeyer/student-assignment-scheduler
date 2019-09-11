<?php declare(strict_types=1);

/**
 * @param string $key
 * @return mixed
 */
function getConfigValue(string $key) {
    $config_dir = __DIR__ . "/../config";
    $dist = (require "${config_dir}/config.dist.php")["dist"];
    return array_merge((require "${config_dir}/config.${dist}.php"), (require "${config_dir}/config.auth.php"))[$key];
}
