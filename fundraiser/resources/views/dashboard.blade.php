@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <h2>Mano paskyra</h2>

    @php
        $story = auth()->user()->story;
    @endphp

    {{-- Jei neturi story --}}
    @if(!$story)
    <p>Jūs dar neturite savo istorijos. Sukurkite ją, kad galėtumėte pradėti rinkti lėšas!</p>
        <div style="margin-bottom:15px;">
            <a href="{{ route('story.create') }}">
                ➕ Sukurti istoriją
            </a>
        </div>
    @endif

    {{-- Jei turi story --}}
    @if($story)
        <div style="border:1px solid #ccc; padding:15px; margin-top:15px;">
            <h3>Mano istorija</h3>

            <strong>{{ $story->title }}</strong><br>

            Statusas:
            @if($story->is_approved)
                <span style="color:green;">Patvirtinta</span>
            @else
                <span style="color:red;">Nepatvirtinta</span>
            @endif

            <br><br>

            @if(!$story->is_approved)
                <a href="{{ route('story.edit', $story) }}">
                    ✏️ Redaguoti
                </a>
            @endif
        </div>
    @endif


</div>

@endsection