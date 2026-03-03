@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width: 600px;">

<h2>Redaguoti istoriją</h2>

<form method="POST" action="{{ route('story.update', $story) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div style="margin-bottom:10px;">
        <label>Pavadinimas</label>
        <input type="text" name="title" value="{{ $story->title }}" class="form-control" required>
    </div>

    <div style="margin-bottom:10px;">
        <label>Aprašymas</label>
        <textarea name="content" class="form-control" required>{{ $story->content }}</textarea>
    </div>

    <div style="margin-bottom:10px;">
        <label>Tikslinė suma (€)</label>
        <input type="number" step="0.01" name="goal_amount"
               value="{{ $story->goal_amount }}" class="form-control" required>
    </div>

    <div style="margin-bottom:10px;">
        <label>Pagrindinė nuotrauka</label>
        <input type="file" name="main_image" class="form-control">
    </div>
     <div style="margin-bottom:10px;">
    <label>Galerijos nuotraukos</label>
    <input type="file" name="gallery_images[]" multiple class="form-control">
</div>

    <button type="submit">Atnaujinti</button>
</form>

</div>
@endsection