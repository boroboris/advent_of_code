<?php

$combinations = [[],[],[],[],[],[],[]];
foreach ([3, 2, 0, 0, 4, 0, 4] as $key => $item) {
    if($item == 0) continue;

    for($i = 0; $i < 96; $i+=$item) {
        $combinations[$key][] = $i;
    }
}

var_dump($combinations);