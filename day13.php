<?php

include "Logger.php";

$test_input = "0: 3
1: 2
4: 4
6: 4";

$real_input = "0: 3
1: 2
2: 4
4: 6
6: 4
8: 6
10: 5
12: 6
14: 8
16: 8
18: 8
20: 6
22: 12
24: 8
26: 8
28: 10
30: 9
32: 12
34: 8
36: 12
38: 12
40: 12
42: 14
44: 14
46: 12
48: 12
50: 12
52: 12
54: 14
56: 12
58: 14
60: 14
62: 14
64: 14
70: 10
72: 14
74: 14
76: 14
78: 14
82: 14
86: 17
88: 18
96: 26";

function initFirewall($test_input)
{
    $firewall = [];
    $matches = [];
//    $possibilities = 1;
    $lengths_for_lcm = [];

    preg_match_all('/(\d+):\s(\d+)/', $test_input, $matches);
    for ($i = 0; $i < count($matches[1]); $i++) {
        $i1 = (int)$matches[1][$i];
        $i2 = (int)$matches[2][$i];
//        $possibilities *= $i2;
//        var_dump($possibilities);
//        $lengths_for_lcm[] = $i2;
        $firewall[$i1] = array_fill(0, $i2, 0);
    }

    $keys = array_keys($firewall);
    $maxkey = end($keys);

    for ($i = 0; $i < $maxkey; $i++) {
        if (!array_key_exists($i, $firewall)) {
            $firewall[$i] = [];
        }
    }

    ksort($firewall);

//    Logger::outputLine('number of possibilities', $possibilities);

    return [$firewall, $lengths_for_lcm];
}

function moveScanner(&$depth) {

    $scanner_direction = max($depth);
    $length = count($depth);
    $scanner_location = array_search($scanner_direction, $depth);

    // go down
    if($scanner_direction == 1) {
        $scanner_location++;

        if($scanner_location < $length) {
            $depth[$scanner_location] = $scanner_direction;
            $depth[$scanner_location - 1] = 0;
        } else {
            $scanner_location = $length - 1;
            $depth[$scanner_location] = 0;
            $depth[$scanner_location - 1] = 2;
        }
    }

    // go up
    if($scanner_direction == 2) {
        $scanner_location--;

        if($scanner_location >= 0) {
            $depth[$scanner_location] = $scanner_direction;
            $depth[$scanner_location + 1] = 0;
        } else {
            $scanner_location = 0;
            $depth[$scanner_location] = 0;
            $depth[$scanner_location + 1] = 1;
        }
    }
}

function gcd($a,$b) {
    return ($a % $b) ? gcd($b,$a % $b) : $b;
}

function lcm($a, $b) {
    return abs($a * $b)/gcd($a, $b);
}

/* ---------------------------------------------- */

list($firewall, $lengths_for_lcm) = initFirewall($real_input);
//var_dump($firewall);
Logger::hr();

$down = 1;
$up = 2;

// init scanner
foreach ($firewall as &$depth) {
    if(!empty($depth)) {
        $depth[0] = 1;
    }
}

$my_location = 0;
$severity = 1;
$delay = 0;

function moveScanners(&$firewall)
{
    foreach ($firewall as &$depth) {
        if (!empty($depth)) {
            moveScanner($depth);
        }
    }
}

while ($severity > 0) {
    $severity = 0;
    $my_location = 0;

    while($my_location < count($firewall)) {

        if($firewall[$my_location][0] > 0) {
            $multiplier = $my_location != 0 ? $my_location : 1;
            $severity += $multiplier * count($firewall[$my_location]);

//            Logger::outputLine('failed at', $my_location);
//            Logger::outputLine('delay', $delay);
        }

        moveScanners($firewall);
        $my_location++;
    }

    if($delay == 0) {
        Logger::outputLine('soulution 1', $severity);
        Logger::hr();
    }

    $delay++;
}
//
//$lengths_for_lcm = [];
//foreach ($firewall as $depth) {
//    $lengths_for_lcm[] = count($depth);
//}
//
//var_dump($lengths_for_lcm);
//$delay = $lengths_for_lcm[0];
//array_shift($delay);
//foreach ($lengths_for_lcm as $key => $number) {
//    $delay = lcm($delay, $number + $key);
//    var_dump($delay, $key);
//}
Logger::outputLine('solution 2', $delay - 1);

// 1/6 * 0 + 1/2 * 1 + 1*2 + 1*3 + 1/8 * 4 + 1 * 5 + 1/8 * 6

// ne prolazim 0 -> 0,5,9
// ne prolazim 1 -> 1,4,6,8,10 (0,3,5,7,9)
// ne prolazim 2 -> null
// ne prolazim 3 -> null
// ne prolazim 4 -> 4,11,17 (0,7,13)
// ne prolazim 5 -> null
// ne prolazim 6 -> 6,13,19 (0,7,13)
