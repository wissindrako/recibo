<?php

namespace App\Helpers;

use Hashids\Hashids;

class Hashid
{
    private static ?Hashids $instance = null;

    private static function hashids(): Hashids
    {
        if (self::$instance === null) {
            self::$instance = new Hashids(config('app.key', 'recibo-salt'), 8);
        }
        return self::$instance;
    }

    public static function encode(int $id): string
    {
        return self::hashids()->encode($id);
    }

    public static function decode(string $hash): int
    {
        $decoded = self::hashids()->decode($hash);
        return $decoded[0] ?? 0;
    }
}
