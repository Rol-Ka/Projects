<?php
$didelisMasyvas = [];

for ($i = 0; $i < 5; $i++) {


    $didelisMasyvas[$i] = []; // sukuriamas tuscias masyvas

    $mazoMasyvoIlgis = rand(0, 10); // kiek mazam masyvui bus elementu

    for ($j = 0; $j < $mazoMasyvoIlgis - 1; $j++) {
        $didelisMasyvas[$i][] = rand(10, 99); // priskiriama reiksme

    }
}
echo "<pre>";
print_r($didelisMasyvas);

$dideleSuma = 0;

foreach ($didelisMasyvas as $valueDidelis) {

    foreach ($valueDidelis as $valueMazas) {
        $dideleSuma += $valueMazas;
    }
}

echo "<pre>";
print_r("Suma:" . $dideleSuma);



usort($didelisMasyvas, 'rusiuoklis');


function rusiuoklis($a, $b)
{
    return count($a) <=> count($b);
}



echo "<pre>";
print_r($didelisMasyvas);
