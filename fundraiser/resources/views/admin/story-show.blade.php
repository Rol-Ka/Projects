@extends('layouts.admin')

@section('content')

<div class="admin-story-view container">

<h1>{{ $story->title }}</h1>

<img
src="{{ asset('storage/'.$story->main_image) }}"
class="main-image"
>

<p class="story-content">
{{ $story->content }}
</p>

<p>
<strong>Autorius:</strong> {{ $story->user->name }}
</p>

<p>
<strong>Tikslas:</strong> €{{ number_format($story->goal_amount) }}
</p>

<p>
<strong>Surinkta:</strong> €{{ number_format($story->current_amount) }}
</p>


<h3>Nuotraukų galerija</h3>

<div class="admin-gallery">

@foreach($story->images as $image)

<img src="{{ asset('storage/'.$image->image_path) }}">

@endforeach

</div>


<h3>Tagai</h3>

<div class="story-tags">

@foreach($story->tags as $tag)

<span class="tag">
#{{ $tag->name }}
</span>

@endforeach

</div>


<div class="story-actions">

@if(!$story->is_approved)

<form method="POST" action="{{ route('admin.stories.approve',$story) }}">
@csrf

<button class="btn-approve">
Patvirtinti
</button>

</form>

@endif

<a
href="{{ route('admin.stories.edit',$story) }}"
class="btn-edit"
>
Redaguoti
</a>


<form method="POST" action="{{ route('admin.stories.destroy',$story) }}">
@csrf
@method('DELETE')

<button class="btn-delete">
Ištrinti
</button>

</form>

</div>

</div>

@endsection