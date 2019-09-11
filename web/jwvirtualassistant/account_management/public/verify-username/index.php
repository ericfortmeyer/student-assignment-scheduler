<?php

namespace jwvirtualassistant\AccountManagement;

/**
 * Verify username
 *
 * Important: account secret required.
 *
 * The secret will be a parameter in the GET request
 * from the link in the email or a form the user submitted
 * to verify the account secret.
 */

use GuzzleHttp\Psr7\ServerRequest;
use \PDO;

require __DIR__ . "/../../vendor/autoload.php";

$db = new PDO(
    sprintf("sqlite:%s", DATABASE_FILE)
);
$Request = ServerRequest::fromGlobals();
RequestValidation\verifyQueryParamsExist($Request, ["account_secret"], __NAMESPACE__ . "\\redirectToErrorPage");
RequestValidation\validateQueryParam(
    $Request,
    ["account_secret"],
    function (string $account_secret) use ($db): bool {
        return RequestValidation\accountSecretExists($db, $account_secret);
    },
    function () { header("Location: /verify-account-secret");}
);
// $csrf_token; // may not be necessary
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="/resources/css/main.css" />
    </head>
    <body>
        <form action="/forgot-password" method="get" id="create_account_form">
            <header></header>
            <section>
                <h1>Please verify your username</h1>
                <p>
                    <label for="username">
                        Please enter your username <span style="color:red">*</span>
                    </label>
                    <input type="text" name="username" required/>
                    <input type="hidden" name="account_secret" value="<?php echo htmlentities($account_secret);?>"/>
                    <!-- <input type="hidden" name="csrf_token" value="<?php /*echo htmlentities($csrf_token);*/?>" /> -->
                </p>
                <button type="submit">Submit</button>
            </section>
        </form>
    </body>
</html>

