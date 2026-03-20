{{-- @extends('layouts.app')

@section('page','create-story')

@section('content')

<div class="container-sm">

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
<input 
    type="text" 
    name="title"
    value="{{ old('title') }}"
    class="{{ $errors->has('title') ? 'error' : '' }}"
>

@error('title')
    <div class="input-error">{{ $message }}</div>
@enderror
</div>


<div class="form-group">
<label>Aprašymas</label>
<textarea 
    name="content"
    class="{{ $errors->has('content') ? 'error' : '' }}"
>{{ old('content') }}</textarea>

@error('content')
    <div class="input-error">{{ $message }}</div>
@enderror
</div>


<div class="form-group">
<label>Tikslinė suma (€)</label>
<input 
    type="number" 
    step="0.01" 
    name="goal_amount"
    value="{{ old('goal_amount') }}"
    class="{{ $errors->has('goal_amount') ? 'error' : '' }}"
>

@error('goal_amount')
    <div class="input-error">{{ $message }}</div>
@enderror
</div>


<div class="form-group">
<label>Pagrindinė nuotrauka</label>
<input 
    type="file" 
    name="main_image"
    class="{{ $errors->has('main_image') ? 'error' : '' }}"
>

@error('main_image')
    <div class="input-error">{{ $message }}</div>
@enderror
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
@endsection --}}



@extends('layouts.app')

@section('page','create-story')

@section('content')

<div class="container-sm">

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

{{-- TITLE --}}
<div class="form-group">
<label>Pavadinimas</label>
<input 
    type="text" 
    name="title"
    value="{{ old('title') }}"
    class="{{ $errors->has('title') ? 'error' : '' }}"
>

@error('title')
    <div class="input-error">{{ $message }}</div>
@enderror
</div>


{{-- CONTENT --}}
<div class="form-group">
<label>Aprašymas</label>
<textarea 
    name="content"
    class="{{ $errors->has('content') ? 'error' : '' }}"
>{{ old('content') }}</textarea>

@error('content')
    <div class="input-error">{{ $message }}</div>
@enderror
</div>


{{-- GOAL --}}
<div class="form-group">
<label>Tikslinė suma (€)</label>
<input 
    type="number" 
    step="0.01" 
    name="goal_amount"
    value="{{ old('goal_amount') }}"
    class="{{ $errors->has('goal_amount') ? 'error' : '' }}"
>

@error('goal_amount')
    <div class="input-error">{{ $message }}</div>
@enderror
</div>


{{-- MAIN IMAGE --}}
<div class="form-group">
<label>Pagrindinė nuotrauka</label>

<div class="file-input">
    <label class="file-label">
        Pasirinkti nuotrauką
        <input 
            type="file" 
            name="main_image"
            hidden
            id="main-image-input"
        >
    </label>

    <span class="file-name">Nuotrauka nepasirinkta</span>
</div>
{{-- PREVIEW --}}
<div id="main-image-preview" class="image-preview"></div>

@error('main_image')
    <div class="input-error">{{ $message }}</div>
@enderror
</div>


{{-- GALLERY --}}
<div class="form-group">
<label>Galerijos nuotraukos</label>

<div class="file-input">
    <label class="file-label">
        Pasirinkti nuotraukas
        <input 
        id="gallery-input"`
            type="file" 
            name="gallery_images[]" 
            multiple
            hidden
        >
    </label>

    <span class="file-name">Nuotraukos nepasirinktos</span>
</div>
{{-- 🔥 PREVIEW --}}
<div id="image-preview" class="image-preview"></div>
</div>


{{-- TAGS --}}
<div class="form-group">
<label>Įrašykite norimus tag'us</label>

<input
type="text"
id="tags-input"
placeholder="Pvz.: kelione pagalba auka"
autocomplete="off"
value="{{ old('tags_text') }}"
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