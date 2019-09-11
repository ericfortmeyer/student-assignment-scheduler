<?php

namespace jwvirtualassistant\AccountManagement;

use GuzzleHttp\Psr7\ServerRequest;
use \PDO;

$BASE_DIR = __DIR__ . "/../../";

require "${BASE_DIR}vendor/autoload.php";

$db = new PDO(
    sprintf("sqlite:%s", DATABASE_FILE)
);
$Request = ServerRequest::fromGlobals();
$query_params = $Request->getQueryParams();
RequestValidation\verifyQueryParamsExist($Request, ["account_secret", "username"], __NAMESPACE__ . "\\redirectToErrorPage");
$account_secret = $query_params["account_secret"];
$username = $query_params["username"];
RequestValidation\validateQueryParam(
    $Request,
    ["username", "account_secret"],
    function (string $username, string $account_secret) use ($db): bool {
        return RequestValidation\usernameAndAccountSecretMatchAnAccount(
            $db,
            new Username($username),
            $account_secret
        );
    },
    function () use ($account_secret) {
        header(
            sprintf(
                "Location: /account-management/verify-username?account_secret=%s&error_code=%d",
                htmlspecialchars($account_secret),
                404 // error code
            )
        );
    }
);
RequestValidation\validateQueryParam(
    $Request,
    ["account_secret"],
    function (string $account_secret) use ($db): bool {
        return RequestValidation\accountSecretExists($db, $account_secret);
    },
    function () {
        header(
            sprintf(
                "Location: /account-management/verify-account-secret?error_code=%d",
                404 //error code
            )
        );
    }
);
/**
 * @todo Add:
 *       (1) ReCAPTCHA
 *       (2) CSRF tokens
 */
// $csrf_token;
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="resources/css/main.css" />
    </head>
    <body>
        <section class="notifications">
            <?php
            if (key_exists("error_code", $query_params) && $query_params["error_code"] == 400) :
                ?>
            <div class="message--error">
                <h1>
                    The passwords you entered did not match.  Please try again.
                </h1>
            </div>
                <?php
            endif;
            ?>
        </section>
        <form action="accounts?username=<?php echo htmlentities($username);?>&account_secret=<?php echo htmlentities($account_secret);?>" method="post" id="forgot_password">
            <!-- <input type="hidden" name="csrf_token" value="<?php /*echo htmlentities($csrf_token); */?>"/> -->
            <header>
            </header>
            <section>
            <h2>
                Please enter your new password.
            </h2>
            <p>
                <label for="password">
                    Password <span style="color:red">*</span>
                </label>
                <input type="password" name="password" required/>
            </p>
            <p>
                <label for="password">
                    Confirm password <span style="color:red">*</span>
                </label>
                <input type="password" name="confirm_password" required/>
            </p>
            <button type="submit">Submit</button>
            </section>
        </form>
    </body>
</html>

