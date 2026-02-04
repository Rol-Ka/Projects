<?php


$bgColor = 'Black';

if (isset($_GET['color']) && $_GET['color'] == 1) {
    $bgColor = 'crimson';
}




?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Mechanika</title>
</head>

<body style="background-color: <?= $bgColor ?> ">
    <a href="pirmas.php">Juodulys</a>
    <a href="pirmas.php?color=1">Raudonulys</a>



</body>

</html>