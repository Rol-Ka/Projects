@extends('layouts.admin')

@section('content')

<div class="admin-container">

<h2>Redaguoti istoriją</h2>

<form
method="POST"
action="{{ route('admin.stories.update',$story) }}"
enctype="multipart/form-data"
>

@csrf
@method('PUT')


<label>Pavadinimas</label>

<input
type="text"
name="title"
value="{{ old('title',$story->title) }}"
>


<label>Aprašymas</label>

<textarea name="content">{{ old('content',$story->content) }}</textarea>


<label>Tikslas (€)</label>

<input
type="number"
name="goal_amount"
value="{{ old('goal_amount',$story->goal_amount) }}"
>


<h3>Tagai</h3>

<div class="tags-container">

@if($story->tags->count())

@foreach($story->tags as $tag)

<div class="tag-chip">

#{{ $tag->name }}

<form method="POST" action="{{ route('admin.tag.detach',[$story,$tag]) }}">
@csrf
@method('DELETE')

<button type="submit">✕</button>

</form>

</div>

@endforeach

@else

<p>Nėra priskirtų tagų</p>

@endif

</div>

</form>


<h3>Pagrindinė nuotrauka</h3>

@if($story->main_image)

<div class="main-image">

<img src="{{ asset('storage/'.$story->main_image) }}">

</div>

@endif


<h3>Nuotraukos</h3>

<div class="admin-gallery">

@if($story->images->count())

@foreach($story->images as $image)

<div class="gallery-item">

<img src="{{ asset('storage/'.$image->image_path) }}" alt="story image">

<form
method="POST"
action="{{ route('admin.image.delete',$image) }}"
>

@csrf
@method('DELETE')

<button class="btn-delete">
Ištrinti
</button>

</form>

</div>

@endforeach

@else

<p>Nuotraukų nėra</p>

@endif

</div>

</div>

@endsection