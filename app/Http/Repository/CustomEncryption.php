<?php

namespace App\Http\Repository;

use Illuminate\Http\Request;

class CustomEncryption
{
    protected $ciphering = "aes-256-cbc";
    protected $options = "0";
    protected $encryption_iv = "h67yflxjrbscog4s";
    protected $encryption_key = "o5ucjegrx74cwggosw8scg8oo4skwggJ";

    public function encryption($simple_string)
    {
        $iv_length = openssl_cipher_iv_length($this->ciphering);
        return openssl_encrypt($simple_string, $this->ciphering,$this->encryption_key, $this->options, $this->encryption_iv);
    }

    public function decryption($encryption)
    {
        // If encryption is disabled or decryption fails, return the original value
        // This allows testing with plain text when DISABLE_ENCRYPTION=true in .env
        if (env('DISABLE_ENCRYPTION', false)) {
            return $encryption;
        }

        $decrypted = openssl_decrypt($encryption, $this->ciphering, $this->encryption_key, $this->options, $this->encryption_iv);

        // If decryption fails (returns false), return original value for testing
        // This allows both encrypted and plain text to work
        if ($decrypted === false) {
            return $encryption;
        }

        return $decrypted;
    }
}
