<?php

if (isset($_GET['eiti'])) {
    header("Location: blue.php");
    exit();
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
    <a href="red.php?eiti=1">raudonas</a>
</body>

</html>