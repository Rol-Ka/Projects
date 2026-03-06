@extends('layouts.admin')

@section('content')

<h1>Hashtag'ai</h1>

@foreach($tags as $tag)
<div>{{ $tag->name }}</div>
@endforeach

@endsection