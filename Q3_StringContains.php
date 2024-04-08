<?php

$inputAr = [
    ['A', 'B', 'C', 'E'],
    ['S', 'F', 'C', 'S'],
    ['A', 'D', 'E', 'E'],
];

function CheckExist($ar, $letter, $inputI, $inputJ, $true_count)
{
    $inputJ = 0;
    $cnt = count($ar);
    for ($i = $inputJ; $i < $cnt; $i++) {
        if ($ar[$i] == $letter) {
            $true_count += $i;
            break;
        }
    }
    $inputJ = $i;
    if ($inputJ == $cnt) {
        $inputI += 1;
    }
    return array($inputI, $inputJ, $true_count);
}

function strip_contains($word)
{
    global $inputAr;
    $count = count($word);
    $inputI = 0;
    $inputJ = 0;
    $true_count = 0;
    for ($k = 0; $k < $count; $k++) {
        // echo $word[$k] . '<br>';
        $letter = $word[$k];
        if (isset($inputAr[$inputI])) {
            $cnt = count($inputAr[$inputI]);
            $array_post = array_slice($inputAr[$inputI], $inputJ, $cnt);
            list($inputI, $inputJ, $true_count) = CheckExist($array_post, $letter, $inputI, $inputJ, $true_count);
        }
    }
    if ($true_count == $count - 1) {
        return "true";
    } else {
        return "false";
    }
}

$words = [
    ['A', 'B', 'C', 'C', 'E', 'D'],
    ['S', 'E', 'E'],
    ['A', 'B', 'C', 'B'],
];
foreach ($words as $key => $word) {
    echo implode("",$word) . " ". (strip_contains($word)) . "<br>";
}
