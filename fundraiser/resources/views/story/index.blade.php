

@extends('layouts.app')

@section('page','stories')

@section('content')

<div class="stories-header">

<h2>Istorijos</h2>

<div class="stories-toolbar">

    <div class="sort-box">
        <span>Rūšiuoti:</span>

        <a href="{{ route('stories.index') }}">Naujausi</a>

        <a href="{{ route('stories.index', array_merge(request()->all(), ['sort' => 'likes_desc'])) }}">
            ❤️ Daugiausiai
        </a>

        <a href="{{ route('stories.index', array_merge(request()->all(), ['sort' => 'likes_asc'])) }}">
            ❤️ Mažiausiai
        </a>
    </div>

</div>

<div class="filter-box">
@if(request('tag'))
        <div class="filter-active" style="margin-bottom: 10px;">
            Filtruojama pagal: <strong>#{{ request('tag') }}</strong>
        </div>
    @endif
    <button id="filter-toggle">
        Filtruoti pagal tagus ▼
    </button>

    <div id="filter-dropdown" class="filter-dropdown">

        <a href="{{ route('stories.index') }}">Visi</a>

        @foreach($tags->sortBy('name') as $tag)
            <a href="{{ route('stories.index', array_merge(request()->all(), ['tag' => $tag->name])) }}">
                #{{ $tag->name }}
            </a>
        @endforeach

    </div>
    

</div>




<h3>Aktyvios istorijos</h3>

<div class="stories-grid">

@forelse($activeStories as $story)
<a href="{{ route('story.show', $story) }}" class="story-link">
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
    $current = $story->current_amount;
    $goal = $story->goal_amount;
@endphp

@include('components.progress')

        <div class="story-money">

    <div class="story-amounts">
        <span class="raised">
            €{{ number_format($story->current_amount, 0) }}
        </span>
        <span class="goal">
            iš €{{ number_format($story->goal_amount, 0) }}
        </span>
    </div>

    <div class="story-left">
        Liko €{{ number_format($goal - $current, 0) }}
    </div>

</div>

        {{-- FOOTER --}}
        <div class="story-footer">

            <div class="likes">
                ❤️ {{ $story->likes_count }}
            </div>

        </div>

    </div>

</div>
</a>

@empty

<p>Nėra aktyvių istorijų</p>

@endforelse

</div>

<h3>Baigtos istorijos</h3>

<div class="stories-grid">

@forelse($completedStories as $story)
<a href="{{ route('story.show', $story) }}" class="story-link">
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
        <div class="story-money">

    <div class="story-amounts">
        <span class="raised">
            €{{ number_format($story->current_amount, 0) }}
        </span>
        <span class="goal">
            iš €{{ number_format($story->goal_amount, 0) }}
        </span>
    </div>

    <div class="story-left">
        Surinkta 100%
    </div>

</div>

        <div class="story-footer">

            <div class="likes">
                ❤️ {{ $story->likes_count }}
            </div>

        </div>

    </div>

</div>
</a>
@empty

<p>Nėra baigtų istorijų</p>

@endforelse

</div>


{{-- <div class="stories-pagination">

{{ $stories->links('vendor.pagination.pagination') }}

</div> --}}

</div>

@endsection