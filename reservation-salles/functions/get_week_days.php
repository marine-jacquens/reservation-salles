<?php

/**
 * @return mixed
 */
function getWeekDays()
{
//    setlocale(LC_TIME, 'fr_FR.UTF8');
    $nowDay = time();
//    $weekDays[] = strftime('%A', $nowDay);
    $weekDays[] = strftime('%A', $nowDay);

    for ($i = 0; $i < 6; ++$i) {
        $nowDay += (60 * 60 * 24);
        $weekDays[] = strftime('%A', $nowDay);
    }
    return $weekDays;
}
