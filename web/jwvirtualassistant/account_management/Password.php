<?php declare(strict_types=1);
/**
 * This file is a part of JW Virtual Assistant Login Account Management.
 * 
 * Copywright (c) Eric Fortmeyer.
 * See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace jwvirtualassistant\AccountManagement;

use Zend\Crypt\Password\Bcrypt;

/**
 * A representation of a password.
 *
 * Returns a password hash when cast to string.
 * Use to avoid leaking password into stack traces, var_dump() calls, etc
 * An encrypted version of the password is stored as a property of the class.
 * The toString method returns the decrypted password.
 * Use an array in the constructor argument with the original password
 * being it's first argument in order to hide the password in stack traces.
 */
class Password extends ValueType
{
    private $enc_password = "";
    private $nonce = "";
    private $key = "";

    protected $incompatibility_message = __CLASS__ . " requires PHP version >= 7.2";

    /**
     * Create the instance.
     *
     * @param array $password Use an array to hide passwords in stack traces
     * @param string $nonce
     * @param string $key
     */
    public function __construct(
        array $password,
        string $nonce = "",
        string $key = ""
    ) {
        $this->checkVersion();
        $this->setup($nonce, $key);
        $this->enc_password = $this->encrypt($password);
    }

    /**
     * Return the password hash.
     */
    public function __toString()
    {
        $decryptedPassword = $this->decrypt($this->enc_password);
        $password_hash = (new Bcrypt())->create($decryptedPassword);
        return $password_hash;
    }

    /**
     * Throw an exception if the version of PHP is outdated
     * @throws IncompatibilityException
     */
    private function checkVersion()
    {
        $this->isOutdated(PHP_VERSION_ID) && $this->throwException();
    }
    /**
     * Is the version of PHP compatible with this class?
     * @param int $version_id
     * @return bool
     */
    private function isOutdated(int $version_id): bool
    {
        return $version_id < 70200;
    }

    /**
     * @throws IncompatibilityException
     */
    private function throwException(): void
    {
        throw new IncompatibilityException($this->incompatibility_message);
    }

    /**
     * Set nonce and key for encrypting and decrypting the password
     * @param string $nonce
     * @param string $key
     * @return void
     */
    private function setup(string $nonce, string $key): void
    {
        $this->nonce = $nonce
            ? $nonce
            : random_bytes(\SODIUM_CRYPTO_AEAD_CHACHA20POLY1305_NPUBBYTES);

        $this->key = $key
            ? $key
            : sodium_crypto_aead_chacha20poly1305_keygen();
    }

    /**
     * Encrypt the password
     * @throws \SodiumException
     * @param array $password use to hide in stack traces
     * @return string
     */
    private function encrypt(array $password): string
    {
        return sodium_crypto_aead_chacha20poly1305_encrypt(
            $password[0],
            $this->nonce,
            $this->nonce,
            $this->key
        );
    }

    /**
     * Decrypt the password
     * @param string $encrypted
     * @return string
     */
    private function decrypt(string $encrypted): string
    {
        return sodium_crypto_aead_chacha20poly1305_decrypt(
            $encrypted,
            $this->nonce,
            $this->nonce,
            $this->key
        );
    }

    protected function getValidator(): \Closure
    {
        return function (string $value): array {
            $maxlen = 2000;
            return [
                strlen($value) > $maxlen,
                sprintf("%s should be no more than %s characters in length", __CLASS__, $maxlen)
            ];
        };
    }
}
