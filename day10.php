<?php

include 'Logger.php';

function swap(&$list, $first, $last)
{
    $temp = $list[$first];
    $list[$first] = $list[$last];
    $list[$last] = $temp;

    return $list;
}

function circularListSwap(&$list, $length, $starting_position) {
    $first = $starting_position;
    $last = $starting_position + $length - 1;

    $number_of_swaps = $length/2;

    $list_length = count($list) - 1;
    if($last > $list_length) {
        $last = abs($last - $list_length) - 1;
    }

    while($number_of_swaps > 0) {
        $list = swap($list, $first, $last);

        $first++; $last--;
        $number_of_swaps--;

        if($last < 0) {
            $last = $list_length;
        }

        if($first > $list_length) {
            $first = 0;
        }
    }
}

function runHashRound($lengths, &$current_position, &$skip_size, $list_length, &$list)
{
    foreach ($lengths as $length) {

        if ($length > 1) {
            circularListSwap($list, $length, $current_position);
        }

        $current_position += $length + $skip_size;
        if ($current_position > $list_length - 1) {
            $current_position = abs($current_position - ($list_length - 1)) - 1;
        }

        $skip_size++;
    }
    return $list;
}

$current_position = 0;
$skip_size = 0;

$list = range(0,255);
$list_length = 256;
$lengths = [199,0,255,136,174,254,227,16,51,85,1,2,22,17,7,192];
$list = runHashRound($lengths, $current_position, $skip_size, $list_length, $list);

var_dump($list);
Logger::outputLine('solution', $list[0] * $list[1]);

echo '<hr>';


