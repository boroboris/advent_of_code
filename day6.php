<?php

include 'Logger.php';

// store state
// find max
// redistribute it around
// repeat

$states = [];
$memory_bank = [0, 2, 7 , 0];

while(array_search(implode('', $memory_bank), $states) !== false) {
    $states[] = implode('', $memory_bank);

    $i = array_search(max($memory_bank), $memory_bank);
    $redistribute = $memory_bank[$i];
    $memory_bank[$i] = 0;

    while($redistribute > 0) {
        $memory_bank[++$i]++;

        $redistribute--;
    }
}

Logger::outputLine('number of occurencies', count($memory_bank));