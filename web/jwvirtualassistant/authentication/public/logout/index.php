<?php


$auth_config = require __DIR__ . "/../config/config.auth.php";

session_name($auth_config["session_name"]);
session_start();

$_SESSION = [];

array_map(
    function ($cookie_name) {
        setcookie($cookie_name, "", time() - 4600);
    },
    $cookie_names
);

session_destroy();
