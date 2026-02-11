<?php

$masyvas = []; // $masyvas[0] = rand(5, 25);

$masyvas[] = rand(5, 25); // $masyvas[1] = rand(5, 25);
$masyvas[] = rand(5, 25); // $masyvas[2] = rand(5, 25);

for ($i = 2; $i < 10; $i++) { // $i = 2, 3, 4, 5, 6, 7, 8, 9
    $masyvas[$i] = $masyvas[$i - 1] + $masyvas[$i - 2]; // $masyvas[2] = $masyvas[1] + $masyvas[0];
}

echo '<pre>'; // <pre> - formatavimas, kad būtų lengviau skaityti
print_r($masyvas); // print_r - išveda masyvą, kad būtų lengviau skaityti