@extends('layouts.app')

@section('page','create-story')

@section('content')

<div class="create-container">

<h2>Sukurti istoriją</h2>

@if(session('error'))
<div class="form-error">
{{ session('error') }}
</div>
@endif

<form method="POST"
      action="{{ route('story.store') }}"
      enctype="multipart/form-data"
      class="story-form">

@csrf

<div class="form-group">
<label>Pavadinimas</label>
<input type="text" name="title" required>
</div>


<div class="form-group">
<label>Aprašymas</label>
<textarea name="content" required></textarea>
</div>


<div class="form-group">
<label>Tikslinė suma (€)</label>
<input type="number" step="0.01" name="goal_amount" required>
</div>


<div class="form-group">
<label>Pagrindinė nuotrauka</label>
<input type="file" name="main_image">
</div>


<div class="form-group">
<label>Galerijos nuotraukos</label>
<input type="file" name="gallery_images[]" multiple>
</div>


<div class="form-group">

<label>Įrašykite norimus tag'us</label>

<input
type="text"
id="tags-input"
placeholder="Pvz.: kelione pagalba auka"
autocomplete="off"
>

<div id="tags-suggestions" class="tags-suggestions"></div>

<input type="hidden" name="tags_text" id="tags-hidden">

</div>


<button type="submit" class="create-btn">
Sukurti
</button>

</form>

</div>
@endsection