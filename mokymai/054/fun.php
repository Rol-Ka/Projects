<?php

function recursive($num)
{
    echo 'IN: ' . $num, '<br>';
    if ($num < 3) {
        // Kviečiame save. Padidiname numerį vienetu.
        recursive($num + 1);
    }
    echo 'OUT: ' . $num, '<br>';
}
$startNum = 1;
recursive($startNum);


$kreivasMasyvas = [
    5,
    [
        7,
        8,
        [
            1,
            [
                [
                    5,
                    7
                ],
                8,
                7
            ],
            0,
            [
                8,
                2,
                [
                    3,
                    3,
                    3
                ]
            ],
            [
                7
            ],
            8,
            [
                9,
                3
            ],
            7
        ],
        5,
        7
    ],
    [],
    8,
    []
];


echo "<pre>";
print_r($kreivasMasyvas);

function countArraySum($arr)
{
    $sum = 0;
    foreach ($arr as $item) {
        if (is_array($item)) {
            $sum += countArraySum($item);
        } else {
            $sum += $item;
        }
    }
    return $sum;
}

echo "\nSum: " . countArraySum($kreivasMasyvas);

$zaliasPuslapis = [
    'title' => '',
    'subTitle' => '',
    'services' => [
        'about' => [
            'text' => '',
            'text' => ''
        ],
        'about' => [
            'text' => ''
        ],
        'about' => [
            'text' => '',
            'text' => '',
            'text' => ''
        ]
    ]
];
echo '<br><hr><br>';
print_r($zaliasPuslapis);

echo '<br><hr><br>';

function labas()
{
    static $x = 0;

    $x = $x + 1;

    echo "<br>X: $x";
}


labas(); // X:1
labas(); // X:1     
labas(); // X:1


echo '<br><hr><br>';


// anonimine funkcija
$anomFun = function () {
    echo '<h2>Anoniminė funkcija</h2>';
};

$anomFun();
echo '<br><hr><br>';



$colors = ['Orange', 'Blue', 'Green', 'Yellow', 'Red'];
$raide = 2;

usort($colors, function ($a, $b) use ($raide) { //su use $raide perduodama i funkcijos vidu
    return $a[$raide] <=> $b[$raide];
});

$raide = 1;

usort($colors, fn($a, $b) => $a[$raide] <=> $b[$raide]); // Arrow funkcija


echo "<br>";
print_r($colors);
