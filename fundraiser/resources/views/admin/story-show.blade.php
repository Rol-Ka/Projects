{{-- @extends('layouts.admin')

@section('content')

<div class="admin-container">

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

@endsection --}}


@extends('layouts.admin')

@section('content')

<div class="admin-container">
<a href="{{ route('admin.stories') }}" class="btn btn-view back-btn">
← Atgal
</a>
<div class="story-show">

<h1 class="story-title">
{{ $story->title }}
</h1>


<div class="story-meta">

<p>
<strong>Autorius:</strong>
{{ $story->user->name }}
</p>

<p>
<strong>Tikslas:</strong>
€{{ number_format($story->goal_amount) }}
</p>

<p>
<strong>Surinkta:</strong>
€{{ number_format($story->current_amount) }}
</p>

</div>


<p class="story-content">
{{ $story->content }}
</p>


{{-- MAIN IMAGE --}}
@if($story->main_image)

<h3>Pagrindinė nuotrauka</h3>

<a href="{{ asset('storage/'.$story->main_image) }}" class="glightbox">

<img
src="{{ asset('storage/'.$story->main_image) }}"
class="story-main-image"
>

</a>

@endif


{{-- GALLERY --}}
@if($story->images->count())

<h3>Nuotraukų galerija</h3>

<div class="story-gallery">

@foreach($story->images as $image)

<a
href="{{ asset('storage/'.$image->image_path) }}"
class="glightbox"
>

<img
src="{{ asset('storage/'.$image->image_path) }}"
>

</a>

@endforeach

</div>

@endif


{{-- TAGS --}}

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
<button class="btn-approve">Patvirtinti</button>
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

</div>

@endsection