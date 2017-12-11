<?php

include 'Logger.php';

// store state
// find max
// redistribute it around
// repeat
//function repeatingState1($states, $needle)
//{
//    $values_count = array_count_values($states);
//
//    var_dump($values_count);
//
////    $first = array_search($number_of_repeats, $values_count) !== false;
////    $second = $values_count['1098765431101514131112'] == 2;
//
//    $repeated = $values_count[$needle] > 1;
//
//    if($repeated == true) {
//        var_dump($values_count);
//    }
//
//    return $repeated;
//}

function repeatingState($states, $number_of_repeats)
{
    $values_count = array_count_values($states);

    $repeating_states = array_search($number_of_repeats, $values_count) !== false;

    if($repeating_states) {
       print_r($values_count);
    }

    return $repeating_states;
//    $second = $values_count['1098765431101514131112'] == 2;

//    $repeated = $values_count[$needle] > 1;
//
//    if($repeated == true) {
//        var_dump($values_count);
//    }
//
//    return $repeated;
}

function findStates1($memory_bank, $repeat_count)
{
    $states = [];

    var_dump($memory_bank);

    while (!repeatingState($states, $repeat_count)) {
        $state = implode("", $memory_bank);
        $states[] = $state;

//        $i = array_search(max($memory_bank), $memory_bank);
//        $redistribute = $memory_bank[$i];
//        $memory_bank[$i] = 0;
//
//        $i++; //begin with next
//        while ($redistribute > 0) {
//            if ($i > count($memory_bank) - 1) {
//                $i = 0;
//            }
//
//            $memory_bank[$i]++;
//            $redistribute--;
//            $i++;
//        }

        $i = array_search(max($memory_bank), $memory_bank);
        $redistribute = $memory_bank[$i];
        $memory_bank[$i] = 0;
        $memory_length = count($memory_bank);

        $redistribute_to_all = $redistribute / $memory_length >= 1 ? round($redistribute / $memory_length) : 0;
        $redistribute_amount = array_fill(0, $memory_length, (int) $redistribute_to_all);
        $redistribute_to_some = $redistribute%$memory_length;

        var_dump($redistribute_amount);
        var_dump($redistribute_to_some);

        $i++; //begin with next
        while ($redistribute_to_some > 0) {
            if ($i >= $memory_length) {
                $i = 0;
            }

            $redistribute_amount[$i]++;
            $redistribute_to_some--;
            $i++;
        }

        foreach ($redistribute_amount as $key => $number) {
            $memory_bank[$key]+= (int) $number;
        }

    }

    return $states;
}

function findStates2($memory_bank, $needle, &$needle_count)
{
    $states = [];
    $memory_length = count($memory_bank);

    var_dump($memory_bank);

    while ($needle_count<2) {
        $state = implode("", $memory_bank);
        $states[] = $state;

        if($state == $needle) {
            $needle_count++;
            Logger::outputLine('counting needles', $needle_count);

            if($needle_count > 1) {
                var_dump($states);
                return $states;
            }
        }

//        $i = array_search(max($memory_bank), $memory_bank);
//        $redistribute = $memory_bank[$i];
//        $memory_bank[$i] = 0;
//
//        var_dump($redistribute);
//
//        $i++; //begin with next
//        while ($redistribute > 0) {
//            if ($i > $memory_length) {
//                $i = 0;
//            }
//
//            $memory_bank[$i]++;
//            $redistribute--;
//            $i++;
//        }

        $i = array_search(max($memory_bank), $memory_bank);
        var_dump($i);
        $redistribute = $memory_bank[$i];
        $memory_bank[$i] = 0;

        $redistribute_to_all = $redistribute / $memory_length >= 1 ? round($redistribute / $memory_length) : 0;
        $redistribute_amount = array_fill(0, $memory_length, (int) $redistribute_to_all);
        $redistribute_to_some = $redistribute%$memory_length;

        var_dump($redistribute_amount);
        var_dump($redistribute_to_some);

        $i++; //begin with next
        while ($redistribute_to_some > 0) {
            if ($i >= $memory_length) {
                $i = 0;
            }

            $redistribute_amount[$i]++;
            $redistribute_to_some--;
            $i++;
        }

        foreach ($redistribute_amount as $key => $number) {
            $memory_bank[$key]+= (int) $number;
        }

    }

    return $states;
}

//$first_test = [0, 2, 7 , 0];
//$first_test = [2, 4, 1, 2];
//$needle_count = 2;
//$states_test = findStates1($first_test, $needle_count);
//Logger::outputLine('number of occurencies test', count($states_test) - 1);
//echo "<hr>";
//
//$first_solution = array_map('intval',preg_split("/\s+/", "0	5	10	0	11	14	13	4	11	8	8	7	1	4	12	11"));
//$states_solution = findStates1($first_solution, 2);
//Logger::outputLine('number of occurencies solution', count($states_solution) - 1);
//
//var_dump($states_solution[count($states_solution)-1]);
//
//

/*$memory_bank2 = array_map('intval',str_split('2412'));
$needle_count = 0;
$states_test2 = findStates2($memory_bank2,"2412", $needle_count);
Logger::outputLine('number of occurencies test', count($states_test2) - 1);
var_dump($needle_count);*/

$needle_count = 0;
$memory_bank2 = array_map('intval',str_split("1098765431101514131112"));
$states_solution2 = findStates2($memory_bank2,"1098765431101514131112", $needle_count);
var_dump($states_solution2);
Logger::outputLine('number of occurencies solution', count($states_solution2) - 1);