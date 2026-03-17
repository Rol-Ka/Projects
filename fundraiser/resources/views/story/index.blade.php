{{-- @extends('layouts.app')

@section('page','stories')

@section('content')

<div class="container-sm">

<h2>Istorijos</h2>

<div class="tag-filter">

<strong>Filtruoti pagal #tag:</strong>

<a href="{{ route('stories.index') }}">Visi</a>

@foreach($tags as $tag)

<a href="{{ route('stories.index', ['tag' => $tag->name]) }}">
#{{ $tag->name }}
</a>

@endforeach

</div>


@forelse($stories as $story)

<div class="story-card {{ $story->is_completed ? 'completed' : '' }}">

<h3 class="story-title">
<a href="{{ route('story.show', $story) }}">
{{ $story->title }}
</a>
</h3>

<p class="story-content">
{{ $story->content }}
</p>

<div class="story-tags">

@foreach($story->tags as $tag)

<span class="tag">
#{{ $tag->name }}
</span>

@endforeach

</div>


<div class="story-progress">

Surinkta:
€{{ $story->current_amount }} / €{{ $story->goal_amount }}

</div>


@if($story->donations->count())

<div class="donation-history">

<strong>Aukojimo istorija:</strong>

<ul>

@foreach($story->donations as $donation)

<li>
{{ $donation->user->name }} – €{{ $donation->amount }}
</li>

@endforeach

</ul>

</div>

@endif


<div class="story-likes">

❤️ {{ $story->likes->count() }}

</div>


@auth

<form method="POST" action="{{ route('like.toggle', $story->id) }}">

@csrf

<button type="submit" class="like-btn">

❤️ Like / Unlike

</button>

</form>

@endauth


@if(!$story->is_completed)

@auth

<form method="POST" action="{{ route('donate', $story->id) }}" class="donate-form">

@csrf

<input type="number" step="0.01" name="amount" placeholder="Suma €" required>

<button type="submit">

Paaukoti

</button>

</form>

@endauth

@else

<p class="goal-reached">

Tikslas pasiektas 🎉

</p>

@endif


@if($story->main_image)

<img src="{{ asset('storage/' . $story->main_image) }}" class="main-image">

@endif


@if($story->images->count())

<div class="gallery">

@foreach($story->images as $image)

<img src="{{ asset('storage/' . $image->image_path) }}">

@endforeach

</div>

@endif


</div>

@empty

<p>Kol kas nėra patvirtintų istorijų</p>

@endforelse

</div>

@endsection --}}

@extends('layouts.app')

@section('page','stories')

@section('content')

<div class="container">

<h2>Istorijos</h2>

<div class="tag-filter">

<strong>Filtruoti pagal #tag:</strong>

<a href="{{ route('stories.index') }}">Visi</a>

@foreach($tags as $tag)

<a href="{{ route('stories.index', ['tag' => $tag->name]) }}">
#{{ $tag->name }}
</a>

@endforeach

</div>


@forelse($stories as $story)

<div class="admin-story">

@if($story->main_image)

<div class="story-image">

<a href="{{ route('story.show',$story) }}">

<img src="{{ asset('storage/'.$story->main_image) }}">

</a>

</div>

@endif


<div class="story-info">

<h3 class="story-title">

<a href="{{ route('story.show',$story) }}">
{{ $story->title }}
</a>

</h3>


<p class="story-content">

{{ Str::limit($story->content,150) }}

</p>


<div class="story-tags">

@foreach($story->tags as $tag)

<span class="tag">
#{{ $tag->name }}
</span>

@endforeach

</div>


<div class="story-progress">

<div class="progress-bar"
style="width: {{ ($story->current_amount / $story->goal_amount) * 100 }}%">
</div>

</div>


<div class="story-raised">

€{{ $story->current_amount }} / €{{ $story->goal_amount }}

</div>


<div class="story-actions">

<div class="story-likes">

<button 
    class="like-btn {{ $story->isLikedByAuth() ? 'liked' : '' }}"
    data-id="{{ $story->id }}"
>

<span class="heart">❤️</span>
<span class="like-count">{{ $story->likes_count }}</span>

</button>

</div>


@if(!$story->is_completed)

@auth

<form method="POST" action="{{ route('donate',$story->id) }}">

@csrf

<input type="number" step="0.01" name="amount" placeholder="€">

<button class="btn btn-approve">
Paaukoti
</button>

</form>

@endauth

@endif

</div>

</div>

</div>

@empty

<p>Kol kas nėra patvirtintų istorijų</p>

@endforelse


<div class="stories-pagination">

{{ $stories->links('vendor.pagination.pagination') }}

</div>

</div>

@endsection