<?php
require __DIR__ . "/../vendor/autoload.php";
$query_params = GuzzleHttp\Psr7\ServerRequest::fromGlobals()->getQueryParams();
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="resources/css/main.css" />
    </head>
    <body>
        <h1>
            JW Virtual Assistant
        </h1>
        <section class="notifications">
            <?php if (key_exists("error_code", $query_params) && $query_params["error_code"] == 400) :?>
            <div class="message--error">
                <h1>
                    <?php echo htmlentities($query_params["error_message"]);?>
                </h1>
            </div>
            <?php endif; ?>
        </section>
        <form action="accounts" method="post" id="create_account_form">
            <header></header>
            <section>
                <p>
                    <label for="username">
                        Username <span style="color:red">*</span>
                    </label>
                    <input type="text" name="username" required/>
                </p>
                <p>
                    <label for="password">
                        Password <span style="color:red">*</span>
                    </label>
                    <input type="password" name="password" required/>
                </p>
                <p>
                    <label for="email">
                        Confirm password: <span style="color:red">*</span>
                    </label>
                    <input type="password" name="confirm_password" />
                </p>
                <p>
                    <label for="email">
                        Email address: 
                        <span style="font-size:small">
                            *Your email address is not required to use this software.
                        </span>
                    </label>
                    <input type="email" name="email" />
                </p>
                <p style="font-size:small">
                    
                </p>
                <button type="submit">Submit</button>
            </section>
        </form>
    </body>
</html>

