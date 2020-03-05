<?php

namespace app\helper\_clazz;

class DateHelper
{

    public static function formatDateTo_Ymd($date)
    {
        return date("Y/m/d", strtotime($date));
    }

    public static function formatDateTo_dmY($date)
    {
        return date("d-m-Y", strtotime($date));
    }
}
