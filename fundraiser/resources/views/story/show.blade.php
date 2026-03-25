@extends('layouts.app')

@section('content')

<div class="container">
<a href="{{ route('dashboard') }}" class="btn btn-view back-btn">
← Atgal
</a>
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
    $isCompleted = $current >= $goal;
@endphp

@include('components.progress')

            <p class="story-raised">
                {{ $story->current_amount }}€ / {{ $story->goal_amount }}€
            </p>
            <p class="story-raised">
                Likusi suma iki tikslo - {{ $goal - $current }}€        
            </p>

            {{-- ❤️ LIKE --}}
            <div class="story-like">
                <button 
    class="like-btn {{ (!$story->is_approved || $isCompleted) ? 'disabled' : '' }}" 
    data-id="{{ $story->id }}"
    data-allowed="{{ ($story->is_approved && !$isCompleted) ? 1 : 0 }}"
>
                    <span class="heart {{ $story->isLikedByAuth() ? 'liked' : '' }}">❤️</span>
                    <span class="like-count">{{ $story->likes()->count() }}</span>
                </button>
            </div>

            

{{-- 💰 DONATE --}}
@if(!$isCompleted && $story->is_approved)

    @auth
        <form method="POST" action="{{ route('donate', $story->id) }}" class="donate-box" data-left="{{ $story->goal_amount - $story->current_amount }}">
            @csrf
<div class="input-group">
            <input 
                type="number" 
                step="0.01" 
                name="amount" 
                placeholder="Suma €"
                class="donate-input"
            
            >
            <div class="input-error"></div>
</div>
            <button type="submit">Paaukoti</button>
        </form>
    @else
        <a href="{{ route('login') }}?redirect={{ url()->current() }}" class="donate-btn">
            Prisijunkite, kad paaukotumėte
        </a>
    @endauth

@elseif($isCompleted)

    <div class="donate-closed">
         Ši istorija jau pilnai finansuota
    </div>

@elseif(!$story->is_approved)

<div class="donate-closed">
    ⏳ Ši istorija dar nepatvirtinta
</div>

@endif

            {{-- DONATIONS --}}
            <div class="story-donations">
                <h3>Aukos</h3>

                @foreach($story->donations as $donation)
                    <p>
                        {{ $donation->user->name }} – {{ $donation->amount }}€
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
   
    window.isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};

    window.storyImages = @json($allImages);
</script>
<div id="donate-modal" class="donate-modal">
    <div class="donate-modal-box">

        <div id="modal-confirm">
            <h3>Patvirtinti auką</h3>
            <p id="donate-modal-text"></p>

            <div class="donate-modal-actions">
                <button id="confirm-donate">Taip</button>
                <button id="cancel-donate">Ne</button>
            </div>
        </div>

        <div id="modal-success" style="display:none;">
            <h3>✅ Ačiū už auką!</h3>
            <p id="success-text"></p>

            <button id="continue-btn">
                Tęsti (5)
            </button>
        </div>

    </div>
</div>
@endsection