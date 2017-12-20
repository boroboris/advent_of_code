<?php

include 'Logger.php';

$streams = [
    '{}',
    '{{{}}}',
    '{{},{}}',
    '{{{},{},{{}}}}',
    '{<a>,<a>,<a>,<a>}',
    '{{<ab>},{<ab>},{<ab>},{<ab>}}',
    '{{<!!>},{<!!>},{<!!>},{<!!>}}',
    '{{<a!>},{<a!>},{<a!>},{<ab>}}',
];

$test_results = [1,6,5,16,1,9,9,3];
$garbage = "<.*?>";
$ignore = "!.";

$streams = [file_get_contents('/var/www/html/random/php_playground/advent_of_code/inputs/day9.txt')];

function scorePoints($points_counter)
{
    $score = 0;
    foreach ($points_counter as $key2 => $items_number) {
        $score += ($key2 + 1) * $items_number;
    }
    return $score;
}

function countBrackets($string_array)
{
    $stack = [];
    $nesting_level = 0;
    $points_counter = [];

    foreach ($string_array as $char) {
        if ($char == '{') {
            array_push($stack, $char);

            if (!array_key_exists($nesting_level, $points_counter)) {
                $points_counter[$nesting_level] = 0;
                $nesting_level++;
            } else {
                $nesting_level++;
            }
        }

        if ($char == '}') {
            array_pop($stack);
            $nesting_level--;
            $points_counter[$nesting_level]++;
        }
    }
    return $points_counter;
}

foreach ($streams as $key => $stream) {
    $stream = preg_replace("/$ignore/", "", $stream); //remove ignored
    $stream = preg_replace("/$garbage/", "", $stream); //remove garbage
    $string_array = str_split($stream);

    $points_counter = countBrackets($string_array);
    $score = scorePoints($points_counter);

    if($score == $test_results[$key]) {
        Logger::outputLine('result1', $score);
    } else {
        Logger::error("result should be $test_results[$key] instead of", $score);
    }
    Logger::hr();
}

/*---------------------------------------------------------*/

$streams2 = [
    '<>',
    '<random characters>',
    '<<<<>',
    '<{!>}>',
    '<!!>',
    '<!!!>>',
    '<{o"i!a,<{i<a>',
];

$test_results2 = [0,17,3,2,0,0,10];

$garbage = "<(.*?)>";
$ignore = "!.";

$streams2 = [file_get_contents('/var/www/html/random/php_playground/advent_of_code/inputs/day9.txt')];

foreach ($streams2 as $key => $stream) {
    $matches = [];
    $stream = preg_replace("/$ignore/", "", $stream); //remove ignored
    preg_match_all("/$garbage/", $stream, $matches); //remove garbage

    $score = strlen(implode($matches[1]));

    if($score == $test_results2[$key]) {
        Logger::outputLine('result2', $score);
    } else {
        Logger::error("result should be $test_results2[$key] instead of", $score);
    }
    Logger::hr();
}
