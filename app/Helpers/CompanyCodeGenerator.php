<?php

namespace App\Helpers;

use App\Models\Company;

class CompanyCodeGenerator
{
    public static function generate(
        string $companyName
    ): string {

        $words = preg_split('/\s+/', trim($companyName));

        if (count($words) >= 2) {

            $prefix =
                strtoupper(substr($words[0], 0, 2)) .
                strtoupper(substr($words[1], 0, 2));

        } else {

            $prefix = strtoupper(
                substr(
                    preg_replace(
                        '/[^A-Za-z0-9]/',
                        '',
                        $companyName
                    ),
                    0,
                    4
                )
            );
        }

        $counter = 1;

        do {

            $companyCode = $prefix .
                str_pad(
                    $counter,
                    3,
                    '0',
                    STR_PAD_LEFT
                );

            $exists = Company::where(
                'company_code',
                $companyCode
            )->exists();

            $counter++;

        } while ($exists);

        return $companyCode;
    }
}