

<nav class="main-nav">

<div class="nav-container">

<a href="{{ route('home') }}" class="logo">
    <img src="/images/mainlogo.png" alt="PaaukokMan">
</a>

<div class="nav-toggle" id="navToggle">
    <span></span>
    <span></span>
    <span></span>
</div>

<div class="nav-links" id="navLinks">

<div class="nav-left">
    <a href="{{ route('stories.index') }}"
       class="{{ request()->routeIs('stories.index') ? 'active' : '' }}">
        Istorijos
    </a>

    <a href="{{ route('about') }}"
       class="{{ request()->routeIs('about') ? 'active' : '' }}">
        Apie mus
    </a>
</div>

<div class="nav-right">

@auth

<a href="{{ route('dashboard') }}">Mano paskyra</a>

@if(!auth()->user()->story)
<a href="{{ route('story.create') }}" >
    + Sukurti istoriją
</a>
@endif

@if(auth()->user()->role === 'admin')
<a href="{{ route('admin.dashboard') }}">Administratorius</a>
@endif

<form method="POST" action="{{ route('logout') }}">
@csrf
<button type="submit" class="logout-btn">
Atsijungti
</button>
</form>

@else

<a href="{{ route('login') }}">Prisijungti</a>
<a href="{{ route('register') }}">Registruotis</a>

@endauth

</div>

</div>

</div>

</nav>

<div class="nav-overlay" id="navOverlay"></div>