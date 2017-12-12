<?php

$garbage = "<.*>";
$ignore = "!.";

$test_cases = [
'{}',
'{{{}}}',
'{{},{}}',
'{{{},{},{{}}}}',
'{<a>,<a>,<a>,<a>}',
'{{<ab>},{<ab>},{<ab>},{<ab>}}',
'{{<!!>},{<!!>},{<!!>},{<!!>}}',
'{{<a!>},{<a!>},{<a!>},{<ab>}}',
];

//$matches = [];
//$result = preg_match("/{({}){0}}/", $test_cases[0], $matches);
//
//var_dump($matches, $result);

$match = true;
$points = 0;
$counter = 0;
$matches = ['random'];
$solutions = [];
foreach ($test_cases as $test) {
    $test = preg_replace("/$ignore/", "", $test); //remove ignored
    $test = preg_replace("/$garbage/", "", $test); //remove garbage

    var_dump($test);

    while(!empty($matches)) {
        $matches = [];
        $group = "/{.*?}/";
        $match = preg_match($group, $test, $matches);
        var_dump($group, $counter, $matches);

        if(!empty($matches)) {
            $points += $counter * (count($matches));
            $test = substr($test,1,-1);
        }
        $counter++;
    }

    $matches = ['random'];
    $counter = 0;
    $solutions[] = $points;
    $points = 0;
}

var_dump($solutions);
