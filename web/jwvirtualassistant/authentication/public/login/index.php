<?php
  require __DIR__ . "/../../functions.php";
  [$session_name, $xsrf_token_name] = [getConfigValue("session_name"), getConfigValue("xsrf_token_name")];
  [$session_id, $xsrf_token] = setAuthSessionCookies($session_name, $xsrf_token_name);
  saveXSRFTokenToDatabase($xsrf_token, $session_id);
  $scripts_in_header = [
    "secretKey",
    "dev_urls"
  ];
  $scripts_in_body = [
    "importKey",
    "formAlert",
    "fetchToken",
    "fetchToken",
    "fetchToken",
    "tokenContainer",
    "formSubmitUIChange",
    "authResponseHandler",
    "formSubmitHandler",
    "addFormSubmitListener",
    "tokenContainerCrypto",
    "tokenContainerStore"
  ];
  $nonce_sanitized = htmlentities(base64_encode(random_bytes(32)));
  header("Content-Security-Policy: script-src 'nonce-${nonce_sanitized}'");
  header("Content-Security-Policy: style-src 'self' 'nonce-${nonce_sanitized}'");
  $path_to_scripts = "/auth/resources/javascript";
  $string_sanitizer = function (string $string_to_sanitize): string {
    return htmlentities($string_to_sanitize);
  };
?>
<!DOCTYPE html>
<html lang="en">
    <head>
      <title>JW Virtual Assistant</title>
      <meta name="theme-color" content="#ffffff" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <meta name="description" content="or: jwvirtualassistant.com community,
          LAMM Scheduling App developed by the community" />
      <link rel="manifest" href="/auth/manifest.json" />
      <link rel="shorcut icon" href="/auth/favicon.ico" />
      <link rel="icon" href="/auth/resources/images/icon-192.png" />
      <link rel="apple-touch-icon" href="/auth/resources/images/icon-192.png" />
      <link nonce='<?php echo $nonce_sanitized ?>' rel="preload" as="style" onload="this.rel='stylesheet'" href="/auth/dist/bundle.min.css" type="text/css" />
      <style nonce='<?php echo $nonce_sanitized ?>'>
          form button {
              font-size: 1rem;
              color: var(--black);
              padding: 1rem 4rem;
              appearance: none;
              border: 1px solid var(--primary);
              margin: 2rem auto;
          }
      </style>
      <?php
          array_map(
            function (string $script_name_sanitized) use ($nonce_sanitized, $path_to_scripts) {
              renderInlineScriptWithNonce($nonce_sanitized, $script_name_sanitized, $path_to_scripts);
            },
            array_map(
              $string_sanitizer,
              $scripts_in_header
            )
          );
      ?>
      
    </head>
    <body>
        <h1>
            JW Virtual Assistant
        </h1>
        <form id="loginForm" method="post" action="#">
            <header>
            </header>
            <section>
                <h2>
                    Login
                </h2>
                <div>
                    <label for="username">
                        User name
                    </label>
                    <input type="text" id="username" name="username" required/>
                </div>
                <div>
                    <label for="password">
                        Password
                    </label>
                    <input type="password" id="password" name="password" required/>
                </div>
                <p>
                    <a id="#createAccountLink" href="***">Create an account</a>
                    <script nonce='<?php echo $nonce_sanitized ?>' type="text/javascript">
                        document.getElementById("#createAccountLink").href = account_management_url;
                    </script>
                </p>
                <button type="submit">
                    <div class="form-submit-loader"><div></div><div></div><div></div><div></div></div>
                </button>
            </section>
            <input type="hidden" name="grant_type" value="password" required/>
            <input type="hidden" name="client_id" value="testclient2" required/>
        </form>
        <aside id="alert" class="form__alert"></aside>
        <?php
          array_map(
            function (string $script_name_sanitized) use ($nonce_sanitized, $path_to_scripts) {
              renderInlineScriptWithNonce($nonce_sanitized, $script_name_sanitized, $path_to_scripts);
            },
            array_map(
              $string_sanitizer,
              $scripts_in_body
            )
          );
        ?>
    </body>
</html>
