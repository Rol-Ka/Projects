

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

    <a href="{{ route('home') }}"
       class="{{ request()->routeIs('home') ? 'active' : '' }}">
        Apie mus
    </a>
</div>

<div class="nav-right">

@auth

<a href="{{ route('dashboard') }}">Paskyra</a>

@if(!auth()->user()->story)
<a href="{{ route('story.create') }}" class="btn-primary">
    + Sukurti
</a>
@endif

@if(auth()->user()->role === 'admin')
<a href="{{ route('admin.dashboard') }}">Admin</a>
@endif

<form method="POST" action="{{ route('logout') }}">
@csrf
<button type="submit" class="logout-btn">
Atsijungti
</button>
</form>

@else

<a href="{{ route('login') }}">Prisijungti</a>
<a href="{{ route('register') }}" class="btn-primary">Registruotis</a>

@endauth

</div>

</div>

</div>

</nav>