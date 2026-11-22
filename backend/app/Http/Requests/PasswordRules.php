<?php

namespace App\Http\Requests;

class PasswordRules
{
    public static function maximumBytes(): \Closure
    {
        return static function (string $attribute, mixed $value, \Closure $fail): void {
            if (is_string($value) && strlen($value) > 72) {
                $fail('La contraseña admite hasta 72 bytes.');
            }
        };
    }
}
