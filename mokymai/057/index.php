<?php

// include __DIR__ . '/Stotele.php'; // jeigu failas nerastas, bus klaida

// include_once __DIR__ . '/Stotele.php'; // tapati faila ikeliama tik vieną kartą


// require_once __DIR__ . '/Stotele.php'; // grieztai tikrina failo egzistyyavima, tapati faila ikeliama tik vieną kartą
require __DIR__ . '/Stotele.php'; // grieztai tikrina failo egzistyyavima


$stotele1 = new Stotele('Žaliakalnis');

$stotele2 = new Stotele('Pilaite');





echo "<pre>";
var_dump($stotele1);
var_dump($stotele2);

echo $stotele1->vardas . PHP_EOL; // veikia, nes vardas yra public
// echo $stotele1->id . PHP_EOL; // klaida, nes id yra private


echo $stotele1->id . PHP_EOL; // veikia, nes naudojamas magiskas metodas __get





$stotele1->rodytiAutobusus();

echo 'viskas gerai';
