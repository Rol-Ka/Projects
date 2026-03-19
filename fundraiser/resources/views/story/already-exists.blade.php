@extends('layouts.app')

@section('content')

<div class="container-sm already-exists">

    <div class="already-card">

        <h2>Jūs jau turite sukūrę istoriją</h2>

        <p class="already-sub">
            Vienas vartotojas gali turėti tik vieną istoriją.
        </p>

        <p class="already-story">
            Jūsų istorija:
            <strong>{{ auth()->user()->story->title }}</strong>
        </p>

        <div class="already-actions">
            <a href="{{ route('stories.index') }}" class="btn-primary">
                Peržiūrėti istorijas
            </a>

            <a href="/dashboard" class="btn-secondary">
                Mano paskyra
            </a>
        </div>

    </div>

</div>

@endsection