@extends('layouts.app')

@section('content')
<div class="container">

<h2>Admin - Istorijos</h2>

@foreach($stories as $story)
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">

        <strong>{{ $story->title }}</strong><br>
        Autorius: {{ $story->user->name ?? 'Nėra' }} <br>

        Statusas:
        @if($story->is_approved)
            <span style="color:green;">Patvirtinta</span>
        @else
            <span style="color:red;">Nepatvirtinta</span>
        @endif

        <div style="margin-top:10px;">

            @if(!$story->is_approved)
                <form method="POST" action="{{ route('admin.stories.approve', $story) }}">
                    @csrf
                    <button type="submit">Patvirtinti</button>
                </form>
            @endif

            <form method="POST" action="{{ route('admin.stories.destroy', $story) }}">
                @csrf
                @method('DELETE')
                <button type="submit" style="color:red;">Ištrinti</button>
            </form>

        </div>

    </div>
@endforeach

</div>
@endsection