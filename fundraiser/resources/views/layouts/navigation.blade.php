

<nav class="main-nav">

<div class="nav-container">

<a href="{{ route('home') }}" class="logo">
PaaukokMan
</a>

<div class="nav-toggle" id="navToggle">
☰
</div>

<div class="nav-links" id="navLinks">

<div class="nav-left">

<a href="{{ route('stories.index') }}">Istorijos</a>

<a href="{{ route('home') }}">Apie mus</a>

</div>

<div class="nav-right">

@auth

<a href="/dashboard">Mano paskyra</a>

@if(!auth()->user()->story)
<a href="{{ route('story.create') }}">
Sukurti istoriją
</a>
@endif

@if(auth()->user()->role === 'admin')
<a href="{{ route('admin.stories') }}">
Administratorius panelė
</a>
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