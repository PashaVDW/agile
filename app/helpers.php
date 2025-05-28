<?php

namespace App;

class helpers
{
    public static function getProfileIcon(): string
    {
        $today = now()->format('d-m');
        $specialDays = config('holidays');

        if (array_key_exists($today, $specialDays)) {
            return asset($specialDays[$today]);
        }

        return asset('assets/images/icons/MaterialSymbolsPerson.svg');
    }
}
