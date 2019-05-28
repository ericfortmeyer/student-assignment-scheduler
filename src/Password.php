<?php

namespace StudentAssignmentScheduler;

use StudentAssignmentScheduler\Exception\IncompatibilityException;
/**
 * Use to avoid leaking password into stack traces, var_dump() calls, etc
 * An encrypted version of the password is stored as a property of the class.
 * The toString method returns the decrypted password.
 */
class Password
{
    private $enc_password = "";
    private $nonce = "";
    private $key = "";

    protected $incompatibility_message = __CLASS__ . " requires PHP version >= 7.2";

    public function __construct(
        string $password,
        string $nonce = "",
        string $key = ""
    ) {
        $this->checkVersion();
        $this->setup($nonce, $key);
        $this->enc_password = $this->encrypt($password);
    }

    /**
     * Return the decrypted password
     */
    public function __toString()
    {
        return $this->decrypt($this->enc_password);
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
     * @param string $password
     * @return string
     */
    private function encrypt(string $password): string
    {
        return sodium_crypto_aead_chacha20poly1305_encrypt(
            $password,
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
}
