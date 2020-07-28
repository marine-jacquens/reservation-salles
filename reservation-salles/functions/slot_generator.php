<?php

/**
 * @param int $beginHour
 * @param int $endHour
 * @return array
 */
function slot_genrator(int $beginHour, int $endHour): array
{
    $slotFirstHour = [];
//    $slotSecondHour = [];
    $slot = [];
    $i = 0;

    while ($beginHour < $endHour) {
        $slotFirstHour[] = $beginHour . "h00";
//        $slotSecondHour[] = $beginHour + 1 . "h00";
//        $slot[] = $slotFirstHour[$i] . " - " . $slotSecondHour[$i];
        $slot[] = $slotFirstHour[$i];
        ++$beginHour;
        ++$i;
    }
    return $slot;
}
