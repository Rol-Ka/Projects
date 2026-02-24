@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2>Istorijos</h2>
    <div style="margin-bottom:20px;">
    <strong>Filtruoti pagal #tag:</strong><br>

    <a href="{{ route('home') }}">Visi</a>

    @foreach($tags as $tag)
        |
        <a href="{{ route('home', ['tag' => $tag->name]) }}">
            #{{ $tag->name }}
        </a>
    @endforeach
</div>

    @forelse($stories as $story)
        <div style="
    border:1px solid #ccc;
    padding:15px;
    margin-bottom:15px;
    background-color: {{ $story->is_completed ? '#e6ffe6' : '#ffffff' }};
">

            <h3>{{ $story->title }}</h3>

            <p>{{ $story->content }}</p>
            <p>
    @foreach($story->tags as $tag)
        <span style="color:blue;">#{{ $tag->name }}</span>
    @endforeach
</p>

            <p>
                Surinkta: €{{ $story->current_amount }} / €{{ $story->goal_amount }}
            </p>
            <p>❤️ {{ $story->likes->count() }}</p>

@auth
<form method="POST" action="{{ route('like.toggle', $story->id) }}">
    @csrf
    <button type="submit">
        ❤️ Like / Unlike
    </button>
</form>
@endauth
@if(!$story->is_completed)
    @auth
        <form method="POST" action="{{ route('donate', $story->id) }}">
            @csrf
            <input type="number" step="0.01" name="amount" placeholder="Suma €" required>
            <button type="submit">Paaukoti</button>
        </form>
    @endauth
@else
    <p style="color:green;"><b>Tikslas pasiektas 🎉</b></p>
@endif

            @if($story->main_image)
                <img src="{{ asset('storage/' . $story->main_image) }}" width="200">
            @endif

        </div>
    @empty
        <p>Kol kas nėra patvirtintų istorijų</p>
    @endforelse

</div>
@endsection