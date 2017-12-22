<?php

include 'Logger.php';

function testSpin($dancers)
{
    if ($dancers === 'eabcd') {
        Logger::success($dancers);
    } else {
        Logger::error('should be cdeab instead of', $dancers);
    }
    Logger::hr();
}

function testExchange($dancers)
{
    if ($dancers === 'eabdc') {
        Logger::success($dancers);
    } else {
        Logger::error('should be eabdc instead of', $dancers);
    }
    Logger::hr();
}

function testPartner($dancers)
{
    if ($dancers === 'baedc') {
        Logger::success($dancers);
    } else {
        Logger::error('should be baedc instead of', $dancers);
    }
    Logger::hr();
}

/*--------------------------------------------------------------*/

function spin($string, $number_of_moves) {
    return substr($string, - $number_of_moves) . substr($string, 0, 16 - $number_of_moves);
}

function exchange($string, $position1, $position2) {
    $program1 = substr($string, $position1, 1);
    $program2 = substr($string, $position2, 1);

    return partner($string, $program1, $program2);
}

function partner($string, $program1, $program2) {
    $b = str_replace($program1,'x',$string);
    $b = str_replace($program2,$program1,$b);

    return str_replace('x',$program2,$b);
}


//$input = 'abcde';
//$dancers = spin($input, 1);
//testSpin($dancers);
//
//$dancers = exchange($dancers, 3, 4);
//testExchange($dancers);
//
//$dancers = partner($dancers, "e", "b");
//testPartner($dancers);

//$input = 'abcde';
//$moves_string = "s1,x3/4,pe/b";
//$dance_moves = explode(',', $moves_string);

$input = "abcdefghijklmnop";
$moves_string = file_get_contents("inputs/day16.txt");
$dance_moves = explode(',', $moves_string);

$counter = 0;
while($counter < 34) {

    foreach ($dance_moves as $move) {
        $move = preg_match("/([sxp])([\da-p]+)\/?([\da-p]+)?/", $move, $match);

        switch($match[1]) {
            case 's':
                $number_of_moves = (int) $match[2];
                $input = spin($input, $number_of_moves);
                break;

            case 'x':
                $program1 = (int) $match[2];
                $program2 = (int) $match[3];
                $input = exchange($input, $program1, $program2);
                break;

            case 'p':
                $input = partner($input, $match[2], $match[3]);
                break;
        }
    }
    Logger::hr();
    $counter++;

    if($input === 'abcdefghijklmnop') {
        break;
    }

}

Logger::outputLine('result', $input);
Logger::outputLine('counter', $counter);

var_dump(1000000000 % 42);
