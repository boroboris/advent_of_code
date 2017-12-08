<?php

/*
1. kako se vektori kreću

    1 - ( 0, 0)  right  $x+1
    2 - ( 1, 0)  up     $y+1
    3 - ( 1, 1)  left   $x-1
    4 - ( 0, 1)  left   $x-1
    5 - (-1, 1)  down   $y-1
    6 - (-1, 0)  down   $y-1
    7 - (-1,-1)  right  $x+1
    8 - ( 0,-1)  right  $x+1
    9 - ( 1,-1)  right  $x+1
   10 - ( 2,-1)  up     $y+1
   11 - ( 2, 0)  up     $y+1
   12 - ( 2, 1)  up     $y+1
   13 - ( 2, 2)  left   $x-1
   14 - ( 1, 2)  left   $x-1
   15 - ( 0, 2)  left   $x-1
   16 - (-1, 2)  left   $x-1
   17 - (-2, 2)  down   $y-1
   18 - (-2, 1)  down
   19 - (-2, 0)  down
   20 - (-2,-1)  down
   21 - (-2,-2)  right
*/

function increaseCoordinatesAccodringToDirection($direction, &$current_coordinates)
{
    switch ($direction) {
        case 'right':
            $current_coordinates[0]++;
            break;
        case 'up':
            $current_coordinates[1]++;
            break;
        case 'left':
            $current_coordinates[0]--;
            break;
        case 'down':
            $current_coordinates[1]--;
            break;
    }
}

function manhattanDistance(array $point1, array $point2) {
    return abs($point1[0] - $point2[0]) + abs($point1[1] - $point2[1]);
}

function calculateValueFromNeighbours($coordinates, $previous_nodes_coordinates, $previous_nodes_values) {
    $value = 0;

    foreach ($previous_nodes_coordinates as $key => $node) {
        $manhattan_distance = manhattanDistance($coordinates, $node);
        echo "distance: $manhattan_distance,coordinates now: ($coordinates[0],$coordinates[1])
        ,previous coordinates: ($node[0],$node[1])<br>";
        if($manhattan_distance == 1 ) {
            $value += $previous_nodes_values[$key];
        }

        $notAStraightLine = $node[0] != $coordinates[0] && $node[1] != $coordinates[1];
        if($manhattan_distance == 2 && $notAStraightLine) {
            $value += $previous_nodes_values[$key];
        }

        echo "node value: $value<br>";
        echo "<hr>";
    }

    echo "<hr>";
    echo "<hr>";
    return $value;
}

function getInputNumberCoordinates($current_coordinates, $input_number, $algorithm = 'normal')
{
    $step = 1;
    $i = 1;

    $node_coordinates = [$current_coordinates];
    $node_values = [1];

    while (true) {

        foreach (['right', 'up', 'left', 'down'] as $key => $direction) {
            for ($j = 0; $j < $step; $j++) {

                if ($i >= $input_number) {
                    return $current_coordinates;
                }

                increaseCoordinatesAccodringToDirection($direction, $current_coordinates);

                $i = $algorithm == 'normal' ? ++$i : calculateValueFromNeighbours($current_coordinates, $node_coordinates, $node_values);
                $node_values[] = $i;
                $node_coordinates[] = $current_coordinates;
            }

            if ($key % 2 == 1) {
                $step++;
            }
        }
    }

    return $current_coordinates;
}

//$input_number = 12;
//$input_number = 265149;
$input_number = 1024;
$start_coordinates = [0,0];
$node_coordinates = [];
$node_values = [];
$end_coordinates = getInputNumberCoordinates($start_coordinates, $input_number);

echo manhattanDistance([0, 0], $end_coordinates);

echo "<hr>";

$input_number = 265150;
$start_coordinates = [0,0];
$node_coordinates = [];
$node_values = [];
$end_coordinates = getInputNumberCoordinates($start_coordinates, $input_number, 'not');

echo manhattanDistance([0, 0], $end_coordinates);
var_dump($node_values);