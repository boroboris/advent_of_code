<?php

$hash = [65, 27, 9, 1, 4, 3, 40, 50, 91, 7, 6, 0, 2, 5, 68, 22];
array_reverse($hash);
$result = array_pop($hash);

foreach ($hash as $number) {
    $result = $result ^ trim($number);
}

var_dump($result);

var_dump(dechex(64));
var_dump(dechex(7));
var_dump(dechex(255));