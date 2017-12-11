<?php

include 'Logger.php';

function swap(&$list, $first, $last)
{
    $temp = $list[$first];
    $list[$first] = $list[$last];
    $list[$last] = $temp;

    return $list;
}

function circularListSwap(&$list, $length, $starting_position, $list_length = 255) {
    $first = $starting_position;
    $last = $starting_position + $length - 1;

    $number_of_swaps = $length/2;

    if($last > $list_length) {
        $last = abs($last - $list_length) - 1;
    }

    if($last < 0) {
        $last = $list_length;
    } elseif ($last > $list_length) {
        $last = $list_length;
    }

    if($first > $list_length) {
        $first = 0;
    } elseif ($first > $list_length) {
        $first = 0;
    }

    while($number_of_swaps > 0) {
        if($first > $list_length || $first < 0) {
            Logger::outputLine('first problem', $first);
        }
        if($last > $list_length || $last < 0) {
            Logger::outputLine('last problem', $last);
        }
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
            circularListSwap($list, $length, $current_position, $list_length);
        }

        $current_position += $length + $skip_size;
        if ($current_position > $list_length) {
            $current_position = abs($current_position - $list_length) - 1;
        }

        $skip_size++;
    }

    return $list;
}

function warnIfListTooBig($list, $list_length, $skip_size)
{
    if (count($list) > $list_length + 1) {
        print "list too long";
        var_dump($skip_size);
        var_dump($list);
    }
}

//$current_position = 0;
//$skip_size = 0;
$list = range(0,255);
//$list_length = 255;

// ----- part 1 --------
//$lengths = [199,0,255,136,174,254,227,16,51,85,1,2,22,17,7,192];
//$list = runHashRound($lengths, $current_position, $skip_size, $list_length, $list);
//
//var_dump($list);
//Logger::outputLine('solution', $list[0] * $list[1]);

echo '<hr>';

//$original_input = "199,0,255,136,174,254,227,16,51,85,1,2,22,17,7,192";
$current_position = 0;
$skip_size = 0;
$original_input = "1,2,3";
$original_chars = str_split($original_input);

$list = array_map('ord', $original_chars);
$list = array_merge($list, [17, 31, 73, 47, 23]);
var_dump($list);
$lengths = [17, 31, 73, 47, 23];
$list_length = count($list) - 1;
$rounds = range(0,1);


foreach ($rounds as $round) {
    runHashRound($lengths, $current_position, $skip_size, $list_length, $list);
    warnIfListTooBig($list, $list_length, $skip_size);

    var_dump($list);
    var_dump($current_position);
    var_dump($skip_size);
}

var_dump($list);
Logger::outputLine('solution', $list[0] * $list[1]);

//$list = [65, 27, 9, 1, 4, 3, 40, 50, 91, 7, 6, 0, 2, 5, 68, 22];
$results = [];
for($i=0; $i < 15; $i++) {
    $list_slice = array_slice($list,$i * 16, ($i + 1) * 16);
    $result = 0;
    foreach ($list_slice as $slice) {
        $result = $result ^ $slice;
    }

    $results[] = $result;
    $list = array_splice($list, 16);
//    var_dump($list);
}

$solution2 = '';
foreach ($results as $result) {
    $result = chr($result);

//    if(trim($result) != "") {
        $solution2 .= bin2hex($result);
//    }
}

var_dump($solution2);

// d7d205f722be177500000000000000 - nop

//'33498fae27da77'
//'33efeb34ea91902bb2f59c9920caa6cd'
//33498f0bae0d27da77000000000000