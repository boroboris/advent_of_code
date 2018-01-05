<?php

include 'Logger.php';

function swap (&$list, $position1, $position2) {
    $temp = $list[$position1];
    $list[$position1] = $list[$position2];
    $list[$position2] = $temp;
}

function reverse (&$list, $list_length, $length, $current_position) {
    $start = $current_position;
    $end = $current_position + $length - 1;
    $number_of_swaps = floor($length/2);

    if($end >= $list_length) {
        $end = $end % $list_length;
    }

    while($number_of_swaps > 0) {
        swap($list, $start, $end);

        $start++;
        $end--;

        if($start >= $list_length) {
            $start = 0;
        }

        if($end < 0) {
            $end = $list_length - 1;
        }

        $number_of_swaps--;
    }
}

function hashToString ($list) {
    $hash = "";

    for($i = 0; $i < 255; $i+=16) {
        $list_slice = array_slice($list, $i, 16);
        $result = array_pop($list_slice);

        foreach ($list_slice as $number) {
            $result = $result ^ $number;
        }

        $hex_result = dechex($result);
        $hash .= strlen($hex_result) < 2 ? '0'.$hex_result : $hex_result;
    }

    return $hash;
}

//$list = range(0,4);
//$lengths = [3,4,1,5];
//$tests = [
//  [2,1,0,3,4],
//  [4,3,0,1,2],
//  [4,3,0,1,2],
//  [3,4,2,1,0]
//];
//$rounds = 1;


//$lengths = [199,0,255,136,174,254,227,16,51,85,1,2,22,17,7,192];

//$length_strings = [
//    '',
//    "AoC 2017",
//    "1,2,3",
//    "1,2,4"
//];

$length_tests = [
    "a2582a3a0e66e6e86e3812dcb672a272",
    "33efeb34ea91902bb2f59c9920caa6cd",
    "3efbe78a8d82f29979031a4aa0b16a9d",
    "63960835bcdc130f0b66d7ff4f6a5a8e"
];

$length_strings = [
    "199,0,255,136,174,254,227,16,51,85,1,2,22,17,7,192"
];

$lengths_ascii = [];

foreach ($length_strings as $tests) {
    $chars = str_split($tests);

    $chars = array_map(function($char) {
        return ord($char);
    }, $chars);

    $lengths_ascii[] = array_merge($chars, [17,31,73,47,23]);
}

foreach ($lengths_ascii as $key2 => $lengths) {
    $rounds = 64;
    $list = range(0,255);
    $list_length = count($list);
    $current_position = 0;
    $skip_size = 0;

    while($rounds > 0) {
        foreach ($lengths as $key => $length) {
            reverse($list, $list_length, $length, $current_position);

            $current_position += $length + $skip_size;
            $skip_size++;

            if($current_position >= $list_length) {
                $current_position = $current_position % $list_length;
            }

// tests for 1
//    if($tests[$key] === $list) {
//        Logger::success(implode(',', $list));
//    } else {
//        Logger::error('should be - ' . implode(',',$tests[$key]),implode(',', $list));
//    }
        }

        $rounds--;
    }

    $hash = hashToString($list);
    // tests for 2
    if($length_tests[$key2] === $hash) {
        Logger::success($hash);
    } else {
        Logger::error('should be - ' . $length_tests[$key2], $hash);
        Logger::outputLine('length', strlen($hash));
    }
}

//Logger::outputLine('result 1', $list[0] * $list[1]);
