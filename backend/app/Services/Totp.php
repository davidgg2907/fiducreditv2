<?php

namespace App\Services;

class Totp
{
    private const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';

    public function generateSecret(): string
    {
        $bits = '';
        foreach (str_split(random_bytes(20)) as $byte) {
            $bits .= str_pad(decbin(ord($byte)), 8, '0', STR_PAD_LEFT);
        }

        return implode('', array_map(
            fn (string $chunk) => self::ALPHABET[bindec($chunk)],
            str_split($bits, 5),
        ));
    }

    public function matchingStep(string $secret, string $code, ?int $lastStep): ?int
    {
        $bits = '';
        foreach (str_split($secret) as $character) {
            $position = strpos(self::ALPHABET, $character);
            if ($position === false) {
                return null;
            }
            $bits .= str_pad(decbin($position), 5, '0', STR_PAD_LEFT);
        }
        $key = implode('', array_map(fn (string $chunk) => chr(bindec($chunk)), str_split($bits, 8)));
        $current = intdiv(now()->timestamp, 30);

        foreach ([$current, $current - 1, $current + 1] as $step) {
            if ($lastStep !== null && $step <= $lastStep) {
                continue;
            }
            $digest = hash_hmac('sha1', pack('J', $step), $key, true);
            $offset = ord($digest[19]) & 15;
            $value = unpack('N', substr($digest, $offset, 4))[1] & 0x7fffffff;
            if (hash_equals(sprintf('%06d', $value % 1000000), $code)) {
                return $step;
            }
        }

        return null;
    }
}
