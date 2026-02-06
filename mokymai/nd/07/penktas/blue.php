<?php

if (isset($_GET['eiti'])) {
    header("Location: red.php");
    die;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <a href="blue.php?eiti=1">melynas</a>
</body>

</html>