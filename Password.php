<?php

namespace TalkSlipSender;

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

    public function __construct(
        string $password,
        string $nonce = "",
        string $key = ""
    ) {
        $this->setup($nonce, $key);
        $this->enc_password = $this->encrypt($password);
    }
    
    public function __toString()
    {
        return $this->decrypt($this->enc_password);
    }

    private function setup(string $nonce, string $key): void
    {
        $this->nonce = $nonce
            ? $nonce
            : random_bytes(\SODIUM_CRYPTO_AEAD_CHACHA20POLY1305_NPUBBYTES);

        $this->key = $key
            ? $key
            : sodium_crypto_aead_chacha20poly1305_keygen();
    }

    private function encrypt(string $password): string
    {
        return sodium_crypto_aead_chacha20poly1305_encrypt(
            $password,
            $this->nonce,
            $this->nonce,
            $this->key
        );
    }

    private function decrypt(string $encrypted): string
    {
        return \sodium_crypto_aead_chacha20poly1305_decrypt(
            $encrypted,
            $this->nonce,
            $this->nonce,
            $this->key
        );
    }
}
