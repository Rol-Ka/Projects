<?php
/*

BE JS (tradicinis) siunciam pilna HTML puslapi

SU JS siunciam tik maza puslapio dali

Tradicinis :
Jeigu metodas GET ---> serveris grazina pilna HTML puslapi
Jeigu metodas POST ---> serveris  grazina redirect 
*/


session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['color'])) {

    $color = htmlspecialchars($_POST['color']);
    $_SESSION['my_color'] = $color;

    header('Location: post-color.php'); // redirectas.
    die; // tam kad redirectintu turim uzdaryti skripta čia.
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Color Picker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        input,
        button {
            padding: 15px;
            font-size: 16px;
        }

        .result {
            margin-top: 20px;
            padding: 20px;
            border-radius: 5px;
            display: none;
        }
    </style>
</head>

<body>
    <h1>Color Picker</h1>
    <form method="POST" action="">
        <label for="color">Choose a color:</label>
        <input type="color" id="color" name="color" required>
        <button type="submit">Submit</button>
    </form>

    <?php
    if (isset($_SESSION['my_color'])) {
        $color = htmlspecialchars($_SESSION['my_color']);

        unset($_SESSION['my_color']); // Ištriname cookie

        echo "<div class='result' style='background-color: $color;'>";
        echo "<p>Selected color: <strong>$color</strong></p>";
        echo "</div>";
        echo "<script>document.querySelector('.result').style.display = 'block';</script>";
    }
    ?>
</body>

</html>