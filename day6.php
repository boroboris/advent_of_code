<?php

include 'Logger.php';

// store state
// find max
// redistribute it around
// repeat

function repeatingState($states, $number_of_repeats)
{
    $values_count = array_count_values($states);

//    $first = array_search($number_of_repeats, $values_count) !== false;
    $second = $values_count['1098765431101514131112'] == 2;

    return $second;
}

function findStates($memory_bank, $number_of_repeats)
{
    $states = [];

    while (!repeatingState($states, $number_of_repeats)) {
        $states[] = implode('', $memory_bank);

        $i = array_search(max($memory_bank), $memory_bank);
        $redistribute = $memory_bank[$i];
        $memory_bank[$i] = 0;

        $i++; //begin with next
        while ($redistribute > 0) {
            if ($i > count($memory_bank) - 1) {
                $i = 0;
            }

            $memory_bank[$i]++;
            $redistribute--;
            $i++;
        }
    }

    return $states;
}

//$first_test = [0, 2, 7 , 0];
//$first_solution = array_map('intval',preg_split("/\s+/", "0	5	10	0	11	14	13	4	11	8	8	7	1	4	12	11"));
//
//$states_test = findStates($first_test, 2);
//$states_solution = findStates($first_solution, 2);
//Logger::outputLine('number of occurencies test', count($states_test) - 1);
//Logger::outputLine('number of occurencies solution', count($states_solution) - 1);
//
//var_dump($states_solution[count($states_solution)-1]);
//
//echo "<hr>";
//
//$memory_bank2 = array_map('intval',str_split('2412'));
//$states_test2 = findStates($memory_bank2,2);
//Logger::outputLine('number of occurencies test', count($states_test2) - 1);

echo "<hr>";
$memory_bank2 = array_map('intval',str_split("1098765431101514131112"));
//var_dump($memory_bank2);
try {
    $states_solution2 = findStates($memory_bank2,2);
} catch (Exception $e) {
    var_dump($e->getMessage());
}
//var_dump($states_solution2);
Logger::outputLine('number of occurencies solution', count($states_solution2) - 1);
