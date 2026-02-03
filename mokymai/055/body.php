<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WEB Mechanikas</title>
    <style>
        body {
            background: gray;
            color: lime;
        }
    </style>
</head>

<body>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET'): ?>

        <form method="post" action="body.php">
            <input type="text" name="a">
            <input type="text" name="b">
            <button id="sumuok">sumuok</button>
        </form>

    <?php else: ?>
        <h2>
            <?php
            if ($_SERVER['CONTENT_TYPE'] == 'application/x-www-form-urlencoded') {
                // skirta analizuoti application/x-www-form-urlencoded
                echo $_POST['a'] + $_POST['b'];
            }
            if ($_SERVER['CONTENT_TYPE'] == 'application/json') {
                // skirta analizuoti application/json
                $json = file_get_contents('php://input'); // failo skaitymas iš input strymo
                $data = json_decode($json, true); // true - pavertia i masyvą
                echo $data['a'] + $data['b'];
            }

            ?>
        </h2>
        <a href="body.php">Atgal</a>

    <?php endif ?>



    <script>
        document.querySelector('#make-sum').addEventListener('click', function(e) { // pridedam event listeneri mygtukui
            e.preventDefault(); //sustabdo formos siuntima

            const data = { // surenkam duomenis is formos
                a: document.querySelector('input[name="a"]').value, // paimam reiksme is input laukelio
                b: document.querySelector('input[name="b"]').value // paimam reiksme is input laukelio
            };

            fetch('body.php', { // siunciam duomenis i body.php
                    method: 'POST', // nurodom, kad siunciam POST uzklausa
                    headers: { // nurodom, kad siunciam JSON duomenis
                        'Content-Type': 'application/json' // nurodom, kad siunciam JSON duomenis
                    },
                    body: JSON.stringify(data) // paverciam duomenis i JSON formata
                })
                .then(response => response.text()) // gaunam atsakyma is serverio kaip teksta
                .then(data => { // apdorojam gauta atsakyma
                    document.body.innerHTML = data; // atnaujinam puslapio turini su gautu atsakymu
                });
        });
    </script>


</body>

</html>