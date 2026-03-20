

@extends('layouts.app')

@section('page','stories')

@section('content')

<div class="stories-header">

<h2>Istorijos</h2>

<div class="stories-toolbar">

    <div class="sort-box">
        <span>Rūšiuoti:</span>

        <a href="{{ route('stories.index') }}">Naujausi</a>

        <a href="{{ route('stories.index', ['sort' => 'likes_desc']) }}">
            ❤️ Daugiausiai
        </a>

        <a href="{{ route('stories.index', ['sort' => 'likes_asc']) }}">
            ❤️ Mažiausiai
        </a>
    </div>

</div>

<div class="filter-box">

    <button id="filter-toggle">
        Filtruoti pagal tagus ▼
    </button>

    <div id="filter-dropdown" class="filter-dropdown">

        <a href="{{ route('stories.index') }}">Visi</a>

        @foreach($tags->sortBy('name') as $tag)
            <a href="{{ route('stories.index', ['tag' => $tag->name]) }}">
                #{{ $tag->name }}
            </a>
        @endforeach

    </div>

</div>




<h3>Aktyvios istorijos</h3>

<div class="stories-grid">

@forelse($activeStories as $story)

    <div class="story-card">

    {{-- IMAGE --}}
    @if($story->main_image)
        <div class="story-image-wrap">
            <img src="{{ asset('storage/'.$story->main_image) }}">
        </div>
    @endif

    {{-- BODY --}}
    <div class="story-body">

        <h3 class="story-title">
            {{ $story->title }}
        </h3>

        <p class="story-content">
            {{ Str::limit($story->content, 90) }}
        </p>

        {{-- PROGRESS --}}
        @php
            $percent = $story->goal_amount > 0 
                ? ($story->current_amount / $story->goal_amount) * 100 
                : 0;

            $left = max($story->goal_amount - $story->current_amount, 0);
        @endphp

        <div class="progress-bar">
            <div class="progress-fill" style="width: {{ $percent }}%"></div>
        </div>

        {{-- AMOUNTS --}}
        <div class="story-amounts">

            <span class="raised">
                €{{ number_format($story->current_amount, 0) }}
            </span>

            <span class="goal">
                iš €{{ number_format($story->goal_amount, 0) }}
            </span>

        </div>

        <div class="story-amounts">
            Liko €{{ number_format($left, 0) }}
        </div>

        {{-- FOOTER --}}
        <div class="story-footer">

            <div class="likes">
                ❤️ {{ $story->likes_count }}
            </div>

        </div>

    </div>

</div>

@empty

<p>Nėra aktyvių istorijų</p>

@endforelse

</div>

<h3>Baigtos istorijos</h3>

<div class="stories-grid">

@forelse($completedStories as $story)

    <div class="story-card completed">

    {{-- IMAGE --}}
    @if($story->main_image)
        <div class="story-image-wrap">
            <img src="{{ asset('storage/'.$story->main_image) }}">
            <div class="badge-completed">Baigta</div>
        </div>
    @endif

    {{-- BODY --}}
    <div class="story-body">

        <h3 class="story-title">
            {{ $story->title }}
        </h3>

        <p class="story-content">
            {{ Str::limit($story->content, 90) }}
        </p>

        {{-- FULL PROGRESS --}}
        <div class="progress-bar">
            <div class="progress-fill full"></div>
        </div>

        {{-- AMOUNTS --}}
        <div class="story-amounts">

            <span class="raised">
                €{{ number_format($story->current_amount, 0) }}
            </span>

            <span class="goal">
                iš €{{ number_format($story->goal_amount, 0) }}
            </span>

        </div>

        <div class="story-footer">

            <div class="likes">
                ❤️ {{ $story->likes_count }}
            </div>

        </div>

    </div>

</div>

@empty

<p>Nėra baigtų istorijų</p>

@endforelse

</div>


{{-- <div class="stories-pagination">

{{ $stories->links('vendor.pagination.pagination') }}

</div> --}}

</div>

@endsection