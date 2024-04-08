<?php

$input_string = $_GET['input'];

function strip_string($input_string, $threshhold = 5)
{
  $return_string = '';
  if ($input_string[0] != '-') {
    $threshhold = strlen($input_string);
  }
  for ($i = 1; $i < $threshhold; $i++) {
    $return_string .= $input_string[$i];
  }
  return $return_string;
}

echo '<pre>';
print_r(strip_string($input_string));
echo '</pre>';
echo '<p>Steps</p>';
echo '<ul>
  <li>Checked +/- contains (In our use case,+/v contains in the prefix)</li>
  <li>Threshshold = 5</li>
  <li>Get the values within threshhold if starting with -ve</li>
  <li>Removed +/-ve `prefix only`</li>
</ul>
';
