<?php

$string = $_GET['input'];

function compressString($string)
{
    $return_string = '';

    $count = strlen($string);
    $letter = $string[0];
    $countappend = 1;
    for ($i = 1; $i < $count; $i++) {
        $current_letter = $string[$i];
        if ($current_letter == $letter) {
            $countappend += 1;
        } else {
            $return_string .= $letter . $countappend;
            $countappend = 1;
        }
        $letter = $current_letter;
    }
    $return_string .= $letter . $countappend;
    return $return_string;
}

echo '<pre>';
print_r(compressString($string));
echo '</pre>';
