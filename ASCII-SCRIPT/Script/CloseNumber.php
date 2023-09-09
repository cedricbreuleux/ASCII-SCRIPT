<?php
/*
$value1 = 35;

$tab = array(
    0 => 30,
    1 => 39,
    2 => 45,
    3 => 65
);
*/


function get_the_closest_number($value1, $tab) {

    $differnce = 1000;
    $valeur_finnal = 1000;
    
    foreach ($tab as $key => $value) {
        if($value > $value1) {
            if($differnce !== 1000) {
                if($differnce > $value - $value1) {
                    $differnce = $value - $value1;
                    $valeur_finnal = $key;
                }
            }
            else {
                $differnce = $value - $value1;
                $valeur_finnal = $key;

            }
        }
        else if($value < $value1) {
            if($differnce !== 1000) {
                if($differnce > $value1 - $value) {
                    $differnce = $value1 - $value;
                    $valeur_finnal = $key;

                }
            }
            else {
                $differnce = $value1;
                $valeur_finnal = $key;

            }
        }
        else {
            $differnce = 0;
            $valeur_finnal = $key;

        }
    }
    return $valeur_finnal;
}
//echo get_the_closest_number($value1, $tab);