@extends('layouts.app')

@section('content')

<div class="start-container">

<h1>
Pradėti rinkti paramą
</h1>

<p>
Norint pradėti rinkti lėšas reikia prisijungti
arba susikurti paskyrą.
</p>

<div class="start-buttons">

<a href="{{ route('login') }}" class="btn-primary">
Prisijungti
</a>

<a href="{{ route('register') }}" class="btn-secondary">
Registruotis
</a>

</div>

</div>

@endsection