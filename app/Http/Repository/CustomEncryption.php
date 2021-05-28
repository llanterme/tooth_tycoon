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
        return openssl_decrypt ($encryption, $this->ciphering,$this->encryption_key, $this->options, $this->encryption_iv);
    }
}
