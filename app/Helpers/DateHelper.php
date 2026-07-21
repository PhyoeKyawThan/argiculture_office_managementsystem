<?php

namespace App\Helpers;

class DateHelper
{
    public static function getMyanmarFormattedDate(string $date): array
    {
        $timestamp = strtotime($date);

        $mm_months = [
            1 => 'ဇန်နဝါရီ',
            2 => 'ဖေဖော်ဝါရီ',
            3 => 'မတ်',
            4 => 'ဧပြီ',
            5 => 'မေ',
            6 => 'ဇွန်',
            7 => 'ဇူလိုင်',
            8 => 'ဩဂုတ်',
            9 => 'စက်တင်ဘာ',
            10 => 'အောက်တိုဘာ',
            11 => 'နိုဝင်ဘာ',
            12 => 'ဒီဇင်ဘာ'
        ];

        $year = date('Y', $timestamp);
        $month_num = (int) date('n', $timestamp);
        $day = date('d', $timestamp);

        return [
            'year' => self::convertToMyanmarNumber($year),
            'month' => $month_num,
            'month_text' => $mm_months[$month_num],
            'day' => self::convertToMyanmarNumber($day),
            'year_range' => self::convertToMyanmarNumber($year) . '-' .self::convertToMyanmarNumber($year + 1)
        ];
    }
    public static function convertToMyanmarNumber(string $number, bool $is_formatted=False): string
    {
        $en_digits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $mm_digits = ['၀', '၁', '၂', '၃', '၄', '၅', '၆', '၇', '၈', '၉'];
        if ($is_formatted) {
            return str_replace($en_digits, $mm_digits, number_format($number));
        }
        return str_replace($en_digits, $mm_digits, $number);
    }
}