


@extends('layouts.admin')

@section('content')

<div class="admin-container">

<a href="{{ route('admin.stories.show', $story) }}" class="btn btn-view back-btn">
← Atgal
</a>


<div class="story-edit-card">

<h2>Redaguoti istoriją</h2>

<form
method="POST"
action="{{ route('admin.stories.update',$story) }}"
enctype="multipart/form-data"
class="story-edit-form"
>

@csrf
@method('PUT')


<div class="form-group">

<label>Pavadinimas</label>

<input
type="text"
name="title"
value="{{ old('title',$story->title) }}"
required
>

</div>


<div class="form-group">

<label>Aprašymas</label>

<textarea name="content">{{ old('content',$story->content) }}</textarea>

</div>


<div class="form-group">

<label>Tikslas (€)</label>

<input
type="number"
name="goal_amount"
value="{{ old('goal_amount',$story->goal_amount) }}"
>

</div>


<h3>Tagai</h3>

<div class="tags-container">

@foreach($story->tags as $tag)

<div class="tag-chip">

#{{ $tag->name }}

<button
type="submit"
form="detach-tag-{{ $tag->id }}"
class="tag-remove"
>
✕
</button>

</div>

@endforeach

</div>


<div class="form-actions">

<button type="submit" class="btn-approve">
Išsaugoti
</button>

</div>

</form>

</div>


{{-- TAG DETACH FORMS (outside main form) --}}

@foreach($story->tags as $tag)

<form
id="detach-tag-{{ $tag->id }}"
method="POST"
action="{{ route('admin.tag.detach',[$story,$tag]) }}"
>
@csrf
@method('DELETE')
</form>

@endforeach


<h3>Pagrindinė nuotrauka</h3>

@if($story->main_image)

<div class="main-image">

<a href="{{ asset('storage/'.$story->main_image) }}" class="glightbox">

<img src="{{ asset('storage/'.$story->main_image) }}">

</a>

</div>

@endif


<h3>Nuotraukos</h3>

<div class="admin-gallery">

@if($story->images->count())

@foreach($story->images as $image)

<div class="gallery-item">

<a href="{{ asset('storage/'.$image->image_path) }}" class="glightbox">

<img src="{{ asset('storage/'.$image->image_path) }}">

</a>

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