<?php

/*
Parašykite funkciją, kuri skaičiuotų, iš kiek sveikų skaičių jos argumentas dalijasi be liekanos (išskyrus vienetą ir patį save) Argumentą užrašykite taip, kad būtų galima įvesti tik sveiką skaičių;
Sugeneruokite masyvą iš 100 elementų, kurio reikšmės atsitiktiniai skaičiai nuo 33 iki 77. Išrūšiuokite masyvą pagal daliklių be liekanos kiekį mažėjimo tvarka, panaudodami ketvirto uždavinio funkciją.

*/

function kiekBeLLiekanos(int $skaicius): int
{
    $rezultatas = 0;
    for ($i = 2; $i <= $skaicius; $i++) {
        if ($skaicius % $i === 0) {
            $rezultatas++;
        }
    }
    return $rezultatas;
}
echo "<pre>";
echo kiekBeLLiekanos(6);

$masyvas = [];
foreach (range(1, 100) as $_) {
    $masyvas[] = rand(33, 77);
}

print_r($masyvas);

usort($masyvas, function ($a, $b) {
    return kiekBeLLiekanos($b) <=> kiekBeLLiekanos($a);
});
print_r($masyvas);
