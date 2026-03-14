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

        <button type="submit" class="btn-approve">Pridėti</button>
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

<div class="tag-main">

<div class="tag-title">
#{{ $tag->name }}
</div>

<div class="tag-count">
{{ $tag->stories_count }} istorijos
</div>

</div>


<div class="tag-edit" id="edit-{{ $tag->id }}">

<form method="POST" action="{{ route('admin.tags.update',$tag) }}">
@csrf
@method('PUT')

<input type="text" name="name" value="{{ $tag->name }}">

<div class="tag-edit-buttons">

<button class="btn-approve">Išsaugoti</button>

<button type="button"
class="btn-cancel"
onclick="cancelEdit({{ $tag->id }})">
Atšaukti
</button>

</div>

</form>

</div>


<div class="tag-actions">

<button onclick="editTag({{ $tag->id }})" class="btn-edit">
✏️
</button>

<form method="POST" action="{{ route('admin.tags.destroy',$tag) }}">
@csrf
@method('DELETE')

<button class="btn-delete">
🗑
</button>

</form>

</div>

</div>

@endforeach

</div>
<div class="admin-pagination">

{{ $tags->links('vendor.pagination.pagination') }}

</div>
</div>

@endsection