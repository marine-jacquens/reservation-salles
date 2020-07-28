<?php

/**
 * @param $heure
 * @return string
 */
function heure_recup($heure): string
{
    for ($i = 0; $i < 2; $i++) {
        $heure_table[] = "$heure[$i]";
    }
    $heure_only = $heure_table[0] . $heure_table[1];
    return $heure_only;
}
