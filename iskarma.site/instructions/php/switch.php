<?php
# switch
$fruit = 'a variable value';
switch($fruit) {
  case 'red apple':
  case 'green apple':
    echo "fruit name is apple and it is green or red!";
    break;
  case 'banana':
    echo "fruit name is: " . "$banana" . " and its yellow!";
    break;
  default:
    echo "fruits are healthy";
}
?>
