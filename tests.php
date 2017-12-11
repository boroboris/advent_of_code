<?php

//$dlist=new SplDoublyLinkedList();
//$loop = true;
//
//foreach(range(0,5) as $number) {
//    $dlist->push($number);
//}
//$dlist->rewind();
//
//
//while($dlist->valid()) {
//    echo $dlist->current()."<br/>";
//
//    $dlist->next();
//    if(!$dlist->valid() && $loop) {
//        echo 'entered<br>';
//        $dlist->rewind();
//        $loop = false;
//    }
//}
//
//echo "<hr>";
//
//echo bin2hex(chr(64)) . "<br>";
//echo bin2hex(chr(7)) . "<br>";
//echo bin2hex(chr(255)) . "<br>";

//$tests = [64, 17, 31, 73, 47, 23];
//foreach ($tests as $test) {
//    echo chr($test);
//}


//$i++; //begin with next
//while ($redistribute > 0) {
//    if ($i > $memory_length) {
//        $i = 0;
//    }
//
//    $memory_bank[$i]++;
//    $redistribute--;
//    $i++;
//}

//svima nešto
//nekima ostatak

$memory_bank = [0,0,0,0];
$redistribute = 11;
$redistribute_amount = [];
$i=2;

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

var_dump($memory_bank);

