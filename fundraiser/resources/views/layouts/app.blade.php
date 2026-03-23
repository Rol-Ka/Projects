<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="@yield('description', 'Default description')">
    <meta name="keywords" content="@yield('keywords', 'default, keywords')">
    <meta name="author" content="@yield('author', 'Author')">
    <meta property="og:title" content="@yield('pavadinimas')">
    <meta property="og:description" content="@yield('description', 'Default description')">
    <meta property="og:type" content="website">
<link rel="icon" type="image/png" href="/images/icon.png">
    <title>PaaukokMan</title>

    <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS + JS -->
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
</head>

<body  data-page="@yield('page')">
<div class="site-wrapper"> 
    {{-- NAVBAR --}}
    @include('layouts.navigation')

    {{-- PAGE CONTENT --}}
    <main class="page-container">
        @yield('content')
    </main>
    @include('layouts.footer')
</div>
@include('components.toast')
<script>
    window.isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
</script>
</body>

</html>
