<?php

echo '<pre>';


$url = $_SERVER['REQUEST_URI'];

const I_DIR = '/projects/mokymai/056/';

$url = str_replace(I_DIR, '', $url);

$url = explode('/', $url);



?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pink Background</title>
    <style>
        body {
            background-color: <?= $url[0] ?? 'pink' ?>;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
</body>

</html>