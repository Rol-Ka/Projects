<?php

/*

Generuokite atsitiktinį stringą, pasinaudodami kodu md5(time()).
 Visus skaitmenis stringe įdėkite į h1 tagą. Raides palikite.
  Jegu iš eilės eina keli skaitmenys, juos į tagą reikią dėti 
  kartu (h1 atsidaro prieš pirmą ir užsidaro po paskutinio) 
  Keitimui naudokite pirmo patobulintą (jeigu reikia) uždavinio funkciją 
  ir preg_replace_callback();

*/


function textToH1(array $arr): string
{
    $text = $arr[0];
    return '<h1 style="display:inline">' . $text . '</h1>';
}

$what = md5(time());

echo $what . '<br>';

$newWhat = preg_replace_callback('/\d+/', 'textToH1', $what);

echo '<br>';
echo $newWhat;


$title = 'Tik nereikia gasdinti Pietu centro, geriant sultis pas save kvartale';

$title = str_replace([',', '.', '?'], '', $title);


$title = explode(' ', $title);
$count = 0;
foreach ($title as &$word) {
    if ($word && strlen($word) <= 5) {
        $count++;
    }
}

echo '<br><pre>';
echo $count;
echo '<br>';
print_r($title);
