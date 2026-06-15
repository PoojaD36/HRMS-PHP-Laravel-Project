<?php

namespace App\Helpers;

class CodeGenerator
{
    public static function generate(
        string $prefix,
        int $lastId
    ): string {

        return $prefix .
            str_pad(
                $lastId + 1,
                5,
                '0',
                STR_PAD_LEFT
            );
    }
}