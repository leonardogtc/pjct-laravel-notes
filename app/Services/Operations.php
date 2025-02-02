<?php

namespace App\Services;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class Operations
{
    public static function decryptID($value)
    {
        // Verifica se Value está encriptado
        try {
            $value = Crypt::decrypt($value);
        } catch (DecryptException $e) {
            return null;
        }

        return $value;
    }
}
