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
use \InvalidArgumentException;

use jwvirtualassistant\AccountManagement\UniqueUsername;
use jwvirtualassistant\AccountManagement\Password;
use jwvirtualassistant\AccountManagement\EmailOption;

use function jwvirtualassistant\AccountManagement\createAccount;

function createAccountAction(ServerRequestInterface $request, PDO $db): ResponseInterface
{
    $username_string = $request->getParsedBody()["username"];
    $password_string = $request->getParsedBody()["password"];
    $confirm_password = $request->getParsedBody()["confirm_password"];
    $email_string = $request->getParsedBody()["email"];
    $password = new Password([$password_string]);
    $email_option = new EmailOption($email_string);
    $site_url = "http://localhost:7999";

    try {
        $username = new UniqueUsername($db, $username_string);
    } catch (InvalidArgumentException $e) {
        return (new Response())
            ->withHeader(
                "Location",
                (string) Uri::withQueryValues(
                    new Uri($site_url),
                        [
                            "error_code" => 400,
                            "error_message" => "Username already exists"
                        ]
                    )
            );
    }
    
    if ($password_string !== $confirm_password) {
        return (new Response(400))
            ->withHeader(
                "Location",
                (string) Uri::withQueryValues(
                    new Uri($site_url),
                        [
                            "error_code" => 400,
                            "error_message" => "Passwords did not match."
                        ]
                    )
            );
    }

    [$accountCreationStatus, $new_account_secret] = createAccount(
        $db,
        $username,
        $password,
        $email_option
    );
    
    if ($accountCreationStatus) {
        return (new Response())
            ->withHeader(
                "Location",
                (string) Uri::withQueryValue(
                    (new Uri($site_url))->withPath("/CreateAccountSuccess.php"),
                    "account_secret",
                    $new_account_secret
                )
            );
    } else {
        return (new Response())
            ->withHeader(
                "Location",
                (string) (new Uri($site_url))->withPath("/CreateAccountFail.html")
            );
    }
}
