<?php


$bgColor = 'Black';

if (isset($_GET['color'])) {
    $bgColor = $_GET['color'];
}




?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Mechanika</title>
</head>

<body style="background-color:<?= $bgColor ?> ">
    <a href="antras.php">Juodulys</a>




</body>

</html>