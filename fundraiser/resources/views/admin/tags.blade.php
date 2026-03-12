@extends('layouts.admin')

@section('content')

<div class="admin-container">

<h2>Hashtag'ai</h2>

<div class="tags-actions">

    <form method="POST" action="{{ route('admin.tags.store') }}" class="tag-create">
        @csrf

        <input
        type="text"
        name="name"
        placeholder="Naujas hashtag..."
        required
        >

        <button type="submit">Pridėti</button>
    </form>


    <form method="GET" class="tag-search">

        <input
        type="text"
        name="search"
        placeholder="Ieškoti hashtag..."
        value="{{ request('search') }}"
        >

        <button type="submit">Ieškoti</button>

    </form>

</div>


<div class="tags-list">

@foreach($tags as $tag)

<div class="tag-row">

<div class="tag-info">

<span class="tag-name">
#{{ $tag->name }}
</span>

<span class="tag-count">
({{ $tag->stories_count }} istorijos)
</span>

</div>

<form method="POST" action="{{ route('admin.tags.update',$tag) }}">

@csrf
@method('PUT')

<input
type="text"
name="name"
value="{{ $tag->name }}"
>

<button type="submit">Išsaugoti</button>

</form>


<form method="POST" action="{{ route('admin.tags.destroy',$tag) }}">

@csrf
@method('DELETE')

<button class="delete">Ištrinti</button>

</form>

</div>

@endforeach

</div>

</div>

@endsection