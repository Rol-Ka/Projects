

<nav class="main-nav">

<div class="nav-container">

<a href="{{ route('home') }}" class="logo">
<img src="/images/mainlogo.png" alt="PaaukokMan">
</a>

<div class="nav-toggle" id="navToggle">
☰
</div>

<div class="nav-links" id="navLinks">

<div class="nav-left">



</div>

<div class="nav-right">
    <a href="{{ route('stories.index') }}"
     class="{{ request()->routeIs('stories.index') ? 'active' : '' }}">
        Istorijos</a>

<a href="{{ route('home') }}" 
class= "{{ request()->routeIs('home') ? 'active' : '' }}">
    Apie mus</a>

@auth

<a href="{{ route('dashboard') }}"
class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
Mano paskyra</a>

@if(!auth()->user()->story)
<a href="{{ route('story.create') }}">
Sukurti istoriją
</a>
@endif

@auth
@if(auth()->user()->role === 'admin')
<a href="{{ route('admin.dashboard') }}" 
class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
Administratorius</a>
@endif
@endauth

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