<?php
require __DIR__ . "/../vendor/autoload.php";
$query_params = GuzzleHttp\Psr7\ServerRequest::fromGlobals()->getQueryParams();
$new_account_secret = $query_params["account_secret"];
?>
<!DOCTYPE html>
<html>
    <body>
        <h1>
            Your account was created
        </h1>
        <p>
            Your account secret is: <?php echo htmlentities($new_account_secret) ?>

        </p>
        <p>
            *Please save this account secret to create a new password or manage your account in other ways.
        </p>
    </body>
</html>