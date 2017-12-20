<?php

include 'Logger.php';

$input = "0 <-> 2
1 <-> 1
2 <-> 0, 3, 4
3 <-> 2, 4
4 <-> 2, 3, 6
5 <-> 6
6 <-> 4, 5";

$input = file_get_contents("inputs/day12.txt");
preg_match_all("/(\d+)\s<->\s(.+)/", $input, $matches);

$programs_list = [];
foreach ($matches[1] as $key => $match) {
    $match2 = preg_replace('/\s+/', '', $matches[2][$key]);
    $programs_list[$match] = explode(',', $match2);
}

$groups = [];
$stack = [];
$already_matched = [];


while (!empty($programs_list)) {
    reset($programs_list);
    $entry_point = key($programs_list);

    $stack = array_merge($stack, $programs_list[$entry_point]);
    $already_matched[$entry_point] = 1;
    unset($programs_list[$entry_point]);

    while (!empty($stack)) {
        $element = array_pop($stack);

        if(!array_key_exists($element, $already_matched)) {
            $stack = array_merge($stack, $programs_list[$element]);
            $already_matched[$element] = 1;
            unset($programs_list[$element]);
        }
    }

    $groups[] = $already_matched;
    $already_matched = [];
}


Logger::outputLine('solution', count($groups));