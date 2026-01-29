<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web mechanika</title>
    <style>
        body {
            background-color: black;
            color: lime;
        }
    </style>
</head>

<body>
    <h1>
        <?php
        $digit = rand(10000, 99999);
        echo  $digit;
        ?>
    </h1>
    <h2>
        <?php
        $bebras = $_GET['bebras'] ?? 'Nera bebro';
        echo  $bebras;


        ?>
    </h2>

    <h3>
        <?php
        $a = $_GET['a'] ?? 0;
        $b = $_GET['b'] ?? 0;
        $suma = $a + $b;
        echo $suma;
        ?>
    </h3>

</body>

</html>