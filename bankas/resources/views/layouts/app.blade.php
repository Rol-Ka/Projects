<!DOCTYPE html>
<html lang="lt">

<head>
    <meta charset="UTF-8">
    <title>Mini Bankas</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<div id="toast" class="toast hidden"></div>
<!-- <form method="POST" action="{{ route('logout') }}" style="display:inline;">
    @csrf
    <button type="submit" class="btn btn-danger">Atsijungti</button>
</form> -->

<body>

    <div class="nav">

        <div class="nav-left">
            <a href="{{ route('accounts.index') }}">Sąskaitos</a>
            <a href="{{ route('accounts.create') }}">Nauja sąskaita</a>
        </div>

        <div class="nav-right">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn-logout">Atsijungti</button>
            </form>
        </div>

    </div>

    <div class="container">

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