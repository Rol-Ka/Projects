@extends('layouts.app')

@section('page','stories')

@section('content')

<div class="stories-container">

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

@endsection