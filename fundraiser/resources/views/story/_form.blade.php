@php
$isEdit = isset($story);
@endphp

{{-- TITLE --}}
<div class="form-group">
<label>Pavadinimas</label>
<input 
    type="text" 
    name="title"
    value="{{ old('title', $isEdit ? $story->title : '') }}"
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
>{{ old('content', $isEdit ? $story->content : '') }}</textarea>

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
    value="{{ old('goal_amount', $isEdit ? $story->goal_amount : '') }}"
    class="{{ $errors->has('goal_amount') ? 'error' : '' }}"
>

@error('goal_amount')
<div class="input-error">{{ $message }}</div>
@enderror
</div>


{{-- TAGS --}}
<div class="form-group">
<label>Įrašykite norimus tag'us</label>

@php
$tagsValue = '';

if(old('tags_text')) {
    $tagsValue = old('tags_text');
} elseif(isset($story)) {
    $tagsValue = $story->tags->pluck('name')
        ->map(fn($t) => '#'.$t)
        ->implode(' ');
}
@endphp

<input
    type="text"
    id="tags-input"
    placeholder="Pvz.: kelione pagalba auka"
    autocomplete="off"
    value="{{ $tagsValue }}"
>

<div id="tags-suggestions" class="tags-suggestions"></div>

<input 
    type="hidden" 
    name="tags_text" 
    id="tags-hidden"
    value="{{ $tagsValue }}"
>

</div>


{{-- =========================
   MAIN IMAGE
========================= --}}
<div class="form-group">
<label>Pagrindinė nuotrauka</label>

<div class="file-input">
    <label class="file-label">
        Pasirinkti nuotrauką
        <input id="main-image-input" type="file" name="main_image" hidden>
    </label>

    <span class="file-name">
        {{ $isEdit && $story->main_image ? 'Nuotrauka pasirinkta' : 'Nuotrauka nepasirinkta' }}
    </span>
</div>

{{-- EXISTING MAIN --}}
@if($isEdit && $story->main_image)
<input type="hidden" id="existing-main-image" value="{{ $story->main_image }}">
<div class="image-preview" data-main-existing> {{-- 🔥 pridėtas data attribute --}}
    <div class="preview-item">

        <img src="{{ asset('storage/'.$story->main_image) }}">

        <div class="preview-remove main-remove">
            ×
        </div>

    </div>
</div>

<input type="hidden" name="delete_main_image" id="delete-main-image">
@endif

{{-- NEW MAIN --}}
<div id="main-image-preview" class="image-preview"></div>

@error('main_image')
<div class="input-error">{{ $message }}</div>
@enderror
</div>


{{-- =========================
   GALLERY
========================= --}}
<div class="form-group">
<label>Galerijos nuotraukos</label>

<div class="file-input">
    <label class="file-label">
        Pasirinkti nuotraukas
        <input 
            id="gallery-input"
            type="file" 
            name="gallery_images[]" 
            multiple
            hidden
        >
    </label>

    <span class="file-name">
        {{ $isEdit && $story->images->count() ? 'Nuotraukos pasirinktos' : 'Nuotraukos nepasirinktos' }}
    </span>
</div>

{{-- EXISTING GALLERY --}}
@if($isEdit && $story->images->count())
<div class="image-preview" data-gallery-existing>
    @foreach($story->images as $img)
        <div class="preview-item" data-id="{{ $img->id }}"> {{-- 🔥 pridėtas id --}}

            <img src="{{ asset('storage/'.$img->image_path) }}">

            <div class="preview-remove existing-remove">
                ×
            </div>

            {{-- 🔥 checkbox atskirai (ne viduje X) --}}
            <input 
                type="checkbox" 
                name="delete_images[]" 
                value="{{ $img->id }}" 
                hidden
            >

        </div>
    @endforeach
</div>
@endif

{{-- NEW GALLERY --}}
<div id="image-preview" class="image-preview"></div>

</div>