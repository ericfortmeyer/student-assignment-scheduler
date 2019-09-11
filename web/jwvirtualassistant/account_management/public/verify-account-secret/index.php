<?php

namespace jwvirtualassistant\AccountManagement;

/**
 * Verify account secret
 *
 * If a user opts-out of email,
 * they will need to store a secret which will be
 * given to them when the account was created.
 */
//  $csrf_token ; // may not be necessary
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="/resources/css/main.css" />
    </head>
    <body>
        <form action="/verify-username" method="get" id="create_account_form">
            <header></header>
            <section>
                <h2>Please enter the account secret</h2>
                <p>
                    If you opted-out of adding your email address to your account,
                    you were given an account secret for account verification.
                    Unfortunately, if you lost or forgot your account secret and 
                    your password, you will need to create a new account and will lose all data from 
                    your existing account.
                </p>
                <p>
                    <label for="account_secret">
                        Account secret <span style="color:red">*</span>
                    </label>
                    <input type="text" name="account_secret" required/>
                    <!--<input type="hidden" name="csrf_token" value="<?php /*echo htmlentities($csrf_token);*/ ?>" /> -->
                </p>
                <button type="submit">Submit</button>
            </section>
        </form>
    </body>
</html>

