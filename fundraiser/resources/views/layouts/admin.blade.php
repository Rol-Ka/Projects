<!DOCTYPE html>
<html lang="lt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>
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
Hashtag'ai
</a>

        </nav>

    </aside>

    <main class="admin-content">

        @yield('content')

    </main>

</div>

</body>
</html>