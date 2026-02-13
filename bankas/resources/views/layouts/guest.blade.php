<!DOCTYPE html>
<html lang="lt">

<head>
    <meta charset="UTF-8">
    <title>Bankas – Prisijungimas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>

<body class="login-body">

    <div class="login-bg-logo">
        <img src="/images/bank-logo.png" alt="Bankas">
    </div>

    <div class="login-center">
        <div class="login-card">
            @yield('content')
        </div>
    </div>

</body>

</html>