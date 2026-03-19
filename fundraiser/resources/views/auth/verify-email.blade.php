@extends('layouts.app')

@section('content')

<div class="auth-container">

    <div class="auth-card">

        <h2>Patvirtink el. paštą</h2>

        <p class="auth-subtext">
            Patikrink savo el. paštą ir paspausk nuorodą.
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="success-msg">
                Nuoroda išsiųsta dar kartą.
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}" novalidate>
            @csrf
            <button class="btn-primary btn-block">Siųsti dar kartą</button>
        </form>

        <form method="POST" action="{{ route('logout') }}" novalidate>
            @csrf
            <button class="btn-link btn-block">Atsijungti</button>
        </form>

    </div>

</div>

@endsection