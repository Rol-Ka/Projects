<!DOCTYPE html>
<html lang="lt">

<head>
    <meta charset="UTF-8">
    <title>Mini Bankas</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

</head>
<div id="toast" class="toast hidden"></div>

<body>

    <nav>
        <a href="{{ route('accounts.index') }}">Sąskaitos</a>
        <a href="{{ route('accounts.create') }}">Nauja sąskaita</a>
    </nav>

    <div class="container">

        @if(session('success'))
        <div class="flash success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
        <div class="flash error">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
        <div class="flash error">
            Yra klaidų — patikrink laukus
        </div>
        @endif

        @yield('content')

    </div>

</body>
<script>
    function showToast(message, type = "success") {
        const toast = document.getElementById('toast');
        toast.innerText = message;
        toast.className = 'toast ' + type;
        toast.classList.remove('hidden');

        setTimeout(() => {
            toast.classList.add('hidden');
        }, 3000);
    }
</script>
@if(session('success'))
<script>
    showToast("{{ session('success') }}", "success")
</script>
@endif

@if(session('error'))
<script>
    showToast("{{ session('error') }}", "error")
</script>
@endif

</html>


</body>

</html>