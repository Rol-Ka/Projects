@extends('layouts.admin')

@section('content')

<div class="admin-edit container">

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
value="{{ $story->title }}"
>


<label>Aprašymas</label>

<textarea name="content">
{{ $story->content }}
</textarea>


<label>Tikslas (€)</label>

<input
type="number"
name="goal_amount"
value="{{ $story->goal_amount }}"
>


<h3>Tagai</h3>

<select name="tags[]" multiple>

@foreach($tags as $tag)

<option
value="{{ $tag->id }}"
{{ $story->tags->contains($tag->id) ? 'selected' : '' }}
>

{{ $tag->name }}

</option>

@endforeach

</select>


<button type="submit">
Išsaugoti
</button>

</form>


<h3>Nuotraukos</h3>

<div class="admin-gallery">

@foreach($story->images as $image)

<div class="gallery-item">

<img src="{{ asset('storage/'.$image->path) }}">

<form
method="POST"
action="{{ route('admin.image.delete',$image) }}"
>

@csrf
@method('DELETE')

<button class="delete">
Ištrinti
</button>

</form>

</div>

@endforeach

</div>


<h3>Pridėti naujas nuotraukas</h3>

<form
method="POST"
action="{{ route('admin.images.upload',$story) }}"
enctype="multipart/form-data"
>

@csrf

<input
type="file"
name="images[]"
multiple
>

<button>Upload</button>

</form>

</div>

@endsection