<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function ukDate($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }
    
    public static function ukDateTime($date)
    {
        return Carbon::parse($date)->format('d/m/Y H:i');
    }
}