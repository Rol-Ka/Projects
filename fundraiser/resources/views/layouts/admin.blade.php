<!DOCTYPE html>
<html lang="lt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administratorius</title>
    <link rel="icon" type="image/png" href="/images/icon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">
    @vite(['resources/css/app.scss','resources/js/app.js'])
</head>

<body>

@include('layouts.navigation')

<div class="admin-container">

    <aside class="admin-sidebar">

        <h2>Administratorius</h2>

        <nav>

            <a href="{{ route('admin.dashboard') }}"
class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
Administratoriaus paskyra
</a>

<a href="{{ route('admin.stories') }}"
class="{{ request()->routeIs('admin.stories') ? 'active' : '' }}">
Istorijos
</a>

<a href="{{ route('admin.tags') }}"
class="{{ request()->routeIs('admin.tags') ? 'active' : '' }}">
Žymos
</a>

        </nav>

    </aside>

    <main class="admin-content">

        @yield('content')

    </main>

</div>
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

<script>
const lightbox = GLightbox({
    selector: '.glightbox',
    touchNavigation: true,
    loop: true,
    closeButton: true
});
</script>

<div id="admin-confirm-modal" class="donate-modal">

    <div class="donate-modal-box">

        <div id="admin-confirm-box">
            <h3>Patvirtinimas</h3>
            <p id="admin-confirm-text">Ar tikrai?</p>

            <div class="donate-modal-actions">
                <button id="admin-confirm-yes">Taip</button>
                <button id="admin-confirm-no">Ne</button>
            </div>
        </div>

    </div>

</div>
</body>
</html>