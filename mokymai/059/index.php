<?php
require __DIR__ . '/biblioteka/Knyga.php';
require __DIR__ . '/Knyga.php';




$knyga1 = new Knyga();
$knyga2 = new AI\GPT5\Knyga('Copycat', 'Jonas Jonaitis', 320);


echo '<pre>';
print_r($knyga1);

print_r($knyga2);
