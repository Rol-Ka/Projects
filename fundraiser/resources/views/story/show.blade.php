@extends('layouts.app')

@section('content')

<div class="container">

<div class="story-show-card">
<div class="story-left">
    {{-- IMAGE --}}
    @if($story->main_image)
        <div class="story-show-image">
            <img src="{{ asset('storage/'.$story->main_image) }}">
        </div>
    @endif

    {{-- 🔥 SLIDER GALLERY --}}
@if($story->images->count())
<div class="story-gallery-wrapper">

    <div class="story-gallery-track">

        @foreach($story->images as $img)
            <div class="gallery-item">
                <img src="{{ asset('storage/'.$img->image_path) }}">
            </div>
        @endforeach

    </div>

</div>
@endif
</div>

    {{-- CONTENT --}}
    <div class="story-show-content">

        <h1 class="story-title">{{ $story->title }}</h1>

        <p class="story-author">
            Autorius: {{ $story->user->name }}
        </p>

        <p class="story-text">
            {{ $story->content }}
        </p>

        {{-- PROGRESS --}}
        <div class="story-progress">
            <div class="progress-bar"
                 style="width: {{ ($story->current_amount / $story->goal_amount) * 100 }}%">
            </div>
        </div>

        <p class="story-raised">
            €{{ $story->current_amount }} / €{{ $story->goal_amount }}
        </p>

        {{-- ❤️ LIKE --}}
        <div class="story-like">
            <button class="like-btn" data-id="{{ $story->id }}">
                <span class="heart {{ $story->isLikedByAuth() ? 'liked' : '' }}">❤️</span>
                <span class="like-count">{{ $story->likes()->count() }}</span>
            </button>
        </div>

        {{-- 💰 DONATE --}}
        @auth
        <form method="POST" action="{{ route('donate', $story->id) }}" class="donate-box">
            @csrf
            <input type="number" step="0.01" name="amount" placeholder="€ suma">
            <button type="submit">Paaukoti</button>
        </form>
        @endauth

        {{-- DONATIONS --}}
        <div class="story-donations">
            <h3>Aukos</h3>

            @foreach($story->donations as $donation)
                <p>
                    {{ $donation->user->name }} – €{{ $donation->amount }}
                </p>
            @endforeach
        </div>

    </div>

</div>




</div>

@endsection