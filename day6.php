<?php

include 'Logger.php';

//$input = [0,2,7,0];
$input =  array_map('intval',preg_split("/\s+/", "0	5	10	0	11	14	13	4	11	8	8	7	1	4	12	11"));

$length = count($input);
$states_count = [];
$the_state = [];

while(true) {
    $max = max($input);
    $max_location = array_search($max, $input);
    $input[$max_location] = 0;

    $redistribute_to_some = $max%$length;
    $redistribute_to_all = floor($max/$length);

    $redistribution = array_fill(0,$length,$redistribute_to_all);

    $i = $max_location >= $length - 1 ? 0 : ($max_location + 1);
    for(; $i < $length; $i++) {
        if($redistribution[$i] <= 0 && $redistribute_to_some <=0) {
            break;
        }

        // redistribute to all + redistribute to some
        $input[$i] += $redistribution[$i];
        $redistribution[$i] = 0;
        if($redistribute_to_some > 0) {
            $input[$i] += 1;
            $redistribute_to_some--;
        }

        if($i+1 >= $length) {
            $i = -1;
        }
    }

    $state = implode('', $input);

    if(!key_exists($state, $states_count)) {
        $states_count[$state] = 1;
    } else {
        $states_count[$state]++;
        $the_state = $input;
        break;
    }
}

Logger::outputLine("solution", count($states_count) + 1);

$input = $the_state;
$state = implode('', $input);
$states_count = [$state => 1];
while(true) {
    $max = max($input);
    $max_location = array_search($max, $input);
    $input[$max_location] = 0;

    $redistribute_to_some = $max%$length;
    $redistribute_to_all = floor($max/$length);

    $redistribution = array_fill(0,$length,$redistribute_to_all);

    $i = $max_location >= $length - 1 ? 0 : ($max_location + 1);
    for(; $i < $length; $i++) {
        if($redistribution[$i] <= 0 && $redistribute_to_some <=0) {
            break;
        }

        // redistribute to all + redistribute to some
        $input[$i] += $redistribution[$i];
        $redistribution[$i] = 0;
        if($redistribute_to_some > 0) {
            $input[$i] += 1;
            $redistribute_to_some--;
        }

        if($i+1 >= $length) {
            $i = -1;
        }
    }

    $state = implode('', $input);

    if(!key_exists($state, $states_count)) {
        $states_count[$state] = 1;
    } else {
        $states_count[$state]++;
        break;
    }
}

Logger::outputLine("solution", count($states_count));