@extends('layouts.app')

@section('content')

<div class="container">

    <div class="story-show-card"> {{-- 🔥 LABAI SVARBU --}}

        {{-- LEFT --}}
        <div class="story-left">

            {{-- VISOS NUOTRAUKOS (hidden data) --}}
            @php
                $allImages = [];

                if ($story->main_image) {
                    $allImages[] = asset('storage/'.$story->main_image);
                }

                foreach ($story->images as $img) {
                    $allImages[] = asset('storage/'.$img->image_path);
                }
            @endphp

            {{-- MAIN IMAGE --}}
            @if($story->main_image)
                <div class="story-show-image">
                    <img 
                        src="{{ asset('storage/'.$story->main_image) }}"
                        class="gallery-open"
                        data-index="0"
                    >
                </div>
            @endif

            {{-- GALLERY --}}
            @if($story->images->count())
            <div class="story-gallery-wrapper">
                <div class="story-gallery-track">

                    @foreach($story->images as $i => $img)
                        <div class="gallery-item">
                            <img 
                                src="{{ asset('storage/'.$img->image_path) }}"
                                class="gallery-open"
                                data-index="{{ $i + 1 }}"
                            >
                        </div>
                    @endforeach

                </div>
            </div>
            @endif

        </div>

        {{-- RIGHT --}}
        <div class="story-show-content">

            <h1 class="story-title">{{ $story->title }}</h1>

            <p class="story-author">
                Autorius: {{ $story->user->name }}
            </p>

            <p class="story-text">
                {{ $story->content }}
            </p>

            {{-- PROGRESS --}}
           @php
    $current = $story->current_amount;
    $goal = $story->goal_amount;
@endphp

@include('components.progress')

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
            <form method="POST" action="{{ route('donate', $story->id) }}" class="donate-box" data-id="{{ $story->id }}">
    @csrf

    <div class="form-group">
        <input 
            type="number" 
            step="0.01" 
            name="amount" 
            placeholder="€ suma"
            class="donate-input"
        >

        <div class="input-error"></div>
    </div>

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

    </div> {{-- 🔥 ČIA UŽSIDARO FLEX CONTAINER --}}

</div>

{{-- LIGHTBOX (paliekam už card ribų) --}}
<div class="lightbox" id="lightbox">

    <span class="lightbox-close">&times;</span>

    <div class="lightbox-content">

        <button class="nav prev">‹</button>

        <img class="lightbox-img">

        <button class="nav next">›</button>

    </div>

</div>

{{-- 🔥 perduodam images į JS --}}
<script>
    window.storyImages = @json($allImages);
</script>

@endsection