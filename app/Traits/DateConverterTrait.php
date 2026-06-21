<?php

namespace App\Traits;

use Carbon\Carbon;

trait DateConverterTrait
{
    public function convertToBurmeseDate(mixed $date, string $format = 'd-m-Y'): string
    {
        if (empty($date)) {
            return '';
        }

        try {
            $parsedDate = Carbon::parse($date)->format($format);
        } catch (\Exception $e) {
            return $date;
        }

        $enNumerals = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $mmNumerals = ['၀', '၁', '၂', '၃', '၄', '၅', '၆', '၇', '၈', '၉'];

        return str_replace($enNumerals, $mmNumerals, $parsedDate);
    }
}