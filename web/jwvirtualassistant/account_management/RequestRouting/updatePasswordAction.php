<?php declare(strict_types=1);
/**
 * This file is a part of JW Virtual Assistant Login Account Management.
 * 
 * Copywright (c) Eric Fortmeyer.
 * See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */


namespace jwvirtualassistant\AccountManagement\RequestRouting;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Uri;
use \PDO;

use jwvirtualassistant\AccountManagement\Username;
use jwvirtualassistant\AccountManagement\Password;

use function jwvirtualassistant\AccountManagement\updateAccountPassword;

function updatePasswordAction(ServerRequestInterface $request, PDO $db): ResponseInterface
{
    $username = $request->getQueryParams()["username"];
    $account_secret = $request->getQueryParams()["account_secret"];
    $password_string = $request->getParsedBody()["password"];
    $confirm_password = $request->getParsedBody()["confirm_password"];
    $username = new Username($username);
    $password = new Password([$password_string]);
    $site_url = "http://localhost:7999";
    
    if ($password_string !== $confirm_password) {
        return (new Response(400))
            ->withHeader(
                "Location",
                    (string) Uri::withQueryValues(
                        (new Uri($site_url))->withPath("forgot-password"),
                        [
                            "username" => (string) $username,
                            "account_secret" => (string) $account_secret,
                            "error_code" => 400
                        ]
                    )
            );
    }
    
    [$updateStatus, $new_account_secret] = updateAccountPassword(
        $db,
        $username,
        $password
    );

    if ($updateStatus) {
        return (new Response())
            ->withHeader(
                "Location",
                (string) Uri::withQueryValue(
                    (new Uri($site_url))->withPath("PasswordChangeSuccess.php"),
                    "account_secret",
                    $new_account_secret
                )
            );
    } else {
        return (new Response())
            ->withHeader(
                "Location",
                (new Uri($site_url))->withPath("PasswordChangeFail.html")
            );
    }
}
