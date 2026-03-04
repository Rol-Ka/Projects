@extends('layouts.app')

@section('content')

<h1>{{ $story->title }}</h1>

<p>
Autorius: {{ $story->user->name }}
</p>

@if($story->main_image)
    <img src="{{ asset('storage/'.$story->main_image) }}" width="400">
@endif

<p>
{{ $story->content }}
</p>

<h3>Galerija</h3>

@foreach($story->images as $img)

    <img src="{{ asset('storage/'.$img->image_path) }}" width="150">

@endforeach

<h3>Surinkta</h3>

<p>
€{{ $story->current_amount }} / €{{ $story->goal_amount }}
</p>

<h3>Donations</h3>

@foreach($story->donations as $donation)

<p>
{{ $donation->user->name }} - €{{ $donation->amount }}
</p>

@endforeach

@endsection